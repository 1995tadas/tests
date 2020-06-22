<template>
    <form method="post" :action="testAction">
    <slot></slot>
    <input v-if="method === 'put'" type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label for="title">Testo pavadinimas</label>
        <input class="form-control" :class="{'border-success':title,'border-danger':!title}" type="text" id="title" name="title" v-model="title">
        <small v-for = "error in parsedErrors" class="text-danger" v-text="error"></small>
    </div>
    <div class="form-group">
        <input :disabled="!title" class="btn btn-primary" type="submit" value="Išsaugoti" >
    </div>
    </form>
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
            title: {
                type: String,
                default: ''
            },
            errors:{
                type: String
            }
        },
        mounted() {
            this.parsedErrors = JSON.parse(this.errors);
        }
    }
</script>

