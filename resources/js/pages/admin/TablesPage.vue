<template>
    <v-app>
      <v-container>
        <v-row>
          <v-col
            v-for="(dessert, index) in desserts"
            :key="index"
            cols="12"
            sm="6"
            md="4"
            lg="3"
            class="mb-4"
          >
            <v-card outlined class="pa-4 text-center" @click="SubmitTable(dessert.id)" >
              <v-card-title class="text-h6 font-weight-bold">
                {{ dessert.name }}
              </v-card-title>
              <v-card-subtitle>
                <span :class="{ 'text-success': dessert.published }">
                  {{ dessert.published ? 'Published' : 'Not Published' }}
                </span>
              </v-card-subtitle>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-app>
  </template>
  <script>
  export default {
    data() {
      return {
        desserts: [
          { name: "Frozen Yogurt", published: true,id : 1 },
          { name: "Ice cream sandwich", published: true ,id : 2},
          { name: "Eclair", published: true ,id : 3},
          { name: "Cupcake", published: true, id : 4 },
          { name: "Gingerbread", published: true, id : 5 },
          { name: "Jelly bean", published: true, id : 6 },
          { name: "Lollipop", published: true, id : 7 },
        ],
      };
    },
    methods: {
            SubmitTable(id) {
                this.$router.push({ name: 'SubmitTable', params: { id: id } });
            },
        },
  };
  </script>

<style scoped>
.text-success {
  color: green;
}
</style>
