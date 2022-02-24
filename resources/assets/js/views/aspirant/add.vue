<template>
	<div>
        
        
        <div class="row">
            <div class="col-sm-12">
                <v-card elevation="2">
                    <div class="card-body">
                        <div class="section-title ma-4">
                            <h2>ASPIRANTS</h2>
                            <p>Add aspirant</p>
                        </div>
                        <aspirant-form></aspirant-form>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
    import AspirantForm from './form';
    import helper from '../../services/helper'

    export default {
        components : { AspirantForm },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>