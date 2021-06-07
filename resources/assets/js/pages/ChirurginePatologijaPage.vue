<template>
    <chirurgine-patologija></chirurgine-patologija>
</template>

<script>
    import ChirurginePatologija from "../components/formos/ChirurginePatologija";

    export default {
        name: "ChirurginePatologijaPage",
        components: {
            'chirurgine-patologija': ChirurginePatologija,
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
