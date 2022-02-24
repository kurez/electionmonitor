<template>
	<div>
        <div class="row">
            <div class="col-lg-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <div class="section-title ma-4">
                            <h2>users</h2>
                            <p>display</p>
                        </div>
                            <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
                                <md-table-toolbar>
                                    <!-- <div class="md-toolbar-section-start">
                                    <h1 class="md-title">Users</h1>
                                    </div> -->
     
                                    <md-field md-clearable class="md-toolbar-section-end" md-layout="box">
                                    <md-input md-layout="box" placeholder="Filter users..." v-model="search" @input="searchOnTable" />
                                    </md-field>
                                </md-table-toolbar>

                                <md-table-empty-state
                                    md-label="No users found"
                                    :md-description="`No user found for this '${search}' search. Try a different search term or add user to database.`">
                                    <md-button class="md-primary md-raised" to="/add/user">Create New User</md-button>
                                </md-table-empty-state>

                                <md-table-row slot="md-table-row" slot-scope="{ item }">
                                    <md-table-cell md-label="Avatar" v-if="item.avatar"><md-avatar><img :src="item.avatar" :alt="item.email"></md-avatar></md-table-cell>
                                    <md-table-cell md-label="Avatar" v-else><md-avatar class="md-primary">{{ item.first_name.charAt(0) }}</md-avatar></md-table-cell>
                                    <md-table-cell md-label="First Name" md-sort-by="first_name">{{ item.first_name }}</md-table-cell>
                                    <md-table-cell md-label="Last Name" md-sort-by="last_name">{{ item.last_name }}</md-table-cell>
                                    <md-table-cell md-label="Phone" md-sort-by="phone">{{ item.phone }}</md-table-cell>
                                    <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                                    <md-table-cell md-label="Gender" md-sort-by="gender" style="text-transform: capitalize;">{{ item.gender }}</md-table-cell>
                                    <md-table-cell md-label="Role" md-sort-by="role" style="text-transform: capitalize;">{{ item.role }}</md-table-cell>
                                    <md-table-cell md-label="Allocated Polling" md-sort-by="allocated_area">{{ item.allocated_area }}</md-table-cell>
                                    <md-table-cell md-label="Actions">
                                        <v-btn
                                        icon
                                        color="#385F73"
                                        @click.prevent="editUser(item)"
                                        >
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                        
                                    <v-btn
                                        icon
                                        color="#E53935"
                                        @click.prevent="deleteUser(item)"
                                        >
                                        <v-icon>mdi-trash-can</v-icon>
                                    </v-btn>
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                      
                            <v-dialog
                            v-model="loading_table"
                            hide-overlay
                            persistent
                            width="300"
                            >
                            <v-card
                                color="primary"
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
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>

    const toLower = text => {
    return text.toString().toLowerCase()
    }

    const searchByName = (items, term) => {
        if (term) {
            return items.filter(item => 
            toLower(item.first_name).includes(toLower(term)) ||
            toLower(item.last_name).includes(toLower(term)) ||
            toLower(item.phone).includes(toLower(term)) ||
            toLower(item.email).includes(toLower(term)) 
            // toLower(item.role).includes(toLower(term)) ||
            // toLower(item.allocated_area).includes(toLower(term)) 

        )
        }
        return items
    }
    import UserForm from './form'
    // import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    // import ClickConfirm from 'click-confirm'

    export default {
        components : { UserForm },
        data() {
            return {
                avatar: '',
                allocated_areas: [],
                users: [],
                search: null,
                searched: [],
                loading_table: false,
                filterUserForm: {
                    sortBy : 'first_name',
                    order: 'desc',
                    phone: '',
                    status: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    pageLength: 500
                }
            } 
        },
        mounted() {
            axios.get('/api/v1/polling')
                .then(response => {
                    console.log(this.allocated_areas = response.data)
                })
            this.getUsers();
            this.searched = this.users
        },
        methods: {
            searchOnTable () {
                this.searched = searchByName(this.users, this.search)
            },
            getUsers(page) {
                this.loading_table = true
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterUserForm);
                axios.get('/api/v1/user?page=' + page + url)
                    .then(response => {
                        // this.users = response.data.data
                        for(let i = 0; i < response.data.data.length; i++) {
                        this.users.push(response.data.data[i]) 
                        
                    }   
                        this.loading_table = false
                        console.log(this.users)
                    });
            
            },
            deleteUser(item){
                axios.delete('/api/v1/user/' + item.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getUsers();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editUser(item){
                this.$router.push('/user/' + item.id + '/edit');
            //    this.editUserDialog = true
            //    axios.post('/api/v1/user/edit/' + user.id).then(response => response.data).then(response => {
            //     this.profileForm.first_name = response.first_name;
            //     this.profileForm.last_name = response.last_name;
            //     this.profileForm.gender = response.gender;
            //     this.profileForm.allocated_area = response.allocated_area;
            //     this.profileForm.role = response.role;

            //     console.log(response)
            //    });
         
            },
            
            getUserStatus(item){
                if(item.status == 'pending_activation')
                    return '<span class="label label-warning">Pending Activation</span>';
                else if(item.status == 'activated')
                    return '<span class="label label-success">Activated</span>';
                else if(item.status == 'banned')
                    return '<span class="label label-danger">Banned</span>';
                else
                    return;
            },
            getUserRole(item){
                if(item.role == 'agent')
                    return '<span class="label label-warning">Agent</span>';
                else if(item.role == 'admin')
                    return '<span class="label label-danger">Admin</span>';
                else
                    return;
            }
        },
        filters: {
            moment(date) {
                return helper.formatDate(date);
            },
            ucword(value) {
                return helper.ucword(value);
            }
        }
    }
</script>
