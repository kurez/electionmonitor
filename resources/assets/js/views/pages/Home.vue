<template>
<div>
  <div class="container mt-5 mb-3" style="padding-top: 125px; color: #fff">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 mb-2" style=" background-color: #040539">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon>  </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0" style="color:#fff">National</h6> <span>The president</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#fff"
                            plain
                            @click="enterResult('national')"
                        >
                           <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="heading">Republic of Kenya</h4>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2" style=" background-color: #040539">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0" style="color:#fff">County</h6> <span>County Governor, Senator, Women Rep.</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#fff"
                            plain
                            @click="enterResult(pollingDetails.county_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="heading" style="text-transform: capitalize;">{{ pollingDetails.county_name }} County</h4>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2" style=" background-color: #040539">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0" style="color:#fff">Constituency</h6> <span>Member of National Assembly</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#fff"
                            plain
                            @click="enterResult(pollingDetails.constituency_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="heading" style="text-transform: capitalize;">{{ pollingDetails.constituency_name }} Constituency</h4>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2" style=" background-color: #040539">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0" style="color:#fff">Ward</h6> <span>Member of County Assembly</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#fff"
                            plain
                            @click="enterResult(pollingDetails.ward_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="heading" style="text-transform: capitalize;">{{ pollingDetails.ward_name }} Ward</h4>
                   
                </div>
            </div>
        </div>
    </div>
</div>
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
</template>

<script>
import VsudSwitch from "../../components/VsudSwitch.vue";
import ProfileCard from "../components/ProfileCard.vue";
import VsudAvatar from "../../components/VsudAvatar.vue";


import ProjectsCard from "../components/ProjectOverviewCard.vue";
import qs from 'qs';
import setNavPills from "../../assets/js/nav-pills.js";
import setTooltip from "../../assets/js/tooltip.js";
 import helper from '../../services/helper'

export default {
  name: "profile-overview",
  data() {
    return {
      loading: false,
      userDetails: new Form({
          email: '',
          phone: '',
          role:'',
          gender: '',
          allocated_area: '',
          first_name: '',
          last_name: '',
          created_at: ''
      }),
      pollingDetails: new Form({
          county_name: '',
          ward_name: '',
          constituency_name:'',
      }),
      showMenu: false,
      loading: false,
    };
  },
  components: {
    VsudSwitch,
    ProfileCard,
    VsudAvatar,
    ProjectsCard,
  },

  // props: ['id'],

  mounted() {
    this.getUserDetails()
    // this.getPollingByName()
    // console.log(this.route_params = this.$route.params)
    // this.userDetails.first_name = this.$store.getters.getAuthUserFullName
    this.$store.state.isAbsolute = true;
    this.$store.state.isNavFixed = false;
    setNavPills();
    setTooltip();
  },
  beforeUnmount() {
    this.$store.state.isAbsolute = false;
  },
  methods: {
    getUserDetails () {
    this.loading = true
    axios.get('/api/v1/user/'+this.$route.params.id)
        .then(response => {
            this.loading = false
            this.userDetails.first_name = response.data.first_name;
            this.userDetails.last_name = response.data.last_name;
            this.userDetails.email = response.data.email;
            this.userDetails.phone = response.data.phone;
            this.userDetails.gender = response.data.gender;
            this.userDetails.role = response.data.role;
            this.userDetails.allocated_area = response.data.allocated_area;
            this.userDetails.created_at = response.data.created_at;
            console.log(response)

            const area = this.userDetails.allocated_area
            axios.get('/api/v1/polling-fetch/'+ decodeURI(area))
              .then(response => {
                  console.log(response.data[0])
                  this.pollingDetails.ward_name = response.data[0].ward_name
                  this.pollingDetails.county_name = response.data[0].county_name
                  this.pollingDetails.constituency_name = response.data[0].constituency_name
              })
              .catch(response => {
                console.log(response)
              });
        })
        .catch(response => {
            this.loading = false
            console.log(response)
        });
        
    },
    enterResult (electoral_area){
        this.loading = true
        setTimeout(() => 
        this.$router.push('/enter-results/'+electoral_area)
        , 2000);  
    },
    logout(){
        helper.logout().then(() => {
        this.$store.dispatch('resetAuthUserDetail');
        this.$router.replace('/login');
        })
    },
  }
};
</script>


<style scoped>

.card {
    border: none;
    border-radius: 10px
}

.c-details span {
    font-weight: 300;
    font-size: 13px
}

.icon {
    width: 50px;
    height: 50px;
    background-color: #eee;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 39px
}

.badge span {
    background-color: #fffbec;
    width: 60px;
    height: 25px;
    padding-bottom: 3px;
    border-radius: 5px;
    display: flex;
    color: #fed85d;
    justify-content: center;
    align-items: center
}

.progress {
    height: 10px;
    border-radius: 10px
}

.progress div {
    background-color: red
}

.text1 {
    font-size: 14px;
    font-weight: 600
}

.text2 {
    color: #a5aec0
}
.heading {
    color: #fff;
    font-size: 20px
}
</style>