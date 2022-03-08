<template>
	<div>
        <br>
        <div class="row page-titles">
            <div class="col-md-12 col-8 align-self-center">
                <!-- <h3 class="text-themecolor m-b-0 m-t-0">User</h3> -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
                    <li class="breadcrumb-item active">Aspirants</li>
                </ol>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-12">
                <div class="mb-4 card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Filter User</h4> -->
                        <!-- <button class="btn btn-secondary btn-sm" to="/aspirant/add" data-toggle="tooltip" title="New aspirant"><i class="fa fa-pencil"></i>Create</button> -->
                        <md-button class="md-primary md-raised btn btn-secondary btn-sm" to="/aspirant/add">Create</md-button>
                        <br><br><br>
                        <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
                            <md-table-toolbar>
                                <md-field md-clearable class="md-toolbar-section-end">
                                 <v-text-field
                                 dense
                                outlined
                                placeholder="Filter..." 
                                v-model="search" 
                                @input="searchOnTable"
                                clearable
                                prepend-icon="mdi-filter-variant"
                            ></v-text-field>
                                </md-field>
                              
                            </md-table-toolbar>

                            <md-table-empty-state
                                md-label="No aspirants found"
                                :md-description="`No aspirant found for this '${search}' query. Try a different search term or create a new aspirant.`">
                                <!-- <md-button class="md-primary md-raised">Create New User</md-button> -->
                            </md-table-empty-state>

                            <md-table-row slot="md-table-row" slot-scope="{ item }">
                                <!-- <md-table-cell md-label="I" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell> -->
                                <md-table-cell md-label="Name" md-sort-by="full_name">
                                    <div class="d-flex px-3 py-2">
                                    <!-- <div>
                                        <v-avatar color="indigo" v-if="item.avatar === null">
                                            <v-icon dark>
                                                mdi-account-circle
                                            </v-icon>
                                            </v-avatar>
                                        <vsud-avatar :img="item.avatar" size="sm" border-radius="lg" class="me-3" alt="user3" v-else/>
                                    </div> -->
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{item.full_name}}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ item.electoral_position }}</p>
                                    </div>
                                    </div>
                                </md-table-cell>
                                <!-- <md-table-cell md-label="Electoral position" md-sort-by="electoral_position">{{ item.electoral_position }}</md-table-cell> -->
                                <md-table-cell md-label="Electoral area" md-sort-by="electoral_area">{{ item.electoral_area }}</md-table-cell>
                                <md-table-cell md-label="Political party" md-sort-by="political_party">{{ item.political_party }}</md-table-cell>
                               <md-table-cell md-label="Results" md-sort-by="results">{{ item.results }}</md-table-cell>                                
                               <md-table-cell md-label="Actions" class="align-middle">
                                    <button class="btn btn-secondary btn-sm" @click.prevent="editAspirant(item)" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil"></i>Edit</button>
                                    <button class="btn btn-danger btn-sm" @click.prevent="deleteAspirant(item)" data-toggle="tooltip" title="Delete User"><i class="fa fa-trash"></i>Delete</button>

                                </md-table-cell>
                            </md-table-row>
                            </md-table>
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
            </div>
        </div>
    </div>
</template>

<script>
    import AspirantForm from './form'
    import helper from '../../services/helper'
    import VsudAvatar from "../../components/VsudAvatar.vue";
    import VsudBadge from "../../components/VsudBadge.vue";
    const toLower = text => {
        return text.toString().toLowerCase()
    }

    const searchByFilter = (items, term) => {
        if (term) {
        return items.filter(

            item => toLower(item.full_name).includes(toLower(term)) || toLower(item.electoral_area).includes(toLower(term)) ||  toLower(item.electoral_position).includes(toLower(term))
            || toLower(item.political_party).includes(toLower(term)) 
            // || toLower(item.role).includes(toLower(term))
            )
        }

        return items
        }

    export default {
        components : { AspirantForm, VsudAvatar, VsudBadge},
        data() {
            return {
                aspirants: [],
                search: null,
                searched: [],
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
            this.loading =true
            axios.get('/api/v1/aspirant')
                    .then(response => {
                        this.loading =false
                        for(let i = 0;i < response.data.length;i++) {
                            console.log(this.aspirants.push(response.data[i]))
                        }
                        this.searched = this.aspirants
                        console.log(this.searched)
                    });
        },

        methods: {
            getAspirants(page) {
                this.loading =true
                if (typeof page === 'undefined') {
                    page = 1;
                }
                // let url = helper.getFilterURL(this.filterAspirantForm);
                axios.get('/api/v1/aspirant')
                    .then(response => {
                        
                        for(let i = 0;i < response.data.length;i++) {
                            console.log(this.aspirants.push(response.data[i]))
                        }
                        this.searched = this.aspirants
                        console.log(this.searched)
                         this.loading = false
                    });
            },
            deleteAspirant(aspirant){
                this.loading =true
                axios.delete('/api/v1/aspirant/'+aspirant.id).then(response => {
                     // toastr['success'](response.data.message);
                    this.loading = false
                    console.log(response)
                    this.getAspirants();
                    this.searched = this.users
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                    this.loading = false
                });
            },
            searchOnTable () {
                this.searched = searchByFilter(this.aspirants, this.search)
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
