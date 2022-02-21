<template>
    <div>
        <v-subheader>
            Home
        </v-subheader>

        <div class="row">
            <div class="col-lg-6 col-md-6">
        
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <v-card elevation="2">
                            <div class="card-body">
                                <h4 class="card-title">Users</h4>
                                <div class="text-right">
                                    <h2 class="font-light m-b-0"><i class="fa fa-users text-success"></i> {{users_count}}</h2>
                                    <span class="text-muted">Total Users</span>
                                </div>
                            </div>
                        </v-card>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <v-card elevation="2">
                            <div class="card-body">
                                <h4 class="card-title">Aspirants</h4>
                                <div class="text-right">
                                    <h2 class="font-light m-b-0"><i class="fa fa-tasks text-info"></i> {{aspirants_count}}</h2>
                                    <span class="text-muted">Total Aspirants</span>
                                </div>
                            </div>
                        </v-card>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
        
            </div>
        </div>
    </div>
</template>

<script>
    import helper from '../../services/helper'
    // import ClickConfirm from 'click-confirm'
    export default {
        data(){
            return {
                users_count: '',
                aspirants_count: '',
            }
        },
        components : {  },
        mounted() {
            axios.get('/api/v1/user/dashboard').then(response =>  {
                this.users_count = response.data.users_count;
                this.aspirants_count = response.data.aspirants_count;
                // console.log(response.data);
            });
        },
        methods: {
          
        },
        computed: {
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          },
          momentWithTime(date) {
            return helper.formatDateTime(date);
          }
        }
    }
</script>
<style>
    .strikethrough{
      text-decoration: line-through;
    }
</style>
