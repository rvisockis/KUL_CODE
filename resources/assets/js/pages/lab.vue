<template>
    <div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-5 mb-5">
                            <i class="fa fa-plus-square fa-lg"></i>
                            <h1 class="box-title"> Užsakyti naują</h1>
                        </div>
                    </div>
                    <div class="box-body" v-bind:class="{'is-disabled':disabled}">
                        <div class="col-md-6">
                            <enhanced-el-tree
                                show-checkbox
                                node-key="id"
                                :props ="props"
                                :load = "loadNode"
                                :expand-on-click-node="true"
                                :expan-on-check-node="true"
                                :accordion="true"
                                :render-after-expand="false"
                                lazy
                                @check="OnCheckBoxClick"
                                ref="tree"
                            ></enhanced-el-tree>
                        </div>
                        <div class="col-md-6">
                            <a-button-group>
                                <a-button v-for="item in Selectedvmodel" v-on:click="ButtonWasClicked(item)" class="btn-info" style="margin:2px"  >{{item.Test}} : {{item.TestAnalites}}</a-button>
                            </a-button-group>
                        </div>

                        <div class="col-md-3">
                            <label></label>
                        </div>

                    </div>
                    <div class="box-footer" v-bind:class="{'is-disabled':disabled}">
                        <button class="btn btn-default pull-right" v-on:click="getCheckedNodesWithoutChild" >Patvirtinti</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-8 mb-8">
                            <i class="fa fa-plus-square fa-lg"></i>
                            <h1 class="box-title">Laboratoriniai atsakymai</h1>
                        </div>
                    </div>
                    <div class="box-body" style="height: auto">
                        <a-spin :spinning="LoadOrdered">
                            <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />
                            <a-popover v-for="items in CompletedTestData" style="width: auto; height:auto ; margin:4px">
                                <template slot="content"> {{items.text}}</template>
                                <span slot="title">Atsakymai :</span>
<!--                                <a-button class="btn-success" >Testas: {{items.Test}}-->
                                <a-button class="btn-success" >
                                    Testas: {{items.Test}}
                                    <br>Testo numeris {{items.name}}
                                    <br>Atlikimo Data {{items.CompletedDate}}
                                    <br>Užsakymo Data {{items.OrderedDate}}
                                    <br>
                                </a-button>
                            </a-popover>
                        </a-spin>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-8 mb-8">
                            <i class="fa fa-plus-square fa-lg"></i>
                            <h1 class="box-title">Tyrimai laukiantys ivykdymo</h1>

                        </div>
                    </div>
                    <div class="box-body">
                    <a-spin :spinning="LoadPending">
                        <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />
                        <a-popover v-for="items in PendingTestData" style="width: auto; height:auto ; margin:4px">
                            <template slot="content"> {{items.text}}</template>
                            <span slot="title">Užsakytos analitės :</span>
