<template>
    <div class="col-sm-12 box box-body" >
        <v-toolbar flat color="white">

            <v-toolbar-title>Telefonų knyga</v-toolbar-title>
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
            :headers="headers"
            :items="telefonu_knyga"
            class="elevation-1"
            :items-per-page-options=[15]
            :search="search"
        >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.DEPARTAMENTAS }}</td>
                <td class="text-xs-left">{{ props.item.SKYRIUS }}</td>
                <td class="text-xs-left">{{ props.item.PAREIGOS }}</td>
                <td class="text-xs-left">{{ props.item.ISORINIS_ILGAS}}</td>
                <td class="text-xs-left">{{ props.item.ISORINIS_TRUMPAS}}</td>
                <td class="text-xs-left">{{ props.item.VIDINIS}}</td>
                <td class="text-xs-left">{{ props.item.EMAIL}}</td>
            </template>

            <template v-slot:no-results>
                <v-alert :value="true" icon="warning">
                    <div style="color:black;">Nerasta "{{ search }}".</div>
                </v-alert>
            </template>
        </v-data-table>




    </div>
</template>

<script>
    export default {
        name: "Tel_knyga",
        data() {
            return {
                telefonu_knyga: [],
                search: '',
                headers: [
                    {
                        text: 'Departamentas',
                        align: 'left',
                        sortable: true,
                        value: 'DEPARTAMENTAS'
                    },
                    { text: 'Skyrius', value: 'SKYRIUS' },
                    { text: 'Pareigos', value: 'PAREIGOS' },
                    { text: 'Miesto nr.', align: 'left', sortable: true, value: 'ISORINIS_ILGAS'},
                    { text: 'Išorinis nr.', align: 'left', sortable: true, value: 'ISORINIS_TRUMPAS'},
                    { text: 'Vidinis nr.', value: 'VIDINIS', sortable: true },
                    { text: 'El. Paštas', value: 'EMAIL', sortable: true }
                ],
            }
        },
        methods: {
            getTelefonuKnyga(){
                axios.get('/api/getTelefonuNumeriai')
                .then(response => {
                    this.telefonu_knyga = response.data
                })
            }
        },
        beforeMount() {
            this.getTelefonuKnyga()
        }
    }
</script>

<style scoped>

</style>
