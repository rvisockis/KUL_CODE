<template>
    <div class="col-sm-12 box box-body" >
        <v-toolbar flat color="white">

            <v-toolbar-title>Mokamos Paslaugos</v-toolbar-title>
            <v-btn @click="download_csv" style="margin-left:20px;">Parsisiųsti Excel formatu</v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                class="col-md-3"
                v-model="search"
                append-icon="fas fa-search"
                label="Paieška"
                single-line
                hide-details
            ></v-text-field>
            <v-dialog v-model="dialog_paslaugos" persistent max-width="full" style="margin-top: 300px; height:auto; max-height:600px;">
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Nauja paslauga</v-btn>
                </template>
                <v-card >
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.KODAS" label="Kodas"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.PAVADINIMAS" label="Pavadinimas"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.KAINA" label="Kaina"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_galiojimo_pradzia"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"

                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field

                                                style="margin-top:5px; width:100%;"
                                                v-model="editedItem.GALIOJIMO_PRADZIA"
                                                label="Galiojimo pradžia"
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="editedItem.GALIOJIMO_PRADZIA" no-title  locale="lt" @input="datepicker_menu_galiojimo_pradzia = false">
                                        </v-date-picker>
                                    </v-menu>


<!--                                    <v2-datepicker v-model="editedItem.GALIOJIMO_PRADZIA"-->
<!--                                                   class="col-sm-12" :lang="lang"-->
<!--                                                   :customLocals="locals"-->
<!--                                                   placeholder="Data"-->
<!--                                                   :picker-options="pickerOptions2"-->
<!--                                                   :value="editedItem.GALIOJIMO_PRADZIA"-->
<!--                                                   valueType="format"></v2-datepicker>-->
                                </v-flex>
                                <v-flex xs12>
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_galiojimo_pabaiga"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                style="margin-top:5px; width:100%;"
                                                v-model="editedItem.GALIOJIMO_PABAIGA"
                                                label="Galiojimo pabaiga"
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="editedItem.GALIOJIMO_PABAIGA" no-title  locale="lt" @input="datepicker_menu_galiojimo_pabaiga = false">
                                        </v-date-picker>
                                    </v-menu>


<!--                                    <div>Galiojimo pabaiga</div>-->
<!--                                    <v2-datepicker v-model="editedItem.GALIOJIMO_PABAIGA"-->
<!--                                                   class="col-sm-12" :lang="lang"-->
<!--                                                   :customLocals="locals"-->
<!--                                                   placeholder="Data"-->
<!--                                                   :picker-options="pickerOptions2"-->
<!--                                                   :value="editedItem.GALIOJIMO_PABAIGA"-->
<!--                                                   valueType="format"></v2-datepicker>-->
                                </v-flex>
                            </v-layout>
                            <div v-if="required" style="color:red; font-size:12px; font-style:italic; margin-top:15px;">Užpildykite visus laukus!</div>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="close" style="margin-right:20px;">Atšaukti</v-btn>
                        <v-btn color="blue darken-1" flat @click="save">Išsaugoti</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table
            :headers="headers"
            :items="paslaugos_list_page"
            class="elevation-1"
            :items-per-page-options=[15]
            :search="search"
        >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.KODAS }}</td>
                <td class="text-xs-left">{{ props.item.PAVADINIMAS }}</td>
                <td class="text-xs-left">{{ props.item.KAINA }}</td>
                <td class="text-xs-left">{{ moment(props.item.GALIOJIMO_PRADZIA).format('YYYY-MM-DD') }}</td>
                <td class="text-xs-left">{{ moment(props.item.GALIOJIMO_PABAIGA).format('YYYY-MM-DD') }}</td>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon
                    small
                    @click="editItem(item)"
                    style="margin-right:5px;"
                >fas fa-edit</v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >fas fa-trash</v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
            <template v-slot:no-results>
                <v-alert :value="true" icon="warning">
                    <div style="color:black;">Nerasta "{{ search }}".</div>
                </v-alert>
            </template>
        </v-data-table>

