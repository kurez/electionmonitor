<template>
	<div>
    

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add
                             Aspirant</h4>
                        <aspirant-form @completed="getAspirants"></aspirant-form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Aspirant</h4>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <input name="full_name" class="form-control" v-model="filterAspirantForm.full_name" @change="getAspirants">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Political Party</label>
                                    <input name="political_party" class="form-control" v-model="filterAspirantForm.political_party" @change="getAspirants">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Electoral Position</label>
                                    <input name="electoral_position" class="form-control" v-model="filterAspirantForm.electoral_position" @change="getAspirants">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Electoral Area</label>
                                    <input name="electoral_area" class="form-control" v-model="filterAspirantForm.electoral_area" @change="getAspirants">
                                </div>
                            </div>
                        
                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Sort By</label>
                                    <select name="sortBy" class="form-control" v-model="filterAspirantForm.sortBy" @change="getAspirants">
                                        <option value="full_name">Full Name</option>
                                        <option value="political_party">Political Party</option>
                                        <option value="electoral_position">Electoral Position</option>
                                        <option value="electoral_area">Electoral Area</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Order</label>
                                    <select name="order" class="form-control" v-model="filterAspirantForm.order" @change="getAspirants">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h4 class="card-title">Aspirant List</h4>
                        <h6 class="card-subtitle" v-if="aspirants.total">Total {{aspirants.total}} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table" v-if="aspirants.total">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Political Party</th>
                                        <th>Electoral Position</th>
                                        <th>Electoral Area</th>
                                        <th>Results</th>
                                        <th style="width:180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="aspirant in aspirants.data" :key="aspirant.id">
                                        <td v-text="aspirant.full_name"></td>
                                        <td>{{ aspirant.political_party }}</td>
                                        <td>{{ aspirant.electoral_position }}</td>
                                        <td>{{ aspirant.electoral_area }}</td>

                                        <td>
                                            <button class="btn btn-info btn-sm" @click.prevent="editAspirant(aspirant)" data-toggle="tooltip" title="Edit Aspirant"><i class="fa fa-pencil"></i></button>
                                            <!-- <button v-if="aspirant.status" class="btn btn-danger btn-sm" @click.prevent="toggleTaskStatus(task)" data-toggle="tooltip" title="Mark as Incomplete"><i class="fa fa-times"></i></button> --> -->
                                            <!-- <button v-else class="btn btn-success btn-sm" @click.prevent="toggleTaskStatus(task)" data-toggle="tooltip" title="Mark as Complete"><i class="fa fa-check"></i></button> -->
                                            <!-- <click-confirm yes-class="btn btn-success" no-class="btn btn-danger"> -->
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteTask(task)" data-toggle="tooltip" title="Delete task"><i class="fa fa-trash"></i></button>
                                            <!-- </click-confirm> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <!-- <div class="col-md-8">
                                    <pagination :data="tasks" :limit=3 v-on:pagination-change-page="getTasks"></pagination>
                                </div> -->
                                <!-- <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterAspirantForm.pageLength" @change="getAspirants" v-if="aspirants.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AspirantForm from './form'
    // import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    // import ClickConfirm from 'click-confirm'

    export default {
        components : { AspirantForm,},
        data() {
            return {
                aspirants: {},
                filterAspirantForm: {
                    sortBy : 'electoral_position',
                    order: 'desc',
                    electoral_area: '',
                    electoral_position: '',
                    full_name: '',
                    pageLength: 25
                }
            }
        },

        created() {
            this.getAspirants();
        },

        methods: {
            getAspirants(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterAspirantForm);
                axios.get('/api/v1/aspirant?page=' + page + url)
                    .then(response => this.aspirants = response.data );
            },
            deleteAspirant(aspirant){
                axios.delete('/api/v1/aspirant/'+aspirant.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getAspirants();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editAspirant(aspirant){
                this.$router.push('/aspirant/'+aspirant.uuid+'/edit');
            },
       
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          }
        }
    }
</script>
