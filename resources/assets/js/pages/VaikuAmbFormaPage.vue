<template>
    <vaiku_amb_forma></vaiku_amb_forma>
</template>

<script>
    import VaikuAmbForma from '../components/formos/VaikuAmbForma'

    export default {
        name: "VaikuAmbFormaPage",
        components: {
            vaiku_amb_forma: VaikuAmbForma,
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

<style scoped>

</style>
