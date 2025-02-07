<template>
    <div class="upload">
        <el-upload
            v-model:file-list="fileList"
            ref="uploadRefs"
            :action="action"
            :multiple="multiple"
            :limit="limit"
            :show-file-list="false"
            :headers="headers"
            :data="data"
            :on-progress="handleProgress"
            :on-success="handleSuccess"
            :on-exceed="handleExceed"
            :on-error="handleError"
            :accept="getAccept"
            :http-request='ajaxUpload'
        >
            <slot />
        </el-upload>
        <el-dialog
            v-if="showProgress && fileList.length"
            v-model="visible"
            title="上传进度"
            :close-on-click-modal="false"
            width="500px"
            :modal="false"
            @close="handleClose"
        >
            <div class="file-list p-4">
                <template v-for="(item, index) in fileList" :key="index">
                    <div class="mb-5">
                        <div>{{ item.name }}</div>
                        <div class="flex-1">
                            <el-progress :percentage="parseInt(item.percentage)" />
                        </div>
                    </div>
                </template>
            </div>
        </el-dialog>
    </div>
</template>

<script lang="ts">
import type { ElUpload, UploadProgressEvent, UploadRequestOptions } from 'element-plus'
import { computed, defineComponent, ref, shallowRef } from 'vue'

import config from '@/config'
import { RequestCodeEnum } from '@/enums/requestEnums'
import useUserStore from '@/stores/modules/user'
import feedback from '@/utils/feedback'
import { isArray, isNil } from 'lodash'
import { UploadAjaxError } from 'element-plus/es/components/upload/src/ajax'

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
            uploadLen++
            if (uploadLen == fileList.value.length) {
                uploadLen = 0
                fileList.value = []
                emit('allSuccess')
            }
            emit('change', file)
            if (response.code == RequestCodeEnum.SUCCESS) {
                emit('success', response)
            }
            if (response.code == RequestCodeEnum.FAIL && response.msg) {
                feedback.msgError(response.msg)
            }
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
        const getActionUrl = (oldAction: string, option: any): string => {
            return oldAction
        }
        const ajaxUpload = (option: any): XMLHttpRequest | Promise<unknown> => {
            const xhr = new XMLHttpRequest()
            const actionUrl: string = getActionUrl(option.action, option)

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', (evt) => {
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
                option.onError(getError(actionUrl, option, xhr))
            })

            xhr.addEventListener('load', () => {
                if (xhr.status < 200 || xhr.status >= 300) {
                    return option.onError(getError(actionUrl, option, xhr))
                }
                option.onSuccess(getBody(xhr))
            })

            xhr.open(option.method, actionUrl, true)

            if (option.withCredentials && 'withCredentials' in xhr) {
                xhr.withCredentials = true
            }

            const headers = option.headers || {}
            if (headers instanceof Headers) {
                headers.forEach((value, key) => xhr.setRequestHeader(key, value))
            } else {
                for (const [key, value] of Object.entries(headers)) {
                    if (isNil(value)) continue
                    xhr.setRequestHeader(key, String(value))
                }
            }

            xhr.send(formData)
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
            ajaxUpload,

        }
    }
})
</script>

<style lang="scss"></style>
