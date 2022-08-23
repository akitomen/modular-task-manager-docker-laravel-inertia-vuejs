<template>
    <li class="bg-gray-100 rounded-md p-2 flex items-center gap-2 mb-2">
        <div class="w-full">
            <div class="font-bold">{{ task.title }}</div>
            <div>{{ task.date + ' ' + task.time }}</div>
        </div>
        <button type="button" @click="$emit('select')" class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
        </button>
    </li>
</template>

<script>
export default {
    name: "TaskLi",
    props: {
        task: Object
    }
}
</script>

<style scoped>

</style>
