<template>
<div>
  
        <v-app :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }" dark id="inspire" style="min-height: 1px">
            <v-container>
            <v-layout wrap>
                <v-flex sm12 md6 offset-md3>
                <v-card elevation="4" light tag="section" style="margin-top: 100px"  class="card">
                    <v-card-title>
                    <v-layout align-center justify-space-between>
                        <h3 class="headline">
                        <strong>Welcome Back</strong>
                        </h3>
                        <!-- <v-flex>
                        <v-img  class="ml-3" contain height="48px" position="center right" src="https://www.mobygames.com/images/i/12/25/1435075.png"></v-img>
                        </v-flex> -->
                    </v-layout>
                    </v-card-title>
                    <v-divider></v-divider>
                    <Transition name="slide-fade">
                    <v-card-text v-if="showOTP">
                        <p>Code sent to phone number <strong>{{ otpForm.phone }} </strong>.</p>
                        <div class="card-body">
                            <v-otp-input
                                v-model="otpForm.otp"
                                :disabled="loadingOverlay"
                                @finish="verifyOtp"
                            ></v-otp-input>
                            <v-overlay absolute :value="loadingOverlay">
                                <v-progress-circular
                                indeterminate
                                color="primary"
                                ></v-progress-circular>
                            </v-overlay>
                        </div>
                    </v-card-text>
                    <!-- </Transition>
                    <Transition name="slide-fade"> -->
                    <v-card-text v-else>
                        <p>Sign in with your phone number</p>
                        <div class="card-body">
                        <form role="form" class="text-start" @submit.prevent ="submit">
                            <!-- <label>Phone number</label> -->
                            <!-- <vsud-input type="text" placeholder="Phone number" name="phone" v-model="signinForm.phone"/> -->
                            <!-- <label></label> -->
                             <v-text-field
                                v-model="otpForm.phone"
                                label="Example: 0712 xxx xx8"
                                outlined
                                dense
                                return-masked-value
                                mask="####.###.###"
                                maxlength="10"
                                :rules="[rules.required, rules.counter]"
                                clearable
                            ></v-text-field>
                            <div class="text-center">
                            <vsud-button
                                class="my-4 mb-2"
                                variant="gradient"
                                color="info"
                                fullWidth
                                v-if="otpForm.phone.length == 10"
                                type="submit"
                                >Sign in
                            </vsud-button>
                            <vsud-button
                                class="my-4 mb-2"
                                variant="gradient"
                                color="info"
                                fullWidth
                                disabled
                                v-else
                                type="submit"
                                >Sign in
                            </vsud-button>
                            </div>
                        </form>
                        </div>
                    </v-card-text>
                    </Transition>
                </v-card>
                </v-flex>
                <v-flex sm12 md6 offset-md3>
                <v-layout align-center justify-space-between>
                    <p class="caption my-3">
                    <a href="#">Privacy Policy</a>
                    |
                    <a href="#">Terms of Service</a>
                    </p>
                    <p class="caption my-3">Powered by <a href="#">ElectionMonitor</a></p>
                </v-layout>
                </v-flex>
            </v-layout>
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
            </v-container>
        </v-app>
 
  </div>
</template>

<script>
import VsudInput from "../../components/VsudInput.vue";
import VsudSwitch from "../../components/VsudSwitch.vue";
import VsudButton from "../../components/VsudButton.vue";
const body = document.getElementsByTagName("body")[0];

export default {
  name: "signin",
  components: {
    VsudInput,
    VsudSwitch,
    VsudButton,
  },
  data() {
        return {
            otpForm: new Form({
                'otp' : '',
                'phone' : ''
            }),
            rules: {
                required: value => !!value || 'Phone number required.',
                counter: value => value.length <= 20 || 'Max 10 characters',
            },
            alert: false,
            alertMessage: '',
            showOTP: false,
            loading: false,
            loadingOverlay: false,
            signinForm: new Form({
                'email' : '',
                'password' : 'password',
            }),
        }
  },
  beforeMount() {
    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
  },
  methods: {
      submit (e) {
        this.loading = true
        this.otpForm.post('/api/v1/auth/check/if/user/exists')
            .then(response => {
                this.alert = true
                console.log(this.alertMessage = response.message)
                this.signinForm.email = response.data[0].email
                this.otpForm.phone = response.data[0].phone
                // this.signinForm.phone = response.data[0].phone
                setTimeout(() => {
                    this.loading = false
                    this.alert = false
                    this.showOTP = true
                    this.alertMessage = ''
                }, 3500)
            })
            .catch(error => {
                this.loading = false
                this.alert = true
                console.log(this.alertMessage = error)
                setTimeout(() => {
                    // this.loading = false
                    this.alertMessage = ''
                    this.alert = false
                    // this.showOTP = true
                }, 3500)
        });
      },
      verifyOtp () {
            this.loadingOverlay = true
            // this.otpForm.phone = this.signinForm.phone
            this.otpForm.post('/api/v1/auth/two-factor-auth')
            .then(response => {
                console.log(response)
                if (response.message === 'Success') {
                setTimeout(() => {
                    this.signin()
                    this.loadingOverlay = false
                }, 3500)
                } else {
                     this.loadingOverlay = false
                    //  this.otpForm.otp = ''
                }
            })
            .catch(response => {
               
                    this.loadingOverlay = false
                    this.otpForm.otp = ''
               
                console.log(response)
            });
      },
      signin() {
          this.signinForm.post('/api/v1/auth/login')
            .then(response => {
                console.log(response.data[0].role)
                this.loading = true
                if (response.message === 'Success' && response.data[0].role === 'admin') {
                    setTimeout(() => {
                    localStorage.setItem('auth_token',response.token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');

                    this.$router.push('/dashboard')
                    this.showOTP = false
                    this.loading = false
                }, 3500)
                } else if(response.message === 'Success' && response.data[0].role === 'agent')  {
                    setTimeout(() => {
                    localStorage.setItem('auth_token',response.token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');

                    this.$router.push('/home/'+response.data[0].id+'/agent')
                    this.showOTP = false
                    this.loading = false
                }, 3500)
                }    
            })
            .catch(response => {
                setTimeout(() => {
                    this.loadingOverlay = false
                    this.showOTP = false
                }, 3500)
                console.log(response)
            });

      }
  }
};
</script>

<style scoped>
body { background-color: #040539 }

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.8s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>