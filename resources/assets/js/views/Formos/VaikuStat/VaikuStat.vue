<template>
    <v-app>

        <div class="box">
            <h4 style="text-align:center; margin-bottom:40px;">PRIĖMIMO - SKUBIOSIOS PAGALBOS SKYRIAUS VAIKŲ LIGŲ GYDYTOJO
                STACIONARIZUOJAMO PACIENTO APŽIŪROS LAPAS
            </h4>
            <div class="col-md-12">
                <v-text-field class="col-md-4" v-model="Name" label="Vardas , pavardė"></v-text-field>
                <v-text-field class="col-md-4" v-model="BirthDay" label="Gimimo diena"></v-text-field>
                <v-text-field class="col-md-4" v-model="SicckensHistoryNR" label="Ligos istorijos Nr."></v-text-field>
                <multiselect class="col-md-12" v-model="FinalDiagnosis"  label="title" track-by="title" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="DiagnosisList" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false" @remove="remove"  @input="diagnosisSelect" @search-change="GetList"  >
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
<!--            Kairė-->
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
                <a-tabs>
                    <a-tab-pane key="1" tab="Pradinė informacija">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <v-textarea v-model="Complaints" label="Nusiskundimai"></v-textarea>
                            <v-textarea v-model="Illnessanamneeze" label="Ligos anamnezė"></v-textarea>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Gyvenimo anamnezė">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <v-text-field v-model="WhichChildInFamily" label="Kelintas vaikas šeimoje ?:" ></v-text-field>
                            </div>
                            <div class="col-md-6">
                                <v-checkbox label="Ar vaikas jaunesnis negu 3 metai ?" v-model="HasLittleKid"></v-checkbox>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="HasLittleKid">
                            <p>Nėštumo eiga</p>
                            <v-radio-group v-model="Pregnancy">
                                <v-radio v-for="items in PregnancyOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="PregnancyOptions==='komplikuota'">
                                <v-text-field v-model="PregnancyComplications" label="Komplikacijos:"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="HasLittleKid">
                            <p>Gimė</p>
                            <v-radio-group v-model="WasBorn">
                                <v-radio v-for="items in WasBornOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6" v-if="HasLittleKid">
                            <p>Naujagimis gimė</p>
                            <v-radio-group v-model="NewlyBorn">
                                <v-radio v-for="items in NewlyBornOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="NewlyBorn==='neišnešiotas'">
                                <v-text-field v-model="NewlyBornpremature" label="Neišnešiotas:"></v-text-field>
                            </div>
                            <div v-if="NewlyBorn==='pernešiotas'">
                                <v-text-field v-model="NewlyBornOverCarried" label="Pernešiotas:"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="HasLittleKid">
                            <p>Gimimo svoris</p>
                            <v-text-field label="Svoris:" v-model="BornWeight" ></v-text-field>

                            <v-radio-group v-model="bornComplications">
                                <v-radio v-for="items in BornCoplicationsoptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="bornComplications==='buvo'">
                                <v-text-field v-model="BornCoplicationsWas" label="Komplikacijos"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="HasLittleKid">
                            <p>Maitino motinos pienu</p>
                            <div class="col-md-6">
                                <v-text-field label="Pienu maitintas mėnesiais:" v-model="FeededMothersMilk" ></v-text-field>
                            </div>
                            <div class="col-md-6">
                                <v-text-field label="Šiuo metu maitinamas:" v-model="ATMisFeededBy" ></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p>Augo ir vystėsi</p>
                            <v-radio-group v-model="evolved">
                                <v-radio v-for="items in evolvedOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Skiepytas</p>
                            <v-radio-group v-model="vaccinated">
                                <v-radio v-for="items in vaccinatedOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="vaccinated==='buvo'">
                                <v-text-field v-model="vaccinatedReason" label="Priežastis"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p>Alergija</p>
                            <v-radio-group v-model="Alergy">
                                <v-radio v-for="items in AlergyOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="Alergy==='yra kam'">
                                <v-text-field v-model="AlargyToWhat" label="Alergija kam"></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="WasSick" label="Persirgtos ligos:"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="ChronicDiseases" label="Lėtinės ligos, vartojami medikamentai"> </v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="InjuriesOperations" label="Traumos ir operacijos"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Epid. Anamnezė</p>
                            <v-radio-group v-model="epidological">
                                <v-radio v-for="items in epidologicalOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="epidological==='buvo'">
                                <v-text-field v-model="epidologicalWas" label="Buvo: "></v-text-field>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p>TBC kontaktas</p>
                            <v-radio-group v-model="TBC">
                                <v-radio v-for="items in TBCOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <div v-if="TBC==='buvo'">
                                <v-text-field v-model="TBCwas" label="buvo"></v-text-field>
                            </div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane tab="Tyrimai" key="3">
                        <div class="col-md-6">
                            <v-checkbox v-model="BblodTest" label="1. B. kraujo tyrimas, dėl" class="col-md-12"></v-checkbox>
                            <v-checkbox v-model="CRB" label="2. CRB" class="col-md-12"></v-checkbox>
                            <v-checkbox v-model="Urinate" label="3. Šlapimas" class="col-md-12"></v-checkbox>
                            <v-checkbox v-model="lye" label="4. Šarmų- rugščių" class="col-md-12"></v-checkbox>
                            <v-checkbox v-model="glucose" label="5. Gliukozė" class="col-md-12"></v-checkbox>
                            <v-checkbox v-model="OtherTest" label="6. Kiti" class="col-md-12"></v-checkbox>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="BblodTestInfo" v-if="BblodTest" label="1. B. kraujo tyrimas, dėl" class="col-md-12"></v-text-field>
                            <v-text-field v-model="CRBInfo" v-if="CRB" label="2. CRB, dėl" class="col-md-12"></v-text-field>
                            <v-text-field v-model="UrinateInfo" v-if="Urinate" label="3. Šlapimas,  dėl" class="col-md-12"></v-text-field>
                            <v-text-field v-model="lyeInfo" v-if="lye" label="4. Šarmų- rugščių balancas, dėl" class="col-md-12"></v-text-field>
                            <v-text-field v-model="glucoseInfo" v-if="glucose" label="5. Gliukozė, dėl" class="col-md-12"></v-text-field>
                            <v-text-field v-model="OtherTestInfo" v-if="OtherTest" label=" 6. Kiti, tyrimai dėl" class="col-md-12"></v-text-field>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane tab="Baigiamoji dalis" key="4">
                        <v-textarea v-model="ConsultationAndSummary" label="Kosultantai ir jų išvados" class="col-md-12"></v-textarea>
                        <v-textarea v-model="Treatment" label="Gydymas" class="col-md-12"></v-textarea>
                        <v-textarea v-model="SendingTo" label="Stacionarizuojamas į" class="col-md-12"></v-textarea>
                    </a-tab-pane>
                </a-tabs>

            </div>
