<template>
    <div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-5 mb-5">
                            <i class="fa fa-plus-square fa-lg"></i>
                            <h1 class="box-title"> Laboratoriniai tyrimai laukiantys patvirtinimo</h1>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <a-table :columns="columnsPending" :dataSource="PendingListInfo" bordered >
                                <template slot="name" slot-scope="text, record, index">
                                    <a  slot="name" @click="open(record)">{{text}} </a>
                                </template>
                            </a-table>
                            <a-modal
                                :title="Name"
                                v-model="visible"
                            >
                                <template slot="footer">
                                    <a-button key="back" @click="handleCancel">Uždaryti</a-button>
                                    <a-button key="submit" type="primary"  @click="handleOk">Patvirtinti</a-button>
                                </template>
                                <a-table :rowSelection="{selectedRowKeys: Pasirinktys, onChange: onSelectChange}" :columns="columnsEdit" :dataSource="DisplayData" bordered >
                                    <template v-for="col in ['Atsakymas']" :slot="col" slot-scope="text, record, index">
                                        <div :key="col">
                                            <a-input
                                                v-if="record.editable"
                                                style="margin: -5px 0"
                                                :value="text"
                                                @change="e => handleChange(e.target.value, record.key, col)"
                                            />
                                            <template v-else>{{text}}</template>
                                        </div>
                                    </template>
                                    <template slot="Redaguoti" slot-scope="text, record, index">
                                        <div class='editable-row-operations'>
                                             <span v-if="record.editable">
                                             <a @click="() => save(record.key)">Išsaugoti</a>
                                                  <a-popconfirm title='Sure to cancel?' @confirm="() => cancel(record.key)">
                                                     <a>Atšaukti</a>
                                                  </a-popconfirm>
                                             </span>
                                            <span v-else>
                                                  <a @click="() => edit(record.key)">Redaguoti</a>
                                            </span>
                                        </div>
                                    </template>
                                </a-table>
                            </a-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-5 mb-5">
                            <i class="fa fa-plus-square fa-lg"></i>
                            <h1 class="box-title"> Neivigdyti laboratoriniai tyrimai</h1>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <a-table :columns="columnsNotDone" :dataSource="NotDoneListInfo" bordered >
                            </a-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const DisplayData=[]
   const columnsEdit=[{
        title: 'Analite',
        className:'Analite',
        dataIndex:'Analite',
    },{
        title: 'Atsakymas',
        className:'Atsakymas',
        dataIndex:'Atsakymas',
    },{
        title: '',
        className:'Redaguoti',
        dataIndex:'Redaguoti',
        scopedSlots: { customRender: 'Redaguoti' }
    }
    ]
    export default {
        name: "LabTestControl",

        data(){
            this.cacheData = DisplayData.map(item => ({ ...item }))
            return {
                Name:[],
                PendingListInfo:[],
                PendingListNames:[],
                PendingListInformation:[],
                PendingResponses:[],
                PendingInputs:[],
                PendingCount:[],
                OpenedProject:[],
                columnsPending : [{
                    title: 'Testo Pavadinimas',
                    clasName:'PendingTest',
                    dataIndex: 'PendingTest',
                    scopedSlots: { customRender: 'name' },

                },{
                    title: 'Tyrimas',
                    className:'TestPending',
                    dataIndex: 'Test',

                }, {
                    title: 'Paciento A/K',
                    className: 'PersonID',
                    dataIndex: 'PersonID',
                }, {
                    title: 'Siunčiantis gydytojas',
                    className: 'SendingDoctor',
                    dataIndex: 'SendingDoctor',
                },{
                    title: 'Užsakymo data',
                    className:'OrdedDate',
                    dataIndex: 'OrdedDate',
                },{
                    title: 'Testo atlikimo data',
                    className: 'Test',
                    dataIndex: 'CompletedDate',
                },

                ],
                NotDoneListInfo:[],
                NotDoneListNames:[],
                Pasirinktys:[],
                visible:false,
                NotDoneListInformation:[],
                NotDoneResponses:[],
                NotDoneInput:[],
                DisplayData:[],
                NotDonePending:[],
                columnsEdit:[{
                    title: 'Analite',
                    className:'Analite',
                    dataIndex:'Analite',
                },{
                    title: 'Atsakymas',
                    className:'Atsakymas',
                    dataIndex:'Atsakymas',
                    scopedSlots: { customRender: 'Atsakymas' }
                },{
                    title: 'Matavimo vienetai',
                    className:'MeasureUnit',
                    dataIndex:'MeasureUnit',
                },{
                    title: '',
                    className:'Redaguoti',
                    dataIndex:'Redaguoti',
                    scopedSlots: { customRender: 'Redaguoti' }
                },

                ],
                columnsNotDone : [{
                    title: 'Testo Pavadinimas',
                    clasName:'PendingTest',
                    dataIndex: 'PendingTest',
                    scopedSlots: { customRender: 'name' },

                },{
                    title: 'Tyrimas',
                    className:'TestPending',
                    dataIndex: 'Test',

                }, {
                    title: 'Paciento A/K',
                    className: 'PersonID',
                    dataIndex: 'PersonID',
                }, {
                    title: 'Siunčiantis gydytojas',
                    className: 'SendingDoctor',
                    dataIndex: 'SendingDoctor',
                },{
                    title: 'Užsakymo data',
                    className:'OrdedDate',
                    dataIndex: 'OrdedDate',
                },],
            }
        },
        components: {

        },
        methods:{
            handleChange (value, key, column) {
                const newData = [...this.DisplayData]
                const target = newData.filter(item => key === item.key)[0]
                if (target) {
                    target[column] = value
                    this.DisplayData = newData
                }
            },
            edit (key) {
                const newData = [...this.DisplayData]
                const target = newData.filter(item => key === item.key)[0]
                if (target) {
                    target.editable = true
                    this.DisplayData = newData
                }
            },
            save (key) {
                const newData = [...this.DisplayData]
                const target = newData.filter(item => key === item.key)[0]
                if (target) {
                    delete target.editable
                    this.DisplayData = newData
                    this.Pasirinktys.push(key)
                    this.cacheData = newData.map(item => ({ ...item }))
                }
            },
            cancel (key) {
                const newData = [...this.DisplayData]
                const target = newData.filter(item => key === item.key)[0]
                if (target) {
                    Object.assign(target, this.cacheData.filter(item => key === item.key)[0])
                    delete target.editable
                    this.DisplayData = newData
                }
            },
            onSelectChange(Pasirinktys){
                this.Pasirinktys = [];
                this.Pasirinktys=Pasirinktys
            },
            handleOk(){
                this.Confirm();
                this.visible=false;
                this.NotDoneListNames=[];
                this.PendingListNames=[];
                this.NotDoneListInfo=[];
                this.PendingListInfo=[];
                this.FirstFunction();
            },
            handleCancel(){
                this.Pasirinktys = [];
                this.visible=false
            },
            open(a){
                this.Pasirinktys = [];
                this.OpenedProject = a;
                this.Name = a.PendingTest
                this.DisplayData=[];
                for ( var index =0;index<a.answer.length; index++){
                    this.DisplayData.push({key:index,Analite:a.answer[index].analite,Atsakymas:a.answer[index].answer,Redaguoti:'Redaguoti',dbkey:a.answer[index].dbkey, MeasureUnit:a.answer[index].MesureUnit})
                    if (a.answer[index].Selected===1){
                        this.Pasirinktys.push(index)
                    }
                }
                this.visible=true
            },
            FirstFunction(){
                axios.get('/api/getLabTestAll')
                    .then(response=>{
                        var AxiosData= response.data;
                        for (var index= 0; index<AxiosData.length;index++){
                            if (AxiosData[index].State==='pending'){
                                this.NotDoneListNames.push({key:index,PendingTest:AxiosData[index].TestName,Test:'',PersonID:AxiosData[index].PatientPersonalID,SendingDoctor:AxiosData[index].SendingDoctor,OrdedDate:AxiosData[index].created_at,dbkey:AxiosData[index].id})
                            }else if((AxiosData[index].State==='awaitingconformation')||(AxiosData[index].State==='partialiconfirmed')){
                                this.PendingListNames.push({key:index,PendingTest:AxiosData[index].TestName,Test:'',PersonID:AxiosData[index].PatientPersonalID,SendingDoctor:AxiosData[index].SendingDoctor,OrdedDate:AxiosData[index].created_at,CompletedDate:AxiosData[index].updated_at,dbkey:AxiosData[index].id})
                            }

                        }
                        this.NotDoneParsing();
                        this.PendingParsing();
                    })
            },
            async NotDoneParsing(){
                for (var index = 0;index<this.NotDoneListNames.length;index++){
                    await  axios.get('/api/getLabTestData',{params:{TestName:this.NotDoneListNames[index].PendingTest}})
                        .then(response=>{
                            var ats  = response.data;
                            this.NotDoneListInfo.push({key:index,PendingTest:this.NotDoneListNames[index].PendingTest,Test:ats[0].Test,PersonID:this.NotDoneListNames[index].PersonID,SendingDoctor:this.NotDoneListNames[index].SendingDoctor,OrdedDate:this.NotDoneListNames[index].OrdedDate,dbkey:this.NotDoneListNames[index].dbkey})
                        })
                }

            },
            async PendingParsing(){
                for (var index = 0;index<this.PendingListNames.length;index++){
                    await  axios.get('/api/getLabTestData',{params:{TestName:this.PendingListNames[index].PendingTest}})
                        .then(response=>{
                            var ats = response.data
                            var info=[];
                            for(var index2=0;index2<ats.length;index2++){
                                info.push({analite:ats[index2].TestAnalite,answer:ats[index2].Answer,MesureUnit:ats[index2].MesureUnit,dbkey:ats[index2].id, Selected:ats[index2].WasChecked})
                            }
                            this.PendingListInfo.push({key:index,answer:info,PendingTest:this.PendingListNames[index].PendingTest,Test:ats[0].Test,PersonID:this.PendingListNames[index].PersonID,SendingDoctor:this.PendingListNames[index].SendingDoctor,OrdedDate:this.PendingListNames[index].OrdedDate,dbkey:this.PendingListNames[index].dbkey,CompletedDate:this.PendingListNames[index].CompletedDate})

                        })
                }
            },
            Confirm(){
                if (this.Pasirinktys.length ===this.DisplayData.length){
                  var url= '/api/getLabTestAll/'+ this.OpenedProject.dbkey
                    axios.put(url,{
                        id:this.OpenedProject.dbkey,
                        State:'done'
                    })

                    for(var index = 0; index< this.DisplayData.length;index++){
                        var url2= '/api/getLabTestData/'+this.DisplayData[index].dbkey
                       axios.put(url2,{
                           id:this.DisplayData[index].dbkey,
                           Answer:this.DisplayData[index].Atsakymas,
                           WasChecked:1
                        })
                    }
                }else if(this.Pasirinktys.length===0){
                    var url= '/api/getLabTestAll/'+ this.OpenedProject.dbkey
                    axios.put(url,{
                        id:this.OpenedProject.dbkey,
                        State:'awaitingconformation'
                    })

                    for(var index = 0; index< this.DisplayData.length;index++){
                        var url2= '/api/getLabTestData/'+this.DisplayData[index].dbkey
                        axios.put(url2,{
                            id:this.DisplayData[index].dbkey,
                            Answer:this.DisplayData[index].Atsakymas,
                            WasChecked:0
                        })
                    }
                }else if((this.Pasirinktys.length!==0)&&(this.Pasirinktys.length!==this.DisplayData.length)){
                    var url= '/api/getLabTestAll/'+ this.OpenedProject.dbkey
                    axios.put(url,{
                        id:this.OpenedProject.dbkey,
                        State:'partialiconfirmed'
                    })
                    for(var index = 0; index< this.DisplayData.length;index++){
                        var url2= '/api/getLabTestData/'+this.DisplayData[index].dbkey
                        if(this.Pasirinktys.includes(this.DisplayData[index].key)){
                            axios.put(url2,{
                                id:this.DisplayData[index].dbkey,
                                Answer:this.DisplayData[index].Atsakymas,
                                WasChecked:1
                            })
                        }else{
                            axios.put(url2,{
                                id:this.DisplayData[index].dbkey,
                                Answer:this.DisplayData[index].Atsakymas,
                                WasChecked:0
                            })
                        }

                    }
                }

            },

        },
        beforeMount(){
            this.FirstFunction();
        },
        mounted(){
        },

    }
</script>

<style scoped>
    .editable-row-operations a {
        margin-right: 8px;
    }
</style>
