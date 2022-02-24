<template>
    <form id="userform" @submit.prevent="proceed">
        <div class="row">
            <div class="form-group text-center m-t-20" v-if="id">
                <span id="fileselector">
                    <label class="btn btn-info">
                        <input type="file"  @change="previewAvatar" id="avatarUpload" class="upload-button">
                        <i class="fa fa-upload margin-correction"></i>Choose Avatar
                    </label>
                </span>
            </div>
            <div class="form-group text-center" v-if="id">
                <img :src="avatar" class="img-responsive" style="max-width:200px;">
            </div>
            <div class="text-center" v-if="id">
                <button type="submit" class="btn btn-info waves-effect waves-light m-t-10" v-if="avatar" @click="uploadAvatar">Upload</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-t-10" v-if="avatar" @click="cancelUploadAvatar">Cancel Upload</button>
            </div>
            <div class="col-md-6 form-group">
              <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" v-model="userForm.first_name" required>
            </div>
            <div class="col-md-6 form-group">
              <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" v-model="userForm.last_name" required>
            </div>
            <div class="col-md-6 form-group">
              <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" v-model="userForm.phone" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" v-model="userForm.email" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              
                    <p>Gender</p>
                    <v-radio-group
                        v-model="userForm.gender"
                        row
                        >
                        <v-radio
                            color="#ffde9e"
                            label="Male"
                            value="male"
                            :checked="userForm.gender === 'male'"
                        ></v-radio>
                        <v-radio
                            color="#ffde9e"
                            label="Female"
                            value="female"
                            :checked="userForm.gender === 'female'"
                        ></v-radio>
                    </v-radio-group>
            </div>
             <div class="col-md-6 form-group mt-3 mt-md-0">
              
                    <p>Roles</p>
                    <v-radio-group
                        v-model="userForm.role"
                        row
                        >
                        <v-radio
                            color="#ffde9e"
                            label="Agent"
                            value="agent"
                            :checked="userForm.role === 'agent'"
                        ></v-radio>
                        <v-radio
                            color="#ffde9e"
                            label="Admin"
                            value="admin"
                            :checked="userForm.role === 'admin'"
                        ></v-radio>
                    </v-radio-group>
            </div>
            <div class="col-md-12 form-group" v-if="userForm.role == 'agent'">
                <select name="allocated_area" class="form-select"  id="allocated_area" v-model="userForm.allocated_area">
                    <option v-for="polling in pollings" :key="polling.id" :value="polling.polling_name">{{ polling.polling_name  }}-{{ polling.ward_name  }} WARD-{{ polling.constituency_name }} CONSTITUENCY-{{ polling.county_name  }} COUNTY</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" v-model="userForm.password">
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" v-model="userForm.password_confirmation">
            </div>
            
        </div>
        <div class="row"><br> </div>
          <v-btn
            :loading="loading"
            class="ma-1"
            style="color: #385F73"
            type="submit"
        >
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </v-btn>
        <v-btn
            class="ma-1"
            style="color: #E53935"
            to="/user"
           
        >
            Cancel
        </v-btn>
       
    </form>
</template>


