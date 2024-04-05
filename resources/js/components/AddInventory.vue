<template>
    <div>
        <h4 class="text-center">Add Inventory</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addinventory">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="inventory.name">
                        <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="inventory.description">
                        <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Add Inventory</button>
                    <div class="alert alert-success mt-3" v-if="successMessage">{{ successMessage }}</div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inventory: {},
            errors: {},
            successMessage: ''
        }
    },
    methods: {
        addinventory() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/inventories', this.inventory)
                    .then(response => {
                        this.successMessage = 'Inventory added successfully.';
                        setTimeout(() => {
                            this.$router.push({ name: 'inventories' });
                        }, 1500);
                    })
                    .catch(function (error) {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            console.error(error);
                        }
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
