<script setup lang="ts">
import {watch, ref, computed} from "vue";
import {Header, Item, ServerOptions, ClickRowArgument} from "vue3-easy-data-table";
import NavLink from "@/Components/NavLink.vue";
import type {Props} from "@/Contracts/PaginatedDataObjProps";
import Modal from "@/Components/Modal.vue";
import dayjs from 'dayjs'
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";

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

const dayConverter = (date:string)=> dayjs(date).format('YYYY-MM-DD');

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

// initial load
loadFromServer();

watch(serverOptions, () => { loadFromServer(); }, { deep: true });

const viewModal = ref(false);
const viewModel = ref({})

/**
 * Displays the clicked row information.
 */
const showRow = (item: ClickRowArgument) => {
    viewModal.value = true;
    viewModel.value = {...item}

};

/**
 * Closes the modal by setting the value of `viewModal` to false.
 */
const closeModal = () => {
    viewModal.value = false;
};

</script>

<template>
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
                @click-row="showRow"
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
        <Modal :show="viewModal" @close="closeModal">
            <div class="p-6">
                <p class="text-md font-medium text-gray-900 dark:text-gray-100">
                    Movie Title:
                </p>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                     <i class="pl-2">{{viewModel.title}}</i>
                </h2>

                <p class="mt-3 text-md font-medium text-gray-900 dark:text-gray-100">
                    Overview:
                </p>
                <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">
                    <i class="pl-2">{{viewModel.overview}}</i>
                </p>
                <div class="mt-6">


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Budget
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Revenue
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Runtime
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Release Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Vote Average
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Vote Count
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{viewModel.budget}}
                                </th>
                                <td class="px-6 py-4">
                                    {{viewModel.revenue}}
                                </td>
                                <td class="px-6 py-4">
                                    {{viewModel.runtime}}
                                </td>
                                <td class="px-6 py-4">
                                    {{dayConverter(viewModel.release_date)}}
                                </td>
                                <td class="px-6 py-4">
                                    {{viewModel.vote_average}}
                                </td>
                                <td class="px-6 py-4">
                                    {{viewModel.vote_count}}
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