<!--            Dešinė-->
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
                <a-tabs>
                    <a-tab-pane key="1" tab="Apžiūros duomenys pirma dalis">
                        <div class="col-md-6">
                            <p>Bendra būklė</p>
                            <v-radio-group v-model="CommonState" row>
                                <v-radio v-for="items in CommonStateOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="Temperature" label="Temperatūra"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Skausmas balas</p>
                            <v-radio-group v-model="PainScale" row>
                                <v-radio v-for="items in PainScaleOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="KPL" label="KPL"></v-text-field>
                            <p>Pulsas</p>
                            <v-radio-group v-model="Pulse" row>
                                <v-radio v-for="items in PulseOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>oda</p>
                            <v-radio-group v-model="Skin" row>
                                <v-radio v-for="items in SkinOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Berimas</p>
                            <v-radio-group v-model="Rash" row>
                                <v-radio v-for="items in RashOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                                <v-text-field v-model="Rashis" label="Koks išbėrimas?" v-if="Rash==='yra'"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Audinių turgoras</p>
                            <v-radio-group v-model="Turgon" row>
                                <v-radio v-for="items in TurgonOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Odos elastingumas</p>
                            <v-radio-group v-model="Elasticity" row>
                                <v-radio v-for="items in ElasticityOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Gleivės</p>
                            <v-radio-group v-model="MucousMembranes" row>
                                <v-radio v-for="items in MucousMembranesOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-model="MucousMembranesOther" label="Kita :" v-if="MucousMembranes==='kita'"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Ležuvis</p>
                            <v-radio-group v-model="tongue" row>
                                <v-radio v-for="items in tongueOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Kataro reiškiniai</p>
                            <v-radio-group v-model="PhenomenaInQatar" row>
                                <v-radio v-for="items in PhenomenaInQatarOptions" :value="items" :label="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-if="PhenomenaInQatar=== 'taip'" v-model="PhenomenaInQatarYes" label="Taip:"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Tonzilės</p>
                            <v-radio-group v-model="tonsils" row>
                                <v-radio v-for="items in tonsilsOptions" :value="items" :label="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Kvėpavimas</p>
                            <v-radio-group v-model="breathing" row>
                                <v-radio v-for="items in breathingOptions" :label="items" :value="items" ></v-radio>
                            </v-radio-group>
                            <v-text-field class="col-md-6" v-model="KD" label="KD(k/min)"></v-text-field>
                            <v-text-field class="col-md-6" v-model="Spo2" label="SpO(2)"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="auscultation" label="Plaučių auskultacija"></v-text-field>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Apžiūros duomenys antra dalis">
                        <div class="col-md-6">
                            <p>Širdies veikla</p>
                            <v-radio-group v-model="HeartActivity">
                                <v-radio v-for="items in HeartActivityOptons" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-model="SSD" label="ŠSD(k/min)" class="col-md-6"></v-text-field>
                            <v-text-field v-model="AKS" label="AKS(mmHg)" class="col-md-6"></v-text-field>
                            <v-text-field v-model="HeartActivitySpecialCondition" label="Kiti ypatingi požymiai" class="col-md-12"></v-text-field>

                        </div>
                        <div class="col-md-6">
                            <p> Valgymas</p>
                            <v-radio-group v-model="Feed">
                                <v-radio v-for="items in FeedOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Skyščių vartojimas</p>
                            <v-radio-group v-model="LiquidConsuption">
                                <v-radio v-for="items in LiquidConsuptionOptions" :value="items" :label="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Pilvas</p>
                            <v-radio-group v-model="Belly">
                                <v-radio v-for="items in BellyOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-if="Belly==='skausmingas'" v-model="BellyHurst" label="Ką skauda? "></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="Liver" label="Kepenys"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="Spleen" label="Blužnis"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Žarnynų peristalka</p>
                            <v-radio-group v-model="CharmPeristalsis">
                                <v-radio v-for="items in CharmPeristalsisOption" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Tuštinas</p>
                            <v-radio-group v-model="Defecating">
                                <v-radio v-for="items in DefecatingOptions" :value="items" :label="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-model="DefecatingLiquid" v-if="Defecating==='skystai'" label='skystai'></v-text-field>
                            <v-text-field v-model="DefecatingObstipation" v-if="Defecating==='obstipacija'" label='obstipacija'></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Šlapinas</p>
                            <v-radio-group v-model="Urinating">
                                <v-radio v-for="items in UrinatingOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Galūnių judesiai</p>
                            <v-radio-group v-model="Limbs">
                                <v-radio v-for="items in LimbsOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-model="LimbsConfused" v-if="Limbs==='sutrikę'" label="Sutrikę :"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Sąmonės būklė</p>
                            <v-radio-group v-model="ConsciousnessState">
                                <v-radio v-for="items in ConsciousnessStateOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Meninginiai simptomai</p>
                            <v-radio-group v-model="Meninges">
                                <v-radio v-for="items in MeningesOptions" :label="items" :value="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-if="Meninges==='yra'" v-model="MeningesIs" label="yra"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>Židininė simptomatika</p>
                            <v-radio-group v-model="Fireplace">
                                <v-radio v-for="items in FireplaceOptions" :value="items" :label="items"></v-radio>
                            </v-radio-group>
                            <v-text-field v-model="FireplaceIs" v-if="Fireplace==='yra'" label="yra"></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-textarea v-model="Other" label="Kitą:"></v-textarea>
                        </div>
                    </a-tab-pane>
                </a-tabs>
            </div>

        </div>
        <v-btn v-on:click="Send" class="primary" >Siųsti</v-btn>
    </v-app>
