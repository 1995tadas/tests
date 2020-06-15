<template>
    <form method="POST" :action="questionAction">
        <input v-if ="testId" type="hidden" name="test_id" :value="testId">
        <input v-if="method==='put'" type="hidden" name="_method" value="PUT">
        <slot></slot>
        <div class="form-group form-row">
            <div class="col">
                <label for="question">Klausimas</label>
                <input class="form-control" :class="{'border-success':question, 'border-danger':!question}" type="text" id="question" name="question" v-model="question" @keyup="submitValidation">
            </div>
            <div class="col-md-3">
                <label for="answers">Atsakymų kiekis</label>
                <select @change="resetAnswers" class="form-control" id="answers" v-model="selected">
                    <option v-for="n in 8" v-if="n > 1" :value="n" v-text="n"></option>
                </select>
            </div>
        </div>
        <div class="form-group" v-for="n in selected">
            <label :for="'answer' + n" v-text="'Atsakymas NR.' + n"></label>
            <input v-model="answer[n]" :class="{'border-success':answer[n], 'border-danger':!answer[n]}" class="form-control" type="text" :name="'answer' + n" @keyup="submitValidation">
        </div>
        <div v-if=errors.length class="form-group">
            <div class="text-danger" v-for="error in errors" v-text="error"></div>
        </div>
        <div class="form-group" v-if="selected">
            <h6>Pasirinkite visus teisingus atsakymus</h6>
            <div class="custom-control custom-checkbox" v-for="n in selected">
                <input type="checkbox" class="custom-control-input" :name="'correct_answer' + n" :id="'correct_answer' + n" :checked="correctAnswer[n]">
                <label class="custom-control-label" :for="'correct_answer' + n" v-text="'NR.' + n"></label>
            </div>
        </div>
        <input :disabled="isDisabled" class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>
</template>

<script>
    export default {
        data() {
            return {
                selected: 4,
                question: null,
                answer: [],
                correctAnswer:[],
                isDisabled:true,
            }
        },
        props:{
            questionAction: {
                type:String,
                required:true
            },
            testId: {
                type:Number
            },
            errors: {
                type: Array
            },
            inputValues: {
                type: String,
                required:true
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
            submitValidation:function () {
                this.isDisabled = !(this.question && this.answer.filter(Boolean).length === this.selected);
            },
            resetAnswers:function () {
                this.answer.splice(this.selected + 1);
                this.correctAnswer.splice(this.selected + 1);
                this.submitValidation();
            },
            showInputValues:function () {
                let jsonInputs = JSON.parse(this.inputValues);
                if(Object.keys(jsonInputs).length !== 0){
                    this.question = jsonInputs.question;
                    let max = 0;
                    Object.keys(jsonInputs).forEach((key)=> {
                            if(/^answer/.test(key)){
                                let index = parseInt(key.slice(6));
                                if(max < index){
                                    max = index;
                                }
                                if(jsonInputs[key]){
                                    this.answer[index] = jsonInputs[key];
                                }
                            } else if(/^correct_answer/.test(key)){
                                let index = parseInt(key.slice(14));
                                this.correctAnswer[index] = true;
                            }
                        }
                    )
                    this.selected = max;
                }
            }
        }
    }
</script>
