<template>
  <div class="card mb-4">
    <div class="card-header pb-0">
      <h6>{{$route.params.electoral_area}}</h6>
      <p class="text-xs text-secondary mb-0">County</p>
    </div>
    <div class="card-body px-3 pt-3 pb-2">
         <md-table v-model="aspirants" md-sort="full_name" md-sort-order="asc" md-card md-fixed-header>

                            <md-table-row slot="md-table-row" v-for="(item, index) in aspirants" :key="index">

                                <md-table-cell md-label="Full name" md-sort-by="full_name">
                                    <div class="d-flex px-3 py-2">
                                   
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{item.full_name}}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ item.political_party }}</p>
                                    </div>
                                    </div>
                                </md-table-cell>
                                <md-table-cell md-label="Electoral position" md-sort-by="electoral_position">{{ item.electoral_position }}</md-table-cell>
                                <md-table-cell md-label="Electoral area" md-sort-by="electoral_area">{{ item.electoral_area }}</md-table-cell>
                                <md-table-cell md-label="Results" md-sort-by="results">
                                   <form @submit.prevent = "feedResult(item.uuid, index)" :id="item.uuid" v-if="!uuids.includes(item.uuid)">
                                          <input
                                                type="number"
                                                step="1"
                                                min="1"
                                                :key="index"
                                                :id="index"
                                                :name="index"
                                                required
                                                v-model="resultsDetails.results[index]"
                                        />
                                       
                                        <v-btn
                                        type="submit"
                                        color="primary"
                                        >
                                        Enter
                                        </v-btn>
                                   </form>
                                   <template v-else>
                                        <p v-for="vote in voted" :key="vote.aspirant_uuid">
                                           <span v-if="item.uuid === vote.aspirant_uuid">{{vote.votes}}</span> 
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

  </div>
</template>

<script>
    export default {
        data() {
        return {
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
        destroyed(){
        }
    }
</script>