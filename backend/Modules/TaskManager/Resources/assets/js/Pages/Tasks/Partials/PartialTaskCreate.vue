<template>
    <div class="w-full h-full bg-gray-100 rounded-md p-4 relative">
        <button type="button" @click="$emit('close')"
                class="absolute right-0 top-0 inline-flex items-center border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        <div class="flex h-full w-full flex-col justify-between">
            <div class="h-full">
                <div class="flex gap-2 items-center mt-2">
                    <p>Title</p>
                    <input-base v-model="form.title"/>
                </div>

                <div class="flex flex-col gap-2 mt-2">
                    <p>Description</p>
                    <textarea-base v-model="form.description"/>
                </div>

                <div class="mt-4 flex gap-4">
                    <date-input v-model="form.start_date"/>
                    <time-input v-model="form.time"/>
                    <div class="flex gap-2 items-center">
                        <checkbox v-model="isRepeat" :checked="isRepeat"/>
                        <p>Repeat</p>
                    </div>
                </div>

                <div v-if="isRepeat">

                    <div class="flex gap-2 items-center mt-2">
                        <p>End</p>
                        <date-input v-model="form.end_date"/>
                    </div>

                    <div class="flex gap-2 items-center mt-2">
                        <p>Repeat Type:</p>
                        <select-list
                            v-model="form.repeat_type"
                            :options="repeatTypes"/>
                    </div>

                    <div v-if="currentPeriods" class="flex justify-end gap-2 mt-2">
                        <checkbox-group
                            v-model="form.repeat_period"
                            :options="currentPeriods"/>
                    </div>

                </div>

            </div>

            <div class="flex justify-between mt-2">
                <button type="button"
                        @click="submit"
                        class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
                    Create
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {useForm} from '@inertiajs/inertia-vue3';
import DateInput from "@taskmanager/Components/Date/DateInput";
import TimeInput from "@taskmanager/Components/Date/TimeInput";
import Checkbox from "@taskmanager/Components/Checkbox";
import SelectList from "@taskmanager/Components/SelectList";
import CheckboxGroup from "@taskmanager/Components/CheckboxGroup";
import InputBase from "@taskmanager/Components/InputBase";
import TextareaBase from "@taskmanager/Components/TextareaBase";

export default {
    name: "PartialTaskCreate",
    components: {TextareaBase, InputBase, CheckboxGroup, SelectList, Checkbox, TimeInput, DateInput},
    props: {
        repeatTypes: Object,
        repeatsProperties: Object,
    },
    data() {
        return {
            form: useForm({
                _method: 'POST',
                title: null,
                description: null,
                start_date: null,
                end_date: null,
                time: null,
                repeat_type: null,
                repeat_period: []
            }),
            repeat: false
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('taskmanager.store'), {
                onSuccess: () => this.$emit('close'),
            })
        }
    },
    computed: {
        isRepeat: {
            get() {
                return this.repeat;
            },
            set(value) {
                if (!value) {
                    this.form.reset('repeat_type', 'repeat_period', 'end_date');
                }
                this.form.repeat_type = Object.keys(this.repeatTypes)[0];
                this.repeat = value;
            }
        },
        currentPeriods() {
            return this.form.repeat_type && this.repeatsProperties[this.form.repeat_type]
                ? this.repeatsProperties[this.form.repeat_type] : null
        }
    },
    watch: {
        'form.repeat_type'() {
            this.form.reset('repeat_period');
        }
    }
}
</script>
