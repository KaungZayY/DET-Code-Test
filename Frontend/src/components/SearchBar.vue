<script setup>
import axios from 'axios';
import { reactive, onMounted } from 'vue';
import router from '@/router';
import { useToast } from 'vue-toastification';

const toast = useToast();

const state = reactive({
    categories: [],
    isLoading: true
});

const filters = reactive({
    category_id: '',
    title: '',
    from_date: '',
    to_date: '',
});

const handleFilter = async () => {
    // let queryParams = [];
    // if (filters.category_id) queryParams.push(`category_id=${filters.category_id}`);
    // if (filters.title) queryParams.push(`title=${encodeURIComponent(filters.title)}`);
    // if (filters.from_date) queryParams.push(`from_date=${filters.from_date}`);
    // if (filters.to_date) queryParams.push(`to_date=${filters.to_date}`);

    // const queryString = queryParams.join('&');
    // const url = `/items${queryString ? `?${queryString}` : ''}`;
}

onMounted(async () => {
    const response = await axios.get('/api/categories');
    state.categories = response.data.categories;
    state.isLoading = false;
})
</script>

<template>
    <div
        class="max-w-7xl mx-auto mt-4 mb-4 p-4 text-gray-900 bg-gray-100 dark:text-white dark:bg-gray-800 rounded-lg shadow-md">
        <form @submit.prevent="handleFilter" class="flex flex-wrap items-center gap-4">
            <!-- Category Filter -->
            <div class="w-full sm:w-auto">
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category
                </label>
                <select name="category_id" id="category_id" :disabled="state.isLoading" v-model="filters.category_id"
                    class="px-4 py-2 block w-full sm:w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Category</option>
                    <option v-for="category in state.categories" :key="category.id" :value="category.id">
                        {{ category.category }}
                    </option>
                </select>
            </div>

            <!-- Title Filter -->
            <div class="w-full sm:w-auto">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Title
                </label>
                <input type="text" name="title" id="title" placeholder="Title" v-model="filters.title"
                    class="px-4 py-2 block w-full sm:w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- From Date Filter -->
            <div class="w-full sm:w-auto">
                <label for="from_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    From Date
                </label>
                <input type="date" name="from_date" id="from_date" v-model="filters.from_date"
                    class="px-4 py-2 block w-full sm:w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- To Date Filter -->
            <div class="w-full sm:w-auto">
                <label for="to_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    To Date
                </label>
                <input type="date" name="to_date" id="to_date" v-model="filters.to_date"
                    class="px-4 py-2 block w-full sm:w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Search Button -->
            <div class="w-full sm:w-auto">
                <button type="submit"
                    class="w-full mt-5 sm:w-auto bg-indigo-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    Search
                </button>
            </div>
        </form>
    </div>
</template>