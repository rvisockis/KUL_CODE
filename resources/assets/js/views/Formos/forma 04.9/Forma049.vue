<template>
    <v-app>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <v-text-field
                        label="Asmens kodas"
                        v-model="personID"
                        class="col-md-6"
                    ></v-text-field>
                    <v-text-field
                        label="Paciento vardas, pavardė"
                        v-model="Name"
                        class="col-md-6"
                    ></v-text-field>
                    <div class="col-md-4">
                            <h4>Įvykdymo diena</h4>
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="date"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker :first-day-of-week="1" v-model="date" locale="lt" @input="menu = false" no-title scrollable>
                                    <div class="flex-grow-1"></div>
                                </v-date-picker>
                            </v-menu>
                    </div>
                    <v-container fluid class="col-md-4"  >
                            <h4>Pasirinkite lytį</h4>
                            <v-radio-group  v-model="gender" :mandatory="true" :column="false">
                                <v-radio label="Vyras"  value="radio-1"></v-radio>
                                <v-radio label="Moteris" value="radio-2"></v-radio>
                            </v-radio-group>
                        </v-container>
                    <div class="col-md-4">
                    <v-text-field
                        label="Svoris"
                        v-model="weight"
                        class="col-md-6"
                    ></v-text-field>
                    <v-text-field
                        label="Ūgis"
                        v-model="height"
                        class="col-md-6"
                    ></v-text-field>
                    </div>
                </div>

            </div>
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
                <a-tabs>
                    <a-tab-pane key="1" tab="Skausmingi sąnariai">
                        <div class="container col-md-12" style="margin-top:-20px;">
                            <h4 style="text-align:center; margin-top:20px;">Skausmo vietos</h4>
                            {{SkausmingosKunoDalys}}
                            <div
                                style="margin-left:auto; margin-right:auto; margin-top:-40px;position:relative; height:462px; width:312px; background:url(https://i.ibb.co/42N6GFR/zmogus.png) 0 0 no-repeat;">
                                <a style="position:absolute; top:122.00001525878906px; left:179.99999237060547px; width:10px; height:10px;"
                                   title="petys_desine" alt="" v-bind:class="[SkausmingosKunoDalys[0].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[0].name)"></a>
                                <a
                                    style="position:absolute; top:122.00000476837158px; left:168.99687957763672px; width:10px; height:10px;"
                                    title="petys_desine2" v-bind:class="[SkausmingosKunoDalys[1].state ? 'human_button_selected' : 'human_button']" alt="" @click="HumanHurts(SkausmingosKunoDalys[1].name)"></a><a
                                style="position:absolute; top:103px; left:158.99687957763672px; width:10px; height:10px;" v-bind:class="[SkausmingosKunoDalys[6].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[6].name)" title="TRECIAS" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[5].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[5].name)" style="position:absolute; top:103px; left:138px; width:10px; height:10px;" title="KETVIRTAS" class="human_button" alt=""></a><a
                                style="position:absolute; top:116.00000381469727px; left:150.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SkausmingosKunoDalys[2].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[2].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:127.00000381469727px; left:156.98959350585938px; width:10px; height:10px;"
                                v-bind:class="[SkausmingosKunoDalys[3].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[3].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:127.00000381469727px; left:144.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SkausmingosKunoDalys[4].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[4].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:122.00000381469727px; left:120px; width:10px; height:10px;" title="" class="human_button"
                                v-bind:class="[SkausmingosKunoDalys[7].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[7].name)" alt="" ></a><a
                                style="position:absolute; top:121.00000381469727px; left:132.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SkausmingosKunoDalys[8].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[8].name)" title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[9].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[9].name)" style="position:absolute; top:166.00000381469727px; left:116px; width:13px; height:13px;" title="" class="human_button"
                                alt="" ></a><a
                                style="position:absolute; top:166.00000381469727px; left:181.00003051757812px; width:13px; height:12px;"
                                v-bind:class="[SkausmingosKunoDalys[10].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[10].name)" title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[11].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[11].name)" style="position:absolute; top:205.00001907348633px; left:98px; width:19px; height:18px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[12].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[12].name)" style="position:absolute; top:205.00001907348633px; left:193.00003051757812px; width:21px; height:18px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[14].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[14].name)" style="position:absolute; top:207.00001907348633px; left:136.00003051757812px; width:14px; height:14px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[13].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[13].name)" style="position:absolute; top:206.00001907348633px; left:159.98959350585938px; width:15px; height:15px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[16].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[16].name)" style="position:absolute; top:257.0000190734863px; left:139.00003051757812px; width:12px; height:13px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[45].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[45].name)" style="position:absolute; top:322.0000190734863px; left:160.98748779296875px; width:14px; height:13px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[53].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[53].name)" style="position:absolute; top:321.0000190734863px; left:136.00003051757812px; width:15px; height:15px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[15].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[15].name)" style="position:absolute; top:257.0000190734863px; left:157.98959350585938px; width:14px; height:13px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SkausmingosKunoDalys[46].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[46].name)" style="position:absolute; top:343.0000190734863px; left:160.98959350585938px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[54].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[54].name)" style="position:absolute; top:343.0000190734863px; left:140.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[55].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[55].name)" style="position:absolute; top:349.0000190734863px; left:117px; width:16px; height:16px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[47].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[47].name)" style="position:absolute; top:349.0000190734863px; left:176.00003051757812px; width:19px; height:16px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[56].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[56].name)" style="position:absolute; top:374.0000190734863px; left:117px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[57].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[57].name)" style="position:absolute; top:366.00001525878906px; left:106px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[58].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[58].name)" style="position:absolute; top:362.0000190734863px; left:100px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[59].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[59].name)" style="position:absolute; top:358.00001525878906px; left:92px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[60].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[60].name)" style="position:absolute; top:354.0000190734863px; left:87px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[48].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[48].name)" style="position:absolute; top:374.00001525878906px; left:184px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[49].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[49].name)" style="position:absolute; top:367.00001525878906px; left:194px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[50].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[50].name)" style="position:absolute; top:362.00001525878906px; left:201px; width:10px; height:10px;" title="" class="human_button"
                                alt=""></a><a
                                v-bind:class="[SkausmingosKunoDalys[51].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[51].name)" style="position:absolute; top:358.00001525878906px; left:208px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[52].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[52].name)" style="position:absolute; top:353.00001525878906px; left:215px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[17].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[17].name)" style="position:absolute; top:238.00001907348633px; left:235.00003051757812px; width:10px; height:21px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SkausmingosKunoDalys[31].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[31].name)" style="position:absolute; top:238.00001907348633px; left:63px; width:11px; height:21px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[32].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[32].name)" style="position:absolute; top:261.0000190734863px; left:42px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[44].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[44].name)" style="position:absolute; top:275.0000190734863px; left:64px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[41].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[41].name)" style="position:absolute; top:277.0000190734863px; left:76px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[38].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[38].name)" style="position:absolute; top:279.0000190734863px; left:88px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[35].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[35].name)" style="position:absolute; top:278.0000190734863px; left:99px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[43].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[43].name)" style="position:absolute; top:290.0000190734863px; left:58px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[40].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[40].name)" style="position:absolute; top:295.0000190734863px; left:74px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[37].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[37].name)" style="position:absolute; top:295.0000190734863px; left:89px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[34].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[34].name)" style="position:absolute; top:294.0000190734863px; left:102px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[42].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[42].name)" style="position:absolute; top:303.0000190734863px; left:53px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[39].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[39].name)" style="position:absolute; top:309.0000190734863px; left:72px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[36].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[36].name)" style="position:absolute; top:309.0000190734863px; left:89px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[33].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[33].name)" style="position:absolute; top:307.0000190734863px; left:101px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SkausmingosKunoDalys[18].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[18].name)" style="position:absolute; top:262.0000190734863px; left:257.0000305175781px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[30].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[30].name)" style="position:absolute; top:276.0000190734863px; left:236.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[27].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[27].name)" style="position:absolute; top:279.0000190734863px; left:224.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[24].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[24].name)" style="position:absolute; top:279.0000190734863px; left:212.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[21].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[21].name)" style="position:absolute; top:278.0000190734863px; left:200.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[29].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[29].name)" style="position:absolute; top:290.0000190734863px; left:243.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[26].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[26].name)" style="position:absolute; top:295.0000190734863px; left:226.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[23].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[23].name)" style="position:absolute; top:294.0000190734863px; left:211.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[20].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[20].name)" style="position:absolute; top:294.0000190734863px; left:199.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[28].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[28].name)" style="position:absolute; top:304.0000190734863px; left:246.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SkausmingosKunoDalys[25].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[25].name)" style="position:absolute; top:309.0000190734863px; left:227.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[22].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[22].name)" style="position:absolute; top:308.0000190734863px; left:211.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SkausmingosKunoDalys[19].state ? 'human_button_selected' : 'human_button']" @click="HumanHurts(SkausmingosKunoDalys[19].name)" style="position:absolute; top:307.0000190734863px; left:199.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a>
                            </div>
                            <div style="background-color:white; height: 100px; width:600px; border:2px; display:block; margin-top:-65px; position:relative;" >

                            </div>

                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Sitinę sąnariai">
                        <div class="container col-md-12" style="margin-top:-20px;">
                            <h4 style="text-align:center; margin-top:20px;">Sutinimo vietos</h4>
                            <div
                                style="margin-left:auto; margin-right:auto; margin-top:-40px;position:relative; height:462px; width:312px; background:url(https://i.ibb.co/42N6GFR/zmogus.png) 0 0 no-repeat;">
                                <a style="position:absolute; top:122.00001525878906px; left:179.99999237060547px; width:10px; height:10px;"
                                   title="petys_desine" alt="" v-bind:class="[SutinusiosKunoDalys[0].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[0].name)"></a>
                                <a
                                    style="position:absolute; top:122.00000476837158px; left:168.99687957763672px; width:10px; height:10px;"
                                    title="petys_desine2" v-bind:class="[SutinusiosKunoDalys[1].state ? 'human_button_selected' : 'human_button']" alt="" @click="swollen_click(SutinusiosKunoDalys[1].name)"></a><a
                                style="position:absolute; top:103px; left:158.99687957763672px; width:10px; height:10px;" v-bind:class="[SutinusiosKunoDalys[6].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[6].name)" title="TRECIAS" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[5].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[5].name)" style="position:absolute; top:103px; left:138px; width:10px; height:10px;" title="KETVIRTAS" class="human_button" alt=""></a><a
                                style="position:absolute; top:116.00000381469727px; left:150.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SutinusiosKunoDalys[2].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[2].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:127.00000381469727px; left:156.98959350585938px; width:10px; height:10px;"
                                v-bind:class="[SutinusiosKunoDalys[3].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[3].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:127.00000381469727px; left:144.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SutinusiosKunoDalys[4].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[4].name)" title="" class="human_button" alt="" ></a><a
                                style="position:absolute; top:122.00000381469727px; left:120px; width:10px; height:10px;" title="" class="human_button"
                                v-bind:class="[SutinusiosKunoDalys[7].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[7].name)" alt="" ></a><a
                                style="position:absolute; top:121.00000381469727px; left:132.00003051757812px; width:10px; height:10px;"
                                v-bind:class="[SutinusiosKunoDalys[8].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[8].name)" title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[9].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[9].name)" style="position:absolute; top:166.00000381469727px; left:116px; width:13px; height:13px;" title="" class="human_button"
                                alt="" ></a><a
                                style="position:absolute; top:166.00000381469727px; left:181.00003051757812px; width:13px; height:12px;"
                                v-bind:class="[SutinusiosKunoDalys[10].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[10].name)" title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[11].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[11].name)" style="position:absolute; top:205.00001907348633px; left:98px; width:19px; height:18px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[12].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[12].name)" style="position:absolute; top:205.00001907348633px; left:193.00003051757812px; width:21px; height:18px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[14].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[14].name)" style="position:absolute; top:207.00001907348633px; left:136.00003051757812px; width:14px; height:14px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[13].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[13].name)" style="position:absolute; top:206.00001907348633px; left:159.98959350585938px; width:15px; height:15px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[16].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[16].name)" style="position:absolute; top:257.0000190734863px; left:139.00003051757812px; width:12px; height:13px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[45].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[45].name)" style="position:absolute; top:322.0000190734863px; left:160.98748779296875px; width:14px; height:13px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[53].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[53].name)" style="position:absolute; top:321.0000190734863px; left:136.00003051757812px; width:15px; height:15px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[15].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[15].name)" style="position:absolute; top:257.0000190734863px; left:157.98959350585938px; width:14px; height:13px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SutinusiosKunoDalys[46].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[46].name)" style="position:absolute; top:343.0000190734863px; left:160.98959350585938px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[54].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[54].name)" style="position:absolute; top:343.0000190734863px; left:140.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[55].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[55].name)" style="position:absolute; top:349.0000190734863px; left:117px; width:16px; height:16px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[47].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[47].name)" style="position:absolute; top:349.0000190734863px; left:176.00003051757812px; width:19px; height:16px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[56].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[56].name)" style="position:absolute; top:374.0000190734863px; left:117px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[57].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[57].name)" style="position:absolute; top:366.00001525878906px; left:106px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[58].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[58].name)" style="position:absolute; top:362.0000190734863px; left:100px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[59].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[59].name)" style="position:absolute; top:358.00001525878906px; left:92px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[60].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[60].name)" style="position:absolute; top:354.0000190734863px; left:87px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[48].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[48].name)" style="position:absolute; top:374.00001525878906px; left:184px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[49].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[49].name)" style="position:absolute; top:367.00001525878906px; left:194px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[50].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[50].name)" style="position:absolute; top:362.00001525878906px; left:201px; width:10px; height:10px;" title="" class="human_button"
                                alt=""></a><a
                                v-bind:class="[SutinusiosKunoDalys[51].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[51].name)" style="position:absolute; top:358.00001525878906px; left:208px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[52].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[52].name)" style="position:absolute; top:353.00001525878906px; left:215px; width:10px; height:10px;" title="" class="human_button"
                                alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[17].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[17].name)" style="position:absolute; top:238.00001907348633px; left:235.00003051757812px; width:10px; height:21px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SutinusiosKunoDalys[31].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[31].name)" style="position:absolute; top:238.00001907348633px; left:63px; width:11px; height:21px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[32].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[32].name)" style="position:absolute; top:261.0000190734863px; left:42px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[44].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[44].name)" style="position:absolute; top:275.0000190734863px; left:64px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[41].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[41].name)" style="position:absolute; top:277.0000190734863px; left:76px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[38].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[38].name)" style="position:absolute; top:279.0000190734863px; left:88px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[35].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[35].name)" style="position:absolute; top:278.0000190734863px; left:99px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[43].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[43].name)" style="position:absolute; top:290.0000190734863px; left:58px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[40].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[40].name)" style="position:absolute; top:295.0000190734863px; left:74px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[37].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[37].name)" style="position:absolute; top:295.0000190734863px; left:89px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[34].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[34].name)" style="position:absolute; top:294.0000190734863px; left:102px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[42].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[42].name)" style="position:absolute; top:303.0000190734863px; left:53px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[39].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[39].name)" style="position:absolute; top:309.0000190734863px; left:72px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[36].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[36].name)" style="position:absolute; top:309.0000190734863px; left:89px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[33].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[33].name)" style="position:absolute; top:307.0000190734863px; left:101px; width:10px; height:10px;" title="" class="human_button" alt=""
                            ></a><a
                                v-bind:class="[SutinusiosKunoDalys[18].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[18].name)" style="position:absolute; top:262.0000190734863px; left:257.0000305175781px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[30].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[30].name)" style="position:absolute; top:276.0000190734863px; left:236.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[27].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[27].name)" style="position:absolute; top:279.0000190734863px; left:224.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[24].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[24].name)" style="position:absolute; top:279.0000190734863px; left:212.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[21].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[21].name)" style="position:absolute; top:278.0000190734863px; left:200.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[29].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[29].name)" style="position:absolute; top:290.0000190734863px; left:243.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[26].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[26].name)" style="position:absolute; top:295.0000190734863px; left:226.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[23].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[23].name)" style="position:absolute; top:294.0000190734863px; left:211.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[20].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[20].name)" style="position:absolute; top:294.0000190734863px; left:199.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[28].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[28].name)" style="position:absolute; top:304.0000190734863px; left:246.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt=""></a><a
                                v-bind:class="[SutinusiosKunoDalys[25].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[25].name)" style="position:absolute; top:309.0000190734863px; left:227.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[22].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[22].name)" style="position:absolute; top:308.0000190734863px; left:211.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a><a
                                v-bind:class="[SutinusiosKunoDalys[19].state ? 'human_button_selected' : 'human_button']" @click="swollen_click(SutinusiosKunoDalys[19].name)" style="position:absolute; top:307.0000190734863px; left:199.00003051757812px; width:10px; height:10px;"
                                title="" class="human_button" alt="" ></a>
                            </div>
                            <div style="background-color:white; height: 100px; width:600px; border:2px; display:block; margin-top:-65px; position:relative;" >
                            </div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="3" tab="Baigiamoji informacija">
                        <p>Data, kada pradėtas dabartinis biologinis preparatas</p>
                        <v-menu
                            ref="preparatomeniu"
                            v-model="PreparatoMeniu"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="PreparatoData"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker :first-day-of-week="1" v-model="PreparatoData" locale="lt" @input="PreparatoMeniu = false" no-title scrollable>
                                <div class="flex-grow-1"></div>
                            </v-date-picker>
                        </v-menu>
                        <p> Klientas patikrintas sekimo laikotarpiu (intervalai mėnesiais)</p>
                        <v-radio-group  v-model="clicked" :mandatory="true" :column="false">
                        <v-radio v-for="items in timepased" :label="items.time" :value="items.time"  ></v-radio>
                        </v-radio-group>
                        <div v-if="clicked==='Kita'"  class="col-md-2">
                           <v-text-field
                               label="Kita"
                               v-model="other"
                           >
                           </v-text-field>
                        </div>
                        <p>Data, kada nutraukta biologinė terapija</p>
                        <v-menu
                            ref="preparatomeniu"
                            v-model="PreparatoNutraukimoMeniu"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="PreparatoNutraikimoData"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker :first-day-of-week="1" v-model="PreparatoNutraikimoData" locale="lt" @input="PreparatoNutraukimoMeniu = false" no-title scrollable>
                                <div class="flex-grow-1"></div>
                            </v-date-picker>
                        </v-menu>
                        <v-textarea
                            style="height:auto ;width:auto"
                            label="Komentarai"
                            v-model="Coments"
                        ></v-textarea>
                    </a-tab-pane>
                </a-tabs>
            </div>
            <div class="col-md-6 box box-body" style="border-style:outset;border-radius:10px;border-width:2px;">
                <a-tabs>
                    <a-tab-pane key="1" tab="Dabartinė ligos būklė">
                        <div class="col-md-12">
                                    <v-text-field
                                        label="Paciento savijautos globalinis vertinimas(mm)"
                                        v-model="PacientoSavijauta"
                                        class="col-md-6"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="Paciento skausmo vertinimas (mm)"
                                        v-model="PacientoSkausmas"
                                        class="col-md-6"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="HAQ"
                                        v-model="HAQ"
                                        class="col-md-2"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="ENG"
                                        v-model="ENG"
                                        class="col-md-2"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="CRB"
                                        v-model="CRB"
                                        class="col-md-2"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="Sutinę sąnariai"
                                        v-model="SutineSanariai"
                                        class="col-md-3"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="Skausmingi sąnariai"
                                        v-model="SkausmingiSanariai"
                                        class="col-md-4"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="Sutinę sąnariai 28"
                                        class="col-md-4"
                                        v-model="SutineSanariai28"
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        label="Skausmingi sąnariai 28"
                                        v-model="SkausmingiSanariai28"
                                        class="col-md-3"
                                    >
                                    </v-text-field>
                        </div>
                        <div class="col-md-12">
                            <p>Diagnozė(TLK-10)</p>
                            <multiselect v-model="Diagnosis"  label="code" track-by="code" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="DiagnosisList" :multiple="false" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false"   @search-change="GetList" >
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
<!--                      nuo cia  -->
<!---->
                        <div class="col-md-12">
                            <v-menu
                                ref="menu"
                                v-model="yearmeniu"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="yeardate"
                                        label="Diagnozės nustatymo metai"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="yeardate"
                                    type="month"
                                    no-title
                                    scrollable
                                >
                                </v-date-picker>
                            </v-menu>
                        </div>

