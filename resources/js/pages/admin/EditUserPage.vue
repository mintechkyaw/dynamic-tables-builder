<template>
<v-container>
    <v-row>
        <v-col cols="3"></v-col>
        <v-col cols="6">
            <h3 class="mb-2">Edit User</h3>
            <v-text-field v-model="user.name" label="Main input"></v-text-field>
            <!-- <v-text-field v-model="user.email" label="Another input"></v-text-field> -->
            <v-container>
                <v-row dense>
                    <v-col cols="12" md="3" sm="4" v-for="per in getPermissions" :key="per.id">
                        <v-checkbox :label="per.name" :value="per.id" color="primary" v-model="user.updatePermissions" multiple></v-checkbox>
                    </v-col>
                </v-row>
            </v-container>
            <v-btn @click="saveBtn" :loading="saveBtnLoading" color="success">Save</v-btn>
        </v-col>
        <v-col cols="3"></v-col>
    </v-row>
</v-container>
</template>

<script>
import {
    id
} from 'vuetify/locale';
import {
    mapActions,
    mapGetters
} from 'vuex';

export default {
    data() {
        return {
            user: {
                id : this.$route.params.id,
                name: '',
                email: '',
                permissions: [],
                updatePermissions: [],
            },
            saveBtnLoading : false,
        }
    },
    computed: {
        ...mapGetters(["getUser", "getPermissions"]),
    },
    methods: {
        ...mapActions(["fetchUserById", "fetchPermissions","updateUser"]),
        async saveBtn(){
            this.saveBtnLoading = true;
            await this.updateUser(this.user);
            // console.log(this.user);
            console.log(this.user.updatePermissions);
            this.saveBtnLoading = false;
            this.$router.push('/user-list');
        }
    },
    async mounted() {
        this.fetchPermissions();
        await this.fetchUserById(this.$route.params.id);
        this.user.name = this.getUser.name;
        this.user.permissions = this.getUser.permissions.map(permission => permission.id);
        this.user.updatePermissions = this.getUser.permissions.map(permission => permission.id);

        this.user.updatePermissions = [...this.user.permissions];

        console.log(this.user);
    },
}
</script>
