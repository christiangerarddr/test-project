<template>
    <AppLayout :title="project.title">
        <template #header>
            <div class="flex justify-between items-center">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    {{ project.title }}
                </h2>
                <Link
                    :href="route('projects.index')"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                >
                    Back to Projects
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Project Details -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6"
                >
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4"
                            >
                                Project Details
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <span
                                        class="text-gray-500 dark:text-gray-400"
                                        >Description:</span
                                    >
                                    <p
                                        class="mt-1 text-gray-900 dark:text-gray-100"
                                    >
                                        {{
                                            project.description ||
                                            "No description"
                                        }}
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-500 dark:text-gray-400"
                                        >Status:</span
                                    >
                                    <span
                                        class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                        :class="{
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100':
                                                project.status ===
                                                'not_started',
                                            'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100':
                                                project.status ===
                                                'in_progress',
                                            'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100':
                                                project.status === 'completed',
                                            'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300':
                                                project.status === 'on_hold',
                                        }"
                                    >
                                        {{ formatStatus(project.status) }}
                                    </span>
                                </div>
                                <div>
                                    <span
                                        class="text-gray-500 dark:text-gray-400"
                                        >Due Date:</span
                                    >
                                    <span
                                        class="ml-2 text-gray-900 dark:text-gray-100"
                                        >{{
                                            formatDate(project.due_date)
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4"
                            >
                                Task Summary
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg"
                                >
                                    <div
                                        class="text-2xl font-bold text-gray-900 dark:text-gray-100"
                                    >
                                        {{ taskStats.total }}
                                    </div>
                                    <div
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        Total Tasks
                                    </div>
                                </div>
                                <div
                                    class="bg-green-50 dark:bg-green-900 p-4 rounded-lg"
                                >
                                    <div
                                        class="text-2xl font-bold text-green-900 dark:text-green-100"
                                    >
                                        {{ taskStats.completed }}
                                    </div>
                                    <div
                                        class="text-sm text-green-500 dark:text-green-400"
                                    >
                                        Completed
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="flex justify-between items-center mb-6">
                        <h3
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Tasks
                        </h3>
                        <PrimaryButton
                            @click="createTask"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >
                            Add Task
                        </PrimaryButton>
                    </div>

                    <TextInput v-model="filterString" placeholder="Filter table" class="mb-2"/>

                    <div v-if="tasks.length === 0" class="text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400 mb-2">
                            No tasks found
                        </div>
                        <div class="text-sm text-gray-400 dark:text-gray-500">
                            Get started by adding your first task
                        </div>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        @click="sortTable('title')"
                                    >
                                        Title
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        @click="sortTable('status')"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        @click="sortTable('priority')"
                                    >
                                        Priority
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        @click="sortTable('completion_date')"
                                    >
                                        Completion Date
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
                                <tr v-for="task in sortedTasks" :key="task.id">
                                    <td class="px-6 py-4">
                                        <div
                                            class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                        >
                                            {{ task.title }}
                                        </div>
                                        <div
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ task.description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100':
                                                    task.status ===
                                                    'not_started',
                                                'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100':
                                                    task.status ===
                                                    'in_progress',
                                                'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100':
                                                    task.status === 'completed',
                                            }"
                                        >
                                            {{ formatStatus(task.status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300':
                                                    task.priority === 'low',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100':
                                                    task.priority === 'medium',
                                                'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100':
                                                    task.priority === 'high',
                                            }"
                                        >
                                            {{
                                                task.priority
                                                    .charAt(0)
                                                    .toUpperCase() +
                                                task.priority.slice(1)
                                            }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{
                                            task.completion_date
                                                ? formatDate(
                                                      task.completion_date
                                                  )
                                                : "Not completed"
                                        }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3"
                                    >
                                        <button
                                            v-if="task.status !== 'completed'"
                                            @click="markAsCompleted(task)"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-500 dark:text-green-400 bg-white dark:bg-gray-800 hover:text-green-700 dark:hover:text-green-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                        >
                                            Complete
                                        </button>
                                        <button
                                            @click="editTask(task)"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteTask(task)"
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

        <!-- Task Modal -->
        <Modal :show="showTaskModal" @close="closeTaskModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    {{ taskForm.id ? "Edit Task" : "Create Task" }}
                </h2>

                <div class="mt-6">
                    <form @submit.prevent="submitTaskForm">
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="taskForm.title"
                                required
                            />
                            <InputError
                                :message="taskForm.errors.title"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                v-model="taskForm.description"
                                rows="3"
                            ></textarea>
                            <InputError
                                :message="taskForm.errors.description"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="status" value="Status" />
                            <select
                                id="status"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                v-model="taskForm.status"
                                required
                            >
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            <InputError
                                :message="taskForm.errors.status"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="priority" value="Priority" />
                            <select
                                id="priority"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                v-model="taskForm.priority"
                                required
                            >
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            <InputError
                                :message="taskForm.errors.priority"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton
                                @click="closeTaskModal"
                                class="mr-3"
                            >
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton :disabled="taskForm.processing">
                                {{ taskForm.id ? "Update" : "Create" }}
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
import { useForm, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    tasks: {
        type: Array,
        required: true,
    },
    taskStats: {
        type: Object,
        required: true,
    },
    selectedTask: {
        type: Object,
        required: false,
        default: null,
    },
});

const showTaskModal = ref(false);
const taskForm = useForm({
    id: null,
    title: "",
    description: "",
    status: "not_started",
    priority: "medium",
    completion_date: null,
});

const createTask = () => {
    taskForm.reset();
    showTaskModal.value = true;
};

const editTask = (task) => {
    taskForm.id = task.id;
    taskForm.title = task.title;
    taskForm.description = task.description;
    taskForm.status = task.status;
    taskForm.priority = task.priority;
    taskForm.completion_date = task.completion_date;
    showTaskModal.value = true;
};

const closeTaskModal = () => {
    showTaskModal.value = false;
    taskForm.reset();
};

const submitTaskForm = () => {
    if (taskForm.id) {
        taskForm.put(route("tasks.update", taskForm.id), {
            preserveScroll: true,
            onSuccess: () => closeTaskModal(),
        });
    } else {
        taskForm.post(route("projects.tasks.store", props.project.id), {
            preserveScroll: true,
            onSuccess: () => closeTaskModal(),
        });
    }
};

const deleteTask = (task) => {
    if (confirm("Are you sure you want to delete this task?")) {
        taskForm.delete(route("tasks.destroy", task.id), {
            preserveScroll: true,
        });
    }
};

const markAsCompleted = (task) => {
    taskForm.put(
        route("tasks.update", task.id),
        {
            ...task,
            status: "completed",
            completion_date: new Date().toISOString().split("T")[0],
        },
        {
            preserveScroll: true,
        }
    );
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

const filterString = ref('');
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

const sortedTasks = computed(() => {


    let filteredTasks = props.tasks;

    if (filterString.value) {
        filteredTasks = props.tasks.filter(project => {
            const filterValue = filterString.value.toLowerCase();
            return Object.entries(project).some(([key, value]) => {
                if (key === 'completion_date') {
                    value = formatDate(value)
                }
                return String(value).toLowerCase().includes(filterValue);
            });
        });
    }

    if (!sortColumn.value) return filteredTasks;

    return [...filteredTasks].sort((a, b) => {
        const aValue = a[sortColumn.value];
        const bValue = b[sortColumn.value];

        if (aValue < bValue) return -sortOrder.value;
        if (aValue > bValue) return sortOrder.value;
        return 0;
    });
});
</script>
