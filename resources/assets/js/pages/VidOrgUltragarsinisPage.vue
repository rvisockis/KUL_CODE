<template>
    <vidorgultragarsinis></vidorgultragarsinis>
</template>

<script>
    import VidOrgUltragarsinis from "../components/formos/VidOrgUltragarsinis";
    export default {
        name: "VidOrgUltragarsinisPage",
        components: {
            vidorgultragarsinis: VidOrgUltragarsinis,
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
