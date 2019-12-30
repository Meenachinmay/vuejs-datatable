<template>
    <nav class="pagination">
        <span class="page-stats" style="padding: 5px;"> {{ pagination.from }} - {{ pagination.to }} of {{ pagination.total }}</span>

        <button v-if="pagination.prevPageURL" class="btn btn-primary" @click="$emit('prev');">
            Prev
        </button>
        <button v-else class="btn btn-secondary" :disabled="true">
            Prev
        </button>
        <button v-if="pagination.nextPageURL" class="btn btn-primary mx-1" @click="$emit('next');">
            Next
        </button>
        <button v-else class="btn btn-secondary mx-1" :disabled="true">
            next
        </button>
    </nav>
</template>

<script>
    export default {
        name: 'Pagination',
        props: ['pagination'],
    }
</script>

<style lang="scss">
    .pagination{
        justify-content: flex-end !important;

        .page-stats {
            align-items: center;
            margin-right: 5px;
        }
        i {
            color: #3273dc !important;
        }
    }
</style>