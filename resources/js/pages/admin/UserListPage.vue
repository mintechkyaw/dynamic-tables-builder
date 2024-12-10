<template>
<v-container fluid>
    <h2>User Lists</h2>
    <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems" :items-length="totalItems" :loading="loading" :search="search" item-value="name" @update:options="loadItems">
        <template v-slot:[`item.permissions`]="{ item }">
            <span>{{ item.permissions.join(', ') }}</span>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
            <v-btn :to="`/edit-user/${item.id}`" v-if="$can('update','user')" size="x-small" color="primary" small>Edit</v-btn>
            <v-btn v-if="$can('delete','user')" size="x-small" color="red" small>Delete</v-btn>
        </template>
    </v-data-table-server>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
import api from '../../api/axios';
import ability from '../../services/ability';

export default {
    data: () => ({
        itemsPerPage: 5,
        headers: [{
                title: 'UID',
                align: 'start',
                key: "id"
            },
            {
                title: 'Name',
                align: 'end',
                key: 'name',
            },
            {
                title: 'Email',
                align: 'end',
                key: "email",
            },
            {
                title: "Role",
                align: "End",
                key: "role",
            },
            {
                title: 'Permissions',
                align: 'end',
                key: "permissions",
            },
            {
                title: 'Created at',
                align: 'end',
                key: "registered_at"
            },
            {
                title: 'Updated at',
                align: 'end',
                key: "profile_updated_at"
            },
            {
                title: 'Actions',
                align: 'end',
                key: "actions"
            },
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),
    computed: {
        ...mapGetters(["getUsers"]),
        $can() {
            return ability.can.bind(ability);
        },
    },
    methods: {
        ...mapActions(["fetchUsers"]),
        async loadItems({
            page,
            itemsPerPage
        }) {
            this.loading = true;

            const params = {
                page: page,
                per_page: itemsPerPage,
                search: this.search,
            }
            try {
                const res = await api.get("/users", {
                    params
                });
                this.serverItems = res.data.data;
                this.totalItems = res.data.meta.total;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
    },
    created() {
        this.loadItems({
            page: 1,
            itemsPerPage: this.itemsPerPage
        });
        // console.log("Can update user:", ability.can('update', 'user'));
        // console.log("Can delete user:", ability.can('delete', 'user'));
    },
}
</script>
