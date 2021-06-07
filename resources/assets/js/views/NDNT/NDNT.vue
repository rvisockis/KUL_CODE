<template>
    <div>
        <start-patient>
        </start-patient>
        <v-app>
            <div class="col-md-12 box-body">
                <div class="col-md-12">

                </div>
            </div>
        </v-app>
    </div>
</template>

<script>
    import axios from 'axios'
    import Start from '../../components/Start'

    export default {
        name: "NDNT",
        data(){
            return{
                LivingAdress:[],
                PhoneNumber:[],
                MobilePhoneNumber:[],
                DetailedAnamnisis:[],
                AppliedTreatment:[],
                AppliedTreatmentOptions:['Ambulatorinis','Stacionarinis','Reabilitacinis','Kitas','Medikamentinis','Chirurginis'],
                StateAndHealth:[],
                ConsultationDate:[],
                DoctorsSpeciality:[],
                MainDiagnosis:[],
                OtherDiagnosis:[],
                SnedingToNDNTCheckBox:[],
                SnedingToNDNTCheckBoxOptions:['Darbingumo lygiui nustatyti','Specialiems poreikiams nustatyti'],
                SendingToNDNTRadio:[],
                SendingToNDNTRadioOptions:['Pirmą kartą','Baigiantis terminui','Būklei pasikeitus'],


            }
        },
        components: {
            'start-patient': Start,
        },
        //'Sending_Date','Sending_Number','Person_Info_Personal_ID','Person_Info_Name','Person_Info_Living_Location',
        // 'Person_Info_Phone_Number','Person_Info_Mobile_Phone_Number','Person_Info_Email','Work_Place','Position','Full_Anamnisis','Applied_Treatment',
        // 'Condition_And_Life','Health_Condition_Summary_Consultation_Date','Health_Condition_Summary_Doctors_Speciality','Health_Condition_Summary_Comments',
        // 'Health_Condition_Summary_Accessories','Barthel_index','Duration_Of_Incapacity','Main_Diagnosis_TLK10','Main_Diagnosis_Functional_Class','Main_Diagnosis_Degree',
        // 'Main_Diagnosis_stage','Main_Diagnosis_Progress','Other_Diagnosis','Sending_To_Disability_What_Kind','Sending_To_Disability_For_What','Sending_To_Disability_For_Younger',
        // 'Sending_To_Disability_What_Time','Sending_To_Disability_Forced_To_DO','State'

    methods:{
            ShowURL(){
                return this.$route.fullPath
            }
        },
        beforeMount() {
            this.ShowURL();
        },
    }
</script>

<style scoped>

</style>
