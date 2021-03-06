<?php

use App\Models\Aspirant\Aspirant;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Aspirant::class, function (Faker $faker) {
    

    $political_parties = 
    [
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
    ];

    $electoral_area = 
    [
        'ABOGETA EAST        ', 
        'ABOGETA WEST        ', 
        'ABOTHUGUCHI CENTRAL ', 
        'ABOTHUGUCHI WEST    ', 
        'ADEMASAJIDE         ', 
        'ADU                 ', 
        'AGENGA NANGUBA     ', 
        'AGUTHI-GAAKI        ', 
        'AHERO               ', 
        'AINABKOI/OLARE      ', 
        'AIRBASE             ', 
        'AIRPORT             ', 
        'AKACHIU             ', 
        'AKIRANGONDU        ', 
        'AKITHII             ', 
        'ALALE               ', 
        'ALANGO GOF          ', 
        'AMALO               ', 
        'AMUKURA CENTRAL     ', 
        'AMUKURA EAST        ', 
        'AMUKURA WEST        ', 
        'AMWATHI             ', 
        'ANGOROM            ', 
        'ANGURAI EAST       ', 
        'ANGURAI NORTH      ', 
        'ANGURAI SOUTH      ', 
        'ANGATA BARIKOI      ', 
        'ANGATA NAYOKIE      ', 
        'ANTUAMBUI           ', 
        'ANTUBETWE KIONGO    ', 
        'ARABIA              ', 
        'ARBAJAHAN           ', 
        'ARROR               ', 
        'ASHABITO            ', 
        'ATHI                ', 
        'ATHI RIVER          ', 
        'ATHIRU GAITI        ', 
        'ATHIRU RUUJINE      ', 
        'ATHWANA             ', 
        'AWASI               ', 
        'BAAWA               ', 
        'BABADOGO            ', 
        'BAHARI              ', 
        'BAHATI              ', 
        'BALAMBALA           ', 
        'BAMBURI             ', 
        'BANGALE             ', 
        'BANISSA             ', 
        'BANJA               ', 
        'BARAGWI             ', 
        'BARAKI              ', 
        'BARTABWA            ', 
        'BARUT               ', 
        'BARWAGO             ', 
        'BARWESSA            ', 
        'BASI CENTRAL        ', 
        'BASSI BOGETAORIO    ', 
        'BASUBA WARD         ', 
        'BATALU              ', 
        'BATEI               ', 
        'BENANE              ', 
        'BIASHARA            ', 
        'BIBIRIONI           ', 
        'BIDII               ', 
        'BIRONGO             ', 
        'BOBARACHO           ', 
        'BOBASI CHACHE       ', 
        'BOBASI/BOITANGARE   ', 
        'BOFU                ', 
        'BOGEKA              ', 
        'BOGETENGA           ', 
        'BOGIAKUMU           ', 
        'BOGICHORA           ', 
        'BOGUSERO            ', 
        'BOIKANGA            ', 
        'BOITO               ', 
        'BOKEIRA             ', 
        'BOKIMONGE           ', 
        'BOMANI              ', 
        'BOMARIBA            ', 
        'BOMBABA BORABU      ',
        'SYOKIMAU/MULOLONGO  ',        
 'TABAKA                       ',
 'TAGARE                       ',
 'TAKABA                       ',
 'TAKABA SOUTH                 ',
 'TALA                         ',
 'TAMBACH                      ',
 'TAMBUA                       ',
 'TAPACH                       ',
 'TAPSAGOI                     ',
 'TARAKWA                      ',
 'TARBAJ                       ',
 'TEBERE                       ',
 'TEMBELIO                     ',
 'TENDENO/SORGET               ',
 'TENGES                       ',
 'TEZO                         ',
 'THANGATHA                    ',
 'THANGE                       ',
 'THARAKA                      ',
 'THEGU RIVER                  ',
 'THETA                        ',
 'THIBA                        ',
 'THINGITHU                    ',
 'TIGITHI                      ',
 'TIMAU                        ',
 'TIMBWANI                     ',
 'TINET                        ',
 'TIWI                         ',
 'TONGAREN                     ',
 'TONONOKA                     ',
 'TOWNSHIP                     ',
 'TSEIKURU                     ',
 'TSIMBA GOLINI                ',
 'TUDOR                        ',
 'TULIMANI                     ',
 'TULWET/CHIYAT                ',
 'TURBI                        ',
 'TURI                         ',
 'TURKWEL                      ',
 'UGUNJA                       ',
 'UKIA                         ',
 'UKUNDA                       ',
 'UKWALA                       ',
 'UMANDE                       ',
 'UMOJA I                      ',
 'UMOJA II                     ',
 'UPPER KAEWA/IVETI            ',
 'UPPER SAVANNA                ',
 'URAN                         ',
 'USONGA                       ',
 'UTALII                       ',
 'UTAWALA                      ',
 'UTHIRU                       ',
 'UTHIRU/RUTHIMITU             ',
 'VANGA                        ',
 'VISOI                        ',
 'VIWANDA                      ',
 'VIWANDANI                    ',
 'VOO/KYAMATU                  ',
 'WAA                          ',
 'WABERA                       ',
 'WABERI                       ',
 'WAGBERI                      ',
 'WAIA- KAKO                   ',
 'WAITA                        ',
 'WAITHAKA                     ',
 'WALDAI                       ',
 'WAMAGANA                     ',
 'WAMBA EAST                   ',
 'WAMBA NORTH                  ',
 'WAMBA WEST                   ',
 'WAMUMU                       ',
 'WAMUNYU                      ',
 'WANGU                        ',
 'WANJOHI                      ',
 'WARANQARA                    ',
 'WARGADUD                     ',
 'WASEGES                      ',
 'WASIMBETE                    ',
 'WASO                         ',
 'WASWETA II                   ',
 'WATAMU                       ',
 'WAYU                         ',
 'WEI WEI                      ',
 'WEMILABI                     ',
 'WERU                         ',
 'WERUGHA                      ',
 'WEST ALEGO                   ',
 'WEST ASEMBO                  ',
 'WEST BUKUSU                  ',
 'WEST BUNYORE                 ',
 'WEST GEM                     ',
 'WEST KABRAS                  ',
 'WEST KANYAMKAGO              ',
 'WEST KISUMU                  ',
 'WEST NALONDO                 ',
 'WEST NYAKACH                 ',
 'WEST SABATIA                 ',
 'WEST SAKWA                   ',
 'WEST SANGALO                ',
 'WEST SEME                    ',
 'WEST UGENYA                  ',
 'WEST UYOMA                   ',
 'WEST YIMBO                   ',
 'WIGA                         ',
 'WITEITHIE                    ',
 'WITU                         ',
 'WODANGA                      ',
 'WOODLEY/KENYATTA GOLF COURSE ',
 'WOTE                         ',
 'WUMINGU/KISHUSHE             ',
 'WUNDANYI/MBALE               ',
 'WUSI/KISHAMBA                ',
 'YALA TOWNSHIP                ',
 'YIMBO EAST                   ',
 'ZIMMERMAN                    ',
 'ZIWA                         ',
 'ZIWA LA NGOMBE              ',
 'ZIWANI/KARIOKOR              ',
 'ZOMBE/MWITIKA                ',
 

    ];
    return [
        'full_name'            => $faker->name,
        'uuid'                 => Str::uuid()->toString(),
        'political_party'       => $political_parties[rand(0, count($political_parties) - 1)],
        'electoral_position'   => 'Member of County Assembly', 
        'electoral_area'       => $electoral_area[rand(0, count($electoral_area) - 1)],
    ];
});
   