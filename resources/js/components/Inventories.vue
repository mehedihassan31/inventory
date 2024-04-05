<template>
    <div>
        <h4 class="text-center">All inventorys</h4><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>User Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="inventory in inventories" :key="inventory.id">
                <td>{{ inventory.id }}</td>
                <td>{{ inventory.name }}</td>
                <td>{{ inventory.description }}</td>
                <td>{{ inventory.user_name }}</td>
                <td>{{ inventory.created_at }}</td>
                <td>{{ inventory.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editinventory', params: { id: inventory.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteinventory(inventory.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-info" @click="this.$router.push('/inventories/add')">Add inventory</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inventories: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/inventories')
                .then(response => {

                    console.log(response.data);
                    this.inventories = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteinventory(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/inventories/${id}`)
                    .then(response => {
                        let i = this.inventories.map(item => item.id).indexOf(id); // find index of your object
                        this.inventories.splice(i, 1)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
