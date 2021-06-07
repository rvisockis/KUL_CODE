<template>
    <v-app>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <h4 style="text-align:center; margin-bottom:40px;">PRIĖMIMO - SKUBIOSIOS PAGALBOS SKYRIAUS
                            GYDYTOJO VAIKŲ CHIRURGO
                            PACIENTO APŽIŪROS, TYRIMO IR GYDYMO LAPAS

                        </h4>
                        <v-text-field label="Vardas, Pavardė" v-model="Name" class="col-md-4"></v-text-field>
                        <v-text-field label="Gimimo data" v-model="BirthDay" class="col-md-4"></v-text-field>
                        <v-text-field label="Medicininio dokumento Nr." v-model="MedicalNrID" class="col-md-4"></v-text-field>
                        <div class="col-md-12">
                            <p>Diagnozė</p>
                            <multiselect class="col-md-12" v-model="FinalDiagnosis"  label="title" track-by="title" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="FinalDiagnosisList" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false" @remove="remove"  @input="diagnosisSelect" @search-change="GetFinalList"  >
                                <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.code}} {{ props.option.title}}</span></div></template>
                                <template slot="tag" slot-scope="{ option, remove}">
                        <span class="multiselect__tag"><span>
                            <a-popover trigger="click" > <div slot="content">Ligos tipas</div>
                                <a-select class="col-md-12" slot="content" v-model="option.type" @change="TypeChange(option)" >
                                    <a-select-option  value="Pagrindinis" >Pagrindinis</a-select-option>
                                    <a-select-option  value="Lydinti">Lydinti</a-select-option>
                                    <a-select-option  value="Komplikacija">Komplikacija</a-select-option>
                                </a-select>
                                <div slot="content">Ligos tipas</div>
                                <a-radio-group slot="content" :defaultValue="0" v-model="option.time">
                                    <a-radio value="0"><a-popover>0<div slot="content"><strong>Anksčiau registruota lėtinė liga</strong></div> </a-popover></a-radio>
                                    <a-radio value="+"> <a-popover>+<div slot="content"><strong>Ūminės ir pirmą kartą nustatytos ligos</strong></div></a-popover></a-radio>
                                    <a-radio value="-"><a-popover>-<div slot="content"><strong>Pirmą kartą einamaisiais metais registruojamos lėtinės ligos, nustatytos anksčiau</strong></div></a-popover></a-radio>
                                </a-radio-group>
                                <div slot="content">Klinikinė diagnozė</div>
                                <a-textarea slot="content" :autosize="{ minRows: 1, maxRows: 20 }" v-model="option.ClinicalName"></a-textarea>
                               {{option.type}} {{option.time}} {{ option.code }}
                                <div slot="title">{{ option.code }}</div>
                            </a-popover>
                        </span>
                            <span class="multiselect__tag-icon" @click="remove(option)"></span>
                        </span>
                                </template>
                            </multiselect>
                        </div>
                        <div class="col-md-12">
                            <v-data-table
                                :headers="headers_diagnosis"
                                :items="FinalDiagnosis"
                                class="elevation-6"
                                :items-per-page-options=[15]
                                style="margin-top:15px;"
                            >
                                <template v-slot:items="props">
                                    <td class="text-xs-left">{{ props.item.code }}</td>
                                    <td class="text-xs-left"> {{ props.item.title }}></td>
                                    <td class="text-xs-left"> {{ props.item.type }}></td>
                                    <td class="text-xs-left"> {{ props.item.time }}></td>
                                    <td class="text-xs-left"> {{ props.item.ClinicalName }}></td>
                                </template>
                            </v-data-table>
                        </div>
                    </div>
                </div>
            </div>
