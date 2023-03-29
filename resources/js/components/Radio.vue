<template>
  <div class="px-4">
    <div class="mx-auto w-36">
      
      <RadioGroup v-model="this.selected">
        <RadioGroupLabel class="sr-only">Selecciona</RadioGroupLabel>
        <div class="flex flex-row gap-3">
          <!-- FIRST -->
          <RadioGroupOption
            as="template"
            v-slot="{ active, checked }"
            v-for="option in options"
            :key="option.value"
            @click="$emit('selectedValue', this.selected)"
            :value="option.value">
            <div
              :class="[
                active
                ? 'ring-2 ring-white ring-opacity-60 ring-offset-2 ring-offset-orange-400'
                : '',
                checked ? ' bg-orange-200 text-black' : 'bg-white ',
              ]"
              class="relative w-full flex justify-center align-items-center cursor-pointer rounded-lg px-1 py-1 shadow-md focus:outline-none"
              >
              <div class="flex gap-3 items-center justify-between">
                <div class="flex items-center">
                  <div class="text-sm">
                    <RadioGroupLabel
                      :class="checked ? '' : 'text-gray-900'"
                      class="font-medium cursor-pointer"
                    >
                    
                    <div v-if="option.value === 'Me lo gestiono yo'" role="button" aria-pressed="false" :aria-label="option.value">
                      <UserIcon class="h-6 w-6 text-black"/></div>
                    <div v-else-if="option.value === 'No aceptada'" role="button" aria-pressed="false" :aria-label="option.value">
                      <XMarkIcon class="h-6 w-6 text-black" /></div>
                    <div v-else v-html="option.html" role="button" aria-pressed="false" :aria-label="option.value"></div>
                    </RadioGroupLabel>
                  </div>
                </div>
              </div>
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
} from '@headlessui/vue'

//import { User } from "@heroicons/vue/24/outline"
import { UserIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const options = [
  { 
    value: 'Me aconseja Pymeralia',
    html: '<img src="../storage/logo/image-removebg-preview(1).png" height="50" width="50" alt="">'
   },
  { 
    value: 'Me lo gestiono yo',
    html: '<UserIcon class="h-6 w-6 text-black"/>'
 },
  { 
    value: 'No aceptada',
    html: '<i class="fa fa-close text-4xl"></i>'
 },
]
</script>

<script>
export default {
  name: 'Radio',
  data() {
    return {
      default: this.default,
      selected: ref('')
    }
  },
  component: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    UserIcon,
    XMarkIcon
  },
  props: {
    default: {
      type: String,
      default: ''
    }
  },
  created() {
    this.selected = ref(this.default)
  },
}
</script>
