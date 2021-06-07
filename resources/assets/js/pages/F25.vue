<template>
    <div>
        <start-patient></start-patient>
        <main-information></main-information>
    </div>
</template>
<script>
    import Start from '../components/Start'
    import MainInformation from '../components/f025/MainInformation'
    import Rentgenas from '../components/f025/Rentgenas'
    import MokamosPaslaugos from '../components/f025/MokamosPaslaugos';
    import MedicalRecord from '../views/medication/MedicalRecord'
    import MedicalVisitDocuments from  '../views/medication/MedicalVisitDocuments'
    export default {

        data(){
            return{
            }
        },
        components: {
            'start-patient': Start,
            'main-information': MainInformation,
            'rentgenas': Rentgenas,
            'mokamos-paslaugos': MokamosPaslaugos,

        },
        methods:{
            ShowURL(){
                return this.$route.fullPath
            }
        },
        beforeMount() {
            this.ShowURL();
        },
        beforeCreate() {
        },
    }
</script>
<style>
</style>

