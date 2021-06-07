<template>
    <div>
        <start-patient>
        </start-patient>
      <medical-records></medical-records>
        <medical-documents></medical-documents>
    </div>
</template>
<script>
    import Start from '../components/Start'
    import MedicalRecord from '../views/medication/MedicalRecord'
    import MedicalVisitDocuments from  '../views/medication/MedicalVisitDocuments'
    export default {

        data(){
            return{
            }
        },
        components: {
            'start-patient': Start,
            'medical-records': MedicalRecord,
            'medical-documents': MedicalVisitDocuments,
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

