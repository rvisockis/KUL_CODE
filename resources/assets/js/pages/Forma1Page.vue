<template>
<forma-1>TEST</forma-1>
</template>

<script>
    import Forma1 from '../components/formos/Forma1';

    export default {
        name: "Forma1Page",
        components: {
            'forma-1': Forma1,

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
