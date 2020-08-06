<template>
    <div>
        <a :href.prevent="singleLanguage !== language ? '#': null"
           v-on="singleLanguage !== language ? {click: changeLanguage}:{}" v-for="singleLanguage in allLanguages"
           :class="{'active-language':singleLanguage === language}">
            {{ singleLanguage }}
        </a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            allLanguages: ['lt', 'en'],
            nextLanguage: ''
        }
    },
    props: {
        language: {
            type: String,
            required: true
        },
        languageRoute: {
            type: String,
            required: true
        }
    },
    methods: {
        changeLanguage() {
            if (this.allLanguages.includes(this.language)) {
                if (this.language === 'lt') {
                    this.nextLanguage = 'en';
                } else if (this.language === 'en') {
                    this.nextLanguage = 'lt';
                }
                axios.get(this.languageRoute + '/' + this.nextLanguage).then(function () {
                    location.reload();
                }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
}
</script>
