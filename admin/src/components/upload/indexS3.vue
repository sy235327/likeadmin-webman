<template>
    <div class='upload'>
        <el-upload
            v-model:file-list='fileList'
            ref='uploadRefs'
            method='PUT'
            :action='action'
            :multiple='multiple'
            :limit='limit'
            :show-file-list='false'
            :headers='headers'
            :data='data'
            :on-progress='handleProgress'
            :on-success='handleSuccess'
            :on-exceed='handleExceed'
            :on-error='handleError'
            :accept='getAccept'
            :http-request='ajaxUpload'
        >
            <slot />
        </el-upload>
        <el-dialog
            v-if='showProgress && fileList.length'
            v-model='visible'
            title='上传进度'
            :close-on-click-modal='false'
            width='500px'
            :modal='false'
            @close='handleClose'
        >
            <div class='file-list p-4'>
                <template v-for='(item, index) in fileList' :key='index'>
                    <div class='mb-5'>
                        <div>{{ item.name }}</div>
                        <div class='flex-1'>
                            <el-progress :percentage='parseInt(item.percentage)' />
                        </div>
                    </div>
                </template>
            </div>
        </el-dialog>
    </div>
</template>

<script lang='ts'>
import type { ElUpload, UploadProgressEvent, UploadRequestOptions } from 'element-plus'
import { computed, defineComponent, ref, shallowRef } from 'vue'

import config from '@/config'
import { RequestCodeEnum } from '@/enums/requestEnums'
import useUserStore from '@/stores/modules/user'
import feedback from '@/utils/feedback'
import { isArray, isNil } from 'lodash'
import { UploadAjaxError } from 'element-plus/es/components/upload/src/ajax'
import { getUploadToken, setUploadFile } from '@/api/file'

