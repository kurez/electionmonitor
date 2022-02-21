<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-12 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">User</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>

         <div class="row">
            <div class="col-lg-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <h4 class="card-title">Add
                             User</h4>
                        <user-form @completed="getUsers"></user-form>
                    </div>
                </v-card>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <h4 class="card-title">Filter User</h4>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input class="form-control" v-model="filterUserForm.first_name" @change="getUsers">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input class="form-control" v-model="filterUserForm.last_name" @change="getUsers">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input class="form-control" v-model="filterUserForm.email" @blur="getUsers">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control" v-model="filterUserForm.status" @change="getUsers">
                                        <option value="">All</option>
                                        <option value="pending_activation">Pending Activation</option>
                                        <option value="activated">Activated</option>
                                        <option value="banned">Banned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Sort By</label>
                                    <select name="sortBy" class="form-control" v-model="filterUserForm.sortBy" @change="getUsers">
                                        <option value="first_name">First Name</option>
                                        <option value="last_name">Last Name</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                        <option value="status">Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Order</label>
                                    <select name="order" class="form-control" v-model="filterUserForm.order" @change="getUsers">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">User List</h4>
                        <h6 class="card-subtitle" v-if="users.length">Total {{ users.length }} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table" v-if="users.length">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Allocated Area</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th style="width:150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key=user.id>
                                        <td v-text="user.first_name"></td>
                                        <td v-text="user.last_name"></td>
                                        <td v-text="user.phone"></td>
                                        <td>{{ user.email }}</td>
                                        <td v-html="getUserRole(user)"></td>
                                        <td>{{ user.profile.allocated_area }}</td>
                                        <td class="hidden-xs hidden-md hidden-sm">{{ user.profile.gender | ucword }}</td>
                                        
                                        <td v-html="getUserStatus(user)"></td>
                                        <td>
                                            <!-- <click-confirm yes-class="btn btn-success" no-class="btn btn-danger"> -->
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteUser(user)" data-toggle="tooltip" title="Delete User"><i class="fa fa-trash"></i></button>
                                            <!-- </click-confirm> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <!-- <div class="col-md-8">
                                    <pagination :data="users" :limit=3 v-on:pagination-change-page="getUsers"></pagination>
                                </div> -->
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterUserForm.pageLength" @change="getUsers" v-if="users.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
    import UserForm from './form'
    // import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    // import ClickConfirm from 'click-confirm'

    export default {
        components : { UserForm },
        data() {
            return {
                users: {},
                filterUserForm: {
                    sortBy : 'first_name',
                    order: 'desc',
                    phone: '',
                    status: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    pageLength: 50
                }
            } 
        },
        mounted() {
            this.getUsers();
        },
        methods: {
            getUsers(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterUserForm);
                axios.get('/api/v1/user?page=' + page + url)
                    .then(response => {
                        this.users = response.data.data
                        console.log(this.users)
                    });
            },
            deleteUser(user){
                axios.delete('/api/v1/user/' +user.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getUsers();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            getUserStatus(user){
                if(user.status == 'pending_activation')
                    return '<span class="label label-warning">Pending Activation</span>';
                else if(user.status == 'activated')
                    return '<span class="label label-success">Activated</span>';
                else if(user.status == 'banned')
                    return '<span class="label label-danger">Banned</span>';
                else
                    return;
            },
            getUserRole(user){
                if(user.profile.role == 'agent')
                    return '<span class="label label-warning">Agent</span>';
                else if(user.profile.role == 'admin')
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