</template>

<script>
    export default {
        name: "VaikuStat",
        data(){
            return{
                Name:[],
                BirthDay:[],
                SicckensHistoryNR:[],
                //main informations start
                CheckDate:new Date().toISOString().substr(0, 10),
                CheckMeniu:false,
                Stationary:[],
                StationaryOptions:['planine tvarka','skubos pagalba'],
                ManditoryHelp:'',
                Complaints:[],
                Illnessanamneeze:[],
                //main information end
                //life anamnesis start
                WhichChildInFamily:[],
                WhichChildInFamilyOptions:['1','2','3','4','5','6','7'],
                HasLittleKid:false,
                Pregnancy:[],
                PregnancyOptions:['normali','komplikuota'],
                PregnancyComplications:[],
                WasBorn:[],
                WasBornOptions:['natūraliai','Cezario operacija'],
                NewlyBorn:[],
                NewlyBornOptions:['išnešiotas','neišnešiotas','pernešiotas'],
                NewlyBornpremature:[],
                NewlyBornOverCarried:[],
                BornWeight:[],
                bornComplications:[],
                BornCoplicationsWas:[],
                BornCoplicationsoptions:['nebuvo','buvo'],
                FeededMothersMilk:[],
                ATMisFeededBy:[],
                evolved:[],
                evolvedOptions:['pagal amžių','vystymasis atsiliko'],
                vaccinated:[],
                vaccinatedOptions:['pagal planą','neskiepyas, neskiepyjimo priežastis'],
                vaccinatedReason:[],
                Alergy:[],
                AlergyOptions:['nėra','yra kam'],
                AlargyToWhat:[],
                WasSick:[],
                ChronicDiseases:[],
                InjuriesOperations:[],
                epidological:[],
                epidologicalWas:[],
                epidologicalOptions:['kontakto nebuvo','nežino','buvo'],
                TBC:[],
                TBCwas:[],
                TBCOptions:['nebuvo','nežino','buvo'],
            //    end of life anamnesis
            //    Start of check data

                CommonState: [],
                CommonStateOptions: ['gera','patenkinama','vidutinė','sunki','kraštutinai sunki'],
                Temperature:[],
                PainScale:[],
                PainScaleOptions:['0','1','2','3','4','5','6','7','8','9','10'],
                KPL:[],
                Pulse:[],
                PulseOptions:['normalus','silpnas','nečiuopiamas'],
                Skin:[],
                SkinOptions:['šilta','vėsi','rausva','blyški','marmuruota'],
                Rash:[],
                RashOptions:['nėra','yra'],
                Rashis:[],
                Turgon:[],
                TurgonOptions:['išlaikytas','sumažėjęs'],
                Elasticity:[],
                ElasticityOptions:['normalus','sumažėjęs'],
                MucousMembranes:[],
                MucousMembranesOptions:['drėgnos','sausos','bėrimas','kita'],
                MucousMembranesOther:[],
                tongue:[],
                tongueOptions:['drėgnas','sausas','su apnašu'],
                PhenomenaInQatar:[],
                PhenomenaInQatarOptions:['ne','taip'],
                PhenomenaInQatarYes:[],
                tonsils:[],
                tonsilsOptions:['ramios','paraudusios','hipertrofiškos','su pūlinukais','pūlingu apnašu'],
                breathing:[],
                breathingOptions:['normalus','stridoras','švokštimas','kvėpavine dalyvauja pagalbiniai raumenys'],
                KD:[],
                Spo2:[],
                auscultation:[],
                HeartActivity:[],
                HeartActivitySpecialCondition:[],
                HeartActivityOptons:['ritmiška','aritmiška'],
                SSD:[],
                AKS:[],
                Feed:[],
                FeedOptions:['kaip įprastai','pablogėjęs','nevalgo'],
                LiquidConsuption:[],
                LiquidConsuptionOptions:['kaip įprastai','pablogėjęs','negeria'],
                Belly:[],
                BellyOptions:['neskausmingas','skausmingas'],
                BellyHurst:[],
                Liver:[],
                Spleen:[],
                CharmPeristalsis:[],
                CharmPeristalsisOption:['yra','nėra','vangi','pagyvėjusi'],
                Defecating:[],
                DefecatingObstipation:[],
                DefecatingLiquid:[],
                DefecatingOptions:['įprastai','skystai','obstipacija'],
                Urinating:[],
                UrinatingOptions:['įprastai','dizurija','sumažėjusi diurezė','anurija','retencija'],
                Limbs:[],
                LimbsConfused:[],
                LimbsOptions:['laisvi','sutrikę'],
                ConsciousnessState:[],
                ConsciousnessStateOptions:['reakcija į aplinką adekvati','vangus','sudirgęs','mieguistas','be sąmonės'],
                Meninges:[],
                MeningesOptions:['nėra','abejotini','yra'],
                MeningesIs:[],
                Fireplace:[],
                FireplaceOptions:['nėra','abejotina','yra'],
                FireplaceIs:[],
                Other:[],
            //    End of check data
            //Start of Final info
                BblodTest:false,
                BblodTestInfo:[],
                CRBInfo:[],
                CRB:false,
                Urinate:false,
                UrinateInfo:[],
                lye:false,
                lyeInfo:[],
                glucoseInfo:[],
                glucose:false,
                OtherTest:false,
                OtherTestInfo:[],
                ConsultationAndSummary:[],
                Diagnosis:[],
                DiagnosisList:[],
                fakelist:[],
                Treatment:[],
                SendingTo:[],
            //  End of Final info
            //JSON
                JSONarray:[],
                AlergijaText:'',
                SpecelistuKonsultacijosText:'',
                TaikytasGydimasText:'',
                GydymoRekomendacijosTXT:'',
                SpecialistuKonsultacijosIsvadosTXT:'',
                DiagnozesTXT:{},
                BuklesIvertinimasAktyvusTXT:'',
                AnamnezesTXT:'',

                FinalDiagnosis:[],
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
        methods:{
            CreateText(){},
            Send(){
                console.log(this.Diagnosis.length) ;
                this.JSONarray=[];
                    this.DiagnozesTXT= ' kodas: '+ this.Diagnosis.code+' pavadinimas: '+this.Diagnosis.name;
                if (this.ConsultationAndSummary.length>0){
                    this.SpecialistuKonsultacijosIsvadosTXT= this.ConsultationAndSummary;
                }else{
                    this.TaikytasGydimasText='-';
                }
                if (this.Alergy==='yra kam'){
                    console.log(this.AlargyToWhat)
                    var text= toString(this.AlargyToWhat)
                    this.AlergijaText='Alergija yra: '+ this.AlargyToWhat
                }else{
                    this.AlergijaText='Alergijos nėra';
                }
                if (this.Treatment.length>0){
                    this.TaikytasGydimasText='Taikytas gydymas: '+ this.Treatment;
                }else{
                    this.TaikytasGydimasText='-'
                }
                if (this.SendingTo.length>0){
                    this.GydymoRekomendacijosTXT='Siunčiama į: '+ this.SendingTo
                }else {
                    this.GydymoRekomendacijosTXT='-'
                }
                this.BuklesIvertinimasAktyvusTXT=this.GetStateConcusionTXT();
                this.AnamnezesTXT= this.GetAnamnesisText();
                this.JSONarray.push({
                    ToDB:{
                        Name:this.Name,
                        BirthDay: this.BirthDay,
                        CheckDate: this.CheckDate,
                        HospitalizationDiagnosis: this.Diagnosis,
                        SendingTo: this.SendingTo,
                        Treatment: this.Treatment,
                        CommonState:this.CommonState,
                        Temperature: this.Temperature,
                        PainScale:this.PainScale,
                        KPL:this.KPL,
                        Pulse:this.Pulse,
                        Skin: this.Skin,
                        Rash:this.Rash,
                        Rashis:this.Rashis,
                        MucousMembranesOther:this.MucousMembranesOther,
                        Turgon:this.Turgon,
                        SkinElasticly:this.Elasticity,
                        MucousMembranes: this.MucousMembranes,
                        tongue: this.tongue,
                        PhenomenaInQatar: this.PhenomenaInQatar,
                        PhenomenaInQatarYes:this.PhenomenaInQatarYes,
                        tonsils: this.tonsils,
                        breathing: this.breathing,
                        KD:this.KD,
                        Spo2: this.Spo2,
                        auscultation: this.auscultation,
                        HeartActivity:this.HeartActivity,
                        SSD:this.SSD,
                        AKS:this.AKS,
                        HeartActivitySpecialCondition:this.HeartActivitySpecialCondition,
                        Feed:this.Feed,
                        LiquidConsuption:this.LiquidConsuption,
                        Belly:this.Belly,
                        BellyHurst:this.BellyHurst,
                        Liver:this.Liver,
                        Spleen:this.Spleen,
                        CharmPeristalsis:this.CharmPeristalsis,
                        Defecating:this.Defecating,
                        DefecatingLiquid:this.DefecatingLiquid,
                        DefecatingObstipation:this.DefecatingObstipation,
                        Urinating:this.Urinating,
                        Limbs:this.Limbs,
                        LimbsConfused:this.LimbsConfused,
                        ConsciousnessState:this.ConsciousnessState,
                        Meninges:this.Meninges,
                        MeningesIs:this.MeningesIs,
                        Fireplace:this.Fireplace,
                        FireplaceIs:this.FireplaceIs,
                        BblodTest:this.BblodTest,
                        CRB:this.CRB,
                        Urinate:this.Urinate,
                        lye:this.lye,
                        glucose:this.glucose,
                        OtherTest:this.OtherTest,
                        BblodTestInfo:this.BblodTestInfo,
                        CRBInfo:this.CRBInfo,
                        UrinateInfo:this.UrinateInfo,
                        lyeInfo:this.lyeInfo,
                        glucoseInfo:this.glucoseInfo,
                        OtherTestInfo:this.OtherTestInfo,
                        WhichChildInFamily:this.WhichChildInFamily,
                        HasLittleKid:this.HasLittleKid,
                        Pregnancy:this.Pregnancy,
                        PregnancyComplications:this.PregnancyComplications,
                        WasBorn:this.WasBorn,
                        NewlyBorn:this.NewlyBorn,
                        NewlyBornpremature:this.NewlyBornpremature,
                        NewlyBornOverCarried:this.NewlyBornOverCarried,
                        BornWeight:this.BornWeight,
                        bornComplications:this.bornComplications,
                        BornCoplicationsWas:this.BornCoplicationsWas,
                        FeededMothersMilk:this.FeededMothersMilk,
                        ATMisFeededBy:this.ATMisFeededBy,
                        evolved:this.evolved,
                        vaccinated:this.vaccinated,
                        vaccinatedReason:this.vaccinatedReason,
                        Complaints:this.Complaints,
                        Illnessanamneeze:this.Illnessanamneeze,
                    },
                    Anamneze:this.AnamnezesTXT,
                    Alergijos:this.AlergijaText,
                    BuklesIvertinimasAktyvus:this.BuklesIvertinimasAktyvusTXT,
                    AktiviuLaboratoriniuIrInstrumentiniuTyrimuInformacija:{},
                    SpecialistuKonsultacijos:this.SpecialistuKonsultacijosIsvadosTXT,
                    Diagnozes:this.FinalDiagnosis,
                    TaikytasGydimas:this.TaikytasGydimasText,
                    GydymoRekomendacijos:this.GydymoRekomendacijosTXT,

                })

                var json = JSON.stringify(this.JSONarray, null, 10)
                console.log('JSON: ' + json)
            },
            GetAnamnesisText(){
                var ats ='';
                ats = ' Nusiskundimai: '+this.Complaints+ ats;
                ats=' Ligos Anamnezė: '+this.Illnessanamneeze+ats;
                ats = ' Stacionarizuojamas : '+this.Illnessanamneeze+ats;
                ats=' Apžiūros data: '+this.CheckDate.toString()+ats;
                return ats;
            },
            GetStateConcusionTXT(){

                var ats =''
                ats = 'Bendra būklė yra '+this.CommonStateOptions+' '+ats;
                ats = ' Temperatūra yra ' + this.Temperature+' '+ats;
                ats= ' Skausmas balais: ' +this.PainScale+' '+ats;
                ats= ' KPL: '+this.KPL+' '+ats;
                ats= ' Pulsas : '+this.Pulse+' '+ats;
                ats= ' Oda yra: '+this.Skin+' '+ats;
                if (this.Rash==='yra'){
                    ats=' Pabėrimas yra: '+this.Rashis+ats;
                }else{
                    ats= ' Pabėrimo nėra '+ats;
                }
                ats= ' Audinių turgonas '+this.Turgon+ats;
                ats= ' Elastingumas: '+this.Elasticity+ats;
                if (this.MucousMembranes==='kita'){
                    ats=' Gleivinės: '+this.MucousMembranesOther+ ats;
                }else{
                    ats =' Gleivinės: '+this.MucousMembranes+ats;
                }
                ats=' Ležuvis: '+this.tongue+ats;
                if (this.PhenomenaInQatar==='taip'){
                    ats= ' Kataro reiškiniai'+this.PhenomenaInQatarYes+ats;
                }else{
                    ats=' Kataro reiškinių nėra'+ats;
                }
                ats=' Tonzilė: '+this.tonsils+ats;
                ats=' Kvepavimas: '+this.breathing +ats;
                ats = ' KD: '+this.KD+ats;
                ats = ' Spo2: '+this.Spo2+ats;
                ats=  ' Plaučių auskultacija '+ this.auscultation+ats;
                if (this.HeartActivitySpecialCondition.length>0){
                    ats = ' Šridies veikla: '+this.HeartActivity+' ŠSD '+this.SSD+' AKS '+this.AKS +'Speciali kondicija: '+ats

                }else{
                    ats = ' Šridies veikla: '+this.HeartActivity+' ŠSD '+this.SSD+' AKS '+this.AKS +ats
                }
                ats = ' Valgymas ' + this.Feed +ats;
                ats =' Skyščių vartojimas: '+this.LiquidConsuption+ats;
                if (this.Belly==='skausmingas'){
                    ats= ' Pilvas '+this.Belly+' '+this.BellyHurst+ats
                }else{
                    ats= ' Pilvas'+this.Belly+ats;
                }
                ats = ' Kepenys '+this.Liver+ats;
                ats =' Blužnis'+this.Spleen+ats;
                ats=' Žarnų peristalka '+this.CharmPeristalsis+ats;
                if (this.Defecating==='skystai'){
                    ats=' Tuštinasi: '+this.Defecating+': '+this.DefecatingLiquid+ats;
                }else if(this.Defecating==='obstipacija'){
                    ats=' Tuštinasi: '+this.Defecating+': '+this.DefecatingObstipation+ats;
                }else{
                    ats=' Tuštinasi: '+ats;}
                ats = ' Šlapinasi: '+this.Urinate+ats;
                if (this.Limbs==='sutrikę'){
                    ats=' Galūnių judesiai: '+this.Limbs+' , '+this.LimbsConfused+ats;
                }else{
                    ats=' Galūnių judesiai: '+this.Limbs+ats;
                }
                ats =' Sąmonės būklė: '+this.ConsciousnessState+ats;
                if (this.Meninges==='yra'){
                    ats=' Meninginiai simptomai: '+this.Meninges+' : '+this.MeningesIs+ats;
                }else{
                    ats=' Meninginiai simptomai: '+this.Meninges+ats;
                }
                if (this.Fireplace==='yra'){
                    ats= ' Židininė simptomatika:  '+this.Fireplace+' : '+this.FireplaceIs+ats;
                }
                if (this.Other.length>0){
                    ats= ' Kita: '+this.Other+ats;
                }
                return  ats;
            },
            GetList(query){
                this.DiagnosisList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a =0 ; a<this.fakelist.length ; a++ ){
                                this.DiagnosisList.push({code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE,time:'',type:'',ClinicalName:''})   ;
                            }
                            return  this.DiagnosisList;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }

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
        },
        beforeMount() {
        }
    }
</script>

<style scoped>

</style>
