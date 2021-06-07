<!--

    TODO:
     1) Needs to get from database data which does not yet exist: "Pacientas prisirašęs prie", "Periodas", "Atsakingas asmuo" pagal SP numerį, "Specialistas" pagal SP numerį,
     "Rezultatas" in Visits, all data for CBP tab, ACHI codes and names. These will need new models and to be added to existing functions for full functionability.
     2) Full logic implementation
     3) Need to make sure which data should be editable in "Pagrindine dalis": what will be editable in an existing F.025 form and what in a new form.

     -->

<template>
    <v-app>
    <div class="col-md-12">
        <div v-if="!isVisits">
            <a-icon slot="indicator" type="loading" style="font-size: 48px" spin class="loadingAnimation"/>
        </div>
        <div v-if="isVisits">
            <div class="col-md-6">
                <a-divider type="horizontal" orientation="left">Apsilankymų lapas</a-divider>
                <div class="box">

                    <div class="box-body">

                        <!--            Apsilankymu lapas(ai)-->

                        <a-collapse accordion v-model="activeKey">
                            <a-collapse-panel v-for="(sk, index) in Visits"
                                              v-bind:header="'Apsilankymas Nr.' + sk.EIL_NR + ' (' + (moment(sk.APSILANKYMO_DATA).format('YYYY-MM-DD')) + ')'" title="" :key="sk.EIL_NR">

                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div v-bind:class="{'is-disabled': sk.isDisabled}">
                                                <!-- applying is-disabled css class  -->
                                                <a-tabs defaultActiveKey="1">
                                                    <a-tab-pane tab="BENDRA INFORMACIJA" key="1">
                                                        <form class="form-horizontal">
                                                            <div class="box-body">
                                                                <div class="form-group row date">

                                                                        <v-row>
                                                                            <v-col cols="12" sm="6" md="4">
                                                                    <label class="col-sm-2 col-form-label" style="margin-right: 40px;">Data</label>
                                                                    <v-menu
                                                                        ref="menu"
                                                                        v-model="datepicker_menu"
                                                                        :close-on-content-click="false"
                                                                        transition="scale-transition"
                                                                        offset-y
                                                                        min-width="290px"
                                                                        style="top:200px;left:300px;"
                                                                    >
                                                                        <template v-slot:activator="{ on }">
                                                                            <v-text-field
                                                                                v-model="sk.APSILANKYMO_DATA"
                                                                                label=""
                                                                                readonly
                                                                                v-on="on"
                                                                                outlined
                                                                                style="margin-bottom:-30px;"
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker v-model="sk.APSILANKYMO_DATA" no-title  locale="lt" @input="datepicker_menu = false">
                                                                        </v-date-picker>
                                                                    </v-menu>

<!--                                                                    <v2-datepicker v-model="sk.APSILANKYMO_DATA"-->
<!--                                                                                   class="col-sm-9" :lang="lang"-->
<!--                                                                                   :customLocals="locals"-->
<!--                                                                                   placeholder="Data"-->
<!--                                                                                   :picker-options="pickerOptions2"-->
<!--                                                                                   :value="sk.APSILANKYMO_DATA"-->
<!--                                                                                   style="margin-left:15px;"></v2-datepicker>-->
                                                                            </v-col>
                                                                        </v-row>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-2 col-form-label">Specialistas</label>
                                                                    <!-- no database entries for names by SP for all specialistas models  -->
                                                                    <div class="col-sm-10">
                                                                        <multiselect v-model="ButtonModel" label="name"
                                                                                     track-by="name"
                                                                                     placeholder="Įveskite specialisto vardą"
                                                                                     open-direction="bottom"
                                                                                     :options="list" :multiple="true"
                                                                                     :searchable="true"
                                                                                     :internal-search="false"
                                                                                     :clear-on-select="true"
                                                                                     :close-on-select="true"
                                                                                     :options-limit="300" :limit="10"
                                                                                     :max-height="600"
                                                                                     :show-no-results="true"
                                                                                     :show-labels="false"
                                                                                     @search-change="getSpecialistName">
                                                                            <template slot="noOptions"
                                                                                      slot-scope="props">
                                                                                <div>Įrašykite bent 4 pirmas vardo
                                                                                    raides
                                                                                </div>
                                                                            </template>
                                                                            <template slot="noResult"
                                                                                      slot-scope="props">
                                                                                <div>Specialistas nerastas</div>
                                                                            </template>
                                                                        </multiselect>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label">Paslaugos
                                                                        kodas</label>
                                                                    <div class="col-sm-10">
                                                                        <multiselect
                                                                                     v-model="sk.PASLAUGOS_KODAS"
                                                                                     label="code" track-by="name"
                                                                                     placeholder="Įveskite tris simbolius"
                                                                                     open-direction="bottom"
                                                                                     :options="paslaugos_list"
                                                                                     :searchable="true"
                                                                                     :internal-search="false"
                                                                                     :clear-on-select="true"
                                                                                     :close-on-select="true"
                                                                                     :options-limit="300" :limit="10"
                                                                                     :max-height="600"
                                                                                     :show-no-results="true"
                                                                                     :show-labels="false"
                                                                                     @search-change="getPaslaugosList">
                                                                            <template slot="option" slot-scope="props">
                                                                                <div class="option__desc"><span
                                                                                    class="option__small">{{ props.option.code}} - {{ props.option.name}}</span>
                                                                                </div>
                                                                            </template>
                                                                            <template slot="singleLabel" slot-scope="props">
                                                                                <div v-model="pavadinimas">{{props.option.code}} - {{props.option.name}}</div>
                                                                            </template>
                                                                            <template slot="noOptions"
                                                                                      slot-scope="props">
                                                                                <div>Įrašykite bent 3 simbolius</div>
                                                                            </template>
                                                                            <template slot="noResult"
                                                                                      slot-scope="props">
                                                                                <div>Paslauga nerasta</div>
                                                                            </template>
                                                                        </multiselect>
                                                                    </div>

                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label">Paslaugos
                                                                        tipas</label>
                                                                    <div class="col-sm-2">
                                                                        <a-radio-group v-model="sk.PASLAUGOS_TIPAS1"
                                                                                       :defaultValue="sk.PASLAUGOS_TIPAS1"
                                                                                       buttonStyle="solid">
                                                                            <a-popover
                                                                                v-for="(pasl_tipas, index) in apsilankymas"
                                                                                title="" trigger="hover"
                                                                                placement="left">
                                                                                <template slot="content">
                                                                                    <p>{{pasl_tipas.popover}}</p>
                                                                                </template>
                                                                                <a-radio-button
                                                                                    @click="clicked_pasltipas(index)"
                                                                                    :value="pasl_tipas.value"
                                                                                    :id="pasl_tipas.value"
                                                                                    style="margin:2px">
                                                                                    {{pasl_tipas.name}}
                                                                                </a-radio-button>
                                                                            </a-popover>
                                                                        </a-radio-group>
                                                                    </div>
                                                                    <v-col cols="12" sm="6" class="py-2">
                                                                            <v-btn-toggle v-model="sk.toggle_multiple"
                                                                                          multiple light>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Vizitas į namus</span>
                                                                                    </template>
                                                                                    <v-btn text value="N">N
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Dėl šios ligos dispanserizuotas</span>
                                                                                    </template>
                                                                                    <v-btn text value="D">D
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Apsilankymas dėl ligos</span>
                                                                                    </template>
                                                                                    <v-btn text value="L">L
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Būtinoji medicinos pagalba</span>
                                                                                    </template>
                                                                                    <v-btn text value="B">B
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Profilaktinis patikrinimas</span>
                                                                                    </template>
                                                                                    <v-btn text value="PR">PR
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Nelaimingas atsitikimas darbe</span>
                                                                                    </template>
                                                                                    <v-btn text value="A">A
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                                <a-tooltip placement="bottom">
                                                                                    <template slot="title">
                                                                                        <span>Priėmimas kitoje ASPĮ</span>
                                                                                    </template>
                                                                                    <v-btn text value="M">M
                                                                                    </v-btn>
                                                                                </a-tooltip>
                                                                            </v-btn-toggle>
                                                                    </v-col>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label">Ligos
                                                                        kodas</label>
                                                                    <div class="col-sm-10">
