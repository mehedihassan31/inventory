<template>
    <div>
        <h4 class="text-center">Add Item</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addItem">
                    <div class="form-group">
                        <label>Inventory</label>
                        <select class="form-control" v-model="item.inventory_id">
                            <option v-for="inventory in inventories" :key="inventory.id" :value="inventory.id">{{ inventory.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="item.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="item.description">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control-file" @change="onFileChange">
                        <img v-if="imagePreview" :src="imagePreview" alt="Image Preview" style="max-width: 200px;">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" v-model="item.quantity">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
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
            imagePreview: null
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
                this.$router.push({name: 'items'});
            })
            .catch(error => {
                console.error(error);
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