<!--        <v-text-field-->
<!--            class="col-md-3"-->
<!--            v-model="clientip.ip"-->
<!--            single-line-->
<!--            hide-details-->
<!--        ></v-text-field>-->

<!--        <v-text-field-->
<!--            style="margin-top:5px; width:100%;"-->
<!--            v-model="personalToken"-->
<!--            label="Tokenas"-->
<!--        ></v-text-field>-->
<!--        <v-btn @click="startGame">Start Game</v-btn>-->
<!--        <v-btn @click="knapSack(this.Mines[0].ResourcesLeft)">Try knapSack</v-btn>-->


    </div>


</template>

<script>
    import axios from 'axios';
    import V2Datepicker from 'v2-datepicker';
    import locals from 'v2-datepicker/lib/locals.js';
    import moment from 'moment';

    Vue.use(V2Datepicker);
    export default {
        data: () => ({
            //////////////////
            UnhiddenMazeRoads: [],
            Mines: [],
            InterconnectionRoads: [],
            Fuel: '',
            DistanceToStart: '',
            CurrentStopId: '',
            startNode: [],
            Cargo: [],
            graph_array: [],
            currentStop: [],
            stoppedAt: '',
            problem: {
                start: {A: 5, B: 2},
                A: {C: 4, D: 2},
                B: {A: 8, D: 7},
                C: {D: 6, finish: 3},
                D: {finish: 1},
                finish: {}
            },
            openNodes: [],
            closedNodes: [],
            latestJunction: [],
            threeRoadsToLatestJunction: [],
            roadTraveled: [],
            FoundMines: [],
            personalToken: '',


            //////////////////
            clientip: '',
            required: false,
            search: '',
            pagination: {},
            selected: [],
            dialog_paslaugos: false,
            locals,
            lang: 'lt',
            paslaugos_list_page: [],
            paslaugos_list_page_fake: [],
            pickerOptions2: {
                shortcuts: [{
                    text: 'Šiandien',
                    onClick(picker) {
                        picker.$emit('pick', new Date());
                    }
                }, {
                    text: 'Vakar',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() - 3600 * 1000 * 24);
                        picker.$emit('pick', date);
                    }
                }, {
                    text: 'Prieš savaitę',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                        picker.$emit('pick', date);
                    }
                }]
            },
            headers: [
                {
                    text: 'Kodas',
                    align: 'left',
                    sortable: true,
                    value: 'KODAS'
                },
                { text: 'Pavadinimas', value: 'PAVADINIMAS' },
                { text: 'Kaina', value: 'KAINA' },
                { text: 'Galiojimo pradžia', align: 'left', sortable: true, value: 'GALIOJIMO_PRADZIA'},
                { text: 'Galiojimo pabaiga', align: 'left', sortable: true, value: 'GALIOJIMO_PABAIGA'},
                { text: 'Veiksmai', value: 'action', sortable: false }
            ],
            editedIndex: -1,
            editedItem: {
            },
            defaultItem: {
            },
            datepicker_menu_galiojimo_pradzia: false,
            datepicker_menu_galiojimo_pabaiga: false,

        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Nauja paslauga' : 'Paslaugos redagavimas'
            },
            pages () {
                if (this.pagination.rowsPerPage == null ||
                    this.pagination.totalItems == null
                ) return 0

                return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
            }
        },

        watch: {
            dialog (val) {
                val || this.close()
            }
        },

        created () {
            this.initialize()
        },

        methods: {

            async startGame(){
               await this.getStates('init');
               await this.getRoads();
               console.log(this.Mines)
               this.findMine();
            },

            async findMine(){
                // this.stoppedAt = this.CurrentStopId
                // let available_roads = this.CurrentStop.find(function(element) {
                //     return element.id == this.stoppedAt;
                // })

                let minDistanceMine = this.Mines.reduce(function(res, obj){
                    return (obj.Distance < res.Distance) ? obj : res;
                })
                let startingDistanceToMine = minDistanceMine.Distance
                console.log(startingDistanceToMine)
                console.log(this.InterconnectionRoads)
                for(let a = 0; a < this.InterconnectionRoads.length; a++){
                    this.openNodes.push({
                        ToStopId: this.InterconnectionRoads[a].ToStopId,
                        FromStopId: this.InterconnectionRoads[a].FromStopId,
                        Weight: this.InterconnectionRoads[a].Weight
                    })
                    // this.openNodes.push({})
                }
                console.log(this.startNode)
                // this.openNodes.push(this.startNode)
                console.log(this.openNodes)
                let tempShortest = [];
                let shortest = [];
                let current;
                let tempDistanceToMine;
                let currentDistanceToMine;
                //Pagrindinis loopas
                // for(let a = 0; a < this.openNodes.length; a++)
                let a = 0;
                let x = 0;
                while(true)
                {
                    await this.getStates('updateAll')
                    currentDistanceToMine = this.Mines.reduce(function(res, obj){
                        return (obj.Distance < res.Distance) ? obj : res;
                    })
                    // if(this.InterconnectionRoads.length > 1) {
                    //     this.latestJunction.push(this.CurrentStopId)
                    //     console.log(this.latestJunction)
                    // }

                    console.log(this.openNodes)
                    // if(a == 0) {
                    //     //Randame trumpiausius kelius is visu galimu openNode ir pushiname i tempShortest
                    //     for (let b = 0; b < this.openNodes.length; b++) {
                    //         tempShortest.push(this.openNodes[b].roads.reduce(function (res, obj) {
                    //             return (obj.Weight < res.Weight) ? obj : res;
                    //         }))
                    //     }
                    //     //Is trumpiausiu keliu (tempShortest) issirenkame viena trumpiausia
                    //     shortest = tempShortest.reduce(function (res, obj) {
                    //         return (obj.Weight < res.Weight) ? obj : res;
                    //     })
                    // } else {

                    //Jei yra neaplankytu, issirenkame trumpiausio kelio
                    if(this.openNodes.length){
                        shortest = this.openNodes.reduce(function(res, obj){
                            return (obj.Weight < res.Weight) ? obj : res;
                        })

                        //Priskiriame trumpiausia kelia i current variable
                        console.log('I current priskirtas trumpiausias kelias')
                        current = shortest;

                    //Jei nera, i current variable priskiriame buvusi node
                    } else {
                        console.log('i current priskirtas praejes kelias')
                    current = this.closedNodes[this.closedNodes.length - 1];
                    }

                    // }



                    //Isimame current is openNodes
                    for(let a = 0; a < this.openNodes.length; a++){
                        if(this.openNodes[a] == current){
                            this.openNodes.splice(a, 1);
                            console.log(this.openNodes[a] + ' elementas istrintas is openNodes masyvo')
                        }
                    }

                    //Pushiname current i closedNodes
                    let alreadyClosed = false;
                    for(let a = 0; a < this.closedNodes.length; a++){
                        if(this.closedNodes[a] == current) {
                            console.log('Sitoks elementas jau yra closedNodes')
                            alreadyClosed = true;
                            break;
                        }
                    }
                    if(!alreadyClosed || !this.closedNodes.length){
                        this.closedNodes.push(current)
                        console.log('I closedNodes papushinta')
                    }


                    console.log(this.closedNodes)

                    //Jei esame ant kasyklos, iseiname is loopo,
                    //issaugome kasyklos koordinates ir surandame
                    //trumpiausia kelia namo/i kasykla
                    if(currentDistanceToMine.Distance === 0 && !this.Cargo.length){
                        this.FoundMines.push(this.CurrentStopId)
                        console.log(this.CurrentStopId)
                        let weight = 0;
                        let a = 0;
                        while(a < 20) {
                            let resourceId = minDistanceMine.ResourcesLeft[a].Id
                            console.log(minDistanceMine.ResourcesLeft[a].Id)
                            console.log(minDistanceMine.ResourcesLeft[a].Weight)
                            let resourceWeight = minDistanceMine.ResourcesLeft[a].Weight
                            if(resourceWeight + weight <=20){
                                await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Load?token=' + this.personalToken + '&resourceId=' + resourceId)
                                console.log('Krovinys pakrautas.')
                                weight += resourceWeight
                            } else {
                                console.log('Krovinys nebetelpa')
                            }
                            a++
                         }
                        //cia reikes pakviesti keliavima namo
                        let wayHome;
                        wayHome = this.closedNodes.slice()
                        console.log(typeof wayHome)
                        wayHome.pop()
                        wayHome = wayHome.reverse()

                        console.log('wayHome : ' + JSON.stringify(wayHome))
                        console.log(wayHome.length)
                        for(let a = 0; a < wayHome.length; a++){
                            console.log('Grizimo namo ciklas ivykdomas ' + a + ' karta.')
                            await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken + '&toStopId=' + wayHome[a].FromStopId)

                        }
                    break;

                    }

                    //Patikriname ar current node yra vienas is dabartiniu kaimynu
                    let isNeighbour = false;
                    for(let a = 0; a < this.InterconnectionRoads.length; a++){
                        if(current.ToStopId === this.InterconnectionRoads[a].ToStopId){
                            console.log('current ToStopId - kaimynas')
                            isNeighbour = true;
                            break;
                        } else {
                            console.log('current ToStopId - NERA kaimynas')
                        }
                    }




                    //einame i current Node
                    //https://cors-anywhere.herokuapp.com/
                    let isOnInterconnection = false;
                    if(isNeighbour){
                        await this.getStates('updateAll')
                        currentDistanceToMine = this.Mines.reduce(function(res, obj){
                            return (obj.Distance < res.Distance) ? obj : res;
                        })
                        console.log('x = ' + x)
                        //kas 2 paejimus atnaujiname tempDistanceToMine
                        if(x % 2 == 0) {
                        tempDistanceToMine = this.Mines.reduce(function(res, obj){
                            return (obj.Distance < res.Distance) ? obj : res;
                        })
                        }
                    x++;
                        await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken + '&toStopId=' + current.ToStopId)
                        console.log('paeita i ' + current.ToStopId)
                        //kas 4 paejimus tikriname ar geru keliu paejome
                        if((x % 3 == 0) && (currentDistanceToMine.Distance > tempDistanceToMine.Distance)) {
                            console.log('prasideda grizimas atgal')
                            for(let a = 0; a < 4; a++){
                                    console.log('current pries pop = ' + JSON.stringify(current))
                                    console.log('closedNodes pries pop = ' + JSON.stringify(this.closedNodes))
                                    current = this.closedNodes.pop()
                                    console.log('closedNodes po pop = ' + JSON.stringify(this.closedNodes))
                                    console.log('current po pop = ' +  JSON.stringify(current))

                                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken + '&toStopId=' + current.FromStopId)
                                    .catch(function (error){
                                    if(error.response){
                                        console.log('erroras - ivykdomas pakartotinis POP')
                                        current = this.closedNodes.pop()
                                        axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken + '&toStopId=' + current.FromStopId)
                                    }
                                })
                                    console.log('grizom ' + a + 'karta')
                                }
                            x = 0;
                            }

                        }
                    else {
                        continue;
                    }
                    // else if (x == 3) {
                    //         console.log(currentDistanceToMine.Distance)
                    //         console.log(tempDistanceToMine.Distance)
                    //         tempDistanceToMine = this.Mines.reduce(function(res, obj){
                    //                     return (obj.Distance < res.Distance) ? obj : res;
                    //                 })
                    //         x = 0;
                    //     }

                    await this.getStates('updateAll')
                    currentDistanceToMine = this.Mines.reduce(function(res, obj){
                        return (obj.Distance < res.Distance) ? obj : res;
                    })

                    // minDistanceMine.Distance = currentDistanceToMine.Distance
                    // if(x == 2){
                    //     tempDistanceToMine = this.Mines.reduce(function(res, obj){
                    //         return (obj.Distance < res.Distance) ? obj : res;
                    //     })
                    // }
                    // console.log(startingDistanceToMine)
                    // console.log(currentDistanceToMine.Distance)
                    // console.log(this.InterconnectionRoads)
                    // if(startingDistanceToMine > currentDistanceToMine){
                    //
                    // }
                    for(let a = 0; a < this.InterconnectionRoads.length; a++){
                        console.log('foras vykdosi')
                        for(let b = 0; b < this.closedNodes.length; b++){
                            var isClosed = false;
                            if(this.InterconnectionRoads[a].ToStopId === this.closedNodes[b].FromStopId){
                                console.log('siame kelyje jau buvo: ' + JSON.stringify(this.InterconnectionRoads[a].ToStopId))
                                isClosed = true;
                                break;
                            }
                        }
                    if(isClosed)
                        continue;
                    for(let b = 0; b < this.openNodes.length + 1; b++){
                            if(!(this.openNodes.length) || (this.InterconnectionRoads[a].ToStopId !== this.openNodes[b].FromStopId)){
                                this.openNodes.push(this.InterconnectionRoads[a])
                                console.log('Naujas kelias pridetas i openNodes: ' + JSON.stringify(this.InterconnectionRoads[a]))
                                break;
                            }
                        }
                    }
                    // Jeigu akligatvis arba visi kaimynai aplankyti, grizti atgal
                    let InterconnectionOpen = false;
                    for(let a = 0; a < this.openNodes.length; a++){
                        for(let b = 0; b < this.InterconnectionRoads.length; b++){
                            if(this.openNodes[a] === this.InterconnectionRoads[b]) {
                                InterconnectionOpen = true;
                            }
                        }
                    }
                    if(!InterconnectionOpen) {
                        let roadBack = this.closedNodes.pop()
                        await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token='+ this.personalToken + '&toStopId=' + roadBack.FromStopId)
                    } else {
                        continue;
                    }


                    //Jeigu distance = 1, bandyti paeiti ir patikrinti ar padidejo.
                    //Jei padidejo, grizti atgal ir isbandyti kita kaimyna
                    // if(minDistanceMine.Distance === 1 && this.InterconnectionRoads.length > 1) {
                    //     let neighbourCount = 0;
                    //     let startId = this.CurrentStopId
                    //     await this.getStates('updateAll')
                    //     console.log(this.InterconnectionRoads)
                    //     for(let a = 1; a < this.InterconnectionRoads.length; a++){
                    //         await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken +'&toStopId=' + this.InterconnectionRoads[a].ToStopId)
                    //         await this.getStates('updateAll')
                    //         let currentDistance = this.Mines.reduce(function(res, obj){
                    //             return (obj.Distance < res.Distance) ? obj : res;
                    //         })
                    //         if(currentDistance === 0){
                    //             this.FoundMines.push(this.CurrentStopId)
                    //             let weight = 0;
                    //             while(weight <= 20) {
                    //                 let resourceId = minDistanceMine.ResourcesLeft[0].Id
                    //                 let resourceWeight = minDistanceMine.ResourcesLeft[0].Weight
                    //                 if(resourceWeight + weight <=20){
                    //                     await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Load?token=' + this.personalToken + '&toStopId=' + resourceId)
                    //                     console.log('Krovinys pakrautas.')
                    //                 } else {
                    //                     break;
                    //                 }
                    //             }
                    //             break;
                    //         } else { //griztam atgal i startId ir bandom kita kelia
                    //             await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/Move?token=' + this.personalToken + '&toStopId=' + startId)
                    //         }
                    //     }
                    // }



                }
            },

          //Sitas nenaudojamas kol kas
          knapSack(val, wt, W){
              let N = wt.length
              let V = new Array[N+1][W+1]
              for(let col = 0; col <= W; col++){
                  V[0][col] = 0;
              }
              for(let row = 0; row <= W; row++){
                  V[row][0] = 0;
              }

              for(let weight = 1; weight <= W; weight++){
                  if(wt[item-1]<=weight){
                      V[item][weight] = Math.max(val[item-1]+V[item-1][weight-wt[item-1]],V[item-1][weight])
                  } else {
                      V[item][weight] = V[item-1][weight]
                  }
              }

              console.log(V[N][W])

          },

          async getStates(state) {
                if(state == 'init') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token='+ this.personalToken, {headers: {'host': 'resourcecompetition.azurewebsites.net', 'Origin': 'resourcecompetition.azurewebsites.net', 'Access-Control-Allow-Origin': 'resourcecompetition.azurewebsites.net', 'Access-Control-Allow-Methods':'DELETE, GET, OPTIONS, PATCH, POST, PUT', 'Access-Control-Allow-Headers':'Origin, X-Requested-With, Content-Type, Accept, Authorization'}} )
                        .then(response => {
                            console.log(response)
                            this.UnhiddenMazeRoads = response.data.UnhiddenMazeRoads;
                            this.Mines = response.data.Mines;
                            this.InterconnectionRoads = response.data.InterconnectionRoads;
                            this.Fuel = response.data.Fuel;
                            this.DistanceToStart = response.data.DistanceToStart;
                            this.CurrentStopId = response.data.CurrentStopId;
                            this.Cargo = response.data.Cargo;
                        })
                } else if (state == 'updateAll') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.Mines = response.data.Mines;
                            this.InterconnectionRoads = response.data.InterconnectionRoads;
                            this.Fuel = response.data.Fuel;
                            this.DistanceToStart = response.data.DistanceToStart;
                            this.CurrentStopId = response.data.CurrentStopId;
                            this.Cargo = response.data.Cargo;
                            console.log(response.data.Mines)
                        })
                } else if (state == 'updateMines') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.Mines = response.data.Mines;
                        })
                } else if (state == 'updateInterconnectionRoads') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.InterconnectionRoads = response.data.InterconnectionRoads;
                        })
                }
                else if (state == 'updateFuel') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.Fuel = response.data.Fuel;
                        })
                }
                else if (state == 'updateDistanceToStart') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.DistanceToStart = response.data.DistanceToStart;
                        })
                }
                else if (state == 'updateCurrentStopId') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.CurrentStopId = response.data.CurrentStopId;
                        })
                }
                else if (state == 'updateCargo') {
                    await axios.get('https://resourcecompetition.azurewebsites.net/api/Truck/GetState?token=' + this.personalToken)
                        .then(response => {
                            // console.log(response)
                            this.Cargo = response.data.Cargo;
                        })
                }
          },

          async getRoads() {

              let max_id = Math.max.apply(Math, this.UnhiddenMazeRoads.map(function (o) {
                  return o.FromStopId
              }))
              for (let a = 1; a <= max_id; a++) {
                  let temporaryStop
                  temporaryStop = this.UnhiddenMazeRoads.filter(function (road) {
                      return road.FromStopId == a;
                  })
                  // console.log(temporaryStop)
                  await this.currentStop.push({id: temporaryStop[0].FromStopId, roads: []});
                  let temporaryIndex = this.currentStop.length - 1;
                  for (let b = 0; b < temporaryStop.length; b++) {
                      this.currentStop[temporaryIndex].roads.push({
                          ToStopId: temporaryStop[b].ToStopId,
                          Weight: temporaryStop[b].Weight

                      })
                  }

              }
              console.log(this.currentStop)
          },


            // async getClientIP(){
            //    this.clientip = await $.getJSON("https://jsonip.com?callback=?", function(data) {
            //        console.log(data)
            //                this.clientip = data.ip;
            //     });
            // console.log(this.clientip.ip)
            // },

            initialize () {
            },

            download_csv() {
                console.log('test')
                var arrData = this.paslaugos_list_page;
                let csvContent = "data:text/csv;charset=utf-8";
                csvContent += [...arrData.map(item => Object.values(item).join(";"))]
                    // .join("\n")
                    // .replace(/(^\[)|(\]$)/gm, "");

                console.log('csvContent: ' + csvContent)

                const data = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", data);
                link.setAttribute("download", "export.csv");
                link.click();
            },

            moment,

            getPaslaugosListPage() {
                this.paslaugos_list_page = [];
                axios.get('/api/getPaslaugosListPage')
                    .then(response => {
                        this.paslaugos_list_page_fake = response.data;
                        for(var a = 0; a < this.paslaugos_list_page_fake.length; a++) {
                            this.paslaugos_list_page.push({
                                'id': this.paslaugos_list_page_fake[a].id,
                                'KODAS': this.paslaugos_list_page_fake[a].KODAS,
                                'PAVADINIMAS' : this.paslaugos_list_page_fake[a].PAVADINIMAS,
                                'KAINA' : this.paslaugos_list_page_fake[a].KAINA,
                                'GALIOJIMO_PRADZIA' : this.paslaugos_list_page_fake[a].GALIOJIMO_PRADZIA,
                                'GALIOJIMO_PABAIGA' : this.paslaugos_list_page_fake[a].GALIOJIMO_PABAIGA,
                            })
                        }
                        return this.paslaugos_list_page;
                        })

                    .catch(error => {
                        console.log(error)
                    });
            },

            editItem (item) {
                this.editedIndex = this.paslaugos_list_page.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog_paslaugos = true
            },

            deleteItem (item) {
                const index = this.paslaugos_list_page.indexOf(item)
                var url_delete = '/api/getPaslaugosListPage/' + this.paslaugos_list_page[index].id;
                confirm('Ar tikrai norite ištrinti šį įrašą?') && this.paslaugos_list_page.splice(index, 1) && axios.delete(url_delete)
            },

            close () {
                this.dialog_paslaugos = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save () {

                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var dateTime = date+' '+time;
                var fixed_date_pradzia = moment(this.editedItem.GALIOJIMO_PRADZIA).format('YYYY-MM-DD');
                var fixed_date_pabaiga = moment(this.editedItem.GALIOJIMO_PABAIGA).format('YYYY-MM-DD');

                var url_post = '/api/getPaslaugosListPage';
                var url_put = '/api/getPaslaugosListPage/' + this.editedItem.id;
                console.log(url_put);


                if (this.editedIndex > -1) {
                    Object.assign(this.paslaugos_list_page[this.editedIndex], this.editedItem)
                    axios.put(url_put, {
                        id: this.editedItem.id,
                        KODAS: this.editedItem.KODAS,
                        PAVADINIMAS: this.editedItem.PAVADINIMAS,
                        KAINA: this.editedItem.KAINA,
                        GALIOJIMO_PRADZIA: fixed_date_pradzia,
                        GALIOJIMO_PABAIGA: fixed_date_pabaiga
                    })
                    this.close();

                } else {
                    if (this.editedItem.KODAS && this.editedItem.PAVADINIMAS && this.editedItem.KAINA && this.editedItem.GALIOJIMO_PRADZIA && this.editedItem.GALIOJIMO_PABAIGA) {
                        this.paslaugos_list_page.push(this.editedItem)
                        console.log(this.editedItem)
                        axios.post(url_post, {
                            KODAS: this.editedItem.KODAS,
                            PAVADINIMAS: this.editedItem.PAVADINIMAS,
                            KAINA: this.editedItem.KAINA,
                            // RECORDCREATED: dateTime,
                            // RECORDUPDATED: dateTime,
                            GALIOJIMO_PRADZIA: fixed_date_pradzia,
                            GALIOJIMO_PABAIGA:  fixed_date_pabaiga

                        })
                        this.required = false;
                        this.close()
                    } else {
                        this.required = true;
                    }
                }
            },
        },
        beforeMount() {
            this.getPaslaugosListPage()
           //  this.getClientIP()
        },
    }
</script>

<style scoped>
  >>> .menuable__content__active {
        top:auto !important;
        left:auto !important;
    }
 >>> .v-dialog:not(.v-dialog--fulscreen) {
      width: auto;
      max-height: 600px;
      margin-top:400px;
  }
</style>
<style>
    /*.theme--light.v-toolbar {*/
    /*    background-color: transparent;*/
    /*}*/

    .application--wrap {
        /*min-height: auto;*/
        background: white;
    }


</style>
