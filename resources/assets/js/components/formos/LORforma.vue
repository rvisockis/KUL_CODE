<template>
    <v-app>
        <div class="box">
            <div class="box-body">

                <div class="box-body" >
                    <div class="col-md-12">
                        <h4 style="text-align:center; margin-bottom:40px;">Priėmimo - skubiosios pagalbos skyriaus gydytojo otorinolaringologo paciento apžiūros, tyrimo ir gydymo lapas</h4>
                        <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:1px; margin-left:-20px; margin-right:15px;">
                            <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Pradinė informacija</label>

                            <v-text-field
                                v-model="vardas_pavarde"
                                label="Vardas, pavardė"
                                class="col-md-3"
                            ></v-text-field>
                            <v-menu
                                ref="menu"
                                v-model="datepicker_menu_gimimo_data"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                                style="top:200px;left:300px;"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        class="col-md-3"
                                        style="margin-top:5px;"
                                        v-model="gimimo_data"
                                        label="Gimimo data"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="gimimo_data" no-title  locale="lt" @input="datepicker_menu = false">
                                </v-date-picker>
                            </v-menu>
                            <v-text-field
                                v-model="med_dok_nr"
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
                                    <v-date-picker v-model="apziuros_data" no-title  locale="lt" @input="datepicker_menu = false">
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

                                <div class="col-md-12"><h4 style="text-align:center;">Diagnozės</h4></div>
                                <div class="col-md-12">
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
                            </div>
                            <div class="col-md-12">
                                <v-divider></v-divider>
                                <a-tabs>
                                    <a-tab-pane tab="Nusiskundimai" key="1">
                                        <v-textarea
                                            v-model="nusiskundimai"
                                            name="input-7-4"
                                            label="NUSISKUNDIMAI IR LIGOS ANAMNEZĖ"
                                        ></v-textarea>
                                    </a-tab-pane>

                                    <a-tab-pane tab="Gyvenimo anamnezė" key="2">
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
                                                    class="col-md-6"
                                                ></v-text-field>
                                            </div>
                                            <div class="col-md-6" >
                                                <v-switch v-model="WillBeOperated"  label="Ar numatoma operacija ?"></v-switch>
                                                <div v-if="WillBeOperated">
                                                    <label class="col-md-12" style="font-weight:500; margin-bottom:-20px; margin-left:-15px;">Kraujavimo, trombozių anamnezė</label>
                                                    <div class="col-md-12">
                                                    <v-radio-group v-model="OperationSelection" row>
                                                        <v-radio v-for="items in OperationOptions" :label="items" :value="items" ></v-radio>
                                                    </v-radio-group>
                                                    </div>
                                                    <div class="col-md-12" v-if="(OperationSelection.length>0)&&(OperationSelection!=='nebuvo')">
                                                        <v-text-field label="Kam ir kokie sutrikimai?" v-model="OperationSimptoms"></v-text-field>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="gretutines_ligos"
                                                    :label="`Gretutinės ligos`"
                                                ></v-checkbox>
                                                <v-text-field
                                                    v-model="kokios_gretutines_ligos"
                                                    v-if="gretutines_ligos"
                                                    label="Kokios gretutinės ligos:"
                                                    class="col-md-6"
                                                ></v-text-field>
                                            </div>

                                        </div>
                                    </a-tab-pane>

                                    <a-tab-pane tab="Kada, kur įvyko trauma" key="3">
                                        <div class="col-md-12">
                                            <label class="col-md-1" style="">Traumos data: </label>
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
                                                        class="col-md-3"
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
                                                           v-model="traumos_laikas"
                                                           placeholder="Laikas"
                                                           style="margin-left:10px;"/>
                                        </div>
                                        <v-text-field
                                            v-model="traumos_vieta"
                                            label="Traumos vieta:"
                                            class="col-md-4"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="traumos_aplinkybes"
                                            label="Traumos aplinkybės:"
                                            class="col-md-4"
                                        ></v-text-field>
                                        <v-checkbox
                                            v-model="tyrimai_alkoholiui"
                                            :label="`Tyrimai alkoholiui, narkotikams paimti`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="policija_informuota"
                                            :label="`Policija informuota`"
                                            class="col-md-4"
                                        ></v-checkbox>

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
                                            <img src="./zmogus_galvos.jpg" usemap="#image-map" style="display: block; margin-left:auto; margin-right: auto;">
                                            <map name="image-map">

                                                <area target=""  @click="humanPartSelect('Akis ir periokulinė sritis - dešinė')" alt="Akis ir periokulinė sritis (dešinė)" title="Akis ir periokulinė sritis (dešinė)"  coords="128,71,112,68,105,75,107,85,116,92,125,89,130,81" shape="poly">
                                                <area target=""  @click="humanPartSelect('Kakta - dešinė')" alt="Kakta (dešinė)" title="Kakta (dešinė)"  coords="107,33,98,48,95,59,105,70,114,64,127,64,127,54,118,39" shape="poly">
                                                <area target=""  @click="humanPartSelect('Momens sritis - dešinė')" alt="Momens sritis (dešinė)" title="Momens sritis (dešinė)"  coords="103,32,86,27,67,27,53,31,40,38,46,46,49,54,65,51,78,51,93,54" shape="poly">
                                                <area target=""  @click="humanPartSelect('Pakaušis - dešinė')" alt="Pakaušis (dešinė)" title="Pakaušis (dešinė)"  coords="37,40,43,47,46,56,41,65,37,77,36,87,37,102,30,99,24,92,21,76,26,52" shape="poly">
                                                <area target=""  @click="humanPartSelect('Smilkinys - dešinė')" alt="Smilkinys (dešinė)" title="Smilkinys (dešinė)"  coords="39,97,39,80,44,68,50,58,63,56,79,54,87,56,93,62,97,68,99,73,99,81,88,85,76,76,66,70,55,72,51,80,46,91" shape="poly">
                                                <area target=""  @click="humanPartSelect('Ausies kaušelis - dešinė')" alt="Ausies kaušelis (dešinė)" title="Ausies kaušelis (dešinė)"  coords="50,89,54,77,62,75,71,78,75,87,76,96,77,105,74,113,65,114,55,105,49,97" shape="poly">
                                                <area target=""  @click="humanPartSelect('Skruostas - dešinė')" alt="Skruostas (dešinė)" title="Skruostas (dešinė)"  coords="114,93,101,88,91,93,88,101,95,108,109,111,117,102" shape="poly">
                                                <area target=""  @click="humanPartSelect('Apatinis žandikaulis - dešinė')" alt="Apatinis žandikaulis (dešinė)" title="Apatinis žandikaulis (dešinė)"  coords="75,113,81,107,87,107,91,110,96,113,105,116,106,123,105,131,105,138,98,138,84,131,76,125" shape="poly">
                                                <area target=""  @click="humanPartSelect('Nosis - dešinė')" alt="Nosis (dešinė)" title="Nosis (dešinė)"  coords="132,81,127,90,121,95,122,109,133,108,143,105,144,97,136,88" shape="poly">
                                                <area target=""  @click="humanPartSelect('Lūpos')" alt="Lūpos" title="Lūpos"  coords="134,110,121,111,115,118,117,125,130,129,140,118" shape="poly">
                                                <area target=""  @click="humanPartSelect('Smakras')" alt="Smakras" title="Smakras"  coords="129,132,113,126,105,142,116,148,127,148,134,139" shape="poly">
                                                <area target=""  @click="humanPartSelect('Kaklas - dešinė')" alt="Kaklas (dešinė)" title="Kaklas (dešinė)"  coords="35,154,39,144,39,137,40,130,39,121,38,112,33,103,45,107,52,113,59,115,66,117,71,121,73,129,80,133,88,137,96,140,104,143,98,149,99,155,96,162,94,166,61,164" shape="poly">
                                                <area target=""  @click="humanPartSelect('Akis ir periokulinė sritis - kairė')" alt="Akis ir periokulinė sritis (kairė)" title="Akis ir periokulinė sritis (kairė)"  coords="60,341,71,339,80,344,84,351,82,361,76,366,64,364,57,355" shape="poly">
                                                <area target=""  @click="humanPartSelect('Kakta - kairė')" alt="Kakta (kairė)" title="Kakta (kairė)"  coords="61,338,72,337,80,341,86,327,87,318,83,311,80,304,71,311,64,321" shape="poly">
                                                <area target=""  @click="humanPartSelect('Momens sritis - kairė')" alt="Momens sritis (kairė)" title="Momens sritis (kairė)"  coords="82,304,85,310,89,317,101,315,116,317,126,321,136,327,143,322,150,314,138,305,122,300,102,299,88,300" shape="poly">
                                                <area target=""  @click="humanPartSelect('Pakaušis - kairė')" alt="Pakaušis (kairė)" title="Pakaušis (kairė)"  coords="138,328,145,324,151,316,158,323,163,334,164,344,165,355,166,363,162,369,154,377,151,362,148,347,143,335" shape="poly">
                                                <area target=""  @click="humanPartSelect('Smilkinys - kairė')" alt="Smilkinys (kairė)" title="Smilkinys (kairė)"  coords="83,342,89,328,90,319,101,317,114,319,125,324,134,331,141,340,145,350,147,359,149,370,144,376,137,370,137,362,134,351,124,345,108,337,96,338" shape="poly">
                                                <area target=""  @click="humanPartSelect('Ausies kaušelis - kairė')" alt="Ausies kaušelis (kairė)" title="Ausies kaušelis (kairė)"  coords="112,362,115,352,123,349,131,352,134,360,133,371,129,379,124,385,116,388,110,382,109,372" shape="poly">
                                                <area target=""  @click="humanPartSelect('Skruostas - kairė')" alt="Skruostas (kairė)" title="Skruostas (kairė)"  coords="71,378,73,368,86,364,95,366,101,373,95,380,82,385" shape="poly">
                                                <area target=""  @click="humanPartSelect('Apatinis žandikaulis - kairė')" alt="Apatinis žandikaulis (kairė)" title="Apatinis žandikaulis (kairė)"  coords="108,386,99,381,88,386,79,391,74,400,73,411,77,412,89,408,98,405,108,401,112,393" shape="poly">
                                                <area target=""  @click="humanPartSelect('Nosis - kairė')" alt="Nosis (kairė)" title="Nosis (kairė)"  coords="48,362,54,355,61,363,67,368,66,377,54,377,46,373,44,369" shape="poly">
                                                <area target=""  @click="humanPartSelect('Burnos ertmė')" alt="Burnos ertmė " title="Burnos ertmė "  coords="50,382,58,379,67,380,71,386,70,394,64,400,55,399,49,394" shape="poly">
                                                <area target=""  @click="humanPartSelect('Smakras')" alt="Smakras" title="Smakras"  coords="55,401,63,402,70,402,71,406,70,414,63,416,55,414,53,407" shape="poly">
                                                <area target=""  @click="humanPartSelect('kaklas - kairė')" alt="Kaklas (kairė)" title="Kaklas (kairė)"  coords="151,379,141,383,135,389,125,390,115,392,113,400,107,406,96,411,87,413,83,416,86,420,85,425,87,432,89,439,100,439,117,443,131,433,143,429,150,428,147,419,146,408,148,396,151,386" shape="poly">


                                            </map>
                                            <v-data-table
                                                :headers="headers"
                                                :items="selectedParts_render"
                                                class="elevation-6"
                                                :rows-per-page-items=[15]
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
                                        <label class="col-md-2" style="margin-top:15px;">Sąmonė:</label>
                                        <v-checkbox
                                            class="col-md-2"
                                            v-model="samone_normali"
                                            :label="`normali`"
                                        ></v-checkbox>
                                        <v-checkbox
                                            class="col-md-2"
                                            v-model="samone_vangus"
                                            :label="`vangus`"
                                        ></v-checkbox>
                                        <v-checkbox
                                            class="col-md-2"
                                            v-model="samone_dirglus"
                                            :label="`dirglus`"
                                        ></v-checkbox>
                                        <v-checkbox
                                            class="col-md-2"
                                            style="margin-top:5px;"
                                            v-model="samone_be"
                                            :label="`be sąmonės`"
                                        ></v-checkbox>
                                        <label class="col-md-12" style="">Oda, gleivinės</label>
                                        <v-checkbox
                                            v-model="oda_gleivines_dregnos"
                                            :label="`drėgnos`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="oda_gleivines_sausos"
                                            :label="`sausos`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="oda_gleivines_kita"
                                            :label="`kita`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-text-field
                                            v-model="oda_gleivines_kita_tekstas"
                                            v-if="oda_gleivines_kita"
                                            label="įrašykite"
                                            class="col-md-12"
                                        ></v-text-field>
                                        <label class="col-md-12" style="">Pulsas (a.radialis):</label>
                                        <v-checkbox
                                            v-model="pulsas_normalus"
                                            :label="`normalus`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="pulsas_silpnas"
                                            :label="`silpnas`"
                                            class="col-md-4"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="pulsas_neciuopiamas"
                                            :label="`nečiuopiamas`"
                                            class="col-md-4"
                                        ></v-checkbox>

                                    </a-tab-pane>

                                    <a-tab-pane tab="Tyrimai" key="6">
                                        <div class="col-md-12">
                                            <div class="col-md-6" style="border-style:solid; border-width: 0 1px 0 0;">
                                                <label class="col-md-12" style="text-align:center;">Tyrimų planas:</label>
                                                <div class="col-md-12" style="padding-top:0px; padding-bottom:0px; ">
                                                <v-checkbox
                                                    v-model="kraujo_tyrimas"
                                                    :label="`1. b. kraujo tyrimas`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-if="kraujo_tyrimas"
                                                    v-model="kraujo_tyrimas_ambulatoriskai"
                                                    :label="`atliktas ambulatoriškai`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                </div>

                                                <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="slapimo_tyrimas"
                                                    :label="`2. šlapimo tyrimas`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-if="slapimo_tyrimas"
                                                    v-model="slapimo_tyrimas_ambulatoriskai"
                                                    :label="`atliktas ambulatoriškai`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                </div>

                                                <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="kresejimas"
                                                    :label="`3. krešėjimas`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-if="kresejimas"
                                                    v-model="kresejimas_ambulatoriskai"
                                                    :label="`atliktas ambulatoriškai`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                </div>

                                                <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="glikemija"
                                                    :label="`4. glikemija`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-if="glikemija"
                                                    v-model="glikemija_ambulatoriskai"
                                                    :label="`atliktas ambulatoriškai`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                </div>

                                                <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="ekg"
                                                    :label="`5. EKG`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-if="ekg"
                                                    v-model="ekg_ambulatoriskai"
                                                    :label="`atliktas ambulatoriškai`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                </div>

                                                <div class="col-md-12">
                                                <v-checkbox
                                                    v-model="rentgenograma"
                                                    :label="`6. rentgenograma`"
                                                    class="col-md-12"
                                                ></v-checkbox>
                                                <v-text-field
                                                    v-model="rentgenograma_nr"
                                                    v-if="rentgenograma"
                                                    label=""
                                                    prefix="Nr."
                                                    class="col-md-6"
                                                ></v-text-field>
                                                <v-checkbox
                                                    v-model="rentgenograma_be_pakitimu"
                                                    v-if="rentgenograma"
                                                    :label="`- be pakitimų`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-model="anesteziologo_konsultacija"
                                                    :label="`7. anesteziologo konsultacija`"
                                                    class="col-md-12"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-model="vaiku_gyd_konsultacija"
                                                    :label="`8. vaikų lygų gydytojo konsultacija`"
                                                    class="col-md-12"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-model="tyrimu_planas_kita"
                                                    :label="`9. kita`"
                                                    class="col-md-12"
                                                ></v-checkbox>
                                                <v-text-field
                                                    v-model="tyrimu_planas_kita_tekstas"
                                                    v-if="tyrimu_planas_kita"
                                                    label="įrašykite"
                                                    class="col-md-12"
                                                ></v-text-field>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-md-12" style="text-align:center;">Tyrimų interpretacija:</label>
                                                <div class="col-md-12">
                                                    <v-checkbox
                                                        v-if="kraujo_tyrimas"
                                                        v-model="kraujo_tyrimo_interpretacija_norma"
                                                        :label="`1. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="kraujo_tyrimas"
                                                        v-model="kraujo_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="kraujo_tyrimo_interpretacija_tekstas"
                                                        v-if="kraujo_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                    <v-checkbox
                                                        v-if="slapimo_tyrimas"
                                                        v-model="slapimo_tyrimo_interpretacija_norma"
                                                        :label="`2. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="slapimo_tyrimas"
                                                        v-model="slapimo_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="slapimo_tyrimo_interpretacija_tekstas"
                                                        v-if="slapimo_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                    <v-checkbox
                                                        v-if="kresejimas"
                                                        v-model="kresejimo_tyrimo_interpretacija_norma"
                                                        :label="`3. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="kresejimas"
                                                        v-model="kresejimo_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="kresejimo_tyrimo_interpretacija_tekstas"
                                                        v-if="kresejimo_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                    <v-checkbox
                                                        v-if="glikemija"
                                                        v-model="glikemijos_tyrimo_interpretacija_norma"
                                                        :label="`4. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="glikemija"
                                                        v-model="glikemijos_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="glikemijos_tyrimo_interpretacija_tekstas"
                                                        v-if="glikemijos_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                    <v-checkbox
                                                        v-if="ekg"
                                                        v-model="ekg_tyrimo_interpretacija_norma"
                                                        :label="`5. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="ekg"
                                                        v-model="ekg_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="ekg_tyrimo_interpretacija_tekstas"
                                                        v-if="ekg_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                    <v-checkbox
                                                        v-if="tyrimu_planas_kita"
                                                        v-model="kito_tyrimo_interpretacija_norma"
                                                        :label="`9. norma`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                        v-if="tyrimu_planas_kita"
                                                        v-model="kito_tyrimo_interpretacija_pakitimai"
                                                        :label="`pakitimai`"
                                                        class="col-md-6"
                                                    ></v-checkbox>
                                                    <v-text-field
                                                        v-model="kito_tyrimo_interpretacija_tekstas"
                                                        v-if="kito_tyrimo_interpretacija_pakitimai"
                                                        label="įrašykite"
                                                        class="col-md-12"
                                                        style="margin-top:-30px;"
                                                    ></v-text-field>
                                                </div>
                                            </div>
                                        </div>
                                    </a-tab-pane>
                                </a-tabs>
                            </div>

                        </div>
                        <div class="col-md-6" style="border-style:outset;border-radius:10px;border-width:2px;">
                            <div class="col-md-12">
                                <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Galutinė informacija</label>

                                <v-expansion-panels>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header style="font-size:16px;">Kvėpavimas, širdies veikla</v-expansion-panel-header>
                                        <v-expansion-panel-content>

                                            <v-text-field
                                                v-model="kvepavimo_daznis"
                                                label="Kvėpavimo dažnis"
                                                class="col-md-12"
                                                suffix="k/min"
                                            ></v-text-field>
                                            <label class="col-md-2" style="margin-top:18px;">Širdies veikla:</label>
                                            <v-checkbox
                                                v-model="sirdies_veikla_ritmiska"
                                                :label="`ritmiška`"
                                                class="col-md-5"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="sirdies_veikla_aritmiska"
                                                :label="`aritmiška`"
                                                style="margin-left:-30px;"
                                                class="col-md-5"
                                            ></v-checkbox>
                                            <v-text-field
                                                v-model="ssd"
                                                label="ŠSD"
                                                class="col-md-6"
                                                suffix="k/min"
                                            ></v-text-field>
                                            <v-text-field
                                                v-model="aks"
                                                label="AKS"
                                                class="col-md-6"
                                                suffix="mmHg"
                                            ></v-text-field>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header style="font-size:16px;">Specialioji būklė</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <label class="col-md-12" style="margin-top:18px; font-size:16px;">Specialioji būklė:</label>
                                            <label class="col-md-2" style="margin-top:18px;">Otoskopija:</label>
                                            <label class="col-md-2" style="margin-top:18px; margin-right:-60px;">AD</label>
                                            <v-checkbox
                                                v-model="ad_be_pakitimu"
                                                :label="`be pakitimų`"
                                                class="col-md-4"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="ad_pakitimai"
                                                :label="`pakitimai`"
                                                class="col-md-4"
                                            ></v-checkbox>
                                            <v-text-field
                                                v-if="ad_pakitimai"
                                                v-model="ad_pakitimai_tekstas"
                                                label="įrašyti"
                                                class="col-md-12"
                                            ></v-text-field>
                                            <div class="col-md-2"></div>
                                            <label class="col-md-2" style="margin-top:18px; margin-right:-60px;">AS</label>
                                            <v-checkbox
                                                v-model="as_be_pakitimu"
                                                :label="`be pakitimų`"
                                                class="col-md-4"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="as_pakitimai"
                                                :label="`pakitimai`"
                                                class="col-md-4"
                                            ></v-checkbox>
                                            <v-text-field
                                                v-if="as_pakitimai"
                                                v-model="as_pakitimai_tekstas"
                                                label="įrašyti"
                                                class="col-md-12"
                                            ></v-text-field>
                                            <label class="col-md-12" style="margin-top:18px;">Klausa:</label>
                                            <label class="col-md-2" style="margin-top:18px; margin-right:-60px;">AD / AS</label>
                                            <v-text-field
                                                v-model="klausa"
                                                class="col-md-10"
                                            ></v-text-field>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header style="font-size:16px;">Rinoskopija, faringoskopija</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <label class="col-md-12" style="margin-top:18px; font-size:16px;">Rinoskopija priekinė:</label>
                                            <label class="col-md-2" style="margin-top:10px; margin-right:-50px;">nosies pertvara</label>
                                            <v-text-field
                                                v-model="nosies_pertvara"
                                                class="col-md-10"
                                            ></v-text-field>
                                            <label class="col-md-2" style="margin-top:10px; margin-right:-50px;">gleivinė</label>
                                            <v-text-field
                                                v-model="gleivine"
                                                class="col-md-10"
                                            ></v-text-field>
                                            <label class="col-md-2" style="margin-top:10px; margin-right:-50px;">apatinės kriauklės</label>
                                            <v-text-field
                                                v-model="apatines_kriaukles"
                                                class="col-md-10"
                                            ></v-text-field>
                                            <label class="col-md-3" style="margin-top:18px; font-size:16px; margin-right:-60px;">Rinoskopija užpakalinė:</label>
                                            <v-text-field
                                                v-model="nosies_pertvara"
                                                class="col-md-9"
                                            ></v-text-field>
                                            <label class="col-md-12" style="margin-top:18px; font-size:16px;">Faringoskopija:</label>
                                            <label class="col-md-2" style="margin-top:10px; margin-right: -20px;">ryklės gleivinė</label>
                                            <v-text-field
                                                v-model="faringoskopija_rykles_gleivine"
                                                class="col-md-10"
                                            ></v-text-field>
                                            <label class="col-md-12" style="margin-top:18px; font-size:16px;">Kita:</label>
                                            <v-text-field
                                                v-model="galutine_info_kita"
                                                class="col-md-12"
                                            ></v-text-field>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header style="font-size:16px;">Išvados</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <label class="col-md-12" style="margin-top:18px; font-size:16px;">Diagnozė:</label>
                                            <v-text-field
                                                v-model="galutine_info_diagnoze"
                                                class="col-md-12"
                                            ></v-text-field>
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
                                                v-if="stacionarinis_gydymas"
                                                label="skyriuje"
                                                class="col-md-2"
                                                style="margin-left:-30px;"
                                            ></v-text-field>
                                            <label class="col-md-12" style="margin-top:30px;">Rekomendacijos (ambulatoriniam gydymui): </label>
                                            <v-text-field
                                                v-model="galutine_info_rekomendacijos"
                                                class="col-md-12"
                                            ></v-text-field>

                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                </v-expansion-panels>



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
                            <div class="col-md-12">
                                <v-btn style="margin-left:50%; margin-right:50%" large color="primary" @click="generateJSON">Užbaigti</v-btn>
                            </div>
                        </div>
                        <!--<div class="col-md-6" style="border-style:outset;border-radius:10px;border-width:2px;">-->

                        <!--</div>-->



                    </div>
                </div>
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
                //Ignas
                MainDiagnosis:[],
                TimeValue:moment(),
                //ignas baigias

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
                diagnosis_list: [],
                diagnosis_fakelist: [],
                isdiagnosis_list: false,

                headers: [
                    {
                        text: 'Traumos vieta',
                        align: 'left',
                        sortable: true,
                        value: 'name'
                    },
                    { text: 'Rūšis', value: 'params', divider: true},
                    { text: 'Ištrinti', value: 'action', sortable: false, align: 'center' }
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
                kokios_gretutines_ligos: '',
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
                tlk_10_am: '',
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
                datepicker_menu_gimimo_data: false,
                gimimo_data: '',
                WillBeOperated:false,
                OperationOptions:['nebuvo','nežino','buvo','pacientui','šeimos nariams'],
                OperationSelection:[],
                OperationSimptoms: '',
                tyrimai_alkoholiui: false,
                samone_normali: false,
                samone_vangus: false,
                samone_dirglus: false,
                samone_be: false,
                oda_gleivines_dregnos: false,
                oda_gleivines_sausos: false,
                oda_gleivines_kita: false,
                oda_gleivines_kita_tekstas: '',
                pulsas_normalus: false,
                pulsas_silpnas: false,
                pulsas_neciuopiamas: false,
                kraujo_tyrimas: false,
                kraujo_tyrimas_ambulatoriskai: false,
                slapimo_tyrimas: false,
                slapimo_tyrimas_ambulatoriskai: false,
                kresejimas: false,
                kresejimas_ambulatoriskai: false,
                glikemija: false,
                glikemija_ambulatoriskai: false,
                ekg: false,
                ekg_ambulatoriskai: false,
                anesteziologo_konsultacija: false,
                vaiku_gyd_konsultacija: false,
                tyrimu_planas_kita: false,
                tyrimu_planas_kita_tekstas: '',
                kraujo_tyrimo_interpretacija_norma: false,
                kraujo_tyrimo_interpretacija_pakitimai: false,
                kraujo_tyrimo_interpretacija_tekstas: '',
                slapimo_tyrimo_interpretacija_norma: false,
                slapimo_tyrimo_interpretacija_pakitimai: false,
                slapimo_tyrimo_interpretacija_tekstas: '',
                kresejimo_tyrimo_interpretacija_norma: false,
                kresejimo_tyrimo_interpretacija_pakitimai: false,
                kresejimo_tyrimo_interpretacija_tekstas: '',
                glikemijos_tyrimo_interpretacija_norma: false,
                glikemijos_tyrimo_interpretacija_pakitimai: false,
                glikemijos_tyrimo_interpretacija_tekstas: '',
                ekg_tyrimo_interpretacija_norma: false,
                ekg_tyrimo_interpretacija_pakitimai: false,
                ekg_tyrimo_interpretacija_tekstas: '',
                kito_tyrimo_interpretacija_norma: false,
                kito_tyrimo_interpretacija_pakitimai: false,
                kito_tyrimo_interpretacija_tekstas: '',
                sirdies_veikla_ritmiska: false,
                sirdies_veikla_aritmiska: false,
                ad_be_pakitimu: false,
                ad_pakitimai: false,
                ad_pakitimai_tekstas: '',
                as_be_pakitimu: false,
                as_pakitimai: false,
                as_pakitimai_tekstas: '',
                klausa: '',
                nosies_pertvara: '',
                gleivine: '',
                apatines_kriaukles: '',
                rinoskopija_uzpakaline: '',
                faringoskopija_rykles_gleivine: '',
                galutine_info_kita: '',
                galutine_info_diagnoze: '',
                galutine_info_rekomendacijos: '',
                tlk_10_am: [],




                JSONarray: [],









                balai: ['0','1','2','3','4','5','6','7','8','9','10'],
                lang: 'lt',
                locals,
                humanPartParams: [' Paraudimas ','Patinimas ','Kraujosrūva ','Deformacija ','Nubrozdinimas ',' Žaizda (durtinė, pjautinė, kirstinė, kąstinė, traiškyta) ',
                    'Šautinė žaizda ','Išnirimas ','Uždaras lūžimas ','Atviras lūžimas ', 'Nudegimas ','Nušalimas '],
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

            getFormattedTime(x) {
                var today = x;
                today = moment(today).format('HH:mm')
                return today;
            },

            moment,

            generateJSON(){
                this.JSONarray = [];

                var apziuros_laikas_formatted = this.getFormattedTime(this.apziuros_laikas)
                var traumos_laikas_formatted = this.getFormattedTime(this.traumos_laikas)


                this.JSONarray.push({
                    pagrindine_informacija: {
                        vardas_pavarde: this.vardas_pavarde,
                        med_dok_nr: this.med_dok_nr,
                        gimimo_data: this.gimimo_data,
                        apziuros_data: this.apziuros_data,
                        apziuros_laikas: apziuros_laikas_formatted,
                        but_pagalbos_kat: this.but_pagalbos_kat,
                    },

                    tlk_10_am: this.tlk_10_am,
                    nusiskundimai: this.nusiskundimai,

                    gyvenimo_anamneze: {
                        alergija: this.alergija,
                        alergija_kam: this.alergija_kam,
                        numatoma_operacija: this.WillBeOperated,
                        kraujavimo_tromboziu_anamneze: this.OperationSelection,
                        sutrikimai: this.OperationSimptoms,
                        gretutines_ligos: this.gretutines_ligos,
                        gretutines_ligos_kokios: this.gretutines_ligos_kokios

                    },
                    kada_kur_ivyko_trauma: {
                        traumos_data: this.traumos_data,
                        traumos_laikas: traumos_laikas_formatted,
                        traumos_vieta: this.traumos_vieta,
                        traumos_aplinkybes: this.traumos_aplinkybes,
                        tyrimai_alkoholiui: this.tyrimai_alkoholiui,
                        policija_informuota: this.policija_informuota,
                    },

                    traumuotos_vietos: {
                        pavadinimas_rusis: this.selectedParts_render
                    },

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
                            samone_gks: this.samones_sutrikimu_nebuvo,
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
                            diagnoze: this.diagnoze,
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
                            gydymas_kita: this.gydymas_kita_tekstas,
                            imunizacija: this.imunizacija,
                            imunizacija_pasiutlige: this.imunizacija_pasiutlige,
                            imunizacija_stablige: this.imunizacija_pasiutlige,
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

            deleteItem (item) {
                const index = this.selectedParts_render.indexOf(item)
                // var url_delete = '/api/getPaslaugosListPage/' + this.paslaugos_list_page[index].id;
                confirm('Ar tikrai norite ištrinti šį įrašą?') && this.selectedParts_render.splice(index, 1)
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

            //Igno funkcijos

            remove(DeletedDiagnosis){
                if (DeletedDiagnosis.code===this.MainDiagnosis){
                    if (DeletedDiagnosis.code===this.tlk_10_am[0].code && this.tlk_10_am[1] ){
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
