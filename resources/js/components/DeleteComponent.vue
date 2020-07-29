<template>
    <a href="#" @click.prevent="deleteItem">
        <i class="fas fa-trash" title="Ištrinti"></i>
    </a>
</template>
<script>
    export default {
        props: {
            route: String,
            redirectRoute: String
        },
        created() {
            console.log(this.route);
        },
        methods: {
            deleteItem() {
                if (confirm('Ar tikrai norite ištrinti?')) {
                    axios.post(this.route, {_method: 'delete'}).then(() => {
                        window.location.replace(this.redirectRoute)
                    })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        }
    }
</script>
