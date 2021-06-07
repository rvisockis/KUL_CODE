<template>
    <div>
<!--        <a-button class="col-md-12" v-if="!isTyrimaiActive" style="margin-top:20px;"  type="primary" @click="isTyrimaiActive = true">Užsakymų / Atsakymų langas</a-button>-->
        <div class="col-md-12">
            <div class="box">
<!--                israsas-->
                <div class="box-header with-border">
                    <i class="fa fa-hospital-o fa-lg"></i>
                    <h3 class="box-title">VIZITO MEDICININIAI DOKUMENTAI</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div :class="{'col-md-9': !isTyrimaiActive, 'col-md-6': isTyrimaiActive }">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <div class="col-md-12">
                                            <i class="fa fa-hospital-o fa-lg"></i>
                                            <h3 class="box-title">Medicininis išrašas / Siuntimas</h3>
                                        </div>
                                    </div>
<!-- kaires puses pirma dalis-->
                                    <a-tabs @change="Check(2)">
                                        <a-tab-pane tab="Gydymo išrašas" key="1" defaultActiveKey="1" v-on:click="Check()">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div v-bind:class="[Push,LiguJuosta]">
                                                        <a-spin :spinning="spinning">
                                                            <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />
                                                            <div class="spin-content">
                                                                <div v-if="Exists">
                                                                    <a-menu
                                                                            :defaultSelectedKeys="['1']"
                                                                            :defaultOpenKeys="['sub1']"
                                                                            mode="inline"
                                                                            :inlineCollapsed="collapsed">
                                                                        <a-menu-item v-for="items in PatientHistory" v-on:click="Import(items)" ><a-icon type="inbox" /><span><a-popover :title="items.sickness_startdate">{{items.sickness_startdate}}<template slot="content">
                                                                          <p><strong>Anamnezė</strong> - {{items.anamnesis}}</p>
                                                                          <p><strong>Apžiūros rezultatai</strong> -{{items.objective_finding}}</p>
                                                                          <p><strong>Tyrimų planas</strong> -{{items.consultation}}</p>
                                                                          <p><strong>Ligos eiga</strong> - {{items.illness_progress}}</p>
                                                                          <p><strong>Gydymo rekomendacijos</strong>- {{items.regime_recommentation}}</p>
                                                                          <a-button class="btn btn-info" v-on:click="Click(1,items.anamnesis)">Anamnezė</a-button>
                                                                          <a-button class="btn btn-info" v-on:click="Click(2,items.objective_finding)">Apžiūros rezultatai</a-button>
                                                                          <a-button class="btn btn-info" v-on:click="Click(3,items.consultation)">Tyrimų planas</a-button>
                                                                          <a-button class="btn btn-info" v-on:click="Click(4,items.illness_progress)">Ligos eiga</a-button>
                                                                          <a-button class="btn btn-info" v-on:click="Click(5,items.regime_recommentation)">Gydimo rekomendacijos</a-button>
                                                    </template></a-popover></span></a-menu-item>
                                                                    </a-menu>
                                                                </div>
                                                                <div v-else>
                                                                    <a-alert
                                                                            message="Perspėjimas"
                                                                            description="Nerasta ligos istorija"
                                                                            type="warning"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </a-spin>
                                                    </div>
                                                    <div v-bind:class="[Push,KomponentoJuosta]">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <label>Anamnezė</label>
                                                                <a-textarea placeholder="-" :autosize="{ minRows: 3, maxRows: 999 }" v-on:input="AutoSave" v-model="AnamnezeModel"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Apžiūros rezultatai</label>
                                                                <a-textarea placeholder="-" :autosize="{ minRows: 3, maxRows: 999 }" v-on:input="AutoSave" v-model="ApziurosRezultataiModel"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tyrimų planas</label>
                                                                <a-textarea placeholder="-" :autosize="{ minRows: 3, maxRows: 999 }" v-on:input="AutoSave" v-model="TyrimuPlanasModel"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Ligos eiga</label>
                                                                <a-textarea placeholder="-" :autosize="{ minRows: 3, maxRows: 999 }" v-on:input="AutoSave" v-model="LigosEigaModel"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Gydymo rekomendacijos</label>
                                                                <a-textarea placeholder="-" :autosize="{ minRows: 3, maxRows: 999 }" v-on:input="AutoSave" v-model="GydymoRekomendacijosModel"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a-tab-pane>
                                        <a-tab-pane tab="Siuntimas" key="2" v-on:click="GetList" >
