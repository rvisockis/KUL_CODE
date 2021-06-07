<template>
    <v-app>
   <div class="box">
       <div class="box-body">

           <div class="col-sm-12" v-if="!pacientas_pasirinktas" >
               <v-toolbar flat color="white">

                   <v-toolbar-title>Sukurtų traumatologų formų sąrašas</v-toolbar-title>
                   <v-dialog v-model="dialog" persistent style="height:500px;">
                   <template v-slot:activator="{ on }">
                   <v-btn v-on="on" primary style="margin-left:20px;">Sukurti naują formą</v-btn>
                   </template>

                       <v-card>
                           <v-card-title class="headline grey ligthen-2" primary-title>Nauja forma</v-card-title>
                           <v-card-text>
                               <v-container>
                                   <v-row>
                                       <v-col cols="12" sm="6" md="6">
                                           <v-text-field v-model="ligos_atvejo_numeris" label="Ligos atvejo numeris*" hint="A-3******"></v-text-field>
                                       </v-col>
                                       <v-col cols="12" sm="6" md="6">
                                           <v-text-field v-model="asmens_kodas" label="Asmens kodas*"></v-text-field>
                                       </v-col>

                                   </v-row>
                               </v-container>
                               <p>*privalomi laukai</p>
                               <p v-if="nauja_forma_neuzpildyta" style="color:red;">Užpildykite privalomus laukus!</p>
                           </v-card-text>
                           <v-divider></v-divider>
                           <v-card-actions>
                               <v-spacer></v-spacer>
                               <v-btn color="primary" text @click="dialog = false">Atšaukti</v-btn>
                               <v-btn color="primary" text @click="createNewForm(ligos_atvejo_numeris, asmens_kodas)">Sukurti ir pildyti</v-btn>
                           </v-card-actions>
                       </v-card>

                   </v-dialog>
                   <v-spacer></v-spacer>
                   <v-text-field
                       class="col-md-3"
                       v-model="search"
                       append-icon="fas fa-search"
                       label="Paieška"
                       single-line
                       hide-details
                   ></v-text-field>
               </v-toolbar>
               <v-data-table
                   :headers="headers_formos_pasirinkimas"
                   :items="formos_list"
                   class="elevation-1"
                   :items-per-page-options=[15]
                   :search="search"
                   style="margin-top:20px;"
               >
                   <template v-slot:items="props">
                       <td class="text-xs-left">{{ props.item.asmens_kodas }}</td>
                       <td class="text-xs-left">{{ props.item.ligos_atvejo_nr }}</td>
                       <td class="text-xs-left">{{ props.item.busena }}</td>
                   </template>
                   <template v-slot:item.action="{ item }">
                       <v-icon
                           small
                           @click="editForm(item.id)"
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

           </div>

<transition name="slide-fade">
           <div class="box-body" v-if="pacientas_pasirinktas">
<div class="col-md-12">
    <h5 class="col-md-12" style="text-align:center; margin-bottom:40px;">Priėmimo - skubiosios pagalbos skyriaus gydytojo traumatologo - ortopedo paciento apžiūros, tyrimo ir gydymo lapas</h5>
    <div class="col-md-12">
        <v-btn class="col-md-1" style="margin-left:70%; display:inline-block; font-size:12px;"  large depressed color="error" @click="pacientas_pasirinktas = false">Atšaukti</v-btn>
        <v-btn class="col-md-1" style="margin-left:15px; display:inline-block; font-size:12px;"  large color="warning" @click="checkRequired">Patikrinti</v-btn>
        <v-btn v-if="requiredFilled" class="col-md-1" style="margin-left:15px; display:inline-block; font-size:12px;"  large color="primary" @click="generateJSON">Užbaigti</v-btn>
        <v-btn v-if="!requiredFilled" class="col-md-1" style="margin-left:15px; display:inline-block; font-size:12px;"  large depressed disabled @click="generateJSON">Užbaigti</v-btn>

    </div>
        <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:1px; margin-left:-20px; margin-right:15px;">
            <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Pradinė informacija</label>
        <v-text-field
            v-model="vardas_pavarde"
            label="Vardas, pavardė"
            class="col-md-6"
        ></v-text-field>
