<template>
    <div class="max-w-sm flex flex-col gap-4 w-full">

        <div @click="$emit('create')" class="p-4 flex items-center gap-4 bg-green-100 hover:bg-green-200 cursor-pointer rounded-md shadow">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <h3 class="font-bold text-base">Create new task</h3>

        </div>

        <div v-if="tasks.missed && tasks.missed.length" class="p-4 rounded-md shadow">

            <h3 class="font-bold text-base mb-4">Missed</h3>

            <ul class="text-sm">
                <task-li
                    v-for="task in tasks.missed"
                    :task="task"
                    :key="task.id"
                    @select="$emit('select', task)"
                />
            </ul>
        </div>

        <div v-if="tasks.today && tasks.today.length" class="p-4 rounded-md shadow">
            <h3 class="font-bold text-base mb-4">Today</h3>
            <ul class="text-sm">
                <task-li
                    v-for="task in tasks.today"
                    :task="task"
                    :key="task.id"
                    @select="$emit('select', task)"
                />
            </ul>
        </div>

        <div v-if="tasks.tomorrow && tasks.tomorrow.length" class="p-4 rounded-md shadow">

            <h3 class="font-bold text-base mb-4">Tomorrow</h3>

            <ul class="text-sm">
                <task-li
                    v-for="task in tasks.tomorrow"
                    :task="task"
                    :key="task.id"
                    @select="$emit('select', task)"
                />
            </ul>
        </div>

        <div v-if="tasks.next_week && tasks.next_week.length" class="p-4 rounded-md shadow">

            <h3 class="font-bold text-base mb-4">Next Week</h3>

            <ul class="text-sm">
                <task-li
                    v-for="task in tasks.next_week"
                    :task="task"
                    :key="task.id"
                    @select="$emit('select', task)"
                />
            </ul>
        </div>

        <div v-if="tasks.after_week && tasks.after_week.length" class="p-4 rounded-md shadow">

            <h3 class="font-bold text-base mb-4">After Week</h3>

            <ul class="text-sm">
                <task-li
                    v-for="task in tasks.after_week"
                    :task="task"
                    :key="task.id"
                    @select="$emit('select', task)"
                />
            </ul>
        </div>
    </div>
</template>

<script>
import TaskLi from "./TaskLi";
export default {
    name: "PartialTasks",
    components: {TaskLi},
    props: {
        tasks: Object,
    },
}
</script>

<style scoped>

</style>
