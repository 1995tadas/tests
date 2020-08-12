<template>
    <div>
        <a href="#" @click.prevent="showResults">{{lang.showResults}}</a>
        <span>{{'(' + lang.showResultsNote + ')'}}</span>
    </div>
</template>

<script>
export default {
    props: {
        langJson: {
            type: String,
            required: true
        },
        showResultsRoute: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            lang: JSON.parse(this.langJson)
        }
    },
    methods: {
        showResults() {
            axios.post(this.showResultsRoute, {_method: 'put'}).then((response) => {
                if (response.data) {
                    location.reload();
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
<style scoped>
span {
    font-size: 0.8em;
}
</style>
