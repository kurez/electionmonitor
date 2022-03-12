<template>
    <div>
     
        <!-- <v-app-bar app color="secondary" dense>
            <v-app-bar-title style="color: #fff">Election Monitor</v-app-bar-title>

            <v-spacer></v-spacer>
        </v-app-bar> -->

        <v-main>
          
                <router-view></router-view>
         
        </v-main>
    

    	
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

<style scoped>
.v-application--wrap {
    flex: 1 1 auto;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0vh;
    max-width: 100%;
    position: relative;
}
</style>