<template>
    <div class="flex py-12 px-4 sm:px-6 lg:px-8 justify-center">
        <div class="overflow-hidden shadow-lg rounded-lg lg:w-1/2">
            <!-- datos de la encuesta -->
            <div class="px-4 py-5 sm:px-6 bg-orange-400 text-white">
                <h3 class="text-base font-semibold leading-6">{{ $t('survey.name') }} {{ survey.name }}</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl v-for="question in paginatedQuestions" :key="question.id">
                    <div class="bg-orange-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                            {{ $t('survey.question') }}</dt>
                        <dd class="mt-1 text-gray-900 sm:col-span-2 sm:mt-0">{{ question.description }}</dd>
                    </div>
                    <div class="bg-orange-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            {{ $t('survey.answer') }}</dt>
                        <dd class="mt-1 text-gray-900 sm:col-span-2 sm:mt-0">
                            <div v-for="(answer, index) in question.answers" :key="answer.id"
                                class="flex items-center mb-4">
                                <input :id="'respuesta-' + index" type="radio" :name="'answer-group-' + question.id"
                                    :value="answer.id"
                                    class="w-4 h-4 border-gray-300 focus:ring-2 text-orange-600 focus:ring-orange-300 dark:focus:ring-orange-600 dark:focus:bg-orange-600 dark:bg-gray-700 dark:border-gray-600"
                                    @change="selectAnswer(answer.id)"
                                    :checked="answers.find(a => a.currentPage === currentPage && a.answerId === answer.id) !== undefined">
                                <label :for="'respuesta-' + index"
                                    class="block ml-2 font-medium text-gray-900 dark:text-gray-300">
                                    {{ answer.name }}
                                </label>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-orange-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500">{{ $t('survey.percent') }}</dt>
                        <dd class="mt-1 text-gray-900 sm:col-span-2 sm:mt-0">{{ percentageAnswered }} %
                        </dd>
                    </div>

                    <div class="bg-orange-50 px-4 py-5 sm:gap-4 sm:px-6">
                        <div class="w-full h-6 bg-gray-200 rounded-full dark:bg-gray-700">
                            <div class="h-6 bg-blue-600 rounded-full dark:bg-blue-500"
                                :style="'width: ' + percentageAnswered + '%'"></div>
                        </div>
                    </div>
                </dl>

                <!-- paginación -->
                <div class="p-3 text-gray-700 uppercase bg-orange-100 dark:text-gray-400">
                    <div class="row">
                        <div class="col-12">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                                <button
                                    class="relative inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                                    :disabled="currentPage === 1" @click="currentPage--">&laquo; {{
                                        $t('pagination.previous') }}</button>
                                <button
                                    class="relative inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    :class="{ 'opacity-50 cursor-not-allowed': currentPage === pageCount }"
                                    :disabled="currentPage === pageCount" @click="currentPage++">{{ $t('pagination.next') }}
                                    &raquo;</button>
                                <button v-if="surveySend && questions.length > 0" @click="submitAnswers"
                                    class="relative inline-flex items-center rounded-md bg-orange-600 py-2 px-3 font-semibold text-white hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                                    :class="{ 'opacity-50 cursor-not-allowed': hasError === 0 }" :disabled="hasError === 0">
                                    <PaperAirplaneIcon class="h-5 w-5 mr-1" aria-hidden="true" /> {{ $t('survey.send') }}
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- mostrar mensaje error/success -->
                <div class="p-4 text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert"
                    v-if="hasError === 0">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ $t('survey.completed') }}</span> {{ $t('survey.success', { seconds: '5' })
                    }}
                </div>
                <div class="p-4 text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"
                    v-if="hasError === 1">
                    <span class="font-medium">{{ $t('survey.error') }}</span> {{ $t('survey.failed') }}
                </div>
            </div>
            <!-- mapa navegación -->
            <div class="px-4 py-5 text-base bg-orange-400 font-semibold leading-6 text-gray-900">{{ $t('survey.map') }}
            </div>
            <div class="flex flex-wrap gap-4 py-4 px-4 bg-orange-50">
                <a v-for="guide in questions.length" :key="guide"
                    class="cursor-pointer w-12 h-12 overflow-hidden shadow rounded-lg flex justify-center items-center hover:bg-orange-300"
                    :class="{ 'cursor-not-allowed font-extrabold border-gray-500 border-dashed border-2': currentPage === guide, 'bg-green-300': isReplied(guide) }"
                    @click="goToPage(guide)">{{ guide }}
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { PaperAirplaneIcon } from '@heroicons/vue/24/outline'
import axios from 'axios'
// propiedades para pasarle datos desde controlador laravel
const props = defineProps({
    survey: Object,
    questions: Object,
})

// variables para paginación
const currentPage = ref(1)
const perPage = ref(1)
const pageCount = computed(() => Math.ceil(props.questions.length / perPage.value))
const hasError = ref(null); // por si hay errores

// guardo las respuestas con localStorage para sobrevivir a efecincos
const answers = ref(JSON.parse(localStorage.getItem('answers' + props.survey.id)) || []);

// guardar las respuestas seleccionadas en el array o actualizar
function selectAnswer(answerId) {
    const index = answers.value.findIndex(answer => answer.currentPage === currentPage.value)

    if (index !== -1) {
        answers.value[index].answerId = answerId
    } else {
        answers.value.push({ currentPage: currentPage.value, answerId })
    }

    localStorage.setItem('answers' + props.survey.id, JSON.stringify(answers.value))
}

// cambiar de página desde botón
function goToPage(page) {
    currentPage.value = page
}

// calcular paginación
const paginatedQuestions = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    const end = start + perPage.value
    return props.questions.slice(start, end)
})

watch(currentPage, () => {
    const start = (currentPage.value - 1) * perPage.value
    const end = start + perPage.value
    paginatedQuestions.value = props.questions.slice(start, end)
})

// calcular el porcentage de respuestas contestadas
const percentageAnswered = computed(() => {
    return Math.round((answers.value.length / props.questions.length) * 100);
});

// boolean si el formulario está completo
const surveySend = computed(() => {
    return answers.value.length === props.questions.length;
});

// boolean si la pregunta está contestada
function isReplied(guide) {
    const answer = answers.value.find(a => a.currentPage === guide)
    return answer
}

// enviar las respuestas
async function submitAnswers() {
    try {
        const answerIds = answers.value.map(answer => answer.answerId);
        const response = await axios.post(`/audit/save/${props.survey.id}`, {
            answerIds: answerIds
        });

        const data = response.data;

        // limpio las respuestas si el envio es bueno y redirect
        localStorage.removeItem(`answers${props.survey.id}`)
        hasError.value = 0 // esto es success
        setTimeout(() => {
            window.location.href = data.redirect;
        }, 5000);
    } catch (error) {
        // para mostrar aviso al usuario si falla
        hasError.value = 1;
    }
}
</script>
