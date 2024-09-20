<template>
    <el-upload
        ref="uploadRef"
        class="upload-demo"
        action="https://run.mocky.io/v3/9d059bf9-4660-45f2-925d-ce80ad6c4d15"
        :auto-upload="false"
        :limit="1"
        :on-change="beforeUpload"
        :show-file-list="false"
        accept=".xlsx,.xls"
    >
        <slot></slot>
    </el-upload>
</template>

<script lang="ts" setup>
import { read, utils } from "xlsx"
const emit = defineEmits(["success", "error"])

const beforeUpload = async (file: any) => {
    console.log(file)
    const reader = new FileReader()
    reader.readAsBinaryString(file.raw)
    reader.onload = (e: any) => {
        const data = e.target.result
        const zzexcel = read(data, {
            type: "binary"
        })
        console.log("zzexcel", zzexcel)
        const result = []
        for (let i = 0; i < zzexcel.SheetNames.length; i++) {
            const newData = utils.sheet_to_json(zzexcel.Sheets[zzexcel.SheetNames[i]], {
                defval: props.defval,
                blankrows: props.blankrows,
                skipHidden: props.skipHidden,
                raw: props.raw,
                rawNumbers: props.rawNumbers,
                header: props.header
            })
            result.push(...newData)
        }
        emit("success", result)
    }
}
const props = withDefaults(
    defineProps<{
        header?: "A" | number | string[]
        rawNumbers?: boolean
        raw?: boolean
        skipHidden?: boolean
        blankrows?: boolean
        defval?: string | number | null
    }>(),
    {
        defval: ""
    }
)
</script>
