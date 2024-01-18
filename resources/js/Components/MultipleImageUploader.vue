<template>
  <el-upload
    action="#"
    :disabled="disabled"
    class="multiple-image-uploader"
    list-type="picture-card"
    :auto-upload="false"
    multiple
    :class="{'hide-upload': max?(images.length>=max ||disabled):disabled}"
    :on-remove="onRemove"
    :on-change="onChange"
    :limit="max"
    accept=".png,.jpg,.jpeg"
    :on-preview="handlePictureCardPreview"
    :file-list="images"
  >
    <template #default>
      <el-icon>
        <plus />
      </el-icon>
    </template>
    <template #tip>
      <div class="el-upload__tip">
        {{ tip }}
      </div>
    </template>
  </el-upload>
  <el-dialog v-model="dialogVisible">
    <img
      style="width:100%;"
      :src="dialogImageUrl"
      alt=""
    >
  </el-dialog>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { Plus } from '@element-plus/icons-vue'


const props = defineProps({
  modelValue: { required: false, default: null },
  onChange: { type: Function, default: null },
  onRemove: { type: Function, default: null },
  images: { type: Array, default: () => [] },
  tip: { type: String, default: '' },
  max: { type: Number, default: null },
  disabled: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue'])

const uploader = ref()
let fileList = ref([])

const dialogImageUrl = ref('')
const dialogVisible = ref(false)

const handleRemove = (uploadFile, uploadFiles) => {
}

const handlePictureCardPreview = (uploadFile) => {
  dialogImageUrl.value = uploadFile.url
  dialogVisible.value = true
}

watch(() => props.images, (first) => {
  fileList.value = first
})

onMounted(() => {
  fileList.value = props.images
})

const onChange = (uploadFile, uploadFiles) => {
  if (props.onChange) {
    props.onChange(uploadFile, uploadFiles)
  } else {
    emit('update:modelValue', uploadFiles)
  }
}

const onRemove = (uploadFile, uploadFiles) => {
  if (props.onRemove) {
    props.onRemove(uploadFile, uploadFiles)
  } else {
    emit('update:modelValue', uploadFiles)
  }
}

</script>

<style>
.multiple-image-uploader.hide-upload div.el-upload.el-upload--picture-card {
  display: none;
}

.el-icon-plus.avatar-uploader-icon {
  color: #8c939d !important;
}
</style>
