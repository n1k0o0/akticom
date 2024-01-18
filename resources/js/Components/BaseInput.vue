<template>
  <div class="form-group">
    <label v-if="label">{{ label }}</label>
    <el-input
      v-bind="$attrs"
      v-model="message"
      :class="{'is-invalid': error}"
      :disabled="disabled"
      :type="type"
      :aria-invalid="error?true:null"
      :placeholder="placeholder??label"
      :min="min"
      :max="max"
    />
    <div
      v-if="error"
      class="invalid-feedback"
    >
      {{ error }}
    </div>
    <span
      v-if="hint"
      class="form-text text-muted"
    >{{ hint }}</span>
    <span
      v-if="isCopy"
      class="copy_text"
      @click="copy(message)"
    />
  </div>
</template>

<script>
import { useModelWrapper } from '@/services/modelWrapper'
import { ElMessage } from 'element-plus'

export default {
  name: 'BaseInput',
  inheritAttrs: false,
  props: {
    min: {
      type: Number,
      default: 0
    },
    max: {
      type: Number,
      default: 999999
    },
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    disabled: {
      type: Boolean,
      default: false
    },
    isCopy: {
      type: Boolean,
      default: false
    },
    hint: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    // eslint-disable-next-line vue/require-default-prop
    modelValue: {
      type: [Number, String],
    }
  },
  emits: ['update:modelValue'],
  setup (props, { emit }) {
    const copy = (text) => {
      copyTextToClipboard(text)
    }

    const copyTextToClipboard = async (text) => {
      if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text)
        return
      }
      navigator.clipboard.writeText(text).then(function () {
        console.log('Async: Copying to clipboard was successful!')
        ElMessage('Текст скопирован')
      }, function (err) {
        console.error('Async: Could not copy text: ', err)
      })
    }
    const fallbackCopyTextToClipboard = (text) => {
      let textArea = document.createElement('textarea')
      textArea.value = text

      // Avoid scrolling to bottom
      textArea.style.top = '0'
      textArea.style.left = '0'
      textArea.style.position = 'fixed'

      document.body.appendChild(textArea)
      textArea.focus()
      textArea.select()

      try {
        let successful = document.execCommand('copy')
        ElMessage('Текст скопирован')
        // let msg = successful ? 'successful' : 'unsuccessful'
        // console.log('Fallback: Copying text command was ' + msg)
      } catch (err) {
        console.error('Fallback: Oops, unable to copy', err)
      }

      document.body.removeChild(textArea)
    }

    return {
      message: useModelWrapper(props, emit, 'modelValue'),
      copy
    }
  },
}
</script>

<style lang="scss">
.copy_text {
  position: absolute;
  right: 25px;
  top: 53%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  cursor: pointer;
  opacity: 0.6;
  transition: .2s ease;
  -webkit-transition: .2s ease;
  -moz-transition: .2s ease;
  -ms-transition: .2s ease;
  width: 16px;
  height: 18px;
  background: url(https://dynamex.az/css/images/copy.svg) no-repeat center;
  padding: 13px;
  border-radius: 2px;
}

.form-group{
  input{

  }
}
</style>
