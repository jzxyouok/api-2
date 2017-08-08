<template>
    <div class="container" style="margin-top: 50px;">
        <el-button @click="getSysInfo">获取系统信息</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loginUser: null,
            }
        },
        created() {
            this.login();
        },
        methods: {
            login() {
                axios.post('/api/admin/login', {email: '676659348@qq.com', password: 'bing8u'}).then(rs => {
                    this.loginUser = rs.data;
                    this.$message.success('登录成功');
                }).catch(err => {
                    this.$message.warning('登录失败');
                })
            },
            getSysInfo() {
                axios.get('/api/admin/sysInfo', {params: {api_token: this.loginUser.api_token}}).then(rs => {
                    console.log(rs);
                }).catch(err => {
                    this.$message.warning('获取失败');
                })
            }
        }
    }
</script>