<!--                                                                        HIS ID: {{this.FullInfo.HIS_ID}}-->
                                                                        <multiselect v-model="sk.LIGOS_KODAS"
                                                                                     track-by="title"
                                                                                     placeholder="Įveskite tris simbolius"
                                                                                     open-direction="bottom"
                                                                                     :options="diagnosis_list"
                                                                                     :searchable="true"
                                                                                     :internal-search="false"
                                                                                     :clear-on-select="true"
                                                                                     :close-on-select="true"
                                                                                     :options-limit="300" :limit="10"
                                                                                     :max-height="600"
                                                                                     :show-no-results="true"
                                                                                     :show-labels="false"
                                                                                     @search-change="GetList">
                                                                            <template slot="option" slot-scope="props">
                                                                                <div class="option__desc"><span
                                                                                    class="option__small">{{ props.option.code}} - {{ props.option.title}}</span>
                                                                                </div>
                                                                            </template>
                                                                            <template slot="noOptions"
                                                                                      slot-scope="props">
                                                                                <div>Įrašykite bent 3 simbolius
                                                                                </div>
                                                                            </template>
                                                                            <template slot="singleLabel" slot-scope="props">
                                                                                <div v-model="pavadinimas">{{props.option.code}} - {{props.option.title}}</div>
                                                                            </template>
                                                                            <template slot="noResult"
                                                                                      slot-scope="props">
                                                                                <div>Ligos kodas nerastas</div>
                                                                            </template>
                                                                        </multiselect>
                                                                        <div style="font-style:italic; font-size:12px;">{{sk.LIGOS_KODAS.code}} - {{sk.LIGOS_KODAS.title}}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-2 col-form-label">Rezultatas</label>
                                                                    <div class="col-sm-10">
                                                                        <multiselect v-model="sk.ButtonModelRez"
                                                                                     label="name" track-by="name"
                                                                                     placeholder="Pasirinkite rezultatą"
                                                                                     open-direction="bottom"
                                                                                     :options="rez_sarasas"
                                                                                     :multiple="true" :searchable="true"
                                                                                     :internal-search="false"
                                                                                     :clear-on-select="true"
                                                                                     :close-on-select="true"
                                                                                     :options-limit="300" :limit="10"
                                                                                     :max-height="600"
                                                                                     :show-no-results="true"
                                                                                     :show-labels="false">
                                                                            <template slot="noOptions"
                                                                                      slot-scope="props">
                                                                            </template>
                                                                            <template slot="noResult"
                                                                                      slot-scope="props">
                                                                                <div>Specialistas nerastas</div>
                                                                            </template>
                                                                        </multiselect>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </a-tab-pane>
                                                    <a-tab-pane tab="INTERVENCIJOS" key="2" active>
                                                        <form class="form-horizontal">
                                                            <div class="box-body">
                                                                <!-- adds new Intervencija Model to current(index) Visit  -->
                                                                <a-button @click="addIntervencijaModel(index)"><i
                                                                    class="fa fa-plus  fa-2x" style="color: green;"></i>
                                                                </a-button>
                                                            </div>
                                                            <a-tabs
                                                                v-model="activeKeyIntervencijos"
                                                                hideAdd
                                                                defaultActiveKey="1"
                                                            >
                                                                <a-tab-pane
                                                                    v-for="(pane, index2) in sk.INTERVENCIJA_MODEL"
                                                                    :tab="index2+1"
                                                                    :key="index2+1"
                                                                    :closable="pane.closable">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">ACHI
                                                                            kodas ir pav.</label>
                                                                        <div class="col-sm-6">
                                                                            <multiselect
                                                                                v-model="pane.ButtonModelACHIKodas"
                                                                                label="name" track-by="name"
                                                                                placeholder="Pasirinkite ACHI paslaugą"
                                                                                open-direction="bottom" :options="list"
                                                                                :multiple="true" :searchable="true"
                                                                                :internal-search="false"
                                                                                :clear-on-select="true"
                                                                                :close-on-select="true"
                                                                                :options-limit="300" :limit="10"
                                                                                :max-height="600"
                                                                                :show-no-results="true"
                                                                                :show-labels="false"
                                                                                @search-change="getSpecialistName">
                                                                                <template slot="noOptions"
                                                                                          slot-scope="props">
                                                                                    <div>Įrašykite bent 4 pirmas vardo
                                                                                        raides
                                                                                    </div>
                                                                                </template>
                                                                                <template slot="noResult"
                                                                                          slot-scope="props">
                                                                                    <div>Specialistas nerastas</div>
                                                                                </template>
                                                                            </multiselect>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Specialistas</label>
                                                                        <div class="col-sm-6">
                                                                            <multiselect v-model="pane.ButtonModel"
                                                                                         label="name" track-by="name"
                                                                                         placeholder="Įveskite specialisto vardą"
                                                                                         open-direction="bottom"
                                                                                         :options="list"
                                                                                         :multiple="true"
                                                                                         :searchable="true"
                                                                                         :internal-search="false"
                                                                                         :clear-on-select="true"
                                                                                         :close-on-select="true"
                                                                                         :options-limit="300"
                                                                                         :limit="10" :max-height="600"
                                                                                         :show-no-results="true"
                                                                                         :show-labels="false"
                                                                                         @search-change="getSpecialistName">
                                                                                <template slot="noOptions"
                                                                                          slot-scope="props">
                                                                                    <div>Įrašykite bent 4 pirmas vardo
                                                                                        raides
                                                                                    </div>
                                                                                </template>
                                                                                <template slot="noResult"
                                                                                          slot-scope="props">
                                                                                    <div>Specialistas nerastas</div>
                                                                                </template>
                                                                            </multiselect>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Išlaid.
                                                                            kontr. (balais)</label>
                                                                        <div class="col-sm-6">
                                                                            <a-input
                                                                                v-model="pane.INTERVENCIJA_ISLAIDOS_KONTR_BALAIS"
                                                                                :min="0" :step="0.01"
                                                                                :defaultValue="pane.INTERVENCIJA_ISLAIDOS_KONTR_BALAIS"></a-input>
                                                                        </div>
                                                                    </div>
                                                                    <!--  sends index of current Visit and index of current tab to function 'remove' -->
                                                                    <a-button v-on:click="remove(index, index2)"
                                                                              style="margin-bottom:15px; margin-top: 15px;"
                                                                              type="danger">Ištrinti šią intervenciją
                                                                    </a-button>
                                                                </a-tab-pane>
                                                            </a-tabs>
                                                        </form>
                                                    </a-tab-pane>
                                                    <a-tab-pane tab="MOK. PASLAUGOS" key="3">
                                                        <form class="form-horizontal">
                                                            <div class="box-body">
                                                                <!-- adds new Priemoka Model to current(index) Visit  -->
                                                                <a-button @click="addPriemokaModel(index)"><i
                                                                    class="fa fa-plus  fa-2x" style="color: green;"></i>
                                                                </a-button>
                                                                <a-tabs

                                                                    v-model="activeKey_Priemoka"
                                                                    hideAdd

                                                                >
                                                                    <a-tab-pane
                                                                        v-for="(pane_priemoka, index2) in sk.PRIEMOKA_MODEL"
                                                                        :tab="index2+1"
                                                                        :key="index2+1"
                                                                        :closable="pane_priemoka.closable">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Paslaugos</label>
                                                                            <div class="col-sm-6">
                                                                                <multiselect
                                                                                    v-model="pane_priemoka.Priemoka_name"
                                                                                    label="code" track-by="name"
                                                                                    placeholder="Pasirinkite paslaugas"
                                                                                    open-direction="bottom"
                                                                                    :options="paslaugos_list"
                                                                                    :searchable="true"
                                                                                    :internal-search="false"
                                                                                    :clear-on-select="true"
                                                                                    :close-on-select="true"
                                                                                    :options-limit="300" :limit="10"
                                                                                    :max-height="600"
                                                                                    :show-no-results="true"
                                                                                    @search-change="getPaslaugosList"
                                                                                    @select="setPaslauguKainaObject"
                                                                                    @close="setPaslauguKaina(index,index2)"
                                                                                    :show-labels="false">
                                                                                    <template slot="singleLabel" slot-scope="props">
                                                                                        <div v-model="pavadinimas">{{props.option.code}} - {{props.option.name}}</div>
                                                                                    </template>
                                                                                    <template slot="noOptions"
                                                                                              slot-scope="props">
                                                                                    </template>
                                                                                    <template slot="option" slot-scope="props">
                                                                                        <div class="option__desc"><span
                                                                                            class="option__small">{{ props.option.code}} - {{ props.option.name}}</span>
                                                                                        </div>
                                                                                    </template>
                                                                                    <template slot="noResult"
                                                                                              slot-scope="props">
                                                                                        <div>Specialistas nerastas</div>
                                                                                    </template>
                                                                                </multiselect>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Finansavimo
                                                                                šaltinis</label>
                                                                            <div class="col-sm-6">
                                                                                <multiselect
                                                                                    v-model="pane_priemoka.PRIEMOKA_FINANSAVIMO_SALTINIS"
                                                                                    label="name" track-by="name"
                                                                                    placeholder="Pasirinkite finansavimo tipą"
                                                                                    open-direction="bottom"
                                                                                    :options="priem_sarasas"
                                                                                    :searchable="true"
                                                                                    :internal-search="false"
                                                                                    :clear-on-select="true"
                                                                                    :close-on-select="true"
                                                                                    :options-limit="300" :limit="10"
                                                                                    :max-height="600"
                                                                                    :show-no-results="true"
                                                                                    :show-labels="false">
                                                                                    <template slot="noOptions"
                                                                                              slot-scope="props">
                                                                                    </template>
                                                                                    <template slot="noResult"
                                                                                              slot-scope="props">
                                                                                        <div>Specialistas nerastas</div>
                                                                                    </template>
                                                                                </multiselect>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Įrašytos
                                                                                į mokamų paslaugų sarašą</label>
                                                                            <div class="col-sm-6">
                                                                                <!--  v-model="pane_priemoka.PRIEMOKA_MOKAMOS_PASLAUGOS"-->
                                                                                <a-input
                                                                                    v-model="pane_priemoka.PRIEMOKA_MOKAMOS_PASLAUGOS"
                                                                                    :min="0" :step="0.01"
                                                                                    :defaultValue="pane_priemoka.PRIEMOKA_MOKAMOS_PASLAUGOS"></a-input>
                                                                            </div>
                                                                        </div>
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label class="col-sm-2 col-form-label">Planinės,-->
<!--                                                                                gautos skubos tvarka</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <a-input-->
<!--                                                                                    v-model="pane_priemoka.PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS"-->
<!--                                                                                    :min="0" :step="0.01"-->
<!--                                                                                    :defaultValue="sk.PRIEMOKA_MODEL.PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS"></a-input>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label-->
<!--                                                                                class="col-sm-2 col-form-label">Kita</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <a-input-->
<!--                                                                                    v-model="pane_priemoka.PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS"-->
<!--                                                                                    :min="0" :step="0.01"-->
<!--                                                                                    :defaultValue="sk.PRIEMOKA_MODEL.PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS"></a-input>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
                                                                        <!--  sends index of current Visit and index of current tab to function 'removePriemoka' -->
                                                                        <a-button
                                                                            v-on:click="removePriemoka(index, index2)"
                                                                            style="margin-bottom:15px;margin-top: 15px;"
                                                                            type="danger">Ištrinti šią mok. paslaugą
                                                                        </a-button>

                                                                    </a-tab-pane>
                                                                </a-tabs>
                                                            </div>
                                                        </form>
                                                    </a-tab-pane>
                                                    <a-tab-pane tab="CPV" key="4">

                                                        <!-- TODO: reikia sukurti v-modelius, funkcijose priskirti jiems reiksmes, gauti duomenis is DB bei prideti i saugojimo funkcijas.
                                                         Kol kas viskas sudeta is Priemokos sekcijos.
                                                         -->

                                                        <form class="form-horizontal">
<!--                                                            <div class="box-body">-->
<!--                                                                {{'WIP, nera vaistu DB'}}<br>-->
<!--                                                                <a-button @click="addPriemokaModel(index)"><i-->
<!--                                                                    class="fa fa-plus  fa-2x" style="color: green;"></i>-->
<!--                                                                </a-button>-->
<!--                                                                <a-tabs-->
<!--                                                                    v-model="activeKey"-->
<!--                                                                    hideAdd-->
<!--                                                                >-->
<!--                                                                    <a-tab-pane-->
<!--                                                                        v-for="(pane_priemoka, index2) in sk.PRIEMOKA_MODEL"-->
<!--                                                                        :tab="pane_priemoka.PRIEMOKA_EIL_NR"-->
<!--                                                                        :key="pane_priemoka.PRIEMOKA_EIL_NR"-->
<!--                                                                        :closable="pane_priemoka.closable">-->

<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label-->
<!--                                                                                class="col-sm-2 col-form-label">Data</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <v2-datepicker-->
<!--                                                                                    v-model="sk.APSILANKYMO_DATA"-->
<!--                                                                                    :lang="lang" :customLocals="locals"-->
<!--                                                                                    placeholder="Data"-->
<!--                                                                                    :picker-options="pickerOptions2"-->
<!--                                                                                    :value="sk.APSILANKYMO_DATA"-->
<!--                                                                                    style=""></v2-datepicker>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label class="col-sm-2 col-form-label">Vaisto-->
<!--                                                                                pavadinimas</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <multiselect v-model="ButtonModel"-->
<!--                                                                                             label="name"-->
<!--                                                                                             track-by="name"-->
<!--                                                                                             placeholder="Įveskite vaisto pav."-->
<!--                                                                                             open-direction="bottom"-->
<!--                                                                                             :options="list"-->
<!--                                                                                             :multiple="true"-->
<!--                                                                                             :searchable="true"-->
<!--                                                                                             :internal-search="false"-->
<!--                                                                                             :clear-on-select="true"-->
<!--                                                                                             :close-on-select="true"-->
<!--                                                                                             :options-limit="300"-->
<!--                                                                                             :limit="10"-->
<!--                                                                                             :max-height="600"-->
<!--                                                                                             :show-no-results="true"-->
<!--                                                                                             :show-labels="false"-->
<!--                                                                                             @search-change="getSpecialistName">-->
<!--                                                                                    <template slot="noOptions"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div></div>-->
<!--                                                                                    </template>-->
<!--                                                                                    <template slot="noResult"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div>Vaistas nerastas</div>-->
<!--                                                                                    </template>-->
<!--                                                                                </multiselect>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label class="col-sm-2 col-form-label">Kiekis</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <a-input :min="0" :step="0.01"-->
<!--                                                                                         :defaultValue="sk.PRIEMOKA_MODEL.PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS"></a-input>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label-->
<!--                                                                                class="col-sm-2 col-form-label">Matas</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <a-input :min="0" :step="0.01"-->
<!--                                                                                         :defaultValue="sk.PRIEMOKA_MODEL.PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS"></a-input>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label class="col-sm-2 col-form-label">CP-->
<!--                                                                                straipsnis</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <multiselect v-model="ButtonModel"-->
<!--                                                                                             label="name"-->
<!--                                                                                             track-by="name"-->
<!--                                                                                             placeholder="Įveskite vaisto pav."-->
<!--                                                                                             open-direction="bottom"-->
<!--                                                                                             :options="list"-->
<!--                                                                                             :multiple="true"-->
<!--                                                                                             :searchable="true"-->
<!--                                                                                             :internal-search="false"-->
<!--                                                                                             :clear-on-select="true"-->
<!--                                                                                             :close-on-select="true"-->
<!--                                                                                             :options-limit="300"-->
<!--                                                                                             :limit="10"-->
<!--                                                                                             :max-height="600"-->
<!--                                                                                             :show-no-results="true"-->
<!--                                                                                             :show-labels="false"-->
<!--                                                                                             @search-change="getSpecialistName">-->
<!--                                                                                    <template slot="noOptions"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div></div>-->
<!--                                                                                    </template>-->
<!--                                                                                    <template slot="noResult"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div>Vaistas nerastas</div>-->
<!--                                                                                    </template>-->
<!--                                                                                </multiselect>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label class="col-sm-2 col-form-label">Specialistas</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <multiselect v-model="ButtonModel"-->
<!--                                                                                             label="name"-->
<!--                                                                                             track-by="name"-->
<!--                                                                                             placeholder="Įveskite specialisto vardą"-->
<!--                                                                                             open-direction="bottom"-->
<!--                                                                                             :options="list"-->
<!--                                                                                             :multiple="true"-->
<!--                                                                                             :searchable="true"-->
<!--                                                                                             :internal-search="false"-->
<!--                                                                                             :clear-on-select="true"-->
<!--                                                                                             :close-on-select="true"-->
<!--                                                                                             :options-limit="300"-->
<!--                                                                                             :limit="10"-->
<!--                                                                                             :max-height="600"-->
<!--                                                                                             :show-no-results="true"-->
<!--                                                                                             :show-labels="false"-->
<!--                                                                                             @search-change="getSpecialistName">-->
<!--                                                                                    <template slot="noOptions"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div>Įrašykite bent 4 pirmas-->
<!--                                                                                            vardo raides-->
<!--                                                                                        </div>-->
<!--                                                                                    </template>-->
<!--                                                                                    <template slot="noResult"-->
<!--                                                                                              slot-scope="props">-->
<!--                                                                                        <div>Specialistas nerastas</div>-->
<!--                                                                                    </template>-->
<!--                                                                                </multiselect>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->
<!--                                                                        <div class="form-group row">-->
<!--                                                                            <label-->
<!--                                                                                class="col-sm-2 col-form-label">Kaina</label>-->
<!--                                                                            <div class="col-sm-6">-->
<!--                                                                                <a-input :min="0" :step="0.01"-->
<!--                                                                                         :defaultValue="sk.PRIEMOKA_MODEL.PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS"></a-input>-->
<!--                                                                            </div>-->
<!--                                                                        </div>-->

<!--                                                                        <a-button-->
<!--                                                                            v-on:click="removePriemoka(index, index2)"-->
<!--                                                                            style="margin-bottom:15px;margin-top: 15px;"-->
<!--                                                                            type="danger">Ištrinti šį įrašą-->
<!--                                                                        </a-button>-->

