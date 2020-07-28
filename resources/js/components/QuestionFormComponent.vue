<template>
    <div class="form-container">
        <div class="form-wrapper">
            <form class="form" method="POST" :action="questionAction">
                <span class="form-title" v-text="formTitle"></span>
                <input v-if="testId" type="hidden" name="test_id" :value="testId">
                <input v-if="method === 'put'" type="hidden" name="_method" value="PUT">
                <slot></slot>
                <div class="form-group form-row">
                    <div class="col">
                        <label for="question">Klausimas</label>
                        <input class="form-control" :class="{'border-success':question, 'border-danger':!question}"
                               type="text" id="question" name="question" v-model="question" @keyup="submitValidation" required autofocus>
                    </div>
                    <div class="col-md-3">
                        <label for="answers">Ats. kiekis</label>
                        <select @change="resetAnswers" class="form-control" id="answers" v-model="selected">
                            <option v-for="n in 8" v-if="n > 1" :value="n" v-text="n"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" v-for="n in selected">
                    <label :for="'answer' + n" v-text="'Atsakymas NR.' + n"></label>
                    <textarea v-model="answers[n]" :class="{'border-success':answers[n], 'border-danger':!answers[n]}"
                              class="form-control" type="text" :name="'answers['+n+']'" @keyup="submitValidation" required maxlength="255"></textarea>
                </div>
                <div v-if=errors.length class="form-group">
                    <div class="text-danger" v-for="error in errors" v-text="error"></div>
                </div>
                <div class="form-group" v-if="selected">
                    <h6>Pasirinkite visus teisingus atsakymus</h6>
                    <div class="d-inline custom-control custom-checkbox" v-for="n in selected">
                        <input type="checkbox" class="custom-control-input" :name="'correct_answers['+n+']'"
                               :id="'correct_answer' + n" :checked="correctAnswers[n]">
                        <label class="custom-control-label" :for="'correct_answer' + n" v-text="'NR.' + n"></label>
                    </div>
                </div>
                <input :disabled="isDisabled" class="btn btn-success" type="submit" value="Išsaugoti">
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: 4,
                question: null,
                answers: [],
                correctAnswers: [],
                isDisabled: true,
            }
        },
        props: {
            questionAction: {
                type: String,
                required: true
            },
            formTitle: {
                type: String,
                required: true
            },
            testId: {
                type: Number
            },
            errors: {
                type: Array
            },
            inputValues: {
                type: String,
                required: true
            },
            method: {
                type: String,
                default: 'post'
            }
        },
        created() {
            this.showInputValues();
            this.submitValidation();
        },
        methods: {
            submitValidation: function () {
                this.isDisabled = !(this.question && this.answers.filter(Boolean).length === this.selected);
            },
            resetAnswers: function () {
                this.answers.splice(this.selected + 1);
                this.correctAnswers.splice(this.selected + 1);
                this.submitValidation();
            },
            showInputValues: function () {
                let jsonInputs = JSON.parse(this.inputValues);
                let length = Object.keys(jsonInputs).length
                if (length) {
                    Object.entries(jsonInputs.answers).forEach((element) => {
                        this.answers[element[0]] = element[1];
                    });
                    this.question = jsonInputs.question;
                    if (jsonInputs.correct_answers) {
                        this.correctAnswers = jsonInputs.correct_answers;
                    }
                    this.selected = Object.keys(jsonInputs.answers).length;
                }
            }
        }
    }
</script>
