<template>
    <input
        @change="change"
        v-model="modelValue"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        aria-describedby="addon-right addon-left"
        type="text"
    />
</template>

<script>
export default {
    name: "InputBase",
    emits: ['update:modelValue'],
    props: {
        modelValue: String
    },
    methods: {
        change(event) {
            this.$emit('update:modelValue', event.target.value)
        }
    }
}
</script>