export default defineComponent({
    components: {},
    props: {
        // 上传文件类型
        type: {
            type: String,
            default: 'image'
        },
        // 是否支持多选
        multiple: {
            type: Boolean,
            default: true
        },
        // 多选时最多选择几条
        limit: {
            type: Number,
            default: 10
        },
        // 上传时的额外参数
        data: {
            type: Object,
            default: () => ({})
        },
        // 是否显示上传进度
        showProgress: {
            type: Boolean,
            default: false
        }
    },
    emits: ['change', 'error', 'success', 'allSuccess'],
    setup(props, { emit }) {
        const userStore = useUserStore()
        const uploadRefs = shallowRef<InstanceType<typeof ElUpload>>()
        const action = ref(`${config.baseUrl}${config.urlPrefix}/upload/${props.type}`)
        const headers = computed(() => ({
            token: userStore.token,
            version: config.version
        }))
        const visible = ref(false)
        const fileList = ref<any[]>([])

        const handleProgress = () => {
            visible.value = true
        }
        let uploadLen = 0
        const handleSuccess = (response: any, file: any) => {
            if (response.code == RequestCodeEnum.SUCCESS) {
                if (response.data.id == -1) {
                    //需要通知后台插入file表
                    setUploadFile({
                        ...response.data.other,
                        name: response.data.name,
                        uri: response.data.uri,
                        size: response.data.size,
                        type: props.type
                    })
                        .then((res: any) => {
                            response.data.id = res.id
                            emit('success', response)
                        })
                        .catch((err: any) => {
                            feedback.msgError(err.msg)
                        })
                        .finally(() => {
                            uploadLen++
                            if (uploadLen == fileList.value.length) {
                                uploadLen = 0
                                fileList.value = []
                                emit('allSuccess')
                            }
                            emit('change', file)
                        })
                    return
                }
            }
            if (response.code == RequestCodeEnum.FAIL && response.msg) {
                feedback.msgError(response.msg)
            }
            uploadLen++
            if (uploadLen == fileList.value.length) {
                uploadLen = 0
                fileList.value = []
                emit('allSuccess')
            }
            emit('change', file)
        }
        const handleError = (event: any, file: any) => {
            uploadLen++
            if (uploadLen == fileList.value.length) {
                uploadLen = 0
                fileList.value = []
                emit('allSuccess')
            }
            feedback.msgError(`${file.name}文件上传失败`)
            uploadRefs.value?.abort(file)
            visible.value = false
            emit('change', file)
            emit('error', file)
        }
        const handleExceed = () => {
            feedback.msgError(`超出上传上限${props.limit}，请重新上传`)
        }
        const handleClose = () => {
            fileList.value = []
            visible.value = false
        }

        const getAccept = computed(() => {
            switch (props.type) {
                case 'image':
                    return '.jpg,.png,.gif,.jpeg,.ico'
                case 'video':
                    return '.wmv,.avi,.mpg,.mpeg,.3gp,.mov,.mp4,.flv,.rmvb,.mkv'
                default:
                    return '*'
            }
        })
        const getError = (action: string, option: UploadRequestOptions, xhr: XMLHttpRequest) => {
            let msg: string
            if (xhr.response) {
                msg = `${xhr.response.error || xhr.response}`
            } else if (xhr.responseText) {
                msg = `${xhr.responseText}`
            } else {
                msg = `fail to ${option.method} ${action} ${xhr.status}`
            }

            return new UploadAjaxError(msg, xhr.status, option.method, action)
        }
        const getBody = (xhr: XMLHttpRequest): XMLHttpRequestResponseType => {
            const text = xhr.responseText || xhr.response
            if (!text) {
                return text
            }

            try {
                return JSON.parse(text)
            } catch {
                return text
            }
        }
        //获取上传地址
        const getActionUrl = async (option: any) => {
            const res = await getUploadToken({
                name: option.file.name,
                size: option.file.size,
                contentType: option.file.type
            })
            if (res && res.is_oss_req == 1) {
                return {
                    is_oss_req: 1,
                    method: res.method,
                    name: res.name,
                    action: res.req_url,
                    headers: res.headers,
                    req_file_url: res.req_file_url,
                    upload_file_name: res.upload_file_name,
                    upload_file_size: res.upload_file_size,
                    save_file_url: res.save_file_url
                }
            }
            return {
                is_oss_req: 0,
                method: option.method,
                action: option.action,
                headers: option.headers
            }
        }
        const ajaxUpload = (option: any): XMLHttpRequest | Promise<unknown> => {
            const xhr = new XMLHttpRequest()
            getActionUrl(option)
                .then((actionRes: any) => {
                    if (!actionRes) {
                        return Promise.reject(new Error('获取上传地址失败'))
                    }
                    option.is_oss_req = actionRes.is_oss_req
                    option.action = actionRes.action
                    option.method = actionRes.method
                    option.headers = actionRes.headers
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', (evt: any) => {
                            const progressEvt = evt as UploadProgressEvent
                            progressEvt.percent = evt.total > 0 ? (evt.loaded / evt.total) * 100 : 0
                            option.onProgress(progressEvt)
                        })
                    }

                    const formData = new FormData()
                    if (option.data) {
                        for (const [key, value] of Object.entries(option.data)) {
                            if (isArray(value) && value.length) {
                                for (const item of value) {
                                    formData.append(key, item as string | Blob) // 类型断言
                                }
                            } else {
                                formData.append(key, value as string | Blob) // 类型断言
                            }
                        }
                    }
                    formData.append(option.filename, option.file, option.file.name)

                    xhr.addEventListener('error', () => {
                        option.onError(getError(option.action, option, xhr))
                    })

                    xhr.addEventListener('load', () => {
                        if (xhr.status < 200 || xhr.status >= 300) {
                            return option.onError(getError(option.action, option, xhr))
                        }
                        let response: any = getBody(xhr)
                        if (option.is_oss_req == 1) {
                            response = {
                                code: RequestCodeEnum.SUCCESS,
                                show: 0,
                                msg: '上传成功',
                                data: {
                                    id: -1,
                                    uri: actionRes.req_file_url,
                                    url: actionRes.save_file_url,
                                    name: actionRes.name,
                                    size: actionRes.upload_file_size,
                                    other: option.data
                                }
                            }
                        }
                        option.onSuccess(response)
                    })

                    xhr.open(option.method, option.action, true)

                    if (option.withCredentials && 'withCredentials' in xhr) {
                        xhr.withCredentials = true
                    }

                    const headers = option.headers || {}
                    if (headers instanceof Headers) {
                        headers.forEach((value, key) => {
                            xhr.setRequestHeader(key, value)
                        })
                    } else {
                        for (const [key, value] of Object.entries(headers)) {
                            if (isNil(value)) continue
                            xhr.setRequestHeader(key, String(value))
                        }
                    }
                    if (option.is_oss_req == 1) {
                        xhr.setRequestHeader('Content-Type', option.file.type)
                        xhr.send(option.file)
                    } else {
                        xhr.send(formData)
                    }
                }).catch((err: any) => {
                    return option.onError(
                        new UploadAjaxError(err, -1, option.method, option.action)
                    )
                })
            return xhr
        }
        return {
            uploadRefs,
            action,
            headers,
            visible,
            fileList,
            getAccept,
            handleProgress,
            handleSuccess,
            handleError,
            handleExceed,
            handleClose,
            ajaxUpload

        }
    }
})
</script>

<style lang='scss'></style>
