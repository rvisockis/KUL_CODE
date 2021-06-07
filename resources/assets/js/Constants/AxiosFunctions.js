import axios from  'axios';
export default {
     GetList(query){
         var fakelist = [];
         var list;
         // try{
         //     let ats =  axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
         //     list=ats
         // }catch(error) {
         //     list = false;
         //     console.log(error);
         // };
         //
         // console.log(ats.data);
         // return list


            axios.get('/api/getDiagnosisList',{params: {CODE:query}} )
                 .then(response => {
                     fakelist = response.data;
                     //console.log(fakelist);
                     // for (var a =0 ; a<fakelist.length ; a++ ){
                     //     list.push({"name":fakelist[a].epicrisis_diagnosis_code, "code":fakelist[a].epicrisis_diagnosis_code})   ;
                     // }
                        // return  list;
                 })
                 .catch(error => {
                     console.log(error)
                 });
            console.log(fakelist)


    },
}