<!--                      iki cia  -->
<!---->

                        <div class="col-md-6">
                            <p>Radiologineės erozijos</p>
                            <v-radio-group  v-model="RadiologinesErozijos" :mandatory="true" :column="false">
                                <v-radio  label="Taip" value="Taip"  ></v-radio>
                                <v-radio  label="Ne" value="Ne"  ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Sakroileitas</p>
                            <v-radio-group  v-model="Sakroileitas" :mandatory="true" :column="false">
                                <v-radio  label="Taip , jei taip, laipsnis: " value="Taip"  ></v-radio>
                                <v-radio  label="Ne" value="Ne"  ></v-radio>
                            </v-radio-group>

                        </div>
                        <div class="col-md-6" v-if="Sakroileitas==='Taip'">
                            <v-text-field
                                label="(dx)"
                                v-model="dx"
                                class="col-md-6"
                            >
                            </v-text-field>
                            <v-text-field
                                label="(sin)"
                                v-model="sin"
                                class="col-md-6"
                            >
                            </v-text-field>
                        </div>
                        <div class="col-md-6">
                            <p>RF</p>
                            <v-radio-group  v-model="RF" :mandatory="true" :column="false">
                                <v-radio  label="Seropozitivi liga" value="Seropozitivi liga"  ></v-radio>
                                <v-radio  label="Seronegativi liga" value="Seronegativi liga"  ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>Anti-CCP</p>
                            <v-radio-group  v-model="AntiCCP" :mandatory="true" :column="false">
                                <v-radio  label="Taip" value="Taip"  ></v-radio>
                                <v-radio  label="Ne" value="Ne"  ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-6">
                            <p>ŽLA-B27</p>
                            <v-radio-group  v-model="ZLAB27" :mandatory="true" :column="false">
                                <v-radio  label="Taip" value="Taip"  ></v-radio>
                                <v-radio  label="Ne" value="Ne"  ></v-radio>
                            </v-radio-group>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Pacientui skirti vaistai">
                        <div class="col-md-12">
                            <v-text-field
                            v-model="BiologinisVaistas"
                            label="Biologinis vaistas"
                            >
                            </v-text-field>
                        </div>
                        <div class="col-md-6" v-if="BiologinisVaistas.length>0">
                            <v-text-field
                                v-model="BiologinisVaistasVaistas"
                                label="Vaistas"
                            >
                            </v-text-field>
                        </div>
                        <div class="col-md-6" v-if="BiologinisVaistas.length>0">
                            <v-text-field
                                v-model="BiologinisVaistasDozavimas"
                                label="Dozavimas"
                            >
                            </v-text-field>
                        </div>
                            <div class="col-md-12">
                                <v-checkbox v-model="BiologinePakeista" label="Ar biologinė terapija buvo pakeista ar modifikuota"></v-checkbox>
                            </div>
                            <div class="col-md-6" v-if="BiologinePakeista" >
                                <p>Pakeista: </p>
                                <v-radio-group v-model="BiologineTerapijaPakeista">
                                    <v-radio v-for="item in BiologinePakeitimuSarasas " :label="item" :value="item"></v-radio>
                                </v-radio-group>
                            </div>
                        <div class="col-md-6" v-if="BiologinePakeista" >
                            <p>Priežastis: </p>
                            <v-radio-group v-model="BiologineTerapijaPakeistaPriezastis">
                                <v-radio v-for="item in BiologinePakeitimuSarasasPriezastis " :label="item" :value="item"></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-md-12">

                        </div>
                    </a-tab-pane>
                </a-tabs>
            </div>
        </div>
    </v-app>
