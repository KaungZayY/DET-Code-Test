<script setup>
import Footer from '@/components/Footer.vue'
import Wrapper from '@/components/Wrapper.vue';
import AuthNavBar from '@/components/AuthNavBar.vue';
import SearchBar from '@/components/SearchBar.vue';
import ItemCard from '@/components/ItemCard.vue';

import axios from 'axios';
import { reactive, onMounted } from 'vue';
import router from '@/router';
import { useToast } from 'vue-toastification';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

const toast = useToast();

const state = reactive({
    items: [],
    isLoading: true
});

onMounted(async () => {
    try {
        const response = await axios.get('/api/items');
        state.items = response.data.items;
        // console.log(state.items)
    }
    catch (error) {
        if (error.response && error.response.status === 401) {
            toast.error('Login First!');
            router.push('/login');
        };
        // console.error('Error fetching data', error);
    }
    finally {
        state.isLoading = false;
    }
})
</script>

<template>
    <Wrapper>
        <AuthNavBar />
        <SearchBar />
        <h1 class="text-black dark:text-white text-2xl text-center pt-2">Items</h1>
        <div class="flex flex-row justify-end">
            <a href="#"
                class="items-center mr-2 px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Add Item
            </a>
        </div>
        <div v-if="state.isLoading" class="text-center text-gray-500 py-6">
            <PulseLoader />
        </div>
        <div v-else class="flex flex-col md:flex-row flex-wrap pt-2 pb-8">
            <ItemCard v-for="item in state.items" :key="item.id" :item="item" />
        </div>
    </Wrapper>
    <Footer />
</template>