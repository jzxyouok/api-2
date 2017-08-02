<template>
    <div class="container" style="margin-top: 50px;">
        <el-upload
                action="/upload"
                list-type="picture-card"
                :headers="headers"
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
                headers: {'X-CSRF-TOKEN': axios.defaults.headers.common['X-CSRF-TOKEN']},
                dialogImageUrl: '',
                dialogVisible: false
            }
        },
        methods: {
            handleRemove(file, fileList) {
                axios.delete('/file/del', {filename: file.response}).then(rs => {
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