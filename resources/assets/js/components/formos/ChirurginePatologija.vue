<template>
    <v-app>

        <div class="box">
            <div class="box-body">
                <a-tabs>
                    <a-tab-pane tab="Bendra informacija" key="1">
                        <v-textarea
                            outlined
                            name="input-7-4"
                            label="Nusiskundimai"
                            value=""
                            class="col-md-6"
                        ></v-textarea>
                        <v-textarea
                            outlined
                            name="input-7-4"
                            label="Anamnezė"
                            value=""
                            class="col-md-6"
                        ></v-textarea>
                        <div class="col-md-12" style="border-width: 1px; border-style: dotted;">
                        <div class="col-md-6">
                        <v-checkbox
                            :label="`GMP`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`Siųstas ASPĮ`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`Pats`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`Kita`"
                            class="col-md-3"
                        ></v-checkbox>

                            <v-checkbox
                                :label="`Policija informuota`"
                                class="col-md-6"
                            ></v-checkbox>
                            <v-checkbox
                                :label="`Kraujas alkoholio tyrimui`"
                                class="col-md-6"
                            ></v-checkbox>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-2" style="margin-top:20px;">Alergija</label>
                            <v-checkbox
                                :label="`nėra`"
                                class="col-md-2"
                            ></v-checkbox>
                            <v-checkbox
                                v-model="alergija"
                                :label="`yra`"
                                class="col-md-2"
                            ></v-checkbox>
                            <v-text-field
                                v-if="alergija"
                                label="(įrašyti)"
                                outlined
                                class="col-md-12"
                            ></v-text-field>
                            <v-text-field
                                label="Vartojami medikamentai:"
                                outlined
                                class="col-md-12"
                                style=""
                            ></v-text-field>
                            <v-text-field
                                label="Persirgtos ir gretutinės ligos:"
                                outlined
                                class="col-md-12"
                                style=""
                            ></v-text-field>
                            <label class="col-md-2" style="margin-top:20px;">Nėštumas</label>
                            <v-checkbox
                                :label="`taip`"
                                class="col-md-2"
                            ></v-checkbox>
                            <v-checkbox
                                :label="`ne`"
                                class="col-md-2"
                            ></v-checkbox>
                        </div>
                        </div>
                    </a-tab-pane>


                    <a-tab-pane tab="Dabartinė būklė" key="2">

                    <div class="col-md-6">
                        <label class="col-md-12" style="margin-top:20px;">Bendra būklė</label>
                        <v-checkbox
                            :label="`patenkinama`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`vid. sunkumo`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`sunki`"
                            class="col-md-3"
                        ></v-checkbox>
                        <v-checkbox
                            :label="`labai sunki`"
                            class="col-md-3"
                        ></v-checkbox>
                    </div>
                    </a-tab-pane>


                </a-tabs>
            </div>
        </div>

    </v-app>
</template>

<script>
    export default {
        name: "ChirurginePatologija",
        data() {
            return {
                alergija: false,
            }
        }
    }
</script>

<style scoped>

</style>
