<template>
    <div>
        <el-card header="基础使用" shadow="never" class="!border-none">
            <div class="flex flex-wrap">
                <div class="m-4">
                    <UploadS3
                        @change="onChange"
                        @success="onSuccess"
                        @error="onError"
                        :show-progress="true"
                    >
                        <el-button type="primary">S3上传</el-button>
                    </UploadS3>
                </div>
                <div class="m-4">
                    <upload
                        @change="onChange"
                        @success="onSuccess"
                        @error="onError"
                        :show-progress="true"
                    >
                        <el-button type="primary">上传图片</el-button>
                    </upload>
                </div>
                <div class="m-4">
                    <upload
                        type="video"
                        @change="onChange"
                        @success="onSuccess"
                        @error="onError"
                        :show-progress="true"
                    >
                        <el-button type="primary">上传视频</el-button>
                    </upload>
                </div>
                <div class="m-4">
                    <upload
                        :multiple="false"
                        @change="onChange"
                        @success="onSuccess"
                        @error="onError"
                        :show-progress="true"
                    >
                        <el-button type="primary">取消多选</el-button>
                    </upload>
                </div>
                <div class="m-4">
                    <upload
                        :limit="2"
                        @change="onChange"
                        @success="onSuccess"
                        @error="onError"
                        :show-progress="true"
                    >
                        <el-button type="primary">一次最多上传2张</el-button>
                    </upload>
                </div>
                <div class="m-4">
                    <analysisXlsx @success="onSuccess" @error="onError" :show-progress="false">
                        <el-button type="primary">前端并解析xlsx生成json</el-button>
                    </analysisXlsx>
                </div>
                <div class="m-4">
                    <el-button type="primary" @click="createXlsx"> 前端根据json生成xlsx </el-button>
                </div>
            </div>
        </el-card>
    </div>
</template>
<script lang="ts" setup>
import analysisXlsx from '@/components/analysis-xlsx/index.vue'
import Upload from '@/components/upload/index.vue'
import UploadS3 from '@/components/upload/indexS3.vue'
import { toSheet } from '@/utils/util'
const onChange = (file: any) => {
    console.log('上传文件的状态发生改变', file)
}

const onSuccess = (file: any) => {
    console.log('上传文件成功', file)
}

const onError = (file: any) => {
    console.log('上传文件失败', file)
}
const createXlsx = () => {
    toSheet(
        [
            { title1: 5, title2: 6, title3: 7 },
            { title1: 4, title2: 6, title3: 2 },
            { title1: 3, title2: 6, title3: 2 }
        ],
        { header: ['title1', 'title2', 'title3'] },
        '测试'
    )
}
</script>