<!-- siuntimas-->
                                            <div class='col-md-12'>
                                                <div class="form-group">
                                                    <div class="form-group ">
                                                        <label>Siuntimas</label>
                                                        <a-textarea placeholder="-" :autosize="{ minRows: 1, maxRows: 999 }"  v-model="Sending"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Diagnozės</label>
                                                        <multiselect v-model="Selected" label="code" track-by="code" placeholder="Pasirinkite siuntimo diagnoze" :options="SelectedDiagnosis" :searchable="false" :multiple="true"  :max-height="600" open-direction="bottom" :taggable="false" :close-on-select="false"  @search-change="GetList" @open="GetList" >
                                                            <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.code}} {{ props.option.name}}</span></div></template>
                                                            <template slot="noOptions">Pirma pasirinkite ligas ir jas patvirtinkite</template>
                                                        </multiselect>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Specialistas</label>
                                                        <multiselect v-model="Speciality" tagPosition="bottom" label="display_name" track-by="display_name" placeholder="Pasirinkite specialybę" :searchable="true" :options="SpecialityTitle" :multiple="true" open-direction="bottom" :close-on-select="false" :taggable="false" @search-change="getSpeciality" @open="getSpeciality" >
                                                            <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.display_name}}</span></div></template>
                                                            <template slot="noOptions">Sąrašas yra tuščias</template>
                                                        </multiselect>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Priežastis</label>
                                                        <a-textarea placeholder="-" :autosize="{ minRows: 1, maxRows: 999 }"  v-model="reason"/>
                                                    </div>
                                                    <a-popconfirm
                                                            :title="titlepop"
                                                            :visible="visible"
                                                            @visibleChange="handleVisibleChange"
                                                            @confirm="confirm"
                                                            @cancel="cancel"
                                                            okText="Tęsti"
                                                            cancelText="Nutraukti"
                                                    >
                                                        <a-button class="btn btn-info" >Siųsti</a-button>
                                                    </a-popconfirm>

                                                </div>
                                            </div>
                                        </a-tab-pane>
                                    </a-tabs>
<!--  -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5" :class="{tyrimaiActive: isTyrimaiActive, 'tyrimaiInactive': !isTyrimaiActive}">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <div class="col-md-12" style="margin-bottom: 16px">
                                            <i class="fa fa-hospital-o fa-lg"></i>
                                            <h3 class="box-title">Užsakymai / Atsakymai</h3>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <a-collapse accordion defaultActiveKey="1" :bordered="false" style="margin:20px; width:100%;">
                                                <a-collapse-panel header="Užsakymai" key="1"  >
