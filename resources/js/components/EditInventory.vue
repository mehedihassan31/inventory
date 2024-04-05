<template>
    <div>
        <h4 class="text-center">Edit Inventory</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateInventory">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="inventory.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="inventory.description">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Inventory</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inventory: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/inventories/${this.$route.params.id}`)
                .then(response => {
                    console.log(response.data);
                    this.inventory = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateInventory() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put(`/api/inventories/${this.$route.params.id}`, this.inventory)
                    .then(response => {
                        this.$router.push({name: 'inventories'});
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
