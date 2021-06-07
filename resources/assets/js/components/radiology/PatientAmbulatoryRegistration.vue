<template>
    <!--<div class="container">-->
        <div class="row">
            <div class="col-6 col-sm-5">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fas fa-x-ray"></i> <span>Radiologiniai tyrimai (išankstinės registracijos)</span></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-inline text-center">
                            <div class="form-group mb-2" :class="{ 'form-group--error': $v.dateValue.$error }">
                                <date-picker v-model="$v.dateValue.$model" :lang="lang" :first-day-of-week="1"></date-picker>
                            </div>
                            <div class="form-group mx-sm-3 mb-2" :class="{ 'form-group--error': $v.selected.$error }">
                                <select class="mx-input" v-model="$v.selected.$model">
                                    <option v-for="option in options" v-bind:value="option.ambValue">
                                        {{ option.text }}
                                    </option>
                                </select>
                            </div>
                            <button v-on:click="generatePdf()" type="button" class="btn btn-info" :disabled="submitStatus === 'PENDING'">GENERUOTI ATASKAITĄ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!--</div>-->
</template>
<script>
    import DatePicker from 'vue2-datepicker'
    import { required} from 'vuelidate/lib/validators'
    export default {
        components: {
            DatePicker
        },
        data() {
            return {
                name: this.$route.params.name,
                selected: null,
                submitStatus: null,
                options: [
                    { ambValue: null, text: 'Pasirinkite ambulatoriją' },
                    { ambValue: 'AMBUL3', text: 'Ambulatorija Nr. 2' },
                    { ambValue: 'AMBUL2', text: 'Ambulatorija Nr. 3' }
                ],
                source: '/api/genradpatientlistpdf',
                dateValue:'',
                lang: {
                    days: ['S','P', 'A', 'T', 'K', 'Pn', 'Š'],
                    months: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
                    pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                    placeholder: {
                        date: 'Pasirinkite datą',
                        dateRange: 'Pasirinkite datų intervalą'
                    }
                },

                // local: {
                //     hourTip: 'Select Hour', // tip of select hour
                //     minuteTip: 'Select Minute', // tip of select minute
                //     secondTip: 'Select Second', // tip of select second
                //     yearSuffix: '', // suffix of head year
                //     monthsHead: 'Sausis_Vasaris_Kovas_Balandis_Gegužė_Birželis_Liepa_Rugpjūtis_Rugsėjis_Spalis_Lapkritis_Gruodis'.split('_'), // months of head
                //     months: 'Sau_Vas_Kov_Bal_Geg_Birž_Lie_Rugp_Rugs_Spa_Lap_Gruo'.split('_'), // months of panel
                //     weeks: 'P_A_T_K_Pn_Š_S'.split('_'),
                //     cancelTip: 'cancel',
                //     submitTip: 'confirm'
                // },

                showFilter: false,
                model: {
                    data: []
                },
                params: {
                    column: 'ward_name',
                    direction: 'asc',
                    per_page: 25,
                    page: 1,
                    search_column: 'case_number',
                    search_operator: 'equal_to',
                    search_query_2: '',
                    searchableText:'',
                    validateMore14: true,
                },
                operators: {
                    equal_to: '=',
                    not_equal: '<>',
                    less_than: '<',
                    greater_than: '>',
                    less_than_or_equal_to: '<=',
                    greater_than_or_equal_to: '>=',
                    in: 'IN',
                    not_in: 'NOT IN',
                    like: 'LIKE',
                    between: 'BETWEEN'
                }
            }
        },
        validations: {
            selected: {
                required
            },
            dateValue: {
                required
            }
        },
        beforeMount() {

        },
        created() {

        },
        methods: {
            generatePdf() {
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                } else {
                    this.submitStatus = 'PENDING'
                    var dateFrom = moment(this.dateValue).format('YYYY-MM-DD')
                    var dateTo = moment(this.dateValue).add(1, 'days').format('YYYY-MM-DD')
                    var notAmb = this.selected;
                    axios
                        .get(this.source, {
                            params: {
                                dateGenerateFrom: dateFrom,
                                dateGenerateTo: dateTo,
                                selectedNotAmb: notAmb
                            },
                            responseType: 'blob'
                        })
                        .then(response => {
                            console.log(response)
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', dateFrom.toString() + '.pdf');
                            document.body.appendChild(link);
                            link.click();
                            this.submitStatus = 'OK'
                        })
                        .catch(error => {
                                console.log(error)
                            }
                        )
                }
            }
        }
    }
</script>
<style>
    .form-group--error {
        animation-name: shakeError;
        animation-duration: .6s;
        animation-timing-function: ease-in-out; }

    .form-group--error input,
    .form-group--error select{
        border-color: #f79483; }

    @keyframes shakeError {
        0% {
            transform: translateX(0); }
        15% {
            transform: translateX(0.375rem); }
        30% {
            transform: translateX(-0.375rem); }
        45% {
            transform: translateX(0.375rem); }
        60% {
            transform: translateX(-0.375rem); }
        75% {
            transform: translateX(0.375rem); }
        90% {
            transform: translateX(-0.375rem); }
        100% {
            transform: translateX(0); } }

</style>