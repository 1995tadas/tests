<template>
    <div>
        <div class="custom-menu" :class="{'custom-menu-hide':!hidden}">
            <button type="button" class="btn btn-primary" @click="hidden = !hidden">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <nav :class="{'hide': hidden}" id="sidebar">
            <div class="logo">
                <a :href="home">{{ lang.landing }}</a>
                <a class="close-icon" href="#" @click.prevent="hidden = !hidden">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <ul class="list-unstyled">
                <template v-if="!userEmail">
                    <li :class="{active:url === 'login'}">
                        <a :href="logInRoute">
                            <span class="fa fa-sign-in mr-3"></span>
                            {{ lang.logIn }}
                        </a>
                    </li>
                    <li :class="{active:url === 'register'}">
                        <a :href="registerRoute">
                            <span class="fas fa-user-plus mr-3"></span>
                            {{ lang.signUp }}
                        </a>
                    </li>
                </template>
                <template v-else>
                    <li :class="{active:url === 'user'}">
                        <a :href="this.userRoute">
                            <span class="fas fa-user mr-3"></span>
                            {{ modifiedUserEmail }}
                        </a>
                    </li>
                    <li :class="{active:url === 'test/create'}">
                        <a :href="this.testCreateRoute">
                            <span class="fas fa-plus mr-3"></span>
                            {{ lang.newTest }}
                        </a>
                    </li>
                    <li :class="{active:url === 'test'}">
                        <a :href="this.testIndexRoute">
                            <span class="fas fa-book mr-3"></span>
                            {{ lang.tests }}
                        </a>
                    </li>
                    <li :class="{active:url === 'solution'}">
                        <a :href="this.solutionUserRoute">
                            <span class="fas fa-clipboard-check mr-3"></span>
                            {{ lang.solutions }}
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout">
                            <span class="fa fa-sign-out mr-3"></span>
                            {{ lang.logOut }}
                        </a>
                    </li>
                </template>
                <li>
                    <a href="http://tadas-portfolio.herokuapp.com" target="_blank" title="Portfolio">
                        <span class="fas fa-info-circle mr-3"></span>{{ lang.author }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
export default {
    props: {
        langJson: {
            type: String,
            required: true
        },
        home: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        testIndexRoute: String,
        testCreateRoute: String,
        userEmail: String,
        userRoute: String,
        solutionUserRoute: String,
        registerRoute: String,
        logInRoute: String,
        logOutRoute: String
    },
    data() {
        return {
            hidden: false,
            modifiedUserEmail: this.userEmail,
            lang: JSON.parse(this.langJson)
        }
    },
    created() {
        if (this.userEmail) {
            this.shortenString();
        }
        this.homeHide();
        this.mobileHide();
    },
    methods: {
        logout() {
            axios.post(this.logOutRoute)
                .then(response => {
                    if (response.status === 302 || 401) {
                        window.location.href = this.logInRoute
                    }
                })
        },
        mobileHide() {
            if ($(window).width() <= 992) {
                this.hidden = true;
            }
        },
        homeHide() {
            if (this.url === '/') {
                this.hidden = true;
            }
        },
        shortenString() {
            window.addEventListener("resize", this.shortenString);
            if (window.innerWidth >= 768) {
                this.modifiedUserEmail = this.userEmail.substring(0, 10) + '...';
            } else {
                this.modifiedUserEmail = this.userEmail;
            }
        }
    }
}
</script>
<style lang="scss" scoped>
@import 'resources/sass/_variables.scss';
@import 'node_modules/bootstrap/scss/bootstrap.scss';

$primary: #649d66;

#sidebar {
    max-height: 100%;
    min-height: 100%;
    min-width: 200px;
    max-width: 200px;
    box-sizing: border-box;
    background: #1b1b2f;
    color: #fff;
    transition: all 0.3s;
    white-space: nowrap;
    overflow: hidden;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    z-index: 999;
    @include media-breakpoint-down(sm) {
        min-width: 100vw;
        max-width: 100vw;
    }

    .logo {
        margin: 0;
        font-weight: 700;
        font-size: 20px;
        background: $primary;
        padding: 10px 10px 10px 30px;
        display: block;
        border-bottom: 1px solid black;
        @include media-breakpoint-down(sm) {
            text-align: center;
            font-size: 40px;
        }

        a {
            color: $white;
        }

        .close-icon {
            margin-left: 20px;
            font-size: 1.8rem;
            @include media-breakpoint-down(sm) {
                font-size: 45px;
            }

            &:hover {
                color: $red;
            }
        }
    }

    ul {
        margin: 0;

        li {
            font-size: 16px;

            a {
                padding: 15px 30px;
                display: block;
                color: rgba(255, 255, 255, .6);
                border-bottom: 1px solid rgba(255, 255, 255, .1);
                @include media-breakpoint-down(sm) {
                    text-align: center;
                    font-size: 30px;
                }

                &:hover {
                    color: $white;
                    background: $primary;
                    border-bottom: 1px solid $primary;
                }
            }

            &.active {
                > a {
                    background: transparent;
                    color: #f6d743;

                    &:hover {
                        background: $primary;
                        border-bottom: 1px solid $primary;
                    }
                }
            }
        }
    }
}

.custom-menu {
    display: inline-block;
    position: absolute;
    top: 15px;
    left: 20px;
    z-index: 998;
    @include transition(.3s);
    @include media-breakpoint-down(sm) {
        top: 5px;
        left: 10px;
    }

    .btn {
        &.btn-primary {
            background: transparent;
            border-color: transparent;

            i {
                color: black;
                font-size: 50px;
                @include media-breakpoint-down(md) {
                    font-size: 30px;
                }
            }

            &:hover, &:focus {
                background: transparent;
                border-color: transparent;
                outline: none;
                box-shadow: none !important;
            }
        }
    }
}

.hide {
    margin-left: -200px;
    @include media-breakpoint-down(sm) {
        margin-left: -100vw;
    }
}
</style>
