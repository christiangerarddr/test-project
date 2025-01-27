<template>
    <AppLayout title="Projects">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100"
                            >
                                Project List
                            </h3>
                        </div>
                        <PrimaryButton
                            @click="createProject"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >
                            Create Project
                        </PrimaryButton>
                    </div>

                    <div v-if="projects.length === 0" class="text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400 mb-2">
                            No projects found
                        </div>
                        <div class="text-sm text-gray-400 dark:text-gray-500">
                            Get started by creating your first project
                        </div>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    @click="sortTable('title')"
                                >
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    @click="sortTable('status')"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    @click="sortTable('due_date')"
                                >
                                    Due Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    @click="sortTable('tasks_count')"
                                >
                                    Tasks
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody
                                class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                            >
                            <tr
                                v-for="project in sortedProjects"
                                :key="project.id"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        {{ project.title }}
                                    </div>
                                    <div
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ project.description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100':
                                                    project.status ===
                                                    'not_started',
                                                'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100':
                                                    project.status ===
                                                    'in_progress',
                                                'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100':
                                                    project.status ===
                                                    'completed',
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300':
                                                    project.status ===
                                                    'on_hold',
                                            }"
                                        >
                                            {{ formatStatus(project.status) }}
                                        </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                >
                                    {{ formatDate(project.due_date) }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                >
                                    {{ project.tasks_count }} tasks
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3"
                                >
                                    <Link
                                        :href="
                                                route(
                                                    'projects.show',
                                                    project.id
                                                )
                                            "
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                    >
                                        View
                                    </Link>
                                    <button
                                        @click="editProject(project)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteProject(project)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 dark:text-red-400 bg-white dark:bg-gray-800 hover:text-red-700 dark:hover:text-red-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Project Modal -->
        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    {{ form.id ? "Edit Project" : "Create Project" }}
                </h2>

                <div class="mt-6">
                    <form @submit.prevent="submitForm">
                        <div>
                            <InputLabel for="title" value="Title"/>
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                            />
                            <InputError
                                :message="form.errors.title"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description"/>
                            <textarea
                                id="description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                v-model="form.description"
                                rows="3"
                            ></textarea>
                            <InputError
                                :message="form.errors.description"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="status" value="Status"/>
                            <select
                                id="status"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                v-model="form.status"
                                required
                            >
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                            <InputError
                                :message="form.errors.status"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="due_date" value="Due Date"/>
                            <TextInput
                                id="due_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.due_date"
                                required
                            />
                            <InputError
                                :message="form.errors.due_date"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal" class="mr-3">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton :disabled="form.processing">
                                {{ form.id ? "Update" : "Create" }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>

<script setup>
import {computed, ref} from "vue";
import {useForm, Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const showModal = ref(false);
const form = useForm({
    id: null,
    title: "",
    description: "",
    status: "not_started",
    due_date: "",
});

const createProject = () => {
    form.reset();
    showModal.value = true;
};

const editProject = (project) => {
    form.id = project.id;
    form.title = project.title;
    form.description = project.description;
    form.status = project.status;
    form.due_date = project.due_date;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
};

const submitForm = () => {
    if (form.id) {
        form.put(route("projects.update", form.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route("projects.store"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
};

const deleteProject = (project) => {
    if (confirm("Are you sure you want to delete this project?")) {
        form.delete(route("projects.destroy", project.id), {
            preserveScroll: true,
        });
    }
};

const formatStatus = (status) => {
    return status
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
};

const sortColumn = ref('');
const sortOrder = ref(1);

const sortTable = (column) => {
    if (sortColumn.value === column) {
        sortOrder.value = -sortOrder.value;
    } else {
        sortColumn.value = column;
        sortOrder.value = 1;
    }
}

const sortedProjects = computed(() => {
    if (!sortColumn.value) return props.projects;

    return [...props.projects].sort((a, b) => {
        const aValue = a[sortColumn.value];
        const bValue = b[sortColumn.value];

        if (aValue < bValue) return -sortOrder.value;
        if (aValue > bValue) return sortOrder.value;
        return 0;
    });
});

</script>
