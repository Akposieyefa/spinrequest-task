<template>
    <br />
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Task List</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all user tasks</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button
                    @click="open = true"
                    type="button"
                    class="block rounded-md bg-gray-800 hover:bg-gray-900  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Add New
                </button>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">No</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr v-for="(taskData, index ) in task.tasks" :key="taskData.slug">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ index+ 1 }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ taskData.title }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ taskData.description }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatDate(taskData.created_at) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <button  @click="editMode(taskData.slug)" class="text-indigo-600 hover:text-indigo-900">Edit</button> |
                                <button  @click="deleteTask(taskData.slug)" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10 " @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-lg text-center  leading-6 font-medium text-gray-900" v-if="edit"> Edit Task </DialogTitle>
                                    <DialogTitle as="h3" class="text-lg text-center  leading-6 font-medium text-gray-900" v-else> Add New Task </DialogTitle>

                                    <div class="flex flex-1 flex-col justify-between">
                                        <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                            <div class="space-y-6 pb-5 pt-6">
                                                <div>
                                                    <label for="project-name" class="block text-sm font-medium leading-6 text-gray-900 text-left">Title</label>
                                                    <div class="mt-2">
                                                        <input type="text" placeholder="Enter Task" v-model="task.task.title"  class="block w-full p-3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 " />
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900 text-left">Description</label>
                                                    <div class="mt-2">
                                                        <textarea id="description" v-model="task.task.description"  rows="4" class="block w-full p-3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                </div>
                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-3 sm:mt-2 divide-y divide-gray-200 px-4 sm:px-6">
                                <button type="button" class="inline-flex mr-5 rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm" @click="closeModal()">Close</button>
                                <button type="button" class="inline-flex  rounded-md border border-transparent shadow-sm px-4 py-2  bg-gray-800 hover:bg-gray-900 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm" v-if="edit" @click="updateTask(task.task.slug)" >Update</button>
                                <button type="button" class="inline-flex  rounded-md border border-transparent shadow-sm px-4 py-2  bg-gray-800 hover:bg-gray-900 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm" v-else @click="createTask()">Submit</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>

<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {onMounted, reactive, ref} from "vue";
import ApiService from "./services/api.js";
import UtilServices from "./services/utils.js"


const task = reactive({
    tasks: [],
    task : {
        title: "",
        description: ""
    }
})

const edit = ref(false)
const open = ref(false)

const getAllTasks = async ()=> {
    try {
        const response = await ApiService.get('tasks/all');
        task.tasks = response.data.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const  deleteTask = async  (slug) => {

    if (confirm("Do you really want to delete this record?")) {
        try {
            const response = await ApiService.delete( 'tasks/delete/' + slug);
            UtilServices.toaster(response.data.message, 'success');
            await getAllTasks()
        } catch (e) {
            UtilServices.toaster(e.response.data.message, 'error');
        }
    }
}

const createTask = async () => {
    try {
        const response = await ApiService.post('tasks/create', {
            title: task.task.title,
            description: task.task.description,
        })
        open.value = false;
        UtilServices.toaster(response.data.message, 'success');
        await getAllTasks()
    } catch (e) {
        UtilServices.toaster(e.response.data.message, 'error');
    }
}

const editMode = async  (slug) => {
    edit.value = true;
    open.value = true
    const response = await ApiService.get('tasks/single/' + slug);
    task.task = response.data.data;
}

const updateTask = async (slug) => {
    try {
        const response = await ApiService.patch('tasks/update/' + slug, {
            title: task.task.title,
            description: task.task.description,
        })
        UtilServices.toaster(response.data.message, 'success');
        open.value = false;
        await getAllTasks()
    } catch (e) {
        UtilServices.toaster(e.response.data.message, 'error');
    }
}

const closeModal = () => {
    edit.value = false
    open.value = false
}

const formatDate = (dateString)  => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

onMounted( async  () => {
    await getAllTasks();
});

</script>
