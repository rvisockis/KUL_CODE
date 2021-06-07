<template>
    <patient-hospitalization :source="source" :thead="thead" :filter="filter" :title="title">
        <template slot-scope="props">
            <!--<tr @click="$router.push('//' + 1)">-->
            <tr>
                <!--<template v-if="props.item.sickness_case_with_visit.length !== 0">-->
                <!--<td v-for="ward in props.item.sickness_case_with_visit">{{ward.visit_with_structure_unit.structure_unit_with_organization.display_name}}</td>-->
                <!--</template>-->
                <!--<template v-else>-->
                <!--<td>{{'Laukia guldymo!'}}</td>-->
                <!--</template>-->
                <td>{{props.item.ward_name}}</td>
                <td>{{props.item.case_number}}</td>
                <td>{{props.item.full_name}}</td>
                <td>{{props.item.start_date}}</td>
                <td>{{props.item.days_in_hospital}}</td>
            </tr>
        </template>
    </patient-hospitalization>
</template>
<script>
    import PatientHospitalization from '../../components/PatientHospitalization.vue'

    export default {
        name: 'PatientHospitalizationIndex',
        data() {
            return {
                title: 'In-Patient Hospitalization',
                source: '/api/patienthospitalization',
                //create: '/customer/create',
                thead: [
                    {title: 'Skyrius', key: 'ward_name', sort: true},
                    {title: 'Atvejo Nr.', key: 'case_number', sort: true},
                    {title: 'Vardas Pavardė', key: 'full_name', sort: true},
                    {title: 'Paguldymo data', key: 'start_date', sort: true},
                    {title: 'Dienų skaičius', key: 'days_in_hospital', sort: true},
                ],
                filter:[
                    'id'
                ]
            }
        },
        components: {
            PatientHospitalization
        }
    }
</script>