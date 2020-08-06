<template>
    <a href="#" @click.prevent="copy" data-toggle="tooltip" :title="lang.testCopyGood">
        <i class="fas fa-link" :title="lang.testCopy"></i>
    </a>
</template>
<script>
export default {
    props: {
        langJson: {
            type: String,
            required: true
        },
        testShowRoute: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            lang: JSON.parse(this.langJson)
        }
    },
    mounted() {
        this.tooltip()
    },
    methods: {
        copy() {
            let dummy = document.createElement("input");
            document.body.appendChild(dummy);
            dummy.value = this.testShowRoute;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            setTimeout(() => {
                $('a[data-toggle="tooltip"]').tooltip('hide')
            }, 800)
        },
        tooltip() {
            $('a[data-toggle="tooltip"]').tooltip({
                placement: 'top',
                trigger: 'click',
            });
        }
    }
}
</script>
<style scoped>
i:hover {
    color: #649d66;
    transform: scale(1.2);
}
</style>
