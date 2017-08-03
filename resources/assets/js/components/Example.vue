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
                axios.delete('/api/file/del', {params: {fileUrl: file.response}}).then(rs => {
                    console.log(rs);
                }).catch(err => {
                    console.log(err);
                })
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            errorBack(err, t) {
                this.$message({
                    type: 'warning',
                    message: '图片未上传成功'
                });
            }
        }
    }
</script>