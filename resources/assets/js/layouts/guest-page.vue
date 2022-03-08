<template>
    <div>
        <v-app>
        <v-app-bar app color="secondary" dense>
            <v-app-bar-title style="color: #fff">Election Monitor</v-app-bar-title>

            <v-spacer></v-spacer>
        </v-app-bar>

        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>

            <v-footer app>
            <!-- -->
            <!-- <app-footer></app-footer> -->
            </v-footer>
        </v-main>
        
        </v-app>

    	
    </div>
</template>

<script>
    export default {
        methods : {
            
        },
        mounted() {
        
        },
        destroyed(){
        }
    }
</script>