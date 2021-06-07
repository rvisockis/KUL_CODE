<template>
    <lor-forma>TEST</lor-forma>
</template>

<script>
    import LORforma from '../components/formos/LORforma';

    export default {
        name: "LORformaPage",
        components: {
            'lor-forma': LORforma,

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