<!--            kairinė puse-->
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
                <a-tabs>
                    <a-tab-pane key="1" tab="Bendra Informacija">
                        <div class="col-md-4">
                            <p>Apžūros data</p>
                            <v-menu
                                ref="preparatomeniu"
                                v-model="CheckMeniu"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="CheckDate"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker :first-day-of-week="1" v-model="CheckDate" locale="lt" @input="CheckMeniu = false" no-title scrollable>
                                    <div class="flex-grow-1"></div>
                                </v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <p> Apžiūros laikas</p>
                            <a-time-picker  format="HH:mm" v-model="CheckTime" />
                        </div>
                        <div class="col-md-4">
                            <p> Stacionarizuojamas</p>
                            <v-radio-group v-model="GoingStationary" >
                                <v-radio v-for="items in GoingStationaryOptions" :label="items" :value="items" ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-12">
                            <v-text-field label="Būtinos pagalbos kategorija" v-model="MandatoryHelp"></v-text-field>
                        </div>
                        <div class="col-md-12">
                            <v-text-field label="Nusiskundimai ir ligos anamnezė" v-model="coments"></v-text-field>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Gyvenimo anamnezė">
                        <div class="col-md-6">
                            <p>Epidemiologinė anamnezė</p>
                            <v-radio-group  v-model="Epidemic" >
                                <v-radio v-for="items in EpidemicOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="Epidemic==='buvo'">
                                <v-text-field v-model="EpidemicWas" label="Kur buvo"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p>Alergija</p>
                            <v-radio-group v-model="Alergy" row>
                                <v-radio v-for="items in AlergyOptions" :label="items" :value="items" ></v-radio>
                            </v-radio-group>
                            <div v-if="Alergy==='Yra'">
                                <v-text-field label="Kam alergija" v-model="AlergyToWhom"></v-text-field>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <v-switch v-model="WillBeOperated"  label="Ar numatoma operacija ?"></v-switch>
                            <div v-if="WillBeOperated">
                                <v-radio-group v-model="OperationSelection" row>
                                    <v-radio v-for="items in OperationOptions" :label="items" :value="items" ></v-radio>
                                </v-radio-group>
                                <div v-if="(OperationSelection.length>0)&&(OperationSelection!=='nebuvo')">
                                    <p>Kraujavimo, trombozių anamnezė</p>
                                    <v-text-field label="Kam ir kokie sutrikimai?" v-model="OperationSimptoms"></v-text-field>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-12">
                        <p>Gretutinė diagnozė</p>
                        <multiselect v-model="Diagnosis"  label="code" track-by="code" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="DiagnosisList" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false"   @search-change="GetList" >
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
                    </a-tab-pane>
                    <a-tab-pane key="3" tab="Specialioji būklė ir gydymo planas">
                        <div class="col-md-6">
                            <v-text-field v-model="SpecialCondition" label="Specialioji būklė"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-checkbox v-model="WillStationaryBe" label="Ar bus stacionarizuojamas"></v-checkbox>

                        </div>
                        <v-textarea v-if="WillStationaryBe" label="Dieta" class="col-md-6" v-model="Diet" ></v-textarea>
                        <v-textarea v-if="WillStationaryBe" label="Režimas" class="col-md-6" v-model="Mode"></v-textarea>
                        <div class="col-md-12">
                            <h3>Tyrimų planas ir interpretacija :</h3>
                            <v-container fluid class="col-md-6">
                                <v-checkbox v-model="InvestigationPlan" label="Bendras kraujo tyrimas" value="Bendras kraujo tyrimas"></v-checkbox>
                                <v-checkbox v-model="InvestigationPlan" label="Šlapimo tyrimas" value="Šlapimo tyrimas"></v-checkbox>
                                <v-checkbox v-model="InvestigationPlan" label="CRB" value="CRB"></v-checkbox>
                                <v-checkbox v-model="InvestigationPlan" label="Pilvo organų echoskopija" value="Pilvo organų echoskopija"></v-checkbox>
                                <v-checkbox v-model="InvestigationPlan" label="Anesteziologo kosultacija" value="Anesteziologo kosultacija"></v-checkbox>
                                <v-checkbox v-model="InvestigationPlan" label="kiti" value="kiti"></v-checkbox>
                            </v-container>
                            <v-container fluid class="col-md-6">
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='Bendras kraujo tyrimas'" label="Bendras kraujo tyrimas" v-model="CommonBlodTest" ></v-text-field>
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='Šlapimo tyrimas'" label="Šlapimo tyrimas" v-model="UraneTest" ></v-text-field>
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='CRB'" label="CRB" v-model="CRB" ></v-text-field>
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='Pilvo organų echoskopija'" label="Pilvo organų echoskopija" v-model="BellyEchoscopy" ></v-text-field>
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='Anesteziologo kosultacija'" label="Anesteziologo kosultacija" v-model="AnesthesiologistConsultation" ></v-text-field>
                                <v-text-field v-for="items in InvestigationPlan " v-if="items==='kiti'" label="Kita" v-model="InvestigationOther" ></v-text-field>
                            </v-container>
                        </div>
                        <div class="col-md-6">
                            <p>Išvada</p>
                            <v-radio-group v-model="conclusion">
                                <v-radio v-for="items in conclusionOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="conclusion==='stacionarinis gydymas'" >
                                <v-text-field label="Skyrius: " v-model="conclusionDepartment"></v-text-field>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <v-textarea label="Rekomendacijos (ambulatoriniam gydymui)" v-model="recomendations"></v-textarea>
                        </div>
                    </a-tab-pane>
                </a-tabs>

            </div>
