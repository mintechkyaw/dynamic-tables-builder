<template>
<v-layout>
    <v-navigation-drawer v-model="drawer">
        <v-list>
            <v-list-item title="Navigation drawer"></v-list-item>
            <v-list-group
                v-model="value"
                v-for="item in items"
                :key="key"
                :prepend-icon="icon"
                no-action
            >
                
            </v-list-group>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar color="primary" prominent>
        <v-btn color="" @click.stop="drawer = !drawer">
            <v-icon icon="fa-solid fa-bars" />
        </v-btn>
    </v-app-bar>

    <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
        Main Content
    </v-main>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            drawer: null,
        }
    }
}
</script>

<style>

</style>
