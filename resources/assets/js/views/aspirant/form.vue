<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" v-model="aspirantForm.full_name"  placeholder="Full Name">
                </div>
                <br>
                <div class="form-group">
                    <select class="form-select"  v-model="aspirantForm.political_party">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="party in political_parties" :key="party" :value="party">{{ party }}</option>
                    </select>
                </div>
            
            </div>
            
            <div class="col-md-6">
                
               <div class="form-group">
                    <select class="form-select"  v-model="aspirantForm.electoral_position">
                        <!-- <option selected>Electoral Position</option> -->
                        <option v-for="position in electoral_position" :key="position" :value="position">{{ position }}</option>
                    </select>
                </div>
                <br>
                <div class="form-group"  v-if="aspirantForm.electoral_position === 'County Governor'">
                    <select class="form-select" aria-label="Default select example" v-model="aspirantForm.electoral_area">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="county in county" :key="county.id" :value="county.county_name">{{ county.county_name }}</option>
                    </select>
                </div>
                
                <div class="form-group"  v-if="aspirantForm.electoral_position === 'Senator'">
                    <select class="form-select" aria-label="Default select example" v-model="aspirantForm.electoral_area">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="county in county" :key="county.id" :value="county.county_name">{{ county.county_name }}</option>
                    </select>
                </div>
                <div class="form-group"  v-if="aspirantForm.electoral_position === 'County Woman Member of National Assembly'">
                   <select class="form-select" aria-label="Default select example" v-model="aspirantForm.electoral_area">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="county in county" :key="county.id" :value="county.county_name">{{ county.county_name }}</option>
                    </select>
                </div>
                <div class="form-group"  v-if="aspirantForm.electoral_position === 'Member of National Assembly'">
                   <select class="form-select" aria-label="Default select example" v-model="aspirantForm.electoral_area">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="constituency in constituency" :key="constituency.id" :value="constituency.constituency_name">{{ constituency.constituency_name }}</option>
                    </select>
                </div>
                 <div class="form-group"  v-if="aspirantForm.electoral_position === 'Member of County Assembly'">
                    <select class="form-select" aria-label="Default select example" v-model="aspirantForm.electoral_area">
                        <!-- <option selected>Political Party</option> -->
                        <option v-for="ward in ward" :key="ward.id" :value="ward.ward_name">{{ ward.ward_name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <v-btn
            :loading="loading"
            class="ma-1"
            style="color: #385F73"
            type="submit"
        >
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </v-btn>
        <v-btn
            class="ma-1"
            style="color: #E53935"
            to="/aspirant"
           
        >
            Cancel
        </v-btn>
        <!-- <router-link to="/aspirant" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link> -->
    </form>
</template>


<script>
    import datepicker from 'vuejs-datepicker'
    import RangeSlider from 'vue-range-slider'
    import 'vue-range-slider/dist/vue-range-slider.css'
    import helper from '../../services/helper'

    export default {
        data() {
            return {
                loading: false,
                aspirantForm: new Form({
                    'full_name' : '',
                    'political_party' : '',
                    'electoral_position' : '',
                    'electoral_area' : '',
                }),
                political_parties:   [
                    'Orange Democratic Movement',                
                    'Federal Party Of Kenya',                    
                    'Economic Freedom Party',                    
                    'Shirikisho Party Of Kenya',                 
                    'United Democratic Party',                   
                    'Thirdway Alliance Kenya',                   
                    'The National Vision Party',                 
                    'Social Democratic Party Of Kenya',          
                    'Safina',                                    
                    'Progressive Party Of Kenya',                
                    'Peoples Empowerment Party',                 
                    'Peoples Democratic Party',                  
                    'Party Of National Unity',                   
                    'Party Of Independent Candidates Of Kenya',  
                    'Party Of Democratic Unity',                 
                    'Party For Development And Reform ',         
                    'New Democrats',                             
                    'National Rainbow Coalition - Kenya',        
                    'Nationa Rainbow Coalition',                 
                    'Muungano Party',                            
                    'Mazingira Greens Party Of Kenya',           
                    'Maendeleo Democratic Party',                
                    'Maendeleo Chap Chap Party',                 
                    'Kenya Patriots Party',                      
                    'Kenya African National Union',              
                    'Jubilee',                                   
                    'Green Congress Of Kenya',                   
                    'Frontier Alliance Party',                   
                    'Forum For Restoration Of Democracy - Kenya',
                    'Farmers Party',                             
                    'Empowerment And Liberation Party',          
                    'Devolution Party Of Kenya',                 
                    'Democratic Congress',                       
                    'Citizens Convention Party',                 
                    'Chama Mwangaza Daima',                      
                    'Chama Cha Uzalendo',                        
                    'Amani National Congress',                   
                    'Agano Party',     
                    ],
                electoral_position: ['The President', 'County Governor', 'Senator', 'Member of National Assembly', 'Member of County Assembly', 'County Woman Member of National Assembly'],
                county: [],
                constituency: [],
                ward: [],
                autocomplete_loading: false,
                itemsCounty: [],
                searchCounty: null,
                selectCounty: null,
                itemsConstituency: [],
                searchConstituency: null,
                selectConstituency: null,
                itemsWard: [],
                searchWard: null,
                selectWard: null,
            };
        },
        components : { datepicker,RangeSlider },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getAspirants();
                this.getLocations();
        },
        watch: {
            searchCounty (val) {
                val && val !== this.selectCounty && this.querySelections(val)
            },
            searchConstituency (val) {
                val && val !== this.selectConstituency && this.querySelections(val)
            },
            searchWard (val) {
                val && val !== this.selectWard && this.querySelections(val)
            },
        },

        methods: {
            proceed(){
                if(this.id)
                    this.updateAspirant();
                else
                    this.storeAspirant();
            },
            storeAspirant(){
                this.loading = true;
                this.aspirantForm.post('/api/v1/aspirant')
                .then(response => {
                    this.loading = false;
                    toastr['success'](response.message);
                    this.$emit('completed',response.aspirant)
                })
                .catch(response => {
                    this.loading = false;
                    toastr['error'](response.message);
                });
            },
            getAspirants(){
                axios.get('/api/v1/aspirant/'+this.id)
                .then(response => {
                    this.aspirantForm.full_name = response.data.full_name;
                    this.aspirantForm.political_party = response.data.political_party;
                    this.aspirantForm.electoral_position = response.data.electoral_position;
                    this.aspirantForm.electoral_area = response.data.electoral_area;
                    console.log(response.data)
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            updateAspirant(){
                this.loading = true
                this.aspirantForm.patch('/api/v1/aspirant/'+this.id)
                .then(response => {
                    this.loading = false;
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.loading = false;
                        this.$router.push('/aspirant');
                    }
                })
                .catch(response => {
                    this.loading = false;
                    toastr['error'](response.message);
                    console.log(response.message)
                });
            },
             querySelections (v) {
                // this.autocomplete_loading = true
                this.itemsCounty = this.county.filter(e => {
                    return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                }) 
                this.itemsConstituency = this.constituency.filter(e => {
                    return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                })
                this.itemsWard = this.ward.filter(e => {
                    return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                })
            },
            getLocations (){
                axios.get('/api/v1/county')
                .then(response => { 
                    this.county = response.data
                    // for(let i = 0; i < response.data.length; i++) {
                    //     this.county.push(response.data[i].county_name) 
                    // }   
                    // this.autocomplete_loading = false
                })
                .catch(response => {
                    // this.autocomplete_loading = false
                    toastr['error'](response.message);
                });

                axios.get('/api/v1/constituency')
                .then(response => { 
                    this.constituency = response.data
                    // for(let i = 0; i < response.data.length; i++) {
                    //     this.constituency.push(response.data[i].constituency_name) 
                    // }   
                    // this.autocomplete_loading = false
                })
                .catch(response => {
                    // this.autocomplete_loading = false
                    toastr['error'](response.message);
                });

                axios.get('/api/v1/ward')
                .then(response => { 
    
                    for(let i = 0; i < response.data.length; i++) {
                        this.ward.push(response.data[i].ward_name) 
                    }   
                    // this.autocomplete_loading = false
                })
                .catch(response => {
                    // this.autocomplete_loading = false
                    toastr['error'](response.message);
                });
            }
        }
    }
</script>
<style>
    .slider{
        width: 100%;
    }
</style>
