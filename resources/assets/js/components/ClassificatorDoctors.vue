<template>
<div>
a
</div>
</template>
<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                showFilter: false,
                model: {
                    data: []
                },
                params: {
                    column: 'ward_name',
                    direction: 'asc',
                    per_page: 25,
                    page: 1,
                    search_column: 'case_number',
                    search_operator: 'equal_to',
                    search_query_2: '',
                    searchableText:'',
                    validateMore14: true,
                },
                operators: {
                    equal_to: '=',
                    not_equal: '<>',
                    less_than: '<',
                    greater_than: '>',
                    less_than_or_equal_to: '<=',
                    greater_than_or_equal_to: '>=',
                    in: 'IN',
                    not_in: 'NOT IN',
                    like: 'LIKE',
                    between: 'BETWEEN'
                }
            }
        },
        beforeMount() {
            this.fetchData()
        },
        created() {
            this.HTMLcontent = '<div>Im section one</div>'
        },
        methods: {
            reset(){
                this.params.searchableText=''
                this.params.page=1
                this.fetchData()
            },
            newquery(){
                this.params.page=1
                this.fetchData()
            },
            next() {
                this.params.loadingNext = true
                this.params.loadingNext = false
                if(this.model.next_page_url) {
                    this.params.page++
                    this.fetchData()
                }
            },
            prev() {
                if(this.model.prev_page_url) {
                    this.params.page--
                    this.fetchData()
                }
            },
            sort(column) {
                if(column === this.params.column) {
                    if(this.params.direction === 'desc') {
                        this.params.direction = 'asc'
                    } else {
                        this.params.direction = 'desc'
                    }
                } else {
                    this.params.column = column
                    this.params.direction = 'asc'
                }

                this.fetchData()
            },
            fetchData() {
                let loader = this.$loading.show({
                    backgroundColor: '#ffffff',
                    color: '#6699ff'
                })
                var vm = this
                axios.get(this.buildURL())
                    .then(function(response) {
                        Vue.set(vm.$data, 'model', response.data.model)
                       loader.hide()
                    })
                    .catch(function(error) {
                        console.log(error)
                    })

            },
            buildURL() {
                var p = this.params
                return `${this.source}?column=${p.column}&direction=${p.direction}&per_page=${p.per_page}&page=${p.page}&search_column=${p.search_column}&search_operator=${p.search_operator}&validateMore14=${p.validateMore14}&searchableText=${p.searchableText}`
            },

        }
    }
</script>