<!--            Pakeiciau is med_dok_nr i ligos_atvejo_numeris-->
        <v-text-field
            v-model="ligos_atvejo_numeris"
            label="Medicininio dokumento Nr."
            class="col-md-6"
        ></v-text-field>
        <div class="col-md-12">
            <label class="col-md-2" style="font-weight:500; margin-top:15px; margin-left:-15px;">Apžiūros data: </label>
            <!--               <v2-datepicker-->
            <!--                   v-model="apziuros_data"-->
            <!--                   class="col-sm-3" :lang="lang"-->
            <!--                   :customLocals="locals"-->
            <!--                   placeholder="Data"-->
            <!--                   :picker-options="pickerOptions2"-->
            <!--                   style="margin-left:15px;"></v2-datepicker>-->
            <v-menu
                ref="menu"
                v-model="datepicker_menu_apziuros_data"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="290px"
                style="top:200px;left:300px;"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        class="col-md-2"
                        style="margin-top:5px;"
                        v-model="apziuros_data"
                        label=""
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="apziuros_data" no-title  locale="lt" @input="datepicker_menu_apziuros_data = false">
                </v-date-picker>
            </v-menu>



            <a-time-picker format="HH:mm"
                           class="col-md-2"
                           v-model="apziuros_laikas"
                           placeholder="Laikas"
                           style="margin-left:10px; margin-top:20px;"/>
            <v-text-field
                class="col-md-6"
                v-model="but_pagalbos_kat"
                label="Būtinosios pagalbos kategorija:"
            ></v-text-field>

            <v-divider class="col-md-12" style="margin-left:-15px;"></v-divider>
            <div class="col-md-12"><h4 style="text-align:center;">Diagnozės</h4></div>
            <multiselect class="col-md-12" style="margin-left:-10px;" v-model="tlk_10_am"  label="name" track-by="name" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="diagnosis_list" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false" @remove="remove"  @input="diagnosisSelect" @search-change="GetList"  >

                <template slot="noOptions">
                    <span>Sąrašas tuščias.</span>
                </template>

                <template slot="noResult">
                    <span>Tokia diagnozė nerasta. Pabandykite pakeisti paieškos užklausą.</span>
                </template>
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
                    :items="tlk_10_am"
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
                    <template slot="no-data">
                        <span>Diagnozių sąrašas tuščias.</span>
                    </template>
                </v-data-table>
            </div>

        </div>
        <div class="col-md-12">
            <v-divider></v-divider>
            <a-tabs style="padding:4px;">
                <a-tab-pane tab="Nusiskundimai" key="1">
                    <v-textarea
                        v-model="nusiskundimai"
                        name="input-7-4"
                        label="NUSISKUNDIMAI"
                    ></v-textarea>
                </a-tab-pane>

                <a-tab-pane tab="Kada, kur įvyko trauma" key="2">
                    <div class="col-md-6">

                        <label class="col-md-2">Traumos data: </label>
                        <v-menu
                            ref="menu"
                            v-model="datepicker_menu_traumos_data"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                            style="top:200px;left:300px;"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    class="col-md-4"
                                    style="margin-top:-10px; margin-left:15px;"
                                    v-model="traumos_data"
                                    label=""
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="traumos_data" no-title  locale="lt" @input="datepicker_menu = false">
                            </v-date-picker>
                        </v-menu>
                        <a-time-picker format="HH:mm"
                                       class="col-md-5"
                                       v-model="traumos_laikas"
                                       placeholder="Laikas"
                                       style="margin-left:10px;"/>

                    <v-text-field
                        v-model="traumos_vieta"
                        label="Traumos vieta:"
                        class="col-md-12"
                    ></v-text-field>
                    <v-text-field
                        v-model="traumos_aplinkybes"
                        label="Traumos aplinkybės:"
                        class="col-md-12"
                    ></v-text-field>
                    </div>
                    <div class="col-md-6">
                    <v-checkbox
                        v-model="tyrimai_alkoholiui_narkotikams"
                        label="Tyrimai alkoholiui, narkotikams paimti"
                        class="col-md-12"
                        ></v-checkbox>
                    <v-checkbox
                        v-model="policija_informuota"
                        :label="`Policija informuota`"
                        class="col-md-12"
                    ></v-checkbox>
                    <v-checkbox
                        v-model="vaiku_teises"
                        :label="`Vaikų teisių apsaugos tarnyba informuota`"
                        class="col-md-12"
                    ></v-checkbox>
                    </div>
                </a-tab-pane>

                <a-tab-pane tab="Traumos vieta" key="4">
                    <div class="container col-md-12" style="margin-top:-20px;">
                        <h4 style="text-align:center; margin-top:20px;">Traumos vieta</h4>
                        <div class="col-md-12" style="margin-bottom:40px;" v-if="isSelected_part">
                            <div class="col-md-2">{{selected_part}}</div>
                            <v-select
                                class="col-md-10"
                                v-model="selectedHumanPartParams"
                                :items="humanPartParams"
                                :multiple=true
                                @blur="humanPartSelectParams(selectedHumanPartParams)"
                            >
                            </v-select>
                        </div>
                        <img src="./zmogus2.jpg" usemap="#image-map">
                        <map name="image-map">

                            <area alt="1. Akis ir periokulinė sritis (dešinė)" title="1. Akis ir periokulinė sritis (dešinė)" coords="127,88,119,83,109,87,105,96,107,106,115,111,122,109,129,100" shape="poly" @click="humanPartSelect('Akis - dešinė')" >
                            <area target="" @click="humanPartSelect('Akis - dešinė, priekis')" alt="1. Akis ir periokulinė sritis  (dešinė - priekis)" title="1. Akis ir periokulinė sritis  (dešinė - priekis)" coords="292,61,284,51,276,58,282,67" shape="poly">
                            <area target="" alt="2. Nosis" title="2. Nosis" coords="132,98,126,107,122,116,121,125,128,126,136,125,143,117,141,108" shape="poly" @click="humanPartSelect('Nosis - dešinė')">
                            <area target="" @click="humanPartSelect('Nosis - priekis')" alt="2. Nosis" title="2. Nosis" coords="294,64,288,75,300,75" shape="poly">
                            <area target="" @click="humanPartSelect('Lūpos - dešinė')" alt="3. Lūpos" title="3. Lūpos" coords="133,127,120,129,116,138,122,141,133,141" shape="poly">
                            <area target="" @click="humanPartSelect('Lūpos - priekis')" alt="3. Lūpos" title="3. Lūpos" coords="287,77,299,77,293,82" shape="poly">
                            <area target="" @click="humanPartSelect('Skruostas - dešinė')" alt="4. Skruostas (dešinė)" title="4. Skruostas (dešinė)" coords="105,109,93,116,97,130,119,127,117,114" shape="poly">
                            <area target="" @click="humanPartSelect('Skruostas - kairė, priekis')" alt="4. Skruostas (kairė - priekis)" title="4. Skruostas (kairė - priekis)" coords="299,67,306,64,312,67,306,75" shape="poly">
                            <area target="" @click="humanPartSelect('Smakras - dešinė')" alt="5. Smakras (dešinė)" title="5. Smakras (dešinė)"  coords="128,145,115,142,104,156,113,161,128,159" shape="poly">
                            <area target="" @click="humanPartSelect('Smakras - priekis')" alt="5. Smakras (priekis)" title="5. Smakras (priekis)" coords="283,85,302,85,292,91,283,85" shape="poly">
                            <area target="" @click="humanPartSelect('Apatinis žandikaulis - dešinė')" alt="6. Apatinis žandikaulis (dešinė)" title="6. Apatinis žandikaulis (dešinė)" coords="80,130,96,133,112,141,101,152,87,145,79,138" shape="poly">
                            <area target="" @click="humanPartSelect('Kakta - dešinė')" style="color:black;" alt="7. Kakta (dešinė)" title="7. Kakta (dešinė)" coords="100,45,89,71,98,76,105,81,108,85,116,79,126,80,122,65,116,55" shape="poly">
                            <area target="" @click="humanPartSelect('Kakta - priekis')" alt="7. Kakta (priekis)" title="7. Kakta (priekis)" coords="274,45,287,46,303,46,312,46,306,38,295,33,283,34" shape="poly">
                            <area target="" @click="humanPartSelect('Momens sritis - dešinė')" alt="8. Momens sritis (dešinė)" title="8. Momens sritis (dešinė)" coords="97,46,86,69,74,70,61,70,45,75,40,63,41,54,51,47,68,42" shape="poly">
                            <area target="" @click="humanPartSelect('Momens sritis - viršus')" alt="8. Momens sritis (viršus)" title="8. Momens sritis (viršus)" coords="507,45,510,51,519,50,526,51,529,45,519,41" shape="poly">
                            <area target="" @click="humanPartSelect('Pakaušis - dešinė')" alt="9. Pakaušis (dešinė)" title="9. Pakaušis (dešinė)" coords="42,77,39,88,36,99,37,110,39,118,25,106,24,91,26,78,35,61" shape="poly">
                            <area target="" @click="humanPartSelect('Pakaušis - galas')" alt="9. Pakaušis (galas)" title="9. Pakaušis (galas)" coords="507,58,518,54,532,60,530,70,518,70,507,70" shape="poly">
                            <area target="" @click="humanPartSelect('Smilkinys - dešinė')" alt="10. Smilkinys (dešinė)" title="10. Smilkinys (dešinė)" coords="43,101,42,83,72,72,98,81,83,98,67,84" shape="poly">
                            <area target="" @click="humanPartSelect('Smilkinys - kairė')" alt="10. Smilkinys (kairė)" title="10. Smilkinys (kairė)" coords="503,53,505,70,505,70,499,65" shape="poly">
                            <area target="" @click="humanPartSelect('Ausies kaušelis - dešinė')" alt="11. Ausies kaušelis (dešinė)" title="11. Ausies kaušelis (dešinė)" coords="74,104,66,92,55,96,52,104,57,114,60,121,67,129,76,127,77,118" shape="poly">
                            <area target="" @click="humanPartSelect('Kaklas - kairė')" alt="12. Kaklas (kairė)" title="12. Kaklas (kairė)" coords="83,432,98,428,115,418,126,410,148,402,142,420,142,432,145,446,127,450,106,454,90,456" shape="poly">
                            <area target="" @click="humanPartSelect('Kaklas - nugara')" alt="12. Kaklas (nugara)" title="12. Kaklas (nugara)" coords="506,83,507,74,533,74,534,81,532,92,531,101,521,101,509,101" shape="poly">
                            <area target="" @click="humanPartSelect('Petis - kairė, priekis')" alt="13. Petis (kairė - priekis)" title="13. Petis (kairė - priekis)" coords="314,105,300,105,310,117,329,113" shape="poly">
                            <area target="" @click="humanPartSelect('Petis - kairė, nugara')" alt="13. Petis (kairė - nugara)" title="13. Petis (kairė - nugara)" coords="502,111,490,119,504,123,515,114" shape="poly">
                            <area target="" @click="humanPartSelect('Žastas - kairė')" alt="14. Žastas (kairė)" title="14. Žastas (kairė)" coords="333,132,348,130,351,141,350,154,350,174,348,187,342,188,334,190,333,179,336,162" shape="poly">
                            <area target="" @click="humanPartSelect('Žastas - kairė, nugara')" alt="14. Žastas (kairė - nugara)" title="14. Žastas (kairė - nugara)" coords="470,138,482,154,485,177,484,195,478,194,470,191,470,170,470,159" shape="poly">
                            <area target="" @click="humanPartSelect('Dilbis - kairė')" alt="15. Dilbis (kairė)" title="15. Dilbis (kairė)" coords="334,203,356,197,368,242,356,247,342,225" shape="poly">
                            <area target="" @click="humanPartSelect('Dilbis - kairė, nugara')" alt="15. Dilbis (kairė - nugara)" title="15. Dilbis (kairė - nugara)" coords="463,207,482,217,466,251,455,248,461,231" shape="poly">
                            <area target="" @click="humanPartSelect('Plaštaka - kairė, priekis')" alt="16. Plaštaka (kairė - priekis)" title="16. Plaštaka (kairė - priekis)" coords="358,263,376,259,392,277,392,284,382,278,382,295,377,303,366,294,362,287,358,274" shape="poly">
                            <area target="" @click="humanPartSelect('Plaštaka - kairė, nugara')" alt="16. Plaštaka (kairė - nugara)" title="16. Plaštaka (kairė - nugara)" coords="450,260,464,263,465,276,462,288,459,296,453,300,450,303,445,294,445,277,436,283,432,283,441,271" shape="poly">
                            <area target="" @click="humanPartSelect('Krūtinės ląst. - priekis')" alt="17. Krūtinės ląst. (priekis)" title="17. Krūtinės ląst. (priekis)" coords="281,118,287,128,286,142,289,159,292,168,298,158,300,147,298,135,299,125,303,118" shape="poly">
                            <area target="" @click="humanPartSelect('Krūtinės ląst - nugara')" alt="17. Krūtinės ląst. (nugara)" title="17. Krūtinės ląst. (nugara)" coords="513,121,526,121,526,129,526,138,526,146,522,154,515,147,513,138,513,130" shape="poly">
                            <area target="" @click="humanPartSelect('Pilvas - priekis')" alt="18. Pilvas (priekis)" title="18. Pilvas (priekis)" coords="262,191,276,184,291,170,305,181,320,193,326,209,317,218,309,230,295,236,279,232,269,219,261,209" shape="poly">
                            <area target="" @click="humanPartSelect('Juosmuo - nugara')" alt="19. Juosmuo (nugara)" title="19. Juosmuo (nugara)" coords="488,164,523,165,554,162,550,199,522,197,492,198" shape="poly">
                            <area target="" @click="humanPartSelect('Kryžmuo')" alt="20. Kryžmuo" title="20. Kryžmuo"  coords="499,204,540,204,529,216,521,231,513,215" shape="poly">
                            <area target=""  @click="humanPartSelect('Sėdmuo - kairė')" alt="21. Sėdmuo (kairė)" title="21. Sėdmuo (kairė)"  coords="487,216,495,209,506,213,512,221,514,228,518,237,520,247,520,258,514,266,504,265,494,260,485,256,486,237" shape="poly">
                            <area target=""  @click="humanPartSelect('Sėdmuo - dešinė')" alt="21. Sėdmuo (dešinė)" title="21. Sėdmuo (dešinė)"  coords="554,224,548,213,538,210,530,222,530,228,531,237,528,244,524,251,524,259,527,263,534,265,543,266,548,263,554,260,557,252,556,237" shape="poly">
                            <area target=""  @click="humanPartSelect('Išoriniai lyt. org.')" alt="22. Išoriniai lyt. org." title="22. Išoriniai lyt. org."  coords="282,239,287,248,293,254,299,248,304,240" shape="poly">
                            <area target=""  @click="humanPartSelect('Šlaunis - dešinė, priekis')" alt="23. Šlaunis (dešinė - priekis)" title="23. Šlaunis (dešinė - priekis)"  coords="257,221,275,235,286,255,289,270,290,302,287,314,289,328,279,331,266,331,259,309,253,283,251,264,252,239" shape="poly">
                            <area target=""  @click="humanPartSelect('Šlaunis - kairė, galas')" alt="23. Šlaunis (kairė - galas)" title="23. Šlaunis (kairė - galas)"  coords="485,266,498,270,518,272,520,293,519,313,519,325,509,328,496,330,489,305,485,285" shape="poly">
                            <area target=""  @click="humanPartSelect('Kelias - dešinė, priekis')" alt="24. Kelias (dešinė - priekis)" title="24. Kelias (dešinė - priekis)"  coords="265,334,280,335,290,332,290,344,289,354,285,358,274,358,265,357,266,349" shape="poly">
                            <area target=""  @click="humanPartSelect('Kelias - kairė, galas')" alt="24. Kelias (kairė - galas)" title="24. Kelias (kairė - galas)"  coords="499,336,510,335,520,333,520,342,520,356,517,365,511,365,501,365,501,354" shape="poly">
                            <area target=""  @click="humanPartSelect('Blauzda - dešinė, priekis')" alt="25. Blauzda (dešinė - priekis)" title="25. Blauzda (dešinė - priekis)"  coords="264,361,274,362,285,363,292,387,287,399,288,416,286,428,274,428,269,407,264,383,261,373" shape="poly">
                            <area target=""  @click="humanPartSelect('Blauzda - kairė, galas')" alt="25. Blauzda (kairė - galas)" title="25. Blauzda (kairė - galas)"  coords="499,369,518,369,518,386,520,398,520,417,505,421,503,406,499,384" shape="poly">
                            <area target=""  @click="humanPartSelect('Čiurna - dešinė, priekis')" alt="26. Čiurna (dešinė - priekis)" title="26. Čiurna (dešinė - priekis)"  coords="274,430,287,430,290,442,274,442" shape="poly">
                            <area target=""  @click="humanPartSelect('Čiurna - kairė, galas')" alt="26. Čiurna (kairė - galas)" title="26. Čiurna (kairė - galas)"  coords="506,424,519,420,517,432,519,441,510,444,509,434" shape="poly">
                            <area target=""  @click="humanPartSelect('Pėda - dešinė, viršus')" alt="27. Pėda (dešinė - viršus)" title="27. Pėda (dešinė - viršus)"  coords="274,447,290,447,290,455,290,465,289,475,287,486,278,486,273,483,267,478,266,471,270,459" shape="poly">
                            <area target=""  @click="humanPartSelect('Pėda - kairė, apačia')" alt="27. Pėda (kairė - apačia)" title="27. Pėda (kairė - apačia)"  coords="510,448,520,443,520,451,518,458,523,466,523,475,519,485,512,485,506,483,503,478,503,467" shape="poly">
                            <area target=""  @click="humanPartSelect('Alkūnė - dešinė, galas')" alt="28. Alkūnė (dešinė - galas)" title="28. Alkūnė (dešinė - galas)"  coords="555,192,562,188,572,189,572,197,578,203,580,210,571,218,560,219,559,210,558,200" shape="poly">
                            <area target=""  @click="humanPartSelect('Alkūnė - kairė, priekis')" alt="28. Alkūnė (kairė - priekis)" title="28. Alkūnė (kairė - priekis)"  coords="333,192,342,191,350,189,351,194,336,200" shape="poly">
                            <area target=""  @click="humanPartSelect('Riešas - dešinė, galas')" alt="29. Riešas (dešinė - galas)" title="29. Riešas (dešinė - galas)"  coords="590,253,578,257,581,263,580,268,596,263,592,259" shape="poly">
                            <area target=""  @click="humanPartSelect('Riešas - kairė, priekis')" alt="29. Riešas (kairė - priekis)" title="29. Riešas (kairė - priekis)"  coords="354,249,369,244,373,250,374,257,359,259,359,255" shape="poly">
                            <area target=""  @click="humanPartSelect('Burnos ertmė')" alt="30. Burnos ertmė" title="30. Burnos ertmė"  coords="54,395,70,404,67,413,56,416,51,405" shape="poly">
                            <area target=""  @click="humanPartSelect('Kakta - kairė')" alt="31. Kakta (kairė)" title="31. Kakta (kairė)"  coords="62,351,73,350,84,357,87,346,96,339,90,330,83,321,74,326,67,335" shape="poly">
                            <area target=""  @click="humanPartSelect('Momens sritis - kairė')" alt="32. Momens sritis (kairė)" title="32. Momens sritis (kairė)"  coords="100,339,115,337,125,339,133,344,139,351,151,336,141,327,128,319,115,318,103,318,89,319" shape="poly">
                            <area target=""  @click="humanPartSelect('Pakaušis - kairė')" alt="33. Pakaušis (kairė)" title="33. Pakaušis (kairė)"  coords="143,352,153,339,159,346,161,360,162,371,160,380,154,388,148,388,148,376,149,367,148,360" shape="poly">
                            <area target=""  @click="humanPartSelect('Smilkinys - kairė')" alt="34. Smilkinys (kairė)" title="34. Smilkinys (kairė)"  coords="91,349,100,343,117,341,132,349,138,358,143,367,140,376,131,363,118,359,107,357,98,362,87,361" shape="poly">
                            <area target=""  @click="humanPartSelect('Ausies kaušelis - kairė')" alt="35. Ausies kaušelis (kairė)" title="35. Ausies kaušelis (kairė)"  coords="112,381,115,369,123,365,132,369,136,380,135,389,130,398,120,402,111,401,109,391" shape="poly">
                            <area target=""  @click="humanPartSelect('Nosis - kairė')" alt="36. Nosis (kairė)" title="36. Nosis (kairė)"  coords="58,366,47,380,43,389,50,391,68,393,60,378" shape="poly">
                            <area target=""  @click="humanPartSelect('Akis ir periokulinė sritis - kairė')" alt="37. Akis ir periokulinė sritis (kairė)" title="37. Akis ir periokulinė sritis (kairė)"  coords="64,357,73,356,83,361,87,366,85,375,77,378,67,378,61,369" shape="poly">
                            <area target=""  @click="humanPartSelect('Skruostas - kairė')" alt="38. Skruostas (kairė)" title="38. Skruostas (kairė)"  coords="85,378,75,383,70,390,74,396,86,395,95,391,95,380" shape="poly">
                            <area target=""  @click="humanPartSelect('Apatinis žandikaulis - kairė')" alt="39. Apatinis žandikaulis (kairė)" title="39. Apatinis žandikaulis (kairė)"  coords="74,408,79,422,94,417,105,412,105,401,84,401" shape="poly">
                            <area target=""  @click="humanPartSelect('Smakras - kairė')" alt="40. Smakras (kairė)" title="40. Smakras (kairė)"  coords="67,415,57,418,56,427,70,429,77,424,73,412" shape="poly">
                            <area target=""  @click="humanPartSelect('Šlaunis - kairė, priekis')" alt="41. Šlaunis (kairė - priekis)" title="41. Šlaunis (kairė - priekis)"  coords="329,223,317,234,306,243,303,249,299,257,296,268,295,279,296,288,296,297,296,307,298,315,295,327,307,331,322,328,326,316,331,299,333,285,335,270,334,251,332,235" shape="poly">
                            <area target=""  @click="humanPartSelect('Kelias - kairė, priekis')" alt="42. Kelias (kairė - priekis)" title="42. Kelias (kairė - priekis)"  coords="294,334,306,338,320,334,316,353,318,361,304,357,298,357,294,345" shape="poly">
                            <area target=""  @click="humanPartSelect('Blauzda - kairė, priekis')" alt="43. Blauzda (kairė - priekis)" title="43. Blauzda (kairė - priekis)"  coords="299,364,319,366,322,380,320,391,314,413,312,426,300,425,299,403,295,386" shape="poly">
                            <area target=""  @click="humanPartSelect('Čiurna - kairė, priekis')" alt="44. Čiurna (kairė - priekis)" title="44. Čiurna (kairė - priekis)"  coords="300,430,311,430,310,444,298,442" shape="poly">
                            <area target=""  @click="humanPartSelect('Pėda - kairė, viršus')" alt="45. Pėda (kairė - viršus)" title="45. Pėda (kairė - viršus)"  coords="297,448,309,449,315,459,317,469,321,474,318,481,311,484,305,485,298,487,297,475,298,462" shape="poly">
                            <area target=""  @click="humanPartSelect('Žastas - dešinė, priekis')" alt="46. Žastas (dešinė - priekis)" title="46. Žastas (dešinė - priekis)"  coords="237,128,250,128,250,148,250,162,252,181,243,181,237,178,236,160,237,147,235,139" shape="poly">
                            <area target=""  @click="humanPartSelect('Alkūnė - dešinė, priekis')" alt="47. Alkūnė (dešinė - priekis)" title="47. Alkūnė (dešinė - priekis)"  coords="236,181,241,184,252,184,250,193,241,195,234,192" shape="poly">
                            <area target=""  @click="humanPartSelect('Dilbis - dešinė, priekis')" alt="48. Dilbis (dešinė - priekis)" title="48. Dilbis (dešinė - priekis)"  coords="232,196,239,199,249,198,247,216,239,230,233,247,220,242,225,228,226,210" shape="poly">
                            <area target=""  @click="humanPartSelect('Riešas - dešinė, priekis')" alt="49. Riešas (dešinė - priekis)" title="49. Riešas (dešinė - priekis)"  coords="219,244,232,250,229,255,217,250" shape="poly">
                            <area target=""  @click="humanPartSelect('Plaštaka - dešinė, priekis')" alt="50. Plaštaka (dešinė - priekis)" title="50. Plaštaka (dešinė - priekis)"  coords="215,253,229,257,231,264,230,276,227,285,224,290,218,295,212,298,207,291,206,275,198,277,202,268,207,258" shape="poly">
                            <area target=""  @click="humanPartSelect('Šlaunis - dešinė, nugara')" alt="51. Šlaunis (dešinė - nugara)" title="51. Šlaunis (dešinė - nugara)"  coords="524,271,536,272,558,268,559,279,557,295,554,314,551,325,541,327,532,327,524,326,524,313,524,289" shape="poly">
                            <area target=""  @click="humanPartSelect('Kelias - dešinė, nugara')" alt="52. Kelias (dešinė - nugara)" title="52. Kelias (dešinė - nugara)"  coords="525,334,534,336,547,336,547,348,545,356,547,367,538,366,530,366,526,356,525,345" shape="poly">
                            <area target=""  @click="humanPartSelect('Blauzda - dešinė, nugara')" alt="53. Blauzda (dešinė - nugara)" title="53. Blauzda (dešinė - nugara)"  coords="529,370,546,371,549,384,546,398,544,416,531,417,528,403,526,389" shape="poly">
                            <area target=""  @click="humanPartSelect('Čiurna - dešinė, nugara')" alt="54. Čiurna (dešinė - nugara)" title="54. Čiurna (dešinė - nugara)"  coords="530,418,542,421,540,439,530,441,531,430,529,425" shape="poly">
                            <area target=""  @click="humanPartSelect('Pėda - dešinė, apačia')" alt="55. Pėda (dešinė - apačia)" title="55. Pėda (dešinė - apačia)"  coords="528,444,539,443,543,453,548,465,548,476,544,482,537,483,530,484,527,474,529,456" shape="poly">
                            <area target=""  @click="humanPartSelect('Žastas - dešinė, nugara')" alt="56. Žastas (dešinė - nugara)" title="56. Žastas (dešinė - nugara)"  coords="568,134,573,154,571,181,555,189,556,175,560,154,561,143" shape="poly">
                            <area target=""  @click="humanPartSelect('Dilbis - dešinė, nugara')" alt="57. Dilbis (dešinė - nugara)" title="57. Dilbis (dešinė - nugara)"  coords="561,223,570,223,580,218,588,250,579,254,572,243,565,231" shape="poly">
                            <area target=""  @click="humanPartSelect('Riešas - kairė, nugara')" alt="58. Riešas (kairė - nugara)" title="58. Riešas (kairė - nugara)"  coords="454,250,465,253,463,259,452,258" shape="poly">
                            <area target=""  @click="humanPartSelect('Plaštaka - dešinė, nugara')" alt="59. Plaštaka (dešinė - nugara)" title="59. Plaštaka (dešinė - nugara)"  coords="579,271,596,265,604,272,609,283,607,285,600,280,601,295,597,304,593,303,588,300,582,293,580,283" shape="poly">
                            <area target=""  @click="humanPartSelect('Alkūnė - kairė, nugara')" alt="60. Alkūnė (kairė - nugara)" title="60. Alkūnė (kairė - nugara)"  coords="468,193,476,197,484,199,484,215,465,205" shape="poly">
                            <area target=""  @click="humanPartSelect('Petis - dešinė, nugara')" alt="61. Petis (dešinė - nugara)" title="61. Petis (dešinė - nugara)"  coords="531,114,539,111,556,121,538,125" shape="poly">
                            <area target=""  @click="humanPartSelect('Petis - dešinė, priekis')" alt="62. Petis (dešinė - priekis)" title="62. Petis (dešinė - priekis)"  coords="250,115,267,105,279,105,269,117" shape="poly">
                            <area target=""  @click="humanPartSelect('Kaklas - dešinė')" alt="63. Kaklas (dešinė)" title="63. Kaklas (dešinė)"  coords="39,125,51,132,65,141,74,148,84,156,96,159,97,170,93,180,84,185,66,178,50,176,38,171,40,158,40,146,39,136" shape="poly">
                            <area target=""  @click="humanPartSelect('Akis ir periokulinė sritis - kairė, priekis')" alt="64. Akis ir periokulinė sritis  (kairė - priekis)" title="64. Akis ir periokulinė sritis  (kairė - priekis)"  coords="295,59,301,52,310,58,302,64" shape="poly">
                            <area target=""  @click="humanPartSelect('Skruostas - dešinė, priekis')" alt="65. Skruostas (dešinė - priekis)" title="65. Skruostas (dešinė - priekis)"  coords="277,70,283,68,287,71,282,77" shape="poly">
                        </map>
                            <v-data-table
                            :headers="headers"
                            :items="selectedParts_render"
                            class="elevation-6"
                            :items-per-page-options=[15]
                            style="margin-top:15px;"
                        >
                            <template v-slot:items="props">
                                <td class="text-xs-left">{{ props.item.name }}</td>
                                <td class="text-xs-left"> {{ props.item.params }}></td>
                            </template>
                            <template v-slot:item.action="{ item }">
                                <v-icon
                                    small
                                    @click="deleteItem(item)"
                                >mdi-delete</v-icon>
                            </template>
                        </v-data-table>
                    </div>
                </a-tab-pane>

                <a-tab-pane tab="Apžiūros duomenys" key="5">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <v-checkbox
                                v-model="alergija"
                                :label="`Alergija`"
                            ></v-checkbox>
                            <v-text-field
                                v-model="alergija_kam"
                                v-if="alergija"
                                label="Alergija kam:"
                                class="col-md-12"
                            ></v-text-field>
                        </div>
                        <div class="col-md-6">
                            <v-checkbox
                                v-model="gretutines_ligos"
                                :label="`Gretutinės ligos`"
                            ></v-checkbox>
                            <v-text-field
                                v-model="gretutines_ligos_kokios"
                                v-if="gretutines_ligos"
                                label="Kokios gretutinės ligos:"
                                class="col-md-12"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <v-select
                            v-model="bendra_bukle"
                            :items="bukle"
                            label="Bendra būklė"
                        ></v-select>
                    </div>
                    <div class="col-md-6">
                        <v-text-field
                            v-model="temperatura"
                            label="Temperatūra:"
                            suffix="°C"
                        ></v-text-field>
                    </div>
                    <div class="col-md-12">
                        <v-select
                            v-model="skausmas_balais"
                            :items="balai"
                            label="Skausmas balais"
                        ></v-select>
                    </div>
                </a-tab-pane>

                <a-tab-pane tab="Papildomi apžiūros duomenys" key="6">
                    <v-expansion-panels focusable>
                        <v-expansion-panel >
                            <v-expansion-panel-header style="font-size:18px;">Oda, gleivinės</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div class="col-md-6">
                                    <label class="col-md-12" style="">Oda, gleivinės</label>
                                    <v-checkbox
                                        v-model="oda_gleivines_rausvos"
                                        :label="`rausvos`"
                                        class="col-md-4"
                                    ></v-checkbox>
                                    <v-checkbox
                                        v-model="oda_gleivines_blyskios"
                                        :label="`blyškios`"
                                        class="col-md-4"
                                    ></v-checkbox>
                                    <label class="col-md-12" style="">Pilvas:</label>
                                    <v-checkbox
                                        v-model="pilvas_minkstas"
                                        :label="`minkštas`"
                                        class="col-md-4"
                                    ></v-checkbox>
                                    <v-checkbox
                                        v-model="pilvas_skausmingas"
                                        :label="`skausmingas`"
                                        class="col-md-4"
                                    ></v-checkbox>
                                    <v-checkbox
                                        v-model="pilvas_itemptas"
                                        :label="`įtemptas`"
                                        class="col-md-6"
                                    ></v-checkbox>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        v-model="kvepavimo_daznis"
                                        label="Kvėpavimo dažnis"
                                        class="col-md-8"
                                        suffix="k/min"
                                    ></v-text-field>
                                    <label class="col-md-12" style="margin-top:15px;">Plaučių auskultacija</label>
                                    <v-text-field
                                        v-model="plauciu_auskultacija_k"
                                        label=""
                                        class="col-md-5"
                                        prefix="K"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="plauciu_auskultacija_d"
                                        label=""
                                        class="col-md-5"
                                        prefix="D"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="ssd"
                                        label="ŠSD"
                                        class="col-md-4"
                                        suffix="k/min"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="aks"
                                        label="AKS"
                                        class="col-md-5"
                                        suffix="mmHg"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="kpl"
                                        label="KPL"
                                        class="col-md-5"
                                        suffix="sek."
                                    ></v-text-field>
                                </div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel v-if="arraySearch(selectedParts_render, galvos_traumos_vietos)">
                            <v-expansion-panel-header style="font-size:18px;">Galvos traumos papildomi apžiūros duomenys</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div  class="col-md-12">
                                    <div class="col-md-12"><v-divider></v-divider></div>
                                    <h3>Galvos traumos papildomi apžiūros duomenys</h3>
                                    <div class="col-md-6">
                                        <label class="col-md-12" style="margin-top:15px;">Anamnezė:</label>
                                        <v-checkbox
                                            v-model="samones_sutrikimu_nebuvo"
                                            :label="`sąmonės sutrikimų nebuvo`"
                                            class="col-md-8"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="buvo_be_samones"
                                            :label="`buvo be sąmonės`"
                                            class="col-md-8"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="buvo_traukuliai"
                                            :label="`buvo traukuliai`"
                                            class="col-md-8"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="pykino_veme"
                                            :label="`pykino/vėmė`"
                                            class="col-md-8"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="kita_anamneze"
                                            :label="`kita`"
                                            class="col-md-12"
                                            style="margin-top:20px;"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="kita_anamneze_tekstas"
                                            v-if="kita_anamneze"
                                            label=""
                                            class="col-md-12"
                                        ></v-text-field>

                                        <label class="col-md-12" style="margin-top:15px;">Akys:</label>
                                        <v-checkbox
                                            v-model="akys_kd"
                                            :label="`- K = D`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="kita_akys"
                                            :label="`kita`"
                                            class="col-md-6"
                                            style="margin-right:-50px;"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="akys_kita"
                                            v-if="kita_akys"
                                            label=""
                                            class="col-md-12"
                                        ></v-text-field>
                                        <label class="col-md-12" style="margin-top:15px;">Nistagmas:</label>
                                        <v-checkbox
                                            v-model="nistagmas_nera"
                                            :label="`nera`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="nistagmas"
                                            :label="`yra`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="nistagmas_yra_tekstas"
                                            v-if="nistagmas"
                                            label=""
                                            class="col-md-12"
                                        ></v-text-field>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-12" style="margin-top:15px;">CNS sistema:</label>
                                        <v-text-field
                                            v-model="samone_gks"
                                            label="Sąmonė pagal Glasgou k. s. (GKS)"
                                            class="col-md-12"
                                            suffix="balų"
                                        ></v-text-field>
                                        <label class="col-md-12" style="margin-top:15px;">Meninginiai simptomai:</label>
                                        <v-checkbox
                                            v-model="meninginiai_nera"
                                            :label="`nera`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="meninginiai_abejotina"
                                            :label="`abejotina`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="meninginiai_simptomai"
                                            :label="`yra`"
                                            class="col-md-12"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="meninginiai_simptomai_tekstas"
                                            v-if="meninginiai_simptomai"
                                            label=""
                                            class="col-md-12"
                                            style="margin-left:-50px;"
                                        ></v-text-field>
                                        <label class="col-md-12" style="margin-top:15px;">Židininė simptomatika:</label>
                                        <v-checkbox
                                            v-model="zidinine_simptomatika_nera"
                                            :label="`nėra`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="zidinine_simptomatika_abejotina"
                                            :label="`abejotina`"
                                            class="col-md-6"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="zidinine_simptomatika"
                                            :label="`yra`"
                                            class="col-md-12"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="zidinine_simptomatika_tekstas"
                                            v-if="zidinine_simptomatika"
                                            label=""
                                            class="col-md-12"
                                        ></v-text-field>
                                    </div>
                                </div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header style="font-size:18px;">Tyrimai ir jų interpretacija</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-checkbox
                                    v-model="rentgenograma"
                                    :label="`rentgenograma`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="rentgenograma_nr"
                                    v-if="rentgenograma"
                                    label=""
                                    prefix="Nr."
                                    class="col-md-4"
                                    style="margin-left:-50px;"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="rentgenograma_be_pakitimu"
                                    v-if="rentgenograma"
                                    :label="`- be pakitimų`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="tyrimai_radiniai"
                                    :label="`radiniai`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="tyrimai_radiniai_tekstas"
                                    v-if="tyrimai_radiniai"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="bendras_kraujo_tyrimas"
                                    :label="`bendras kraujo tyrimas`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="slapimo_tyrimas"
                                    :label="`šlapimo`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="tyrimai_kiti"
                                    :label="`kiti`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="tyrimai_kiti_tekstas"
                                    v-if="tyrimai_kiti"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header style="font-size:18px;">Gydymas</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-text-field
                                    v-model="dieta"
                                    label="dieta (jei stacionarizuojama)"
                                    class="col-md-6"
                                    style=""
                                ></v-text-field>
                                <v-text-field
                                    v-model="rezimas"
                                    label="rėžimas (jei stacionarizuojama)"
                                    class="col-md-6"
                                    style=""
                                ></v-text-field>
                                <v-checkbox
                                    v-model="nuskausminimas"
                                    :label="`Nuskausminimas`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="nuskausminimas_tekstas"
                                    v-if="nuskausminimas"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="repozicija"
                                    :label="`Repozicija`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="repozicija_tekstas"
                                    v-if="repozicija"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="imobilizacija"
                                    :label="`Imobilizacija`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="imobilizacija_tekstas"
                                    v-if="imobilizacija"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="zaizdos_sutvarkymas"
                                    :label="`Žaizdos sutvarkymas`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="zaizda_susiuta"
                                    v-if="zaizdos_sutvarkymas"
                                    :label="`Susiūta`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="zaizda_suklijuota"
                                    v-if="zaizdos_sutvarkymas"
                                    :label="`Suklijuota`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="zaizda_tvarstis"
                                    v-if="zaizdos_sutvarkymas"
                                    :label="`Tvarstis su antiseptiku`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="nudegimo_sutvarkymas"
                                    :label="`Nudegimo sutvarkymas`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="nudegimas_tvarstis"
                                    v-if="nudegimo_sutvarkymas"
                                    :label="`tvarstis su sidabro sulfadiazinu`"
                                    class="col-md-6"
                                    style="margin-left:30px;"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="nudegimo_sutvarkymas_kita"
                                    v-if="nudegimo_sutvarkymas"
                                    :label="`Kita`"
                                    style="margin-left:-30px;"
                                    class="col-md-6"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="nudegimas_tekstas"
                                    v-if="nudegimo_sutvarkymas_kita"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>

                                <v-checkbox
                                    v-model="gydymas_kita"
                                    :label="`Kita`"
                                    class="col-md-4"
                                ></v-checkbox>
                                <v-text-field
                                    v-model="gydymas_kita_tekstas"
                                    v-if="gydymas_kita"
                                    label="(įrašyti)"
                                    class="col-md-12"
                                ></v-text-field>

                                <v-checkbox
                                    v-model="imunizacija"
                                    :label="`Imunizacija`"
                                    class="col-md-12"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="imunizacija_pasiutlige"
                                    v-if="imunizacija"
                                    :label="`pasiutligė`"
                                    class="col-md-6"
                                    style="margin-left:30px;"
                                ></v-checkbox>
                                <v-checkbox
                                    v-model="imunizacija_stablige"
                                    v-if="imunizacija"
                                    :label="`stabligė`"
                                    style="margin-left:-30px;"
                                    class="col-md-6"
                                ></v-checkbox>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>

                </a-tab-pane>
            </a-tabs>
        </div>

    </div>
    <div class="col-md-6" style="border-style:outset;border-radius:10px;border-width:2px;">
        <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Galutinė informacija</label>
        <div class="col-md-12">
            <label class="col-md-1" style="margin-top:30px;">Išvada: </label>
            <v-checkbox
                v-model="ambulatorinis_gydymas"
                :label="`ambulatorinis gydymas`"
                class="col-md-3"
            ></v-checkbox><v-checkbox
            v-model="stebejimo_paslauga"
            :label="`stebėjimo paslauga`"
            class="col-md-3"
        ></v-checkbox><v-checkbox
            v-model="stacionarinis_gydymas"
            :label="`stacionarinis gydymas`"
            class="col-md-3"
        ></v-checkbox>
            <v-text-field
                v-model="stacionarinis_gydymas_skyriuje"
                v-if="stacionarinis_gydymas"
                label="skyriuje"
                class="col-md-2"
                style="margin-left:-30px;"
            ></v-text-field>
            <label class="col-md-12" style="margin-top:30px;">Rekomendacijos (ambulatoriniam gydymui): </label>
            <v-text-field
                v-model="imobilizacijos_trukme"
                label="Įmobilizacijos trukmė"
                class="col-md-4"
            ></v-text-field>
            <v-text-field
                v-model="rezimas_rekomendacija"
                label="Rėžimas"
                class="col-md-4"
            ></v-text-field>
            <v-text-field
                v-model="riboti_fizini_kruvi"
                label="Riboti fizinį krūvį"
                class="col-md-4"
            ></v-text-field>
            <div class="col-md-12">
                <v-text-field
                    v-model="perrisimai"
                    label="Perrišimai"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="vakcinacija"
                    label="Vakcinacija"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="medikamentai"
                    label="Medikamentai"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="kontrole_pas_traumatologa"
                    label="Kontrolė pas traumatologą"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="siuntimas_ortopedinems"
                    label="Siuntimas ortopedinėms priemonėms"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="siuntimas_konsultuoti"
                    label="Siuntimas konsultuoti"
                    class="col-md-12"
                ></v-text-field>
                <v-text-field
                    v-model="rekomendacijos_kita"
                    label="Kita"
                    class="col-md-12"
                ></v-text-field>
            </div>
            <div class="col-md-6">

                <!--                <label class="col-md-3" style="margin-top:30px;display:none;">Gydytojas: </label>-->
                <!--                <v-text-field-->

                <!--                    class="col-md-9"-->
                <!--                    style="margin-left:-10px;"-->
                <!--                ></v-text-field>-->
                <!--                <h6 style="text-align:center;">(spaudas, parašas)</h6>-->

                <!--                <label class="col-md-3" style="margin-top:30px;display:none;">Vedėjas: </label>-->
                <!--                <v-text-field-->

                <!--                    class="col-md-9"-->
                <!--                    style="margin-left:-10px;"-->
                <!--                ></v-text-field>-->
                <!--                <h6 style="text-align:center; ">(spaudas, parašas)</h6>-->

                <div class="col-md-12" style="display:none;border-style:solid; border-width:1px; margin-top:60px;">
                    <h5 style="text-align:center;  margin-bottom:30px;">Gydytojo atsakymą (išrašą) gavau ir įsipareigoju jį perduoti savo šeimos gydytojui</h5>
                    <v-divider></v-divider>
                    <h6 style="text-align:center; margin-top:-15px;">(paciento ar jo atstovo vardas, pavardė, parašas)</h6>
                </div>

            </div>


        </div>
    </div>

       </div>
