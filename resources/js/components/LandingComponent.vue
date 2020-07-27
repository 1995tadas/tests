<template>
    <div>
        <transition name="appear">
            <h1 v-show="loaded">Testas</h1>
        </transition>
        <transition name="fade" mode="out-in">
            <div class="explanations" :key=text[this.currentTextIndex]>{{text[this.currentTextIndex]}}</div>
        </transition>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                text: ['Registruokitės ir junkitės', 'Susikurkite savo testą', 'Pridėkite klausimus', 'Dalinkitės su draugais',
                'Peržiūrėkite sprendimus'
                ],
                currentTextIndex: 0,
                loaded: false
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
            },
        },
        mounted() {
            this.changeText();
            this.loaded = true;
        }
    }
</script>
<style scoped lang="scss">
    @import 'node_modules/bootstrap/scss/bootstrap.scss';
    div {

        h1 {
            font-size: 10rem;
            padding: 20px;
            background-color: #f6d743;
            color: black;
            mix-blend-mode: exclusion;
            @include media-breakpoint-down(md){
                font-size: 5rem;
                width: 100vw;
            }
        }
        .explanations {
            margin-top: 40px;
            font-size: 3em;
            color: white;
            @include media-breakpoint-down(md){
                font-size: 1.3em;
            }
        }
    }
    .fade-enter-active,.fade-leave-active,.appear-enter-active {
        transition:opacity 1s ease-in-out, transform 1s ease-in-out;
    }
    .appear-enter {
        opacity: 0;
        transform: translateY(-100px)
    }
    .appear-enter-to {
        opacity: 1;
        transform: translateY(0px)
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
