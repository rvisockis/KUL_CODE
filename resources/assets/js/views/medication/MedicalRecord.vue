<template>
<div>
    <div class="col-md-12">
        juodrastis: {{juodrastis}}
        <div class="box">
            <div class="box-header with-border">
                <div class="col-md-2 mb-2">
                    <i class="fa fa-plus-square fa-lg"></i>
                    <h3 class="box-title">DIAGNOZĖS </h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            PASKUTINIŲ VIZITŲ METU NUSTATYTOS DIAGNOZĖS
                        </h4>
                        <button  v-for="items in PatientHistory" v-on:click="ToggleClass( items.epicrisis_diagnosis_code, items.appointed_diagnosis_text)" style="margin:2px"   v-bind:class="[Push, Class[items.rn-1]]"  :title="items.appointed_diagnosis_text"   type="button" id="Diagnosis"  class="  btn-lg btn  "  >{{items.epicrisis_diagnosis_code}}<br> {{items.sickness_startdate}}<br></button>
                    </div>
                    <div class="col-md-12" id="laikinas">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            VIZITO DIAGNOZĖS
                        </h4>
                    </div>
                </div>
                <multiselect v-model="ButtonModel"  label="name" track-by="name" placeholder="Įveskite tris simbolius" open-direction="bottom"  :options="list" :multiple="true" :searchable="true"  :internal-search="false" :clear-on-select="true" :close-on-select="true" :options-limit="300" :limit="10"  :max-height="600" :show-no-results="true" :show-labels="false" :taggable="false"  @select="ChangeClass" @search-change="GetList" @remove="Delete" >
                    <template slot="option" slot-scope="props"><div class="option__desc"><span class="option__small">{{ props.option.code}} {{ props.option.title}}</span></div></template>
                    <template slot="tag" slot-scope="{ option, remove }">
                        <span class="multiselect__tag"><span>
                            <a-popover > <div slot="content">Ligos tipas</div>
                                <a-select slot="content" v-model="option.type" @change="ChangeType(option.code, option.type)" >
                                    <a-select-option  value="Pagrindinis" >Pagrindinis</a-select-option>
                                    <a-select-option  value="Lydinti">Lydinti</a-select-option>
                                    <a-select-option  value="Komplikacija">Komplikacija</a-select-option>
                                </a-select>
                                <div slot="content">Ligos tipas</div>
                                <a-radio-group slot="content" :defaultValue="0" v-model="option.time">
                                    <a-radio value="0"><a-popover>0<div slot="content"><strong>Anksčiau registruota lėtinė liga</strong></div> </a-popover></a-radio>
                                    <a-radio value="+"> <a-popover>+<div slot="content"><strong>Ūminės ir pirmą kartą nustatytos ligos</strong></div></a-popover></a-radio>
                                    <a-radio value="-"><a-popover>-<div slot="content"><strong>Pirmą kartą einamaisiais metais registruojamos lėtinės ligos, nustatytos anksčiau</strong></div></a-popover></a-radio>
                                </a-radio-group>
                                <div slot="content">Klinikinė diagnozė</div>
                                <a-textarea slot="content" :autosize="{ minRows: 1, maxRows: 20 }" v-model="option.ClinicalName" v-on:input="ClinicalCheck"></a-textarea>
                               {{option.letter}} {{option.time}} {{ option.code }}
                                <div slot="title">{{ option.code }}</div>
                            </a-popover>
                        </span>
                            <span class="multiselect__tag-icon" @click="deletetag(option)"></span>
                        </span>
                    </template>
                </multiselect>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8">
                        <button class="btn btn-info pull-left"  v-on:click="Send()">Tvirtinti pasirinktas diagnozes </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default pull-right" v-on:click="Remove()" >Istrinti pasirinkimus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--cia-->


<!--    trint nx-->
    </div>
