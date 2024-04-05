<template>
    <div>
        <h4 class="text-center">Add Item</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group m-2">
                        <label>Inventory</label>
                        <select class="form-control" v-model="item.inventory_id">
                            <option v-for="inventory in inventories" :key="inventory.id" :value="inventory.id">{{
                    inventory.name }}</option>
                        </select>

                        <div class="invalid-feedback" v-if="errors.inventory_id">{{ errors.inventory_id[0] }}</div>
                    </div>
                    <div class="form-group m-2">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="item.name">
                        <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</div>
                    </div>
                    <div class="form-group m-2">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="item.description">
                        <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>

                    </div>
                    <div class="form-group m-2">
                        <label>Image</label>
                        <input type="file" class="form-control-file" @change="onFileChange">
                        <img v-if="imagePreview" :src="imagePreview" alt="Image Preview" style="max-width: 200px;">

                        <span class="text-danger" v-if="errors.image">{{ errors.image[0] }}</span>

                    </div>
                    <div class="form-group m-2">
                        <label>Quantity</label>
                        <input type="number" class="form-control" v-model="item.quantity">
                        <span class="text-danger" v-if="errors.quantity">{{ errors.quantity[0] }}</span>

                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add Item</button>
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
            item: {
                inventory_id: null,
                name: '',
                description: '',
                image: null,
                quantity: 0
            },
            inventories: [],
            imagePreview: null,
            errors: {},
            successMessage: ''

        }
    },
    created() {
        this.fetchInventories();
    },
    methods: {
        fetchInventories() {
            this.$axios.get('/api/inventories')
                .then(response => {
                    this.inventories = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        onFileChange(event) {
            this.item.image = event.target.files[0];
            this.previewImage(event.target.files[0]);
        },
        previewImage(file) {
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        addItem() {
            let formData = new FormData();
            formData.append('inventory_id', this.item.inventory_id);
            formData.append('name', this.item.name);
            formData.append('description', this.item.description);
            formData.append('image', this.item.image);
            formData.append('quantity', this.item.quantity);

            this.$axios.post('/api/items', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.successMessage = 'Inventory added successfully.';
                    setTimeout(() => {
                        this.$router.push({ name: 'items' });
                    }, 1500);
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors
                        this.errors = error.response.data.errors;
                    } else {
                        console.error(error);
                    }
                });
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
