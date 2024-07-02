<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LightTable from "@/Components/LightTable.vue";
import {Head, useForm} from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
const page = usePage();

const form = useForm({
    endpoint: '',
});

</script>

<template>
    <Head title="Movies" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Movies</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-3">
                    Import Movies
                </h3>
                <div class="max-w-7xl text-gray-300 mx-auto sm:px-6 lg:px-8 space-y-6 bg-white border dark:border-gray-400 dark:bg-gray-800 shadow sm:rounded-lg my-3">
                    <form @submit.prevent="" class="py-6 space-y-6">
                        <div>
<!--                            <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Search for movie</label>-->
                            <div class="flex">
  <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
    https://api.themoviedb.org/3/search/movie?query=
  </span>
                                <input type="text"
                                       id="website-admin"
                                       class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="eg: Inception, Pulp Fiction, Robin Hood">
                                <div>
                                    <button type="submit" class="mt-0.5 p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                        <span class="sr-only">Search</span>
                                    </button>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pl-3">
                    Browse Among Movies
                </h3>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-3">
                    <light-table :paginatedDataObj="page.props.movies"></light-table>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
