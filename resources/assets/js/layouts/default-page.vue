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
            <v-card>
                <v-navigation-drawer app>
                    <!-- -->
                    <v-card elevation="2">
                        <v-list>
                            <v-list-item class="px-2">
                                <v-list-item-avatar>
                                <v-img :src="getAvatar" alt="user" class="profile-pic"></v-img>
                                </v-list-item-avatar>
                            </v-list-item>

                            <v-list-item link>
                                <v-list-item-content>
                                <v-list-item-title class="text-h6">
                                    {{getAuthUserFullName()}}
                                </v-list-item-title>
                                <v-list-item-subtitle>{{getAuthUser('email')}}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card>

                        <!-- <v-divider></v-divider> -->

                        <v-list
                        nav
                        dense
                        >
                        <v-list-item link>
                            <v-list-item-icon>
                            <v-icon>mdi-folder</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Home</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon>
                            <v-icon>mdi-account-multiple</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Users</v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-list-item-icon>
                            <v-icon>mdi-star</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Aspirants</v-list-item-title>
                        </v-list-item>
                        </v-list>
                </v-navigation-drawer>
            </v-card>

        <v-app-bar app>
            <!-- -->
            
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

            <!-- If using vue-router -->
            <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
            <app-footer></app-footer>
        </v-footer>
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
                        first_name: response.profile.first_name,
                        last_name: response.profile.last_name,
                        email: response.user.email,
                        avatar:response.profile.avatar
                    });
                });
            }
        }
    }
</script>
