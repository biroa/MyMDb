<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
const page = usePage();
</script>

<template>
    <Head title="Providers" />

    <AuthenticatedLayout v-if="page.props.auth.user.role === 'admin'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Providers</h2>
        </template>
    </AuthenticatedLayout>
</template>
