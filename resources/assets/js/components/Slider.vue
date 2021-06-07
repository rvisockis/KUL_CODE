<template>
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


      <!--&lt;!&ndash; search form (Optional) &ndash;&gt;-->
      <!--<form action="#" method="get" class="sidebar-form">-->
        <!--<div class="input-group">-->
          <!--<input type="text" name="q" class="form-control" placeholder="Search...">-->
          <!--<span class="input-group-btn">-->
              <!--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>-->
              <!--</button>-->
            <!--</span>-->
        <!--</div>-->
      <!--</form>-->
      <!--&lt;!&ndash; /.search form &ndash;&gt;-->

      <!-- Sidebar Menu -->
<!--        ?sickness-case-number=65116&visit-number=445&personal-code=48710110189&patient-first-name=Jonas&patient-surname=Petraitis&username=Ignas&user-surname=Kubilius&korteles-nr=2016%2F0189299%2F00-->
      <ul class="sidebar-menu">
      <!--<ul class="sidebar-menu" data-widget="tree">-->
        <!--<li class="header">Pasirinkite</li>-->
        <!-- Optionally, you can add icons to the links -->
        <!--<router-link tag="li" :to="{ name: 'Home' }"><a><i class="fas fa-cross"></i> <span>MIRUSIEJI PACIENTAI</span></a></router-link>-->
        <!--<router-link tag="li" :to="{ name: 'ClassificatorDoctors', params: { infoname:'Gydytojai',infodescription:'Gydytojų, dirbančių įstaigoje klasifikatorius' } }"><a><i class="fas fa-bed"></i> <span>GYDYTOJŲ KLASIFIKATORIUS</span></a></router-link>-->
<!--        <router-link tag="li" :to="{ name: 'ClassificatorDoctors', params: { infoname:'Gydytojai',infodescription:'Gydytojų, dirbančių įstaigoje klasifikatorius' } }"><a><i class="fa fa-book"></i><span>GYDYTOJŲ KLASIFIKATORIUS</span></a></router-link>-->
<!--        <router-link tag="li" :to="{ name: 'F025'}"><a><i class="fa fa-book"></i><span>F025</span></a></router-link>-->
          <router-link v-if="admin_links" tag="li" :to="{ name: 'GetPostings', path:'Postings'}"><a><i class="fas fa-file-alt"></i><span> Elektroniniai Siuntimai</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{ name: 'MokamosPaslaugos', path:'MokamosPaslaugos'}"><a><i class="fas fa-th-list"></i><span> Mokamos Paslaugos</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{ name: 'F25', path:'F25', query: {'personal-code': '48710110189', 'korteles-nr': '2016/0189299/00'}}"><a><i class="fa fa-book"></i><span>F025/a-LK</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{ name: 'MedicalRecord', path:'israsas', query: {'personal-code': '48710110189', 'korteles-nr': '2016/0189299/00', 'username': 'ignas', 'doctorID': '138092', 'patient-first-name': 'MONTVYDIENĖ, IEVA MARIJA'}}"><a><i class="fa fa-book"></i><span>Išrašas</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{ name: 'Kalendorius', path:'Kalendorius'}"><a><i class="fas fa-calendar"></i><span> Operacinių Kalendorius</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{name:'NDNT',path:'NDNT'}" ><a><i class="fas fa-file-medical"></i><span> NDNT</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{name:'TelefonuKnyga',path:'TelefonuKnyga'}" ><a><i class="fas fa-phone"></i><span> Telefonų knyga</span></a></router-link>
          <router-link v-if="admin_links" tag="li" :to="{name:'IPRRegistracijos',path:'IPRRegistracijos'}" ><a><i class="fas fa-phone"></i><span> IPR tel. nr. paieška</span></a></router-link>



          <li class="treeview" v-if="admin_links">
              <a href="#" @click="tyrimu_menu()">
                  <i class="fas fa-file-medical-alt"></i> <span>Tyrimai</span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu" v-bind:class="{active_menu: analysis_menu}">
                  <router-link v-if="admin_links" tag="li" :to="{name:'VidOrgUltragarsinis',path:'VidOrgUltragarsinis'}" ><a><i class="fas fa-file-medical-alt"></i><span> Vid. org. ultragarsinis tyrimas</span></a></router-link>
              </ul>
          </li>


          <!--<router-link tag="li" :to="{ name: 'RadiologyExams',params: { infoname:'ATASKAITOS',infodescription:'Ligoninės ataskaitų modulis'} }" ><a><i class="fas fa-file"></i> <span>ATASKAITOS</span></a></router-link>-->
        <!--<router-link tag="li" :to="{ name: 'RadiologyExams' }"><a><i class="fas fa-birthday-cake"></i> <span>JUBILIEJAI</span></a></router-link>-->
        <!--<router-link tag="li" :to="{ name: 'MedicationScaning' }"><a><i class="fas fa-pills"></i> <span>MEDIKAMENTAI</span></a></router-link>-->

