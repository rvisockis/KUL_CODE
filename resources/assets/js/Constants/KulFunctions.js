import moment from 'moment';
export default {
    save(){
    },
    delete(input){
        input = '';
        return input ;
    },
    //BadCode yra kodas kuris yra panaikinamas AllClass visa ateinanti mygtuku klase Index yra indesas kuria funkcija atlikti naudojama MedicalRecord komponente case 2 yra visu mygtuku busenu atsatymas i pradine busena
    DeleteClass(BadCode,AllClass,Index ){
        switch (Index) {
            case 1:
                for (var a =0; a< AllClass.length;a++){
                    if (AllClass[a][0]==BadCode.code){
                        AllClass[a][1]='btn-danger'
                    }
                }
            return AllClass;

            case 2:
                for (var b=0 ; b< AllClass.length;b++){
                    AllClass[b][1]='btn-danger'
                }
             return AllClass;
        }

    },
    ChangeClass(ButtonModel, Class,Code) {
        var checking = false;
        for (var a = 0; a < ButtonModel.length; a++) {
            if (ButtonModel[a].code == Code.code) {
                checking = true;
            }
        }
        if (checking) {
            for (var a = 0; a < Class.length; a++) {
                if (Class[a][0]== Code.code) {
                    Class[a][1] = 'btn-danger';
                }
            }
        } else {
            for (a = 0; a < Class.length; a++) {
                if (Class[a][0] == Code.code) {
                    Class[a][1] = 'btn-success';
                }
            }
        }
        checking = false;
        return Class
    },
    CreateChangeClass(ButtonModel, Class,Code) {
        var checking = false;
        for (var a = 0; a < ButtonModel.length; a++) {
            if (ButtonModel[a].code == Code) {
                checking = true;
            }
        }
        if (!checking) {
            for (var a = 0; a < Class.length; a++) {
                if (Class[a][0]== Code) {
                    Class[a][1] = 'btn-danger';
                }
            }
        } else {
            for (a = 0; a < Class.length; a++) {
                if (Class[a][0] == Code) {
                    Class[a][1] = 'btn-success';
                }
            }
        }
        checking = false;
        return Class
    },
    ToggleClass(ButtonModel,Class,SicknessCode){
        var checking = false;
        for (var a = 0; a<ButtonModel.length; a++){
            if (ButtonModel[a].code == SicknessCode){
                checking= true;
            }
        }
        if (checking) {
            var FindIndex;
            for (FindIndex = 0; FindIndex<Class.length;FindIndex++){
                if (Class[FindIndex][0]== SicknessCode){
                    Class[FindIndex][1]= 'btn-danger';
                }
            }
        }else{
            for (FindIndex = 0; FindIndex<Class.length;FindIndex++){
                if (Class[FindIndex][0]== SicknessCode){
                    Class[FindIndex][1]= 'btn-success';
                }
            }
        }
        checking=false;
        return Class;
    },
    FirstTime(PatientHistory,Class,FirstTime){
        if (FirstTime) {
            for (var Length = 0; Length < PatientHistory.length; Length++) {
                Class[Length][1] = 'btn-danger';
                Class[Length][0] = PatientHistory[Length].epicrisis_diagnosis_code;
            }
        }
        return Class
    },
    CheckDay(date, today){
        var CheckedTxt;
        var CheckedDay;
        var IsToday;
        var answer = [];
        var checkm=moment(date).format( 'M');
        switch (checkm) {
            case '1': CheckedTxt = 'Sausio';break;
            case '2': CheckedTxt = 'Vasario';break;
            case '3': CheckedTxt=  'Kovo';break;
            case '4': CheckedTxt = 'Balandžio';break;
            case '5': CheckedTxt = 'Gegužės';break;
            case '6': CheckedTxt = 'Birželio';break;
            case '7': CheckedTxt = 'Liepos';break;
            case '8': CheckedTxt = 'Rugpjūčio';break;
            case '9': CheckedTxt = 'Rugsėjo';break;
            case '10': CheckedTxt = 'Spalio'; break;
            case '11': CheckedTxt = 'Lapkričio'; break ;
            case '12': CheckedTxt = 'Gruodžio'; break;
        }
        IsToday= date;
        CheckedDay = moment(date).format( 'DD');
        if(IsToday==today){
            IsToday = '(šiandien)'
        }else{
            IsToday=''
        }
        answer = [];
        answer.push({IsToday: IsToday, daytxt: CheckedTxt, Dayname:CheckedDay})
        return answer;
    }
}