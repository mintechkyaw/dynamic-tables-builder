<template>
<v-layout>
    <v-navigation-drawer v-model="drawer">
        <v-list>
            <v-list-item>
                <h3>Dynamite App</h3>
            </v-list-item>
        </v-list>
        <v-tabs direction="vertical">
            <v-tab to="/" prepend-icon="fa-solid fa-house">
                Home
            </v-tab>
            <v-tab to="/forms" prepend-icon="fa-brands fa-wpforms">
                Forms
            </v-tab>
            <v-tab to="/tables" prepend-icon="fa-solid fa-database">
                Tables
            </v-tab>
            <v-tab @click="logout" prepend-icon="fa-solid fa-arrow-right-from-bracket">
                Logout
            </v-tab>
        </v-tabs>
    </v-navigation-drawer>

    <v-app-bar color="primary" prominent>
        <v-btn color="" @click.stop="drawer = !drawer">
            <v-icon icon="fa-solid fa-bars" />
        </v-btn>
    </v-app-bar>

    <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
        <router-view></router-view>
    </v-main>
</v-layout>
</template>

<script>
import {
    mapActions
} from 'vuex';

export default {
    data() {
        return {
            drawer: null,
        }
    },
    methods: {
        logout() {
            localStorage.removeItem("token");
            this.$store.commit('clearUser');
            this.$router.push("/login");
        },
        ...mapActions(['fetchForms'])
    },
    created () {
        // this.fetchForms();
    },
}
</script>

<style>

</style>
