<template>
    <div class="flex gap-1 flex items-center"
         v-for="option in options">
        <input
            :disabled="disabled"
            @change="change"
            v-model="modelValue"
            type="checkbox"
            :value="option.value"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        >
        <p>{{ option.label }}</p>
    </div>
</template>

<script>
import Checkbox from "./Checkbox";
export default {
    name: "CheckboxGroup",
    components: {Checkbox},
    props: {
        modelValue: Array,
        options: Array,
        disabled: Boolean
    },
    emits: ['update:modelValue'],
    methods: {
        change() {
            this.$emit('update:modelValue', this.modelValue)
        }
    }
}
</script>

<style scoped>

</style>
