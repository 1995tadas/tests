<template>
    <div>
        <span v-if="saved" class="success">{{ lang.savedSuccess }}</span>
        <span v-else-if="error" class="fail">{{ lang.savedFailed }}</span>
        <div v-else class="attempt-form">
            <input @keydown.enter="saveAttempts" type="number" :min="this.range[0]" :max="this.range[1]"
                   :placeholder="this.range[0]+'-'+this.range[1]"
                   v-model="newNumber">
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
        range: {
            type: Array,
            required: true
        },
        defaultNumber: {
            type: Number,
            required: true
        },
        storeRoute: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            newNumber: this.defaultNumber,
            lang: JSON.parse(this.langJson),
            saved: false,
            error: false,
        }
    },
    methods: {
        saveAttempts() {
            if (this.defaultNumber >= this.range[0] && this.defaultNumber <= this.range[1]) {
                axios.post(this.storeRoute, {
                    _method: 'put',
                    new_number: this.newNumber
                }).then((response) => {
                        if (response.data) {
                            this.saved = true;
                        } else {
                            this.setError();
                        }
                    }
                ).catch(
                    () => {
                        this.setError();
                    }
                )
            } else {
                this.setError();
            }
        },
        setError() {
            this.error = true;
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
    width: 40px;
}

button {
    background-color: black;
    color: white;
    box-shadow: none;
    border: 0;
    border-radius: 2px;
}
</style>
