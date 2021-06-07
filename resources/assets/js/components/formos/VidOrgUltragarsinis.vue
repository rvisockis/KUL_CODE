<template>
<v-app>
    <div class="box">
        <div class="box-body">
            <div class="col-md-12">
                <h4 style="text-align:center; margin-bottom:40px;">Vidaus organų ultragarsinis tyrimas</h4>
                <div class="col-md-6"style="border-style:outset;border-radius:10px;border-width:1px; margin-left:-20px; margin-right:15px;">
                    <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Pradinė informacija</label>

                    <v-menu
                        ref="menu"
                        v-model="datepicker_menu_tyrimo_data"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                        style="top:200px;left:300px;"
                    >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                class="col-md-4"
                                v-model="tyrimo_data"
                                label="Tyrimo data"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="gimimo_data" no-title  locale="lt" @input="datepicker_menu_tyrimo_data = false">
                        </v-date-picker>
                    </v-menu>
                    <v-text-field
                        v-model="stacionaro_ligos_nr"
                        label="Gydymo stacionare ligos istorijos Nr."
                        class="col-md-6"
                    />
                    <div class="col-md-4">
                    </div>

                    <v-text-field
                        v-model="asmens_sveikatos_ligos_nr"
                        label="Asmens sveikatos istorijos Nr."
                        class="col-md-6"
                    />
                    <v-divider class="col-md-11" style="margin-left:10px;"></v-divider>


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
                        <v-date-picker v-model="gimimo_data" no-title  locale="lt" @input="datepicker_menu_gimimo_data = false">
                        </v-date-picker>
                    </v-menu>
                    <v-text-field
                        v-model="vardas_pavarde"
                        label="Vardas, pavardė"
                        class="col-md-3"
                    />
                    <v-text-field
                        v-model="ugis"
                        label="Ūgis"
                        class="col-md-2"
                    />
                    <v-text-field
                        v-model="svoris"
                        label="Svoris (kg)"
                        class="col-md-2"
                    />
                    <v-text-field
                        v-model="kpp"
                        label="KPP"
                        class="col-md-2"
                        suffix="m²"
                    />

                    <a-tabs class="col-md-12">
                        <a-tab-pane tab="Kepenys" key="1">
                            <v-select v-model="kepenys_dydis" class="col-md-6" :items="['Normalus','Padidintas']" label="Dydis">
                            </v-select>
                            <v-text-field
                                v-model="kepenys_konturas"
                                label="Kontūras lygus"
                                class="col-md-6"
                                style="padding-left:20px;"
                                placeholder="Įrašykite"
                            />
                            <v-select v-model="kepenys_kampai" class="col-md-6" :items="['Smailūs','Buki']" label="Kampai">
                            </v-select>
                            <v-select v-model="kepenys_echogeniskumas" class="col-md-6" :items="['Padidintas','Normalus','Sumažintas']" label="Echogeniškumas">
                            </v-select>
                            <v-text-field
                                v-model="kepenys_zidininiai_pakitimai"
                                label="Židininiai pakitimai (+/-)"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />

                        </a-tab-pane>

                        <a-tab-pane tab="Tulžies pūslė" key="2">
                            <v-select v-model="tulzis_dydis" class="col-md-6" :items="['Padidinta','Nepadidinta']" label="Dydis">
                            </v-select>
                            <v-select v-model="tulzis_forma" class="col-md-6" :items="['Deformuota','Nedeformuota']" label="Forma">
                            </v-select>
                            <v-text-field
                                v-model="tulzis_sieneles_storis"
                                label="Sienelės storis"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="mm"
                            />
                        </a-tab-pane>

                        <a-tab-pane tab="Bendras tulžies latakas" key="3">
                            <v-select v-model="tulzies_latakas" class="col-md-6" :items="['Neišplėstas','Išplėstas']" label="Bendras tulžies latakas">
                            </v-select>
                            <v-text-field
                                v-model="tulzies_latakas_intrahepatiniai"
                                label="Intrahepatiniai latakai"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />
                        </a-tab-pane>

                        <a-tab-pane tab="Kasa" key="4">
                            <v-text-field
                                v-model="kasa_galvutes_diametras"
                                label="Galvutės diametras"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="mm (n.30-32 mm)"
                            />
                            <v-select v-model="kasa_parenchima" class="col-md-6" :items="['Tolygi','Netolygi']" label="Parenchima">
                            </v-select>
                            <v-text-field
                                v-model="kasa_konturai"
                                label="Kontūrai"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />
                            <v-text-field
                                v-model="kasa_papildomi_dariniai"
                                label="Papildomi dariniai"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />
                        </a-tab-pane>

                        <a-tab-pane tab="Blužnis" key="5">
                            <v-select v-model="bluznis_dydis" class="col-md-6" :items="['Padidėjusi','Nepadidėjusi']" label="Dydis">
                            </v-select>
                            <v-text-field
                                v-model="bluznis_parenchima"
                                label="Parenchima tolygi"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />

                        </a-tab-pane>

                        <a-tab-pane tab="Dešinysis inkstas" key="6">
                            <v-text-field
                                v-model="desinysis_inkstas_dydis"
                                label="Dydis"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="(+/-)"
                            />
                            <v-select v-model="desinysis_inkstas_kontrurai" class="col-md-6" :items="['Lygūs','Nelygūs']" label="Kontūrai">
                            </v-select>
                            <v-select v-model="desinysis_inkstas_parenchima" class="col-md-3" :items="['Tolygi','Netolygi']" label="Parenchima">
                            </v-select>
                            <v-text-field
                                v-model="desinysis_inkstas_parenchima_papildomi"
                                label=""
                                class="col-md-3"
                                placeholder="Įrašykite"
                                suffix="mm"
                            />
                            <v-text-field
                                v-model="desinysis_inkstas_kolektorine_sistema"
                                label="Kolektorinė sistema"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="mm"
                            />
                            <v-textarea
                                v-model="desinysis_inkstas_pakitimai"
                                label="Patologiniai pakitimai"
                                class="col-md-12"
                                placeholder="Įrašykite"
                            />
                        </a-tab-pane>

                        <a-tab-pane tab="Kairysis inkstas" key="7">
                            <v-text-field
                                v-model="kairysis_inkstas_dydis"
                                label="Dydis"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="(+/-)"
                            />
                            <v-select v-model="kairysis_inkstas_kontrurai" class="col-md-6" :items="['Lygūs','Nelygūs']" label="Kontūrai">
                            </v-select>
                            <v-select v-model="kairysis_inkstas_parenchima" class="col-md-3" :items="['Tolygi','Netolygi']" label="Parenchima">
                            </v-select>
                            <v-text-field
                                v-model="kairysis_inkstas_parenchima_papildomi"
                                label=""
                                class="col-md-3"
                                placeholder="Įrašykite"
                                suffix="mm"
                            />
                            <v-text-field
                                v-model="kairysis_inkstas_kolektorine_sistema"
                                label="Kolektorinė sistema"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="mm"
                            />
                            <v-textarea
                                v-model="kairysis_inkstas_pakitimai"
                                label="Patologiniai pakitimai"
                                class="col-md-12"
                                placeholder="Įrašykite"
                            />
                        </a-tab-pane>

                        <a-tab-pane tab="Šlapimo pūslė, prostata (vyr.)" key="8">
                            <v-text-field
                                v-model="slapimo_pusle"
                                label="Šlapimo pūslė"
                                class="col-md-6"
                                placeholder="Įrašykite"
                            />
                            <v-text-field
                                v-model="prostata"
                                label="Prostata (vyr.)"
                                class="col-md-6"
                                placeholder="Įrašykite"
                                suffix="mm (35x45 mm) Kontūrai"
                            />
                        </a-tab-pane>
                    </a-tabs>

                </div>
                <div class="col-md-6" style="border-style:outset;border-radius:10px;border-width:2px;">
                    <label class="col-md-12" style="margin-top:30px; text-align:center; font-size:18px;">Galutinė informacija</label>
                    <v-textarea
                        v-model="pastabos"
                        label="Pastabos"
                        class="col-md-12"
                        placeholder="Įrašykite"
                    />
                    <v-textarea
                        v-model="isvada"
                        label="Išvada"
                        class="col-md-12"
                        placeholder="Įrašykite"
                    />
                </div>

            </div>
        </div>
    </div>
