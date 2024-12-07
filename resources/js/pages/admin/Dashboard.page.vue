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
            <v-tab v-if="$can('read','user')" to="/user-list" prepend-icon="fa-solid fa-users">
                Users
            </v-tab>
            <v-tab v-if="$can('create','user')" to="/user-create" prepend-icon="fa-solid fa-user-plus">
                Create User
            </v-tab>
            <v-tab v-if="$can('manage','all')" to="/role" prepend-icon="fa-solid fa-key">
                Role
            </v-tab>
            <v-tab v-if="$can('create','form')" to="/forms" prepend-icon="fa-brands fa-wpforms">
                Forms
            </v-tab>
            <v-tab v-if="$can('read','form')" to="/tables" prepend-icon="fa-solid fa-database">
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
      <v-spacer></v-spacer>
      <div class="me-6">
        <v-icon left icon="fa fa-user" class="me-1"></v-icon>
        <span v-if="authUser">{{ authUser.name }}</span>
        <span v-else>Loading...</span>
      </div>
    </v-app-bar>

    <v-main
      class="d-flex align-center justify-center"
      style="min-height: 300px"
    >
      <router-view></router-view>
    </v-main>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import ability from "../../services/ability";

export default {
  data() {
    return {
      drawer: null,
    };
  },
  methods: {
    logout() {
      alert(" Are you sure you want to logout?");
      localStorage.removeItem("token");
      this.$store.commit("clearUser");
      this.$router.push("/login");
    },
    ...mapActions(["fetchForms", "authUserApi"]),
  },
  computed: {
    ...mapGetters(["authUser"]),
    $can() {
      return ability.can.bind(ability);
    },
  },
  async created() {
    // this.fetchForms();
    await this.authUserApi();
    // console.log(this.authUser);
  },
};
</script>
