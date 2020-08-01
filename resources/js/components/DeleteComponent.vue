<template>
    <a href="#" @click.prevent="deleteItem">
        <i class="fas fa-trash" :title="lang.delete"></i>
    </a>
</template>
<script>
export default {
    props: {
        langJson: {
            type: String,
            required: true
        },
        route: {
            type: String,
            required: true
        },
        redirectRoute: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            lang: JSON.parse(this.langJson)
        }
    },
    methods: {
        deleteItem() {
            if (confirm(this.lang.deleteConfirmation+'?')) {
                axios.post(this.route, {_method: 'delete'}).then(() => {
                    window.location.replace(this.redirectRoute)
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
}
</script>
