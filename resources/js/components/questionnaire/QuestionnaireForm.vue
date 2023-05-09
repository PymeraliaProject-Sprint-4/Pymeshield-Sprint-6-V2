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
                            <label class="block font-medium text-label text-gray-700" for="questionnaire_name">{{
                                $t('questionnaire.name') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text" name="questionnaire_name" id="questionnaire_name" v-model="questionnaire_name"
                                autofocus>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 rounded-b-lg">
                        <button
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded items-center disabled:opacity-50 disabled:cursor-not-allowed"
                            type="submit" value="Save" v-bind:disabled="sending">
                            {{ $t('form.send') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        questionnaires: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            errors: '',
            questionnaire_name: '',
            questionnaire_date: '',
            sending: false,
        }
    },
    methods: {
        saveTask() {
            this.sending = true;

            axios.post('/questionnaire', {
                questionnaire_name: this.questionnaire_name,
                questionnaire_date: this.questionnaire_date,

            })
                .then(response => {
                    window.location.href = '/questionnaire/' + response.data.id + '/edit';
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.sending = false;
                })

        }
    },
}

</script>