</template>
<script>
    import {LinksFunction} from "../../components/ReadLinkInfo";
    import axios from 'axios';
    import Option from "ant-design-vue/es/vc-select/Option";
    import SavedDiagnosis from '../../Constants/SavedDiagnosis.Constants'
    import KulFunctions from '../../Constants/KulFunctions'
    import ARadioGroup from "ant-design-vue/es/radio/Group";
    import ATextarea from "ant-design-vue/es/input/TextArea";
    // import {Start} from "/resources/assets/js/"
    import {serverBus} from "../../app";

    export default {
        components: {ATextarea, ARadioGroup, Option},
        props: {
            juodrastis: {
                type: Boolean
            },
        },
        data(){
            return {
                First: true,
                Main:'',
                PatientPC:'',
                PatientInformation: '',
                PatientHistory:'',
                FirstTime: true,
                Push: true,
                Class:[],
                ButtonModel : [],
                InputModel:'',
                list : [],
                fakelist:[],
                instanceid:'',
                pc: LinksFunction(this.$route.query,'personal-code'),
                name: LinksFunction(this.$route.query,'username'),
                docid: LinksFunction(this.$route.query,'doctorID'),
                SendModel:[],
                isLoading: false,
                informacija:[{ diagnosis: 'gel', 'key':1}],
            }
        },
methods : {
    AutoSave(){
        var SendingTime = '';
        var SendingDiagnosis = '';
        var SendingType = '';
        var SendingTitle = '';
        var ClinicalName = '';
        for (var index =0;index<this.ButtonModel.length;index++){
            SendingDiagnosis= this.ButtonModel[index].code.toString()+';'+SendingDiagnosis;
            SendingTime= this.ButtonModel[index].letter.toString()+';'+SendingTime;
            SendingType= this.ButtonModel[index].time.toString()+';'+SendingType;
            SendingTitle= this.ButtonModel[index].name.toString()+';'+SendingTitle;
            if (this.ButtonModel[index].ClinicalName!=undefined){
                ClinicalName = this.ButtonModel[index].ClinicalName.toString()+';'+ClinicalName;
            }else{
                ClinicalName =';'+ClinicalName
            }
        }
        var url = '/api/getCacheDiagnosis/'+this.instanceid.toString()
        axios.put(url,{
            Diagnosis:SendingDiagnosis,
            Time:SendingTime,
            Type:SendingType,
            Title:SendingTitle,
            ClinicalName:ClinicalName,
            id:this.instanceid,

        })
            .then(response=>{

            })
    },
    ClinicalCheck(input){
        if (input.data=='.'){
            this.AutoSave();
        }
    },
    Read(){
        axios.get('/api/getCacheDiagnosis',{params:{pc:this.pc,Username:this.name,doctorID:this.docid}})
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

        axios.post('/api/getCacheDiagnosis',{PC:this.pc,Username:this.name,doctorID:this.docid}).then(response=>{
            this.CheckNewInstance();
        })
    },
    CheckNewInstance(){
        axios.get('/api/getCacheDiagnosis',{params:{pc:this.pc,Username:this.name,doctorID:this.docid}})
            .then(response=>{
                var temp = response.data;
                this.instanceid = temp[0].id;
                return this.instanceid;
            })
    },
    CopyAll(data){
        this.instanceid=data[0].id
        console.log(data)
        if (data[0].time!=null){var timedata = data[0].time.split(";");}
        if (data[0].type!=null){var typedata = data[0].type.split(";");}
        if (data[0].diagnosis!=null){var diagnosisdata= data[0].diagnosis.split(";");}
        if (data[0].title!=null){var titleisdata= data[0].title.split(";");}
        var ClinicalName= data[0].ClinicalName.split(";");


        for(var index = timedata.length-1; index>-1;index--){
            if ((timedata[index]!='')&&(typedata[index]!='')&&(diagnosisdata[index]!='')){
                if(timedata[index]=='P'){
                    this.ButtonModel.push({"name":titleisdata[index], "code": diagnosisdata[index],type:'Pagrindinis', letter:'P',time:typedata[index],ClinicalName:ClinicalName[index] })
                    console.log(ClinicalName[index])
                                    }
                if(timedata[index]=='K'){
                    this.ButtonModel.push({"name":titleisdata[index], "code": diagnosisdata[index],type:'Komplikacija', letter:'K',time:typedata[index],ClinicalName:ClinicalName[index]})
                    console.log(ClinicalName[index])
                }
                if(timedata[index]=='L'){
                    this.ButtonModel.push({"name":titleisdata[index], "code": diagnosisdata[index],type:'Lydinti', letter:'L',time:typedata[index],ClinicalName:ClinicalName[index]})
                    console.log(ClinicalName[index])
                }
            }
        }
        if (this.First){
            for (var index=0;index<this.ButtonModel.length;index++){
                if (this.ButtonModel[index].letter=='P'){
                    this.Main= this.ButtonModel[index].code
                }
            }
            this.First= false;
        }
        this.Class=KulFunctions.FirstTime(this.PatientHistory,this.Class,this.FirstTime);
        this.FirstTime = false;
        for (var index=0;index<this.ButtonModel.length;index++){
            this.Class= KulFunctions.CreateChangeClass(this.ButtonModel, this.Class,this.ButtonModel[index].code);
        }

        this.Save()
    },
    deletetag(input){
        if(input.code==this.Main){
            if(this.ButtonModel.length>1){
                if(this.ButtonModel[0].type!='Pagrindinis'){
                    this.ButtonModel[0].type='Pagrindinis'
                    this.ButtonModel[0].letter='P';
                    this.Main = this.ButtonModel[0].code;
                }else{
                    this.ButtonModel[1].type='Pagrindinis';
                    this.ButtonModel[1].letter='P';
                    this.Main = this.ButtonModel[1].code;
                }
            }

        }
        this.Class = KulFunctions.DeleteClass(input, this.Class,1);
        this.list = [];
        this.Class= KulFunctions.ChangeClass(this.ButtonModel, this.Class,input);
        for (var index= 0; index<this.ButtonModel.length;index++){
            if (input.code==this.ButtonModel[index].code){
                this.ButtonModel.splice(index,1)
            }
        }
        this.AutoSave();
        this.Save()},

    GetPatientInformation(){
        this.PatientPC = LinksFunction(this.$route.query, 'personal-code');
         axios.get('/api/getPatient',{params:{CODE:this.PatientPC}})
                .then( response =>{
                    this.PatientInformation = response.data;
                    return this.PatientInformation;

                });

        },
    GetDiagnosisHistory(){

        this.PatientPC = LinksFunction(this.$route.query, 'personal-code');
        axios.get('/api/getPatientHistory', {params :{CODE:this.PatientPC} })
                .then(response => {
                    this.PatientHistory = response.data;
                    var a;
                    for( a=0 ; a < 11;a++){
                        this.Class.push(['','btn-danger']);

                    }
                    this.Class=KulFunctions.FirstTime(this.PatientHistory,this.Class,this.FirstTime);
                    this.FirstTime = false;
                    for (var index=0;index<this.ButtonModel.length;index++){
                        this.Class= KulFunctions.CreateChangeClass(this.ButtonModel, this.Class,this.ButtonModel[index].code);
                    }
                    this.Read()
                    return  this.PatientHistory;
                })
                .catch(error => {
                    console.log(error)
                });
    },
    GetList(query){
              this.list = [];
              axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                  .then(response => {
                      this.fakelist = response.data;
                      if (this.ButtonModel.length == 0){
                          for (var a =0 ; a<this.fakelist.length ; a++ ){
                              this.list.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE,type:'Pagrindinis', letter:'P',time:0, clinicalname:''})   ;
                          }
                      }else{
                          for (var a =0 ; a<this.fakelist.length ; a++ ){
                              this.list.push({name:this.fakelist[a].TITLE, code:this.fakelist[a].CODE, title:this.fakelist[a].TITLE,type:'Lydinti', letter:'L',time:0,clinicalname:''})   ;
                          }
                      }
                      return  this.list;
                  })
                  .catch(error => {
                      console.log(error)
                  });
        this.Save();
    },
    ChangeType(SicknessCode,SicknessType){
        if (this.First){
            this.Main = this.ButtonModel[0].code;
            this.First= false;
        }
      //  jei nauja pakeiciama i pagrindine
      for (var index=0; index < this.ButtonModel.length;index++){
          if (this.ButtonModel[index].code== SicknessCode){
              if(this.ButtonModel[index].type=='Pagrindinis'){
                  if (this.ButtonModel[index].code!= this.Main){
                      for (var index2=0; index2 < this.ButtonModel.length;index2++) {
                          if ((this.ButtonModel[index2].type=='Pagrindinis')&&(this.ButtonModel[index2].code==this.Main)){
                              this.ButtonModel[index2].type='Lydinti';
                              this.ButtonModel[index2].letter='L';
                          }
                      }
                      this.Main= this.ButtonModel[index].code;
                      this.ButtonModel[index].letter='P';
                  }
              }
          }
          //jei i bet ka kitka pakeiciama
          if (this.ButtonModel[index].type!='Pagrindinis'){
              if (this.ButtonModel[index].code==SicknessCode){
                  if (this.ButtonModel[index].code!= this.Main){
                      if (this.ButtonModel.length >1){
                          if (SicknessType =="Lydinti"){
                              this.ButtonModel[index].letter='L';
                          }else{
                              this.ButtonModel[index].letter='K';
                          }
                      }else{
                          this.ButtonModel[index].type='Pagrindinis';
                      }
                  }else {
                      this.ButtonModel[index].type='Pagrindinis';
                  }
              }
          }
      }
        this.Save();
      this.AutoSave();


    },
    ToggleClass(SicknessCode, SicknessName) {
        this.Push = false;
        this.Class=KulFunctions.FirstTime(this.PatientHistory,this.Class,this.FirstTime);
        this.FirstTime = false;
        if (this.ButtonModel.length ==0){
            this.Main = SicknessCode;
        }
        var check = true;
        this.Class= KulFunctions.ToggleClass(this.ButtonModel,this.Class,SicknessCode);
        for (var FindIndex = 0; FindIndex<this.ButtonModel.length; FindIndex++){
            if (SicknessCode == this.ButtonModel[FindIndex].code){
                if(SicknessCode==this.Main){
                    if (this.ButtonModel.length>1){
                        if(this.ButtonModel[0].type!='Pagrindinis'){
                            this.ButtonModel[0].type='Pagrindinis'
                            this.ButtonModel[0].letter='P';
                            this.Main = this.ButtonModel[0].name;
                        }else{
                            this.ButtonModel[1].type='Pagrindinis';
                            this.ButtonModel[1].letter='P';
                            this.Main = this.ButtonModel[1].name;
                        }
                    }
                 }
                this.ButtonModel.splice(FindIndex,1);
                check = false
            }
        }
        if (check){
            if(this.ButtonModel.length ==0){
                this.ButtonModel.push({"name":SicknessName, "code": SicknessCode,type:'Pagrindinis', letter:'P', time:'0',clinicalname:''});
            }else{
                this.ButtonModel.push({"name":SicknessName, "code": SicknessCode,type:'Lydinti', letter:'L',time:0,clinicalname:''});
            }

        }
        check = false;
        this.Save();
        this.AutoSave();
        this.Push = true;
    },
    ChangeClass(Code){
        console.log('suldu ',Code);
        if (Code.type=='Pagrindinis'){
            if (this.Main== Code.code){
                if (this.ButtonModel.length>1){
                    if(this.ButtonModel[0].type!='Pagrindinis'){
                        this.ButtonModel[0].type='Pagrindinis'
                        this.ButtonModel[0].letter='P';
                        this.Main = this.ButtonModel[0].code;
                    }else{
                        this.ButtonModel[1].type='Pagrindinis';
                        this.ButtonModel[1].letter='P';
                        this.Main = this.ButtonModel[1].code;
                    }
                }

            }
            this.Main = Code.name;
        }
        this.Class=KulFunctions.FirstTime(this.PatientHistory,this.Class,this.FirstTime);
        this.FirstTime = false;
        this.Class= KulFunctions.ChangeClass(this.ButtonModel, this.Class,Code);
        console.log(Code);
        this.Save();
         this.list = [];
    },
    Delete(Code){
        if(Code.name==this.Main){
            if(this.ButtonModel.length>1){
                if(this.ButtonModel[0].type!='Pagrindinis'){
                    this.ButtonModel[0].type='Pagrindinis'
                    this.ButtonModel[0].letter='P';
                    this.Main = this.ButtonModel[0].code;
                }else{
                    this.ButtonModel[1].type='Pagrindinis';
                    this.ButtonModel[1].letter='P';
                    this.Main = this.ButtonModel[1].code;
                }
            }

        }
        this.Class = KulFunctions.DeleteClass(Code, this.Class,1);
        this.Save();
        this.list = [];
    },
    Send(){
        this.SendModel= [];
        if (this.ButtonModel !=''){
            SavedDiagnosis.Delete();
            SavedDiagnosis.save(this.ButtonModel);
            this.Notification(1,'patvirtintos')
        }else {
            var error = ' nepasirinkote jokiu ligu';
            this.Notification(0,error);
        }
        this.AutoSave();
    },
    Save(){
        this.SendModel= [];
            SavedDiagnosis.Delete();
            SavedDiagnosis.save(this.ButtonModel);


    },
    Remove(){
        SavedDiagnosis.Delete();
        this.ButtonModel = [];
        this.Main='';
        this.First= true;
        this.Class = KulFunctions.DeleteClass(0,this.Class,2)
        this.Notification(1,'panaikintos');
        this.Save();
        this.AutoSave();
    },
    Notification(type, code){
        this.$notification.config({
            placement: 'topRight',
            top: '50px'

        });
        if (type==1){
            var message = 'Jusu pasirinktos diagnozes ' +code
            this.$notification.open({
                message: 'Pavyko',
                description: message,
                showIcon: true,
                type: 'success'

            });
        }else{
            var error = 'Jus'+ code;
            this.$notification.open({
                message: 'Nepavyko',
                description: error,
                showIcon: true,
                type: 'error'

            });
        }

    }
    },
     beforeMount() {
       this.GetPatientInformation();
       this.GetDiagnosisHistory();
       // this.Read();
    },
        created() {
            serverBus.$on('selectedPage', (juodrastis) => {
                this.juodrastis = juodrastis;
            })
        },
        mounted() {
},

    }

</script>
<style>

</style>
