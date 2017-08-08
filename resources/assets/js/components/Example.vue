<template>
    <div class="container" style="margin-top: 50px;">
        <el-upload
                action="/api/upload"
                list-type="picture-card"
                :on-preview="handlePictureCardPreview"
                :on-remove="handleRemove"
                :on-error="errorBack">
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="头像">
        </el-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dialogImageUrl: '',
                dialogVisible: false
            }
        },
        methods: {
            handleRemove(file, fileList) {
                axios.delete('/api/file/del', {params: {fileUrl: file.response.path}}).then(rs => {
                    this.$message.success('图片删除成功');
                }).catch(err => {
                    this.$message.warning('图片删除失败');
                })
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            errorBack(err, t) {
                this.$message.error('上传发生错误');
            }
        }
    }
</script>
<style>
    .el-upload__input {
        display: none !important;
    }
</style>