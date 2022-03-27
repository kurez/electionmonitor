<template>
<div class="container-fluid">
    <br>
    <div class="py-4">              
       <md-button class="btn bg-gray-800" style="color: #FFF;border-radius: 4px" @click="$router.go(-1)">Back</md-button>  
    </div>

  <div class="card mb-4 mt-4">
    <div class="card-header pb-0">
      <h6 style="text-transform: capitalize">{{$route.params.electoral_area}} {{$route.params.location}}</h6>
      <!-- <p class="text-xs text-secondary mb-0">County</p><br> -->
    </div>
    <div class="card-body px-3 pt-3 pb-2">

                <!-- Tab Nav -->
                        <div class="nav-wrapper position-relative mb-2" v-if="$route.params.location === 'county'">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 d-flex align-items-center justify-content-center" id="tabs-icons-text-2-tab" @click="position = 'County Governor'"  aria-controls="tabs-icons-text-2" aria-selected="false" style="background-color: #040539; color: #fff">
                                        <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg> -->
                                        County Governor
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 d-flex align-items-center justify-content-center" id="tabs-icons-text-3-tab" @click="filteredAspirants('Senator')"  aria-controls="tabs-icons-text-3" aria-selected="false" style="background-color: #040539; color: #fff">
                                        <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd"></path></svg> -->
                                        Senator
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 d-flex align-items-center justify-content-center" id="tabs-icons-text-3-tab" @click="filteredAspirants('County Woman Member of National Assembly')"  aria-controls="tabs-icons-text-3" aria-selected="false" style="background-color: #040539; color: #fff">
                                        <!-- <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd"></path></svg> -->
                                        Women Rep.
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End of Tab Nav -->
         <md-table v-model="aspirants" md-sort="full_name" md-sort-order="asc" md-card md-fixed-header>

          <md-table-row slot="md-table-row" v-for="(item, index) in aspirants" :key="index">

              <md-table-cell md-label="Full name" md-sort-by="full_name">
                  <div class="d-flex px-3 py-2">
                                   
                  <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{item.full_name}}</h6>
                      <p class="text-xs sub-header text-primary  mb-0" style="color: #">{{ item.political_party }}</p>
                  </div>
                  </div>
              </md-table-cell>
              <md-table-cell md-label="Electoral position" md-sort-by="electoral_position">
                {{item.electoral_position}}
              </md-table-cell>
              <md-table-cell md-label="Electoral area" md-sort-by="electoral_area">{{ item.electoral_area }}</md-table-cell>
              <md-table-cell md-label="Results" md-sort-by="results">
                 <form @submit.prevent = "feedResult(item.uuid, index)" :id="item.uuid" v-if="!uuids.includes(item.uuid)">
                   <div class="row">
                     <div class="col-6">
                            <input
                              class="form-control"
                              type="number"
                              step="1"
                              min="1"
                              :key="index"
                              :id="index"
                              :name="index"
                              required
                              v-model="resultsDetails.results[index]"
                            />
                     </div>
                     <div class="col-6">
                       <md-button class="btn bg-gray-800" style="color: #FFF;border-radius: 4px" type="submit">Enter</md-button>
                        <!-- <button type="submit" class="btn btn-gray-800">Enter</button> -->
                     </div>
                   </div>
                 </form>
                 <template v-else>
                      <p v-for="vote in voted" :key="vote.aspirant_uuid">
                         <span v-if="item.uuid === vote.aspirant_uuid"><code>{{vote.votes}}</code></span> 
                      </p>
                 </template>
                                    
              </md-table-cell>
             <md-table-cell md-label="" md-sort-by="">

              </md-table-cell>
             <!-- <md-table-cell md-label="Latitude" md-sort-by="longitude">{{ item.latitude }}</md-table-cell>    -->

          </md-table-row>
          </md-table>
          <v-dialog
              v-model="loading"
              hide-overlay
              persistent
              width="300"
              >
              <v-card
                  style="background-color: #040539"
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

  </div>
  </div>
</template>

<script>

import VsudBadge from "../../components/VsudBadge.vue";
    export default {
      components : { VsudBadge },
        data() {
        return {
        position: '',
        loading: false,
        uuids: [],
        voted: [],
        resultsDetails: new Form({
          index: '',
          uuid: '',
        //   id: '',
          results: {},
      }),
            aspirants: []
        }
        },
        methods : {
            feedResult (uuid,index,id) {
                this.resultsDetails.uuid = uuid
                this.resultsDetails.index = index
                // this.resultsDetails.id = id
                this.loading = true
                
                // var self = this
                this.resultsDetails.post('/api/v1/enter-results')
                .then(response => {
                    console.log(response)
                    setTimeout(() => 
                        this.loading =false,
                        this.resultsDetails.results = {},
                        this.resultsDetails.uuid = ''
                    , 2000);
                    axios.get('/api/v1/vote-status')
                    .then(response => {
                          console.log(this.voted = response.data)
                        for(var i=0;i<response.data.length;i++) {
                            this.uuids.push(response.data[i].aspirant_uuid)
                            // this.voted.push(response.data[i])
                        }
                    })
                    .catch(response => {
                      this.loading = false
                        console.log(response)
                    });
                    
                })
                .catch(response => {
                    console.log(response)
                });

            }
        },
        mounted() {
            console.log(this.$route.params.electoral_area)
            axios.get('/api/v1/enter-results/'+this.$route.params.electoral_area)
              .then(response => {
                  console.log(this.aspirants = response.data)
              })
              .catch(response => {
                console.log(response)
              });

            axios.get('/api/v1/vote-status')
              .then(response => {
                //   console.log(this.uuids = response.data[0].aspirant_uuid)
                 console.log(this.voted = response.data)
                  for(var i=0;i<response.data.length;i++) {
                      this.uuids.push(response.data[i].aspirant_uuid)
                    //   this.voted.push(response.data)
                  }
              })
              .catch(response => {
                console.log(response)
              });

        },
        computed: {
          filteredAspirants() {
            let search = this.aspirants
            this.position = 'Senator'
            
            search = search.filter((item) => {
              return (item.electoral_position === this.position)
            })
            
            return search;
          }
        },
        destroyed(){
        }
    }
</script>