<script>
     export default {
        data() {
            return {
                userForm: new Form({
                    'email': '',
                    'phone': '',
                    'role': '',
                    'gender': '',
                    // 'avatar': '',
                    'allocated_area': '',
                    'password': '',
                    'password_confirmation': '',
                    'first_name': '',
                    'last_name': ''
                }),
                loading: false,
                pollings: {},
                avatar: ''
            }
        },
        props: ['id'],
        mounted(){
            if(this.id)
                this.getUsers();
                this.getPollings();
               

        },
        methods: {
            submit(e){
                this.loading = true
                axios.post('/api/v1/auth/register', this.userForm).then(response =>  {
                    toastr['success'](response.data.message);
                    // this.getUsers();
                    this.userForm = ''
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                    toastr['error'](error.response.data.message);
                });
            },
            proceed(){
                if(this.id)
                    this.updateUser();
                else
                    this.submit();
            },
            storeUser(){
                this.loading = true;
                this.userForm.post('/api/v1/user')
                .then(response => {
                    this.loading = false;
                    toastr['success'](response.message);
                    this.$emit('completed',response.user)
                    this.$router.push('/user');
                })
                .catch(response => {
                    this.loading = false;
                    toastr['error'](response.message);
                });
            },
            getUsers(){
                axios.get('/api/v1/user/edit/'+this.id)
                .then(response => {
                this.userForm.first_name = response.data.first_name;
                this.userForm.last_name = response.data.last_name;
                this.userForm.gender = response.data.gender;
                this.userForm.allocated_area = response.data.allocated_area;
                this.userForm.role = response.data.role;
                this.userForm.phone = response.data.phone;
                this.userForm.email = response.data.email;
                console.log(response.data)
                })
                .catch(response => {
                    toastr['error'](response.data);
                });
            },
            updateUser(){
                this.loading = true
                this.userForm.patch('/api/v1/user/'+ this.id)
                .then(response => {
                    
                    if(response.type == 'error')
                    
                        toastr['error'](response.message);
                        
                    else {
                        this.loading = false;
                        toastr['success'](response.message);
                        this.$router.push('/user');
                    }
                })
                .catch(response => {
                    this.loading = false;
                    toastr['error'](response.message);
                });
            },
            getPollings(){
                axios.get('/api/v1/polling')
                .then(response => { 
    
                    this.pollings = response.data
                    console.log(this.pollings)
                    // for(let i = 0; i < response.data.length; i++) {
                    //     this.county.push(response.data[i].county_name) 
                    // }   
                    // this.autocomplete_loading = false
                })
                .catch(response => {
                    // this.autocomplete_loading = false
                    toastr['error'](response.message);
                });
            },
            previewAvatar(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createAvatar(files[0]);
            },
            createAvatar(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            cancelUploadAvatar(){
                this.avatar = '';
            },
            uploadAvatar() {
                let data = new FormData();
                data.append('avatar', $('#avatarUpload')[0].files[0]);
                axios.post('/api/v1/user/update-avatar/'+this.id,data)
                .then(response => {
                    this.$store.dispatch('setAuthUserDetail',{
                        avatar: response.data.profile.avatar
                    });
                    toastr['success'](response.data.message);
                    this.avatar = '';
                    $("#avatarUpload").val('');
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            removeAvatar() {
                axios.post('/api/v1/user/remove-avatar')
                .then(response => {
                    this.$store.dispatch('setAuthUserDetail',{
                        avatar: null
                    });
                    toastr['success'](response.data.message);
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
        }
    }
</script>
<style>
    .slider{
        width: 100%;
    }
    .php-email-form {
  width: 100%;
  background: #fff;
}
.php-email-form .form-group {
  padding-bottom: 8px;
}
.php-email-form .error-message {
  display: none;
  color: #fff;
  background: #ed3c0d;
  text-align: left;
  padding: 15px;
  font-weight: 600;
}
.php-email-form .error-message br + br {
  margin-top: 25px;
}
.php-email-form .sent-message {
  display: none;
  color: #fff;
  background: #18d26e;
  text-align: center;
  padding: 15px;
  font-weight: 600;
}
.php-email-form .loading {
  display: none;
  background: #fff;
  text-align: center;
  padding: 15px;
}
.php-email-form .loading:before {
  content: "";
  display: inline-block;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  margin: 0 10px -6px 0;
  border: 3px solid #18d26e;
  border-top-color: #eee;
  -webkit-animation: animate-loading 1s linear infinite;
  animation: animate-loading 1s linear infinite;
}
.php-email-form input, .php-email-form textarea {
  border-radius: 0;
  box-shadow: none;
  font-size: 14px;
  border-radius: 4px;
}
.php-email-form input:focus, .php-email-form textarea:focus {
  border-color: #ffc451;
}
.php-email-form input {
  height: 44px;
}
.php-email-form textarea {
  padding: 10px 12px;
}
.php-email-form button[type=submit] {
  background: #ffc451;
  border: 0;
  padding: 10px 24px;
  color: #151515;
  transition: 0.4s;
  border-radius: 4px;
}
.php-email-form button[type=submit]:hover {
  background: #ffcd6b;
}
@-webkit-keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
