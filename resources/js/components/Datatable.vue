<template>
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th scope="col" v-for="column in columns" :key="column.name" @click="$emit('sort', column.name)"
                    :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_dsc') : 'sorting'"
                    :style="'width:'+column.width+';'+'curson:pointer;'">
                    {{ column.label }}
                </th>
            </tr>
        </thead>
        <slot></slot>
    </table>
</template>

<script>
    export default {
        name: 'Datatable',

        props: ['columns', 'sortKey', 'sortOrders'],

    }
</script>