<!--                                                                    </a-tab-pane>-->
<!--                                                                </a-tabs>-->
<!--                                                            </div>-->
                                                        </form>
                                                    </a-tab-pane>
                                                </a-tabs>


                                                <!--apatiniai apsilankymo lapo mygtukai-->

                                            </div>

                                            <div class=col-md-12>
                                                <a-button type="primary" v-if="!sk.isRedaguojama"
                                                          @click="redaguoti(index)">
                                                    <a-icon type="edit"/>
                                                    Redaguoti
                                                </a-button>
                                                <a-button type="primary" v-if="sk.isRedaguojama"
                                                          @click="issaugotiVizita(index)">
                                                    <a-icon type="save"/>
                                                    Išsaugoti
                                                </a-button>
                                                <a-button type="dashed" v-if="sk.isRedaguojama"
                                                          @click="atsauktiRedagavima(index)">
                                                    <a-icon type="close"/>
                                                    Atšaukti
                                                </a-button>
                                                <a-divider type="vertical"></a-divider>
                                                <a-button type="default" @click="copyVisit(index)">
                                                    <a-icon type="copy"/>
                                                    Kopijuoti
                                                </a-button>
                                                <a-divider type="vertical"></a-divider>
                                                <a-button v-if="!sk.isNewVisit" type="danger" @click="deleteVisit(index)">
                                                    <a-icon type="copy"/>
                                                    Ištrinti vizitą (TEMPORARY)
                                                </a-button>
                                            </div>


                                        </div>

                                    </div>
                                </div>

                            </a-collapse-panel>

                        </a-collapse>
                    </div>
                    <a-divider type="horizontal" orientation="left"></a-divider>
                    <a-button v-on:click="addVisit()" type="primary" style="margin-bottom: 10px; margin-left: 10px;">
                        <a-icon type="plus"/>
                        Pridėti apsilankymą
                    </a-button>
                </div>
            </div>
        </div>


        <!--baigias apsilankymu lapas-->


        <!-- Checks if models != null. May not need some of the models in the check because of rendering, like 'isUzdarymoData', which may be null.  -->
        <div v-if="isFullInfoID && isPaskirtis && isKortelesNr && isSusijusioDokNr && isDraustumas &&
                    isApSiuntimas && isApBrigada && isApButinoji && isApPSDF && isAtidarymoData && isUzdarymoData
                    && isDiagnosis && isdiagnosis_list && isVisits && isDiagnosis_table ">
            <div class="col-md-6">
                <a-divider type="horizontal" orientation="left">Pagrindinė dalis</a-divider>
                <div class="box">
                    <div class="box-body">


                        <!--pagrindinė dalis-->


                        <a-collapse defaultActiveKey="1">
                            <a-collapse-panel header="Pagrindinė dalis" key="1">
                                <div class="col-md-3" style="margin-bottom:12px; margin-top:12px;">
                                    <a-input addonBefore="Paskirtis" :value="Paskirtis" disabled=""/>
                                </div>
                                <div class="col-md-4" style="margin-bottom:12px; margin-top:12px;">
                                    <a-input addonBefore="Kortelės nr." :value="KortelesNr" disabled=""/>
                                </div>
                                <div class="col-md-5" style="margin-bottom:12px; margin-top:12px;">
                                    <a-input addonBefore="Susijusio dokumento Nr." :value="SusijusioDokNr" disabled=""/>
                                </div>
                                <a-divider type="horizontal" orientation="left">Draustumas</a-divider>
                                <a-radio-group name="radioGroup">
                                    <a-radio :value="1" style="font-weight:normal"
                                             :class="Draustumas=='1' ? 'ant-radio-checked' : ''" disabled="">Apdraustas
                                        PSD
                                    </a-radio>
                                    <a-radio :value="2" style="font-weight:normal" disabled=""
                                             :class="Draustumas=='3' ? 'ant-radio-checked' : ''">Kita
                                    </a-radio>
                                    <a-radio :value="3" style="font-weight:normal" disabled=""
                                             :class="Draustumas=='2' ? 'ant-radio-checked' : ''">Apdraustas EEE šalyje
                                        ar Šveicarijoje
                                    </a-radio>
                                </a-radio-group>
                                <a-divider type="horizontal" orientation="left">Bendrieji apsilankymų duomenys
                                </a-divider>
                                <a-input addonBefore="Pacientas prisirašęs prie" defaultValue="" disabled=""/>
                                <a-checkbox-group style="margin-top:15px; margin-bottom:15px;" v-if="ApCheckedList"
                                                  v-model="ApCheckedList" v-on:click="changeApPSDFState">
                                    <a-row>
                                        <a-checkbox value="ApSiuntimas" style="font-weight:normal">Atvyko pagal
                                            siuntimą
                                        </a-checkbox>
                                        <a-checkbox value="ApBrigada" style="font-weight:normal">Atvežė GMP brigada
                                        </a-checkbox>
                                        <a-checkbox value="ApButinoji" style="font-weight:normal">Būtinoji pagalba
                                        </a-checkbox>
                                        <a-checkbox value="ApPSDF" disabled style="font-weight:normal">Mokėtina iš PSDF
                                        </a-checkbox>
                                    </a-row>
                                </a-checkbox-group>
                                <a-input addonBefore="Periodas" :value="FullInfoID" disabled=""/>


                                <!--galutinės diagnozės-->


                                <a-divider type="horizontal" orientation="left" style="margin-top:50px;">Galutinių
                                    diagnozių sąrašas
                                </a-divider>
<!--                                <v-app style="height: auto">-->

                                    <div class="col-sm-12">
                                        <v-toolbar flat color="white">

                                            <v-spacer></v-spacer>

                                            <!--  Dialog box that opens when pressed 'Nauja diagnoze'  -->
                                            <v-dialog v-model="dialog" max-width="full">
                                                <template v-slot:activator="{ on }">
                                                    <v-btn color="primary" dark class="mb-2" v-on="on">Nauja diagnozė
                                                    </v-btn>
                                                </template>
                                                <v-card>
                                                    <v-card-title>
                                                        <span class="headline">{{ formTitle }}</span>
                                                    </v-card-title>
                                                    <v-card-text>

                                                        <v-container grid-list-md>
                                                            <v-layout wrap>
                                                                <v-flex xs12>
                                                                    <v-menu
                                                                        ref="menu"
                                                                        v-model="datepicker_menu_nauja_diagnoze"
                                                                        :close-on-content-click="false"
                                                                        transition="scale-transition"
                                                                        offset-y
                                                                        min-width="290px"
                                                                        style="top:200px;left:300px;"
                                                                    >
                                                                        <template v-slot:activator="{ on }">
                                                                            <v-text-field
                                                                                v-model="editedItem.DATA"
                                                                                label="Data"
                                                                                readonly
                                                                                v-on="on"
                                                                                outlined
                                                                                style="margin-top:15px; margin-bottom:-20px;"
                                                                            ></v-text-field>
                                                                        </template>
                                                                        <v-date-picker v-model="editedItem.DATA" no-title  locale="lt" @input="datepicker_menu = false">
                                                                        </v-date-picker>
                                                                    </v-menu>




<!--                                                                    <v2-datepicker v-model="editedItem.DATA"-->
<!--                                                                                   class="col-sm-12" :lang="lang"-->
<!--                                                                                   :customLocals="locals"-->
<!--                                                                                   placeholder="Data"-->
<!--                                                                                   :picker-options="pickerOptions2"-->
<!--                                                                                   :value="dateToday"-->
<!--                                                                                   valueType="format"></v2-datepicker>-->



                                                                </v-flex>
                                                                <v-flex xs12>
                                                                    <multiselect v-model="editedItem.LIGOS_KODAS"
                                                                                 label="name" track-by="name"
                                                                                 placeholder="Įveskite tris simbolius"
                                                                                 open-direction="bottom"
                                                                                 :options="diagnosis_list"
                                                                                 :searchable="true"
                                                                                 :internal-search="false"
                                                                                 :close-on-select="true"
                                                                                 :options-limit="300" :limit="10"
                                                                                 :max-height="600"
                                                                                 :show-no-results="true"
                                                                                 :show-labels="false" :taggable="false"
                                                                                 @search-change="GetList">
                                                                        <template slot="singleLabel" slot-scope="props"
                                                                                  v-if="props.option.name != undefined">
                                                                            {{props.option.name}}
                                                                        </template>
                                                                        <template slot="singleLabel" slot-scope="props"
                                                                                  v-if="props.option.name == undefined">
                                                                            {{editedItem.LIGOS_KODAS }}
                                                                        </template>
                                                                        <template slot="option" slot-scope="props">
                                                                            <div class="option__desc"><span
                                                                                class="option__small">{{ props.option.code}} {{ props.option.title}}</span>
                                                                            </div>
                                                                        </template>
                                                                        <template slot="noOptions" slot-scope="props">
                                                                            <div>Įrašykite bent 4 pirmpas vardo raides
                                                                            </div>
                                                                        </template>
                                                                        <template slot="noResult" slot-scope="props">
                                                                            <div>Specialistas nerastas</div>
                                                                        </template>
                                                                    </multiselect>
                                                                </v-flex>
                                                                <v-flex xs12>
                                                                    <a-select defaultValue="+"
                                                                              v-model="editedItem.LIGOS_TIPAS">
                                                                        <a-select-option value="+">+</a-select-option>
                                                                        <a-select-option value="-">-</a-select-option>
                                                                        <a-select-option value="0">0</a-select-option>
                                                                    </a-select>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue darken-1" text @click="close">Atšaukti
                                                        </v-btn>
                                                        <v-btn color="blue darken-1" text @click="save">Išsaugoti
                                                        </v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>


                                        </v-toolbar>


                                        <v-flex>
                                            <v-data-table
                                                :headers="headers"
                                                :items="Diagnosis_table"
                                                class="elevation-2"
                                                sort-icon="anticon-up"
                                                expand
                                                hide-actions
                                                style="margin-top:15px;margin-bottom:15px;"
                                            >
                                                <template v-slot:items="props">
                                                    <td>{{ props.item.DATA }}</td>
                                                    <td class="text-xs-right">{{ props.item }}</td>
                                                    <td class="text-xs-right">{{ props.item.LIGOS_TIPAS }}</td>
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
                                                    <v-btn color="primary" @click="initialize">Atnaujinti sąrašą</v-btn>
                                                </template>
                                            </v-data-table>
                                        </v-flex>
                                    </div>



                                <!--baigiamoji dalis-->


                                <a-divider type="horizontal" orientation="left" style="margin-top:50px">Baigiamoji
                                    dalis
                                </a-divider>
                                <div class="form-group row date">
                                    <label class="col-sm-4 col-form-label" style="margin-top:10px;">Kortelės užvedimo data, laikas</label>
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_atidarymo"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                        style="top:200px;left:300px;"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                class="col-md-3"
                                                v-model="AtidarymoData[0]"
                                                label=""
                                                readonly
                                                v-on="on"
                                                outlined
                                                style="margin-top:15px;"
                                                disabled
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="AtidarymoData[0]" no-title  locale="lt" @input="datepicker_menu = false">
                                        </v-date-picker>
                                    </v-menu>



<!--                                    <v2-datepicker class="col-sm-4" format="yyyy-MM-DD" :lang="lang"-->
<!--                                                   :customLocals="locals" placeholder="Data"-->
<!--                                                   :picker-options="pickerOptions2" :value="AtidarymoData[0]"-->
<!--                                                   disabled></v2-datepicker>-->
                                    <a-time-picker :defaultValue="moment(AtidarymoData[1], 'HH:mm:ss')"
                                                   format="HH:mm:ss" placeholder="Laikas" disabled style="margin-top: 18px; margin-left:5px;" class="no-icon .ant-time-picker-icon"/>
                                </div>
                                <div class="form-group row date">
                                    <label class="col-sm-4 col-form-label" style="margin-top:10px;">Kortelės užbaigimo data, laikas</label>
                                    <v-menu
                                        ref="menu"
                                        v-model="datepicker_menu_uzbaigimo"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                        style="top:200px;left:300px;"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                class="col-md-3"
                                                v-model="UzdarymoData[0]"
                                                label=""
                                                readonly
                                                v-on="on"
                                                outlined
                                                style="margin-top:15px;"
                                                disabled
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="UzdarymoData[0]" no-title  locale="lt" @input="datepicker_menu_uzbaigimo = false">
                                        </v-date-picker>
                                    </v-menu>



<!--                                    <v2-datepicker class="col-sm-4" format="yyyy-MM-DD" :lang="lang"-->
<!--                                                   :customLocals="locals" placeholder="Data"-->
<!--                                                   :picker-options="pickerOptions2" :value="UzdarymoData[0]"-->
<!--                                                   disabled></v2-datepicker>-->


                                    <a-time-picker :defaultValue="moment(UzdarymoData[1], 'HH:mm:ss')" format="HH:mm:ss"
                                                   placeholder="Laikas" disabled style="margin-top: 18px; margin-left:5px;" suffixIcon="" class="no-icon .ant-time-picker-icon"/>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Atsakingas asmuo</label>
                                    <div class="col-sm-6">
                                        <multiselect v-model="AtsakingasAsmuo" label="name" track-by="name"
                                                     placeholder="Įveskite specialisto vardą" open-direction="bottom"
                                                     :options="list" :multiple="true" :searchable="true"
                                                     :internal-search="false" :clear-on-select="true"
                                                     :close-on-select="true" :options-limit="300" :limit="10"
                                                     :max-height="600" :show-no-results="true" :show-labels="false"
                                                     @search-change="getSpecialistName">
                                            <template slot="noOptions" slot-scope="props">
                                                <div>Įrašykite bent 4 pirmas vardo raides</div>
                                            </template>
                                            <template slot="noResult" slot-scope="props">
                                                <div>Specialistas nerastas</div>
                                            </template>
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Specialistas</label>
                                    <div class="col-sm-6">
                                        <multiselect v-model="AtsakingasAsmuo" label="name" track-by="name"
                                                     placeholder="Įveskite specialisto vardą" open-direction="bottom"
                                                     :options="list" :multiple="true" :searchable="true"
                                                     :internal-search="false" :clear-on-select="true"
                                                     :close-on-select="true" :options-limit="300" :limit="10"
                                                     :max-height="600" :show-no-results="true" :show-labels="false"
                                                     @search-change="getSpecialistName">
                                            <template slot="noOptions" slot-scope="props">
                                                <div>Įrašykite bent 4 pirmas vardo raides</div>
                                            </template>
                                            <template slot="noResult" slot-scope="props">
                                                <div>Specialistas nerastas</div>
                                            </template>
                                        </multiselect>
                                    </div>
                                </div>
                                <!--  Currently only saves Diagnosis Table  -->
                                <div class="text-center">
                                    <a-button type="primary" @click="editPagrindineDalisDiagnozes" icon="save"
                                              style="margin-top:15px;">Išsaugoti
                                    </a-button>
                                </div>
                            </a-collapse-panel>
                        </a-collapse>
                        <!--                    baigias pagrindinė dalis-->
                    </div>
                </div>
            </div>
        </div>

    </div>
    </v-app>
