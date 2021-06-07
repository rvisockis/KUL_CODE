<template>
    <v-app>
        <div class="box box-body">
            <v-expansion-panels v-model="panels" multiple class="col-md-6">
<!--                pirmas panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-user-md</v-icon>Asmens sveikatos priežiūros įstaiga, specialistas ir pacientas</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-divider></v-divider>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Paciento Vardas ir Pavardė</label>

                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="PatientName"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Specialistas</label>

                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="Specialist"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Organizacija</label>

                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="Organization"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
<!--                antras panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-check-square</v-icon>Atvykimas</v-expansion-panel-header>
                    <v-expansion-panel-content></v-expansion-panel-content>
                </v-expansion-panel>
<!--                trecias panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-info-circle</v-icon>Informacija apie siuntimą</v-expansion-panel-header>
                    <v-expansion-panel-content></v-expansion-panel-content>
                </v-expansion-panel>
                <!--                ketvirtas panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-file-medical</v-icon>Medicininio vaizdo aprašas</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Medicininio vaizdo aprašas</label>
                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="ViewDescription"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <!--                penktas panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-exclamation-triangle</v-icon>Išvada</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Išvada</label>
                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="Conculusion"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <!--                sestas panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-stethoscope</v-icon>Pagrindinė diagnozė</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:20px; text-align:right; ">Diagnozės</label>

                        <div class="col-md-9">
                            <multiselect v-model="DiagnosisMain" style="width:90%" label="code" track-by="code" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="DiagnosisMainList" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false" class="col-md-12"   @search-change="GetList" >
                                <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.code}} {{ props.option.title}}</span></div></template>
                                <template slot="noResult"
                                          slot-scope="props">
                                    <div>Kodas nerastas</div>

                                </template>
                                <template slot="noOptions"
                                          slot-scope="props">
                                    <div>Įrašykite bent 3 simbolius</div>
                                </template>
                            </multiselect>
                        </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Aprašas</label>
                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                style="margin-top:-15px;"
                                v-model="DescriptionMain"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <!--                septintas panelis-->
                <v-expansion-panel>
                    <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-notes-medical</v-icon>Susijusios diagnozės</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:20px; margin-left:-15px; text-align:right; ">Diagnozės</label>

                        <div class="col-md-9">
                            <multiselect v-model="DiagnosisSide"  label="code" track-by="code" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="DiagnosisSideList" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false" class="col-md-12"   @search-change="GetListSide" >
                                <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.code}} {{ props.option.title}}</span></div></template>
                                <template slot="noResult"
                                          slot-scope="props">
                                    <div>Kodas nerastas</div>
                                </template>
                                <template slot="noOptions"
                                          slot-scope="props">
                                    <div>Įrašykite bent 3 simbolius</div>
                                </template>
                            </multiselect>
                        </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-3" style="font-size:16px;font-weight:700; margin-top:15px; margin-left:-15px; text-align:right; ">Aprašas</label>

                        <div class="col-md-9">
                            <v-text-field
                                solo
                                class="col-md-12"
                                v-model="DescriptionSide"
                                label=""
                            ></v-text-field>
                        </div>
                        </div>

                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

        </div>
    </v-app>
</template>

<script>
    export default {
        name: "RadiologijosForma",
        data(){
            return{
                panels:[0,3,4,5,6],
                //Asmens sveikatos priežiūros įstaiga, specialistas ir pacientas
                PatientName:[],
                Specialist:[],
                Organization:[],
            //    Atvykimas

            //    Informacija apie siuntimą

            //    Medicininio vaizdo aprašas
                ViewDescription:[],
            //    Išvada
                Conculusion:[],
            //    Pagrindinė diagnozė
                DiagnosisMain:[],
                DiagnosisMainList:[],
                fakelist:[],
                DescriptionMain:[],

            //    Susijusios diagnozės
                DiagnosisSide:[],
                DiagnosisSideList:[],
                fakelistSide:[],
                DescriptionSide:[],
            }
        },
        methods:{
            GetList(query){
                this.DiagnosisMainList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a =0 ; a<this.fakelist.length ; a++ ){
                                this.DiagnosisMainList.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE})   ;
                            }
                            return  this.DiagnosisMainList;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            },
            GetListSide(query){
                this.DiagnosisMainList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a =0 ; a<this.fakelist.length ; a++ ){
                                this.DiagnosisMainList.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE})   ;
                            }
                            return  this.DiagnosisMainList;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }

            },
        },
        beforeMount() {
        },
    }
</script>

<style scoped>

</style>
