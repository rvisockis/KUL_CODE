<template>
<v-app>
    <div class="box">
        <div class="box-body">
            <div class="col-md-6" style="">
                <v-expansion-panels v-model="panels" multiple >

                    <v-expansion-panel>

                        <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-user-md</v-icon>Asmens sveikatos priežiūros įstaiga, specialistas ir pacientas</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-divider style="margin-top:-10px;"></v-divider>
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Pacientas</label>
                            </div>
                            <div class="col-md-9">
                                <b>{{patient.name}}</b>, sveikatos istorijos Nr. {{patient.patient_nr}} <br>
                                Asm. k.: {{patient.personal_id}} <br>
                                Gimimo data: {{patient.born}} <br>
                                {{patient.address}} <br>
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Specialistas</label>
                            </div>
                            <div class="col-md-9">
                                <b>{{specialist.name}}</b>, spaudo Nr. {{specialist.stamp_nr}} <br>
                                {{specialist.profession}} <br>
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Įstaiga</label>
                            </div>
                            <div class="col-md-9">
                                <b>{{institution.name}}</b><br>
                                JAR kodas {{institution.jar_code}}, SVEIDRA NR.{{institution.sveidra_nr}}<br>
                                {{institution.address}}<br>
                                Tel.: {{institution.tel}}<br>
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Darbo vieta</label>
                            </div>
                            <div class="col-md-9">
                                Nenustatyta
                            </div>
                        </v-expansion-panel-content>

                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-syringe</v-icon>Skiepas</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-divider style="margin-top:-10px;"></v-divider>
                            <div class="col-md-12" style="border-style: dotted; border-width: 1px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">{{vaccine.disease}}</label>
                            </div>
                            <div class="col-md-9">
                                {{vaccine.dose}} <span v-if="vaccine.dose < 2 ">dozė</span> <span v-if="vaccine.dose > 1 ">dozės</span> | {{vaccine.vaccine}} | {{vaccine.date_perscripted}} <br>
                                {{vaccine.specialist_profession}} {{vaccine.specialist_perscribed}} | {{vaccine.institution_name}}
                            </div>
                            </div>

                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-prescription-bottle-alt</v-icon>Imuninio vaistinio preparato informacija</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-divider style="margin-top:-10px;"></v-divider>
                            <div class="col-md-12" style="margin-bottom:-50px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Vaisto bendrinis pavadinimas</label>
                            </div>
                            <div class="col-md-9">
                               {{drug_information.name}}
                            </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-50px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">NPAKID</label>
                            </div>
                            <div class="col-md-9">
                                {{drug_information.npakid}}
                            </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-50px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Vaisto farmacinė forma</label>
                            </div>
                            <div class="col-md-9">
                                {{drug_information.pharmaceutical_form}}
                            </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-50px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Vaisto dozuočių skaičius pakuotėje</label>
                            </div>
                            <div class="col-md-9">
                                {{drug_information.doses_per_package}}
                            </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-50px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Vaisto stiprumas</label>
                            </div>
                            <div class="col-md-9">
                                {{drug_information.drug_intensity}}
                            </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                            <div class="col-md-3">
                                <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Rinkodaros teisių turėtojas, gamintojas</label>
                            </div>
                            <div class="col-md-9">
                                {{drug_information.manufacturer}}
                            </div>
                            </div>
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-info-circle</v-icon>Informacija apie skiepą</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-divider style="margin-top:-10px;"></v-divider>
                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Skiepijimo data<span class="required">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_date"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                        style="top:200px;left:300px;"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                solo
                                                class="col-md-2"
                                                style="margin-top:-15px;"
                                                v-model="vaccine_information.date"
                                                label=""
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="vaccine_information.date" no-title  locale="lt" @input="datepicker_menu_date = false" >
                                        </v-date-picker>
                                    </v-menu>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-25px; margin-left:-15px; text-align:right; ">Vaisto tinkamumo vartoti pabaigos data<span class="required">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_end_date"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                        style="top:200px;left:300px;"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                solo
                                                class="col-md-2"
                                                style="margin-top:-15px;"
                                                v-model="vaccine_information.end_date"
                                                label=""
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="vaccine_information.end_date" no-title  locale="lt" @input="datepicker_menu_end_date = false" >
                                        </v-date-picker>
                                    </v-menu>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Serijos numeris<span class="required">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <v-text-field
                                        solo
                                        class="col-md-4"
                                        style="margin-top:-15px;"
                                        v-model="vaccine_information.serial_number"
                                        label=""
                                    ></v-text-field>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-left:-15px; text-align:right; ">Įskiepijimo būdas<span class="required">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <v-select
                                        class="col-md-2"
                                        :items="methods_of_grafting"
                                        label=""
                                        solo
                                        v-model="vaccine_information.method_of_grafting"
                                    ></v-select>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Įskiepyta vakcinos dozė<span class="required">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <v-text-field
                                        solo
                                        class="col-md-6"
                                        style="margin-top:-15px;"
                                        v-model="vaccine_information.dose"
                                        label=""
                                    ></v-text-field>
                                </div>
                            </div>
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header style="font-size:15px;"><v-icon style="flex:none; margin-right:10px;">fas fa-allergies</v-icon>Reakcija į skiepą</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-divider style="margin-top:-10px;"></v-divider>
                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Reakcija į skiepą</label>
                                </div>
                                <div class="col-md-9">
                                    <v-text-field
                                        solo
                                        class="col-md-6"
                                        style="margin-top:-15px;"
                                        v-model="reaction_to_vaccine.reaction"
                                        label="Įveskite reakcijos pavadinimą"
                                    ></v-text-field>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-bottom:-20px;">
                                <div class="col-md-3">
                                    <label class="col-md-12" style="font-size:16px;font-weight:700; margin-top:-13px; margin-left:-15px; text-align:right; ">Bendros reakcijos į skiepijimą, pastabos</label>
                                </div>
                                <div class="col-md-9">
                                    <v-text-field
                                        solo
                                        class="col-md-6"
                                        style="margin-top:-15px;"
                                        v-model="reaction_to_vaccine.general_notes"
                                    ></v-text-field>
                                </div>

                                <v-btn class="col-md-6" @click="generateJSON">JSON</v-btn>
                            </div>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </div>
        </div>
    </div>
