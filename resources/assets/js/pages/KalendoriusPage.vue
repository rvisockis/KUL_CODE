<template>
<kalendorius></kalendorius>
</template>

<script>
    import Kalendorius from "../components/kalendorius/Kalendorius";
    export default {
        name: "KalendoriusPage",
        components: {
            'kalendorius': Kalendorius
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
