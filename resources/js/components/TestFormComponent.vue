<template>
    <div class="form-container">
        <div class="form-wrapper">
            <form method="post" :action="testAction">
                <slot></slot>
                <span class="form-title" v-text="formTitle"></span>
                <input v-if="method === 'put'" type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="title">Testo pavadinimas</label>
                    <input class="form-control" :class="{'border-success':title,'border-danger':!title}" type="text"
                           id="title" name="title" v-model="title" maxlength="60" autofocus required>
                    <small v-for="error in parsedErrors" class="text-danger" v-text="error"></small>
                </div>
                <div class="form-group">
                    <input :disabled="!title" class="btn btn-success" type="submit" value="Išsaugoti">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                parsedErrors: ''
            }
        },
        props: {
            testAction: {
                type: String,
                required: true
            },
            method: {
                type: String,
                default: 'post'
            },
            formTitle: {
                type: String,
                required: true
            },
            title: {
                type: String,
                default: ''
            },
            errors: {
                type: String
            }
        },
        mounted() {
            this.parsedErrors = JSON.parse(this.errors);
        }
    }
</script>

