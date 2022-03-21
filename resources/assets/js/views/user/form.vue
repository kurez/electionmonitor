<template>
    <form id="userform" @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-12">
                <v-row>
                    <v-col
                    cols="12"
                    sm="6"
                    >
                    <v-text-field
                        v-model="userForm.first_name"
                        label="First Name"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>

                    <v-col
                    cols="12"
                    sm="6"
                    >
                    <v-text-field
                        v-model="userForm.last_name"
                        label="Last Name"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col
                    cols="12"
                    sm="6"
                    >
                    <v-text-field
                        v-model="userForm.phone"
                        label="Phone number"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>

                    <v-col
                    cols="12"
                    sm="6"
                    >
                   <v-text-field
                        v-model="userForm.email"
                        label="Email"
                        outlined
                        dense
                    ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col
                    cols="12"
                    sm="6"
                    >
                    <v-select
                    v-model="userForm.gender"
                    :items="genders"
                    label="Gender"
                    required
                    outlined
                    dense
                    ></v-select>
                    </v-col>

                    <v-col
                    cols="12"
                    sm="6"
                    >
                   <v-select
                    v-model="userForm.role"
                    :items="roles"
                    label="Role"
                    required
                    outlined
                    dense
                    ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                    cols="12"
                    sm="6"
                    >
                    <v-select
                    v-model="userForm.allocated_area"
                    :items="pollings"
                    label="Polling"
                    required
                    outlined
                    dense
                    ></v-select>
                  <!-- <v-autocomplete
                    v-model="userForm.allocated_area"
                    :items="pollings"
                    chips
                    clearable
                    hide-selected
                    item-text="name"
                    item-value="symbol"
                    label="Search for a polling..."
                    outlined
                    dense
                    value = "userForm.allocated_area"
                    
                    >
                       <template v-slot:no-data>
                            <v-list-item>
                            <v-list-item-title>
                                Search for your allocated
                                <strong>Polling</strong>
                            </v-list-item-title>
                            </v-list-item>
                        </template>
                        <template v-slot:selection="{ item }">
                           <v-list-item-subtitle v-text="item.polling_name"></v-list-item-subtitle>
                        </template>
                        <template v-slot:item="{ item }">
                           
                            <v-list-item-content>
                            <v-list-item-title v-text="item.polling_name"></v-list-item-title>
                            <v-list-item-subtitle v-text="item.county_name"></v-list-item-subtitle>
                            </v-list-item-content>
                        </template>
                    </v-autocomplete> -->
                    </v-col>
                </v-row>
                <v-dialog
                            v-model="loading"
                            hide-overlay
                            persistent
                            width="300"
                            >
                            <v-card
                                color="secondary"
                                dark
                            >
                                <v-card-text>
                                Please stand by
                                <v-progress-linear
                                    indeterminate
                                    color="white"
                                    class="mb-0"
                                ></v-progress-linear>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary waves-effect waves-light m-t-10">
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </button>
        <button to="/user" class="btn btn-danger waves-effect waves-light m-t-10">
            <span>Cancel</span>
            <!-- <span v-else>Save</span> -->
        </button>
    </form>
</template>


<script>
     export default {
        data() {
            return {
                userForm: new Form({
                    password: 'password',
                    password_confirmation: 'password',
                    email: '',
                    phone: '',
                    role:'',
                    gender: '',
                    allocated_area: '',
                    first_name: '',
                    last_name: ''
                }),
                roles: ['admin','agent'],
                genders: ['male','female'],
                loading: false,
                pollings: []
            }
        },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getUsers();
                this.getPollings();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.updateUser();
                else
                    this.submit();
            },
            submit(e){
                this.loading = true
                axios.post('/api/v1/auth/register', this.userForm).then(response =>  {
                    toastr['success'](response.data.message);
                    this.$router.push('/user');
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                    toastr['error'](error.response.data.message);
                });
            },
            getUsers(){
                this.loading = true
                axios.get('/api/v1/user/'+this.id)
                .then(response => {
                    this.loading = false
                    this.userForm.first_name = response.data.first_name;
                    this.userForm.last_name = response.data.last_name;
                    this.userForm.email = response.data.email;
                    this.userForm.phone = response.data.phone;
                    this.userForm.gender = response.data.gender;
                    this.userForm.role = response.data.role;
                    this.userForm.allocated_area = response.data.allocated_area;
                    console.log(response)
                })
                .catch(response => {
                    this.loading = false
                    toastr['error'](response.message);
                });
            },
            updateUser(){
                this.loading = true
                this.userForm.allocated_area = this.userForm.allocated_area
                this.userForm.put('/api/v1/user/'+this.id)
                .then(response => {
                    this.loading = false
                    if(response.type == 'error')
                        toastr['error'](response.message);
                        
                    else {
                        this.$router.push('/user');
                        this.loading = false
                    }
                })
                .catch(response => {
                    toastr['error'](response.message);
                    this.loading = false
                });
            },
            getPollings (){
                this.loading = true
                axios.get('/api/v1/polling')
                .then(response => {
                    this.loading = false
                    for(let i=0;i<response.data.length;i++){
                        this.pollings.push(response.data[i].polling_name)
                    }
                    console.log(this.pollings)
                })
                .catch(response => {
                    toastr['error'](response.message);
                    this.loading = false
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
