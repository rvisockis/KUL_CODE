<template>
    <div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-2 mb-2">
                        <!--<i class="fa fa-plus-square fa-lg"></i>-->
                        <!--<h3 class="box-title"></h3>-->
                        <!--pavadinimas-->
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                               {{PickedMonthTxt}} {{PickedDayNumb}} dienos pacientai {{todayindicator}}
                            </h4>
                        </div>
                        <div class="col-md-12" id="laikinas">
<!--turinys-->
                            <a-button v-on:click="DecreaseByDay"><a-icon type="step-backward" /></a-button>
                            <v2-datepicker v-model="formattedDate" format="yyyy-MM-DD"  :lang="lang" :customLocals="locals" @change="OnCahnge"  ></v2-datepicker>
                            <a-button v-on:click="IncreaseByDay" ><a-icon type="step-forward" /></a-button>
                            <a-table :columns="columns" v-on:select="test()"  :dataSource="listinfo" bordered >
                                <template slot="name" slot-scope="text, record, index">
                                    <a  :href="'/israsas?personal-code='+ listinfo[index].PersonID +'&username='+listinfo[index].UserName+'&doctorID='+listinfo[index].ID+'&patient-first-name='+ listinfo[index].name">{{text}} </a>
                                </template>
                            </a-table>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