</div>
</transition>
           </div>
       </div>
    </v-app>
</template>

<script>
    import V2Datepicker from 'v2-datepicker';
    import locals from 'v2-datepicker/lib/locals.js';
    import moment from 'moment';

    export default {
        name: "Forma1",
        data() {
            return {
                // Formos pasirinkimas
                pacientas_pasirinktas: false,
                headers_formos_pasirinkimas: [
                    {text: 'Asmens kodas', align: 'left', sortable: true, value: 'asmens_kodas'},
                    {text: 'Ligos atvejo nr.', align: 'left', sortable: true, value: 'ligos_atvejo_nr'},
                    {text: 'Būsena', align:'left', sortable: true, value: 'busena'},
                    {text: 'Veiksmai', value: 'action', sortable: false, align: 'center', divider: true },
                ],
                dialog: false,
                ligos_atvejo_numeris: '',
                asmens_kodas: '',
                nauja_forma_neuzpildyta: false,
                formos_list_fake: [],
                formos_list: [],


                // Formos redagavimas

                headers: [
                    {
                        text: 'Traumos vieta',
                        align: 'left',
                        sortable: true,
                        value: 'name',
                        divider: true
                    },
                    { text: 'Rūšis', value: 'params', divider: true},
                    { text: 'Ištrinti', value: 'action', sortable: false, align: 'center', divider: true },
                ],
                //Ignas
                MainDiagnosis:[],
                TimeValue:moment(),
                //ignas baigias
                formDataID: '',
                formID: '',
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

                tyrimai_radiniai: false,
                galvos_traumos_vietos: ['Pakaušis - dešinė', 'Momens sritis - dešinė', 'Kakta - dešinė', 'Akis - dešinė',
                'Nosis - dešinė', 'Lūpos - dešinė', 'Smakras - dešinė', 'Apatinis žandikaulis - dešinė', 'Skruostas - dešinė',
                'Smilkinys - dešinė', 'Ausies kaušelis - dešinė', 'Kaklas - dešinė',
                    'Pakaušis - kairė', 'Momens sritis - kairė', 'Kakta - kairė', 'Akis ir periokulinė sritis - kairė',
                    'Nosis - kairė', 'Burnos ertmė', 'Smakras - kairė', 'Apatinis žandikaulis - kairė', 'Skruostas - kairė',
                    'Smilkinys - kairė', 'Ausies kaušelis - kairė', 'Kaklas - kairė'
                ],
                nuskausminimas: false,
                repozicija: false,
                imobilizacija: false,
                zaizdos_sutvarkymas: false,
                nudegimo_sutvarkymas: false,
                nudegimo_sutvarkymas_kita: false,
                imunizacija: false,
                tyrimai_kiti: false,
                kita_anamneze: false,
                rentgenograma: false,
                gydymas_kita: false,
                stacionarinis_gydymas: false,
                kita_akys: false,
                alergija: false,
                nistagmas: false,
                gretutines_ligos: false,
                meninginiai_simptomai: false,
                zidinine_simptomatika: false,
                selected_part: '',
                isSelected_part: false,
                selectedParts: [],
                selectedParts_render: [],
                body_selected: [],
                skausmas_balais: [],
                vardas_pavarde: '',
                med_dok_nr: '',
                apziuros_data: moment().format('YYYY-MM-DD'),
                apziuros_laikas: moment(),
                but_pagalbos_kat: '',
                nusiskundimai: '',
                datepicker_menu_apziuros_data: false,
                datepicker_menu_traumos_data: false,
                traumos_data: '',
                traumos_laikas: moment(),
                traumos_vieta: '',
                traumos_aplinkybes: '',
                policija_informuota: false,
                vaiku_teises: false,
                alergija_kam: '',
                gretutines_ligos_kokios: '',
                bendra_bukle: '',
                temperatura: '',
                oda_gleivines_rausvos: false,
                oda_gleivines_blyskios: false,
                pilvas_minkstas: false,
                pilvas_skausmingas: false,
                pilvas_itemptas: false,
                kvepavimo_daznis: '',
                plauciu_auskultacija_k: '',
                plauciu_auskultacija_d: '',
                ssd: '',
                aks: '',
                kpl: '',
                samones_sutrikimu_nebuvo: false,
                buvo_be_samones: false,
                buvo_traukuliai: false,
                pykino_veme: false,
                kita_anamneze_tekstas: '',
                akys_kd: false,
                akys_kita: '',
                nistagmas_nera: false,
                nistagmas_yra_tekstas: '',
                samone_gks: '',
                meninginiai_nera: false,
                meninginiai_abejotina: false,
                meninginiai_simptomai_tekstas: '',
                zidinine_simptomatika_nera: false,
                zidinine_simptomatika_abejotina: false,
                zidinine_simptomatika_tekstas: '',
                rentgenograma_nr: '',
                rentgenograma_be_pakitimu: false,
                tyrimai_radiniai_tekstas: '',
                bendras_kraujo_tyrimas: false,
                slapimo_tyrimas: false,
                tyrimai_kiti_tekstas: '',
                diagnoze: '',
                tlk_10_am: [],
                dieta: '',
                rezimas: '',
                nuskausminimas_tekstas: '',
                repozicija_tekstas: '',
                imobilizacija_tekstas: '',
                zaizda_susiuta: false,
                zaizda_suklijuota: false,
                zaizda_tvarstis: false,
                nudegimas_tvarstis: false,
                nudegimas_tekstas: '',
                gydymas_kita_tekstas: '',
                imunizacija_pasiutlige: false,
                imunizacija_stablige: false,
                ambulatorinis_gydymas: false,
                stebejimo_paslauga: false,
                stacionarinis_gydymas_skyriuje: '',
                imobilizacijos_trukme: '',
                rezimas_rekomendacija: '',
                riboti_fizini_kruvi: '',
                perrisimai: '',
                vakcinacija: '',
                medikamentai: '',
                kontrole_pas_traumatologa: '',
                siuntimas_ortopedinems: '',
                siuntimas_konsultuoti: '',
                rekomendacijos_kita: '',
                tyrimai_alkoholiui_narkotikams: false,
                diagnosis_list: [],
                diagnosis_fakelist: [],
                isdiagnosis_list: false,
                requiredFilled: false,
                tlk_10_am_multiselect: [],

                JSONarray: [],

                ESPBI_apziuros_data: '',
                ESPBI_bukles_ivertinimas: '',
                ESPBI_anamneze: '',
                ESPBI_alergijos: '',
                ESPBI_atliktu_tyrimu_informacija: '',
                ESPBI_diagnozes: '',
                ESPBI_taikytas_gydymas: '',
                ESPBI_rekomendacijos: '',
                ESPBI_skiriami_vaistai: '',








                balai: ['0','1','2','3','4','5','6','7','8','9','10'],
                lang: 'lt',
                locals,
                humanPartParams: ['Paraudimas','Patinimas','Kraujosrūva','Deformacija','Nubrozdinimas','Žaizda (durtinė, pjautinė, kirstinė, kąstinė, traiškyta)',
                'Šautinė žaizda','Išnirimas','Uždaras lūžimas','Atviras lūžimas', 'Nudegimas','Nušalimas'],
                selectedHumanPartParams: [],
                bukle: ['gera', 'patenkinama', 'vidutinė', 'sunki'],
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
            }
        },
        methods: {

            getFormosList(){
            this.formos_list = [];
            axios.get('/api/getTraumFormos')
                .then(response => {
                    this.formos_list_fake = response.data;
                    for(var a = 0; a < this.formos_list_fake.length; a++) {
                        this.formos_list.push({
                            'id': this.formos_list_fake[a].id,
                            'asmens_kodas': this.formos_list_fake[a].asmens_kodas,
                            'busena': this.formos_list_fake[a].busena,
                            'ligos_atvejo_nr': this.formos_list_fake[a].ligos_atvejo_nr,
                        })
                    }
                    console.log(this.formos_list)
                    return this.formos_list
                })
                .catch(error => {
                    console.log(error)
                })
            },

            updateForm(formid){
                console.log(formid)
                axios.put('/api/getTraumFormosData/' + formid, {
                    formid: this.formID,
                    vardas_pavarde: this.vardas_pavarde,
                    med_dok_nr: this.ligos_atvejo_numeris,
                    CheckDate: this.CheckDate,
                    apziuros_data: this.apziuros_data,
                    apziuros_laikas: this.apziuros_laikas,
                    but_pagalbos_kat: this.but_pagalbos_kat,
                    nusiskundimai: this.nusiskundimai,
                    traumos_data: this.traumos_data,
                    traumos_laikas: this.traumos_laikas,
                    traumos_vieta: this.traumos_vieta,
                    traumos_aplinkybes: this.traumos_aplinkybes,
                    policija_informuota: this.policija_informuota,
                    vaiku_teises: this.vaiku_teises,
                    traumuotos_vietos: this.traumuotos_vietos,
                    alergija: this.alergija,
                    alergija_kam: this.alergija_kam,
                    gretutines_ligos: this.gretutines_ligos,
                    gretutines_ligos_kokios: this.gretutines_ligos_kokios,
                    bendra_bukle: this.bendra_bukle,
                    temperatura: this.temperatura,
                    skausmas_balais: this.skausmas_balais,
                    oda_gleivines_rausvos: this.oda_gleivines_rausvos,
                    oda_gleivines_blyskios: this.oda_gleivines_blyskios,
                    pilvas_minkstas: this.pilvas_minkstas,
                    pilvas_skausmingas: this.pilvas_skausmingas,
                    pilvas_itemptas: this.pilvas_itemptas,
                    kvepavimo_daznis: this.kvepavimo_daznis,
                    plauciu_auskultacija_k: this.plauciu_auskultacija_k,
                    plauciu_auskultacija_d: this.plauciu_auskultacija_d,
                    ssd: this.ssd,
                    aks: this.aks,
                    kpl: this.kpl,
                    samones_sutrikimu_nebuvo: this.samones_sutrikimu_nebuvo,
                    buvo_be_samones: this.buvo_be_samones,
                    buvo_traukuliai: this.buvo_traukuliai,
                    pykino_veme: this.pykino_veme,
                    kita_anamneze_tekstas: this.kita_anamneze_tekstas,
                    samone_gks: this.samone_gks,
                    meninginiai_nera: this.meninginiai_nera,
                    meninginiai_abejotina: this.meninginiai_abejotina,
                    meninginiai_simptomai_tekstas: this.meninginiai_simptomai_tekstas,
                    zidinine_simptomatika_nera: this.zidinine_simptomatika_nera,
                    zidinine_simptomatika_abejotina: this.zidinine_simptomatika_abejotina,
                    zidinine_simptomatika_tekstas: this.zidinine_simptomatika_tekstas,
                    nistagmas_nera: this.nistagmas_nera,
                    nistagmas_yra_tekstas: this.nistagmas_yra_tekstas,
                    rentgenograma: this.rentgenograma,
                    rentgenograma_nr: this.rentgenograma_nr,
                    rentgenograma_be_pakitimu: this.rentgenograma_be_pakitimu,
                    radiniai: this.radiniai,
                    tyrimai_radiniai_tekstas: this.tyrimai_radiniai_tekstas,
                    bendras_kraujo_tyrimas: this.bendras_kraujo_tyrimas,
                    tyrimai_kiti: this.tyrimai_kiti,
                    tyrimai_kiti_tekstas: this.tyrimai_kiti_tekstas,
                    tlk_10_am: this.tlk_10_am,
                    dieta: this.dieta,
                    rezimas: this.rezimas,
                    nuskausminimas: this.nuskausminimas,
                    nuskausminimas_tekstas: this.nuskausminimas_tekstas,
                    repozicija: this.repozicija,
                    repozicija_tekstas: this.repozicija_tekstas,
                    imobilizacija: this.imobilizacija,
                    imobilizacija_tekstas: this.imobilizacija_tekstas,
                    zaizdos_sutvarkymas: this.zaizdos_sutvarkymas,
                    zaizda_susiuta: this.zaizda_susiuta,
                    zaizda_suklijuota: this.zaizda_suklijuota,
                    zaizda_tvarstis: this.zaizda_tvarstis,
                    nudegimo_sutvarkymas: this.nudegimo_sutvarkymas,
                    nudegimas_tvarstis: this.nudegimas_tvarstis,
                    nudegimo_sutvarkymas_kita: this.nudegimo_sutvarkymas_kita,
                    nudegimas_tekstas: this.nudegimas_tekstas,
                    gydymas_kita_tekstas: this.gydymas_kita_tekstas,
                    imunizacija: this.imunizacija,
                    imunizacija_pasiutlige: this.imunizacija_pasiutlige,
                    imunizacija_stablige: this.imunizacija_stablige,
                    ambulatorinis_gydymas: this.ambulatorinis_gydymas,
                    stebejimo_paslauga: this.stebejimo_paslauga,
                    stacionarinis_gydymas: this.stacionarinis_gydymas,
                    stacionarinis_gydymas_skyriuje: this.stacionarinis_gydymas_skyriuje,
                    imobilizacijos_trukme: this.imobilizacijos_trukme,
                    rezimas_rekomendacija: this.rezimas_rekomendacija,
                    riboti_fizini_kruvi: this.riboti_fizini_kruvi,
                    perrisimai: this.perrisimai,
                    vakcinacija: this.vakcinacija,
                    medikamentai: this.medikamentai,
                    kontrole_pas_traumatologa: this.kontrole_pas_traumatologa,
                    siuntimas_ortopedinems: this.siuntimas_ortopedinems,
                    siuntimas_konsultuoti: this.siuntimas_konsultuoti,
                    rekomendacijos_kita: this.rekomendacijos_kita
                })
            },

            createNewForm(atvejo_numeris, asmens_kodas){
                if(atvejo_numeris && asmens_kodas){
                    this.nauja_forma_neuzpildyta = false;
                    this.pacientas_pasirinktas = true;
                    this.dialog = false;
                    this.GetPatientInformation();
                    axios.post('/api/getTraumFormos', {
                        asmens_kodas: asmens_kodas,
                        busena: 'pradėta',
                        ligos_atvejo_nr: atvejo_numeris,
                    })
                        .then((response) => {
                            let form_id = response.data;
                            this.formID = form_id
                            axios.post('/api/getTraumFormosData', {
                                formid: form_id,
                                vardas_pavarde: '-',
                                med_dok_nr: '-',
                                CheckDate: '-',
                                apziuros_data: moment(),
                                apziuros_laikas: moment(),
                                but_pagalbos_kat: '-',
                                nusiskundimai: '-',
                                traumos_data: moment(),
                                traumos_laikas: moment(),
                                traumos_vieta: '-',
                                traumos_aplinkybes: '-',
                                policija_informuota: '-',
                                vaiku_teises: '-',
                                traumuotos_vietos: '-',
                                alergija: '-',
                                alergija_kam: '-',
                                gretutines_ligos: '-',
                                gretutines_ligos_kokios: '-',
                                bendra_bukle: '-',
                                temperatura: '-',
                                skausmas_balais: '-',
                                oda_gleivines_rausvos: '-',
                                oda_gleivines_blyskios: '-',
                                pilvas_minkstas: '-',
                                pilvas_skausmingas: '-',
                                pilvas_itemptas: '-',
                                kvepavimo_daznis: '-',
                                plauciu_auskultacija_k: '-',
                                plauciu_auskultacija_d: '-',
                                ssd: '-',
                                aks: '-',
                                kpl: '-',
                                samones_sutrikimu_nebuvo: '-',
                                buvo_be_samones: '-',
                                buvo_traukuliai: '-',
                                pykino_veme: '-',
                                kita_anamneze_tekstas: '-',
                                samone_gks: '-',
                                meninginiai_nera: '-',
                                meninginiai_abejotina: '-',
                                meninginiai_simptomai_tekstas: '-',
                                zidinine_simptomatika_nera: '-',
                                zidinine_simptomatika_abejotina: '-',
                                zidinine_simptomatika_tekstas: '-',
                                nistagmas_nera: '-',
                                nistagmas_yra_tekstas: '-',
                                rentgenograma: '-',
                                rentgenograma_nr: '-',
                                rentgenograma_be_pakitimu: '-',
                                radiniai: '-',
                                tyrimai_radiniai_tekstas: '-',
                                bendras_kraujo_tyrimas: '-',
                                tyrimai_kiti: '-',
                                tyrimai_kiti_tekstas: '-',
                                tlk_10_am: '-',
                                dieta: '-',
                                rezimas: '-',
                                nuskausminimas: '-',
                                nuskausminimas_tekstas: '-',
                                repozicija: '-',
                                repozicija_tekstas: '-',
                                imobilizacija: '-',
                                imobilizacija_tekstas: '-',
                                zaizdos_sutvarkymas: '-',
                                zaizda_susiuta: '-',
                                zaizda_suklijuota: '-',
                                zaizda_tvarstis: '-',
                                nudegimo_sutvarkymas: '-',
                                nudegimas_tvarstis: '-',
                                nudegimo_sutvarkymas_kita: '-',
                                nudegimas_tekstas: '-',
                                gydymas_kita_tekstas: '-',
                                imunizacija: '-',
                                imunizacija_pasiutlige: '-',
                                imunizacija_stablige: '-',
                                ambulatorinis_gydymas: '-',
                                stebejimo_paslauga: '-',
                                stacionarinis_gydymas: '-',
                                stacionarinis_gydymas_skyriuje: '-',
                                imobilizacijos_trukme: '-',
                                rezimas_rekomendacija: '-',
                                riboti_fizini_kruvi: '-',
                                perrisimai: '-',
                                vakcinacija: '-',
                                medikamentai: '-',
                                kontrole_pas_traumatologa: '-',
                                siuntimas_ortopedinems: '-',
                                siuntimas_konsultuoti: '-',
                                rekomendacijos_kita: '-'


                            })
                                .then((response) => {
                                    this.formDataID = response.data
                                    console.log(this.formDataID)
                                })
                        })

                } else {
                    this.nauja_forma_neuzpildyta = true;
                }

            },

            editForm(formid){
                console.log(formid)
                this.formDataID = formid
                axios.get('/api/getTraumFormosData', {params: {formid: formid}})
                    .then(response => {
                        console.log(response.data)
                        console.log(response.data[0].formid)
                        this.nauja_forma_neuzpildyta = false;
                        this.pacientas_pasirinktas = true;
                        //form data
                            this.formID = response.data[0].formid,
                            this.vardas_pavarde = response.data[0].vardas_pavarde,
                            this.med_dok_nr= response.data[0].ligos_atvejo_numeris,
                            this.CheckDate= response.data[0].CheckDate,
                            this.apziuros_data= response.data[0].apziuros_data,
                            this.apziuros_laikas= response.data[0].apziuros_laikas,
                            this.but_pagalbos_kat= response.data[0].but_pagalbos_kat,
                            this.nusiskundimai= response.data[0].nusiskundimai,
                            this.traumos_data= response.data[0].traumos_data,
                            this.traumos_laikas= response.data[0].traumos_laikas,
                            this.traumos_vieta= response.data[0].traumos_vieta,
                            this.traumos_aplinkybes= response.data[0].traumos_aplinkybes,
                            this.policija_informuota= response.data[0].policija_informuota,
                            this.vaiku_teises= response.data[0].vaiku_teises,
                            this.traumuotos_vietos= response.data[0].traumuotos_vietos,
                            this.alergija= response.data[0].alergija,
                            this.alergija_kam= response.data[0].alergija_kam,
                            this.gretutines_ligos= response.data[0].gretutines_ligos,
                            this.gretutines_ligos_kokios= response.data[0].gretutines_ligos_kokios,
                            this.bendra_bukle= response.data[0].bendra_bukle,
                            this.temperatura= response.data[0].temperatura,
                            this.skausmas_balais= response.data[0].skausmas_balais,
                            this.oda_gleivines_rausvos= response.data[0].oda_gleivines_rausvos,
                            this.oda_gleivines_blyskios= response.data[0].oda_gleivines_blyskios,
                            this.pilvas_minkstas= response.data[0].pilvas_minkstas,
                            this.pilvas_skausmingas= response.data[0].pilvas_skausmingas,
                            this.pilvas_itemptas= response.data[0].pilvas_itemptas,
                            this.kvepavimo_daznis= response.data[0].kvepavimo_daznis,
                            this.plauciu_auskultacija_k= response.data[0].plauciu_auskultacija_k,
                            this.plauciu_auskultacija_d= response.data[0].plauciu_auskultacija_d,
                            this.ssd= response.data[0].ssd,
                            this.aks= response.data[0].aks,
                            this.kpl= response.data[0].kpl,
                            this.samones_sutrikimu_nebuvo= response.data[0].samones_sutrikimu_nebuvo,
                            this.buvo_be_samones= response.data[0].buvo_be_samones,
                            this.buvo_traukuliai= response.data[0].buvo_traukuliai,
                            this.pykino_veme= response.data[0].pykino_veme,
                            this.kita_anamneze_tekstas= response.data[0].kita_anamneze_tekstas,
                            this.samone_gks= response.data[0].samone_gks,
                            this.meninginiai_nera= response.data[0].meninginiai_nera,
                            this.meninginiai_abejotina= response.data[0].meninginiai_abejotina,
                            this.meninginiai_simptomai_tekstas= response.data[0].meninginiai_simptomai_tekstas,
                            this.zidinine_simptomatika_nera= response.data[0].zidinine_simptomatika_nera,
                            this.zidinine_simptomatika_abejotina= response.data[0].zidinine_simptomatika_abejotina,
                            this.zidinine_simptomatika_tekstas= response.data[0].zidinine_simptomatika_tekstas,
                            this.nistagmas_nera= response.data[0].nistagmas_nera,
                            this.nistagmas_yra_tekstas= response.data[0].nistagmas_yra_tekstas,
                            this.rentgenograma= response.data[0].rentgenograma,
                            this.rentgenograma_nr= response.data[0].rentgenograma_nr,
                            this.rentgenograma_be_pakitimu= response.data[0].rentgenograma_be_pakitimu,
                            this.radiniai= response.data[0].radiniai,
                            this.tyrimai_radiniai_tekstas= response.data[0].tyrimai_radiniai_tekstas,
                            this.bendras_kraujo_tyrimas= response.data[0].bendras_kraujo_tyrimas,
                            this.tyrimai_kiti= response.data[0].tyrimai_kiti,
                            this.tyrimai_kiti_tekstas= response.data[0].tyrimai_kiti_tekstas,
                            this.tlk_10_am= response.data[0].tlk_10_am,
                            this.dieta= response.data[0].dieta,
                            this.rezimas= response.data[0].rezimas,
                            this.nuskausminimas= response.data[0].nuskausminimas,
                            this.nuskausminimas_tekstas= response.data[0].nuskausminimas_tekstas,
                            this.repozicija= response.data[0].repozicija,
                            this.repozicija_tekstas= response.data[0].repozicija_tekstas,
                            this.imobilizacija= response.data[0].imobilizacija,
                            this.imobilizacija_tekstas= response.data[0].imobilizacija_tekstas,
                            this.zaizdos_sutvarkymas= response.data[0].zaizdos_sutvarkymas,
                            this.zaizda_susiuta= response.data[0].zaizda_susiuta,
                            this.zaizda_suklijuota= response.data[0].zaizda_suklijuota,
                            this.zaizda_tvarstis= response.data[0].zaizda_tvarstis,
                            this.nudegimo_sutvarkymas= response.data[0].nudegimo_sutvarkymas,
                            this.nudegimas_tvarstis= response.data[0].nudegimas_tvarstis,
                            this.nudegimo_sutvarkymas_kita= response.data[0].nudegimo_sutvarkymas_kita,
                            this.nudegimas_tekstas= response.data[0].nudegimas_tekstas,
                            this.gydymas_kita_tekstas= response.data[0].gydymas_kita_tekstas,
                            this.imunizacija= response.data[0].imunizacija,
                            this.imunizacija_pasiutlige= response.data[0].imunizacija_pasiutlige,
                            this.imunizacija_stablige= response.data[0].imunizacija_stablige,
                            this.ambulatorinis_gydymas= response.data[0].ambulatorinis_gydymas,
                            this.stebejimo_paslauga= response.data[0].stebejimo_paslauga,
                            this.stacionarinis_gydymas= response.data[0].stacionarinis_gydymas,
                            this.stacionarinis_gydymas_skyriuje= response.data[0].stacionarinis_gydymas_skyriuje,
                            this.imobilizacijos_trukme= response.data[0].imobilizacijos_trukme,
                            this.rezimas_rekomendacija= response.data[0].rezimas_rekomendacija,
                            this.riboti_fizini_kruvi= response.data[0].riboti_fizini_kruvi,
                            this.perrisimai= response.data[0].perrisimai,
                            this.vakcinacija= response.data[0].vakcinacija,
                            this.medikamentai= response.data[0].medikamentai,
                            this.kontrole_pas_traumatologa= response.data[0].kontrole_pas_traumatologa,
                            this.siuntimas_ortopedinems= response.data[0].siuntimas_ortopedinems,
                            this.siuntimas_konsultuoti= response.data[0].siuntimas_konsultuoti,
                            this.rekomendacijos_kita= response.data[0].rekomendacijos_kita
                    })
            },

            getFormattedTime(x) {
                var today = x;
                today = moment(today).format('HH:mm')
                return today;
            },

            moment,
            //Igno funkcijos

            remove(DeletedDiagnosis){
                if (DeletedDiagnosis.code===this.MainDiagnosis){
                    if ((DeletedDiagnosis.code===this.tlk_10_am[0].code) && (this.tlk_10_am[1])){
                        this.tlk_10_am[1].type='Pagrindinis';
                        this.MainDiagnosis=this.tlk_10_am[1].code;
                    }else{
                        this.tlk_10_am[0].type='Pagrindinis';
                        this.MainDiagnosis=this.tlk_10_am[0].code;
                    }
                }
            },
            TypeChange(ChangedOption){
                var NewMain=this.MainDiagnosis;
                if (this.tlk_10_am.length===1){
                    this.tlk_10_am[0].type='Pagrindinis'
                }
                if ((ChangedOption.type==='Pagrindinis')&&(ChangedOption.code!==this.MainDiagnosis)){
                        for (var index=0;index<this.tlk_10_am.length;index++){
                            if (this.tlk_10_am[index].code===ChangedOption.code) {
                                NewMain=ChangedOption.code;
                                this.tlk_10_am[index].type='Pagrindinis'
                            }
                            if (this.tlk_10_am[index].code===this.MainDiagnosis){
                                this.tlk_10_am[index].type='Lydinti';
                            }
                        }

                }
                if ((ChangedOption.type!=='Pagrindinis')&&(ChangedOption.code===this.MainDiagnosis)){
                    for (var index=0;index<this.tlk_10_am.length;index++){
                        if (ChangedOption.code===this.tlk_10_am[index].code){
                            this.tlk_10_am[index].type='Pagrindinis';
                        }
                    }
                }


                this.MainDiagnosis= NewMain;

            },
            //Baigias
            diagnosisSelect(selectedOption, id){

                if (this.tlk_10_am.length===1){
                    this.tlk_10_am[0].type= 'Pagrindinis';
                    this.tlk_10_am[0].time='-';
                    this.MainDiagnosis=this.tlk_10_am[0].code
                }else if(this.tlk_10_am.length){
                    this.tlk_10_am[this.tlk_10_am.length-1].type= 'Lydinti';
                    this.tlk_10_am[this.tlk_10_am.length-1].time='-';
                }


                // for(let a = 0; a < this.tlk_10_am.length; a++) {
                //     if(this.tlk_10_am[a].hasOwnProperty('type') && a !== 0){
                //         this.tlk_10_am[a].type = 'Lydinti'
                //     }
                //
                //     if(!this.tlk_10_am[a].hasOwnProperty('type') && a === 0) {
                //         console.log('this.tlk_10_am[a].hasOwnProperty(\'type\')' + this.tlk_10_am[a].hasOwnProperty('type'))
                //         this.tlk_10_am[a].push({
                //             type: 'Pagrindinis'
                //         })
                //     }
                // }
            },

            generateESPBIstring(additional_string, base_string){
                let connector = '. ';
                if(additional_string) {
                    if(additional_string[additional_string.length - 1] === '.'){
                        additional_string = additional_string.slice(0, additional_string.length - 1);
                        console.log('additional string ifas suveike')
                    }

                    if(base_string){
                        base_string += connector;
                        base_string += additional_string;
                    } else {
                        base_string += additional_string;
                    }
                }

                return base_string;
            },

            generateESPBI() {

                if (this.apziuros_data && this.apziuros_laikas) {
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Apžiūros data ir laikas: ' + this.apziuros_data + ', ' + this.getFormattedTime(this.apziuros_laikas), this.ESPBI_apziuros_data)
                } else {
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Apžiūros data ir laikas: -', this.ESPBI_apziuros_data)
                }

                if (this.but_pagalbos_kat) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Būtinosios pagalbos kategorija: ' + this.but_pagalbos_kat, this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Būtinosios pagalbos kategorija: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.nusiskundimai) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Nusiskundimai: ' + this.nusiskundimai, this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Nusiskundimai: -', this.ESPBI_anamneze)
                }

                if (this.traumos_data && this.traumos_laikas && this.traumos_vieta && this.traumos_aplinkybes) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Traumos data: ' + this.traumos_data + ', traumos laikas: ' + this.getFormattedTime(this.traumos_laikas) + ', traumos vieta: ' + this.traumos_vieta + ', traumos aplinkybės: ' + this.traumos_aplinkybes, this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Kada, kur įvyko trauma: -', this.ESPBI_anamneze)
                }

                if (this.tyrimai_alkoholiui_narkotikams) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Tyrimai alkoholiui, narkotikams: paimti', this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Tyrimai alkoholiui, narkotikams: -', this.ESPBI_anamneze)
                }

                if (this.policija_informuota) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Policija informuota: taip', this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Policija informuota: -', this.ESPBI_anamneze)
                }

                if (this.vaiku_teises) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Vaikų teisių apsaugos tarnyba informuota: taip', this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Vaikų teisių apsaugos tarnyba informuota: -', this.ESPBI_anamneze)
                }


                if(this.alergija && this.alergija_kam){
                    this.ESPBI_alergijos = this.generateESPBIstring('Alergijos: ' + this.alergija_kam, this.ESPBI_alergijos)
                } else if(!this.alergija || !this.alergija_kam){
                    this.ESPBI_alergijos = this.generateESPBIstring('Alergijos: -', this.ESPBI_alergijos)
                }

                if(this.gretutines_ligos && this.gretutines_ligos_kokios){
                    this.ESPBI_anamneze = this.generateESPBIstring('Gretutinės ligos: ' + this.gretutines_ligos_kokios, this.ESPBI_anamneze)
                } else if(!this.gretutines_ligos || !this.gretutines_ligos_kokios) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Gretutinės ligos: -', this.ESPBI_anamneze)
                }

                if(this.bendra_bukle){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Bendra būklė: ' + this.bendra_bukle, this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Bendra būklė: -', this.ESPBI_bukles_ivertinimas)
                }

                if(this.temperatura){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Temperatūra: ' + this.temperatura + '°C', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Temperatūra: -', this.ESPBI_bukles_ivertinimas)

                }

                if(this.skausmas_balais){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Skausmas balais: ' + this.skausmas_balais, this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Skausmas balais: -', this.ESPBI_bukles_ivertinimas)
                }

                // if(this.diagnoze){
                //     this.ESPBI_diagnozes = this.generateESPBIstring('Diagnozė: ' + this.diagnoze, this.ESPBI_diagnozes)
                // } else {
                //     this.ESPBI_diagnozes = this.generateESPBIstring('Diagnozė: -', this.ESPBI_diagnozes)
                // }

                if(this.tlk_10_am){
                    for(let a = 0; a < this.tlk_10_am.length; a++){
                        this.ESPBI_diagnozes = this.generateESPBIstring('TLK-10-AM: ' + this.tlk_10_am[a].code + ' ' + this.tlk_10_am[a].title + ', ligos tipas ' + this.tlk_10_am[a].type + ', ' + this.tlk_10_am[a].time, this.ESPBI_diagnozes)
                    }
                } else {
                    this.ESPBI_diagnozes = this.generateESPBIstring('TLK-10-AM: -', this.ESPBI_diagnozes)
                }




                if(this.dieta){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Dieta: ' + this.dieta, this.ESPBI_taikytas_gydymas)
                } else {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Dieta: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.rezimas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Rėžimas: ' + this.rezimas, this.ESPBI_taikytas_gydymas)
                } else {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Rėžimas: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.nuskausminimas && this.nuskausminimas_tekstas) {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nuskausminimas: ' + this.nuskausminimas_tekstas, this.ESPBI_taikytas_gydymas)
                } else if(!this.nuskausminimas || !this.nuskausminimas_tekstas) {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nuskausminimas: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.repozicija && this.repozicija_tekstas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Repozicija: ' + this.repozicija_tekstas, this.ESPBI_taikytas_gydymas)
                } else if(!this.repozicija || this.repozicija_tekstas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Repozicija: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.imobilizacija && this.imobilizacija_tekstas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imobilizacija: ' + this.imobilizacija_tekstas, this.ESPBI_taikytas_gydymas)
                } else if(!this.imobilizacija || this.imobilizacija_tekstas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imobilizacija: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.zaizdos_sutvarkymas){
                    if(this.zaizda_suklijuota && this.zaizda_susiuta && this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: suklijuota, susiųta, tvarstis su antiseptiku', this.ESPBI_taikytas_gydymas)
                    } else if(this.zaizda_suklijuota && this.zaizda_susiuta && !this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: suklijuota, susiųta', this.ESPBI_taikytas_gydymas)
                    } else if(this.zaizda_suklijuota && !this.zaizda_susiuta && !this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: suklijuota', this.ESPBI_taikytas_gydymas)
                    } else if(this.zaizda_suklijuota && !this.zaizda_susiuta && this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: suklijuota, tvarstis su antiseptiku', this.ESPBI_taikytas_gydymas)
                    } else if(!this.zaizda_suklijuota && this.zaizda_susiuta && this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: susiųta, tvarstis su antiseptiku', this.ESPBI_taikytas_gydymas)
                    }else if (!this.zaizda_suklijuota && this.zaizda_susiuta && !this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: susiųta')
                    } else if (!this.zaizda_suklijuota && !this.zaizda_susiuta && !this.zaizda_tvarstis){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: -')
                    }
                } else if (!this.zaizdos_sutvarkymas) {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Žaizdos sutvarkymas: -')
                }

                if(this.nudegimo_sutvarkymas){
                    if(this.nudegimas_tvarstis && !this.nudegimo_sutvarkymas_kita){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nudegimo sutvarkymas: tvarstis su sidabro sulfadiazinu', this.ESPBI_taikytas_gydymas)
                    } else if (this.nudegimas_tvarstis && this.nudegimo_sutvarkymas_kita && this.nudegimas_tekstas){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nudegimo sutvarkymas: tvarstis su sidabro sulfadiazinu, ' + this.nudegimas_tekstas, this.ESPBI_taikytas_gydymas)
                    } else if (!this.nudegimas_tvarstis && this.nudegimo_sutvarkymas_kita && this.nudegimas_tekstas){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nudegimo sutvarkymas: ' + this.nudegimas_tekstas, this.ESPBI_taikytas_gydymas)
                    }
                } else {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Nudegimo sutvarkymas: -', this.ESPBI_taikytas_gydymas)
                }

                if(this.gydymas_kita && this.gydymas_kita_tekstas){
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Gydymas (kita): ' + this.gydymas_kita_tekstas, this.ESPBI_taikytas_gydymas)
                } else {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Gydymas (kita): -', this.ESPBI_taikytas_gydymas)
                }

                if(this.imunizacija){
                    if(this.imunizacija_pasiutlige && this.imunizacija_stablige){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imunizacija: pasiutligė, stabligė', this.ESPBI_taikytas_gydymas)
                    } else if (this.imunizacija_stablige && !this.imunizacija_pasiutlige){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imunizacija: stabligė', this.ESPBI_taikytas_gydymas)
                    } else if (this.imunizacija_pasiutlige && !this.imunizacija_stablige){
                        this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imunizacija: pasiutligė', this.ESPBI_taikytas_gydymas)
                    }
                } else {
                    this.ESPBI_taikytas_gydymas = this.generateESPBIstring('Imunizacija: -', this.ESPBI_taikytas_gydymas)
                }



                if (this.oda_gleivines_rausvos || this.oda_gleivines_blyskios) {
                    if (this.oda_gleivines_rausvos && !this.oda_gleivines_blyskios) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Oda, gleivinės: rausvos', this.ESPBI_bukles_ivertinimas)
                    } else if (!this.oda_gleivines_rausvos && this.oda_gleivines_blyskios) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Oda, gleivinės: blyškios', this.ESPBI_bukles_ivertinimas)

                    } else if (this.oda_gleivines_rausvos && this.oda_gleivines_blyskios) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Oda, gleivinės: rausvos, blyškios', this.ESPBI_bukles_ivertinimas)

                    }
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Oda, gleivinės: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.kvepavimo_daznis) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Kvėpavimo dažnis: ' + this.kvepavimo_daznis + ' k/min', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Kvėpavimo dažnis: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.plauciu_auskultacija_k && this.plauciu_auskultacija_d) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Plaučių auskultacija: K ' + this.plauciu_auskultacija_k + ', D ' + this.plauciu_auskultacija_d, this.ESPBI_bukles_ivertinimas)
                } else if (this.plauciu_auskultacija_k && !this.plauciu_auskultacija_d) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Plaučių auskultacija: K ' + this.plauciu_auskultacija_k + ', D - ', this.ESPBI_bukles_ivertinimas)
                } else if (!this.plauciu_auskultacija_k && this.plauciu_auskultacija_d) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Plaučių auskultacija: K -' + ', D ' + this.plauciu_auskultacija_d, this.ESPBI_bukles_ivertinimas)
                } else if (!this.plauciu_auskultacija_d && !this.plauciu_auskultacija_k) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Plaučių auskultacija: K -' + ', D -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.ssd) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('ŠSD: ' + this.ssd + ' k/min', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('ŠSD: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.aks) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('AKS: ' + this.aks + ' mmHg', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('AKS: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.kpl) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('KPL: ' + this.kpl + ' sek.', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('KPL: -', this.ESPBI_bukles_ivertinimas)

                }

                if (this.pilvas_itemptas && this.pilvas_minkstas && this.pilvas_skausmingas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: skausmingas, įtemptas ir minkštas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_itemptas && this.pilvas_skausmingas && !this.pilvas_minkstas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: įtemptas ir skausmingas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_itemptas && this.pilvas_minkstas && !this.pilvas_skausmingas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: įtemptas ir minkštas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_itemptas && !this.pilvas_skausmingas && !this.pilvas_minkstas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: įtemptas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_minkstas && this.pilvas_skausmingas && !this.pilvas_itemptas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: minkštas ir skausmingas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_minkstas && !this.pilvas_skausmingas && !this.pilvas_itemptas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: minkštas', this.ESPBI_bukles_ivertinimas)
                } else if (this.pilvas_skausmingas && !this.pilvas_minkstas && !this.pilvas_itemptas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: skausmingas', this.ESPBI_bukles_ivertinimas)
                } else if (!this.pilvas_skausmingas && !this.pilvas_itemptas && !this.pilvas_minkstas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Pilvas: -', this.ESPBI_bukles_ivertinimas)

                }

                if (this.arraySearch(this.selectedParts_render, this.galvos_traumos_vietos)) {

                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Galvos traumos papildomi apžiūros duomenys - anamnezė:', this.ESPBI_bukles_ivertinimas)

                    if (this.samones_sutrikimu_nebuvo && this.buvo_traukuliai && this.pykino_veme && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, pykino/vėmė, buvo traukuliai', this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && this.buvo_traukuliai && !this.pykino_veme && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, buvo traukuliai', this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && this.pykino_veme && !this.buvo_traukuliai && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, pykino/vėmė', this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && !this.pykino_veme && !this.buvo_traukuliai && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo', this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && this.buvo_traukuliai && this.pykino_veme && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės, buvo traukuliai, pykino/vėmė', this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && this.buvo_traukuliai && !this.pykino_veme && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės, buvo traukuliai', this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && !this.buvo_traukuliai && !this.pykino_veme && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės', this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_traukuliai && this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo traukuliai, pykino/vėmė', this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_traukuliai && !this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo traukuliai', this.ESPBI_bukles_ivertinimas)
                    } else if (!this.buvo_traukuliai && this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && !this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('pykino/vėmė', this.ESPBI_bukles_ivertinimas)
                    }
                    //su 'kitas' variantu pasirinktu
                    else if (this.samones_sutrikimu_nebuvo && this.buvo_traukuliai && this.pykino_veme && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, pykino/vėmė, buvo traukuliai, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && this.buvo_traukuliai && !this.pykino_veme && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, buvo traukuliai, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && this.pykino_veme && !this.buvo_traukuliai && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, pykino/vėmė, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.samones_sutrikimu_nebuvo && !this.pykino_veme && !this.buvo_traukuliai && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('sąmonės sutrikimų nebuvo, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && this.buvo_traukuliai && this.pykino_veme && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės, buvo traukuliai, pykino/vėmė, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && this.buvo_traukuliai && !this.pykino_veme && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės, buvo traukuliai, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_be_samones && !this.buvo_traukuliai && !this.pykino_veme && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo be sąmonės, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_traukuliai && this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo traukuliai, pykino/vėmė, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (this.buvo_traukuliai && !this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('buvo traukuliai, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (!this.buvo_traukuliai && this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('pykino/vėmė, ' + this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    } else if (!this.buvo_traukuliai && !this.pykino_veme && !this.buvo_be_samones && !this.samones_sutrikimu_nebuvo && this.kita_anamneze) {
                        this.ESPBI_bukles_ivertinimas = this.generateESPBIstring(this.kita_anamneze_tekstas, this.ESPBI_bukles_ivertinimas)
                    }

                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Galvos traumos papildomi apžiūros duomenys -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.akys_kd && !this.kita_akys) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Akys: - K = D', this.ESPBI_bukles_ivertinimas)
                } else if (this.akys_kd && this.kita_akys) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Akys: - K = D, ' + this.akys_kita, this.ESPBI_bukles_ivertinimas)
                } else if (!this.akys_kd && this.kita_akys) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Akys: ' + this.akys_kita, this.ESPBI_bukles_ivertinimas)
                }

                if (this.nistagmas_nera && !this.nistagmas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Nistagmas: nėra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.nistagmas_nera && this.nistagmas && !this.nistagmas_yra_tekstas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Nistagmas: yra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.nistagmas_nera && this.nistagmas && this.nistagmas_yra_tekstas) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Nistagmas: yra, ' + this.nistagmas_yra_tekstas, this.ESPBI_bukles_ivertinimas)
                } else if (!this.nistagmas && !this.nistagmas_nera) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Nistagmas: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.samone_gks) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Sąmonė pagal Glasgou k.s. (GKS): ' + this.samone_gks + ' balų', this.ESPBI_bukles_ivertinimas)
                } else {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Sąmonė pagal Glasgou k.s. (GKS): -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.meninginiai_nera && !this.meninginiai_abejotina && !this.meninginiai_simptomai) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Meninginiai simptomai: nėra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.meninginiai_nera && this.meninginiai_abejotina && !this.meninginiai_simptomai){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Meninginiai simptomai: abejotina', this.ESPBI_bukles_ivertinimas)
                }  else if (!this.meninginiai_nera && !this.meninginiai_abejotina && this.meninginiai_simptomai && !this.meninginiai_simptomai_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Meninginiai simptomai: yra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.meninginiai_nera && !this.meninginiai_abejotina && this.meninginiai_simptomai && this.meninginiai_simptomai_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Meninginiai simptomai: yra, ' + this.meninginiai_simptomai_tekstas, this.ESPBI_bukles_ivertinimas)
                } else if (!this.meninginiai_nera && !this.meninginiai_abejotina && !this.meninginiai_simptomai && !this.meninginiai_simptomai_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Meninginiai simptomai: -', this.ESPBI_bukles_ivertinimas)
                }

                if (this.zidinine_simptomatika_nera && !this.zidinine_simptomatika_abejotina && !this.zidinine_simptomatika) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Židininė simptomatika: nėra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.zidinine_simptomatika_nera && this.zidinine_simptomatika_abejotina && !this.zidinine_simptomatika){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Židininė simptomatika: abejotina', this.ESPBI_bukles_ivertinimas)
                }  else if (!this.zidinine_simptomatika_nera && !this.zidinine_simptomatika_abejotina && this.zidinine_simptomatika && !this.zidinine_simptomatika_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Židininė simptomatika: yra', this.ESPBI_bukles_ivertinimas)
                } else if (!this.zidinine_simptomatika_nera && !this.zidinine_simptomatika_abejotina && this.zidinine_simptomatika && this.zidinine_simptomatika_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Židininė simptomatika: yra, ' + this.zidinine_simptomatika_tekstas, this.ESPBI_bukles_ivertinimas)
                } else if (!this.zidinine_simptomatika_nera && !this.zidinine_simptomatika_abejotina && !this.zidinine_simptomatika && !this.zidinine_simptomatika_tekstas){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Židininė simptomatika: -', this.ESPBI_bukles_ivertinimas)
                }


                if(this.rentgenograma && this.rentgenograma_nr && !this.rentgenograma_be_pakitimu){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Rentgenograma nr. ' + this.rentgenograma_nr, this.ESPBI_atliktu_tyrimu_informacija)
                } else if(this.rentgenograma && this.rentgenograma_nr && this.rentgenograma_be_pakitimu){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Rentgenograma nr. ' + this.rentgenograma_nr + ', be pakitimų', this.ESPBI_atliktu_tyrimu_informacija)
                } else if(!this.rentgenograma) {
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Rentgenograma: -', this.ESPBI_atliktu_tyrimu_informacija)
                }

                if(this.tyrimai_radiniai && this.tyrimai_radiniai_tekstas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Radiniai: ' + this.tyrimai_radiniai_tekstas, this.ESPBI_atliktu_tyrimu_informacija)
                } else if(!this.tyrimai_radiniai || !this.tyrimai_radiniai_tekstas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Radiniai: -', this.ESPBI_atliktu_tyrimu_informacija)
                }

                if(this.bendras_kraujo_tyrimas) {
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Bendras kraujo tyrimas: taip', this.ESPBI_atliktu_tyrimu_informacija)
                } else if(!this.bendras_kraujo_tyrimas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Bendras kraujo tyrimas: -', this.ESPBI_atliktu_tyrimu_informacija)
                }

                if(this.slapimo_tyrimas) {
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Šlapimo tyrimas: taip', this.ESPBI_atliktu_tyrimu_informacija)
                } else if(!this.slapimo_tyrimas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Šlapimo tyrimas: -', this.ESPBI_atliktu_tyrimu_informacija)
                }

                if(this.tyrimai_kiti && this.tyrimai_kiti_tekstas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Kiti tyrimai: ' + this.tyrimai_kiti_tekstas, this.ESPBI_atliktu_tyrimu_informacija)
                } else if(!this.tyrimai_kiti || !this.tyrimai_kiti_tekstas){
                    this.ESPBI_atliktu_tyrimu_informacija = this.generateESPBIstring('Kiti tyrimai: -', this.ESPBI_atliktu_tyrimu_informacija)
                }

                if(this.selectedParts_render){
                    let kuno_dalys = '';
                    for(let a = 0; a < this.selectedParts_render.length; a++){
                        kuno_dalys += this.selectedParts_render[a].name + ', rūšis:  ' + this.selectedParts_render[a].params + '; '
                    }
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Traumuotos vietos: ' + kuno_dalys, this.ESPBI_bukles_ivertinimas)
                } else if(!this.selectedParts_render){
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Traumuotos vietos: -', this.ESPBI_bukles_ivertinimas)
                }


                if(this.ambulatorinis_gydymas && !this.stebejimo_paslauga && !this.stacionarinis_gydymas){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: ambulatorinis gydymas', this.ESPBI_rekomendacijos)
                } else if(this.ambulatorinis_gydymas && this.stebejimo_paslauga && !this.stacionarinis_gydymas){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: ambulatorinis gydymas, stebėjimo paslauga', this.ESPBI_rekomendacijos)
                } else if(this.ambulatorinis_gydymas && this.stebejimo_paslauga && this.stacionarinis_gydymas && this.stacionarinis_gydymas_skyriuje){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: ambulatorinis gydymas, stebėjimo paslauga, stacionarinis gydymas ' + this.stacionarinis_gydymas_skyriuje + ' skyriuje.', this.ESPBI_rekomendacijos)
                } else if(this.ambulatorinis_gydymas  && !this.stebejimo_paslauga && this.stacionarinis_gydymas && this.stacionarinis_gydymas_skyriuje){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: ambulatorinis gydymas, stacionarinis gydymas ' + this.stacionarinis_gydymas_skyriuje + ' skyriuje', this.ESPBI_rekomendacijos)
                } else if(!this.ambulatorinis_gydymas && this.stebejimo_paslauga && !this.stacionarinis_gydymas){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: stebėjimo paslauga', this.ESPBI_rekomendacijos)
                } else if(!this.ambulatorinis_gydymas && !this.stebejimo_paslauga && this.stacionarinis_gydymas && this.stacionarinis_gydymas_skyriuje){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: stacionarinis gydymas ' + this.stacionarinis_gydymas_skyriuje + ' skyriuje', this.ESPBI_rekomendacijos)
                } else if(!this.ambulatorinis_gydymas && this.stebejimo_paslauga && this.stacionarinis_gydymas && this.stacionarinis_gydymas_skyriuje){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Išvada: stebėjimo paslauga, stacionarinis gydymas ' + this.stacionarinis_gydymas_skyriuje + ' skyriuje', this.ESPBI_rekomendacijos)
                }

                if(this.imobilizacijos_trukme){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Imobilizacijos trukmė: ' + this.imobilizacijos_trukme, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Imobilizacijos trukmė: -' + this.imobilizacijos_trukme, this.ESPBI_rekomendacijos)
                }

                if(this.rezimas_rekomendacija){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Režimas: ' + this.rezimas_rekomendacija, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Režimas: -', this.ESPBI_rekomendacijos)
                }

                if(this.riboti_fizini_kruvi){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Riboti fizinį krūvį: ' + this.riboti_fizini_kruvi, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Riboti fizinį krūvį: -', this.ESPBI_rekomendacijos)
                }

                if(this.perrisimai){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Perrišimai: ' + this.perrisimai, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Perrišimai: -', this.ESPBI_rekomendacijos)
                }

                if(this.vakcinacija){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Vakcinacija: ' + this.vakcinacija, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Vakcinacija: -', this.ESPBI_rekomendacijos)
                }

                if(this.medikamentai){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Medikamentai: ' + this.medikamentai, this.ESPBI_rekomendacijos)
                    this.ESPBI_skiriami_vaistai = this.generateESPBIstring('Medikamentai: ' + this.medikamentai, this.ESPBI_skiriami_vaistai)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Medikamentai: -', this.ESPBI_rekomendacijos)
                    this.ESPBI_skiriami_vaistai = this.generateESPBIstring('Medikamentai: -', this.ESPBI_skiriami_vaistai)
                }

                if(this.kontrole_pas_traumatologa){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Kontrolė pas traumatologą: ' + this.kontrole_pas_traumatologa, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Kontrolė pas traumatologą: -', this.ESPBI_rekomendacijos)
                }

                if(this.siuntimas_ortopedinems){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Siuntimas ortopedinėms priemonėms: ' + this.siuntimas_ortopedinems, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Siuntimas ortopedinėms priemonėms: -', this.ESPBI_rekomendacijos)
                }

                if(this.siuntimas_konsultuoti){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Siuntimas konsultuoti: ' + this.siuntimas_konsultuoti, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Siuntimas konsultuoti: -', this.ESPBI_rekomendacijos)
                }

                if(this.rekomendacijos_kita){
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Kita: ' + this.rekomendacijos_kita, this.ESPBI_rekomendacijos)
                } else {
                    this.ESPBI_rekomendacijos = this.generateESPBIstring('Kita: -', this.ESPBI_rekomendacijos)
                }









            },

            resetESPBI(){
                    this.ESPBI_apziuros_data = '',
                    this.ESPBI_bukles_ivertinimas= '',
                    this.ESPBI_anamneze= '',
                    this.ESPBI_alergijos= '',
                    this.ESPBI_atliktu_tyrimu_informacija= '',
                    this.ESPBI_diagnozes= '',
                    this.ESPBI_taikytas_gydymas= '',
                    this.ESPBI_rekomendacijos= '',
                    this.ESPBI_skiriami_vaistai= ''
            },


            generateJSON(){
                this.updateForm(this.formDataID)
                this.resetESPBI()
                this.JSONarray = [];

                this.generateESPBI();
                console.log('ESPBI_anamneze: ' + this.ESPBI_anamneze)
                console.log('ESPBI_bukles_ivertinimas: ' + this.ESPBI_bukles_ivertinimas)
                console.log('ESPBI_atliktu_tyrimu_informacija: ' + this.ESPBI_atliktu_tyrimu_informacija)
                console.log('ESPBI_diagnozes: ' + this.ESPBI_diagnozes)
                console.log('ESPBI_rekomendacijos: ' + this.ESPBI_rekomendacijos)
                console.log('ESPBI_skiriami_vaista: ' + this.ESPBI_skiriami_vaistai)
                console.log('ESPBI_taikytas_gydymas: ' + this.ESPBI_taikytas_gydymas)
                console.log('ESPBI_alergijos: ' + this.ESPBI_alergijos)
                console.log('ESPBI_apziuros_data: ' + this.ESPBI_apziuros_data)

                var apziuros_laikas_formatted = this.getFormattedTime(this.apziuros_laikas)
                var traumos_laikas_formatted = this.getFormattedTime(this.traumos_laikas)


                this.JSONarray.push({
                    pagrindine_informacija: {
                        vardas_pavarde: this.vardas_pavarde,
                        med_dok_nr: this.med_dok_nr,
                        apziuros_data: this.apziuros_data,
                        apziuros_laikas: apziuros_laikas_formatted,
                        but_pagalbos_kat: this.but_pagalbos_kat,
                    },
                    nusiskundimai: {
                        nusiskundimai: this.nusiskundimai,
                    },
                    kada_kur_ivyko_trauma: {
                        traumos_data: this.traumos_data,
                        traumos_laikas: traumos_laikas_formatted,
                        traumos_vieta: this.traumos_vieta,
                        traumos_aplinkybes: this.traumos_aplinkybes,
                        policija_informuota: this.policija_informuota,
                        vaiku_teises: this.vaiku_teises
                    },
                    traumuotos_vietos: this.selectedParts_render,
                    apziuros_duomenys: {
                        alergija: this.alergija,
                        alergija_kam: this.alergija_kam,
                        gretutines_ligos: this.gretutines_ligos,
                        gretutines_ligos_kokios: this.gretutines_ligos_kokios,
                        bendra_bukle: this.bendra_bukle,
                        temperatura: this.temperatura,
                        skausmas_balais: this.skausmas_balais,
                    },
                    papildomi_apziuros_duomenys: {
                        pradine_informacija: {
                            oda_gleivines_rausvos: this.oda_gleivines_rausvos,
                            oda_gleivines_blyskios: this.oda_gleivines_blyskios,
                            pilvas_minkstas: this.pilvas_minkstas,
                            pilvas_skausmingas: this.pilvas_skausmingas,
                            pilvas_itemptas: this.pilvas_itemptas,
                            kvepavimo_daznis: this.kvepavimo_daznis,
                            plauciu_auskultacija_k: this.plauciu_auskultacija_k,
                            plauciu_auskultacija_d: this.plauciu_auskultacija_d,
                            ssd: this.ssd,
                            aks: this.aks,
                            kpl: this.kpl,
                        },
                        galvos_traumos_papildomi_apziuros_duomenys: {
                            samones_sutrikimu_nebuvo: this.samones_sutrikimu_nebuvo,
                            buvo_be_samones: this.buvo_be_samones,
                            buvo_traukuliai: this.buvo_traukuliai,
                            pykino_veme: this.pykino_veme,
                            kita_anamneze_tekstas: this.kita_anamneze_tekstas,
                            samone_gks: this.samone_gks,
                            meninginiai_nera: this.meninginiai_nera,
                            meninginiai_abejotina: this.meninginiai_abejotina,
                            meninginiai_simptomai_tekstas: this.meninginiai_simptomai_tekstas,
                            zidinine_simptomatika_nera: this.zidinine_simptomatika_nera,
                            zidinine_simptomatika_abejotina: this.zidinine_simptomatika_abejotina,
                            zidinine_simptomatika_tekstas: this.zidinine_simptomatika_tekstas,
                            nistagmas_nera: this.nistagmas_nera,
                            nistagmas_yra_tekstas: this.nistagmas_yra_tekstas
                        },
                        tyrimai_ir_ju_interpretacija: {
                            rentgenograma: this.rentgenograma,
                            rentgenograma_nr: this.rentgenograma_nr,
                            rentgenograma_be_pakitimu: this.rentgenograma_be_pakitimu,
                            radiniai: this.radiniai,
                            tyrimai_radiniai_tekstas: this.tyrimai_radiniai_tekstas,
                            bendras_kraujo_tyrimas: this.bendras_kraujo_tyrimas,
                            slapimo_tyrimas: this.slapimo_tyrimas,
                            tyrimai_kiti: this.tyrimai_kiti,
                            tyrimai_kiti_tekstas: this.tyrimai_kiti_tekstas,
                            tlk_10_am: this.tlk_10_am,
                            //     {
                            //     code: this.tlk_10_am.code,
                            //     title: this.tlk_10_am.title,
                            //     type: this.tlk_10_am.type,
                            //     time: this.tlk_10_am.time
                            // },
                            dieta: this.dieta,
                            rezimas: this.rezimas,
                            nuskausminimas: this.nuskausminimas,
                            nuskausminimas_tekstas: this.nuskausminimas_tekstas,
                            repozicija: this.repozicija,
                            repozicija_tekstas: this.repozicija_tekstas,
                            imobilizacija: this.imobilizacija,
                            imobilizacija_tekstas: this.imobilizacija_tekstas,
                            zaizdos_sutvarkymas: this.zaizdos_sutvarkymas,
                            zaizda_susiuta: this.zaizda_susiuta,
                            zaizda_suklijuota: this.zaizda_suklijuota,
                            zaizda_tvarstis: this.zaizda_tvarstis,
                            nudegimo_sutvarkymas: this.nudegimo_sutvarkymas,
                            nudegimas_tvarstis: this.nudegimas_tvarstis,
                            nudegimo_sutvarkymas_kita: this.nudegimo_sutvarkymas_kita,
                            nudegimas_tekstas: this.nudegimas_tekstas,
                            gydymas_kita: this.gydymas_kita_tekstas,
                            imunizacija: this.imunizacija,
                            imunizacija_pasiutlige: this.imunizacija_pasiutlige,
                            imunizacija_stablige: this.imunizacija_stablige,
                        },

                    },
                    galutine_informacija: {
                        ambulatorinis_gydymas: this.ambulatorinis_gydymas,
                        stebejimo_paslauga: this.stebejimo_paslauga,
                        stacionarinis_gydymas: this.stacionarinis_gydymas,
                        stacionarinis_gydymas_skyriuje: this.stacionarinis_gydymas_skyriuje,
                        imobilizacijos_trukme: this.imobilizacijos_trukme,
                        rezimas_rekomendacija: this.rezimas_rekomendacija,
                        riboti_fizini_kruvi: this.riboti_fizini_kruvi,
                        perrisimai: this.perrisimai,
                        vakcinacija: this.vakcinacija,
                        medikamentai: this.medikamentai,
                        kontrole_pas_traumatologa: this.kontrole_pas_traumatologa,
                        siuntimas_ortopedinems: this.siuntimas_ortopedinems,
                        siuntimas_konsultuoti: this.siuntimas_konsultuoti,
                        rekomendacijos_kita: this.rekomendacijos_kita
                    }

                })

                var json = JSON.stringify(this.JSONarray, null, 10)
                console.log('JSON: ' + json)

            },

            GetList(query) {
                this.diagnosis_list = [];
                axios.get('/api/getDiagnosisList', {params: {CODE: query}})
                    .then(response => {
                        this.diagnosis_fakelist = response.data;
                        for (var a = 0; a < this.diagnosis_fakelist.length; a++) {
                            this.diagnosis_list.push({
                                "name": this.diagnosis_fakelist[a].CODE,
                                "code": this.diagnosis_fakelist[a].CODE,
                                "title": this.diagnosis_fakelist[a].TITLE,
                                "time":'',
                                "type":'',
                            });
                        }
                        this.isdiagnosis_list = true;
                        return this.diagnosis_list;

                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            checkRequired(){
               this.requiredFilled = true;
            },

            deleteItem (item) {
                const index = this.formos_list.indexOf(item)
                 var url_delete = '/api/getTraumFormos/' + this.formos_list[index].id;
                console.log(url_delete)
                confirm('Ar tikrai norite ištrinti šį įrašą?') && this.formos_list.splice(index, 1) && axios.delete(url_delete)
            },
            humanPartSelect(part) {
                this.selected_part = part;
                this.isSelected_part = true;
                console.log(this.selected_part);
            },

            arraySearch(array, search) {
                for(var a = 0; a < array.length; a++){
                    for(var b = 0; b < search.length; b++) {
                        if(array[a].name === search[b]) {
                            return true;
                        }
                    }
                }
            },

            humanPartSelectParams(params) {
                this.selectedParts.push({
                    name: this.selected_part,
                    params: params
                })
                console.log('params: ' + params[1])
                var selected = this.selected_part

                if(params.length>1) {
                    for(let a = 0; a < params.length; a++) {
                        this.selectedParts_render.push({
                            name: this.selected_part,
                            params: params[a]
                        })
                    }
                } else {
                    this.selectedParts_render.push({
                        name: this.selected_part,
                        params: params[0]
                    })
                }

                this.selected_part = '';
                this.isSelected_part = false;
                this.selectedHumanPartParams = [];
                console.log('selectedParts: ' + this.selectedParts)

            },
            // ignas pilde 2019-11-15

            // pasiemu varda ir pavarde
            GetPatientInformation(){
                axios.get('/api/getPatient',{params:{CODE:this.asmens_kodas}})
                    .then( response =>{
                        var info = response.data;
                        this.vardas_pavarde = info.display_name
                        return this.vardas_pavarde;
                    });
            },


            // ignas nebepildo


            // humanPart(part) {
            //     for(let a = 0; a < this.kuno_dalys.length; a++) {
            //         console.log('praejo ciklas: ' + a + 'kartu')
            //         if(part == this.kuno_dalys[a].name) {
            //             this.kuno_dalys[a].state = !this.kuno_dalys[a].state;
            //             if(this.kuno_dalys[a].state) {
            //                 this.body_selected.push(this.kuno_dalys[a].name)
            //             } else {
            //                 let index = this.body_selected.indexOf(this.kuno_dalys[a].name)
            //                 this.body_selected.splice(index, 1)
            //             }
            //             break;
            //         }
            //     }
            // }
        },
        beforeMount(){
            this.getFormosList();
        }
    }
</script>

<style scoped>

    .label {
        font-weight: 300 !important;
    }
    .ant-time-picker{
        margin-left:-20px;
    }
    .ant-time-picker >>> .ant-time-picker-icon {
        margin-right:15px;
    }
    >>> .multiselect__select {
        top: 12px;
        padding: 0px;
        text-align: inherit;
    }
    >>> .v-dialog:not(.v-dialog--fulscreen) {
        margin-top:0px;
    }
    .multiselect--active >>> .multiselect__select {
        transform: none;
    }

</style>
<style>
    .label {
        font-weight: 400 !important;
    }
    .human_button:hover {
        background-color:blue;
        opacity: 0.5;
        border-radius: 10px;
    }
    .human_button_selected {
        background-color:red;
        border-radius: 10px;
        opacity:1;
    }
    .theme--light.v-label {
        color: #000000;
        font-weight:400;

    }
    .box {
        box-shadow: 0 1px 1px rgba(0,0,0,1)
    }
</style>
