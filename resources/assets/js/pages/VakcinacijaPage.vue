<template>
    <vakcinacija></vakcinacija>
</template>

<script>
    import Vakcinacija from "../components/formos/Vakcinacija";
    export default {
        name: "VakcinacijaPage",
        components: {
            vakcinacija: Vakcinacija,
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
