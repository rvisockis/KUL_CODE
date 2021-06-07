    <template>
    <div>
    <Table border stripe ref="selection" :columns="columns" :data="list"></Table>
        <div style="margin: 10px;overflow: hidden">
            <div style="float: right;">
                <Page :total="livingsubjectdata.length" @on-change="changePage" show-total></Page>
            </div>
        </div>
    </div>
</template>
<script>
    const pageSize=20;
    export default {
        data () {
            return {
                page: 1,
                pageSize: 20,
                livingsubjectdata:[],
                // data:[],
                columns: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: 'Asmens kodas',
                        key: 'display_code',
                        sortable: false
                    },
                    {
                        title: 'Pavardė, Vardas',
                        key: 'display_name',
                        sortable: true

                    },
                    {
                        title: 'Gimimo data',
                        key: 'birth_time',
                        sortable: true,
                        render: (h, params) => {
                            return h('div', this.formatDate(this.livingsubjectdata[params.index].birth_time));
                        }
                    },
                    {
                        title: 'Struktūrinis vienetas',
                        key: 'sickness_and_visit.structure_unit_id',
                        sortable: false

                    },
                ],
            }
        },
        methods: {
            takelivingsubjectdata () {
                axios.get('/livingsubjectsinfo')
                    .then(response => this.livingsubjectdata = response.data)
            },
            formatDate (date) {
                return new Date(date).toLocaleDateString()
            },
            getPageList(p, size) {
                return this.livingsubjectdata.slice((p - 1) * size, p * size)
            },
            changePage (p) {
                this.page = p
                //this.list = this.getPageList(p, pageSize)

            },

        },
        computed:{
            list(){
                return this.getPageList(this.page,pageSize)
            },

        },
        created(){
            this.takelivingsubjectdata()
        }

    }
    // onSize (pageSize) {
    //     this.currentPageSize = pageSize;
    //     this.$emit('on-page-size-change', pageSize);
    //     this.changePage(1);
    // },
    // changePage (page) {
    //     if (this.currentPage != page) {
    //         this.currentPage = page;
    //         this.$emit('update:current', page);
    //         this.$emit('on-change', page);
    //     }
    // }
</script>
