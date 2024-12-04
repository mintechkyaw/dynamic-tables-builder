<template>
<v-container fluid>
    <h2>User Lists</h2>
    <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems" :items-length="totalItems" :loading="loading" :search="search" item-value="name" @update:options="loadItems"></v-data-table-server>
</v-container>
</template>


<script>
export default {
    data: () => ({
        itemsPerPage: 5,
        headers: [{
                title: 'UID',
                align: 'start',
                sortable: false,
            },
            {
                title: 'Name',
                key: 'calories',
            },
            {
                title: 'Email',
                align: 'end'
            },
            {
                title: 'Permissions',
                align: 'end'
            },
            {
                title: 'Created at',
                align: 'end'
            },
            {
                title: 'Updated at',
                align: 'end'
            },
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),
    methods: {
    },
}
</script>
