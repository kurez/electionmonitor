<template>
	<div>
        
        <div class="row page-titles">
            <div class="col-md-12 col-8 align-self-center">
                
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/user">User</router-link></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol> -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <div class="section-title ma-4">
                            <h2>users</h2>
                            <p>Register</p>
                        </div>
                        <user-form></user-form>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
    import UserForm from './form';
    import helper from '../../services/helper'

    export default {
        components : { UserForm },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>