</template>

<script>
    import V2Datepicker from 'v2-datepicker';
    import locals from 'v2-datepicker/lib/locals.js';
    export default {
        name: "Forma049",
        data() {
            return {
                BiologinisVaistas:[],
                BiologinisVaistasVaistas:[],
                BiologinisVaistasDozavimas:[],
                BiologinePakeista:false,
                BiologineTerapijaPakeista:[],
                BiologineTerapijaPakeistaPriezastis:[],
                BiologinePakeitimuSarasas:['Nuotrauka','Pauzė','Dozės pakeitimas','Perėjimas prie kito vaisto','Kita'],
                BiologinePakeitimuSarasasPriezastis:['Nepageidaujama reakcija','Nepakankamas efektas','Remisija','Kita'],
                dx:[],
                sin:[],
                RadioCheck:['Reguliariai','Pagal reikalą','Nevartoja'],
                NSVNU:[],
                Analgetikai:[],
                yearmeniu:false,
                yeardate:new Date().toISOString().substr(0, 7),
                // Selected
                PacientoSavijauta:[],
                PacientoSkausmas:[],
                HAQ:[],
                ENG:[],
                CRB:[],
                SutineSanariai:[],
                SkausmingiSanariai:[],
                SutineSanariai28:[],
                SkausmingiSanariai28:[],
                Diagnosis:[],
                DiagnosisList:[],
                RadiologinesErozijos:[],
                Sakroileitas:[],
                DiagnozesMetai:[],
                RF:[],
                AntiCCP:[],
                ZLAB27:[],
                Coments:[],
                PreparatoData: new Date().toISOString().substr(0, 10),
                PreparatoMeniu:false,
                PreparatoNutraikimoData: new Date().toISOString().substr(0, 10),
                PreparatoNutraukimoMeniu:false,
                other:'',
                personID:[],
                gender:[],
                Name:[],
                swollen_selected:[],
                date: new Date().toISOString().substr(0, 10),
                menu:false,
                time:[],
                weight:[],
                height:[],
                clicked:[],
                timepased:[
                    {state: false, time:'0'},
                    {state: false, time:'3'},
                    {state: false, time:'6'},
                    {state: false, time:'12'},
                    {state: false, time:'18'},
                    {state: false, time:'24'},
                    {state: false, time:'30'},
                    {state: false, time:'36'},
                    {state: false, time:'42'},
                    {state: false, time:'48'},
                    {state: false, time:'Kita'},
],
                lang: 'lt',
                Hurt_body_Select: [],
                locals,
                bukle: ['gera', 'patenkinama', 'vidutinė', 'sunki'],
                SkausmingosKunoDalys: [
                    {

                        state: false,
                        name: 'desinys_petys'
                    },
                    {
                        state: false,
                        name: 'desinys_petys_2'
                    },
                    {
                        state: false,
                        name: 'kaklas_vidurys'
                    },
                    {
                        state: false,
                        name: 'kaklas_desine'
                    },
                    {
                        state: false,
                        name: 'kaklas_kaire'
                    },
                    {
                        state: false,
                        name: 'zandas_desine'
                    },
                    {
                        state: false,
                        name: 'zandas_kaire'
                    },
                    {
                        state: false,
                        name: 'petys_kaire'
                    },
                    {
                        state: false,
                        name: 'petys_kaire_2'
                    },
                    {
                        //9
                        state: false,
                        name: 'alkune_desine'
                    },
                    {
                        state: false,
                        name: 'alkune_kaire'
                    },
                    {
                        state: false,
                        name: 'riesas_desine'
                    },
                    {
                        state: false,
                        name: 'riesas_kaire'
                    },
                    {
                        state: false,
                        name: 'klubas_kaire'
                    },
                    {
                        //14
                        state: false,
                        name: 'klubas_desine'
                    },
                    {
                        //15
                        state: false,
                        name: 'kelenas_kaire'
                    },
                    {
                        //16
                        state: false,
                        name: 'kelenas_desine'
                    },
                    {
                        /////////////////////////
                        //17
                        state: false,
                        name: 'pirstas_nykstys_kaire_krumplis'
                    },
                    {
                        //18
                        state: false,
                        name: 'pirstas_nykstys_kaire_galas'
                    },

                    {
                        //19
                        state: false,
                        name: 'pirstas_mazasis_kaire_galas'
                    },
                    {
                        //20
                        state: false,
                        name: 'pirstas_mazasis_kaire_vidurys'
                    },
                    {
                        //21
                        state: false,
                        name: 'pirstas_mazasis_kaire_krumplis'
                    },
                    {
                        //22
                        state: false,
                        name: 'pirstas_bevardis_kaire_galas'
                    },
                    {
                        //23
                        state: false,
                        name: 'pirstas_bevardis_kaire_vidurys'
                    },
                    {
                        //24
                        state: false,
                        name: 'pirstas_bevardis_kaire_krumplis'
                    },
                    {
                        //25
                        state: false,
                        name: 'pirstas_didysis_kaire_galas'
                    },
                    {
                        //26
                        state: false,
                        name: 'pirstas_didysis_kaire_vidurys'
                    },
                    {
                        //27
                        state: false,
                        name: 'pirstas_didysis_kaire_krumplis'
                    },
                    {
                        //28
                        state: false,
                        name: 'pirstas_smilius_kaire_galas'
                    },
                    {
                        //29
                        state: false,
                        name: 'pirstas_smilius_kaire_vidurys'
                    },
                    {
                        //30
                        state: false,
                        name: 'pirstas_smilius_kaire_krumplis'
                    },
                    {
                        ////////////////////////
                        //31
                        state: false,
                        name: 'pirstas_nykstys_desine_krumplis'
                    },
                    {
                        //32
                        state: false,
                        name: 'pirstas_nykstys_desine_galas'
                    },

                    {
                        //33
                        state: false,
                        name: 'pirstas_mazasis_desine_galas'
                    },
                    {
                        //34
                        state: false,
                        name: 'pirstas_mazasis_desine_vidurys'
                    },
                    {
                        //35
                        state: false,
                        name: 'pirstas_mazasis_desine_krumplis'
                    },
                    {
                        //36
                        state: false,
                        name: 'pirstas_bevardis_desine_galas'
                    },
                    {
                        //37
                        state: false,
                        name: 'pirstas_bevardis_desine_vidurys'
                    },
                    {
                        //38
                        state: false,
                        name: 'pirstas_bevardis_desine_krumplis'
                    },
                    {
                        //39
                        state: false,
                        name: 'pirstas_didysis_desine_galas'
                    },
                    {
                        //40
                        state: false,
                        name: 'pirstas_didysis_desine_vidurys'
                    },
                    {
                        //41
                        state: false,
                        name: 'pirstas_didysis_desine_krumplis'
                    },
                    {
                        //42
                        state: false,
                        name: 'pirstas_smilius_desine_galas'
                    },
                    {
                        //43
                        state: false,
                        name: 'pirstas_smilius_desine_vidurys'
                    },
                    {
                        //44
                        state: false,
                        name: 'pirstas_smilius_desine_krumplis'
                    },
                    //////////////////////////////////////
                    {
                        //45
                        state: false,
                        name: 'peda_ciurna_kaire'
                    },
                    {
                        //46
                        state: false,
                        name: 'peda_kulnas_kaire'
                    },
                    {
                        //47
                        state: false,
                        name: 'peda_vidurys_kaire'
                    },
                    {
                        //48
                        state: false,
                        name: 'peda_nykstys_kaire'
                    },
                    {
                        //49
                        state: false,
                        name: 'peda_pirstas4_kaire'
                    },
                    {
                        //50
                        state: false,
                        name: 'peda_pirstas3_kaire'
                    },
                    {
                        //51
                        state: false,
                        name: 'peda_pirstas2_kaire'
                    },
                    {
                        //52
                        state: false,
                        name: 'peda_pirstas1_kaire'
                    },
                    /////////////////////////////////////
                    {
                        //53
                        state: false,
                        name: 'peda_ciurna_desine'
                    },
                    {
                        //54
                        state: false,
                        name: 'peda_kulnas_desine'
                    },
                    {
                        //55
                        state: false,
                        name: 'peda_vidurys_desine'
                    },
                    {
                        //56
                        state: false,
                        name: 'peda_nykstys_desine'
                    },
                    {
                        //57
                        state: false,
                        name: 'peda_pirstas4_desine'
                    },
                    {
                        //58
                        state: false,
                        name: 'peda_pirstas3_desine'
                    },
                    {
                        //59
                        state: false,
                        name: 'peda_pirstas2_desine'
                    },
                    {
                        //60
                        state: false,
                        name: 'peda_pirstas1_desine'
                    },

                ],
                SutinusiosKunoDalys: [
                    {

                        state: false,
                        name: 'desinys_petys'
                    },
                    {
                        state: false,
                        name: 'desinys_petys_2'
                    },
                    {
                        state: false,
                        name: 'kaklas_vidurys'
                    },
                    {
                        state: false,
                        name: 'kaklas_desine'
                    },
                    {
                        state: false,
                        name: 'kaklas_kaire'
                    },
                    {
                        state: false,
                        name: 'zandas_desine'
                    },
                    {
                        state: false,
                        name: 'zandas_kaire'
                    },
                    {
                        state: false,
                        name: 'petys_kaire'
                    },
                    {
                        state: false,
                        name: 'petys_kaire_2'
                    },
                    {
                        //9
                        state: false,
                        name: 'alkune_desine'
                    },
                    {
                        state: false,
                        name: 'alkune_kaire'
                    },
                    {
                        state: false,
                        name: 'riesas_desine'
                    },
                    {
                        state: false,
                        name: 'riesas_kaire'
                    },
                    {
                        state: false,
                        name: 'klubas_kaire'
                    },
                    {
                        //14
                        state: false,
                        name: 'klubas_desine'
                    },
                    {
                        //15
                        state: false,
                        name: 'kelenas_kaire'
                    },
                    {
                        //16
                        state: false,
                        name: 'kelenas_desine'
                    },
                    {
                        /////////////////////////
                        //17
                        state: false,
                        name: 'pirstas_nykstys_kaire_krumplis'
                    },
                    {
                        //18
                        state: false,
                        name: 'pirstas_nykstys_kaire_galas'
                    },

                    {
                        //19
                        state: false,
                        name: 'pirstas_mazasis_kaire_galas'
                    },
                    {
                        //20
                        state: false,
                        name: 'pirstas_mazasis_kaire_vidurys'
                    },
                    {
                        //21
                        state: false,
                        name: 'pirstas_mazasis_kaire_krumplis'
                    },
                    {
                        //22
                        state: false,
                        name: 'pirstas_bevardis_kaire_galas'
                    },
                    {
                        //23
                        state: false,
                        name: 'pirstas_bevardis_kaire_vidurys'
                    },
                    {
                        //24
                        state: false,
                        name: 'pirstas_bevardis_kaire_krumplis'
                    },
                    {
                        //25
                        state: false,
                        name: 'pirstas_didysis_kaire_galas'
                    },
                    {
                        //26
                        state: false,
                        name: 'pirstas_didysis_kaire_vidurys'
                    },
                    {
                        //27
                        state: false,
                        name: 'pirstas_didysis_kaire_krumplis'
                    },
                    {
                        //28
                        state: false,
                        name: 'pirstas_smilius_kaire_galas'
                    },
                    {
                        //29
                        state: false,
                        name: 'pirstas_smilius_kaire_vidurys'
                    },
                    {
                        //30
                        state: false,
                        name: 'pirstas_smilius_kaire_krumplis'
                    },
                    {
                        ////////////////////////
                        //31
                        state: false,
                        name: 'pirstas_nykstys_desine_krumplis'
                    },
                    {
                        //32
                        state: false,
                        name: 'pirstas_nykstys_desine_galas'
                    },

                    {
                        //33
                        state: false,
                        name: 'pirstas_mazasis_desine_galas'
                    },
                    {
                        //34
                        state: false,
                        name: 'pirstas_mazasis_desine_vidurys'
                    },
                    {
                        //35
                        state: false,
                        name: 'pirstas_mazasis_desine_krumplis'
                    },
                    {
                        //36
                        state: false,
                        name: 'pirstas_bevardis_desine_galas'
                    },
                    {
                        //37
                        state: false,
                        name: 'pirstas_bevardis_desine_vidurys'
                    },
                    {
                        //38
                        state: false,
                        name: 'pirstas_bevardis_desine_krumplis'
                    },
                    {
                        //39
                        state: false,
                        name: 'pirstas_didysis_desine_galas'
                    },
                    {
                        //40
                        state: false,
                        name: 'pirstas_didysis_desine_vidurys'
                    },
                    {
                        //41
                        state: false,
                        name: 'pirstas_didysis_desine_krumplis'
                    },
                    {
                        //42
                        state: false,
                        name: 'pirstas_smilius_desine_galas'
                    },
                    {
                        //43
                        state: false,
                        name: 'pirstas_smilius_desine_vidurys'
                    },
                    {
                        //44
                        state: false,
                        name: 'pirstas_smilius_desine_krumplis'
                    },
                    //////////////////////////////////////
                    {
                        //45
                        state: false,
                        name: 'peda_ciurna_kaire'
                    },
                    {
                        //46
                        state: false,
                        name: 'peda_kulnas_kaire'
                    },
                    {
                        //47
                        state: false,
                        name: 'peda_vidurys_kaire'
                    },
                    {
                        //48
                        state: false,
                        name: 'peda_nykstys_kaire'
                    },
                    {
                        //49
                        state: false,
                        name: 'peda_pirstas4_kaire'
                    },
                    {
                        //50
                        state: false,
                        name: 'peda_pirstas3_kaire'
                    },
                    {
                        //51
                        state: false,
                        name: 'peda_pirstas2_kaire'
                    },
                    {
                        //52
                        state: false,
                        name: 'peda_pirstas1_kaire'
                    },
                    /////////////////////////////////////
                    {
                        //53
                        state: false,
                        name: 'peda_ciurna_desine'
                    },
                    {
                        //54
                        state: false,
                        name: 'peda_kulnas_desine'
                    },
                    {
                        //55
                        state: false,
                        name: 'peda_vidurys_desine'
                    },
                    {
                        //56
                        state: false,
                        name: 'peda_nykstys_desine'
                    },
                    {
                        //57
                        state: false,
                        name: 'peda_pirstas4_desine'
                    },
                    {
                        //58
                        state: false,
                        name: 'peda_pirstas3_desine'
                    },
                    {
                        //59
                        state: false,
                        name: 'peda_pirstas2_desine'
                    },
                    {
                        //60
                        state: false,
                        name: 'peda_pirstas1_desine'
                    },

                ],
                fakelist:[],
            }
        },
        methods: {
            GetList(query){
                this.DiagnosisList = [];
                if (query.length>2){
                    axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                        .then(response => {
                            this.fakelist = response.data;
                                for (var a =0 ; a<this.fakelist.length ; a++ ){
                                    this.DiagnosisList.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE})   ;
                                }
                            return  this.DiagnosisList;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }

            },
            test(){console.log(this.timepased)},
            HumanHurts(part) {
                for(let a = 0; a < this.SkausmingosKunoDalys.length; a++) {
                    if(part == this.SkausmingosKunoDalys[a].name) {
                        this.SkausmingosKunoDalys[a].state = !this.SkausmingosKunoDalys[a].state;
                        if(this.SkausmingosKunoDalys[a].state) {
                            this.Hurt_body_Select.push(this.SkausmingosKunoDalys[a].name)
                        } else {
                            let index = this.Hurt_body_Select.indexOf(this.SkausmingosKunoDalys[a].name)
                            this.Hurt_body_Select.splice(index, 1)
                        }
                        break;
                    }
                }
            },
            swollen_click(part) {
                for(let a = 0; a < this.SutinusiosKunoDalys.length; a++) {
                    if(part == this.SutinusiosKunoDalys[a].name) {
                        this.SutinusiosKunoDalys[a].state = !this.SutinusiosKunoDalys[a].state;
                        if(this.SutinusiosKunoDalys[a].state) {
                            this.swollen_selected.push(this.SutinusiosKunoDalys[a].name)
                        } else {
                            let index = this.swollen_selected.indexOf(this.SutinusiosKunoDalys[a].name)
                            this.swollen_selected.splice(index, 1)
                        }
                        break;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
