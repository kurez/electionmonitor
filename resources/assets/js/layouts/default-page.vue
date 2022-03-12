<template>
    <div id="main-wrapper">
  
        <v-app>
            <v-card v-if="$route.name !== 'agentHome'">
                <v-navigation-drawer app>
                     <aside
                            class="my-3 overflow-auto border-0 sidenav navbar navbar-vertical navbar-expand-xs border-radius-xl"
                            :class="this.$store.state.isRTL ? 'me-3 rotate-caret' : 'ms-3'"
                            id="sidenav-main"
                        >
                            <div class="sidenav-header">
                            <i
                                class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
                                aria-hidden="true"
                                id="iconSidenav"
                            ></i>
                            <!-- <a class="m-0 navbar-brand disabled" href="/"> -->
                                <!-- <img :src="logo" class="navbar-brand-img h-100" alt="main_logo" /> -->
                                <span class="ms-1 font-weight-bold navbar-brand">Election Monitor</span>
                            <!-- </a> -->
                            </div>
                            <hr class="mt-0 horizontal dark" />
                            <div
                                    class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100"
                                    id="sidenav-collapse-main"
                                >
                                    <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Dashboard" to="/dashboard">
                                             <template v-slot:icon>
                                                    <!-- <icon name="dashboard" /> -->
                                                </template>
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Users" to="/user">
                                        
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Aspirant" to="/aspirant">
                                       
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Electoral counties" to="/county">
                                        
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Electoral constituencies" to="/constituency">
                                       
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Electoral wards" to="/ward">
                                       
                                        </sidenav-collapse>
                                    </li>
                                    <li class="nav-item">
                                        <sidenav-collapse navText="Polling stations" to="/polling">
                                       
                                        </sidenav-collapse>
                                    </li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="pt-3 mx-3 mt-3 sidenav-footer">
                                    <!-- <sidenav-card
                                    
                                    textPrimary="Profile"
                                    textSecondary="Name"
                                    href="https://www.creative-tim.com/learning-lab/vue/overview/soft-ui-dashboard/"
                                    linkText=""
                                    iconClass="ni ni-diamond"
                                    /> -->
                                    <!-- <button
                                    class="btn bg-gradient-danger mt-4 w-100"
                                    
                                    type="button"
                                    >Logout</button
                                    > -->
                                </div>
                        </aside>
                </v-navigation-drawer>
            </v-card>

        <v-app-bar app color="#040539" dense v-if="$route.name !== 'login'">
            <!-- -->
             <!-- <v-app-bar-title>Title</v-app-bar-title>

                <v-spacer></v-spacer>

                <v-btn icon color="#fff">
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-heart</v-icon>
                </v-btn>

                <v-btn icon @click="logout()">
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
             -->
             <v-toolbar-title v-if="$route.name === 'agentHome' || 'enterResults'" style="color: #fff">Election <strong style="color: #00E676">Monitor</strong></v-toolbar-title>

            <v-spacer></v-spacer>
            
            
            <v-btn icon color="#fff" @click= "logout()">
                <v-icon>mdi-export</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <div class="container-fluid">

            <!-- If using vue-router -->
            <router-view></router-view>
            </div>
        </v-main>

        <v-footer app>
            <!-- -->
            <!-- <app-footer></app-footer> -->
            
        </v-footer>
        </v-app>

    </div>
</template>


<script>
    // import Icon from "../components/Icon.vue";
    import SidenavCollapse from "./Sidenav/SidenavCollapse.vue";
    import SidenavCard from "./Sidenav/SidenavCard.vue";
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
          SidenavCollapse,SidenavCard,
        },
        mounted() {
            if(!this.getAuthUser('email')){
                helper.authUser().then(response => {
                    this.$store.dispatch('setAuthUserDetail',{
                        first_name: response.first_name,
                        last_name: response.last_name,
                        email: response.user.email,
                        avatar:response.avatar,
                        phone: response.phone,
                        allocated_area: response.allocated_Area
                    });
                });
            }
        }
    }
</script>
