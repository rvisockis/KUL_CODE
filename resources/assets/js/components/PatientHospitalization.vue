<template>
    <div class="panel panel-default">

        <affix class="panel-heading vue-affix" relativeElementSelector="#onShearching" :offset="{ top: 50, bottom: 40 }" style="width: 1250px">
            <!--<span class="panel-title">{{title}}</span>-->
            <div class="row">
                <div class="col-md-3">
                <!--<router-link :to="create" class="btn btn-primary btn-sm">Create</router-link>-->
                <!--<button class="btn btn-default btn-sm" @click="showFilter = !showFilter">F</button>-->


                    <div class="input-group input-group-sm">
                        <input type="search" class="form-control" v-model="params.searchableText" @keyup.enter="newquery">
                        <span class="input-group-btn">
<button class="btn btn-primary" type="button" @click="reset">Išvalyti</button>
</span>
                    </div>

                </div>
                <div class="col-md-3">
                    <!--<router-link :to="create" class="btn btn-primary btn-sm">Create</router-link>-->
                    <!--<button class="btn btn-default btn-sm" @click="showFilter = !showFilter">F</button>-->


                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"  id="defaultCheck1" v-model="params.validateMore14" @change="newquery">
                        <label class="form-check-label" for="defaultCheck1">
                            Daugiau kaip 14 dienų
                        </label>
                    </div>
                </div>
            </div>
        </affix>

        <div class="panel-body" id="onShearching">
            <div class="filter" v-if="showFilter">
                <div class="filter-column">
                    <select class="form-control" v-model="params.search_column">
                        <option v-for="column in filter" :value="column">{{column}}</option>
                    </select>
                </div>
                <div class="filter-operator">
                    <select class="form-control" v-model="params.search_operator">
                        <option v-for="(value, key) in operators" :value="key">{{value}}</option>
                    </select>
                </div>
                <div class="filter-input">
                    <input type="text" class="form-control" v-model="params.search_query_1"
                           @keyup.enter="fetchData" placeholder="Search">
                </div>
                <div class="filter-input" v-if="params.search_operator === 'between'">
                    <input type="text" class="form-control" v-model="params.search_query_2"
                           @keyup.enter="fetchData" placeholder="Search">
                </div>
                <div class="filter-btn">
                    <button class="btn btn-primary btn-sm btn-block" @click="fetchData">Filter</button>
                </div>
            </div>
            <table class="table table-striped">

                <thead>
                <tr>
                    <th v-for="item in thead">
                        <div class="patienthospitalization-th" @click="sort(item.key)" v-if="item.sort">
                            <span>{{item.title}}</span>
                            <span v-if="params.column === item.key">
                                    <span v-if="params.direction === 'asc'">&#x25B2;</span>
                                    <span v-else>&#x25BC;</span>
                                </span>
                        </div>
                        <div v-else>
                            <span>{{item.title}}</span>
                        </div>
                    </th>
                </tr>
                </thead>


                <tbody>
                <slot v-for="item in model.data" :item="item"></slot>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
                <div class="row">
            <div class="col-md-3">
                <div class="form-group form-group-sm">
                    <label>Per puslapį:</label>
                <select v-model="params.per_page" @change="fetchData">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            </div>
                <div class="col-md-3 mt-5 text-center ">
                        <label>Rodoma: </label>
                <span> {{model.from}} - {{model.to}} iš {{model.total}}</span>
                </div>
            <div class="col-md-6 text-right">
                <div class="form-inline">
                     <div class="form-group form-group-sm">
                <label class="control-label"> Dabar rodomas puslapis: </label>

                <input class="form-control" type="text" v-model="params.page"
                       @keyup.enter="fetchData" >
                             <label class="control-label"> iš {{ model.last_page}}</label>
                     </div>
                <div class="form-group">
                <button  @click="prev" class="btn btn-default btn-sm" >Buvęs</button>
                <button  @click="next" class="btn btn-default btn-sm" >Sekantis</button>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
        props: ['source', 'thead', 'filter', 'title'],
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
            }
        }
    }
</script>