</template>

<script>
    import 'v2-datepicker/lib/index.css';
    import {LinksFunction} from "../../components/ReadLinkInfo";
    import moment from 'moment';
    import axios from 'axios';
    import V2Datepicker from 'v2-datepicker';
    import Option from "ant-design-vue/es/vc-select/Option";
    import ARadioButton from "ant-design-vue/es/radio/RadioButton";
    import ARadioGroup from "ant-design-vue/es/radio/Group";
    import locals from "v2-datepicker/lib/locals.js";

    Vue.use(V2Datepicker);
    const columns = [{
        title: 'Data',
        dataIndex: 'DATA',
        width: '15%',
        scopedSlots: {customRender: 'Data'},
    }, {
        title: 'TLK-10-AM kodas',
        dataIndex: 'LIGOS_KODAS',
        width: '25%',
        scopedSlots: {customRender: 'kodas'},
    }, {
        title: 'LIGOS TIPAS +/-/0',
        dataIndex: 'LIGOS_TIPAS',
        width: '40%',
        scopedSlots: {customRender: 'tipas'},
    },
        //     {
        //     title: '+/-/0',
        //     dataIndex: 'plius',
        //     width: '10%',
        //     scopedSlots: { customRender: 'plius' },
        // }, {
        //     title: 'Traumos priežastis',
        //     dataIndex: 'priezastis',
        //     width: '25%',
        //     scopedSlots: { customRender: 'priezastis' },
        // },
        {
            title: 'Veiksmai',
            dataIndex: 'operation',
            width: '20%',
            scopedSlots: {customRender: 'operation'},
        }];

    const data = [];
    for (let i = 0; i < 5; i++) {
        data.push({
            key: i.toString(),
            name: `Edrward ${i}`,
            age: 32,
            address: `London Park no. ${i}`,
        })
    }
    export default {
        components: {ARadioGroup, ARadioButton, Option},
        name: "MainInformation",

        data() {

            this.cacheData = data.map(item => ({...item}));
            const panes = [
                {
                    title: '1', content: '', key: '1'
                },
            ];
            const panes_priemoka = [
                {
                    title: '1', content: '', key: '1'
                },
            ];
            return {


                // Galutiniu diagnoziu lentele

                dialog: false,
                headers: [{
                    text: 'Data',
                    align: 'left',
                    sortable: true,
                    value: 'DATA'
                },
                    {text: 'TLK-10-AM kodas', value: 'LIGOS_KODAS', sortable: true},
                    {text: 'Ligos Tipas (+/0/-)', value: 'LIGOS_TIPAS', sortable: false},
                    // {text: 'Traumos priežastis', value: '-', sortable: false},
                    {text: 'Veiksmai', value: 'action', sortable: false}
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    DATA: '',
                    LIGOS_KODAS: '',
                    LIGOS_TIPAS: '',
                },
                defaultItem: {
                    DATA: '',
                    LIGOS_KODAS: '',
                    LIGOS_TIPAS: '',
                },

                ///////////


                instanceid: [],
                datepicker_menu: false,
                kaina: [],
                mok_paslaugos_list: '',
                activeClass: 'active',
                lang: 'lt',
                locals,
                data,
                pavadinimas: 'test',
                columns,
                PatientPC: '',
                PatientInformation: '',
                PatientHistory: '',
                activeKeyIntervencijos: 1,
                panes,

                activeKey: ['1'],
                newTabIndex: 2,
                activeKey_Priemoka: 1,
                panes_priemoka,
                newTabIndex_Priemoka: 2,
                dateToday: '',
                priem_sarasas: [
                    {
                        name: '2 - mokama privataus draudimo fondo lėšomis',
                        value: '2',
                    },
                    {
                        name: '3 - mokama darbdavio lėšomis',
                        value: '3',
                    },
                    {
                        name: '4 - mokama paciento lėšomis',
                        value: '4',
                    },
                    {
                        name: '5 - mokama labdaros lėšomis',
                        value: '5',
                    },
                    {
                        name: '6 - mokama savivaldybės lėšomis',
                        value: '6',
                    },
                    {
                        name: '7 - gydymo įstaigos suteikta labdara',
                        value: '7',
                    },
                    {
                        name: '8 - apmoka kita ASPĮ',
                        value: '8',
                    },
                    {
                        name: '9 - kita',
                        value: '9'
                    }
                ],
                rez_sarasas: [
                    {
                        name: '1 - gydymas baigtas'
                    },
                    {
                        name: '2 - gydymas tęsiamas'
                    },
                    {
                        name: '3 - ilgalaikis stebėjimas tęsiamas'
                    },
                    {
                        name: '4 - siuntimas konsultacijai'
                    },
                    {
                        name: '5 - siuntimas į kitą įstaigą ambulatoriniam gydymui ar tyrimams'
                    },
                    {
                        name: '6 - siuntimas stacionariniam gydymui į kitą įstaigą'
                    },
                    {
                        name: '7 - hospitalizuojamas tos pačios įstaigos stacionare'
                    },
                    {
                        name: 'siuntimas stacionarinei reabilitacijai'
                    },
                    {
                        name: '9 - siuntimas ambulatorinei reabilitacijai'
                    },
                    {
                        name: '10 - kita'
                    },
                    {
                        name: '99 - mirties liudijimo išrašymas'
                    }
                ],
                isClicked: [],
                isDisabled: [],
                isClicked_pasltipas: [],
                isClickedPaslaugosTipas: [],
                apsilankymas: [
                    {
                        name: '2',
                        value: '2',
                        popover: 'pirmasis, ketvirtasis, septintasis ir t. t. apsilankymas dėl tos pačios priežasties pas specialistą konsultantą (konsultacija)'
                    },
                    {
                        name: '3',
                        value: '3',
                        popover: 'antrasis, trečiasis, penktasis, šeštasis, aštuntasis, devintasis ir t. t. apsilankymas dėl tos pačios priežasties pas tos pačios srities specialistą konsultantą'
                    },
                    {
                        name: '5',
                        value: '5',
                        popover: 'mokamas apsilankymas (sumoka pats pacientas arba kita įstaiga)'
                    }
                ],
                toggle_multiple: [],  // PASLAUGOS_TIPAS2 button array
                toggle_multiple_ids: [], //PASLAUGOS_TIPAS2 IDS array
                diagnozes: [],
                diagnosis_ligos_tipas: ['+', '-', '0'],
                list: [],
                FullInfo: [],
                isNewVisit: false,
                islist: false,
                fakelist: [],
                ApCheckedList: [],
                diagnosis_list: [],
                isdiagnosis_list: false,
                diagnosis_fakelist: [],
                paslaugos_list: [],
                paslaugos_fakelist: [],
                achi_list: [],
                achi_fakelist: [],
                SusijusioDokNr: '',
                isSusijusioDokNr: false,
                Paskirtis: '',
                isPaskirtis: false,
                KortelesNr: '',
                isKortelesNr: false,
                isRedaguojama: [],
                ApSiuntimas: '',
                isApSiuntimas: false,
                ApBrigada: '',
                isApBrigada: false,
                ApButinoji: '',
                isApButinoji: false,
                ApPSDF: '',
                isApPSDF: false,
                Draustumas: '',
                isDraustumas: false,
                FullInfoID: '',
                isFullInfoID: false,
                Diagnosis: '',
                isDiagnosis: false,
                Diagnosis_table: [],
                isDiagnosis_table: false,
                AtidarymoData: '',
                isAtidarymoData: false,
                UzdarymoData: '',
                isUzdarymoData: false,
                AtsakingasAsmuo: '',
                Visits: [],
                isVisits: false,
                ApsilankymoTipas: [],
                Intervencija: [],
                isIntervencija: false,
                Priemoka: [],
                isPriemoka: false,
                Priemoka_object: [],
                Priemoka_name: [],
                // Buttons: [],
                ButtonModel: [],
                ButtonModelRez: [],
                ButtonModelLKodas: [],
                ButtonModelACHIKodas: [],
                ButtonModelPKodas: [],
                ButtonModelPriem: [],
                ButtonModelBD_Atsakingas: [this.AtsakingasAsmuo],
                ButtonModelBD_Specialistas: [],
                //Instance id
                InstanceId: '',
                // FullDiagnosisID
                FullDiagnosisID: [],
                datepicker_menu_uzbaigimo: false,
                datepicker_menu_atidarymo: false,
                datepicker_menu_nauja_diagnoze: false,
                fibonacci_recursive: 0,



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
                }
            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nauja diagnozė' : 'Redaguoti'
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            }
        },

        created() {

        },

        methods: {

            //Diagnosis_table functions
            //Loads/Reloads Diagnosis Table
            initialize() {
                for (var a = 0; a < this.Diagnosis.length; a++) {
                    this.Diagnosis_table.push({
                        DATA: this.Diagnosis[a].DATA,
                        LIGOS_KODAS: this.Diagnosis[a].LIGOS_KODAS,
                        LIGOS_TIPAS: this.Diagnosis[a].LIGOS_TIPAS
                    })
                }
                this.isDiagnosis_table = true;

            },

            //Assigns current object to editedItem and opens dialog box
            editItem(item) {
                this.editedIndex = this.Diagnosis_table.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            //Deletes object from Diagnosis_table and Database
            deleteItem(item) {
                const index = this.Diagnosis_table.indexOf(item)
                var url_delete = '/api/getFullDiagnosis/' + this.FullDiagnosisID[index];
                var isDeleted = false;
                for(let a = 0; a < this.Visits.length; a++) {
                        if (this.Diagnosis_table[index].VIZITO_EIL_NR == this.Visits[a].EIL_NR && this.Diagnosis_table[index].LIGOS_KODAS == this.Visits[a].LIGOS_KODAS.code) {
                            this.openNotification('error', 'deletefirst');
                            isDeleted = true;

                        }
                }
                if(!isDeleted) {
                    confirm('Ar tikrai norite ištrinti šį įrašą (negrįžtamai)?') && this.Diagnosis_table.splice(index, 1) && axios.delete(url_delete)
                }



            },

            //Saving diagnosis to database
            editPagrindineDalisDiagnozes() {
                for (var a = 0; a < this.Diagnosis_table.length; a++) {
                    var url = '/api/getFullDiagnosis/' + this.FullDiagnosisID[a]
                    var url_post = '/api/getFullDiagnosis'

                    //Updating data in FullInformationCardDiagnosis datatable
                    //If entry does not exist in database, create a new one
                    if (!this.FullDiagnosisID[a]) {
                        axios.post(url_post, {
                            DATA: this.Diagnosis_table[a].DATA,
                            LIGOS_KODAS: this.Diagnosis_table[a].LIGOS_KODAS,
                            LIGOS_TIPAS: this.Diagnosis_table[a].LIGOS_TIPAS,
                            fullinfoid: this.FullInfoID
                        })
                    }
                    //If entry exists in database, update it
                    else {
                        axios.put(url, {
                            id: this.FullDiagnosisID[a],
                            DATA: this.Diagnosis_table[a].DATA,
                            LIGOS_KODAS: this.Diagnosis_table[a].LIGOS_KODAS,
                            LIGOS_TIPAS: this.Diagnosis_table[a].LIGOS_TIPAS

                        })
                    }


                }


            },

            //Gets all 'Galutiniu diagnoziu sarasas' items ids
            getFullDiagnosisID(a) {
                axios.get('/api/getFullDiagnosis', {params: {fullinfoid: a}})
                    .then(response => {
                        var temp = response.data
                        for (let a = 0; a < temp.length; a++) {
                            this.FullDiagnosisID[a] = temp[a].id;
                        }

                    })
            },

            //Closes dialog box and empties editItem
            close() {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            //Saves editedItem to local array or creates a new entry in local array if editedItem is a new entry
            save() {
                if(!this.editedItem.DATA || !this.editedItem.LIGOS_KODAS.name || !this.editedItem.LIGOS_TIPAS) {
                    this.openNotification('error', 'required');
                } else {
                    if (this.editedIndex > -1) {
                        this.Diagnosis_table[this.editedIndex].DATA = moment(this.editedItem.DATA).format('YYYY-MM-DD')
                        this.Diagnosis_table[this.editedIndex].LIGOS_KODAS = this.editedItem.LIGOS_KODAS.name
                        this.Diagnosis_table[this.editedIndex].LIGOS_TIPAS = this.editedItem.LIGOS_TIPAS
                    } else {
                        var fixed_date = moment(this.editedItem.DATA).format('YYYY-MM-DD');
                        this.Diagnosis_table.push({
                            DATA: fixed_date,
                            LIGOS_KODAS: this.editedItem.LIGOS_KODAS.name,
                            LIGOS_TIPAS: this.editedItem.LIGOS_TIPAS
                        })
                    }
                    this.close()
                }

            },

            //Gets available diagnosis from database
            GetList(query) {
                this.diagnosis_list = [];
                axios.get('/api/getDiagnosisList', {params: {CODE: query}})
                    .then(response => {
                        this.diagnosis_fakelist = response.data;
                        for (var a = 0; a < this.diagnosis_fakelist.length; a++) {
                            this.diagnosis_list.push({
                                "name": this.diagnosis_fakelist[a].CODE,
                                "code": this.diagnosis_fakelist[a].CODE,
                                "title": this.diagnosis_fakelist[a].TITLE
                            });
                        }
                        this.isdiagnosis_list = true;
                        return this.diagnosis_list;

                    })
                    .catch(error => {
                        console.log(error)
                    });
            },

            //Gets Paslaugos list from database
            getPaslaugosList(query) {
                this.paslaugos_list = [];
                axios.get('/api/getPaslaugosList', {params: {KODAS: query}})
                    .then(response => {
                        this.paslaugos_fakelist = response.data;
                        for (var a = 0; a < this.paslaugos_fakelist.length; a++) {
                            this.paslaugos_list.push({
                                "name": this.paslaugos_fakelist[a].PAVADINIMAS,
                                "code": this.paslaugos_fakelist[a].KODAS,
                                "kaina": this.paslaugos_fakelist[a].KAINA
                            });
                        }
                        return this.paslaugos_list;

                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            setPaslauguKaina(index, index2) {
                if(this.Priemoka_object) {
                    console.log('index: ' + index)
                    console.log('index2: ' + index2)
                    this.Visits[index].PRIEMOKA_MODEL[index2].PRIEMOKA_MOKAMOS_PASLAUGOS = this.Priemoka_object.kaina
                    console.log('kaina: ' + this.Visits[index].PRIEMOKA_MODEL[index2].PRIEMOKA_MOKAMOS_PASLAUGOS)
                    this.Priemoka_object = null;
                }

            },
            setPaslauguKainaObject(selectedOption) {
                console.log('selectedOption: ' + JSON.stringify(selectedOption))
                this.Priemoka_object = selectedOption;
            },

            //Gets data from link
            getLinkInfo(RequestedElement) {
                return LinksFunction(this.$route.query, RequestedElement);
            },


            getAtsakingasAsmuo() {
                axios.get('/api/getAtsakingasAsmuo', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.AtsakingasAsmuo = response.data;
                            return this.AtsakingasAsmuo;
                        }
                    )
            },
            getUzdarymoData() {
                axios.get('/api/getUzdarymoData', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.UzdarymoData = response.data;
                            this.isUzdarymoData = true;
                            return this.UzdarymoData;
                        }
                    )
            },
            getAtidarymoData() {
                axios.get('/api/getAtidarymoData', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.AtidarymoData = response.data;
                            this.isAtidarymoData = true;
                            return this.AtidarymoData;
                        }
                    )
            },

            //Gets F.025 ID from database and sends it to required functions
            getFullInfoID() {
                axios.get('/api/getFullInfoID', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.FullInfoID = response.data;

                            this.getF025Diagnosis(this.FullInfoID);
                            this.getApsilankymai(this.FullInfoID);
                            this.GetInstanceId(this.FullInfoID);
                            this.getFullDiagnosisID(this.FullInfoID);
                            this.isFullInfoID = true;
                            return this.FullInfoID;


                        }
                    )

            },
            getFullInfo() {
                axios.get('/api/getFullInfo', {
                    params: {
                        ASMENS_KODAS:this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                        this.FullInfo = response.data
                        // console.log('fullinfo response.data: ' + JSON.stringify(response.data))
                        console.log('FullInfo: ' + JSON.stringify(this.FullInfo))
                        console.log('FullInfo HIS ID: ' + this.FullInfo[0].HIS_ID)
                        console.log('FullInfo LYTIS: ' + this.FullInfo.LYTIS)
                    })
            },

            //Gets 'Galutiniu diagnoziu sarasas' and initializes the html table
            getF025Diagnosis(a) {
                axios.get('/api/getF025Diagnosis', {params: {fullinfoid: a}})
                    .then(response => {
                            this.Diagnosis = response.data;
                            this.initialize()
                            this.isDiagnosis = true;
                            return this.Diagnosis;
                        }
                    )
            },

            //Gets all Visit ids
            async GetInstanceId(a) {
                await axios.get('/api/getVisits', {params: {fullinfoid: a, KORTELES_NR: this.getLinkInfo('korteles-nr')}})
                    .then(response => {
                        var temp = response.data
                        console.log('getVisits visi id: ' + temp[0])
                        for (let a = 0; a < temp.length; a++) {
                            this.instanceid[a] = temp[a].id;
                            console.log('visu vizitu id: ' + this.instanceid[a])
                        }
                        return this.instanceid
                    })


            },

            async saveVisitType(index){
                var url4 = '/api/getVisitType'
                console.log('vizito id toggle mygtukams: ' + this.instanceid[index])
                for (var c = 0; c < this.Visits[index].toggle_multiple.length; c++) {
                    await axios.post(url4, {
                        fullvisitid: this.instanceid[index],
                        PASLAUGOS_TIPAS2: this.Visits[index].toggle_multiple[c],
                        VERSION: '1'
                    })
                }
            },
            setActiveIntervencija(EIL_NR) {
                if(EIL_NR == 0){
                    this.activeKeyIntervencijos = EIL_NR + 1;
                } else {
                    this.activeKeyIntervencijos = EIL_NR
                }

            },
            setActivePriemoka(EIL_NR) {
                if(EIL_NR == 0){
                    this.activeKey_Priemoka = EIL_NR + 1;
                } else {
                    this.activeKey_Priemoka = EIL_NR
                }

            },

            //Called once user presses "Issaugoti" button on a Visit
           async EditVisit(index) {
                if(!this.Visits[index].isNewVisit) {
                    this.VisitTypeVersionControl(index);
                    this.InterventionVersionControl(index);
                    this.PaymentsVersionControl(index);
                }
                console.log('full info id ', this.FullInfoID ,' indexas ' ,index, ' instance ',this.instanceid)
                var url = '/api/getVisits/' + this.instanceid[index];
                var unformatted_date = moment(this.Visits[index].APSILANKYMO_DATA).format('YYYY-MM-DD');
                unformatted_date.split('T');
                //Checking whether all fields are filled in. If they are, continues to the next section, if not, throws error notification.
                if (!unformatted_date || !this.Visits[index].PASLAUGOS_KODAS.code || !this.Visits[index].LIGOS_KODAS.code || !this.Visits[index].PASLAUGOS_TIPAS1 ||
                    unformatted_date === '-' || this.Visits[index].PASLAUGOS_KODAS.code === '-' || this.Visits[index].LIGOS_KODAS.code === '-' || this.Visits[index].PASLAUGOS_TIPAS1 === '-'
                    || unformatted_date === null || this.Visits[index].PASLAUGOS_KODAS.code == null || this.Visits[index].LIGOS_KODAS.code === null || this.Visits[index].PASLAUGOS_TIPAS1 === null) {
                    this.openNotification('error', 'required')
                } else {
                    var url_post_visits = '/api/getVisits'
                    if(this.Visits[index].isNewVisit) {
                        console.log('Vizitas: ' + JSON.stringify(this.Visits[index]))
                        console.log('its a new visit')
                       await axios.post(url_post_visits, {
                            fullinfoid: this.FullInfoID,
                            EIL_NR: this.Visits[index].EIL_NR,
                            APAP_ID: this.Visits[index].APAP_ID,
                            APSILANKYMO_DATA: unformatted_date,
                            SIUNTIMAS: this.Visits[index].SIUNTIMAS,
                            PASLAUGOS_KODAS: this.Visits[index].PASLAUGOS_KODAS.code,
                            PASLAUGOS_KODAS_TIKSL: this.Visits[index].PASLAUGOS_KODAS_TIKSL,
                            LIGOS_KODAS: this.Visits[index].LIGOS_KODAS.code,
                            PASLAUGOS_TIPAS1: this.Visits[index].PASLAUGOS_TIPAS1,
                            SPECIALISTAS_SP: this.Visits[index].SPECIALISTAS_SP,
                            KORTELES_NR: this.Visits[index].KORTELES_NR,
                            HIS_ID: this.Visits[index].HIS_ID,
                            KAINA_BALAIS: this.Visits[index].KAINA_BALAIS,
                            KAINA: this.Visits[index].KAINA,
                            VALIUTA: this.Visits[index].VALIUTA,
                            MOKAMA_IS_PSDF: this.Visits[index].MOKAMA_IS_PSDF,
                            EIL_NR_UI: this.Visits[index].EIL_NR_UI,

                        });
                            // .then(this.GetInstanceId(this.FullInfoID) && this.saveVisitType(index));

                    // Adding current visit diagnosis to "Galutines Diagnozes" local table
                    this.Diagnosis_table.push({
                        DATA: unformatted_date,
                        LIGOS_KODAS: this.Visits[index].LIGOS_KODAS.code,
                        VIZITO_EIL_NR: this.Visits[index].EIL_NR
                    })

                    }

                    //Updating data in FullInformationCardVisits datatable
                    if(!this.Visits[index].isNewVisit) {
                        axios.put(url, {
                            fullinfoid: this.FullInfoID,
                            EIL_NR: this.Visits[index].EIL_NR,
                            APAP_ID: this.Visits[index].APAP_ID,
                            APSILANKYMO_DATA: unformatted_date,
                            SIUNTIMAS: this.Visits[index].SIUNTIMAS,
                            PASLAUGOS_KODAS: this.Visits[index].PASLAUGOS_KODAS.code,
                            PASLAUGOS_KODAS_TIKSL: this.Visits[index].PASLAUGOS_KODAS_TIKSL,
                            LIGOS_KODAS: this.Visits[index].LIGOS_KODAS.code,
                            PASLAUGOS_TIPAS1: this.Visits[index].PASLAUGOS_TIPAS1,
                            SPECIALISTAS_SP: this.Visits[index].SPECIALISTAS_SP,
                            KORTELES_NR: this.Visits[index].KORTELES_NR,
                            HIS_ID: this.Visits[index].HIS_ID,
                            KAINA_BALAIS: this.Visits[index].KAINA_BALAIS,
                            KAINA: this.Visits[index].KAINA,
                            VALIUTA: this.Visits[index].VALIUTA,
                            MOKAMA_IS_PSDF: this.Visits[index].MOKAMA_IS_PSDF,
                            EIL_NR_UI: this.Visits[index].EIL_NR_UI,

                        });
                    }
                    var url_intervention = '/api/getIntervencija';
                    for (let b = 0; b < this.Visits[index].INTERVENCIJA_MODEL.length; b++) {
                        axios.post(url_intervention, {
                            fullvisitid: this.instanceid[index],
                            ISLAIDOS_KONTR_BALAIS: this.Visits[index].INTERVENCIJA_MODEL[b].INTERVENCIJA_ISLAIDOS_KONTR_BALAIS,
                            EIL_NR: this.Visits[index].INTERVENCIJA_MODEL[b].INTERVENCIJA_EIL_NR,
                            SPECIALISTAS_SP: '-', //placeholder
                            ACHI_KODAS: '-', //placeholder
                            VERSION: '1'
                        })
                    }

                    var url_payments = '/api/getPriemoka'
                    for (let a = 0; a < this.Visits[index].PRIEMOKA_MODEL.length; a++) {
                        if(!this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MEDZIAGOS) {
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MEDZIAGOS = '-'
                        }
                        if(!this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_KITA) {
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_KITA = '-'
                        }
                        axios.post(url_payments, {
                            fullvisitid: this.instanceid[index],
                            EIL_NR: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_EIL_NR,
                            FINANSAVIMO_SALTINIS: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_FINANSAVIMO_SALTINIS.value,
                            MOKAMOS_PASLAUGOS: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS,
                            MOKAMOS_PASLAUGOS_KITOS: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS,
                            MOKAMOS_PASLAUGOS_SKUBIOS: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS,
                            PRIEMOKA_MEDZIAGOS: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MEDZIAGOS,
                            PRIEMOKA_KITA: this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_KITA,
                            VERSION: '1'
                        })
                    }

                    await this.GetInstanceId(this.FullInfoID);
                    console.log('await visit ids completed')
                    await this.saveVisitType(index);
                    console.log('await save visit type completed')

                    this.openNotification('success', 'updated')
                }
                if(this.Visits[index].isNewVisit){
                    this.Visits[index].isNewVisit = false;
                }


                // for (let a = 0; a < this.Visits[index].toggle_multiple.length; a++) {
                //     for(var b = 0; b < exists.length; b++){
                //
                //     }

                // if(exists){
                //     axios.put('/api/getVisitType', {
                //
                //     })

                // }
            },

            getApsilankymai(b) {
                axios.get('/api/getApsilankymai', {params: {fullinfoid: b}})
                    .then(response => {
                            var Visits1 = response.data;
                            for (var index = 0; index < Visits1.length; index++) {
                                if (!Visits1[index].SIUNTIMAS) {
                                    Visits1[index].SIUNTIMAS = '-'
                                }
                                if (!Visits1[index].PASLAUGOS_KODAS_TIKSL) {
                                    Visits1[index].PASLAUGOS_KODAS_TIKSL = '-'
                                }
                                if (!Visits1[index].MOKAMA_IS_PSDF) {
                                    Visits1[index].MOKAMA_IS_PSDF = '-'
                                }
                                this.Visits.push({
                                    //Pushing to local array
                                    VISIT_ID: Visits1[index].id,
                                    APAP_ID: Visits1[index].APAP_ID,
                                    APSILANKYMO_DATA: Visits1[index].APSILANKYMO_DATA,
                                    EIL_NR: Visits1[index].EIL_NR,
                                    EIL_NR_UI: Visits1[index].EIL_NR_UI,
                                    HIS_ID: Visits1[index].HIS_ID,
                                    KAINA: Visits1[index].KAINA,
                                    KAINA_BALAIS: Visits1[index].KAINA_BALAIS,
                                    KORTELES_NR: Visits1[index].KORTELES_NR,
                                    LIGOS_KODAS: {
                                        code: Visits1[index].LIGOS_KODAS,
                                    },
                                    MOKAMA_IS_PSDF: Visits1[index].MOKAMA_IS_PSDF,
                                    PASLAUGOS_KODAS: {
                                        code: Visits1[index].PASLAUGOS_KODAS,
                                    },
                                    PASLAUGOS_KODAS_TIKSL: Visits1[index].PASLAUGOS_KODAS_TIKSL,
                                    PASLAUGOS_TIPAS1: Visits1[index].PASLAUGOS_TIPAS1,
                                    RECORDCREATED: Visits1[index].RECORDCREATED,
                                    RECORDUPDATED: Visits1[index].RECORDUPDATED,
                                    SIUNTIMAS: Visits1[index].SIUNTIMAS,
                                    SPECIALISTAS_SP: Visits1[index].SPECIALISTAS_SP,
                                    VALIUTA: Visits1[index].VALIUTA,
                                    fullinfoid: Visits1[index].fullinfoid,
                                    id: Visits1[index].id,
                                    toggle_multiple: [],
                                    toggle_multiple_empty: null,
                                    toggle_multiple_ids: [],
                                    Model: [{
                                        name: Visits1[index].LIGOS_KODAS,
                                        code: Visits1[index].LIGOS_KODAS,
                                        title: index,
                                        pasl_tipas: Visits1[index].PASLAUGOS_TIPAS1,

                                    }],
                                    INTERVENCIJA_MODEL: [],
                                    PRIEMOKA_MODEL: [],

                                    //Saving data to backup variables for a return state (cancel button)
                                    VISIT_ID_BACKUP: Visits1[index].id,
                                    APAP_ID_BACKUP: Visits1[index].APAP_ID,
                                    APSILANKYMO_DATA_BACKUP: Visits1[index].APSILANKYMO_DATA,
                                    EIL_NR_BACKUP: Visits1[index].EIL_NR,
                                    EIL_NR_UI_BACKUP: Visits1[index].EIL_NR_UI,
                                    HIS_ID_BACKUP: Visits1[index].HIS_ID,
                                    KAINA_BACKUP: Visits1[index].KAINA,
                                    KAINA_BALAIS_BACKUP: Visits1[index].KAINA_BALAIS,
                                    KORTELES_NR_BACKUP: Visits1[index].KORTELES_NR,
                                    LIGOS_KODAS_BACKUP: {
                                        code: Visits1[index].LIGOS_KODAS,
                                    },
                                    MOKAMA_IS_PSDF_BACKUP: Visits1[index].MOKAMA_IS_PSDF,
                                    PASLAUGOS_KODAS_BACKUP: {
                                        code: Visits1[index].PASLAUGOS_KODAS,
                                    },
                                    PASLAUGOS_KODAS_TIKSL_BACKUP: Visits1[index].PASLAUGOS_KODAS_TIKSL,
                                    PASLAUGOS_TIPAS1_BACKUP: Visits1[index].PASLAUGOS_TIPAS1,
                                    RECORDCREATED_BACKUP: Visits1[index].RECORDCREATED,
                                    RECORDUPDATED_BACKUP: Visits1[index].RECORDUPDATED,
                                    SIUNTIMAS_BACKUP: Visits1[index].SIUNTIMAS,
                                    SPECIALISTAS_SP_BACKUP: Visits1[index].SPECIALISTAS_SP,
                                    VALIUTA_BACKUP: Visits1[index].VALIUTA,
                                    fullinfoid_BACKUP: Visits1[index].fullinfoid,
                                    id_BACKUP: Visits1[index].id,
                                    toggle_multiple_BACKUP: [],
                                    toggle_multiple_ids_BACKUP: [],
                                    Model_BACKUP: [{
                                        name: Visits1[index].LIGOS_KODAS,
                                        code: Visits1[index].LIGOS_KODAS,
                                        title: index,
                                        pasl_tipas: Visits1[index].PASLAUGOS_TIPAS1,

                                    }],
                                    INTERVENCIJA_MODEL_BACKUP: [],
                                    PRIEMOKA_MODEL_BACKUP: [],
                                    isDisabled: true,
                                    isRedaguojama: false


                                });
                            }
                            var pasl_tipas1;
                            for (var index = 0; index < this.Visits.length; index++) {
                                if (this.Visits[index].PASLAUGOS_TIPAS1 === '2') {
                                    pasl_tipas1 = 0;
                                } else if (this.Visits[index].PASLAUGOS_TIPAS1 === '3') {
                                    pasl_tipas1 = 1;
                                } else if (this.Visits[index].PASLAUGOS_TIPAS1 === '5') {
                                    pasl_tipas1 = 2;
                                }
                                this.setClicked_pasltipas(pasl_tipas1);

                                this.getApsilankymoTipas(this.Visits[index].id, index);
                                this.getIntervencija(this.Visits[index].id, index);
                                this.getPriemoka(this.Visits[index].id, index);



                            }

                            this.disablingVisits();
                            this.isVisits = true;
                        this.getDateToday();
                        this.setActiveVisitPanel(this.Visits.length);
                            return this.Visits;
                        }
                    )
            },

            //if there are interventions for this visit (index), then calls sendIntervencija, otherwise fills the model with default values
            getIntervencija(d, index) {
                axios.get('/api/getIntervencija', {params: {fullvisitid: d}})
                    .then(response => {
                            this.Intervencija = response.data;
                            if (this.Intervencija.length) {
                                this.sendIntervencija(index)
                            }

                            // else {
                            //     this.Visits[index].INTERVENCIJA_MODEL.push({
                            //         INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: '-',
                            //         INTERVENCIJA_EIL_NR: '1',
                            //     })
                            //     this.Visits[index].INTERVENCIJA_MODEL_BACKUP.push({
                            //         INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: '-',
                            //         INTERVENCIJA_EIL_NR: '1',
                            //     })
                            // }
                            this.isIntervencija = true;
                            return this.Intervencija;
                        }
                    )
            },

            //Fills INTERVENCIJA_MODEL with data from database
            sendIntervencija(index) {
                for (var a = 0; a < this.Intervencija.length; a++) {
                    if (this.Intervencija[a].VERSION == '1') {
                        this.Visits[index].INTERVENCIJA_MODEL.push({
                            id: this.Intervencija[a].id,
                            INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: this.Intervencija[a].ISLAIDOS_KONTR_BALAIS,
                            INTERVENCIJA_EIL_NR: this.Intervencija[a].EIL_NR,
                            INTERVENCIJA_VERSION: this.Intervencija[a].VERSION
                        })
                        this.Visits[index].INTERVENCIJA_MODEL_BACKUP.push({
                            id: this.Intervencija[a].id,
                            INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: this.Intervencija[a].ISLAIDOS_KONTR_BALAIS,
                            INTERVENCIJA_EIL_NR: this.Intervencija[a].EIL_NR,
                            INTERVENCIJA_VERSION: this.Intervencija[a].VERSION
                        })
                    }

                    // Not using default values, instead using VERSION CONTROL
                    // else {
                    //     this.Visits[index].INTERVENCIJA_MODEL.push({
                    //         INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: '-',
                    //         INTERVENCIJA_EIL_NR: this.Intervencija[a].EIL_NR,
                    //     })
                    //     this.Visits[index].INTERVENCIJA_MODEL_BACKUP.push({
                    //         INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: '-',
                    //         INTERVENCIJA_EIL_NR: this.Intervencija[a].EIL_NR,
                    //
                    //     })
                    // }
                }
            },

            //fills PRIEMOKA_MODEL with data from database
            getPriemoka(e, index) {
                axios.get('/api/getPriemoka', {params: {fullvisitid: e}})
                    .then(response => {
                            var Priemoka = response.data
                            var finansavimo_saltinis;
                            var mokamos_paslaugos;
                            var mokamos_paslaugos_skubios;
                            var mokamos_paslaugos_kitos;
                            var priemoka_medziagos;
                            var priemoka_kita;
                            var eil_nr;
                            for (var a = 0; a < Priemoka.length; a++) {
                                if (Priemoka[a] && Priemoka[a].VERSION == '1') {
                                    if (Priemoka[a].FINANSAVIMO_SALTINIS) {
                                        for (var x = 0; x < 7; x++) {
                                            if (this.priem_sarasas[x].value === Priemoka[a].FINANSAVIMO_SALTINIS) {
                                                finansavimo_saltinis = this.priem_sarasas[x];
                                            }
                                        }
                                    }
                                    if (Priemoka[a].MOKAMOS_PASLAUGOS) {
                                        mokamos_paslaugos = Priemoka[a].MOKAMOS_PASLAUGOS
                                    }
                                    if (Priemoka[a].MOKAMOS_PASLAUGOS_SKUBIOS) {
                                        mokamos_paslaugos_skubios = Priemoka[a].MOKAMOS_PASLAUGOS_SKUBIOS
                                    }
                                    if (Priemoka[a].MOKAMOS_PASLAUGOS_KITOS) {
                                        mokamos_paslaugos_kitos = Priemoka[a].MOKAMOS_PASLAUGOS_KITOS
                                    }
                                    if (Priemoka[a].EIL_NR) {
                                        eil_nr = Priemoka[a].EIL_NR
                                    }
                                    priemoka_medziagos = Priemoka[a].PRIEMOKA_MEDZIAGOS
                                    priemoka_kita = Priemoka[a].PRIEMOKA_KITA

                                    this.Visits[index].PRIEMOKA_MODEL.push({
                                        id: Priemoka[a].id,
                                        PRIEMOKA_EIL_NR: eil_nr,
                                        PRIEMOKA_FINANSAVIMO_SALTINIS: finansavimo_saltinis,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS: mokamos_paslaugos,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS: mokamos_paslaugos_skubios,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS: mokamos_paslaugos_kitos,
                                        PRIEMOKA_MEDZIAGOS: priemoka_medziagos,
                                        PRIEMOKA_KITA: priemoka_kita
                                    })
                                    //for cancel button
                                    this.Visits[index].PRIEMOKA_MODEL_BACKUP.push({
                                        id: Priemoka[a].id,
                                        PRIEMOKA_EIL_NR: eil_nr,
                                        PRIEMOKA_FINANSAVIMO_SALTINIS: finansavimo_saltinis,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS: mokamos_paslaugos,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS: mokamos_paslaugos_skubios,
                                        PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS: mokamos_paslaugos_kitos,
                                        PRIEMOKA_MEDZIAGOS: priemoka_medziagos,
                                        PRIEMOKA_KITA: priemoka_kita
                                    })
                                } else {
                                    // this.Visits[index].PRIEMOKA_MODEL.push({
                                    //     PRIEMOKA_FINANSAVIMO_SALTINIS: '',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS: '-',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS: '-',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS: '-',
                                    // })
                                    //for cancel button
                                    // this.Visits[index].PRIEMOKA_MODEL_BACKUP.push({
                                    //     PRIEMOKA_FINANSAVIMO_SALTINIS: '',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS: '-',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS: '-',
                                    //     PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS: '-',
                                    // })
                                }
                            }
                            this.isPriemoka = true;
                        }
                    )
            },

            VisitTypeVersionControl(index) {
                console.log('toggle_multiple_ids: ' + this.Visits[index].toggle_multiple_ids)
                for(let a = 0; a < this.Visits[index].toggle_multiple_ids.length; a++) {
                    let url = '/api/getVisitType/' + this.Visits[index].toggle_multiple_ids[a];
                    console.log('Apsilankymo tipo url su id:' + url)
                    axios.put(url, {
                        id: this.Visits[index].toggle_multiple_ids[a],
                        VERSION: '0'
                    })
                }
            },
            InterventionVersionControl(index) {
                for(let a = 0; a < this.Visits[index].INTERVENCIJA_MODEL_BACKUP.length; a++) {
                    let url = '/api/getIntervencija/' +  this.Visits[index].INTERVENCIJA_MODEL_BACKUP[a].id;
                    console.log('Intervenciju url: ' + url)
                    axios.put(url, {
                        id:  this.Visits[index].INTERVENCIJA_MODEL_BACKUP[a].id,
                        VERSION: '0'
                    })

                }
            },
            PaymentsVersionControl(index) {
                let indeksas = index;
                for(let a = 0; a < this.Visits[indeksas].PRIEMOKA_MODEL_BACKUP.length; a++) {
                    let url = '/api/getPriemoka/' + this.Visits[indeksas].PRIEMOKA_MODEL_BACKUP[a].id;
                    console.log('Priemoku url: ' + url)
                    axios.put(url, {
                        id: this.Visits[indeksas].PRIEMOKA_MODEL_BACKUP[a].id,
                        VERSION: '0'
                    })
                }
            },
            //fills toggle_multiple (multiple select buttons)
            getApsilankymoTipas(c, d) {
                axios.get('/api/getApsilankymoTipas', {params: {id: c}})
                    .then(response => {
                            this.ApsilankymoTipas = response.data;
                            for (var a = 0; a < this.ApsilankymoTipas.length; a++) {
                                var index;
                                if(this.ApsilankymoTipas[a].VERSION == '1') {
                                    this.Visits[d].toggle_multiple_ids.push(this.ApsilankymoTipas[a].id)
                                    this.Visits[d].toggle_multiple_ids_BACKUP.push(this.ApsilankymoTipas[a].id)
                                    if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'N') {
                                        index = 0;
                                        this.Visits[d].toggle_multiple.push('N');
                                        this.Visits[d].toggle_multiple_BACKUP.push('N');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'D') {
                                        index = 1;
                                        this.Visits[d].toggle_multiple.push('D');
                                        this.Visits[d].toggle_multiple_BACKUP.push('D');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'L') {
                                        index = 2;
                                        this.Visits[d].toggle_multiple.push('L');
                                        this.Visits[d].toggle_multiple_BACKUP.push('L');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'B') {
                                        index = 3;
                                        this.Visits[d].toggle_multiple.push('B');
                                        this.Visits[d].toggle_multiple_BACKUP.push('B');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'PR') {
                                        index = 4;
                                        this.Visits[d].toggle_multiple.push('PR');
                                        this.Visits[d].toggle_multiple_BACKUP.push('PR');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'A') {
                                        index = 5;
                                        this.Visits[d].toggle_multiple.push('A');
                                        this.Visits[d].toggle_multiple_BACKUP.push('A');
                                    } else if (this.ApsilankymoTipas[a].PASLAUGOS_TIPAS2 === 'M') {
                                        index = 6;
                                        this.Visits[d].toggle_multiple.push('M');
                                        this.Visits[d].toggle_multiple_BACKUP.push('M');
                                    }
                                }
                            }
                            if(this.Visits[d].toggle_multiple.length < 1) {
                                this.Visits[d].toggle_multiple_empty = true;
                            } else {
                                this.Visits[d].toggle_multiple_empty = false;
                            }
                            console.log('this.Visits[d].toggle_multiple.length: ' + this.Visits[d].toggle_multiple.length)
                            this.isClickedPaslaugosTipas.push({
                                name: this.ApsilankymoTipas,
                            });
                            return this.ApsilankymoTipas;
                        }
                    )
            },
            getDraustumas() {
                axios.get('/api/getDraustumas', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.Draustumas = response.data;
                            this.isDraustumas = true;
                            return this.Draustumas;
                        }
                    )
            },
            changeApPSDFState() {
                this.$set(this.ApPSDF, !this.ApPSDF)
            },
            getApPSDF() {
                axios.get('/api/getApPSDF', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.ApPSDF = response.data;
                            if (!this.ApPSDF || this.ApPSDF == '0') {
                                this.ApPSDF = '';
                            } else {
                                this.ApCheckedList.push('ApPSDF');
                                this.ApPSDF = 'ApPSDF';
                            }
                            this.isApPSDF = true;
                            return this.ApPSDF;
                        }
                    )
            },
            getApButinoji() {
                axios.get('/api/getApBrigada', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.ApButinoji = response.data;
                            if (!this.ApButinoji) {
                                this.ApButinoji = '';
                            } else {
                                this.ApButinoji = 'ApButinoji'
                                this.ApCheckedList.push('ApButinoji');
                            }
                            this.isApButinoji = true;
                            return this.ApButinoji;
                        }
                    )
            },
            getDateToday(){
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();


                today = yyyy + '-' + mm + '-' + dd;
                this.dateToday = today;
                console.log(this.dateToday + 'type: ' + typeof this.dateToday)
                return this.dateToday;
            },
            getApBrigada() {
                axios.get('/api/getApBrigada', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.ApBrigada = response.data;
                            if (!this.ApBrigada) {
                                this.ApBrigada = '';
                            } else {
                                this.ApBrigada = 'ApBrigada';
                                this.ApCheckedList.push('ApBrigada');
                            }
                            this.isApBrigada = true;
                            return this.ApBrigada;
                        }
                    )
            },
            getApSiuntimas() {
                this.labtest(); //absolutely random and not related to F.025
                axios.get('/api/getApSiuntimas', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.ApSiuntimas = response.data;
                            if (!this.ApSiuntimas) {
                                this.ApSiuntimas = '';
                            } else {
                                this.ApSiuntimas = 'ApSiuntimas';
                                this.ApCheckedList.push('ApSiuntimas');
                            }
                            this.isApSiuntimas = true;
                            return this.ApSiuntimas;
                        }
                    )
            },
            getPaskirtis() {
                axios.get('/api/getPaskirtis', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.Paskirtis = response.data;
                            this.isPaskirtis = true;
                            return this.Paskirtis;
                        }
                    )

            },
            getKortelesNr() {
                axios.get('/api/getKortelesNr', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.KortelesNr = response.data;
                            this.isKortelesNr = true;
                            return this.KortelesNr;
                        }
                    )
            },
            getSusijusioDokNr() {
                axios.get('/api/getSusijusioDokNr', {
                    params: {
                        ASMENS_KODAS: this.getLinkInfo('personal-code'),
                        KORTELES_NR: this.getLinkInfo('korteles-nr')
                    }
                })
                    .then(response => {
                            this.SusijusioDokNr = response.data;
                            this.isSusijusioDokNr = true;
                            return this.SusijusioDokNr;
                        }
                    )

            },

            getSpecialistName(query) {
                this.list = [];
                if (query.length > 3)
                    axios.get('/api/getSpecialistName', {params: {display_name: query}})
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a = 0; a < this.fakelist.length; a++) {
                                this.list.push({
                                    "name": this.fakelist[a].display_name

                                });
                            }
                            this.islist = true;
                            return this.list;

                        })
                        .catch(error => {
                            console.log(error)
                        });

            },
            GetPatientInformation2() {
                this.PatientPC = LinksFunction(this.$route.query, 'personal-code');
                axios.get('/api/getPatient', {params: {CODE: this.PatientPC}})
                    .then(response => {
                        this.PatientInformation = response.data;
                        return this.PatientInformation;

                    });
                // var a;
                // for( a=0 ; a < 11;a++){
                //     this.Class.push(['','btn-danger']);
                // }
            },
            GetDiagnosisHistory2() {
                this.PatientPC = LinksFunction(this.$route.query, 'personal-code');
                axios.get('/api/getPatientHistory', {params: {CODE: this.PatientPC}})
                    .then(response => {
                        this.PatientHistory = response.data;
                        return this.PatientHistory;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            handleChange(value, key, column) {
                const newData = [...this.data];
                const target = newData.filter(item => key === item.key)[0]
                if (target) {
                    target[column] = value;
                    this.data = newData
                }
            },
            onEdit(targetKey, action) {
                this[action](targetKey)
            },

            //removes from current Visit (index) INTERVENCIJA_MODEL (index2)
            remove(index, index2) {
                var eil_nr = index2;
                if (this.Visits[index].INTERVENCIJA_MODEL[index2]) {
                    this.Visits[index].INTERVENCIJA_MODEL.splice(index2, 1)
                }
                console.log('intervencijos istrynimo galutines eil nr: ' + eil_nr)
                this.setActiveIntervencija(eil_nr)
            },

            //removes from current Visit (index) PRIEMOKA_MODEL (index2)
            removePriemoka(index, index2) {
                if (this.Visits[index].PRIEMOKA_MODEL[index2]) {
                    this.Visits[index].PRIEMOKA_MODEL.splice(index2, 1)
                }
                this.setActivePriemoka(index2)
            },
            clicked(index) {
                // toggle the active class
                this.$set(this.isClicked, index, !this.isClicked[index])
            },

            //sets css classes and calls function to get visit id
            redaguoti(index) {
                // this.$set(this.Visits.isDisabled, index, this.Visits[index].isDisabled = false)
                // this.$set(this.Visits.isRedaguojama, index, this.Visits[index].isRedaguojama[index] = true)
                this.Visits[index].isDisabled=false;
                this.Visits[index].isRedaguojama=true;
                this.GetInstanceId(this.FullInfoID);
                // this.VisitTypeVersionControl();
            },
            atsauktiRedagavima(index) {

                if(this.Visits[index].isNewVisit) {
                    confirm('Ar tikrai norite atšaukti šio įrašo kūrimą?') && this.Visits.splice(index, 1)
                } else {

                    //setting css classes to Visits[index] element

                    this.Visits[index].isDisabled = true;
                    this.Visits[index].isRedaguojama = false;

                    //setting all variables to the state before editing

                    this.Visits[index].VISIT_ID = this.Visits[index].VISIT_ID_BACKUP,
                        this.Visits[index].APAP_ID = this.Visits[index].APAP_ID_BACKUP,
                        this.Visits[index].APSILANKYMO_DATA = this.Visits[index].APSILANKYMO_DATA_BACKUP,
                        this.Visits[index].EIL_NR = this.Visits[index].EIL_NR_BACKUP,
                        this.Visits[index].EIL_NR_UI = this.Visits[index].EIL_NR_UI_BACKUP,
                        this.Visits[index].HIS_ID = this.Visits[index].HIS_ID_BACKUP,
                        this.Visits[index].KAINA = this.Visits[index].KAINA_BACKUP,
                        this.Visits[index].KAINA_BALAIS = this.Visits[index].KAINA_BALAIS_BACKUP,
                        this.Visits[index].KORTELES_NR = this.Visits[index].KORTELES_NR_BACKUP,
                        this.Visits[index].LIGOS_KODAS = this.Visits[index].LIGOS_KODAS_BACKUP
                    console.log(this.Visits[index].LIGOS_KODAS)
                        // code: this.Visits[index].Visits1[index].LIGOS_KODAS,
                        ,
                        this.Visits[index].MOKAMA_IS_PSDF = this.Visits[index].MOKAMA_IS_PSDF,
                        this.Visits[index].PASLAUGOS_KODAS = this.Visits[index].PASLAUGOS_KODAS_BACKUP
                        // code: Visits1[index].PASLAUGOS_KODAS,
                        ,
                        this.Visits[index].PASLAUGOS_KODAS_TIKSL = this.Visits[index].PASLAUGOS_KODAS_TIKSL_BACKUP,
                        this.Visits[index].PASLAUGOS_TIPAS1 = this.Visits[index].PASLAUGOS_TIPAS1_BACKUP,
                        this.Visits[index].RECORDCREATED = this.Visits[index].RECORDCREATED_BACKUP,
                        this.Visits[index].RECORDUPDATED = this.Visits[index].RECORDUPDATED_BACKUP,
                        this.Visits[index].SIUNTIMAS = this.Visits[index].SIUNTIMAS_BACKUP,
                        this.Visits[index].SPECIALISTAS_SP = this.Visits[index].SPECIALISTAS_SP_BACKUP,
                        this.Visits[index].VALIUTA = this.Visits[index].VALIUTA_BACKUP,
                        this.Visits[index].fullinfoid = this.Visits[index].fullinfoid_BACKUP,
                        this.Visits[index].id = this.Visits[index].id_BACKUP,
                        this.Visits[index].toggle_multiple = [...this.Visits[index].toggle_multiple_BACKUP],
                        this.Visits[index].Model = [...this.Visits[index].Model_BACKUP],
                        this.Visits[index].INTERVENCIJA_MODEL = [...this.Visits[index].INTERVENCIJA_MODEL_BACKUP]

                    //sets BACKUP state for INTERVENCIJA_MODEL
                    for (var a = 0; a < this.Visits[index].INTERVENCIJA_MODEL_BACKUP.length; a++) {
                        this.Visits[index].INTERVENCIJA_MODEL[a].INTERVENCIJA_EIL_NR = this.Visits[index].INTERVENCIJA_MODEL_BACKUP[a].INTERVENCIJA_EIL_NR,
                            this.Visits[index].INTERVENCIJA_MODEL[a].INTERVENCIJA_ISLAIDOS_KONTR_BALAIS = this.Visits[index].INTERVENCIJA_MODEL_BACKUP[a].INTERVENCIJA_ISLAIDOS_KONTR_BALAIS
                    }
                    //deletes user added INTERVENCIJA_MODEL elements
                    var deleteCountIntervencija = this.Visits[index].INTERVENCIJA_MODEL.length - this.Visits[index].INTERVENCIJA_MODEL_BACKUP.length;
                    this.Visits[index].INTERVENCIJA_MODEL.splice(this.Visits[index].INTERVENCIJA_MODEL_BACKUP.length, deleteCountIntervencija)

                    //sets BACKUP state for PRIEMOKA_MODEL
                    for (var a = 0; a < this.Visits[index].PRIEMOKA_MODEL_BACKUP.length; a++) {
                        this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS = this.Visits[index].PRIEMOKA_MODEL_BACKUP[a].PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS,
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS = this.Visits[index].PRIEMOKA_MODEL_BACKUP[a].PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS,
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_FINANSAVIMO_SALTINIS = this.Visits[index].PRIEMOKA_MODEL_BACKUP[a].PRIEMOKA_FINANSAVIMO_SALTINIS,
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_MOKAMOS_PASLAUGOS = this.Visits[index].PRIEMOKA_MODEL_BACKUP[a].PRIEMOKA_MOKAMOS_PASLAUGOS,
                            this.Visits[index].PRIEMOKA_MODEL[a].PRIEMOKA_EIL_NR = this.Visits[index].PRIEMOKA_MODEL_BACKUP[a].PRIEMOKA_EIL_NR
                    }
                    //deletes user added PRIEMOKA_MODEL elements
                    var deleteCountPriemoka = this.Visits[index].PRIEMOKA_MODEL.length - this.Visits[index].PRIEMOKA_MODEL_BACKUP.length;
                    this.Visits[index].PRIEMOKA_MODEL.splice(this.Visits[index].PRIEMOKA_MODEL_BACKUP.length, deleteCountPriemoka)


                    console.log(this.Visits[index].PRIEMOKA_MODEL)
                }
            },

            //sets css classes and calls function to save edited stuff
            issaugotiVizita(index) {
                this.Visits[index].isDisabled = true;
                this.Visits[index].isRedaguojama = false;
                this.EditVisit(index);
            },

            //setting css class as disabled for all visits
            disablingVisits() {
                for (var a = 0; a < this.Visits.length; a++) {
                    this.isDisabled[a] = true;
                }
            },
            clicked_pasltipas(a) {
                // toggle the active class
                for (var index = 0; index < 2; index++) {
                    if (index == a) {
                        this.$set(this.isClicked_pasltipas, a, this.isClicked_pasltipas[a] = true)
                    } else {
                        this.$set(this.isClicked_pasltipas, a, this.isClicked_pasltipas[a] = false)
                    }

                }
            },
            setClicked_pasltipas(a) {

                this.$set(this.isClicked_pasltipas, a, !this.isClicked_pasltipas[a])
                // this.$set(this.isClicked, a, !this.isClicked[a])

            },
            setClicked(d, index) {

                this.$set(this.isClicked[d], index, this.isClicked[d][index] = true)

            },
            PaslaugosTipasClicked(a, b) {
                if (a === b) {
                    this.$set(this.isClickedPaslaugosTipas, index, !this.isClickedPaslaugosTipas[index])
                }
            },
            uncheck: function (val) {
                if (val === this.previouslySelected) {
                    this.selected = false;
                }
                this.previouslySelected = this.selected;
            },
            uncheckAll: function () {
                this.selected = false;
            },

            //not used anymore, left for future reference. UPDATE: NOW USING FOR TESTING ENVIRONMENT
            deleteVisit(index) {
                console.log(this.instanceid[index])
                console.log(this.instanceid)
                console.log('vizitas trinimui: ' + this.Visits[index])

                var url = '/api/getVisits/' + this.instanceid[index]
                console.log(url)
                confirm('Ar tikrai norite ištrinti šį įrašą?') && this.Visits.splice(index, 1) && axios.delete(url) && this.instanceid.splice(index, 1)

            },

            //Copies current Visit data to a new one locally and to database
            copyVisit(index) {
                var url = '/api/getVisits';
                var kortelesnr = LinksFunction(this.$route.query, 'korteles-nr');
                var time = this.Visits.length + 1

                this.$set(this.isDisabled, this.Visits.length, this.isDisabled[this.Visits.length] = true)

                //Pushing a copy of current Visit to local array
                this.Visits.push({
                    APAP_ID:this.FullInfo.APAP_ID,
                    APSILANKYMO_DATA: this.Visits[index].APSILANKYMO_DATA,
                    EIL_NR: time,
                    EIL_NR_UI: time,
                    HIS_ID: this.FullInfo.HIS_ID,
                    KAINA: this.Visits[index].KAINA,
                    KAINA_BALAIS: this.Visits[index].KAINA_BALAIS,
                    KORTELES_NR: this.Visits[index].KORTELES_NR,
                    LIGOS_KODAS: this.Visits[index].LIGOS_KODAS,
                    MOKAMA_IS_PSDF: this.Visits[index].MOKAMA_IS_PSDF,
                    PASLAUGOS_KODAS: this.Visits[index].PASLAUGOS_KODAS,
                    PASLAUGOS_KODAS_TIKSL: this.Visits[index].PASLAUGOS_KODAS_TIKSL,
                    PASLAUGOS_TIPAS1: this.Visits[index].PASLAUGOS_TIPAS1,
                    RECORDCREATED: this.Visits[index].RECORDCREATED,
                    RECORDUPDATED: this.Visits[index].RECORDUPDATED,
                    SIUNTIMAS: this.Visits[index].SIUNTIMAS,
                    SPECIALISTAS_SP: this.Visits[index].SPECIALISTAS_SP,
                    VALIUTA: this.Visits[index].VALIUTA,
                    fullinfoid: this.Visits[index].fullinfoid,
                    id: this.Visits[index].id,
                    toggle_multiple: this.Visits[index].toggle_multiple,
                    Model: this.Visits[index].Model,
                    INTERVENCIJA_MODEL: this.Visits[index].INTERVENCIJA_MODEL,
                    PRIEMOKA_MODEL: this.Visits[index].PRIEMOKA_MODEL,
                    isNewVisit: false,
                    isRedaguojama: true,
                    isDisabled: false
                });

                let unformatted_date = moment(this.Visits[index].APSILANKYMO_DATA).format('YYYY-MM-DD')
                unformatted_date.split('T')

                // Posting available data to FullInformationCardVisits datatable
                axios.post(url, {
                    fullinfoid: this.FullInfoID,
                    EIL_NR: time,
                    APAP_ID: this.FullInfo[0].APAP_ID,
                    APSILANKYMO_DATA: unformatted_date,
                    SIUNTIMAS: this.Visits[index].SIUNTIMAS,
                    PASLAUGOS_KODAS: this.Visits[index].PASLAUGOS_KODAS.code,
                    PASLAUGOS_KODAS_TIKSL: this.Visits[index].PASLAUGOS_KODAS_TIKSL,
                    LIGOS_KODAS: this.Visits[index].LIGOS_KODAS.code,
                    PASLAUGOS_TIPAS1: this.Visits[index].PASLAUGOS_TIPAS1,
                    SPECIALISTAS_SP: this.Visits[index].SPECIALISTAS_SP,
                    KORTELES_NR: kortelesnr,
                    HIS_ID: this.FullInfo[0].HIS_ID,
                    KAINA_BALAIS: this.Visits[index].KAINA_BALAIS,
                    KAINA: this.Visits[index].KAINA,
                    VALIUTA: this.Visits[index].VALIUTA,
                    MOKAMA_IS_PSDF: this.Visits[index].MOKAMA_IS_PSDF,
                    EIL_NR_UI: time,
                })
                // //////////
                // // Posting available data to FullInformationCardVisitTypes datatable
                // var url_types = '/api/getVisitType'
                // for (let a = 0; a < this.Visits[index].toggle_multiple.length; a++) {
                //     axios.post(url_types, {
                //         fullvisitid: this.instanceid[index],
                //         PASLAUGOS_TIPAS2: this.Visits[index].toggle_multiple[a]
                //     })
                // }
                // ////////
                // // Posting available data to FullInformationCardIntervations datatable
                // var url_intervention = '/api/getVisitIntervention'
                // for (var b = 0; b < this.Visits[index].INTERVENCIJA_MODEL.length; b++) {
                //     axios.post(url_intervention, {
                //         fullvisitid: this.instanceid[index],
                //         ISLAIDOS_KONTR_BALAIS: this.Visits[index].INTERVENCIJA_MODEL[b].INTERVENCIJA_ISLAIDOS_KONTR_BALAIS,
                //         EIL_NR: time,
                //         SPECIALISTAS_SP: '-', //placeholder
                //         ACHI_KODAS: '-' //placeholder
                //     })
                // }
            },
            Edit(input) {
                var newInput = input + 1;
                var kortelesnr = LinksFunction(this.$route.query, 'korteles-nr');
                var url = '/api/getVizitai/' + this.instanceid.toString()
                axios.put(url, {
                    fullinfoid: this.FullInfoID,
                    APAP_ID: '',
                    APSILANKYMO_DATA: '',
                    SIUNTIMAS: '',
                    PASLAUGOS_KODAS: '',
                    PASLAUGOS_KODAS_TIKSL: 'suldu',
                    LIGOS_KODAS: '',
                    PASLAUGOS_TIPAS1: '',
                    SPECIALISTAS_SP: '',
                    KORTELES_NR: kortelesnr,
                    HIS_ID: '',
                    KAINA_BALAIS: '',
                    KAINA: '',
                    VALIUTA: '',
                    MOKAMA_IS_PSDF: '',
                    EIL_NR: newInput,
                    EIL_NR_UI: '',
                }).then(response => {
                });

            },
            CheckNewInstance(input) {
                var kortelesnr = LinksFunction(this.$route.query, 'korteles-nr');
                axios.get('/api/getVizitai', {
                    params: {
                        fullinfoid: this.FullInfoID,
                        KORTELES_NR: kortelesnr
                    }
                }).then(response => {
                    var temp = response.data
                    this.instanceid = temp[0].id;
                    return this.instanceid;
                })
            },

            //creates a new element in INTERVENCIJA_MODEL array
            addIntervencijaModel(index) {
                var eil_nr = this.Visits[index].INTERVENCIJA_MODEL.length + 1
                this.Visits[index].INTERVENCIJA_MODEL.push({
                    INTERVENCIJA_ISLAIDOS_KONTR_BALAIS: '-',
                    INTERVENCIJA_EIL_NR: eil_nr
                })
                console.log('intervencijos eil nr: ' + eil_nr)
                this.setActiveIntervencija(eil_nr)

            },

            //random function for lab test
            labtest() {
                var text = 'LT. YELLOW';
                var text2 = 'YELLOW'
                var res = text2.split(/\s/).join('')
                console.log(res)
            },

            //notifications based on type and purpose
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
                if (purpose == 'deletefirst') {
                    this.$notification[type]({
                        message: 'Klaida',
                        description: 'Egzistuoja vizitas su šia diagnoze. Ištrinkite vizitą ir bandykite dar kartą'
                    })
                }

            },

            //creates a new element in PRIEMOKA_MODEL array
            addPriemokaModel(index) {
                let eil_nr = this.Visits[index].PRIEMOKA_MODEL.length + 1;
                this.Visits[index].PRIEMOKA_MODEL.push({
                    PRIEMOKA_EIL_NR: eil_nr,
                    PRIEMOKA_FINANSAVIMO_SALTINIS: '',
                    PRIEMOKA_MOKAMOS_PASLAUGOS: '-',
                    PRIEMOKA_MOKAMOS_PASLAUGOS_SKUBIOS: '-',
                    PRIEMOKA_MOKAMOS_PASLAUGOS_KITOS: '-',
                })
                this.setActivePriemoka(eil_nr)

            },

            moment, //required, do not delete

            //adds an empty visit to local array and to database. may need to change so it only adds to local to prevent errors
            addVisit(a) {
                var url = '/api/getVisits';
                var time = (this.Visits.length + 1).toString();
                var kortelesnr = LinksFunction(this.$route.query, 'korteles-nr');
                // Posting available data to FullInformationCardVisits datatable
                //!!!! ONLY POSTING LOCALLY, NOT USED ANYMORE
                // axios.post(url, {
                //     fullinfoid: this.FullInfoID,
                //     EIL_NR: time,
                //     APAP_ID: this.FullInfo.APAP_ID,
                //     APSILANKYMO_DATA: '-',
                //     SIUNTIMAS: '-',
                //     PASLAUGOS_KODAS: '-',
                //     MOKAMA_IS_PSDF: this.FullInfo.MOKETINA_IS_PSDF,
                //     VALIUTA: this.FullInfo.VALIUTA,
                //     PASLAUGOS_KODAS_TIKSL: '-',
                //     LIGOS_KODAS: '-',
                //     PASLAUGOS_TIPAS1: '-',
                //     SPECIALISTAS_SP: '-',
                //     KORTELES_NR: kortelesnr,
                //     HIS_ID: this.FullInfo.HIS_ID,
                //     KAINA_BALAIS: '-',
                //     KAINA: '-',
                //     VALIUTA: '-',
                //     MOKAMA_IS_PSDF: '-',
                //     EIL_NR_UI: time,
                // });
                this.$set(this.isDisabled, this.Visits.length, this.isDisabled[this.Visits.length] = true);
                this.Visits.push({
                    APAP_ID: this.FullInfo[0].APAP_ID,
                    APSILANKYMO_DATA: this.dateToday,
                    EIL_NR: time,
                    EIL_NR_UI: time,
                    HIS_ID: this.FullInfo[0].HIS_ID,
                    KAINA: '-',
                    KAINA_BALAIS: '-',
                    KORTELES_NR: this.FullInfo[0].KORTELES_NR,
                    LIGOS_KODAS: '-',
                    MOKAMA_IS_PSDF: this.FullInfo[0].MOKETINA_IS_PSDF,
                    PASLAUGOS_KODAS: '-',
                    PASLAUGOS_KODAS_TIKSL: '-',
                    PASLAUGOS_TIPAS1: '-',
                    RECORDCREATED: '-',
                    RECORDUPDATED: '-',
                    SIUNTIMAS: '-',
                    SPECIALISTAS_SP: '-',
                    VALIUTA: this.FullInfo[0].VALIUTA,
                    fullinfoid: this.FullInfoID,
                    Model: [{
                        name: '',
                        code: '',
                        title: '',
                        pasl_tipas: '',
                    }

                    ],
                    toggle_multiple: [],
                    INTERVENCIJA_MODEL: [],
                    PRIEMOKA_MODEL: [],
                    isDisabled: false,
                    isRedaguojama: true,
                    isNewVisit: true
                })
                this.setActiveVisitPanel(time);
                console.log(this.activeKey)
                // this.$set(this.isDisabled, time, this.isDisabled[time] = false);
                // this.$set(this.isRedaguojama, time, this.isRedaguojama[time] = true)
            },
            setActiveVisitPanel(EIL_NR) {
                this.activeKey = [(EIL_NR).toString()];
            }
        },
        beforeMount() {
            this.getFullInfo();
            this.GetDiagnosisHistory2();
            this.GetPatientInformation2();
            this.GetList();
            this.getFullInfoID();
            this.getSusijusioDokNr();
            this.getKortelesNr();
            this.getPaskirtis();
            this.getApSiuntimas();
            this.getApBrigada();
            this.getApButinoji();
            this.getApPSDF();
            this.getDraustumas();
            this.getAtidarymoData();
            this.getUzdarymoData();
            this.getAtsakingasAsmuo();



        },
        created() {


        },
        mounted() {
            // this.initialize();
            // this.getF025Diagnosis();
        },


    }


