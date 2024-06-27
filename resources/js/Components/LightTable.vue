<script setup lang="ts">
import {watch, reactive, ref, computed} from "vue";
import { Link } from '@inertiajs/vue3';
import type { Header, Item, ServerOptions } from "vue3-easy-data-table";
import NavLink from "@/Components/NavLink.vue";
const props = defineProps<{
    paginatedDataObj: object;
}>();
const isLoading = ref(true)
watch(props.paginatedDataObj, async (newState, oldState) => {
    if(newState !== oldState){
        isLoading.value = false;
    }
});

const headers: Header[] = [
    { text: "Title", value: "title", width: 300},
 //   { text: "Original title", value: "original_title", width: 200},
    { text: "Popularity", value: "popularity", width: 100},
    //{ text: "Revenue", value: "revenue"},
    { text: "Runtime", value: "runtime",  width: 50},
    //{ text: "Vote average", value: "vote_average", sortable: true},
    //{ text: "Vote count", value: "vote_count", width: 200},
    { text: "Budget", value: "budget", width: 50},
    { text: "Overview", value: "overview", width: 500},
];

const items = ref<Item[]>([]);
const loading = ref(false);
const serverItemsLength = ref(0);
const serverOptions = ref<ServerOptions>({
    page: props.paginatedDataObj.current_page,
    rowsPerPage: props.paginatedDataObj.per_page,
    sortBy: 'age',
    sortType: 'desc',
});

const loadFromServer = async () => {
    loading.value = true;
    items.value = props.paginatedDataObj.data;
    serverItemsLength.value = props.paginatedDataObj.total;
    loading.value = false;
};

const lastPageItem = computed(() => {
    return {_query:{page:props.paginatedDataObj.last_page}};
});
const firstPageItem = computed(()=>{
    return {_query:{page:1}}
});

const nextPageItem = computed(()=>{
    let next;
    if(props.paginatedDataObj.current_page < props.paginatedDataObj.last_page){
        next = props.paginatedDataObj.current_page + 1;
    }else{
        next = props.paginatedDataObj.current_page;
    }
    return {_query:{page:next}};
})

const prevPageItem = computed(()=>{
    let prev;
    if(props.paginatedDataObj.current_page > 1)
    {
        prev = props.paginatedDataObj.current_page - 1;
    }else{
        prev = props.paginatedDataObj.current_page;
    }
    return {_query:{page:prev}};
})

// initial load
loadFromServer();

watch(serverOptions, (value) => { loadFromServer(); }, { deep: true });

</script>

<template>

<!--    <NavLink-->
<!--        :href="route('provider.index')"-->
<!--        :active="route().current('provider.index')"-->
<!--        v-if="page.props.auth.user.role === 'admin'">-->
<!--        Providers-->
<!--    </NavLink>-->

    <div>

        <div>
            <EasyDataTable
                v-model:server-options="serverOptions"
                :server-items-length="serverItemsLength"
                :loading="loading"
                :headers="headers"
                :items="items"
                theme-color="#1d90ff"
                table-class-name="customize-table"
                header-text-direction="left"
                body-text-direction="left"
                hide-rows-per-page="true"
            >
                <template #pagination="{ prevPage, nextPage,isFirstPage, isLastPage}">
                    <NavLink class="px-2" :href="route('movie.index',firstPageItem)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M10.72 11.47a.75.75 0 0 0 0 1.06l7.5 7.5a.75.75 0 1 0 1.06-1.06L12.31 12l6.97-6.97a.75.75 0 0 0-1.06-1.06l-7.5 7.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.72 11.47a.75.75 0 0 0 0 1.06l7.5 7.5a.75.75 0 1 0 1.06-1.06L6.31 12l6.97-6.97a.75.75 0 0 0-1.06-1.06l-7.5 7.5Z" clip-rule="evenodd" />
                        </svg>
                    </NavLink>
                    <NavLink class="px-2" :href="route('movie.index',prevPageItem)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </NavLink>
                    <NavLink class="px-2" :href="route('movie.index',nextPageItem)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </NavLink>
                    <NavLink class="px-2" :href="route('movie.index',lastPageItem)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                        </svg>
                    </NavLink>
                </template>
            </EasyDataTable>
        </div>
    </div>
</template>

<style scoped>
.customize-table {
    --easy-table-border: 1px solid #445269;
    --easy-table-row-border: 1px solid #445269;

    --easy-table-header-font-size: 16px;
    --easy-table-header-height: 50px;
    --easy-table-header-font-color: #c1cad4;
    --easy-table-header-background-color: #2d3a4f;

    --easy-table-header-item-padding: 10px 15px;

    --easy-table-body-even-row-font-color: #fff;
    --easy-table-body-even-row-background-color: #4c5d7a;

    --easy-table-body-row-font-color: #c0c7d2;
    --easy-table-body-row-background-color: #2d3a4f;
    --easy-table-body-row-height: 50px;
    --easy-table-body-row-font-size: 15px;

    --easy-table-body-row-hover-font-color: #2d3a4f;
    --easy-table-body-row-hover-background-color: #eee;

    --easy-table-body-item-padding: 10px 15px;

    --easy-table-footer-background-color: #2d3a4f;
    --easy-table-footer-font-color: #c0c7d2;
    --easy-table-footer-font-size: 14px;
    --easy-table-footer-padding: 0px 10px;
    --easy-table-footer-height: 50px;

    --easy-table-rows-per-page-selector-width: 70px;
    --easy-table-rows-per-page-selector-option-padding: 10px;
    --easy-table-rows-per-page-selector-z-index: 1;


    --easy-table-scrollbar-track-color: #2d3a4f;
    --easy-table-scrollbar-color: #2d3a4f;
    --easy-table-scrollbar-thumb-color: #4c5d7a;;
    --easy-table-scrollbar-corner-color: #2d3a4f;

    --easy-table-loading-mask-background-color: #2d3a4f;
}
</style>
