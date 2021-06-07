import VueRouter from 'vue-router';

let routes = [
    // {
    //     path: '/doctors',
    //     component: require('./views/classificators/doctors/Index'),
    //     name: 'PatientHospitalization',
    //     props: {headername:'Gydytojų klasifikatorius'}
    // },
    {
        path: '/Chirurginis_Priemimas',
        component: require('./views/Formos/Priemimo Chirurginio/PriemimoChirForma').default,
        name: 'Chirurginis_Priemimas',
    },

    {
        path: '/StacionarinisPriemimas',
        component: require('./views/Formos/VaikuStat/VaikuStat').default,
        name: 'StacionarinisPriemimas',
    },
    {
        path: '/Forma049',
        component: require('./views/Formos/forma 04.9/Forma049').default,
        name: 'Forma049',
    },
     {
         path: '/israsas',
         component: require('./pages/Pages').default,
         name: 'MedicalRecord',

     },
    {
        path: '/NDNT',
        component: require('./views/NDNT/NDNT').default,
        name:'NDNT',
    },
    {
        path: '/MokamosPaslaugos',
        component: require('./pages/MokamosPaslaugosPage').default,
        name: 'MokamosPaslaugos',

    },
    {
        path: '/Forma1',
        component: require('./pages/Forma1Page').default,
        name: 'Forma1',

    },
    {
        path: '/LORforma',
        component: require('./pages/LORformaPage').default,
        name: 'LORforma',

    },
    {
        path: '/RadiologyForm',
        component: require('./views/Formos/RadiologijosForma/RadiologijosForma').default,
        name: 'RadiologijosForma'
    },
    {
        path: '/VaikuAmbForma',
        component: require('./pages/VaikuAmbFormaPage').default,
        name: 'VaikuAmbForma',

    },
    {
        path: '/Vakcinacija',
        component: require('./pages/VakcinacijaPage').default,
        name: 'Vakcinacija',

    },
    {
        path: '/ChirurginePatologija',
        component: require('./pages/ChirurginePatologijaPage').default,
        name: 'ChirurginePatologija',

    },
    {
        path: '/Kalendorius',
        component: require('./pages/KalendoriusPage').default,
        name: 'Kalendorius',

    },

    {
        path: '/lab',
        component: require('./pages/lab').default,
        name: 'lab',
    },
    {
        path: '/labControl',
        component: require('./pages/LabTestControl').default,
        name: 'labControl',
    },


    {
        path: '/F25',
        component: require('./pages/F25').default,
        name: 'F25',
    },
    {
        path: '/ClassificatorDoctors' ,
        component: require('./components/ClassificatorDoctors').default,
        name: 'ClassificatorDoctors'
    },
    {
        path: '/' ,
        component: require('./views/DaysPatient/Today').default,
        name: 'Today'
    },
    {
        path:'/Postings',
        component:require('./views/GetPostings/GetPostings').default,
        name:'GetPostings'
    },
    {
        path:'/TelefonuKnyga',
        component:require('./components/tel_knyga/Tel_knyga').default,
        name:'TelefonuKnyga'
    },
    {
        path:'/VidOrgUltragarsinis',
        component:require('./components/formos/VidOrgUltragarsinis').default,
        name:'VidOrgUltragarsinis'
    },
    {
        path:'/IPRRegistracijos',
        component:require('./components/IPRRegistracijos').default,
        name:'IPRRegistracijos'
    },

    // {
    //     path: '/info',
    //     component: require('./views/patienthospital/Index'),
    //     name: 'PatientHospitalization',
    //     props: {headername:'Registracija'}
    // },
    // {
    //     path: '/radiology',
    //     component: require('./components/radiology/PatientAmbulatoryRegistration'),
    //     name: 'RadiologyExams'
    // },
    // {
    //     path: '/medscan',
    //     component: require('./components/medication/MedicationScan'),
    //     name: 'MedicationScaning'
    // }
];
export default new VueRouter({
    mode: 'history',
    routes
})
