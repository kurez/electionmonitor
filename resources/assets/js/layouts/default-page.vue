<template>
    <div id="main-wrapper">
        <!-- <app-header></app-header>
        <app-sidebar></app-sidebar>

        <div class="page-wrapper">
            <div class="container-fluid">
                <router-view></router-view>
                <app-right-sidebar></app-right-sidebar>
            </div>
        	<app-footer></app-footer>
        </div> -->
        <!-- App.vue -->

        <v-app>
             <v-navigation-drawer
                v-model="drawer"
                absolute
                temporary
                >
                <v-list
                    nav
                    dense
                    shaped
                >
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img :src="getAvatar" :alt="getAuthUserFullName()"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content>
                        <v-list-item-title>{{getAuthUserFullName()}}</v-list-item-title>
                         <v-subheader>{{getAuthUser('email')}}</v-subheader>
                        </v-list-item-content>
                    </v-list-item>
                    
                    <hr>
                    <v-list-item-group
                    v-model="group"
                    active-class="deep-purple--text text--accent-4"
                    >
                    <v-list-item to="/home">
                        <v-list-item-icon>
                        <!-- <v-icon>mdi-home</v-icon> -->
                        </v-list-item-icon>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item>

                    <v-list-group
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-icon>
                                <!-- <v-icon>mdi-account-multiple</v-icon> -->
                            </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Users</v-list-item-title>
                        </v-list-item-content>
                        </template>

                        <v-list-item to="/user"
                        >
                        <v-list-item-content>
                            <v-list-item-title>Show Users</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/add/user"
                        >
                        <v-list-item-content>
                            <v-list-item-title>Register User</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        
                        
                    </v-list-group>

                    <v-list-group
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-icon>
                                <!-- <v-icon>mdi-account-multiple</v-icon> -->
                            </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Aspirants</v-list-item-title>
                        </v-list-item-content>
                        </template>

                        <v-list-item to="/aspirant"
                        >
                        <v-list-item-content>
                            <v-list-item-title>Show Aspirants</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/add/aspirant"
                        >
                        <v-list-item-content>
                            <v-list-item-title>Add Aspirant</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        
                        
                    </v-list-group>

                    <v-list-group
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-icon>
                                <!-- <v-icon>mdi-map-marker-distance</v-icon> -->
                            </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Electoral Areas</v-list-item-title>
                        </v-list-item-content>
                        </template>

                        <v-list-item
                        >
                        <v-list-item-content>
                            <v-list-item-title>Electoral Counties</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                        >
                        <v-list-item-content>
                            <v-list-item-title>Electoral Constituencies</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                        >
                        <v-list-item-content>
                            <v-list-item-title>Electoral Wards</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                        >
                        <v-list-item-content>
                            <v-list-item-title>Polling Stations</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                    </v-list-item-group>
                </v-list>
            </v-navigation-drawer>

        <v-app-bar app color="black">
            <!-- -->
            <v-app-bar-nav-icon @click="drawer = true" color="#fff"></v-app-bar-nav-icon>
            <v-toolbar-title style="color: #fff">KU<span style="color: #9575CD"><strong>RA</strong></span></v-toolbar-title>
			<!-- Uncomment below if you prefer to use an image logo -->
			<!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

             <v-spacer></v-spacer>
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon color="#fff" @click.prevent="logout()" v-bind="attrs" v-on="on">
                        <v-icon>mdi-export</v-icon>
                    </v-btn>
                </template>
                <span>Logout</span>
            </v-tooltip>

            <!-- <v-toolbar-title>Title</v-toolbar-title> -->
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- <v-container fluid> -->

                <!-- If using vue-router -->
                <router-view></router-view>
                
            </v-container>
        </v-main>

        <!-- ======= Footer ======= -->
		<footer id="footer">
			

			<div class="container">
			<div class="copyright">
				&copy; Copyright <strong><span>KURA MONITORING</span></strong>. All Rights Reserved
			</div>
			</div>
		</footer><!-- End Footer -->
        </v-app>

    </div>
</template>


<script>
    import AppHeader from './header.vue'
    import AppSidebar from './sidebar.vue'
    import AppFooter from './footer.vue'
    import AppRightSidebar from './right-sidebar.vue'
    import helper from '../services/helper'
    export default {
        data: () => ({
            drawer: false,
            group: null,
        }),
        computed: {
            getAvatar(){
                return '/images/users/'+this.getAuthUser('avatar');
            }
        },
        methods : {
            logout(){
                helper.logout().then(() => {
                    this.$store.dispatch('resetAuthUserDetail');
                    this.$router.replace('/login');
                })
            },
            getAuthUserFullName(){
                return this.$store.getters.getAuthUserFullName;
            },
            getAuthUser(name){
                return this.$store.getters.getAuthUser(name);
            },
            notification(){
                toastr.options = {
                    "positionClass": "toast-top-right"
                };

                $('[data-toastr]').on('click',function(){
                    var type = $(this).data('toastr'),message = $(this).data('message'),title = $(this).data('title');
                    toastr[type](message, title);
                });
            },
            getAuthUser(name){
                return this.$store.getters.getAuthUser(name);
            }
        },
        components: {
            AppHeader, AppSidebar, AppFooter, AppRightSidebar
        },
        mounted() {
            $('body').addClass("fix-header fix-sidebar card-no-border");
            $("body").trigger("resize");
            $(".fix-header .topbar").stick_in_parent();
            $('.scroll-sidebar').slimScroll({
                position: 'left'
                , size: "5px"
                , height: '100%'
                , color: '#dcdcdc'
            });
            $('.message-scroll').slimScroll({
                position: 'right'
                , size: "5px"
                , height: '570'
                , color: '#dcdcdc'
            });

            if(!this.getAuthUser('email')){
                helper.authUser().then(response => {
                    this.$store.dispatch('setAuthUserDetail',{
                        first_name: response.user.first_name,
                        last_name: response.user.last_name,
                        phone: response.user.phone,
                        email: response.user.email,
                        avatar:response.user.avatar
                    });
                });
            }
        }
    }
</script>
