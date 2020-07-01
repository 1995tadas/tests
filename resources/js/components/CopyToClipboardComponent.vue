<style scoped>
    i:hover {
        color: #649d66;
        transform: scale(1.2);
    }
</style>
<template>
    <a href="#" @click.prevent="copy" data-toggle="tooltip" title="Testo nuoroda nukopijuota sėkmingai">
        <i class="fas fa-link" title="Kopijuoti testo nuorodą"></i>
    </a>
</template>
<script>
    export default {
        props: {
            testShow: String
        },
        mounted() {
            this.tooltip()
        },
        methods: {
            copy() {
                let dummy = document.createElement("input");
                document.body.appendChild(dummy);
                dummy.value = this.testShow;
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
