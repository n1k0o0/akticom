<script setup>
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import pagination from '@/Components/Pagination.vue'
import { Delete } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'

const props = defineProps({
  stickers: Array | Object,
  per_page: Number | null,
})

const page = usePage()

let refUpload = ref()

let searchData = ref({
  per_page: props.per_page,
})

const perPage = [10, 25, 50, 100]

let loading = ref(false)
let fileList = ref([])

const uploadFile = async (uploadFile) => {
  if (!uploadFile?.raw) {
    return
  }

  router.post(route('stickers.upload'), { file: uploadFile.raw }, {
    forceFormData: true,
  })

  refUpload.value.clearFiles()

}

const deleteData = async (faq) => {
  router.delete(route('stickers.destroy', faq))
}

const sortTable = function ({ prop, order }) {
  router.get(route('stickers.index', { sort: prop, order: order, page: 1 }))
}

const search = function () {
  router.get(route('stickers.index', searchData.value))
}

const handleExceed = (files, uploadFiles) => {
  ElMessage.warning(
      `The limit is 3, you selected ${files.length} files this time, add up to ${
          files.length + uploadFiles.length
      } totally`
  )
}

</script>


<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Stickers
      </h2>
    </template>

    <div class="py-12">
      <div class="container mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
          <el-alert :title="error" type="error" v-for="error in page.props.errors"/>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">


          <div class="float-right mb-8">
            <el-upload
                ref="refUpload"
                v-model:file-list="fileList"
                class="upload-demo"
                :auto-upload="false"
                @change="uploadFile"
                multiple
                accept=".csv"
                :limit="1"
                :on-exceed="handleExceed"
            >
              <el-button type="primary">Click to upload</el-button>
              <template #tip>
                <div class="el-upload__tip">
                  scv files with a size less than 500KB.
                </div>
              </template>
            </el-upload>
          </div>

          <div class="col-12">
            <div class="row">
              <label>PerPage</label>
              <el-select
                  v-model="searchData.per_page"
                  placeholder="Select"
                  @change="search"
              >
                <el-option
                    v-for="item in perPage"
                    :key="item"
                    :label="item"
                    :value="item"
                />
              </el-select>
            </div>
            <el-table
                @sort-change="sortTable"
                v-loading="loading"
                :data="stickers.data"
                :empty-text="'Нет данных'"
            >
              <el-table-column
                  prop="id"
                  label="ID"
                  width="65"
                  sortable="custom"
              />
              <el-table-column
                  prop="name"
                  min-width="155"
                  label="Name"
                  sortable="custom"
              />
              <el-table-column
                  prop="code"
                  min-width="160"
                  label="Code"
                  sortable="custom"
              />
              <el-table-column
                  label="Actions"
                  width="110"
                  class-name="Əməliyyatlar"
              >
                <template #default="scope">
                  <el-popconfirm
                      width="290"
                      cancel-button-text="Отмена"
                      confirm-button-text="Да"
                      title="Вы действительно хотите удалить ?"
                      @confirm="deleteData(scope.row)"
                  >
                    <template #reference>
                      <el-icon
                          class="cursor-pointer"
                          color="red"
                          size="20"
                      >
                        <Delete/>
                      </el-icon>
                    </template>
                  </el-popconfirm>
                </template>
              </el-table-column>
            </el-table>
            <el-row justify="center">
              <pagination class="mt-6" :links="stickers.links"/>
            </el-row>
          </div>

        </div>
      </div>
    </div>
  </AppLayout>
</template>
