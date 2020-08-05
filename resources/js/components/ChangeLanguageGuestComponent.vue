<template>
    <div @click="changeLanguage" class="flag">
        <img :src="'https://www.countryflags.io/'+flag+'/flat/48.png'">
    </div>
</template>

<script>
export default {
    data() {
        return {
            language: 'lt',
            flag: 'lt'
        }
    },
    props: {
        languageRoute: String,
        currentLanguage: String
    },
    created() {
        this.language = this.currentLanguage;
        this.changeFlag();
    },
    methods: {
        changeFlag() {
            this.flag = this.currentLanguage === 'lt' ? 'gb' : this.currentLanguage === 'en' ? 'lt' : 'gb';
        },
        changeLanguage() {
            if (this.language === 'lt') {
                this.language = 'en';
            } else if (this.language === 'en') {
                this.language = 'lt';
            }
            axios.get(this.languageRoute + '/' + this.language).then(function () {
                location.reload();
            }).catch(function (error) {
                console.log(error);
            })
        }
    }
}
</script>

<style scoped>

.flag {
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
}

</style>
