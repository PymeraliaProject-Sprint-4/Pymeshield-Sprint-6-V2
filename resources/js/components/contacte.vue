<template>
  <div class="contact">
    <div class="flex flex-wrap">
      <div class="w-full md:w-1/2 p-6">
        <h3 class="text-2xl font-bold mb-4 text-center">{{ $t('contact-us') }}</h3>
        <form @submit.prevent="submitForm">
          <div class="mb-4">
            <label for="name" class="block mb-2">{{ $t('name') }}</label>
            <input type="text" id="name" v-model="name" required
              class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
          </div>
          <div class="mb-4">
            <label for="phone" class="block mb-2">{{ $t('phone') }}</label>
            <input type="tel" id="phone" v-model="phone" required
              class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
          </div>
          <div class="mb-4">
            <label for="email" class="block mb-2">{{ $t('email') }}</label>
            <input type="email" id="email" v-model="email" required
              class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
          </div>
          <div class="mb-4">
            <label for="subject" class="block mb-2">{{ $t('subject') }}</label>
            <input type="text" id="subject" v-model="subject" required
              class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
          </div>
          <div class="mb-4">
            <label for="message" class="block mb-2">{{ $t('message') }}</label>
            <textarea id="message" v-model="message" required rows="4"
              class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
          </div>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"><i
              class="fas fa-paper-plane mr-2"></i>
            {{ $t('send')
            }} </button>
        </form>
      </div>
      <div class="w-full md:w-1/2 p-6">
        <h3 class="text-2xl font-bold mb-4 text-center">{{ $t('visit-us') }}</h3>
        <div class="mb-4">
          <p class="font-bold">{{ $t('address') }}</p>
          <p class="text-gray-700"> Av. dels Esports, 18, 43540 La Ràpita, Tarragona</p>
        </div>
        <div class="mb-4">
          <p class="font-bold">{{ $t('phone') }}</p>
          <p class="text-gray-700">+34 977 74 40 87</p>
        </div>
        <div class="mb-4">
          <p class="font-bold">{{ $t('email') }}</p>
          <p class="text-gray-700">info@example.com</p>
        </div>
        <div class="mb-4">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3028.323341563484!2d0.5883906150770898!3d40.622750679341614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a0554f5ec517f7%3A0x2bf0c75a59e9c399!2sPymeralia!5e0!3m2!1sen!2sus!4v1678778327118!5m2!1sen!2sus"
            width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>

  </div>
</template>
<script>

export default {
  data() {
    return {
      name: '',
      phone: '',
      email: '',
      subject: '',
      message: ''
    }
  },
  methods: {
    submitForm() {
      // Code to submit form data goes here
      console.log('Form submitted');
      window.location.reload();
    }
  }
}
</script>
<style scoped>.contact {
  max-width: 1000px;
  margin: 0 auto;
}</style>