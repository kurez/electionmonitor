<template>
    <form id="registerform" @submit.prevent="submit">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <div class="col-xs-6">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" v-model="registerForm.first_name">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-6">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" v-model="registerForm.last_name">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input type="text" name="email" class="form-control" placeholder="Email" v-model="registerForm.email"> </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" name="password" class="form-control" placeholder="Password" v-model="registerForm.password"> </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" v-model="registerForm.password_confirmation"> </div>
                </div>
            </div>
        </div>
        <!-- <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
           Register
        </button> -->
         <v-btn
            :loading="loading"
            class="ma-1"
            style="color: green"
            plain
            type="submit"
        >
            Add
        </v-btn>
    </form>
</template>


<script>
     export default {
        data() {
            return {
                registerForm: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: ''
                },
                loading: false,
            }
        },
        mounted(){
        },
        methods: {
            submit(e){
                this.loading = true
                axios.post('/api/v1/auth/register', this.registerForm).then(response =>  {
                    toastr['success'](response.data.message);
                    this.$router.push('/user');
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                    toastr['error'](error.response.data.message);
                });
            }
        }
    }
</script>
<style>
    .slider{
        width: 100%;
    }
</style>