</v-app>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "VidOrgUltragarsinis",
        data() {
            return {
                tyrimo_data: moment().format('YYYY-MM-DD'),
                datepicker_menu_tyrimo_data: false,
                stacionaro_ligos_nr: '',
                asmens_sveikatos_ligos_nr: '',
                vardas_pavarde: '',
                gimimo_data: '',
                datepicker_menu_gimimo_data: false,
                ugis: '',
                svoris: '',
                kpp: '',

                kepenys_dydis: '',
                kepenys_konturas: '',
                kepenys_kampai: '',
                kepenys_echogeniskumas: '',
                kepenys_zidininiai_pakitimai: '',

                tulzis_dydis: '',
                tulzis_forma: '',
                tulzis_sieneles_storis: '',
                tulzis_papildomi_dariniai: '',

                tulzies_latakas: '',
                tulzies_latakas_intrahepatiniai: '',

                kasa_galvutes_diametras: '',
                kasa_parenchima: '',
                kasa_konturai: '',
                kasa_papildomi_dariniai: '',

                bluznis_dydis: '',
                bluznis_parenchima: '',

                desinysis_inkstas_dydis: '',
                desinysis_inkstas_kontrurai: '',
                desinysis_inkstas_parenchima: '',
                desinysis_inkstas_parenchima_papildomi: '',
                desinysis_inkstas_kolektorine_sistema: '',
                desinysis_inkstas_pakitimai: '',

                kairysis_inkstas_dydis: '',
                kairysis_inkstas_kontrurai: '',
                kairysis_inkstas_parenchima: '',
                kairysis_inkstas_parenchima_papildomi: '',
                kairysis_inkstas_kolektorine_sistema: '',
                kairysis_inkstas_pakitimai: '',

                slapimo_pusle: '',

                prostata: '',

                pastabos: '',
                isvada: '',


            }
        }
    }
</script>

<style scoped>

</style>