</script>

<style scoped>
    .loadingAnimation {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 40px;
    }

    .red {
        background-color: #00ffb8;
    }

    .ant-time-picker {
        width: 128px;
    }

    .no-icon >>> .ant-time-picker-icon {
        display: none;
    }


    .form-horizontal .form-group {
        margin-bottom: 5px;
    }

    .is-disabled {
        opacity: .5;
        pointer-events: none;
    }
    >>>.v-text-field--outlined {
        min-height: 40px;
    }

    >>>.v-text-field--outlined>.v-input__control>.v-input__slot {
        min-height: 40px;
    }

    >>>.v-application--wrap {
        min-height: auto;
        /*background: #ECF0F5!important;*/
    }

    >>>.v-dialog:not(.v-dialog--fulscreen) {
        margin-top:0px;
    }
    >>> .theme--light>.v-application {
        background: none !important;
    }


</style>
<style>
    .multiselect__content-wrapper {
        position: relative;
        z-index: 100;
    }

    .multiselect__tag, .multiselect__option--highlight, .multiselect__tag-icon:hover {
        background: #1890ff;
    }

    .v-application--wrap {
        min-height: auto;
        /*background: white;*/
    }

    .v-btn:not(.v-btn--round).v-size--large {
        min-width: 20px;
    }

    .v-dialog:not(.v-dialog--fulscreen) {
        width: auto;
    }

    .ant-notification, .ant-notification-topRight {
        z-index: 10000;
    }
    .theme--light.v-application {
        background: none !important;
    }
</style>
