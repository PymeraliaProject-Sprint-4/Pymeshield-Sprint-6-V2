<template>
     <div class="max-w-xl sm:mx-auto m-5 ring-1 ring-gray-200 bg-white rounded-lg">
        <form action="" id="questionnaire-form" method="POST" v-on:submit.prevent="saveTask()">
            <div hidden>
                @csrf
            </div>

            <div class="grid gap-6 my-6">
                <div class="flex justify-center mt-5">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="question">{{ $t('question') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text"
                                name="question"
                                id="question"
                                v-model="pregunta"
                                required autofocus>
                        </div>

                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="description">{{ $t('question.description') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text"
                                name="description"
                                id="description"
                                v-model="description"
                                required autofocus>
                        </div>
                    </div>
                </div>

            <details class="pl-4">
                <summary>{{ $t('answer.true') }}</summary>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="recommendation_true">{{ $t('answer.reco') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text"
                                name="recommendation_true"
                                id="recommendation_true"
                                v-model="recommendation_true"
                                required autofocus>
                        </div>
                    </div>
                </div>


                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="risk_true">{{ $t('answer.risk') }}</label>
                        </div>
                        <select id="risk_true"
                                name="risk_true"
                                v-model="risk_true"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="risk in risks" :value="risk.id"
                                    :key="risk.id">{{ risk.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="intervention_true">{{ $t('answer.inter') }}</label>
                        </div>
                        <select id="intervention_true"
                                name="intervention_true"
                                v-model="intervention_true"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="intervention in interventions" :value="intervention.id"
                                    :key="intervention.id">{{ intervention.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="measure_true">{{ $t('answer.type') }}</label>
                        </div>
                        <select id="measure_true"
                                name="measure_true"
                                v-model="measure_true"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="type_measure in type_measures" :value="type_measure.id"
                                    :key="type_measure.id">{{ type_measure.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="probability_true">{{ $t('answer.prob') }}</label>
                        </div>
                        <select id="probability_true"
                                name="probability_true"
                                v-model="probability_true"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="probability in probabilities" :value="probability.id"
                                    :key="probability.id">{{ probability.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="impact_true">{{ $t('answer.imp') }}</label>
                        </div>
                        <select id="impact_true"
                                name="impact_true"
                                v-model="impact_true"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="impact in impacts" :value="impact.id"
                                    :key="impact.id">{{ impact.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </details>
            <details class="pl-4">
                <summary>{{ $t('answer.false') }}</summary>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="recommendation_false">{{ $t('answer.reco') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text"
                                name="recommendation_false"
                                id="recommendation_false"
                                v-model="recommendation_false"
                                required autofocus>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="risk_false">{{ $t('answer.risk') }}</label>
                        </div>
                        <select id="risk_false"
                                name="risk_false"
                                v-model="risk_false"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="risk in risks" :value="risk.id"
                                    :key="risk.id">{{ risk.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="intervention_false">{{ $t('answer.inter') }}</label>
                        </div>
                        <select id="intervention_false"
                                name="intervention_false"
                                v-model="intervention_false"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="intervention in interventions" :value="intervention.id"
                                    :key="intervention.id">{{ intervention.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="measure_false">{{ $t('answer.reco') }}</label>
                        </div>
                        <select id="measure_false"
                                name="measure_false"
                                v-model="measure_false"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="type_measure in type_measures" :value="type_measure.id"
                                    :key="type_measure.id">{{ type_measure.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="probability_false">{{ $t('answer.prob') }}</label>
                        </div>
                        <select id="probability_false"
                                name="probability_false"
                                v-model="probability_false"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="probability in probabilities" :value="probability.id"
                                    :key="probability.id">{{ probability.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="impact_false">{{ $t('answer.imp') }}</label>
                        </div>
                        <select id="impact_false"
                                name="impact_false"
                                v-model="impact_false"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="impact in impacts" :value="impact.id"
                                    :key="impact.id">{{ impact.name }}
                            </option>
                        </select>
                    </div>
                </div>
                </details>





                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 rounded-b-lg">
                    <div class="flex justify-center">
                        <button
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded items-center"
                            type="submit" value="Save" v-bind:disabled="sending" >{{ $t('form.send') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</template>
<script>
    import axios from 'axios';
    // en export default en la funcion data tenemos que crear un objeto con las variables que recogeremos del componente
    export default {
        props: {
            risks: {
                type: Array,
                default: () => []
            },
            interventions: {
                type: Array,
                default: () => []
            },
            type_measures: {
                type: Array,
                default: () => []
            },
            probabilities: {
                type: Array,
                default: () => []
            },
            impacts: {
                type: Array,
                default: () => []
            }

        },
        data() {
            return {
                pregunta: '',
                description: '',

                recommendation_true: '',
                risk_true: '',
                intervention_true: '',
                measure_true: '',
                probability_true: '',
                impact_true: '',

                recommendation_false: '',
                risk_false: '',
                intervention_false: '',
                measure_false: '',
                probability_false: '',
                impact_false: '',
                sending: false
            }
        },
        mounted() {
            console.log('Component form mounted.')
        },
        methods: {
            saveTask() {
                this.sending = true;
                //plugin axios
                this.$axios.post('question', {name: this.pregunta, description: this.description, recommendation_true: this.recommendation_true, risk_true: this.risk_true, intervention_true: this.intervention_true, measure_true: this.measure_true, probability_true: this.probability_true, impact_true: this.impact_true, recommendation_false: this.recommendation_false, risk_false: this.risk_false, intervention_false: this.intervention_false, measure_false: this.measure_false, probability_false: this.probability_false, impact_false: this.impact_false })
                .then(response => {
                    window.location.href = '/question';
                })
                .catch(error => {
                    console.log(error.response)
                })

            }
            // Verificamos los datos: del form
            // verificate: function(){
            //     const params = {
            //         question: this.question,
            //         true: this.true,
            //         false: this.false
            //     };
            //         q_lenght=this.question.lenght
            //         t_lenght=this.true.lenght
            //         f_lenght=this.false.lenght
            //     // Si se llenan todos los campos
            //     if(this.question&&this.true&&this.false){
            //         check=0;
            //         // Comprovamos que no se inyecta codigo
            //         if(q_lenght=>150){
            //             this.errors.push('Has de fer una pregunta mes breu.');
            //         }else{
            //             check=1;
            //         }
            //         if(t_lenght=>100){
            //             this.errors.push('Recomanació masa llarga.');
            //         }else{
            //             check++;
            //         }
            //         if(f_lenght=>100){
            //             this.errors.push('Recomanació masa llarga.');
            //         }else{
            //             check++;
            //         }
            //         // En caso de que no supere el limite de caracteres ninguno de los datos
            //         if (check===3){
            //             axios.post('/question', params)
            //             .then((response) => {
            //             const question = response.data;
            //             console.log(question);
            //             this.$emit('create', question);

            //             });
            //         }
            //     }
            //     this.errors = [];

            //     if (!this.question) {
            //         this.errors.push('Es impresindible una pregunta');
            //     }
            //     if (!this.true) {
            //         this.errors.push('En cas de si... Que recomanes?');
            //     }
            //     if (!this.false) {
            //         this.errors.push('En cas de no... Que recomanes?');
            //     }

            // }
        }
    }
</script>
