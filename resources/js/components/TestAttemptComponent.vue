<template>
    <div>
        <span v-if="saved" class="success">{{ lang.savedSuccess }}</span>
        <span v-else-if="error" class="fail">{{ lang.savedFailed }}</span>
        <div v-else class="attempt-form">
            <input @keydown.enter="saveAttempts" type="number" min="1" max="10" placeholder="1-10"
                   v-model="testAttempts">
            <button @click="saveAttempts">{{ lang.save }}</button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        langJson: {
            type: String,
            required: true
        },
        testAttempts: {
            type: Number,
            required: true
        },
        changeAttemptsRoute: {
            type: String,
            required: true
        },
        userId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            newTestAttempts: this.testAttempts,
            lang: JSON.parse(this.langJson),
            saved: false,
            error: false
        }
    },
    methods: {
        saveAttempts() {
            if (this.testAttempts <= 10 && this.testAttempts >= 1) {
                axios.post(this.changeAttemptsRoute, {
                    _method: 'put',
                    user_id: this.userId,
                    test_attempt_number: this.testAttempts
                }).then(() => {
                        this.saved = true;
                    }
                ).catch(
                    () => {
                        this.error = true;
                    }
                )
            } else {
                this.error = true;
            }
        }
    }
}
</script>
<style scoped>
.success {
    color: #1ede51;
}

.fail {
    color: #de1f24;
}

.attempt-form {
    white-space: nowrap;
}

input {
    line-height: 0.5;
}

button {
    background-color: black;
    color: white;
    box-shadow: none;
    border: 0;
    margin: 5px 0;
}
</style>
