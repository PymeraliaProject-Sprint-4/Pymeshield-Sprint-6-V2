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
                            <label class="block font-medium text-label text-gray-700" for="questionnaire_name">{{ $t('questionnaire.name') }}</label>
                        </div>
                        <div>
                            <input
                                class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6"
                                type="text"
                                name="questionnaire_name"
                                id="questionnaire_name"
                                v-model="questionnaire_name"
                                required autofocus>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-10/12">
                        <div>
                            <label class="block font-medium text-label text-gray-700" for="questionnaire_autor">{{ $t('questionnaire.autor') }}</label>
                        </div>
                        <select id="questionnaire_autor"
                                name="questionnaire_autor"
                                v-model="questionnaire_autor"
                                class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                            <option value="" selected>{{ $t('messages.option') }}</option>
                            <option v-for="questionnaire in questionnaires" :value="questionnaire.autor"
                                    :key="questionnaire.id">{{ questionnaire.autor }}
                            </option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 rounded-b-lg">
                        <button
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded items-center"
                            type="submit" value="Save"  v-bind:disabled="sending"
                            >
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
            questionnaire_name: '',
            questionnaire_autor: '',
            questionnaire_date: '',
            sending: false,
        }
    },
    mounted() {
        console.log('Component form mounted.')
    },
    methods: {
        saveTask() {
            this.sending = true;

            axios.post('/questionnaire', {
                questionnaire_name: this.questionnaire_name,
                questionnaire_autor: this.questionnaire_autor,
                questionnaire_date: this.questionnaire_date,

            })
                .then(response => {
                    window.location.href = '/questionnaire/' + response.data.id + '/edit';
                })
                .catch(error => {
                    console.log(error.response)
                })

        }
    },
}

</script>

