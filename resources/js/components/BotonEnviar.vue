<template>
    <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
        <PlusIcon class="h-6 w-6 text-white-400" aria-hidden="true"/>
        <span class="ml-2">Crear tareas</span>
    </button>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/24/solid'

export default {
    components: {
        PlusIcon
    }
}
</script>