<!--            Dešinioji puse-->
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
            <a-tabs>
                <a-tab-pane key="1" tab="Apžiūros duomenys (pirma dalis)">
                    <div class="col-md-7">
                        <p>Bendra būklė</p>
                        <v-radio-group v-model="CommonState" row>
                            <v-radio v-for="items in CommonStateOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-3">
                        <v-text-field label="Temperatura" v-model="Temperature"></v-text-field>
                    </div>
                    <div class="col-md-10">
                        <p>Skausmas balais</p>
                        <v-radio-group  v-model="Pain" row>
                            <v-radio v-for="items in PainOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-6">
                        <p>Gleivės</p>
                      <v-radio-group v-model="slime" row>
                          <v-radio v-for="items in slimeOptions" :value="items" :label="items"></v-radio>
                      </v-radio-group>
                        <div v-if="slime==='kita'">
                            <v-text-field v-model="slimeOther" label="Kita: "></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p> Audinių turgoras</p>
                        <v-radio-group v-model="turgor" row>
                            <v-radio v-for="items in turgorOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                        <v-text-field v-model="KLP" label="KLP"></v-text-field>
                    </div>
                    <div class="col-md-6">
                        <p>Pulsas</p>
                        <v-radio-group v-model="pulse" row>
                            <v-radio v-for="items in pulseOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-6">
                        <v-text-field v-model="breathing" label="Kėpavimo dažnis" ></v-text-field>
                    </div>
                    <div class="col-md-12">
                        <h1> Kvėpavimas</h1>
                        <div class="col-md-6">
                            <p>Kairėje</p>
                            <v-radio-group v-model="breathingLeft" row >
                                <v-radio v-for="items in breathingLeftOptions" :label="items" :value="items" ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Dešinėje</p>
                            <v-radio-group v-model="breathingRight" row >
                                <v-radio v-for="items in breathingRightOptions" :label="items" :value="items" ></v-radio>
                            </v-radio-group>
                        </div>
                    </div>
                </a-tab-pane>
                <a-tab-pane key="2" tab="Apžiūros duomenys (antra dalis)">
                    <div class="col-md-6">
                        <p>Širdies veikla</p>
                        <v-radio-group v-model="Heart" row>
                            <v-radio v-for="items in HeartOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <v-text-field v-model="SSD" label="SSD (k/min)" ></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="AKS" label="AKS (mmHg)" ></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Pilvas</p>
                        <div class="col-md-6">
                            <v-radio-group v-model="belly">
                                <v-radio v-for="items in bellyOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6" v-if="belly === 'skausmingas nežymiai'">
                            <v-text-field v-model="bellySlightlyPainful" label="kur nežymiai skausmingas ?"></v-text-field>
                        </div>
                        <div class="col-md-6" v-if="belly === 'skausmingas'">
                            <v-text-field v-model="bellyPainful" label="kur skausmingas ?"></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Pilvaplėvės dirginimas</p>
                        <v-radio-group v-model="Abdomen" row>
                            <v-radio v-for="items in AbdomenOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                        <div v-if="Abdomen==='yra'">
                            <v-text-field v-model="AbdomenIfIs" label="Koks :"></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Tuštinosi</p>
                        <v-radio-group v-model="Voids">
                            <v-radio v-for="items in VoidsOptions" :label="items" :value="items"></v-radio>
                        </v-radio-group>
                        <div v-if="Voids ==='nesituštino'">
                            <v-text-field v-if="!VoidIfDoesntKnow" v-model="VoidDayCount" label="Kiek dienų"></v-text-field>
                            <v-checkbox v-model="VoidIfDoesntKnow" label="nežino"></v-checkbox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Peristaltika</p>
                        <v-radio-group v-model="Peristalsis" >
                            <v-radio v-for="items in PeristalsisOptions" :value="items" :label="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-6">
                        <p>Šlapinosi prieš</p>
                        <v-text-field v-model="UrinationWhen" label="val"></v-text-field>
                        <v-radio-group v-model="Urination" >
                            <v-radio v-for="items in UrinationOptions" :value="items" :label="items"></v-radio>
                        </v-radio-group>
                    </div>
                    <div class="col-md-6">
                        <p>Peristaltika</p>
                        <v-radio-group v-model="Organs" >
                            <v-radio v-for="items in OrgansOptions" :value="items" :label="items"></v-radio>
                        </v-radio-group>
                        <div v-if="Organs==='su pakeitimais'">
                            <v-text-field v-model="OrgansChanges" label="Pokyčiai: "></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <v-text-field v-model="menstruation" label="Paskutinės menstruacijos"></v-text-field>
                    </div>
                </a-tab-pane>
            </a-tabs>
            </div>
            <v-btn v-on:click="Send" class="primary" >Siųsti</v-btn>
        </div>
    </v-app>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                coments:[],
                palnedOperation:false,
                BirthDay:[],
                Name:[],
                MedicalNrID:[],
                CheckDate:new Date().toISOString().substr(0, 10),
                CheckTime:moment(),
                GoingStationary:[],
                MandatoryHelp:[],
                GoingStationaryOptions:['Planine tvarka','Skubos tvarka'],
                NeededHelpCategory:[],
                ComplainsAndAnamnisis:[],
                AlergyOptions:['Yra','Nėra'],
                Alergy:[],
                AlergyToWhom:[],
                EpidemicAnamnisis:[],
                EpidemicAnamnisisHurts:[],
                CheckMeniu:false,
                HasEpidemic:false,
                Epidemic:[],
                EpidemicOptions:['kontakto nebuvo',' nežino','buvo'],
                EpidemicWas:[],
                WillBeOperated:false,
                OperationOptions:['nebuvo','nežino','buvo','pacientui','šeimos nariams'],
                OperationSelection:[],
                OperationSimptoms:[],
                Diagnosis:[],
                DiagnosisList:[],
                CommonState:[],
                CommonStateOptions:['gera','patenkinama','vidutine','sunki'],
                Temperature:[],
                Pain:[],
                PainOptions:['0','1','2','3','4','5','6','7','8','9','10'],
                slime:[],
                slimeOther:[],
                slimeOptions:['drėgnos','sausos','kita'],
                turgor:[],
                turgorOptions:['išlaikytas','sumažėjęs'],
                KLP:[],
                pulse:[],
                pulseOptions:['normalus','silpnas','nečiuopiamas'],
                breathing:[],
                breathingRight:[],
                breathingRightOptions:['normalus','stridoras','švokštimas','susilpnėjęs','kvėpavime dalivauja pagalbiniai raumenys'],
                breathingLeftOptions:['normalus','stridoras','švokštimas','susilpnėjęs','kvėpavime dalivauja pagalbiniai raumenys'],
                breathingLeft:[],
                Heart:[],
                HeartOptions:['ritmiška','artmiška'],
                SSD:[],
                AKS:[],
                belly:[],
                bellyOptions:['nepapūstas','papūstas','simetriškas','asimetriškas','neskausmingas','skausmingas nežymiai','skausmingas'],
                bellySlightlyPainful:[],
                bellyPainful:[],
                Abdomen:[],
                AbdomenOptions:['yra','nėra'],
                AbdomenIfIs:[],
                Voids:[],
                VoidsOptions:['įprastai','skystai','nesituštino'],
                VoidIfDoesntKnow:false,
                VoidDayCount:[],
                Peristalsis:[],
                PeristalsisOptions:['aktyvi','neišklausoma'],
                Urination:[],
                UrinationOptions:['įprastai','skausmingai','nesišlapino','nežino'],
                UrinationWhen:[],
                Organs:[],
                OrgansOptions:['be patologinių pakitimų','su pakeitimais'],
                OrgansChanges:[],
                menstruation:[],
                SpecialCondition:[],
                InvestigationPlan:[],
                CommonBlodTest:[],
                UraneTest:[],
                CRB:[],
                BellyEchoscopy:[],
                AnesthesiologistConsultation:[],
                InvestigationOther:[],
                FinalDiagnosis:[],
                FinalDiagnosisList:[],
                finalfakelist:[],
                conclusion:[],
                conclusionOptions:['ambulatorinis gydymas','stebėjimo paslauga','stacionarinis gydymas'],
                conclusionDepartment:[],
                recomendations:[],
                WillStationaryBe:false,
                Diet:[],
                Mode:[],
                //json
                JSONarray:[],
                AnamnezeTXT:[],
                BuklesIvertinimasTXT:[],
                AtktiviuTyrimuTXT:[],
                TaikytasGydymoTXT:[],
                DiagnozesTXT:[],
                GydymoRekomendacijosTXT:[],
                SpecialistuTXT:[],

                MainDiagnosis:'',
                headers_diagnosis: [
                    {
                        text: 'TLK-10-AM',
                        align: 'left',
                        sortable: true,
                        value: 'code',
                        divider: true
                    },
                    { text: 'Pavadinimas', value: 'title', divider: true},
                    { text: 'Ligos tipas', value: 'type', sortable: false, align: 'center', divider: true },
                    { text: '+/0/-', value: 'time', sortable: false, align: 'center', divider: true },
                    { text: 'Klinikinė diagnozė', value: 'ClinicalName', sortable: false, align: 'left', divider: true }
                ],

            }
        },

        methods: {
            GetAnamneze(){
                var ats='';
                ats= ' Gretutinės ligos: '+this.Diagnosis+ats;
                if (this.WillBeOperated){
                    ats=' Kraujavimo, trombozių anamnezė: operacija buvo '+this.OperationSelection+' sutrikimas: '+this.OperationSimptoms+ats;
                }
                if (this.Epidemic==='buvo'){
                    ats=' Epidemiologinė anamnezė '+this.Epidemic+' , '+this.EpidemicWas+ats;
                }else{
                    ats=' Epidemiologinė anamnezė: '+this.Epidemic+ats;
                }
                ats=' Nusiskundimai ir ligos anamnezė: '+this.ComplainsAndAnamnisis+ats;
                ats=' Stacionarizuojamas: '+this.GoingStationary+ats;
                ats=' Apžiūros data:'+this.CheckDate+' Laikas: '+this.CheckTime+ats;
                return ats;
            },
            GetBuklesIvetinimas(){
                var ats='';
                ats=' Spacialioji būklė: '+this.SpecialCondition+ats;
                if (this.menstruation.length>0){
                    ats=' Menstruacijos: '+this.menstruation+ats;
                }
                if (this.Organs==='su pakeitimais'){
                    ats=' Lytiniai organai: '+this.Organs+' : '+this.OrgansChanges+ats;
                }else{
                    ats=' Lytiniai organai: '+this.Organs+ats;
                }
                ats=' Šlapinosi prieš: '+this.UrinationWhen+' ; '+this.Urination+ats;
                ats=' Peristalka: '+this.Peristalsis+ats;
                if (this.Voids==='nesituštino'){
                    ats=' Nesituštino: '+this.VoidDayCount+' dienų'+ats;
                }else{
                    ats=' Tuštinosi: '+this.Voids+ats;
                }
                if (this.Abdomen==='yra'){
                    ats=' Pilvalės dirginimas yra: '+this.AbdomenIfIs+ats;
                }else{
                    ats='Pilvalės dirginimo nėra'+ats;
                }
                if (this.belly==='skausmingas'){
                    ats=' Pilvas skausmingas: '+this.bellyPainful+ats;
                }else if (this.belly==='skausmingas nežymiai'){
                    ats=' Pilvas skausmingas nežymiai: '+this.bellySlightlyPainful+ats;
                }else{
                    ats= ' Pilvas '+this.belly+ats;
                }
                ats= ' ŠSD: '+this.SSD+ats;
                ats=' AKS: '+this.AKS+ats;
                ats=' Širdies veikla: '+this.Heart+ats;
                ats= ' Kvėpavimas kairėje: '+this.breathingLeft+' .Kvėpavimas dešinėje: '+this.breathingRight+ats;
                ats= ' Kvėpavimo dažnis: '+this.breathing+ats;
                ats=' Pulsas: '+this.pulse+ats;
                ats= ' KPL: '+this.KLP+' Audinių turgoras: '+this.turgor+ats;
                if (this.slime==='kita'){
                    ats= ' Gleivės: '+this.slimeOther+ats;
                }else{
                    ats= ' Gleivės: '+this.slime+ats;
                }
                ats= ' Skausmas balais: '+this.Pain+ats;
                ats= ' Temperatūra: '+this.Temperature+ats;
                ats= ' Bendra būklė: '+this.CommonState+ats;
                ats=' Būtinos pagalbos kategorija: '+this.MandatoryHelp+ats;

                return ats;
            },
            GetAttiviuTyrimu(){
                var ats='';
                for (var a = 0; a> this.InvestigationPlan.length;a++){
                    if (this.InvestigationPlan[a]==='Bendras kraujo tyrimas'){
                        ats= ' Bendras kraujo tyrimas: '+this.CommonBlodTest+ats;
                    }
                    if (this.InvestigationPlan[a]==='Šlapimo tyrimas'){
                        ats= ' Šlapimo tyrimas: '+this.UraneTest+ats;
                    }
                    if (this.InvestigationPlan[a]==='CRB'){
                        ats= ' CRB: '+this.CRB+ats;
                    }
                    if (this.InvestigationPlan[a]==='Pilvo organų echoskopija'){
                        ats= ' Pilvo organų echoskopija: '+this.BellyEchoscopy+ats;
                    }
                    if (this.InvestigationPlan[a]==='kiti'){
                        ats= ' kiti: '+this.InvestigationOther+ats;
                    }
                }
                return ats;
            },
            GetTaikytasGydimas(){
                var ats='Dieta: '+this.Diet+' Režimas '+this.Mode;

                return ats;
            },
            GetDiagnozesTXT(){
                var ats='';
                ats= ' Diagnozė: '+this.Diagnosis;
                return ats;
            },
            GetGydymoRekomendacijos(){
                var ats='';
                ats=' Rekomendacijos: '+this.recomendations
                if (this.conclusion==='stacionarinis gydymas'){
                    ats=' Stacionarinis gydymas'+ this.conclusionDepartment+ats;
                }else{
                    ats= ' Išvada: '+this.conclusion+ats;
                }

                return ats;
            },
            GetSpecialistu(){
                var ats='';
                for (var a = 0; a> this.InvestigationPlan.length;a++){
                    if (this.InvestigationPlan[a]==='Anesteziologo kosultacija'){
                         ats= ' Anesteziologo kosultacija: '+this.AnesthesiologistConsultation;
                    }
                }
                return ats;
            },
            SendESBI(){},
            Send(){
                this.AnamnezeTXT=this.GetAnamneze();
                this.BuklesIvertinimasTXT=this.GetBuklesIvetinimas()
                this.AtktiviuTyrimuTXT=this.GetAttiviuTyrimu();
                this.TaikytasGydymoTXT=this.GetTaikytasGydimas();
                this.DiagnozesTXT=this.GetDiagnozesTXT();
                this.GydymoRekomendacijosTXT=this.GetGydymoRekomendacijos();
                this.SpecialistuTXT=this.GetSpecialistu();
                this.JSONarray.push({
                    data:{
                        coments:this.coments,
                        BirthDay:this.BirthDay,
                        Name:this.Name,
                        MedicalNrID:this.MedicalNrID,
                        CheckDate:this.CheckDate,
                        GoingStationary:this.GoingStationary,
                        MandatoryHelp:this.MandatoryHelp,
                        NeededHelpCategory:this.NeededHelpCategory,
                        ComplainsAndAnamnisis:this.ComplainsAndAnamnisis,
                        Alergy:this.Alergy,
                        AlergyToWhom:this.AlergyToWhom,
                        EpidemicAnamnisis:this.EpidemicAnamnisis,
                        EpidemicAnamnisisHurts:this.EpidemicAnamnisisHurts,
                        Epidemic:this.Epidemic,
                        EpidemicWas:this.EpidemicWas,
                        OperationSelection:this.OperationSelection,
                        OperationSimptoms:this.OperationSimptoms,
                        Diagnosis:this.Diagnosis,
                        CommonState:this.CommonState,
                        Temperature:this.Temperature,
                        Pain:this.Pain,
                        slime:this.slime,
                        slimeOther:this.slimeOther,
                        turgor:this.turgor,
                        KLP:this.KLP,
                        pulse:this.pulse,
                        breathing:this.breathing,
                        breathingRight:this.breathingRight,
                        breathingLeft:this.breathingLeft,
                        Heart:this.Heart,
                        SSD:this.SSD,
                        AKS:this.AKS,
                        belly:this.belly,
                        bellySlightlyPainful:this.bellySlightlyPainful,
                        bellyPainful:this.bellyPainful,
                        Abdomen:this.Abdomen,
                        AbdomenIfIs:this.AbdomenIfIs,
                        Voids:this.Voids,
                        VoidDayCount:this.VoidDayCount,
                        Peristalsis:this.Peristalsis,
                        Urination:this.Urination,
                        UrinationWhen:this.UrinationWhen,
                        Organs:this.Organs,
                        OrgansChanges:this.OrgansChanges,
                        menstruation:this.menstruation,
                        SpecialCondition:this.SpecialCondition,
                        InvestigationPlan:this.InvestigationPlan,
                        CommonBlodTest:this.CommonBlodTest,
                        UraneTest:this.UraneTest,
                        CRB:this.CRB,
                        BellyEchoscopy:this.BellyEchoscopy,
                        AnesthesiologistConsultation:this.AnesthesiologistConsultation,
                        InvestigationOther:this.InvestigationOther,
                        FinalDiagnosis:this.FinalDiagnosis,
                        conclusion:this.conclusion,
                        conclusionDepartment:this.conclusionDepartment,
                        recomendations:this.recomendations,
                        Diet:this.Diet,
                        Mode:this.Mode,
                    },
                    AnamnezeTXT:this.AnamnezeTXT,
                    BuklesIvertinimasTXT:this.BuklesIvertinimasTXT,
                    AtktiviuTyrimuTXT:this.AtktiviuTyrimuTXT,
                    TaikytasGydymoTXT:this.TaikytasGydymoTXT,
                    DiagnozesTXT:this.FinalDiagnosis,
                    GydymoRekomendacijosTXT:this.GydymoRekomendacijosTXT,
                    SpecialistuTXT:this.SpecialistuTXT,
                })
                var json = JSON.stringify(this.JSONarray, null, 10)
                console.log('JSON: ' + json)
            },
            remove(DeletedDiagnosis){
                if (DeletedDiagnosis.code===this.MainDiagnosis){
                    if (DeletedDiagnosis.code===this.tlk_10_am[0].code){
                        this.FinalDiagnosis[1].type='Pagrindinis';
                        this.FinalDiagnosis=this.tlk_10_am[1].code;
                    }else{
                        this.FinalDiagnosis[0].type='Pagrindinis';
                        this.MainDiagnosis=this.FinalDiagnosis[0].code;
                    }
                }
            },
            TypeChange(ChangedOption){
                var NewMain=this.MainDiagnosis;
                if (this.FinalDiagnosis.length===1){
                    this.FinalDiagnosis[0].type='Pagrindinis'
                }
                if ((ChangedOption.type==='Pagrindinis')&&(ChangedOption.code!==this.MainDiagnosis)){
                    for (var index=0;index<this.FinalDiagnosis.length;index++){
                        if (this.FinalDiagnosis[index].code===ChangedOption.code) {
                            NewMain=ChangedOption.code;
                            this.FinalDiagnosis[index].type='Pagrindinis'
                        }
                        if (this.FinalDiagnosis[index].code===this.MainDiagnosis){
                            this.FinalDiagnosis[index].type='Lydinti';
                        }
                    }

                }
                if ((ChangedOption.type!=='Pagrindinis')&&(ChangedOption.code===this.MainDiagnosis)){
                    for (var index=0;index<this.FinalDiagnosis.length;index++){
                        if (ChangedOption.code===this.FinalDiagnosis[index].code){
                            this.FinalDiagnosis[index].type='Pagrindinis';
                        }
                    }
                }


                this.MainDiagnosis= NewMain;

            },
            diagnosisSelect(selectedOption, id){

                if (this.FinalDiagnosis.length===1){
                    this.FinalDiagnosis[0].type= 'Pagrindinis';
                    this.FinalDiagnosis[0].time='-';
                    this.MainDiagnosis=this.FinalDiagnosis[0].code
                }else{
                    this.FinalDiagnosis[this.FinalDiagnosis.length-1].type= 'Lydinti';
                    this.FinalDiagnosis[this.FinalDiagnosis.length-1].time='-';
                }


            },
            GetList(query){
                this.DiagnosisList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a =0 ; a<this.fakelist.length ; a++ ){
                                this.DiagnosisList.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE, time:'',type:'',ClinicalName:''});
                            }
                            return  this.DiagnosisList;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }

            },
            GetFinalList(query){
                this.FinalDiagnosisList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.finalfakelist = response.data;
                            for (var a =0 ; a<this.finalfakelist.length ; a++ ){
                                this.FinalDiagnosisList.push({code:this.finalfakelist[a].CODE, title:this.finalfakelist[a].TITLE,time:'',type:'',ClinicalName:''});
                            }
                            return  this.FinalDiagnosisList;
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
