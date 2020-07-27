<template>
    <transition name="fade" mode="out-in">
        <div :key=text[this.currentTextIndex]>{{text[this.currentTextIndex]}}</div>
    </transition>
</template>
<script>
    export default {
        data() {
            return {
                text: ['Registruokitės', 'Susikurkite savo testą', 'Pridėkite klausimus', 'Dalinkitės su draugais',
                'Peržiūrėkite sprendimus'
                ],
                currentTextIndex: 0,
            }
        },
        methods: {
            changeText() {
                setInterval(() => {
                        if (this.currentTextIndex === this.text.length - 1) {
                            this.currentTextIndex = 0;
                        } else {
                            this.currentTextIndex++;
                        }
                    },3000)
            }
        },
        mounted() {
            this.changeText();
        }
    }
</script>
<style scoped type="scss">
    div {
        font-size: 3em;
        color: white;
    }
    .fade-enter-active,.fade-leave-active {
        transition:opacity 1s ease-in-out, transform 1s ease-in-out;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
    .fade-enter {
        transform: translateX(-100px)
    }
    .fade-enter-to, .fade-leave {
        opacity: 1;
        transform: translateX(0px)
    }
    .fade-leave-to {
        transform: translateX(100px)
    }
</style>
