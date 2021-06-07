<template>
    <v-app>
        <div class="box">
            <div class="box-body">

                <div class="box-body" >
                    <div class="col-md-12">
                        <h4 style="text-align:center; margin-bottom:40px;">Priėmimo - skubiosios pagalbos skyriaus vaikų ligų gydytojo ambulatorinio paciento apžiūros, tyrimo ir gydymo lapas</h4>
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
                                <v-date-picker v-model="apziuros_data" no-title  locale="lt" @input="datepicker_menu = false">
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
                                        <div class="col-md-6">
                                            <label class="col-md-12" style="">Valgymas:</label>
                                            <v-radio-group class="col-md-12" v-model="valgymas" row>
                                                <v-radio label="kaip įprastai" value="kaip_iprastai"></v-radio>
                                                <v-radio label="pablogėjęs apetitas" value="pablogejes_apetitas"></v-radio>
                                                <v-radio label="atsisako valgyti" value="atsisako_valgyti"></v-radio>
                                            </v-radio-group>
                                            <v-checkbox
                                                v-model="alergija"
                                                :label="`Alergija`"
                                                class="col-md-12"
                                            ></v-checkbox>
                                            <v-text-field
                                                v-model="alergija_kam"
                                                v-if="alergija"
                                                label="Alergija kam:"
                                                class="col-md-12"
                                            ></v-text-field>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-12" style="">Epidemiologinė anamnezė:</label>
                                            <v-radio-group class="col-md-12" v-model="epidemiologine_anamneze" row>
                                                <v-radio label="kontakto nebuvo" value="kontakto_nebuvo"></v-radio>
                                                <v-radio label="nežino" value="nezino"></v-radio>
                                                <v-radio label="buvo" value="buvo"></v-radio>
                                            </v-radio-group>
                                            <v-text-field
                                                v-model="epidemiologine_anamneze_tekstas"
                                                v-if="epidemiologine_anamneze == 'buvo'"
                                                label="įrašyti"
                                                class="col-md-12"
                                            ></v-text-field>
                                        </div>
                                    </a-tab-pane>

                                    <a-tab-pane tab="Apžiūros duomenys, I dalis" key="2">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <v-text-field
                                                    v-model="temperatura"
                                                    label="Temperatūra:"
                                                    suffix="°C"
                                                ></v-text-field>
                                                <v-select
                                                    v-model="bendra_bukle"
                                                    :items="bukle"
                                                    label="Bendra būklė"
                                                ></v-select>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Pulsas (a.radialis):</label>
                                                <v-radio-group class="col-md-12" v-model="pulsas">
                                                    <v-radio label="normalus" value="normalus"></v-radio>
                                                    <v-radio label="silpnas" value="silpnas"></v-radio>
                                                    <v-radio label="nečiuopiamas" value="neciuopiamas"></v-radio>
                                                </v-radio-group>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Bėrimas/Patinimas:</label>
                                                <v-radio-group class="col-md-12" v-model="berimas">
                                                    <v-radio label="nėra" value="nėra"></v-radio>
                                                    <v-radio label="yra" value="yra"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    style="margin-top:-30px;"
                                                    v-if="berimas == 'yra'"
                                                    v-model="berimas_koks"
                                                    label="įrašykite"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Gleivinės:</label>
                                                <v-radio-group class="col-md-12" v-model="gleivines">
                                                    <v-radio label="drėgnos" value="drėgnos"></v-radio>
                                                    <v-radio label="sausos" value="sausos"></v-radio>
                                                    <v-radio label="bėrimas" value="bėrimas"></v-radio>

                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    style="margin-top:-30px;"
                                                    v-if="gleivines == 'bėrimas'"
                                                    v-model="gleivines_berimas"
                                                    label="įrašykite"
                                                ></v-text-field>


                                            </div>
                                            <div class="col-md-6" >
                                                <v-select
                                                    v-model="skausmas_balais"
                                                    :items="balai"
                                                    label="Skausmas balais"
                                                ></v-select>
                                                <v-text-field
                                                    v-model="kpl"
                                                    label="KPL"
                                                    suffix="sek."
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Oda:</label>
                                                <v-radio-group class="col-md-12" v-model="oda">
                                                    <v-radio label="šilta" value="šilta"></v-radio>
                                                    <v-radio label="vėsi" value="vėsi"></v-radio>
                                                    <v-radio label="rausva" value="rausva"></v-radio>
                                                    <v-radio label="blyški" value="blyški"></v-radio>
                                                </v-radio-group>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Audinių turgoras:</label>
                                                <v-radio-group class="col-md-12" v-model="audiniu_turgoras">
                                                    <v-radio label="išlaikytas" value="išlaikytas"></v-radio>
                                                    <v-radio label="sumažėjęs" value="sumažėjęs"></v-radio>
                                                </v-radio-group>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Liežuvis:</label>
                                                <v-radio-group class="col-md-12" v-model="liezuvis">
                                                    <v-radio label="drėgnas" value="drėgnas"></v-radio>
                                                    <v-radio label="sausas" value="sausas"></v-radio>
                                                    <v-radio label="su apnašu" value="su apnašu"></v-radio>
                                                </v-radio-group>

                                        </div>
                                        </div>
                                    </a-tab-pane>

                                    <a-tab-pane tab="Apžiūros duomenys, II dalis" key="3">
                                        <div class="col-md-12">

                                            <div class="col-md-6">
                                                <label class="col-md-12" style="margin-bottom:-20px;">Kataro reiškiniai:</label>
                                                <v-radio-group class="col-md-12" v-model="kataro_reiskiniai" row>
                                                    <v-radio label="ne" value="ne"></v-radio>
                                                    <v-radio label="taip" value="taip"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    style="margin-top:-30px;"
                                                    v-if="kataro_reiskiniai == 'taip'"
                                                    v-model="kataro_reiskiniai_taip"
                                                    label="įrašykite"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-bottom:-20px;">Tonzilės:</label>
                                                <v-radio-group class="col-md-12" v-model="tonziles" row>
                                                    <v-radio label="ramios" value="ramios"></v-radio>
                                                    <v-radio label="paraudusios" value="paraudusios"></v-radio>
                                                    <v-radio label="hipertrofiškos" value="hipertrofiškos"></v-radio>
                                                    <v-radio label="su pūlinukais" value="su pūlinukais"></v-radio>                                                    <v-radio label="hipertrofiškos" value="hipertrofiškos"></v-radio>
                                                    <v-radio label="pūlingu apnašu" value="hipertrofiškos"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    style="margin-top:-30px;"
                                                    v-model="plauciu_auskultacija"
                                                    label="Plaučių auskultacija"
                                                ></v-text-field>
                                                <label class="col-md-2" style="margin-top:5px;">Širdies veikla:</label>
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
                                                <v-text-field
                                                    v-model="sirdies_veikla_kita"
                                                    label="kiti požymiai"
                                                    class="col-md-12"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Šlapinasi:</label>
                                                <v-radio-group class="col-md-12" v-model="slapinasi" row>
                                                    <v-radio label="įprastai" value="įprastai"></v-radio>
                                                    <v-radio label="dizurija" value="dizurija"></v-radio>
                                                    <v-radio label="sumažėjusi diurezė" value="sumažėjusi diurezė"></v-radio>
                                                    <v-radio label="anurija" value="anurija"></v-radio>
                                                    <v-radio label="retencija" value="retencija"></v-radio>
                                                </v-radio-group>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Meninginiai simptomai:</label>
                                                <v-radio-group class="col-md-12" v-model="simptomai_meninginiai" row>
                                                    <v-radio label="nėra" value="nėra"></v-radio>
                                                    <v-radio label="abejotini" value="abejotini"></v-radio>
                                                    <v-radio label="yra" value="yra"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-if="simptomai_meninginiai == 'yra'"
                                                    v-model="meninginiai_simptomai_yra"
                                                    label="įrašykite"
                                                    style="margin-top:-30px;"
                                                ></v-text-field>

                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Židininė neurologinė simptomatika:</label>
                                                <v-radio-group class="col-md-12" v-model="zidinine_neurologine_simptomatika" row>
                                                    <v-radio label="nėra" value="nėra"></v-radio>
                                                    <v-radio label="yra" value="yra"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-if="zidinine_neurologine_simptomatika == 'yra'"
                                                    v-model="zidinine_neurologine_simptomatika_yra"
                                                    label="įrašykite"
                                                    style="margin-top:-30px;"
                                                ></v-text-field>

                                            </div>


                                            <div class="col-md-6">
                                                <label class="col-md-12" style="margin-bottom:-20px;">Kvėpavimas:</label>
                                                <div class="col-md-6">
                                                    <v-radio-group class="col-md-12" v-model="kvepavimas" row>
                                                        <v-radio label="normalus" value="normalus"></v-radio>
                                                        <v-radio label="stridoras" value="stridoras"></v-radio>
                                                        <v-radio label="švokštimas" value="švokštimas"></v-radio>
                                                        <v-radio label="kvėpavime dalyvauja pagalbiniai raumenys" value="kiti raumenys"></v-radio>
                                                    </v-radio-group>
                                                </div>
                                                <div class="col-md-6">
                                                    <v-text-field
                                                        class="col-md-12"
                                                        v-model="kd"
                                                        label="KD"
                                                        suffix="k/min."
                                                    ></v-text-field>
                                                    <v-text-field
                                                        class="col-md-12"
                                                        v-model="spo2"
                                                        label="SpO₂"
                                                        suffix="k/min."
                                                    ></v-text-field>
                                                </div>

                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Pilvas:</label>
                                                <v-checkbox
                                                    v-model="pilvas_minkstas"
                                                    :label="`minkštas`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-checkbox
                                                    v-model="pilvas_skausmingas"
                                                    :label="`skausmingas`"
                                                    class="col-md-6"
                                                ></v-checkbox>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-if="pilvas_skausmingas"
                                                    v-model="pilvas_skausmingas_tekstas"
                                                    label="įrašykite"
                                                ></v-text-field>
                                                <v-text-field
                                                    v-model="kepenys"
                                                    label="Kepenys"
                                                    class="col-md-12"
                                                ></v-text-field>
                                                <v-text-field
                                                    v-model="bluznis"
                                                    label="Blužnis"
                                                    class="col-md-12"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Žarnų peristaltika:</label>
                                                <v-radio-group class="col-md-12" v-model="zarnu_peristaltika" row>
                                                    <v-radio label="yra" value="yra"></v-radio>
                                                    <v-radio label="nėra" value="nėra"></v-radio>
                                                    <v-radio label="vangi" value="vangi"></v-radio>
                                                    <v-radio label="pagyvėjusi" value="pagyvėjusi"></v-radio>
                                                </v-radio-group>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Tuštinasi:</label>
                                                <v-radio-group class="col-md-12" v-model="tustinasi" row>
                                                    <v-radio label="įprastai" value="įprastai"></v-radio>
                                                    <v-radio label="skystai" value="skystai"></v-radio>
                                                    <v-radio label="obstipacija" value="obstipacija"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-if="tustinasi == 'obstipacija'"
                                                    v-model="obstipacija"
                                                    label="įrašykite"
                                                    style="margin-top:-30px;"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Galūnių judėsiai:</label>
                                                <v-radio-group class="col-md-12" v-model="galuniu_judesiai" row>
                                                    <v-radio label="laisvi" value="laisvi"></v-radio>
                                                    <v-radio label="sutrikę" value="sutrikę"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-if="galuniu_judesiai == 'sutrikę'"
                                                    v-model="galuniu_judesiai_sutrike"
                                                    label="įrašykite"
                                                    style="margin-top:-30px;"
                                                ></v-text-field>
                                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Sąmonės būklė:</label>
                                                <v-radio-group class="col-md-12" v-model="samones_bukle" row>
                                                    <v-radio label="reakcija į aplinką adekvati" value="reakcija į aplinką adekvati"></v-radio>
                                                    <v-radio label="vangus" value="vangus"></v-radio>
                                                    <v-radio label="sudirgęs" value="sudirgęs"></v-radio>
                                                    <v-radio label="mieguistas" value="mieguistas"></v-radio>                                                  <v-radio label="vangus" value="vangus"></v-radio>
                                                    <v-radio label="be sąmonės" value="be samonės"></v-radio>
                                                </v-radio-group>
                                                <v-text-field
                                                    class="col-md-12"
                                                    v-model="apziuros_duomenys_kita"
                                                    label="Kita"
                                                    style="margin-top:-30px;"
                                                ></v-text-field>
                                            </div>

                                        </div>

                                    </a-tab-pane>
                                </a-tabs>
                            </div>

                        </div>
                        <div class="col-md-6" style="border-style:outset;border-radius:10px;border-width:2px;">
                            <div class="col-md-12">
                                <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Galutinė informacija</label>

                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Tyrimai:</label>
                                            <v-checkbox
                                                v-model="tyrimai_bkt"
                                                :label="`BKT`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="tyrimai_crb"
                                                :label="`CRB`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="tyrimai_slapimas"
                                                :label="`šlapimas`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="tyrimai_elektrolitai"
                                                :label="`elektrolitai`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="tyrimai_gliukoze"
                                                :label="`gliukozė`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-checkbox
                                                v-model="kiti_tyrimai"
                                                :label="`kiti`"
                                                class="col-md-2"
                                            ></v-checkbox>
                                            <v-text-field
                                                v-if="kiti_tyrimai"
                                                class="col-md-12"
                                                v-model="kiti_tyrimai_tekstas"
                                                label="įrašykite"
                                                style="margin-top:-30px;"
                                            ></v-text-field>
                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Diagnozė:</label>
                                <v-textarea
                                                class="col-mod-12"
                                                v-model="tyrimu_vertinimas"
                                                name="input-7-4"
                                                style="display:block;"
                                            ></v-textarea>

                                        <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Konsultantai ir jų išvados:</label>
                                            <v-textarea
                                                class="col-mod-12"
                                                v-model="konsultantai_ir_ju_isvados"
                                                name="input-7-4"
                                                style="display:block;"
                                            ></v-textarea>
                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Diagnozė:</label>
                                <v-textarea
                                    class="col-mod-12"
                                    v-model="diagnoze_galutine_info"
                                    name="input-7-4"
                                    style="display:block;"
                                ></v-textarea>

                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Gydymas:</label>
                                <v-textarea
                                    class="col-mod-12"

                                    v-model="gydymas_galutine_info"
                                    name="input-7-4"
                                    style="display:block;"
                                ></v-textarea>

                                <label class="col-md-1" style="margin-top:30px;">Išvada: </label>
                                <v-checkbox
                                    v-model="ambulatorinis_gydymas"
                                    :label="`ambulatorinis gydymas`"
                                    class="col-md-3"
                                ></v-checkbox><v-checkbox
                                v-model="stebejimo_paslauga"
                                :label="`stebėjimo paslauga`"
                                class="col-md-3"
                            ></v-checkbox>
                                <label class="col-md-12" style="margin-top:-20px; margin-bottom:-20px;">Rekomendacijos:</label>
                                <v-textarea
                                    class="col-mod-12"
                                    v-model="rekomendacijos_galutine_info"
                                    name="input-7-4"
                                    style="display:block;"
                                ></v-textarea>
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
                            {{JSONarray}}
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
        name: "VaikuAmbForma",
        data() {
            return {
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
                traumos_laikas: '',
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
                faringoskopija_rykles_gleivine: '',
                galutine_info_kita: '',
                galutine_info_diagnoze: '',
                galutine_info_rekomendacijos: '',
                epidemiologine_anamneze: '',
                epidemiologine_anamneze_tekstas: '',
                valgymas: '',
                kpl: '',
                pulsas: '',
                oda: '',
                berimas: '',
                berimas_koks: '',
                audiniu_turgoras: '',
                gleivines:'',
                gleivines_berimas: '',
                liezuvis: '',
                kataro_reiskiniai:'',
                kataro_reiskiniai_taip: '',
                kvepavimas: '',
                kd: '',
                spo2: '',
                plauciu_auskultacija: '',
                sirdies_veikla_kita: '',
                pilvas_skausmingas_tekstas: '',
                tonziles: '',
                kepenys: '',
                bluznis: '',
                zarnu_peristaltika: '',
                tustinasi: '',
                obstipacija: '',
                slapinasi: '',
                galuniu_judesiai: '',
                galuniu_judesiai_sutrike: '',
                samones_bukle: '',
                simptomai_meninginiai: '',
                meninginiai_simptomai_yra: '',
                zidinine_neurologine_simptomatika: '',
                zidinine_neurologine_simptomatika_yra: '',
                apziuros_duomenys_kita: '',
                tyrimai_bkt: false,
                tyrimai_crb: false,
                tyrimai_slapimas: false,
                tyrimai_elektrolitai: false,
                tyrimai_gliukoze: false,
                kiti_tyrimai: false,
                kiti_tyrimai_tekstas: '',
                tyrimu_vertinimas: '',
                konsultantai_ir_ju_isvados: '',
                diagnoze_galutine_info: '',
                gydymas_galutine_info: '',
                rekomendacijos_galutine_info: '',
                ESPBI_apziuros_data: '',
                ESPBI_butinosios_pagalbos_kategorija: '',
                ESPBI_anamneze: '',
                ESPBI_alergijos: '',
                ESPBI_bukles_ivertinimas: '',







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

                if(this.apziuros_data && this.apziuros_laikas){
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Apžiūros data ir laikas: ' + this.apziuros_data + ', ' + this.getFormattedTime(this.apziuros_laikas), this.ESPBI_apziuros_data)
                } else {
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Apžiūros data ir laikas: -', this.ESPBI_apziuros_data)
                }

                if(this.but_pagalbos_kat) {
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Būtinosios pagalbos kategorija: ' + this.but_pagalbos_kat, this.ESPBI_butinosios_pagalbos_kategorija)
                } else {
                    this.ESPBI_apziuros_data = this.generateESPBIstring('Būtinosios pagalbos kategorija: -', this.ESPBI_butinosios_pagalbos_kategorija)

                }

                if(this.nusiskundimai) {
                    this.ESPBI_anamneze = this.generateESPBIstring('Nusiskundimai ir ligos anamnezė: ' + this.nusiskundimai, this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Nusiskundimai ir ligos anamnezė: -', this.ESPBI_anamneze)
                }

                if(this.alergija) {
                    this.ESPBI_alergijos = this.generateESPBIstring('Alergijos: ' + this.alergija_kam, this.ESPBI_alergijos)
                } else {
                    this.ESPBI_alergijos = this.generateESPBIstring('Alergijos: -', this.ESPBI_alergijos)
                }

                if(this.epidemiologine_anamneze == 'buvo') {
                    this.ESPBI_anamneze = this.generateESPBIstring('Epidemiologinė anamnezė: kontaktas buvo - ' + this.epidemiologine_anamneze_tekstas, this.ESPBI_anamneze)
                } else if(this.epidemiologine_anamneze == 'nezino') {
                    this.ESPBI_anamneze = this.generateESPBIstring('Epidemiologinė anamnezė: nežino', this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Epidemiologinė anamnezė: kontakto nebuvo', this.ESPBI_anamneze)
                }

                if(this.valgymas == 'kaip_iprastai') {
                    this.ESPBI_anamneze = this.generateESPBIstring('Valgymas: kaip įprastai', this.ESPBI_anamneze)
                } else if (this.valgymas == 'pablogejes_apetitas') {
                    this.ESPBI_anamneze = this.generateESPBIstring('Valgymas: pablogėjęs apetitas', this.ESPBI_anamneze)
                } else {
                    this.ESPBI_anamneze = this.generateESPBIstring('Valgymas: atsisako valgyti', this.ESPBI_anamneze)
                }

                if(this.bendra_bukle) {
                    this.ESPBI_bukles_ivertinimas = this.generateESPBIstring('Bendra b8')
                }



            },

            generateJSON(){
                this.JSONarray = [];
                this.generateESPBI();
                console.log(this.ESPBI_anamneze)

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
                    nusiskundimai: {
                        nusiskundimai: this.nusiskundimai,
                    },
                    gyvenimo_anamneze: {

                    },
                    kada_kur_ivyko_trauma: {
                        traumos_data: this.traumos_data,
                        traumos_laikas: traumos_laikas_formatted,
                        traumos_vieta: this.traumos_vieta,
                        traumos_aplinkybes: this.traumos_aplinkybes,
                        policija_informuota: this.policija_informuota,
                        vaiku_teises: this.vaiku_teises
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
                // console.log('JSON: ' + json)

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