<!--          <li class="treeview menu-open " style="height: auto;">-->
<!--              <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>-->
<!--                  <span class="pull-right-container">-->
<!--                <i class="fa fa-angle-left pull-right"></i>-->
<!--              </span>-->
<!--              </a>-->
<!--              <ul class="treeview-menu" style="display: block;">-->
<!--                  <li><a href="#">Link in level 2</a></li>-->
<!--                  <li><a href="#">Link in level 2</a></li>-->
<!--              </ul>-->
<!--          </li>-->
          <li class="treeview" v-if="admin_links">
              <a href="#" @click="formu_menu">
                  <i class="fas fa-file-medical"></i> <span>Formos</span>
                  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu" v-bind:class="{active_menu: form_menu}">
                  <router-link v-if="admin_links" tag="li" :to="{ name: 'Forma1', path:'Forma1'}"><a><i class="fa fa-book"></i><span>Traumatologų forma</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{ name: 'LORforma', path:'LORforma'}"><a><i class="fa fa-book"></i><span>LOR forma</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{ name: 'VaikuAmbForma', path:'VaikuAmbForma'}"><a><i class="fa fa-book"></i><span>Vaikų amb. forma</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{ name: 'Vakcinacija', path:'Vakcinacija'}"><a><i class="fas fa-syringe"></i><span> Vakcinacijos forma</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{ name: 'ChirurginePatologija', path:'ChirurginePatologija'}"><a><i class="fa fa-book"></i><span>Chirurginė Patologija</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{name:'RadiologijosForma',path:'RadiologijosForma'}" ><a><i class="fas fa-atom"></i><span> Radiologijos Forma</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{name:'Chirurginis_Priemimas',path:'Chirurginis_Priemimas'}" ><a><i class="fas fa-file-medical"></i><span> Chirurginis priėmimas</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{name:'StacionarinisPriemimas',path:'StacionarinisPriemimas'}" ><a><i class="fas fa-file-medical"></i><span> Stacionarinis priėmimas</span></a></router-link>
                  <router-link v-if="admin_links" tag="li" :to="{name:'Forma049',path:'Forma049'}" ><a><i class="fas fa-file-medical"></i><span> Forma 049</span></a></router-link>


                  <!--                  <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>-->
<!--                  <li class="treeview">-->
<!--                      <a href="#"><i class="fa fa-circle-o"></i> Level One-->
<!--                          <span class="pull-right-container">-->
<!--                  <i class="fa fa-angle-left pull-right"></i>-->
<!--                </span>-->
<!--                      </a>-->
<!--                      <ul class="treeview-menu">-->
<!--                          <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>-->
<!--                          <li class="treeview">-->
<!--                              <a href="#"><i class="fa fa-circle-o"></i> Level Two-->
<!--                                  <span class="pull-right-container">-->
<!--                      <i class="fa fa-angle-left pull-right"></i>-->
<!--                    </span>-->
<!--                              </a>-->
<!--                              <ul class="treeview-menu">-->
<!--                                  <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>-->
<!--                                  <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>-->
<!--                              </ul>-->
<!--                          </li>-->
<!--                      </ul>-->
<!--                  </li>-->
<!--                  <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>-->
              </ul>
          </li>

      </ul>


      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>

export default {
    data() {
        return {
            clientip: '',
            admin_group: ['192.168.63.7', '192.168.63.4', '192.168.63.3'],
            admin_links: false,
            form_menu: false,
            analysis_menu: false,

        }

    },
    methods: {
        checkRole(){ //TODO: kvieciant funkcija turi buti siunciamas roles argumentas.
            let ipcheck = this.admin_group.find(ip => ip === this.clientip)
            if(ipcheck !== undefined){
                this.admin_links = true;
            } else {
                this.admin_links = false;
            }
        },
        async getClientIP(){
        //     this.clientip = await $.getJSON("https://jsonip.com?callback=?", function(data) {
        //         console.log(data)
        //         this.clientip = data.ip;
        //     });
        //     console.log(this.clientip.ip)
            await axios.get('/api/getClientIP')
            .then(response => {
                this.clientip = response.data
                console.log(this.clientip)
                this.checkRole()
            })
        },
        formu_menu(){
            this.form_menu = !this.form_menu;
        },
        tyrimu_menu(){
            this.analysis_menu = !this.analysis_menu;
        }

    },
    beforeMount() {
        this.getClientIP();
    }
}
</script>
<style scoped>
    .active_menu {
        display: block !important;
    }

</style>
