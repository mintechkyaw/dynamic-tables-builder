<template>
<v-container>
    <v-row>
        <v-col cols="3"></v-col>
        <v-col cols="6">
            <h2 class="mb-2">Create User</h2>
            <v-text-field label="Enter Name"></v-text-field>
            <v-text-field label="Enter Email"></v-text-field>
            <v-text-field label="Enter Password" type="password"></v-text-field>
            <v-select label="Select Role" :items="roleItems" item-value="id" item-title="name"></v-select>
            <v-container>
                <v-row dense>
                    <v-col cols="12" md="3" sm="4" v-for="per in getPermissions" :key="per.id">
                        <v-checkbox :label="per.name" color="primary"></v-checkbox>
                    </v-col>
                </v-row>
            </v-container>
            <v-btn variant="tonal">Create</v-btn>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex'
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                role: '',
                password: '',
                permissions: [],
            },
            selectBoxRole: [],
        }
    },
    computed: {
        ...mapGetters(["getPermissions", "getRoles"]),
        roleItems() {
            return this.getRoles || [];
        },
    },
    methods: {
        ...mapActions(["fetchPermissions", "fetchRoles"]),
    },
    mounted() {
        this.fetchPermissions();
        this.fetchRoles();
        // this.selectBoxRole = this.getRoles;
        // console.log(this.getPermissions);
    },
}
</script>
