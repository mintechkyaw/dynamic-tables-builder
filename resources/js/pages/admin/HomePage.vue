<template>
<v-container fluid>
    <v-row>
        <v-col cols="4">
            <v-card variant="outlined" style="height: 150px" class="text-center">
                <h3 class=" align-center">Users - 4</h3>
            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card variant="outlined" style="height: 150px" class="text-center">
                <h3 class=" align-center">Tables - 4</h3>
            </v-card>
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
    computed: {
        ...mapGetters(["getForms"]),
        $can() {
            return ability.can.bind(ability);
        }
    },
    methods: {
        ...mapActions(["fetchForms"])
    },
    mounted() {},
}
</script>

<style>

</style>
