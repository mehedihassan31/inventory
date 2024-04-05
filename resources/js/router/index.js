import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/pages/Home.vue';
import Register from '@/pages/Register.vue';
import Login from '@/pages/Login.vue';
import Dashboard from '@/pages/Dashboard.vue';

import Inventories from '@/components/Inventories.vue';
import AddInventory from '@/components/AddInventory.vue';
import EditInventory from '@/components/EditInventory.vue';

import Items from '@/components/Items.vue';
import AddItem from '@/components/AddItem.vue';
import EditItem from '@/components/EditItem.vue';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },

    {
        name: 'inventories',
        path: '/inventories',
        component: Inventories
    },
    {
        name: 'addinventory',
        path: '/inventories/add',
        component: AddInventory
    },
    {
        name: 'editinventory',
        path: '/inventories/edit/:id',
        component: EditInventory
    },

    {
        name: 'items',
        path: '/items',
        component: Items
    },
    {
        name: 'additem',
        path: '/items/add',
        component: AddItem
    },
    {
        name: 'editItem',
        path: '/items/edit/:id',
        component: EditItem
    },


];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
