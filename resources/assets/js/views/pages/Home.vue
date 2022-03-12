<template>
<div>
  <div class="container-fluid mt-5 mb-3" style="padding-top: 125px">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon>  </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">National</h6> <span>The president</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#00C853"
                            plain
                            @click="enterResult('national')"
                        >
                           <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">Republic <br>of Kenya</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <!-- <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div>
                        <div class="mt-3"> <span class="text1">32 Applied <span class="text2">of 50 capacity</span></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">County Government</h6> <span>County Governor, Senator, Women Representative of The National Assembly</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#00C853"
                            plain
                            @click="enterResult(pollingDetails.county_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading" style="text-transform: capitalize;">{{ pollingDetails.county_name }}<br>County</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <!-- <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div>
                        <div class="mt-3"> <span class="text1">42 Applied <span class="text2">of 70 capacity</span></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">Constituency</h6> <span style="color: ">Member of National Assembly</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#00C853"
                            plain
                            @click="enterResult(pollingDetails.constituency_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading" style="text-transform: capitalize;">{{ pollingDetails.constituency_name }} <br>Constituency</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <!-- <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div>
                        <div class="mt-3"> <span class="text1">52 Applied <span class="text2">of 100 capacity</span></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon"> <v-icon>mdi-tie</v-icon> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">Ward</h6> <span>Member of County Assembly</span>
                        </div>
                    </div>
                    <div class="badge">
                        <v-btn
                            class="ma-1"
                            color="#00C853"
                            plain
                            @click="enterResult(pollingDetails.ward_name)"
                        >
                            <v-icon>mdi-counter</v-icon> Enter Results
                        </v-btn> 
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading" style="text-transform: capitalize;">{{ pollingDetails.ward_name }} <br>Ward</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <!-- <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div>
                        <div class="mt-3"> <span class="text1">52 Applied <span class="text2">of 100 capacity</span></span> </div>
                    </div>
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
</style>