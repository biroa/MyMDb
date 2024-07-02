<script setup lang="ts">
import {watch, ref, computed, Ref} from "vue";
import {Header, Item, ServerOptions} from "vue3-easy-data-table";
import NavLink from "@/Components/NavLink.vue";
import type {Props, ItemData} from "@/Contracts/PaginatedDataObjProps";
import Modal from "@/Components/Modal.vue";
import dayjs from 'dayjs'


const props = defineProps<Props>();
const isLoading = ref(true)
watch(props.paginatedDataObj, async (newState, oldState) => {
    if(newState !== oldState){
        isLoading.value = false;
    }
});

const headers: Header[] = [
    { text: "Title", value: "title", width: 300},
 //   { text: "Original title", value: "original_title", width: 200},
    { text: "Popularity", value: "popularity", width: 150},
    //{ text: "Revenue", value: "revenue"},
    { text: "Runtime", value: "runtime",  width: 100},
    //{ text: "Vote average", value: "vote_average", sortable: true},
    { text: "Vote count", value: "vote_count", width: 100},
    { text: "Budget", value: "budget", width: 100},
    // { text: "Overview", value: "overview", width: 500},
    { text: "View", value: "view",width:50},
    { text: "Edit", value: "edit",width:50},
    { text: "Get Details", value: "get-details", width:100},
];

const items = ref<Item[]>([]);
const loading = ref(false);
const serverItemsLength = ref(0);

/**
 * Represents the server options for a paginated data object.
 */
const serverOptions = ref<ServerOptions>({
    page: props.paginatedDataObj.current_page,
    rowsPerPage: props.paginatedDataObj.per_page,
    sortBy: 'age',
    sortType: 'desc',
});

/**
 * Loads data from the server and sets the corresponding values.
 * @async
 */
const loadFromServer = async () => {
    loading.value = true;
    items.value = props.paginatedDataObj.data;
    serverItemsLength.value = props.paginatedDataObj.total;
    loading.value = false;
};

/**
 * Convert date to YYYY-MM-DD type
 * @todo: We need to check the datatypes later ...
 * @param date
 */
const dayConverter = (date: Date | undefined | null | string)=> dayjs(date).format('YYYY-MM-DD');

/**
 * Represents the last item of the last page in a paginated data object.
 */
const lastPageItem = computed(() => {
    return {_query:{page:props.paginatedDataObj.last_page}};
});

/**
 * Description: Computed property to return the first page item object with a query parameter of page set to 1.
 *
 * @returns {Object} The first page item object with a query parameter of page set to 1.
 */
const firstPageItem = computed(()=>{
    return {_query:{page:1}}
});

/**
 * Calculate the next page item object based on the paginated data.
 *
 * @function nextPageItem
 * @returns {Object} - The next page item object with "_query" property.
 *
 */
const nextPageItem = computed(()=>{
    let next;
    if(props?.paginatedDataObj?.current_page < props?.paginatedDataObj?.last_page){
        next = props.paginatedDataObj.current_page + 1;
    }else{
        next = props.paginatedDataObj.current_page;
    }
    return {_query:{page:next}};
})

/**
 * Represents the previous page item of a paginated data object.
 */
const prevPageItem = computed(()=>{
    let prev;
    if(props?.paginatedDataObj?.current_page > 1)
    {
        prev = props.paginatedDataObj.current_page - 1;
    }else{
        prev = props.paginatedDataObj.current_page;
    }
    return {_query:{page:prev}};
})

const viewModal = ref(false);
const viewModel:Ref<ItemData | null> = ref(null)


const getMovieDetails = (row:ItemData) =>{
    console.log('Get Movie Detail By ID:' + row.id)
}

/**
 * Displays the clicked row information.
 */
const showRow = (row:ItemData) => {
    viewModal.value = true;
    viewModel.value = row

};

/**
 * Edit the clicked row information in a form ...
 * @param row
 */
const editModal = (row:ItemData)=>{
    console.log('Record ID:' + row.id)
}

/**
 * Closes the modal by setting the value of `viewModal` to false.
 */
const closeModal = () => {
    viewModal.value = false;
};

// initial load
loadFromServer();
watch(serverOptions, () => { loadFromServer(); }, { deep: true });

</script>

<template>
    <div>

        <div>
            <EasyDataTable
                v-model:server-options="serverOptions"
                fixed-expand="true"
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
                <template #expand="item">
                    <div class="font-normal" style="padding: 15px">
                        <h2 class="text-lg font-medium text-grey-400">Movie Overview</h2>
                        <p>{{item.overview}}</p>
                    </div>
                </template>
                <template #item-edit="item">
                    <div class="font-normal justify-center">
                        <button
                            @click.prevent="editModal(item)"
                            type="button"
                            class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                    </div>
                </template>
                <template #item-view="item">
                    <div class="font-normal justify-center">
                        <button
                            @click.prevent="showRow(item)"
                            type="button"
                            class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </template>
                <template #item-get-details="item">
                    <div class="font-normal justify-start">
                        <button
                            @click.prevent="getMovieDetails(item)"
                            type="button"
                            class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                            </svg>

                        </button>
                    </div>
                </template>
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
        <Modal :show="viewModal" @close="closeModal">
            <div class="p-6">
                <p class="text-md font-medium text-gray-900 dark:text-gray-100">
                    Movie Title:
                </p>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                     <i class="pl-2">{{viewModel?.title}}</i>
                </h2>

                <p class="mt-3 text-md font-medium text-gray-900 dark:text-gray-100">
                    Overview:
                </p>
                <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">
                    <i class="pl-2">{{viewModel?.overview}}</i>
                </p>
                <div class="mt-6">


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Metrics
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Value
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Budget
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel?.budget}}
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Revenue
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel?.revenue}}
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Runtime
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel?.runtime}}
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Release Date
                                </th>
                                <td class="px-6 py-4">
                                    {{dayConverter(viewModel?.release_date)}}
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Votes Average
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel?.vote_average}}
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Vote Count
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel?.vote_count}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </Modal>
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
