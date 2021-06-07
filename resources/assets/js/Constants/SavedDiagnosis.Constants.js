export default {
    //pasirinktu ligu sarasas
    SavedDiagnosis: [],
    // save input ka issaugoti i SavedDiagnosis konstanta input yra ka isaugot
    save(input) {
        for (var a = 0; a<input.length;a++){
            this.SavedDiagnosis.push(input[a])

        }


    },
    //istustina komponenta
    Delete(){
        this.SavedDiagnosis= [];
    },



}