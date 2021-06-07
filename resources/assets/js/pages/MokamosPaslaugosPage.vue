<template>
    <div>
        <mokamos-paslaugos></mokamos-paslaugos>
    </div>
</template>

<script>
    import MokamosPaslaugos from '../components/f025/MokamosPaslaugos';

    export default {
        name: "MokamosPaslaugosPage",
        components: {
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

<style scoped>

</style>
