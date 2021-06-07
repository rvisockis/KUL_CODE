<template>
    <div>

<!--        asmens kodo ivedimo dalis-->
        <div class="col-md-12" >

            <div v-if="IsVisable && !IsLoaded" class="siuntimai_overlay">
                <a-icon slot="indicator" type="loading" style="font-size: 80px; position: absolute; left:50%; top:45%" spin class="loadingAnimation"/>
            </div>
            <div v-if="dialog" class="siuntimai_overlay">

            </div>
            <div class="col-md-3 ">
                <div class="box">
                    <div class="box-body">

                        <div class="col-md-12" id="laikinas">

                            <label> Asmens kodas</label>
                            <div class="text-center" >
                                <v-dialog v-model="dialog" width="500" style="margin-top: 0px!important;" >
                                    <template v-slot:activator="{on}">
                                        <v-text-field v-model="PersonalCode" v-on:keyup.enter="dialog = true"/>
                            <div class="col-md-12" v-if="IncorrectPersonalCode" style="color: red; font-style: italic;">Neteisingas asmens kodas.</div>
                            <a-button class="tarpas btn btn-info  pull-left" v-on="on">Gauti siuntimus</a-button>
                            </template>
                            <v-card >
                                <v-card-title
                                    class="headline grey lighten-2"
                                    primary-title
                                    style="font-size:18px;"
                                >
                                    Ar tikrai šis asmens kodas teisingas?
                                </v-card-title>
                                <v-card-text style="font-size:24px; margin-top:20px;">
                                    {{PersonalCode}}
                                </v-card-text>

                                <v-divider></v-divider>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <a-button type="primary" size="large" style="width:80px" v-on:click="dialog = false"  @click="Click">Taip</a-button>

                                    <a-button type="danger" size="large" style="margin-left:5px; width:80px;" @click="dialog = false">Ne</a-button>

                                </v-card-actions>
                            </v-card>
                                </v-dialog>
                        </div>

                    </div>
                </div>
            </div>

            </div>
            <div class="col-md-9" v-if="Founded">
                <div class="box">

                    <div class="box-body">
                      <h3>Paciento informacija</h3>
                        <v-text-field v-if="TableData.length" class="col-md-7" disabled outlined v-model="TableData[0].patientName" label="Vardas, pavardė"></v-text-field>
                        <v-text-field v-if="TableData.length" class="col-md-7" disabled outlined v-model="TableData[0].patientBirthday" label="Gimimo data"></v-text-field>

                    </div>
                </div>
            </div>
        </div>
<!--        informacijos pateikimo dalis-->
        <div v-if="IsVisable && IsLoaded" class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-2 mb-2">
                        <i class="fas fa-file-medical"></i>
                        <h3 class="box-title"> Siuntimai
                        </h3>
                </div>
                <div class="box-body">
                        <div class="spin-content">
                            <div class="col-md-12" v-if="IsLoaded">
                                <div class="col-md-12" v-if="Founded">
                                    <a-table :columns="columns" :dataSource="TableData" bordered >
                                        <template  slot="sendingDocument" slot-scope="record">
                                            <a :href="record" target="_blank">Siuntimo dokumentas</a>
                                        </template>
                                    </a-table>
                                </div>
                                <div v-else>
                                    <a-alert
                                            description="Nerasta aktyvių siuntimų"
                                            type="warning"
                                    />
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
<!--            Draustumas-->
<!--            <div class="box">-->
<!--                <div class="box-header">-->
<!--                    <div class="col-md-2 mb-2">-->
<!--                        <i class="fa fa-plus-square fa-lg"></i>-->
<!--                        <h3 class="box-title">-->
<!--                            Draustumas-->
<!--                        </h3>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="box-body">-->
<!--                    <a-spin :spinning="Issearching" tip="Ieškome">-->
<!--                        <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />-->
<!--                        <div class="spin-content">-->
<!--                            <div class="col-md-12" v-if="IsLoaded">-->
<!--                                <div class="col-md-12" v-if="Founded">-->

