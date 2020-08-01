<template>
    <div>
        <transition name="appear">
            <h1 v-show="loaded">{{ lang.test }}</h1>
        </transition>
        <transition name="fade" mode="out-in">
            <div class="explanations" :key=lang.explanations[this.explanationsIndex]>
                {{lang.explanations[this.explanationsIndex]}}
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    props: {
        langJson: String
    },
    data() {
        return {
            lang: JSON.parse(this.langJson),
            explanationsIndex: 0,
            loaded: false,
        }
    },
    methods: {
        changeText() {
            setInterval(() => {
                if (this.explanationsIndex === this.lang.explanations.length - 1) {
                    this.explanationsIndex = 0;
                } else {
                    this.explanationsIndex++;
                }
            }, 3000)
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

h1 {
    font-size: 10rem;
    padding: 20px;
    background-color: #f6d743;
    color: black;
    mix-blend-mode: exclusion;
    width: 60vw;
    @include media-breakpoint-down(md) {
        font-size: 5rem;
        width: 100vw;
    }
}

.explanations {
    margin-top: 40px;
    font-size: 3em;
    color: white;
    @include media-breakpoint-down(md) {
        font-size: 1.3em;
    }
}

.fade-enter-active, .fade-leave-active, .appear-enter-active {
    transition: opacity 1s ease-in-out, transform 1s ease-in-out;
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
