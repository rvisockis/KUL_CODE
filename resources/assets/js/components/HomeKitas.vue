<template>
    <div class="example-component">
        <section>
        <b-field grouped group-multiline>
            <b-select v-model="defaultSortDirection">
                <option value="asc">Default sort direction: ASC</option>
                <option value="desc">Default sort direction: DESC</option>
            </b-select>
            <b-select v-model="perPage" :disabled="!isPaginated">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="15">15 per page</option>
                <option value="20">20 per page</option>
            </b-select>
            <div class="control">
                <button class="button" @click="currentPage = 2" :disabled="!isPaginated">Set page to 2</button>
            </div>
            <div class="control is-flex">
                <b-switch v-model="isPaginated">Paginated</b-switch>
            </div>
            <div class="control is-flex">
                <b-switch v-model="isPaginationSimple" :disabled="!isPaginated">Simple pagination</b-switch>
            </div>
        </b-field>

        <b-table
                :data="data"
                :paginated="isPaginated"
                :per-page="perPage"
                :current-page.sync="currentPage"
                :pagination-simple="isPaginationSimple"
                :default-sort-direction="defaultSortDirection"
                default-sort="user.first_name">

            <template slot-scope="props">

                <b-table-column field="display_code" label="First Name" sortable>
                    {{ props.row.display_code }}
                </b-table-column>

                <b-table-column field="display_name" label="Last Name" sortable>
                    {{ props.row.display_name }}
                </b-table-column>

                <b-table-column field="birth_time" label="Date" sortable centered>
                    <span class="tag is-success">
                        {{ new Date(props.row.birth_time).toLocaleDateString() }}
                    </span>
                </b-table-column>

            </template>
        </b-table>
        </section>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                data:[],
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'asc',
                currentPage: 1,
                perPage: 5
            }
        },
        created(){
            axios.get('/livingsubjectsinfo')
                .then(response => this.data = response.data);
        }
    }
</script>

