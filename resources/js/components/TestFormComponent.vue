<template>
    <div class="form-container">
        <div class="form-wrapper">
            <form class="form" method="post" :action="testAction">
                <slot></slot>
                <span class="form-title" v-text="formTitle"></span>
                <input v-if="method === 'put'" type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="title">{{lang.testTitle}}</label>
                    <input class="form-control" :class="{'border-success':title,'border-danger':!title}" type="text"
                           id="title" name="title" v-model="title" maxlength="60" autofocus required>
                    <small v-for="error in parsedErrors" class="text-danger" v-text="error"></small>
                </div>
                <div class="form-group">
                    <input :disabled="!title" class="btn btn-success" type="submit" :value="lang.create">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lang: JSON.parse(this.langJson),
            parsedErrors: '',
            formTitle: ''
        }
    },
    props: {
        langJson: {
            type: String,
            required: true
        },
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
        errors:String
    },
    mounted() {
        this.changeTitle();
        this.parsedErrors = JSON.parse(this.errors);
    },
    methods: {
        changeTitle() {
            if (this.method === 'post') {
                this.formTitle = this.lang.newTest;
            } else if (this.method === 'put'){
                this.formTitle = this.lang.editTest;
            }
        }
    }
}
</script>

