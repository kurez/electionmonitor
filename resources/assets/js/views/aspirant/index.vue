<template>
	<div>
        <div class="row">
            <div class="col-lg-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <div class="section-title ma-4">
                            <h2>Aspirant</h2>
                            <p>ASPIRANTS</p>
                        </div>
                            <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
                                <md-table-toolbar>
                                    <!-- <div class="md-toolbar-section-start">
                                    <h1 class="md-title">Users</h1>
                                    </div> -->
     
                                    <md-field md-clearable class="md-toolbar-section-end" md-layout="box">
                                    <md-input md-layout="box" placeholder="Filter aspirants..." v-model="search" @input="searchOnTable" />
                                    </md-field>
                                </md-table-toolbar>

                                <md-table-empty-state
                                    md-label="No aspirants found"
                                    :md-description="`No aspirant found for this '${search}' search. Try a different search term or add aspirant to database.`">
                                    <md-button class="md-primary md-raised" to="/add/aspirant">Create New User</md-button>
                                </md-table-empty-state>

                                <md-table-row slot="md-table-row" slot-scope="{ item }">
                                    <!-- <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell> -->
                                    <md-table-cell md-label="Full name" md-sort-by="full_name">{{ item.full_name }}</md-table-cell>
                                    <md-table-cell md-label="Political Party" md-sort-by="political_party">{{ item.political_party }}</md-table-cell>
                                    <md-table-cell md-label="Electoral position" md-sort-by="electoral_position">{{ item.electoral_position }}</md-table-cell>
                                    <md-table-cell md-label="Electoral area" md-sort-by="electoral_area">{{ item.electoral_area }}</md-table-cell>
                                    <md-table-cell md-label="Actions">
                                        <v-btn
                                        icon
                                        color="#385F73"
                                        @click.prevent="editAspirant(item)"
                                        >
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                        
                                    <v-btn
                                        icon
                                        color="#E53935"
                                        @click.prevent="deleteAspirant(item)"
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
            toLower(item.full_name).includes(toLower(term)) ||
            toLower(item.political_party).includes(toLower(term)) ||
            toLower(item.electoral_position).includes(toLower(term)) ||
            toLower(item.electoral_area).includes(toLower(term))
        )
        }
        return items
    }
    import AspirantForm from './form'
    // import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    // import ClickConfirm from 'click-confirm'

    export default {
        components : { AspirantForm,},
        data() {
            return {
                filterAspirantForm: {
                    sortBy : 'electoral_position',
                    order: 'desc',
                    electoral_area: '',
                    electoral_position: '',
                    full_name: '',
                    pageLength: 500
                },
                loading_table: false,
                search: null,
                searched: [],
                aspirants: []
            }
        },

        created() {
            this.getAspirants();
            this.searched = this.aspirants
        },

        methods: {
            searchOnTable () {
                this.searched = searchByName(this.aspirants, this.search)
            },
            getAspirants(page) {
                this.loading_table = true
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterAspirantForm);
                // axios.get('/api/v1/aspirant?page=' + page + url)
                    // .then(response => console.log(this.aspirants = response.data.data) );

                axios.get('/api/v1/aspirant?page=' + page + url).then(response => {
                    // console.log(this.users = response.data.data)

                    for(let i = 0; i < response.data.data.length; i++) {
                        this.aspirants.push(response.data.data[i]) 
                    }  

                    console.log(this.aspirants)
                    // this.getAspirants();
                    this.loading_table = false
                }).catch(error => {
                    this.loading_table = false
                    toastr['error'](error.response.data.message);
                });
            },
            deleteAspirant(aspirant){
                axios.delete('/api/v1/aspirant/'+aspirant.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getAspirants();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editAspirant(item){
                this.$router.push('/aspirant/'+item.uuid+'/edit');
            },
       
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          }
        }
    }
</script>