<!--                                </div>-->
<!--                                <div v-else>-->
<!--                                    <a-alert-->
<!--                                            description="Asmuo nerastas"-->
<!--                                            type="warning"-->
<!--                                    />-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </a-spin>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script>
    import ATextarea from "ant-design-vue/es/input/TextArea";
    import axios from'axios';

    export default {
        name: "GetPostings",
        components: {ATextarea},
        data(){
            return{
                dialog: false,
                IncorrectPersonalCode: false,
                PersonalCode:'',
                Issearching:true,
                IsVisable:false,
                Founded:false,
                IsLoaded:false,
                PatientName:'',
                columns : [
                //     {
                //     title: 'Ligos kodas',
                //     className:'SicknessCode',
                //     dataIndex: 'SicknessCode',
                //
                // },{
                //     title: 'Priežastis',
                //     className:'reason',
                //     dataIndex: 'reason',
                // },
                    {
                    title: 'Siunčianti įstaiga',
                    className: 'company',
                    dataIndex: 'company',
                }, {
                    title: 'Siunčiantis gydytojas',
                    className: 'sendingDoctor',
                    dataIndex: 'sendingDoctor',
                },{
                    title: 'Siuntimo data',
                    className:'sendingDate',
                    dataIndex: 'sendingDate',
                },
                    {
                        title: 'Siuntimas kam',
                        className:'sendingTarget',
                        dataIndex: 'sendingTarget',
                    },
                    {
                        title: 'Siuntimo dokumentas',
                        className: 'sendingDocument',
                        dataIndex: 'sendingDocument',
                        scopedSlots: {customRender: 'sendingDocument'}
                    }],
                TableData:[],

            }
        },
        methods:{
            Enter(input){
                // console.log(input)
                // if (input.data!=' '){
                //     if(input.inputType!="insertLineBreak"){
                //         this.PersonalCode= this.PersonalCode+input.data
                //         console.log(this.PersonalCode)
                //     }else{
                //         this.Click()
                //     }
                // }
            },
            sjp(){
                var xhr = new XMLHttpRequest()
                xhr.open('GET', 'http://192.168.63.118/restapi/api/order');
                xhr.onload = function() {
                    var responseText = xhr.responseText;
                    console.log(responseText);
                    // process the response.
                };
                console.log('praejo')
            },
            async Click(){
                if(this.PersonalCode.length !== 11) {
                    this.IncorrectPersonalCode = true;
                } else {
                    if(this.IncorrectPersonalCode) this.IncorrectPersonalCode = false;

                    var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFlZTYxNjE3YjQzNjNmODkwMzVhNmZhOWE3ZDNjYjRhZjFkMjIwMDRmMDA2OWMyZTAxNDBmNjFlN2E0NWNhZTA4OTAyOWQzMzAzMTlmMGE0In0.eyJhdWQiOiI0IiwianRpIjoiYWVlNjE2MTdiNDM2M2Y4OTAzNWE2ZmE5YTdkM2NiNGFmMWQyMjAwNGYwMDY5YzJlMDE0MGY2MWU3YTQ1Y2FlMDg5MDI5ZDMzMDMxOWYwYTQiLCJpYXQiOjE1Njg5NzA5MDQsIm5iZiI6MTU2ODk3MDkwNCwiZXhwIjoxNjAwNTkzMzA0LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.R8NlQxySIsWDg1vlmeI0_ycfz18QgYiLwQSHYBRwNDsdYUnmdqLTFqrccBO3OEzXqXd_59tDQjZovq0fwP19dP07E_jDlPoUnG0dRAtuB0e7jJB3dbKNtYk2CmwSacYLfLIVXLNi_OD2_7pC4TDuliphz1z17Y_o_Y9-sYtDBUZTM64AWTJ01uu3Msy_uhnuDL0xN8STViciAR7J4qVOkyiex6SH9vC2VBuiEmTit7uLI5TmBnb20L3HLXMcglpQ5cJECd87B0psuwWiY8IZ6g_NK_5LvoFi5oJXxQv6CHfnxzXLBhbHoWK4y0l4_Q-QB60CnjcySx8XFzWNPWJml8lJ8Ade1wOSOaZegEVGQ4n13FzZItqvJFVVM_kE_WWmV4XqHUAQ5EeL4votb4q5xV_RkM7HFUv6Brbxc5RDyl-qYTmaCKSg3SLs82FlY5z2uLkjrwD0TFcmxEk9fl_v61Yc6-18G0TFiizzPhDSrx8LWKidNmLp_9-9VUqJXsdK91iNFNDBWyLtZ3x6x7xKJlZltatiMxEYNe3xEoeF6xgsQduZyO8R2ba659iq_JpHkslykZ5LRh1WNpsJP47BDrFqPkpoZEYSVwHoqpepKcXpCVPxSnEnCeQzYZc9sm201m2SheStqYDkIpgf-f9tIavsS8-QhSS7iaQqUP5tl_8'
                    var base = axios.create({
                            baseURL: 'http://192.168.63.118/restapi',
                            headers: {'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRmNGE4Y2U1MWMwNGY3MzYzNTQxYTFmNGNhODk1MGZkMjhhNDk0NDcxMWFkMDQ1NzllMzJjNjgwYzMyOGY3YWViOTc0MGMzYTE5M2FlMzVhIn0.eyJhdWQiOiI0IiwianRpIjoiNGY0YThjZTUxYzA0ZjczNjM1NDFhMWY0Y2E4OTUwZmQyOGE0OTQ0NzExYWQwNDU3OWUzMmM2ODBjMzI4ZjdhZWI5NzQwYzNhMTkzYWUzNWEiLCJpYXQiOjE1Njg5ODUwNTMsIm5iZiI6MTU2ODk4NTA1MywiZXhwIjoxNjAwNjA3NDUzLCJzdWIiOiIiLCJzY29wZXMiOlsicGxhY2Utb3JkZXJzIl19.b4YHtyjc2gWylBa1yErJQY8aZkkslY2FKNG7hLsDU9V__6WmDkksv0NMjemqUuJQY9bdAvPFAWDr9kaL7Ld76HqQeviDQcgiS-BLlpjr6RU-zh_ZUZWk4ZmJBYrWcOMIkUD5YmW8EcDkCmvF9YC7RTzRyLpZQ9H6T9L7labgIoJxvH6soqTagYCkDUoOS5Njh1tvCHTUNI_U7XZF3IYU2IlAUQtu0tKxEL4Q3HgXtWW_t9omy1cAbHJXiWtRyV9PPAauZWhSGj4rkCAyzz62BwJqlCzywla8zf-4sWewW0Euib8-qeK7Smk7aw7-vFvCbf7Ld-xXE5APi0BRXLtoxrmQdc1QH4SuvTmL_WDpiLmNh8k3nEPM9GTpyv7GjNhKrZZprYOhxvEowPKfXx0Vi2saLrlXN8Xd_LqCkDb5-dqSjuhKaHIm0ULpOzzoV5R-dSxThizlph1wCMXgk8GC7AZkMk0HNc8ZLxue7S66Djem0i4TwlEYuQcopVL6W0sGjTOIiiZ0Yjzy-sMXIBXIxcb7fMQ0FTAlkzmt85PuPWGd_mMZx1PdAB7lekEqLs_DhqudI1ar47QiL-BNcP4j5pNt701WTnWvfFSKgTL6K7F133sqyp__pZKLH0IrqUso9TsPnZn3PfErRyRwkzdf9Iucuz2lxjw046kEp-cn5V0'},
                            'Content-type': 'application/json',
                            // 'Access-Control-Allow-Credentials': true
                        }
                    )

                    this.TableData = [];
                    this.IsLoaded = false;
                    this.Issearching = true;
                    this.IsVisable = true;
                    // base.get('/api/order')
                    //     .then(response=>{
                    //         console.log(response.data)
                    //     })
                    // axios.post('http://192.168.63.118/restapi/oauth/token'
                    // {headers: {
                    var url = 'api/orders/' + this.PersonalCode
                    await base.get(url,
                        // base.get('/api/orders/39609261831',
                        //      {headers: {
                        //     // 'Access-Control-Allow-Origin': '*',
                        //     // 'Content-Type': 'application/json',
                        //     // 'X-Requested-With': 'XMLHttpRequest',
                        //      'Content-Type': 'application/json',
                        //      'Authorization': 'Bearer {token}'
                        // }}
                        //,{grant_type: 'client_credentials', client_id: '4', client_secret: '759j4ZdBELd2041zfnzoQQHEAdyUqE4m4MgWiURU'}
                        // axios.post('http://192.168.63.118/restapi/oauth/token',{headers: {
                        //         'Access-Control-Allow-Origin': '*',
                        //         'Content-Type': 'application/json',
                    )
                        .then(response => {
                            this.IsLoaded = true;
                            this.Issearching = false;
                            var data = response.data;
                            var vardas = Object.keys(data)
                            console.log(response.data);
                            if (vardas.length > 0) {
                                this.Founded = true;
                                // this.PatientName= data[vardas[0]].OrderSourceDoctorName + ' ' +data[vardas[0]].OrderSourceDoctorSurname;
                                for (var index = 0; index < vardas.length; index++) {
                                    var date = data[vardas[index]].SendingCreationDate.split('T', 1)
                                    let birthday = data[vardas[index]].PatientFullInformation[0][0].split('T', 1)
                                    console.log(date);
                                    this.TableData.push({
                                        key: index,
                                        SicknessCode: data[vardas[index]].OrderDiagnosisCode,
                                        reason: data[vardas[index]].OrderTypeDisplay,
                                        company: data[vardas[index]].SendingCustodian[0][0],
                                        sendingDoctor: data[vardas[0]].SendingAuthor[0][0] + ' '
                                            + data[vardas[0]].SendingAuthor[1][0],
                                        sendingDate: date,
                                        sendingTarget: data[vardas[index]].SendingTarget[0],
                                        sendingDocument: data[vardas[index]].SendingLinkPdf,
                                        patientBirthday: birthday,
                                        patientName: data[vardas[index]].PatientFullInformation[1][0]
                                    })
                                }
                            } else {
                                this.Founded = false;
                                this.PatientName = '';

                            }
                            return this.PatientName;
                        })
                    // axios.get('/api/order',{params:{PC:this.PersonalCode}})
                    //     .then(response=>{
                    //         console.log(response.data)
                    //         this.IsLoaded= true;
                    //         this.Issearching= false;
                    //         var data = response.data;
                    //         if (data.length>0){
                    //          this.Founded=true;
                    //          this.PatientName= data[0].PATIENT_NAME;
                    //          for (var index=0;index<data.length;index++){
                    //              this.TableData.push({
                    //                  key:index,
                    //                  SicknessCode:data[index].POSTING_DIAGNOSIS,
                    //                  reason:data[index].REASON,
                    //                  company:data[index].SENDING_COMPANY,
                    //                  sendingDoctor:data[index].SENDING_DOCTOR,
                    //                  sendingDate:data[index].created_at
                    //              })
                    //          }
                    //         }else{
                    //             this.Founded=false;
                    //             this.PatientName='';
                    //
                    //         }
                    //         return this.PatientName;
                    //     })
                    // axios.get('api/CheckPostings',{params:{PC:this.PersonalCode}})
                    // .then(response=>{
                    //     this.IsLoaded= true;
                    //     this.Issearching= false;
                    //     var data = response.data;
                    //     if (data.length>0){
                    //      this.Founded=true;
                    //      this.PatientName= data[0].PATIENT_NAME;
                    //      for (var index=0;index<data.length;index++){
                    //          this.TableData.push({
                    //              key:index,
                    //              SicknessCode:data[index].POSTING_DIAGNOSIS,
                    //              reason:data[index].REASON,
                    //              company:data[index].SENDING_COMPANY,
                    //              sendingDoctor:data[index].SENDING_DOCTOR,
                    //              sendingDate:data[index].created_at
                    //          })
                    //      }
                    //     }else{
                    //         this.Founded=false;
                    //         this.PatientName='';
                    //
                    //     }
                    //     return this.PatientName;
                    // })
                }
                },
        },
        beforeMount() {
            this.sjp()
        },
    }
</script>

<style scoped>
    .tarpas {
        margin-top: 10px;
    }
    .spin-content{
        /*border: 1px solid #91d5ff;*/
        /*background-color: #e6f7ff;*/
        padding: 30px;
    }
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
    .v-dialog {
        margin-top: 0px !important;
    }
</style>