<!--uzsakymai-->
                                                    <a-tabs defaultActiveKey="1" :size="size" >
                                                        <a-tab-pane tab="Radiologija" key="1">
                                                            <a-tabs defaultActiveKey="1" type="card" >
                                                                <a-tab-pane tab="Rentgenas"  key="1" v-on:click="Check()">
                                                                    <rengenas></rengenas>
                                                                </a-tab-pane>
                                                                <a-tab-pane tab="Kompiuterinė tomografija" key="2" v-on:click="Check()">
                                                                </a-tab-pane>
                                                                <a-tab-pane tab="Magnetinis rezonansas" key="3" v-on:click="Check()">
                                                                </a-tab-pane>
                                                            </a-tabs>
                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Laboratorija" key="2" forceRender v-on:click="Check()">
                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Patologija" key="3">

                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Echoskopija" key="4">

                                                        </a-tab-pane>
                                                    </a-tabs>
                                                </a-collapse-panel>
                                                <a-collapse-panel header="Atsakymai" key="2" :disabled='false'>
                                                    <a-tabs defaultActiveKey="1" :size="size" >
                                                        <a-tab-pane tab="Radiologija" key="1">
                                                            <a-tabs defaultActiveKey="1" type="card" >
                                                                <a-tab-pane tab="Rentgenas"  key="1">
                                                                    <rengenas></rengenas>
                                                                </a-tab-pane>
                                                                <a-tab-pane tab="Kompiuterinė tomografija" key="2" >
                                                                </a-tab-pane>
                                                                <a-tab-pane tab="Magnetinis rezonansas" key="3" >
                                                                </a-tab-pane>
                                                            </a-tabs>
                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Laboratorija" key="2" forceRender>
                                                            Laboratorijos turinys
                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Patologija" key="3">

                                                        </a-tab-pane>
                                                        <a-tab-pane tab="Echoskopija" key="4">

                                                        </a-tab-pane>
                                                    </a-tabs>
                                                </a-collapse-panel>
                                            </a-collapse>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <v-card height="auto" width="100" style="right:0px; float:right; margin-left:auto; margin-right: 5px;">
                            <v-navigation-drawer
                                absolute
                                permanent
                                right
                            >
                                <v-list dense>
                                    <v-list-item
                                        v-for="item in items"
                                        :key="item.title"
                                        @click=""
                                    >
                                        <v-list-item-content style="height: 50px;">
                                            <v-list-item-title @click="isTyrimaiActive = !isTyrimaiActive" style="font-size:14px; height:20px;">{{ item.title }}</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-navigation-drawer>
                        </v-card>



                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-info pull-left" v-on:click="Action(1)">Tvirtinti įrašytus duomenis </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default pull-right" v-on:click="Action(2)">Atsaukti įrašus </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-2 mb-2">
                        <i class="fa fa-hospital-o fa-lg"></i>
                        <h3 class="box-title">F025</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row" style="display: block!important;">
                      <f025></f025>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PickedDiagnosis from '../../Constants/SavedDiagnosis.Constants'
    import {LinksFunction} from "../../components/ReadLinkInfo";
    import axios from  'axios'
    import kulFunctions from '../../Constants/KulFunctions'
    import Rentgenas from '../../components/f025/Rentgenas'
    import f025 from '../../components/f025/MainInformation'


    export default {
        data() {
            return {
                items: [
                    { title: 'Tyrimai' },
                ],
                isTyrimaiActive: false,
                tekstas:'asd',
                option: '',
                ChoseDiagnosis: '',
                TypeOffMedicine: '',
                AnamnezeModel: '',
                ApziurosRezultataiModel: '',
                TyrimuPlanasModel: '',
                LigosEigaModel: '',
                GydymoRekomendacijosModel: '',
                collapsed: false,
                KomponentoJuosta: 'col-md-9',
                LiguJuosta: 'col-md-3',
                Push:true,
                PatientPC:'',
                PatientHistory:'',
                size:'large',
                informacija:[{ diagnosis: 'gel', 'key':1}],
                SelectedDiagnosis:[],
                columns : [{ title: 'Diagnozė', dataIndex: 'diagnosis', key: 'diagnosis' }],
                spinning: true,
                Exists: true,
                Selected:[],
                Speciality:[],
                Sending:'',
                Explanation:'',
                visible: false,
                condition: false,
                deleting: '',
                test:'',
                instanceid:'',
                titlepop:'',
                isSelected:false,
                SpecialityTitle:[],
                reason:'',
                next:true,
                wasAlreadySend:false,
            }
        },
        components:{
            'rengenas':Rentgenas,
            'f025':f025,
        },
        methods:{
            AutoSave(input){

                if (input.data=='.'){
                    if(this.next){
                        var url = '/api/getCacheEpicrisis/'+this.instanceid.toString()
                        axios.put(url,{
                            anamneze:this.AnamnezeModel,
                            Apziuros:this.ApziurosRezultataiModel,
                            Tyrimo:this.TyrimuPlanasModel,
                            Ligos:this.LigosEigaModel,
                            Rekomendacijos:this.GydymoRekomendacijosModel,
                            id:this.instanceid,

                        })
                            .then(response=>{

                                console.log('gerai');
                            });
                        this.next = false;
                    }

                }else{
                    this.next = true;
                }

            },
            AutoSaveBtn(){
                var url = '/api/getCacheEpicrisis/'+this.instanceid.toString()
                axios.put(url,{
                    anamneze:this.AnamnezeModel,
                    Apziuros:this.ApziurosRezultataiModel,
                    Tyrimo:this.TyrimuPlanasModel,
                    Ligos:this.LigosEigaModel,
                    Rekomendacijos:this.GydymoRekomendacijosModel,
                    id:this.instanceid,

                })
                    .then(response=>{

                        console.log('gerai');
                    });
            },

            Read(){
                var pc = LinksFunction(this.$route.query,'personal-code');
                var name = LinksFunction(this.$route.query,'username');
                var docid = LinksFunction(this.$route.query,'doctorID');

            axios.get('/api/getCacheEpicrisis',{params:{pc:pc,Username:name,doctorID:docid}})
                .then(response=>{
                    var index = response.data;
                    if (index.length>0){
                        this.CopyAll(response.data);
                    }else{
                        this.CreateNew()
                    }
                })


            },
            CreateNew(){
                var pc = LinksFunction(this.$route.query,'personal-code');
                var name = LinksFunction(this.$route.query,'username');
                var docid = LinksFunction(this.$route.query,'doctorID');
                axios.post('/api/getCacheEpicrisis',{PC:pc,Username:name,doctorID:docid}).then(response=>{
                    this.CheckNewInstance();
                })
            },
            CheckNewInstance(){
                var pc = LinksFunction(this.$route.query,'personal-code');
                var name = LinksFunction(this.$route.query,'username');
                var docid = LinksFunction(this.$route.query,'doctorID');

                axios.get('/api/getCacheEpicrisis',{params:{pc:pc,Username:name,doctorID:docid}})
                    .then(response=>{
                        var temp = response.data;
                        this.instanceid = temp[0].id;
                        return this.instanceid;
                    })
            },
            CopyAll(data){
                this.instanceid= data[0].id;
                this.AnamnezeModel= data[0].ANAMNEZE;
                this.ApziurosRezultataiModel = data[0].APZIUROS_REZULTATAI;
                this.TyrimuPlanasModel= data[0].TYRIMU_PLANAS;
                this.LigosEigaModel = data[0].LIGOS_EIGA;
                this.GydymoRekomendacijosModel= data[0].GYDYMO_REKOMENDACIJOS;

            },
            getSpeciality(query){
                axios.get('/api/getSpeciality', {params :{name:query} })
                    .then(response=>{
                        this.SpecialityTitle= response.data;
                        return this.SpecialityTitle
                    })
            },
            Check(){
                var temp=[];
                this.condition= false;
                this.deleting= '';
                var deletethis= [];
                this.SelectedDiagnosis = PickedDiagnosis.SavedDiagnosis
                if (this.Selected.length>0){
                    for (var index=0; index< this.SelectedDiagnosis.length;index++){
                        temp.push(this.SelectedDiagnosis[index].code)
                    }
                    for (var index=0; index<this.Selected.length;index++){
                        if (!(temp.includes(this.Selected[index].code))){
                            deletethis.push(this.Selected[index].code);
                            this.deleting= ''+this.Selected[index].code +' ' + this.deleting +' ';
                        }
                    }
                    for (var index=0; index< deletethis.length;index++){
                        for (var index2=0; index2< this.Selected.length;index2++){
                            if(deletethis[index]==this.Selected[index2].code){
                                this.Selected.splice(index2,1);
                            }
                        }
                    }
                    if (this.deleting!=''){
                        this.condition = false;
                        var message = 'Siuntimo diagnozė: '+this.deleting+' buvo pašalinta iš siuntimo diagnozių kadangi ji buvo pašalinta iš vizito diagnozių sąrąšo';
                        this.$notification.open({
                            message: 'Perspėjimas',
                            description: message,
                            showIcon: true,
                            type: 'warning'
                        });
                        var selected='';
                        for (var index=0; index< this.Selected.length; index++){
                            selected+= this.Selected[index].code+ ' ; '
                        }
                        this.titlepop = 'Jūsu siuntimo diagnozės: '+ this.deleting+' buvo pašalintos, nes jos buvo nuimtos iš ligos atvėjo ligų ar siųsite siuntimą su likusiomis ligomis : '+  selected;
                        this.condition= true
                    }
                }

            },
            Send(){
                //test
                var check =false
                var temp ='';
                var temp2='';
                if (this.Selected.length>0){
                    if (this.Sending!=''){
                        if(this.Speciality.length>0){
                            if(this.reason!=''){
                                for (var index = 0; index<this.Selected.length;index++){
                                    temp = this.Selected[index].code.toString() + ';'+temp
                                }
                                for (var index2 = 0; index2<this.Speciality.length;index2++){
                                    temp2 = this.Speciality[index2].display_name.toString() + ';'+temp2
                                }
                                axios.get('/api/SendMedicalPost', {params:{PC:LinksFunction(this.$route.query,'personal-code'),username:LinksFunction(this.$route.query,'username')}})
                                    .then(response=>{
                                        var tem = response.data;
                                        if (tem.length==0){
                                            this.SendPosting(temp,temp2)
                                        }else{
                                            for (var index=0;index<tem.length;index++){
                                                if (tem[index].REQUIRED_SPECIALITY==(this.Speciality[0].display_name+';')){
                                                    check= true;
                                                }
                                            }
                                            if (check){
                                                this.Notification(3,'Pacientas turi siuntimą nurodytam specialistui')
                                            }else{

                                                this.SendPosting(temp,temp2)}
                                        }
                                    });
                            }else{this.Notification(3,'Privalote įrašyti siuntimo priežastį')}
                        }else{this.Notification(3,'Privalote nurodyti specialistą')}
                    } else{this.Notification(3,'Privalote parašyti koks siuntimas')}
                }else{this.Notification(3,'Privalote nurodyti siuntimo diagnozę')}
            },
            SendPosting(temp,temp2){
                axios.post('/api/SendMedicalPost', {
                    SENDING: this.Sending,
                    POSTING_DIAGNOSIS: temp,
                    REQUIRED_SPECIALITY: temp2,
                    REASON: this.reason,
                    PERSON_CODE:LinksFunction(this.$route.query,'personal-code'),
                    PATIENT_NAME:LinksFunction(this.$route.query,'patient-first-name'),
                    SENDING_COMPANY:'Ligoninė',
                    SENDING_DOCTOR:LinksFunction(this.$route.query,'username'),
                })
                    .then(response=>{
                            this.Notification(4,'Siuntimas išsiųstas')
                        }
                    )
                    .catch(error => {
                        this.Notification(3, 'Siuntimas neišsisiunte: '+error)
                    })
            },
            handleVisibleChange (visible) {
                if (!visible) {
                    this.visible = false;
                    return
                }
                // Determining condition before show the popconfirm.
                this.Check();
                if (this.condition ) {
                    this.visible = true
                } else {
                    this.confirm() // next step

                }
            },
            confirm(){
                this.visible = false;
                this.Send();
            },
            cancel(){
                this.visible = false

            },
            GetList(){
                this.SelectedDiagnosis = PickedDiagnosis.SavedDiagnosis;
                this.Check(1);
            },
            Import(Item){
                this.Check();
                this.AnamnezeModel=   Item.anamnesis;
                this.ApziurosRezultataiModel=  Item.objective_finding;
                this.TyrimuPlanasModel=  Item.consultation;
                this.LigosEigaModel= Item.illness_progress;
                this.GydymoRekomendacijosModel= Item.regime_recommentation;
                this.AutoSaveBtn();
            },
            GetDiagnosisHistory(){
                this.PatientPC = LinksFunction(this.$route.query, 'personal-code');
                axios.get('/api/GetHistory', {params :{CODE:this.PatientPC} })
                    .then(response => {
                        console.log('patienthistory atsakymas: ' + response.data)
                        this.PatientHistory = response.data;
                        this.spining(this.PatientHistory);
                        return  this.PatientHistory;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
        Action(input){
            switch (input) {
                case 1: //uzsaugojimas-->
                    var VisitId = LinksFunction(this.$route.query, 'visit-number');
                    if (PickedDiagnosis.SavedDiagnosis != ''){
                    for (var index =0; index< PickedDiagnosis.SavedDiagnosis.length;index++){
                        var SiceknessCode = PickedDiagnosis.SavedDiagnosis[index].code ;
                        var SicknessType = PickedDiagnosis.SavedDiagnosis[index].type;
                        var SicknessTime = PickedDiagnosis.SavedDiagnosis[index].time;
                        axios.post('./api/SendSelected_Diagnosis',{
                            visitid:VisitId,
                            diagnosiscode:SiceknessCode,
                            diagnosistype:SicknessType,
                            diagnosistime:SicknessTime,
                        })
                            .catch(error => {
                            this.Notification(3, 'Diagnozes neisisiunte: '+error)
                        })
                    }
                        axios.post('./api/SendInformation', {
                            VISITID: VisitId,
                            ANAMNEZE: this.AnamnezeModel,
                            APZIUROS_REZULTATAI: this.ApziurosRezultataiModel,
                            TYRIMU_PLANAS: this.TyrimuPlanasModel,
                            LIGOS_EIGA: this.LigosEigaModel,
                            GYDYMO_REKOMENDACIJOS: this.GydymoRekomendacijosModel,
                        })
                            .then(response=>{
                                    this.Notification(1,' pateikti duomenys isiusti'   )
                            }
                            )
                            .catch(error => {
                            this.Notification(3, 'aprasai neisisiunte kodas: '+error)
                        })
                    }else{
                        this.Notification(2,'nepasirinkote diagnoziu')
                    }
                break;

                case 2: //istrynimas pasirinkciu
                    this.AnamnezeModel=   kulFunctions.delete(this.AnamnezeModel);
                    this.ApziurosRezultataiModel=  kulFunctions.delete(this.ApziurosRezultataiModel);
                    this.TyrimuPlanasModel=  kulFunctions.delete(this.TyrimuPlanasModel);
                    this.LigosEigaModel= kulFunctions.delete(this.LigosEigaModel);
                    this.GydymoRekomendacijosModel= kulFunctions.delete(this.GydymoRekomendacijosModel);
                    this.Notification(1,'panaikinti');
                    break;
            }
            this.Check();
        },
            spining(data){
                if(data.length>1){
                    this.Exists = true;
                }else{
                    this.Exists = false;
                }
                this.spinning = false;
            },

            Click(type, info){
                this.Check();
                switch (type) {
                    case 1:
                        this.AnamnezeModel=   info;
                        break;
                    case 2:
                        this.ApziurosRezultataiModel=  info;
                        break;
                    case 3:
                        this.TyrimuPlanasModel=  info;
                        break;
                    case 4:
                        this.LigosEigaModel= info;
                        break;
                    case 5:
                        this.GydymoRekomendacijosModel= info;
                        break;
                }
                this.AutoSaveBtn();
            },
            Notification(type, code) {
                this.$notification.config({
                    placement: 'topRight',
                    top: '50px'

                });
                if (type == 1) {
                    var message = 'Jusu ivesti duomenys yra ' + code;
                    this.$notification.open({
                        message: 'Pavyko',
                        description: message,
                        showIcon: true,
                        type: 'success'

                    });
                } else if(type==2) {
                    var error = 'Jus ' + code;
                    this.$notification.open({
                        message: 'Nepavyko',
                        description: error,
                        showIcon: true,
                        type: 'error'

                    });
                }else if(type==3) {
                    var error2 = code;
                    this.$notification.open({
                        message: 'Nepavyko',
                        description: error2,
                        showIcon: true,
                        type: 'error'
                    });
                }else if(type==4){
                    var error3 = code;
                    this.$notification.open({
                        message: 'Pavyko',
                        description: error3,
                        showIcon: true,
                        type: 'success'
                    });
                }

            },
            toggleCollapsed () {
                this.collapsed = !this.collapsed
            },
        },
        beforeMount() {
            this.GetDiagnosisHistory();
            this.Read();
        },
    }
</script>
<style scoped>
    .tyrimaiActive {

        display: block;
        left: 0px;
        -webkit-transition: left 1s;
    }
    .tyrimaiInactive {
        display: none;
        left:1000px;
        -webkit-transition: left 2s;

    }
    .tyrimaiButtonInactive {
        display: none;
    }
    .tyrimaiButtonActive {
        display: block;
    }

</style>