<!--                            <a-button class="btn-danger" >-->
                            <a-button class="btn-danger"  >
                                Testas: {{items.Test}}
                                <br>Testo numeris {{items.name}}
                                <br>Užsakymo Data {{items.OrderedDate}}
                                <br>
                            </a-button>
                        </a-popover>
                    </a-spin>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {LinksFunction} from "../components/ReadLinkInfo"
    import EnhancedElTree from '@xlaoyu/enhanced-el-tree';
    export default {
        data(){
            return {
                testmodelis:[],

                sourceTakeDiagnosis: '/api/getPatient',
                OrdernewState:false,
                PendingresearchState:false,
                ResearchHistoryState:false,
                FoundedTestsTypes:[],
                FoundedWhatToTest:[],
                FoundedTests:[],
                FoundedTestsAnalites:[],
                SelectedTest:[],
                SelectedTestCount:0,
                OrderedTestsCount:0,
                CompletedTest:[],
                CompletedTestData:[],
                OrderedTests:[],
                SendingData:[],
                PendingTest:[],
                PendingTestCount:0,
                PendingTestData:[],
                PendingTestResponses:1,
                CompletedResponses:1,
                TestName:'',
                TestsNames:[],
                disabled:false,
                CompleatedTests:[],
                RecievedData:[],
                WasSelectedFully:[],
                PersonID:LinksFunction(this.$route.query,'personal-code'),
                DoctorName:LinksFunction(this.$route.query,'username'),
                LabTestModel:[],
                Selectedvmodel:[],
                inputs:[],
                Completedinputs:[],
                PendingAxios:1,
                CompletedAxios:1,
                LoadPending:true,
                LoadOrdered:true,
                props: {
                    label: 'name',
                    children: 'zones',
                    type:'',
                    WhatTested:'',
                    TestAnalites:'',
                    Test:'',
                    disabled: 'disabled',
                    isLeaf:'leaf',
                },
            }
        },
        components: {
            EnhancedElTree
        },
        methods:{
            ButtonWasClicked(input){
                this.$refs.tree.setChecked(input,false,4)
                this.OnCheckBoxClick();
            },
            OnCheckBoxClick(){
                this.SelectedTest=[];
                this.$refs.tree.store.levelShow[2]=true
                var CheckedNodes= this.$refs.tree.getCheckedNodes();
                var AlmostCheckedNodes = this.$refs.tree.getHalfCheckedNodes();
                // SelectedTest
                for (var index =0;index<CheckedNodes.length;index++){
                    if ((CheckedNodes[index].Test!='-')&&(CheckedNodes[index].TestAnalites=='-')){
                        this.SelectedTest.push(CheckedNodes[index])
                    }
                }
                for (var index =0;index<AlmostCheckedNodes.length;index++){
                    if ((AlmostCheckedNodes[index].Test!='-')&&(AlmostCheckedNodes[index].TestAnalites=='-')){
                        this.SelectedTest.push(AlmostCheckedNodes[index])
                    }
                }
                let WasFullySelected=[]
                let analitestest  = [];
                var nodeid=[];
                this.Selectedvmodel = [];
                for (var index =0; index<CheckedNodes.length;index++){
                    if (CheckedNodes[index].Test!='-'){
                        if (CheckedNodes[index].TestAnalites!='-'){
                            analitestest.push(CheckedNodes[index].Test)
                            this.Selectedvmodel.push(CheckedNodes[index])
                        }else{
                            WasFullySelected.push(CheckedNodes[index].Test)
                            nodeid.push(CheckedNodes[index].id)
                        }
                    }
                }
                for (var index=0;index<WasFullySelected.length;index++){
                    for (var index2=0;index2<this.RecievedData.length;index2++){
                        if ((this.RecievedData[index2].TestAnalite!='-')&&(this.RecievedData[index2].Test==WasFullySelected[index])&&(!(analitestest.includes(WasFullySelected[index])))){
                            var id = index2 +'-'+1+'-'+2+'-'+3;
                            this.Selectedvmodel.push({id:id, name:this.RecievedData[index2].TestAnalite, disabled:false,type:this.RecievedData[index2].TestType,Test:this.RecievedData[index2].Test,TestAnalites:this.RecievedData[index2].TestAnalite,WhatTested:this.RecievedData[index2].WhatToTest,leaf:true});
                        }
                    }
                }
            },
           async FirstFunction(){
                //get persons ordered and compleated tests
                  axios.get('/api/getLabTest',{params:{PersonID:this.PersonID}})
                    .then(response =>{
                        this.OrderedTests= response.data;
                        for (var index=0;index<this.OrderedTests.length;index++){
                            if (this.OrderedTests[index].State==='done'){
                                this.OrderedTestsCount=1+this.OrderedTestsCount
                                this.GetResults(this.OrderedTests[index].TestName)
                            }else{
                                this.PendingTestCount=1+this.PendingTestCount;
                                this.GetPendingAnalites(this.OrderedTests[index].TestName)
                            }
                        }
                    })
                    .catch(error=>{

                    })
            },
           async GetPendingAnalites(input){
                this.inputs.push(input)
                if (this.PendingTestCount==this.PendingTestResponses){
                    for (var index = 0;index<this.inputs.length;index++){
                        await axios.get('/api/getLabTestData',{params:{TestName:this.inputs[index]}})
                            .then(response=>{

                                var Data = response.data[0].created_at;
                                var PagaminimoData =Data.toString().slice(0,11);
                                this.PendingTest.push({name:this.inputs[index], information: response.data , UzsakymoData:PagaminimoData, Testas:response.data[0].Test });
                                if (this.PendingAxios==this.PendingTestResponses){
                                    this.CombinePendingTest();

                                }else{
                                    this.PendingAxios++
                                }
                                this.LoadPending=false;
                            })
                            .catch(error=>{
                            })
                    }
                }else{
                    this.PendingTestResponses++
                }
            },
            CombinePendingTest(){
                for (var index = 0; index<this.PendingTest.length;index++){
                    this.PendingTestData.push({name:'',text:'',OrderedDate:'',CompletedDate:'',Test:''});
                    this.PendingTestData[index].name=this.PendingTest[index].name;
                    this.PendingTestData[index].OrderedDate=this.PendingTest[index].UzsakymoData;
                    this.PendingTestData[index].CompletedDate=this.PendingTest[index].AtlikimoData;
                    this.PendingTestData[index].Test=this.PendingTest[index].Testas;
                    for (var index2=0;index2<this.PendingTest[index].information.length; index2++){
                        this.PendingTestData[index].text = this.PendingTest[index].information[index2].TestAnalite + ' ; ' +'   '+this.PendingTestData[index].text
                    }
                }

            },
           async GetResults(input){
                this.Completedinputs.push(input)
                //get completed tests analites.
                if (this.CompletedResponses==this.OrderedTestsCount){
                        for (var index = 0;index<this.Completedinputs.length;index++){
                          await  axios.get('/api/getLabTestData',{params:{TestName:this.Completedinputs[index]}})
                                .then(response=>{
                                    var Data = response.data[0].created_at;
                                    var PagaminimoData =Data.toString().slice(0,11);
                                    var Data2 =  response.data[0].updated_at;
                                    var PabaigimoData =Data2.toString().slice(0,11);
                                    this.CompletedTest.push({name:this.Completedinputs[index], information: response.data , UzsakymoData:PagaminimoData, AtlikimoData: PabaigimoData, Testas:response.data[0].Test });
                                    if (this.CompletedAxios==this.OrderedTestsCount){
                                        this.CombineTestWithTestData();
                                    }else{
                                        this.CompletedAxios++
                                    }
                                    this.LoadOrdered=false;
                                })
                                .catch(error=>{
                                })
                        }
                }else{
                    this.CompletedResponses++
                }
            },
            CombineTestWithTestData(){
                for (var index = 0; index<this.CompletedTest.length;index++){
                    this.CompletedTestData.push({name:'',text:'',OrderedDate:'',CompletedDate:'',Test:''});
                    this.CompletedTestData[index].name=this.CompletedTest[index].name;
                    this.CompletedTestData[index].OrderedDate=this.CompletedTest[index].UzsakymoData;
                    this.CompletedTestData[index].CompletedDate=this.CompletedTest[index].AtlikimoData;
                    this.CompletedTestData[index].Test=this.CompletedTest[index].Testas;
                    for (var index2=0;index2<this.CompletedTest[index].information.length; index2++){
                        this.CompletedTestData[index].text = this.CompletedTest[index].information[index2].TestAnalite + ' : '+this.CompletedTest[index].information[index2].Answer +'('+ this.CompletedTest[index].information[index2].MesureUnit+')'+'  ; '+'   '+this.CompletedTestData[index].text
                    }
                }

            },
            loadNode(node,resolve){
                if (node.level === 0) {
                    axios.get('/api/getAnalites')
                        .then(response=>{
                            this.RecievedData= response.data;

                            var SendThis=[];
                            for (var index =0 ; index<this.RecievedData.length;index++){
                                if (this.FoundedTestsTypes.indexOf(this.RecievedData[index].TestType)==-1){
                                    SendThis.push({id: index ,name:this.RecievedData[index].TestType,disabled:true})
                                    this.FoundedTestsTypes.push(this.RecievedData[index].TestType)
                                }
                            }
                            return resolve(SendThis)
                        })
                }
                if (node.level>0){
                    this.FoundedTestsTypes=[];
                    this.FoundedTests=[];
                    this.FoundedWhatToTest=[];
                    this.FoundedTestsAnalites=[];
                    if (node.level==1){
                        var SendThis=[];
                        for (var index =0 ; index<this.RecievedData.length;index++){
                            if ((node.data.name==this.RecievedData[index].TestType)&&(this.FoundedWhatToTest.indexOf(this.RecievedData[index].WhatToTest)==-1)&&(this.RecievedData[index].WhatToTest!='-')){
                                this.FoundedWhatToTest.push(this.RecievedData[index].WhatToTest)
                                var id = index +'-'+node.level;
                                SendThis.push({id:id,name:this.RecievedData[index].WhatToTest,WhatTested:this.RecievedData[index].WhatToTest, disabled:true,type:this.RecievedData[index].TestType,Test:'-',TestAnalites:'-'})
                            }
                        }
                        return resolve(SendThis)

                    }
                    if (node.level==2){
                        var SendThis=[];
                        for (var index =0 ; index<this.RecievedData.length;index++){
                            if ((node.data.name==this.RecievedData[index].WhatToTest)&&(this.FoundedTests.indexOf(this.RecievedData[index].Test)==-1)&&(this.RecievedData[index].Test!='-')){
                                this.FoundedTests.push(this.RecievedData[index].Test)
                                var a = node.level-1
                                var b =node.level
                                var c = index
                                var id = c +'-'+a+'-'+b;
                                SendThis.push({id:id,name:this.RecievedData[index].Test, disabled:true,type:this.RecievedData[index].TestType,WhatTested:this.RecievedData[index].WhatToTest,Test:this.RecievedData[index].Test,TestAnalites:'-',WhatTested:this.RecievedData[index].WhatToTest})
                            }
                        }
                        return resolve(SendThis)
                    }
                    if (node.level==3){
                        // FoundedTestsAnalites
                        var SendThis=[];
                        for (var index =0 ; index<this.RecievedData.length;index++){
                            if ((node.data.type==this.RecievedData[index].TestType)&&(node.data.WhatTested==(this.RecievedData[index].WhatToTest))&&(node.data.Test==(this.RecievedData[index].Test))&&(this.FoundedTestsAnalites.indexOf(this.RecievedData[index].TestAnalite)==-1)&&(this.RecievedData[index].TestAnalite!='-')){
                                this.FoundedTestsAnalites.push(this.RecievedData[index].TestAnalite)
                                var a = node.level-1
                                var b =node.level
                                var c = index
                                var d = node.level-2
                                var id = c +'-'+d+'-'+a+'-'+b;
                                SendThis.push({id:id, name:this.RecievedData[index].TestAnalite, disabled:false,type:this.RecievedData[index].TestType,Test:this.RecievedData[index].Test,TestAnalites:this.RecievedData[index].TestAnalite,WhatTested:this.RecievedData[index].WhatToTest,MesureUnit:this.RecievedData[index].MesureUnit,leaf:true})
                            }
                        }
                        return resolve(SendThis)
                    }
                }

            },
            GetLastTestName(input,numb){
                axios.get('api/getTestsName')
                    .then(response =>{
                        var ResponseData= response.data
                        var ResponseDataLength = ResponseData.length
                        this.TestName = 'TEST'+ResponseDataLength+1+numb
                        for (var index=0; index<this.Selectedvmodel.length;index++){
                            if (this.Selectedvmodel[index].Test==input){
                                axios.post('api/getLabTestData',{
                                    TestName:this.TestName+1+numb,
                                    TestType:this.Selectedvmodel[index].type,
                                    WhatToTest:this.Selectedvmodel[index].WhatTested,
                                    Test:input,
                                    TestAnalite:this.Selectedvmodel[index].TestAnalites,
                                    MesureUnit:this.Selectedvmodel[index].MesureUnit
                                })
                            }
                        }
                        axios.post('api/getLabTest',{
                            TestName:this.TestName+1+numb,
                            PatientPersonalID:this.PersonID,
                            SendingDoctor:this.DoctorName,
                        })
                            .then(response=>{
                                var text = 'Tyrimas užsakytas pavadinimu: '+this.TestName+1+numb
                                this.Notification(1,text)
                            })
                            .catch(error=>{
                                var text = 'Tyrimo užsakyti nepavyko'
                                this.Notification(2,text)

                            })
                        this.disabled= true;
                    })

            },
            getCheckedNodesWithoutChild(){
                var toSend
                toSend = this.Selectedvmodel
                for (var index=0;index<this.SelectedTest.length;index++){
                    if (this.Selectedvmodel[index].test!='-'){
                        this.GetLastTestName(this.SelectedTest[index].Test,index)
                    }
                }
                if (this.Selectedvmodel.length<1){
                    this.Notification(2,'Privalote pasirinkti tyrimą')
                }

                },
            Notification(type, text){
                this.$notification.config({
                    placement: 'topRight',
                    top: '50px'
                });
                if (type == 1) {
                    this.$notification.open({
                        message: 'Pavyko',
                        description: text,
                        showIcon: true,
                        type: 'success'

                    });
                } else if(type==2) {
                    this.$notification.open({
                        message: 'Nepavyko',
                        description: text,
                        showIcon: true,
                        type: 'error'

                    });
                }
            }

        },
        beforeMount(){
            this.FirstFunction();
        },
        mounted(){
        },

    }
</script>
<style>
    .is-disabled {
        opacity: .5;
        pointer-events: none;
    }
</style>

