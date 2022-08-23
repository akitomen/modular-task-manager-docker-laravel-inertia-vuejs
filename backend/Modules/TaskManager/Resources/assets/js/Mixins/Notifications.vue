<script>
export default {
    name: "Notifications",
    components: {Notification},
    methods: {
        setFlash() {
            for (let type in this.flashMessages) {
                if (this.$page.props.flash[type]) {
                    this.$notification.push(this.$page.props.flash[type], type);
                }
            }
        },
        setFormErrors() {
            for (let formName in this.validations) {
                if (typeof this.validations[formName] === 'string') {
                    this.$notification.push(this.validations[formName]);
                } else if (typeof this.validations[formName] === 'object'
                    || typeof this.validations[formName] === 'array') {
                    for (let errorName in this.validations[formName]) {
                        this.$notification.push(this.validations[formName][errorName]);
                    }
                } else {
                    this.$notification.push('Unknown error.');
                }
            }
        }
    },
    computed: {
        flashMessages() {
            return this.$page.props ? this.$page.props.flash : {};
        },
        validations() {
            return this.$page.props ? this.$page.props.errors : {};
        }
    },
    watch: {
        flashMessages: function () {
            this.setFlash();
        },
        validations: function () {
            this.setFormErrors();
        }
    }
}
</script>
