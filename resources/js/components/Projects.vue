<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Vuejs Datatable</div>
                    <div class="card-body">
                        <button class="float-right btn btn-sm btn-primary m-1">hello world</button>
                        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at }}</td>
                                </tr>
                            </tbody>
                        </datatable>
                        <pagination :pagination="pagination"
                                    @next="getUsers(pagination.nextPageURL)"
                                    @prev="getUsers(pagination.prevPageURL)">
                        </pagination>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datatable from './Datatable.vue';
    import Pagination from './Pagination.vue';

    export default {
        components: {datatable: Datatable, pagination: Pagination},
        created(){
            this.getUsers();
        },
        data(){
            let sortOrders = {};

            let columns= [
                {width: '33%', label: 'Name', name: 'name'},
                {width: '33%', label: 'Email', name: 'email'},
                {width: '33%', label: 'Created_at', name: 'created_at'}
            ];

            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            })

            return {
                users: [],
                columns: columns,
                sortKey: 'name',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'asc'
                },
                pagination: {
                    lastPage: '',
                    currentPage:'',
                    total:'',
                    lastPageURL:'',
                    nextPageURL:'',
                    prevPageURL:'',
                    from:'',
                    to:'',
                },
            }
        },
        methods: {
            getUsers(url = '/users'){
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw){
                            this.users = data.data.data;
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },
            configPagination(data){
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageURL = data.last_page_url;
                this.pagination.nextPageURL = data.next_page_url;
                this.pagination.prevPageURL = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            sortBy(key){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getUsers();
            },
            getIndex(array, key, value){
                return array.findIndex(i => i[key] == value)
            },
        }
    }
</script>
