<template>
    <div class="w-full h-full bg-gray-100 rounded-md p-4 relative">
        <button type="button" @click="$emit('close')" class="absolute right-0 top-0 inline-flex items-center border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="flex h-full w-full flex-col justify-between">
            <div class="h-full">
                <h2 class="font-bold text-base mb-2">{{ task.title }}</h2>
                <p class="text-sm">{{ task.description }}</p>

                <div class="mt-4 flex gap-4">
                    <date-input disabled v-model="form.start_date" />
                    <time-input disabled v-model="form.time" />
                    <div class="flex gap-2 items-center">
                        <checkbox disabled v-model="isRepeat" :checked="isRepeat" />
                        <p>Repeat</p>
                    </div>
                </div>
                <div v-if="isRepeat">

                    <div class="flex gap-2 items-center mt-2">
                        <p>End</p>
                        <date-input disabled v-model="form.end_date" />
                    </div>

                    <div class="flex gap-2 items-center mt-2">
                        <p>Repeat Type:</p>
                        <select-list
                            disabled
                            v-model="task.repeat_type"
                            :options="repeatTypes" />
                    </div>

                    <div v-if="currentPeriods" class="flex justify-end gap-2 mt-2">
                        <checkbox-group
                            disabled
                            v-model="task.repeat_period"
                            :options="currentPeriods" />
                    </div>

                </div>

            </div>
            <div class="flex justify-between mt-2">

                <button type="button" @click="completed" class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
                    Completed
                </button>

                <button v-if="isRepeat" type="button" @click="chainEnd" class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
                    End the chain
                </button>

            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import DateInput from "@taskmanager/Components/Date/DateInput";
import TimeInput from "@taskmanager/Components/Date/TimeInput";
import Checkbox from "@taskmanager/Components/Checkbox";
import SelectList from "@taskmanager/Components/SelectList";
import CheckboxGroup from "@taskmanager/Components/CheckboxGroup";
export default {
    name: "PartialTaskShow",
    components: {CheckboxGroup, SelectList, Checkbox, TimeInput, DateInput},
    props: {
        task: Object,
        repeatTypes: Object,
        repeatsProperties: Object,
    },
    data() {
        return {
            form: useForm({
                _method: 'PUT',
                start_date: this.task.start_date,
                time: this.task.time
            })
        }
    },
    methods: {
        completed() {
            this.form.put(this.route('taskmanager.completed', this.task.id), {
                onSuccess: () => this.$emit('close'),
            })
        },
        chainEnd() {
            this.form.put(this.route('taskmanager.chain-end', this.task.id), {
                onSuccess: () => this.$emit('close'),
            })
        },
    },
    computed: {
        isRepeat() {
            return !!this.task.repeat_type;
        },
        currentPeriods() {
            return this.task.repeat_type && this.repeatsProperties[this.task.repeat_type]
                ? this.repeatsProperties[this.task.repeat_type] : null
        }
    }
}

</script>