</v-app>
</template>

<script>
    export default {
        name: "Vakcinacija",
        data() {
            return {
                panels: [0,1,2,3,4],
                JSON_array: [],


                // NEW STRUCTURE
                Composition: {
                    Encounter: {
                        Organization: {
                            name: '',
                            type: '',
                            Identifier: {
                                system: '',
                                value: '',
                            }
                        },
                        Practitioner: {
                            HumanName: '',
                            Identifier: '',
                            Contact: [],
                            Specialty: {
                                code: '',
                            },
                            Qualification: {
                                licenseStatus: '',
                                code: '',
                                period: '',

                            },
                            AddressIdentifier: {
                                type: '',
                                text: '',
                                addressID: '',
                                municipalityID: '',
                                cityID: '',
                                streetID: '',
                                house: '',
                                hull: '',
                                flat: '',
                                postCode: '',
                            }

                        }
                    }
                },



                // FIRST PANEL
                patient: {
                    name: 'Regimantas Kontrimas',
                    patient_nr: 'patient-151016-00258',
                    personal_id: '38204231205',
                    born: '1982-04-23',
                    address: 'Kretinga, Guobų aklg. 17'
                },
                specialist: {
                    name: 'Regimantas Kontrimas',
                    stamp_nr: 'TestG521233',
                    profession: 'Gydytojas patologas',
                },
                institution: {
                    name: 'Viešoji įstaiga Klaipėdos universitetinė ligoninė',
                    jar_code: '190468035',
                    sveidra_nr: '450',
                    address: 'Klaipėda, Liepojos g. 41',
                    tel: '8~46 396 502'
                },
                // SECOND PANEL
                vaccine: {
                    disease: 'Difterija',
                    dose: '1',
                    vaccine: 'IMMUNAL',
                    date_perscripted: '2019-09-24 08:11',
                    specialist_perscribed: 'Regimantas Kontrimas',
                    specialist_profession: 'Gydytojas patologas',
                    institution_name: 'Viešoji įstaiga Klaipėdos universitetinė ligoninė'
                },
                // THIRD PANEL
                drug_information: {
                    name: 'Rausvažiedžių ežiuolių (Echinacea purpurea) šviežios žolės sultys (1,5-2,5:1)',
                    npakid: '1013098',
                    pharmaceutical_form: 'geriamasis tirpalas',
                    doses_per_package: '50 ml ir dozatorius N1',
                    drug_intensity: '0,8 ml/ml',
                    manufacturer: 'Sandoz d.d.'
                },
                // FOURTH PANEL
                vaccine_information: {
                    date: '',
                    end_date: '',
                    serial_number: '',
                    method_of_grafting: '',
                    dose: ''
                },
                // FIFTH PANEL
                reaction_to_vaccine: {
                    reaction: '',
                    general_notes: '',
                },

                datepicker_menu_date: false,
                datepicker_menu_end_date: false,
                methods_of_grafting: ['į burną', 'į nosį', 'į odą', 'į paodį', 'į raumenis'],

            }
        },
        methods: {

            openNotification(type, purpose) {
                if (purpose == 'required') {
                    this.$notification[type]({
                        message: 'Klaida',
                        description: 'Įsitikinkite, kad užpildyti visi privalomi laukai ir bandykite dar kartą.'
                    })
                }
                if (purpose == 'updated') {
                    this.$notification[type]({
                        message: 'Išsaugota',
                        description: 'Duomenys sėkmingai atnaujinti.'
                    })
                }

            },

            getFormattedTime(x) {
                var today = x;
                today = moment(today).format('HH:mm')
                return today;
            },

            isEmpty(array){
               for(let member in array) {
                   if(!array[member]){
                       return true;
                   }

               }
               return false;
            },

            generateESPBIstring(string, base_string){
                let connector = '. ';
                if(string) {
                    if(base_string){
                        base_string += connector;
                        base_string += string;
                    } else {
                        base_string += string;
                    }
                }

                return base_string;
            },

            generateESPBI(){

            },

            generateJSON() {
                if (this.isEmpty(this.vaccine_information)) {
                    this.openNotification('error', 'required')
                } else {

                    this.JSON_array = [],
                        this.JSON_array.push({
                            istaiga_specialistas_pacientas: {
                                pacientas: this.patient,
                                specialistas: this.specialist,
                                istaiga: this.institution
                            },
                            skiepas: this.vaccine,
                            preparato_informacija: this.drug_information,
                            informacija_apie_skiepa: this.vaccine_information,
                            reakcija_i_skiepa: this.reaction_to_vaccine
                        })


                    let json = JSON.stringify(this.JSON_array, null, 5)
                    console.log(json)
                }
            }

        },
    }
</script>

<style scoped>

    .required {
        color: red;
    }

</style>
