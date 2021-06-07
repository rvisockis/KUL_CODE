<template>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <a-tabs defaultActiveKey="1" tabPosition="left" :style="{ height: '300px'}">
                    <a-tab-pane tab="KRUTINE PILVAS" key="1">
                        <a-button-group v-for="(items, index) in KRUTINE_PILVAS_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedKrutine[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>

                    <a-tab-pane tab="GALVA" key="2">
                        <a-button-group v-for="(items, index, key) in GALVA_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedGalva[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>

                    <a-tab-pane tab="VIRSUTINES GALUNES" key="3">
                        <a-button-group v-for="(items, index) in VIRSUTINES_GALUNES_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedVirsutines[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>
                    <a-tab-pane tab="STUBURAS" key="4" >
                        <a-button-group v-for="(items, index) in STUBURAS_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedStuburas[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>
                    <a-tab-pane tab="DUBUO" key="5">
                        <a-button-group v-for="(items, index) in DUBUO_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedDubuo[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>
                    <a-tab-pane tab="APATINES GALUNES" key="6">
                        <a-button-group v-for="(items, index) in APATINES_GALUNES_BTNS">
                            <a-button @click="clicked_rentg(index, items.key)" v-bind:class="{active: isClickedApatines[index]}" style="margin:15px;" >{{items.name}}</a-button>
                        </a-button-group>
                    </a-tab-pane>
                </a-tabs>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Rentgenas",
        data() {
            return {
                isClickedKrutine: [],
                isClickedGalva: [],
                isClickedVirsutines: [],
                isClickedStuburas: [],
                isClickedDubuo: [],
                isClickedApatines: [],
                APATINES_GALUNES_BTNS: [
                    {
                        name: 'KELIS AP',
                        key: '6',
                    },
                    {
                        name: 'KELIS LAT',
                        key: '6',
                    },
                    {
                        name: 'CIURNA AP',
                        key: '6',
                    },
                    {
                        name: 'CIURNA LAT',
                        key: '6',
                    },
                    {
                        name: 'PEDA',
                        key: '6',
                    },
                ],
                DUBUO_BTNS: [
                    {
                        name: 'DUBUO',
                        key: '5',
                    },
                ],
                STUBURAS_BTNS: [
                    {
                        name: 'KAKLAS AP',
                        key: '4',
                    },
                    {
                        name: 'KAKLAS LAT',
                        key: '4',
                    },
                    {
                        name: 'THOROKALINIS AP',
                        key: '4',
                    },
                    {
                        name: 'THOROKALINIS LAT',
                        key: '4',
                    },
                    {
                        name: 'LIUMBALNIS AP',
                        key: '4',
                    },
                    {
                        name: 'LIUMBALNIS LAT',
                        key: '4',
                    },
                    {
                        name: 'UODEGIKAULIS',
                        key: '4',
                    },
                ],
                VIRSUTINES_GALUNES_BTNS: [
                    {
                        name: 'PETYS',
                        key: '3',
                    },
                    {
                        name: 'PETYS Y',
                        key: '3',
                    },
                    {
                        name: 'ALKUNE AP',
                        key: '3',
                    },
                    {
                        name: 'ALKUNE LAT',
                        key: '3',
                    },
                    {
                        name: 'PLASTAKA AP',
                        key: '3',
                    },
                    {
                        name: 'PLASTAKA LAT',
                        key: '3',
                    },
                    {
                        name: 'RIESAS AP',
                        key: '3',
                    },
                    {
                        name: 'RIESAS LAT',
                        key: '3',
                    },
                    {
                        name: 'PIRSTAI',
                        key: '3',
                    },
                ],
                GALVA_BTNS: [
                    {
                        name: 'KAUKOLE AP',
                        key: '2',
                    },
                    {
                        name: 'KAUKOLE PA',
                        key: '2',
                    },
                    {
                        name: 'KAUKOLE LAT L',
                        key: '2',
                    },
                    {
                        name: 'KAUKOLE LAT R',
                        key: '2',
                    },
                    {
                        name: 'NOSIS LAT L',
                        key: '2',
                    },
                    {
                        name: 'NOSIS LAT R',
                        key: '2',
                    },
                    {
                        name: 'VEIDO DAUBOS',
                        key: '2',
                    },
                ],
                KRUTINE_PILVAS_BTNS: [
                    {
                        name: 'PLAUCIAI PA',
                        key: '1',
                    },
                    {
                        name: 'PLAUCIAI LAT',
                        key: '1',
                    },
                    {
                        name: 'PLAUCIAI AP',
                        key: '1',
                    },
                    {
                        name: 'PLAUCIAI AP',
                        key: '1',
                    },
                    {
                        name: 'SONKAULIAI PA',
                        key: '1',
                    },
                    {
                        name: 'SONKAULIAI OBL',
                        key: '1',
                    },
                    {
                        name: 'KRUTINKAULIS LAT',
                        key: '1',
                    },
                    {
                        name: 'KRUTINKAULIS OBL',
                        key: '1',
                    },
                    {
                        name: 'PILVAS AP',
                        key: '1',
                    },
                    {
                        name: 'PILVAS LAT',
                        key: '1',
                    },
                ],
            }
        },
        methods: {
            clicked_rentg(index, key) {
                if(key == '1') {
                    this.$set(this.isClickedKrutine, index, !this.isClickedKrutine[index])
                } else if(key == '2') {
                    this.$set(this.isClickedGalva, index, !this.isClickedGalva[index])
                } else if(key == '3') {
                    this.$set(this.isClickedVirsutines, index, !this.isClickedVirsutines[index])
                } else if(key == '4') {
                    this.$set(this.isClickedStuburas, index, !this.isClickedStuburas[index])
                } else if(key == '5') {
                    this.$set(this.isClickedDubuo, index, !this.isClickedDubuo[index])
                } else if(key == '6') {
                    this.$set(this.isClickedApatines, index, !this.isClickedApatines[index])
                }
            },

        },
        beforeMount(){
            // this.KRUTINE_PILVAS_BTNS.forEach((item, index) => this.$set(this.isClickedRentg, index, false));
            // this.GALVA_BTNS.forEach((item, index) => this.$set(this.isClickedRentg, index, false))
        }

    }
</script>

<style scoped>

</style>