<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LightTable from "@/Components/LightTable.vue";
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3';
const page = usePage();
</script>

<template>
    <Head title="Movies" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Movies</h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<!--                <div class="flex flex-col items-center py-5">-->
<!--                <div class="inline-flex rounded-md shadow-sm" role="group">-->
<!--                    <Link type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">-->
<!--                        List the existing Movies-->
<!--                    </Link>-->
<!--                    <Link type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">-->
<!--                        Edit Movie-->
<!--                    </Link>-->
<!--                    <Link type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">-->
<!--                        Import a new Movie-->
<!--                    </Link>-->
<!--                </div>-->
<!--                </div>-->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <light-table :paginatedDataObj="page.props.movies"></light-table>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