<!--                    apacia-->
<!--<a-button v-on:click="test">siaip</a-button>-->
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import {LinksFunction} from "../../components/ReadLinkInfo";
    import KulFunctioms from "../../Constants/KulFunctions"
    import axios from 'axios';
    import Option from "ant-design-vue/es/vc-select/Option";
    import 'v2-datepicker/lib/index.css';
    import V2Datepicker from 'v2-datepicker';
    import locals from "v2-datepicker/lib/locals.js";
    import moment from 'moment';
    Vue.use(V2Datepicker);

    export default {

        components: { Option },

        data(){
            return {
                foundedpostings:[],
                lang:'lt',
                locals,
                sendInfo : [],
                formattedDate:'',
                today:'',
                todayindicator:'(šiandien)',
                PickedMonthTxt:'',
                PickedDayNumb:'',
                ID:'',
                UserName:'',
                GotData:[],
                 columns : [{
                     title: 'Vizito laikas',
                     clasName:'visittime',
                     dataIndex: 'visittime',
                     scopedSlots: { customRender: 'name' },

                 },{
                    title: 'Vardas Pavardė',
                     className:'name',
                    dataIndex: 'name',

                }, {
                    title: 'Asmens Kodas',
                    className: 'PersonID',
                    dataIndex: 'PersonID',
                }, {
                     title: 'Ligos Kodas',
                     className: 'SicknessID',
                     dataIndex: 'SicknessID',
                 },{
                    title: 'Siunčiantis gydytojas',
                     className:'SendingDoctor',
                    dataIndex: 'SendingDoctor',
                },{
                     title: 'Siunčianti įstaiga',
                     className: 'SendingCompany',
                     dataIndex: 'SendingCompany',
                 }],
                daysPatientList:[],
                listinfo:[],
                Postings:[],
                next:'',
                processed:'',
                child:[],
                do:false,

            }
        },
        methods : {
            FirstFunction() {
                var myDate = new Date();
                var month = ('0' + (myDate.getMonth() + 1)).slice(-2);
                var date = ('0' + (myDate.getDate())).slice(-2);
                var year = myDate.getFullYear();
                this.formattedDate = year + '-' + month + '-' + date;
                this.today = this.formattedDate;
                var answer = KulFunctioms.CheckDay(this.formattedDate, this.today)
                this.todayindicator = answer[0].IsToday;
                this.PickedMonthTxt = answer[0].daytxt;
                this.PickedDayNumb = answer[0].Dayname;
                var ID = LinksFunction(this.$route.query, 'doctorID')
                this.UserName = LinksFunction(this.$route.query, 'username')
                this.processed = 0;
                axios.get('api/getDayPatient', {params: {doctorid: ID, data: this.formattedDate}}).then(response => {
                    var test = response.data;
                    this.Getinfo(test);
                })

            },
            IncreaseByDay() {
                this.formattedDate = moment(this.formattedDate).add(1, 'days');
                this.formattedDate = moment(this.formattedDate).format('YYYY-MM-DD');
                var answer = KulFunctioms.CheckDay(this.formattedDate, this.today)
                this.todayindicator = answer[0].IsToday;
                this.PickedMonthTxt = answer[0].daytxt;
                this.PickedDayNumb = answer[0].Dayname;
                var ID = LinksFunction(this.$route.query, 'doctorID');
                this.processed = 0;
                this.listinfo = [];
                axios.get('api/getDayPatient', {params: {doctorid: ID, data: this.formattedDate}}).then(response => {
                    var test = response.data;
                    this.daysPatientList = test
                    this.Getinfo(test);
                })

            },
            DecreaseByDay() {
                this.formattedDate = moment(this.formattedDate).subtract(1, 'days');
                this.formattedDate = moment(this.formattedDate).format('YYYY-MM-DD');
                moment(this.formattedDate, 'YYYY-MM-DD').format();
                var answer = KulFunctioms.CheckDay(this.formattedDate, this.today)
                this.todayindicator = answer[0].IsToday;
                this.PickedMonthTxt = answer[0].daytxt;
                this.PickedDayNumb = answer[0].Dayname;
                this.processed = 0;
                var ID = LinksFunction(this.$route.query, 'doctorID')
                this.listinfo = [];
                axios.get('api/getDayPatient', {params: {doctorid: ID, data: this.formattedDate}}).then(response => {
                    var test = response.data;
                    this.Getinfo(test);
                })

            },
            OnCahnge(ChangedDay) {
                this.formattedDate = moment(ChangedDay).format('YYYY-MM-DD');
                var answer = KulFunctioms.CheckDay(this.formattedDate, this.today)
                this.todayindicator = answer[0].IsToday;
                this.PickedMonthTxt = answer[0].daytxt;
                this.PickedDayNumb = answer[0].Dayname;
                this.processed = 0;
                var ID = LinksFunction(this.$route.query, 'doctorID');
                this.listinfo = [];
                axios.get('api/getDayPatient', {params: {doctorid: ID, data: this.formattedDate}}).then(response => {
                    var test = response.data;
                    this.Getinfo(test);

                })
            },
            Getinfo(input) {
                this.next = 1;
                this.Postings=[];
                this.processed = input.length;
                this.daysPatientList = input;
                for (var index2 = 0; index2 < this.daysPatientList.length; index2++) {
                     this.GetAxiosInfo(index2, this.daysPatientList[index2])
                }
            },
            GetAxiosInfo(index, input) {
                axios.get('/api/CheckPostings', {params: {PC: input.personalcode}})
                    .then(response => {
                        var temp= response.data;
                        if (temp.length>0){
                            for (var index=0;index<=temp.length-1;index++){
                                var a =temp[index].PERSON_CODE
                                this.foundedpostings.push(a)
                            }

                            this.Postings.push(response.data)
                        }
                        if (this.processed == this.next) {
                            this.Parsing();
                        } else {
                            this.next++;
                        }
                        return this.Postings
                    })
            },
            Parsing() {
                for (var index=0;index<this.daysPatientList.length;index++){
                    this.child=[];
                    var sk= this.daysPatientList[index].personalcode;
                    if (this.foundedpostings.indexOf(sk)>-1){
                        for (var index2=0;index2<this.Postings.length;index2++){
                                if (this.daysPatientList[index].personalcode==this.Postings[index2][0].PERSON_CODE){
                                    if (this.Postings[index2].length==1){
                                        //    jei vienas siuntimas
                                            this.listinfo.push({
                                                key: index,
                                                visittime: this.daysPatientList[index].visittime,
                                                name: this.daysPatientList[index].patientname,
                                                ID: LinksFunction(this.$route.query, 'doctorID'),
                                                UserName: LinksFunction(this.$route.query, 'username'),
                                                PersonID: this.daysPatientList[index].personalcode,
                                                SicknessID: this.Postings[index2][0].POSTING_DIAGNOSIS,
                                                SendingDoctor: this.Postings[index2][0].SENDING_DOCTOR,
                                                SendingCompany: this.Postings[index2][0].SENDING_COMPANY,
                                            })
                                    }else if(this.Postings[index2].length>1){
                                        //    jei daugiau negu vienas siuntimas
                                        for (var index3 = 1; index3<this.Postings[index2].length;index3++){
                                            if (this.Postings[index2][index3].PERSON_CODE==this.daysPatientList[index].personalcode){
                                                if ((index3<10)&&(index3!=0)){
                                                    var tempindex = (index+1)*10 +index3
                                                    this.child.push({
                                                        key: tempindex,
                                                        visittime: this.daysPatientList[index].visittime,
                                                        name: this.daysPatientList[index].patientname,
                                                        ID: LinksFunction(this.$route.query,'doctorID'),
                                                        UserName: LinksFunction(this.$route.query,'username'),
                                                        PersonID: this.daysPatientList[index].personalcode,
                                                        SicknessID:this.Postings[index2][index3].POSTING_DIAGNOSIS,
                                                        SendingDoctor:this.Postings[index2][index3].SENDING_DOCTOR,
                                                        SendingCompany:this.Postings[index2][index3].SENDING_COMPANY,
                                                    })
                                                }else if ((index3>10)&&(index3<999)){
                                                    var tempindex = (index+1)*100 +index3
                                                    this.child.push({
                                                        key: tempindex,
                                                        visittime: this.daysPatientList[index].visittime,
                                                        name: this.daysPatientList[index].patientname,
                                                        ID: LinksFunction(this.$route.query,'doctorID'),
                                                        PersonID: this.daysPatientList[index].personalcode,
                                                        UserName: LinksFunction(this.$route.query,'username'),
                                                        SicknessID:this.Postings[index2][index3].POSTING_DIAGNOSIS,
                                                        SendingDoctor:this.Postings[index2][index3].SENDING_DOCTOR,
                                                        SendingCompany:this.Postings[index2][index3].SENDING_COMPANY,
                                                    })
                                                }else if(index3<999){
                                                    var tempindex = (index+1)*1000 +index3
                                                    this.child.push({
                                                        key: tempindex,
                                                        visittime: this.daysPatientList[index].visittime,
                                                        name: this.daysPatientList[index].patientname,
                                                        ID: LinksFunction(this.$route.query,'doctorID'),
                                                        UserName: LinksFunction(this.$route.query,'username'),
                                                        PersonID: this.daysPatientList[index].personalcode,
                                                        SicknessID:this.Postings[index2][index3].POSTING_DIAGNOSIS,
                                                        SendingDoctor:this.Postings[index2][index3].SENDING_DOCTOR,
                                                        SendingCompany:this.Postings[index2][index3].SENDING_COMPANY,
                                                    })
                                                }
                                            }
                                        }
                                        this.listinfo.push({
                                            key: index,
                                            visittime: this.daysPatientList[index].visittime,
                                            name: this.daysPatientList[index].patientname,
                                            ID: LinksFunction(this.$route.query, 'doctorID'),
                                            UserName: LinksFunction(this.$route.query, 'username'),
                                            PersonID: this.daysPatientList[index].personalcode,
                                            SicknessID: this.Postings[index2][0].POSTING_DIAGNOSIS,
                                            SendingDoctor: this.Postings[index2][0].SENDING_DOCTOR,
                                            SendingCompany: this.Postings[index2][0].SENDING_COMPANY,
                                            children: this.child

                                        })
                                    }
                                }
                        }
                    }else{
                        //    jei nera siuntimu
                        this.listinfo.push({
                            key: index,
                            visittime: this.daysPatientList[index].visittime,
                            name: this.daysPatientList[index].patientname,
                            ID: LinksFunction(this.$route.query, 'doctorID'),
                            UserName: LinksFunction(this.$route.query, 'username'),
                            PersonID: this.daysPatientList[index].personalcode,
                            SicknessID: '-',
                            SendingDoctor: '-',
                            SendingCompany: '-',
                        })
                    }
                }
            },
        },
        beforeMount() {
            this.FirstFunction();
        },
        mounted() {
        },

    }

</script>
<style>
    th.column-money,
    td.column-money {
        text-align: right !important;
    }
</style>
