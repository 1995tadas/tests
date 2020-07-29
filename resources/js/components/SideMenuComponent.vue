<template>
    <div>
        <div class="custom-menu" :class="{'custom-menu-hide':!hidden}">
            <button type="button" class="btn btn-primary" @click="hidden = !hidden">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <nav :class="{'hide': hidden}" id="sidebar">
            <div class="logo">
                <a :href="home">Pagrindinis</a>
                <a class="close-icon" href="#" @click.prevent="hidden = !hidden">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <ul class="list-unstyled mb-5">
                <template v-if="!user">
                    <li :class="{active:url === 'login'}">
                        <a :href="logIn"><span class="fa fa-sign-in mr-3"></span>Prisijungti</a>
                    </li>
                    <li :class="{active:url === 'register'}">
                        <a :href="register"><span class="fa fa-user-plus mr-3"></span>Registracija</a>
                    </li>
                </template>
                <template v-else>
                    <li :class="{active:url === 'test/create'}">
                        <a :href="this.testCreate"><span class="fa fa-plus mr-3"></span>Naujas testas</a>
                    </li>
                    <li :class="{active:url === 'test'}">
                        <a :href="this.testIndex"><span class="fa fa-book mr-3"></span>Testai</a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout"><span class="fa fa-sign-out mr-3"></span>Atsijungti</a>
                    </li>
                </template>
                <li>
                    <a href="http://tadas-portfolio.herokuapp.com" target="_blank" title="Portfolio"><span
                        class="fa fa-info-circle mr-3"></span>Apie autorių</a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default {
        props: {
            testIndex: String,
            testCreate: String,
            home: String,
            url: String,
            user: {
                type: Boolean,
                default: false
            },
            register: String,
            logIn: String,
            logOut: String
        },
        created() {
            if (this.url === '/') {
                this.hidden = true;
            }
            this.mobile();
        },
        data() {
            return {
                hidden: false
            }
        },
        methods: {
            logout() {
                if (confirm("Ar tikrai norite atsijungti?")) {
                    axios.post(this.logOut)
                        .then(window.location.href = this.logIn)
                }
            },
            mobile() {
                if ($(window).width() <= 992) {
                    this.hidden = true;
                }
            }

        }
    }
</script>
<style lang="scss" scoped>
    @import 'resources/sass/_variables.scss';
    @import 'node_modules/bootstrap/scss/bootstrap.scss';

    $font-primary: 'Poppins', Arial, sans-serif;
    $primary: #649d66;

    #sidebar {
        max-height: 100vh;
        min-height: 100vh;
        min-width: 200px;
        max-width: 200px;
        background: #1b1b2f;
        color: #fff;
        transition: all 0.3s;
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
            li {
                font-size: 16px;

                > ul {
                    margin-left: 10px;

                    li {
                        font-size: 14px;
                    }
                }

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

        @include media-breakpoint-down(md) {
            // margin-left: -200px;
        }
    }

    .custom-menu {
        display: inline-block;
        position: absolute;
        top: 15px;
        left: 20px;
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
                    background: transparent !important;
                    border-color: transparent !important;
                    outline: none !important;
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
