<template>
    <div>
        <h4 class="text-center">All Items</h4><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Inventory</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.inventory_name }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.description }}</td>
                <td><img :src="item.image" alt="Item Image" style="max-width: 100px;"></td>
                <td>{{ item.quantity }}</td>
                <td>{{ item.created_at }}</td>
                <td>{{ item.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editItem', params: { id: item.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteItem(item.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-info" @click="$router.push('/items/add')">Add Item</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/items')
                .then(response => {
                    console.log(response.data);
                    this.items = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },

    methods: {
        deleteItem(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/items/${id}`)
                    .then(response => {
                        let i = this.items.map(item => item.id).indexOf(id); // find index of your object
                        this.items.splice(i, 1)
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
