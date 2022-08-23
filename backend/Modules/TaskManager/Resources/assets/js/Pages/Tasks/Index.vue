<template>
    <task-layout>

        <div class="flex w-full">

            <partial-tasks
                @create="openCreate"
                @select="openShow"
                class="mr-4"
                :tasks="tasks"
            />

            <div class="w-full min-h-[300px] max-h-[400px]">

                <partial-task-show
                    v-if="selected && !create"
                    :task="selected"
                    :repeat-types="repeat_types"
                    :repeats-properties="repeats_properties"
                    @close="closeAll"
                />

                <partial-task-create
                    v-if="!selected && create"
                    :repeat-types="repeat_types"
                    :repeats-properties="repeats_properties"
                    @close="closeAll"
                />

                <div v-else class="flex items-center justify-center h-full w-full">
                    Please select a task
                </div>

            </div>
        </div>

        <notifications />
    </task-layout>
</template>

<script>
import TaskLayout from "@taskmanager/Layouts/TaskLayout";
import PartialTasks from "./Partials/PartialTasks";
import PartialTaskShow from "./Partials/PartialTaskShow";
import PartialTaskCreate from "./Partials/PartialTaskCreate";
import Notifications from "../../Mixins/Notifications";

export default {
    name: "Index",
    components: {Notifications, PartialTaskCreate, PartialTaskShow, PartialTasks, TaskLayout},
    props: {
        tasks: Object,
        repeat_types: Object,
        repeats_properties: Object,
    },
    data() {
        return {
            selected: null,
            create: false,
            time: null,
        }
    },
    methods: {
        openShow(task) {
            this.create = false;
            this.selected = task;
        },
        openCreate() {
            this.selected = null;
            this.create = true;
        },
        closeAll() {
            this.selected = null;
            this.create = false;
        }
    }
}
</script>

<style scoped>

</style>
