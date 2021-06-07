<template>
    <div>
        <a-affix >
            <div class="row" style="height: 140px;">
                <div class="col-md-12" style="width: 100%;">
                    <div class="box box-widget widget-user">
                        <div class="widget-user-header bg-aqua-active">
                            <div class="col-md-8">
                            <h2 class="widget-user-desc" >
                                {{getLinkInfo('patient-first-name')}} {{getLinkInfo('patient-surname')}}
                            </h2>
                            <h3 class="widget-user-desc">
                                {{getLinkInfo('personal-code')}}
                            </h3>
                            <h2 class="widget-user-username"></h2>
                            </div>
                            <div class="col-md-4" style="text-align:right;">
                                <a-switch inset style="width:150px;" @click="selectedPage" :juodrastis="juodrastis" v-model="juodrastis" checkedChildren="Juodraštis" unCheckedChildren="Pagrindinis langas" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a-affix>
        <br />
    </div>
</template>
<script>
import {LinksFunction} from "./ReadLinkInfo";
import {serverBus} from "../app";

export default {
    props: ['juodrastis'],
    data(){
        return {
            juodrastis: false,
            sourceTakeDiagnosis: '/api/getPatient',
        }
    },
    beforeMount(){
    },
    mounted(){
    },
    methods:{
        selectedPage() {
            serverBus.$emit('selectedPage', this.juodrastis)
        },
        getLinkInfo(RequestedElement) {
            return LinksFunction(this.$route.query, RequestedElement);
        },
    },
}
</script>
<style>
</style>

