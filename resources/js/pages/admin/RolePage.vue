<template>
<v-container>
    <v-row>
        <v-col cols="6">
            <h2 class="mb-2">Create Role</h2>
            <v-text-field label="Enter Role" v-model="roleName"></v-text-field>
            <v-btn @click="roleCreateBtn" variant="tonal" :loading="createBtnLoading">Create</v-btn>
        </v-col>
        <v-col>
            <h2>Table</h2>
            <v-table>
                <thead>
                    <tr>
                        <th class="text-left">
                            Id
                        </th>
                        <th class="text-left">
                            Role Name
                        </th>
                        <th class="text-left">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in getRoles" :key="role.id">
                        <td>{{ role.id }}</td>
                        <td>{{ role.name }}</td>
                        <td>
                            <v-btn :loading="loadingState[role.id]" @click="deleteRoleBtn(role.id)" color="warning" size="x-small">Delete</v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    data() {
        return {
            roleName: "",
            createBtnLoading : false,
            loadingState : {},
        }
    },
    computed: {
       ...mapGetters(["getRoles"])
    },
    methods: {
    ...mapActions(["fetchRoles","createRole","deleteRole"]),
    async roleCreateBtn(){
        try {
            this.createBtnLoading = true;
            await this.createRole(this.roleName);
            this.createBtnLoading = false;
            this.roleName = "";
            this.fetchRoles();
        } catch (e) {
            this.createBtnLoading = false;
            alert(e.message);
        }
    },
    async deleteRoleBtn(id){
        try {
            this.loadingState[id] = true;
            await this.deleteRole(id);
            this.loadingState[id] = false;
        } catch (error) {
            this.loadingState[id] = false;
        }
    }
    },
    mounted () {
        this.fetchRoles();
        // console.log(this.getRoles);
    },
}
</script>
