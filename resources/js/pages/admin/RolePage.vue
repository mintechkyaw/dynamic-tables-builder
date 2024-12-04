<template>
<v-container>
    <v-row>
        <v-col cols="6">
            <h2 class="mb-2">Create Role</h2>
            <v-text-field label="Enter Role"></v-text-field>
            <v-btn variant="tonal">Create</v-btn>
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
                    <tr>
                        <td>1</td>
                        <td>admin</td>
                        <td>
                            <v-btn color="warning" size="x-small">Delete</v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>
