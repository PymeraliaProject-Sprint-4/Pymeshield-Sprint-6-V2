<template>
    <div>
      <button @click="changeLanguage('en')">English</button>
      <button @click="changeLanguage('es')">Español</button>
      <button @click="changeLanguage('ca')">Català</button>
      <p>{{ $t('home') }}</p>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      changeLanguage(lang) {
        this.$i18n.locale = lang
      }
    }
  }
  </script>