import {reactive} from 'vue';
import {ElNotification} from "element-plus";

const Store = {
    push(message, type = 'error') {
        ElNotification({
            title: 'Notification',
            message: message,
            type: type,
        })
    }
}

export default {
    install(app) {
        app.config.globalProperties.$notification = reactive(Store);
    }
};
