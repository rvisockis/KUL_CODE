<template>

    <div class="col-sm-12" >
        <div v-if="Loading" class="siuntimai_overlay">
            <a-icon slot="indicator" type="loading" style="font-size: 80px; position: absolute; left:50%; top:45%" spin class="loadingAnimation"/>
        </div>
        <div class="col-md-4 box box-body">
            <label> Asmens kodas</label>
            <v-text-field v-model="PersonalCode" v-on:keyup.enter="getIPRRegistracijos" placeholder="Įveskite a.k."></v-text-field>
            <a-button class="tarpas btn btn-info  pull-left" @click="getIPRRegistracijos">Ieškoti</a-button>
        </div>
        <div class="col-md-12 box box-body">
        <v-toolbar flat color="white">
            <v-toolbar-title>IPR tel. nr. paieška</v-toolbar-title>
            <v-spacer></v-spacer>
<!--            <v-text-field-->
<!--                class="col-md-3"-->
<!--                v-model="search"-->
<!--                append-icon="fas fa-search"-->
<!--                label="Paieška"-->
<!--                placeholder="Įveskite a.k., vardą arba pavardę."-->
<!--                single-line-->
<!--                hide-details-->
<!--            ></v-text-field>-->
        </v-toolbar>
        <v-data-table
            :headers="headers"
            :items="registracijos"
            class="elevation-1"
            :items-per-page-options=[15]
            :search="search"
        >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.vardas }}</td>
                <td class="text-xs-left">{{ props.item.pavarde }}</td>
                <td class="text-xs-left">{{ props.item.asmenskodas }}</td>
                <td class="text-xs-left">{{ props.item.telefonas}}</td>
                <td class="text-xs-left">{{ props.item.email}}</td>
            </template>

            <template v-slot:no-data>
                <v-alert :value="true">
                    <div style="color:black;">-</div>
                </v-alert>
            </template>
            <template v-slot:no-results>
                <v-alert :value="true">
                    <div style="color:black;">Nerasta "{{ search }}".</div>
                </v-alert>
            </template>
        </v-data-table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "IPRRegistracijos",
        data() {
            return {
                Loading: false,
                PersonalCode: '',
                registracijos: [],
                search: '',
                headers: [
                    {
                        text: 'Vardas',
                        align: 'left',
                        sortable: true,
                        value: 'vardas'
                    },
                    { text: 'Pavardė', value: 'pavarde' },
                    { text: 'Asmens kodas', value: 'asmenskodas' },
                    { text: 'Telefono nr.', align: 'left', sortable: true, value: 'telefonas'},
                    { text: 'El. paštas', align: 'left', sortable: true, value: 'email'},
                    { text: 'Sukūrimo data', align: 'left', sortable: true, value: 'sukurimodata'},
                ],
            }
        },
        methods: {
           async getIPRRegistracijos(){
                this.Loading = true;
                await axios.get('/api/getIPRRegistracijos', {params: {ak: this.PersonalCode}} )
                .then(response => {
                    this.registracijos = response.data
                    this.Loading = false;
                    console.log('atsakymas ipr: ' + JSON.stringify(response.data))
                })
            }
        },
        beforeMount() {
            // this.getIPRRegistracijos()
        }
    }
</script>

<style scoped>
    .siuntimai_overlay {
        position: fixed; /* Sit on top of the page content */
        /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: not-allowed; /* Add a pointer on hover */
    }
</style>
