<template>
<v-container>
    <v-row>
        <v-col cols="3"></v-col>
        <v-col cols="6">
            <h2 class="mb-2">Create User</h2>
            <v-text-field label="Enter Name" v-model="user.name"></v-text-field>
            <v-text-field label="Enter Email" v-model="user.email"></v-text-field>
            <v-text-field label="Enter Password" type="password" v-model="user.password"></v-text-field>
            <v-select label="Select Role" v-model="user.role_id" :items="roleItems" item-value="id" item-title="name"></v-select>
            <v-container>
                <v-row dense>
                    <v-col cols="12" md="3" sm="4" v-for="per in getPermissions" :key="per.id">
                        <v-checkbox :label="per.name" :value="per.id" color="primary" v-model="user.permissions" multiple></v-checkbox>
                    </v-col>
                </v-row>
            </v-container>
            <v-btn @click="createUserBtn(user)" :loading="createBtnLoading" variant="tonal">Create</v-btn>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex'
import ability from '../../services/ability';
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                role_id: "",
                password: '',
                permissions: [],
            },
            createBtnLoading: false,
        }
    },
    computed: {
        ...mapGetters(["getPermissions", "getRoles"]),
        roleItems() {
            return this.getRoles || [];
        },
    },
    methods: {
        ...mapActions(["fetchPermissions", "fetchRoles", "createUser"]),
        async createUserBtn() {
            try {
                this.createBtnLoading = true;
                const payload = {
                    ...this.user,
                    role_id: String(this.user.role_id),
                };
                await this.createUser(payload);
                this.createBtnLoading = false;
                this.user.name = '';
                this.user.email = '';
                this.user.role_id = "";
                this.user.password = '';
                this.user.permissions = [];
            } catch (error) {
                this.createBtnLoading = false;
                alert(error.message)
            }
        },
    },
    mounted() {
        this.fetchPermissions();
        this.fetchRoles();
        // this.selectBoxRole = this.getRoles;
        // console.log(this.getPermissions);
    },
}
</script>
