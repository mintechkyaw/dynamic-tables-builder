<template>
    <v-container fluid>
        <v-row justify="center" align="center" class="gy-4">
            <v-col cols="12" md="6" lg="4">
                <v-card elevation="6" class="text-center py-6 px-4 gradient-card">
                    <div class="stat-title">Users</div>
                    <div class="stat-value">{{ stats.usersCount }}</div>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-card elevation="6" class="text-center py-6 px-4 gradient-card">
                    <div class="stat-title">Roles</div>
                    <div class="stat-value">{{ stats.rolesCount }}</div>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-card elevation="6" class="text-center py-6 px-4 gradient-card">
                    <div class="stat-title">Permissions</div>
                    <div class="stat-value">{{ stats.permissionsCount }}</div>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-card elevation="6" class="text-center py-6 px-4 gradient-card">
                    <div class="stat-title">Forms</div>
                    <div class="stat-value">{{ stats.formsCount }}</div>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-card elevation="6" class="text-center py-6 px-4 gradient-card">
                    <div class="stat-title">Tables</div>
                    <div class="stat-value">{{ stats.tablesCount }}</div>
                </v-card>
            </v-col>
            
        </v-row>
    </v-container>
</template>

<script setup>
import { onMounted, reactive } from "vue";
import api from "../../api/axios";

const stats = reactive({
    usersCount: 0,
    rolesCount: 0,
    permissionsCount: 0,
    formsCount: 0,
    tablesCount: 0,
});

const getData = async () => {
    try {
        const res = await api.get("/stats");
        stats.usersCount = res.data.usersCount;
        stats.rolesCount = res.data.rolesCount;
        stats.permissionsCount = res.data.permissionsCount;
        stats.formsCount = res.data.formsCount;
        stats.tablesCount = res.data.tablesCount;
    } catch (error) {
        console.error("Error fetching stats:", error);
    }
};

onMounted(() => {
    getData();
});
</script>
