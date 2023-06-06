<template>
    <div class="flex flex-col items-center h-screen bg-gray-100">
        <div class="flex items-center mt-8">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-500 text-white text-2xl">
                {{ userInitial }}
            </div>
            <h1 class="text-2xl ml-4">Hola, {{ user.nick_name }} <i @click="openModalWalletTron()"
                    class="fas fa-eye eye-icon cursor-pointer transition-colors duration-300 hover:text-red-500 animate-wiggle"></i>
            </h1>
        </div>
        <div class="flex justify-center mt-8 space-x-4">
            <button @click="openModalRetirarDinero()"
                class="flex items-center justify-center bg-blue-500 text-white rounded-lg p-4">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5v2.4l-10 5-10-5V17zm10-10l10-5v2.4L12 14 2 4.4V2l10 5z" />
                </svg>
                Retirar dinero
            </button>
            <button @click="openModalTransfers()"
                class="flex items-center justify-center bg-blue-500 text-white rounded-lg p-4">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3a9 9 0 1 0 9 9c0-1.9-.6-3.6-1.6-5L8 15.6V17h2.6L17 8.6c-1.4-1-3.1-1.6-5-1.6zm9 9a9 9 0 0 1-9 9c-1.9 0-3.6-.6-5-1.6L15.6 16H17v2.6l-7.4 7.4c1.4-.9 2.9-1.6 4.8-1.6a9 9 0 0 1 9-9z" />
                </svg>
                Transferencia
            </button>
        </div>
        <div class="relative mt-8">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 opacity-75 rounded-lg" id="saldoDIV">
            </div>
            <p class="ml-5 mb-2 text-white text-2xl font-bold relative z-5 py-8">Saldo de la cuenta: {{
                accountBalance }}
            </p>
        </div>
        <div class="flex justify-center mt-8">
            <button @click="openModalDireccionBilletera()"
                class="flex items-center justify-center bg-blue-500 text-white rounded-lg p-4 mr-4">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 4a4 4 0 0 0-4 4v7H7v2h2v2H9v2h2v-2h2v-2h-2v-2h2V8a4 4 0 0 0-4-4zm0 2a2 2 0 0 1 2 2v2H10V8a2 2 0 0 1 2-2zm0 4a2 2 0 0 1-2 2H8v2h2a2 2 0 0 1-2 2V8a2 2 0 0 1 2 2zm6.7 2.3l2-2a.996.996 0 0 0 0-1.41l-2-2a.996.996 0 1 0-1.41 1.41L16.59 9H14a1 1 0 0 0 0 2h2.59l-1.3 1.3a.996.996 0 1 0 1.41 1.41zM5.3 11.3L3.3 9A.996.996 0 1 0 1.89 10.4L3.59 12H6a1 1 0 0 0 0-2H3.41l1.3-1.3a.996.996 0 1 0-1.41-1.41l-2 2a.996.996 0 0 0 0 1.41l2 2c.39.39 1.03.39 1.42 0z" />
                </svg>
                Dirección de la cartera
            </button>
            <button @click="openModalPaymentPassword()"
                class="flex items-center justify-center bg-blue-500 text-white rounded-lg p-4 mr-4">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 1C5.93 1 1 5.93 1 12v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5c0-6.07-4.93-11-11-11zm-1 18a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm1-5H4v-1h8v1zm6-5H4V9h14v1zm0-3H4V6h14v1z" />
                </svg>
                Contraseña de pago
            </button>
            <button @click="openModalPassword()"
                class="flex items-center justify-center bg-blue-500 text-white rounded-lg p-4">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 1c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 16.52 2 11 6.48 1 12 1zm0 2c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 3a4.98 4.98 0 0 0-2.89.94L14 11H6v2h5l.22.03a2.998 2.998 0 0 1 5.56 0A2.98 2.98 0 0 1 18 11a3 3 0 0 1-3-3h-2a1 1 0 0 0-2 0H9a3 3 0 0 1-3 3 2.98 2.98 0 0 1-1.77-.59A4.98 4.98 0 0 0 12 6z" />
                </svg>
                Cambiar contraseña
            </button>
        </div>
    </div>
    <!--<> Modal para ver la direccion tron del usuario<>-->
    <TransitionRoot as="template" :show="modal_wallet_tron">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_wallet_tron = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">
                                <div>
                                    {{ $t('Tu dirección de billetera de MagicalMoriak és:') }}

                                    <input type="text" v-model="user.direccion"
                                        class="border-gray-300 rounded-md w-full px-3 mt-3" disabled>
                                    <button @click.prevent="copyToClipboardTron"
                                        class="absolute right-0 top-1/2 transform -translate-y-1/2 flex items-center px-2 text-gray-500 hover:text-gray-700">
                                        <i class="fa-solid fa-copy mb-6 mr-7"></i>
                                    </button>
                                </div>
                                <p v-if="showCopyMessageTron" class="text-sm text-gray-500 mt-2">
                                    {{ $t('Copiado correctamente!') }}
                                </p>
                                <div class="flex justify-end">
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center mt-6"
                                        @click="closeModalWalletTron()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->
    <!--<> Modal para hacer transferencias de billetera tron a billetera tron<>-->
    <TransitionRoot as="template" :show="modal_transfers">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_transfers = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">
                                        <i class="fas fa-edit mr-2"></i>{{ $t('Transferencia') }}
                                    </label>

                                    {{ $t('Indica la cantidad que deseas transferir') }}
                                    <input type="number" v-model="quantityToTransfer"
                                        class="border-gray-300 focus:border-blue-500 rounded-md w-full py-2 px-3 mb-5"
                                        :placeholder="'Tu saldo: ' + accountBalance">



                                    {{ $t('Indica el usuario al que le deseas transferir ') }}

                                    <input :type="showNewPassword ? 'text' : 'password'" v-model="newPassword"
                                        id="newPassword" name="newPassword"
                                        class="border-gray-300 rounded-md w-full py-2 px-3 mb-5">
                                    <div v-if="error" class="text-red-500 mt-2">
                                        {{ error }}
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button
                                        class="bg-teal-400 hover:bg-teal-600 font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center"
                                        @click.prevent="changePassword()">
                                        <i class="far fa-save mr-2"></i>{{ $t('Enviar') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="closeModalTransfers()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->
    <!--<> Modal para cambiar la contraseña del usuario<>-->
    <TransitionRoot as="template" :show="modal_new_password">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_new_password = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">
                                        <i class="fas fa-edit mr-2"></i>{{ $t('Contraseña') }}
                                    </label>

                                    {{ $t('Contraseña actual') }}
                                    <i :class="showActualPassword ? 'far fa-eye' : 'far fa-eye-slash'"
                                        @click="togglePasswordVisibility('ActualPassword')">
                                    </i>
                                    <input :type="showActualPassword ? 'text' : 'password'" v-model="actualPassword"
                                        id="actualPassword" name="actualnewPassword"
                                        class="border-gray-300 rounded-md w-full py-2 px-3 mb-5">

                                    {{ $t('Nueva contraseña') }}
                                    <i :class="showNewPassword ? 'far fa-eye' : 'far fa-eye-slash'"
                                        @click="togglePasswordVisibility('NewPassword')">
                                    </i>
                                    <input :type="showNewPassword ? 'text' : 'password'" v-model="newPassword"
                                        id="newPassword" name="newPassword"
                                        class="border-gray-300 rounded-md w-full py-2 px-3 mb-5">

                                    {{ $t('Confirme la nueva contraseña') }}
                                    <i :class="showConfirmNewPassword ? 'far fa-eye' : 'far fa-eye-slash'"
                                        @click="togglePasswordVisibility('confirmNewPassword')">
                                    </i>
                                    <input :type="showConfirmNewPassword ? 'text' : 'password'" v-model="confirmNewPassword"
                                        id="confirmNewPassword" name="confirmNewPassword"
                                        class="border-gray-300 rounded-md w-full py-2 px-3" :class="{ '': error !== '' }">

                                    <div v-if="error" class="text-red-500 mt-2">
                                        {{ error }}
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button
                                        class="bg-teal-400 hover:bg-teal-600 font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center"
                                        @click.prevent="changePassword()">
                                        <i class="far fa-save mr-2"></i>{{ $t('save') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="closeModalPassword()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->

    <!--<> Modal para cambiar la contraseña de pago<>-->
    <TransitionRoot as="template" :show="modal_payment_password">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_payment_password = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">
                                <div v-if="user.payment_password">
                                    {{ $t('Ya tienes una contraseña de pago establecida') }}

                                </div>
                                <div v-else class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2"><i class="fas fa-edit mr-2"></i> {{
                                        $t('Contraseña de pago')
                                    }}</label>
                                    {{ $t('password') }}
                                    <i :class="actualPasswordVisible ? 'far fa-eye' : 'far fa-eye-slash'"
                                        @click="togglePasswordVisibility('actualPassword')"></i>


                                    <input type="password" v-model="newPaymentPassword" id="newPassword" name="newPassword"
                                        class="border-gray-300 rounded-md w-full py-2 px-3 mb-5">
                                    {{ $t('confirm-new-password') }}
                                    <i :class="confirmNewPasswordVisible ? 'far fa-eye' : 'far fa-eye-slash'"
                                        @click="togglePasswordVisibility('confirmNewPassword')"></i>

                                    <input type="password" v-model="confirmPaymentNewPassword" id="confirmNewPassword"
                                        name="confirmNewPassword" class="border-gray-300 rounded-md w-full py-2 px-3"
                                        :class="{ '': error !== '' }">

                                    <div v-if="error" class="text-red-500 mt-2">
                                        {{ error }}
                                    </div>
                                </div>
                                <div class="flex justify-end">

                                    <button
                                        class="bg-teal-400 hover:bg-teal-600 font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center mt-10"
                                        @click.prevent="changePaymentPassword()">
                                        <i class="far fa-save mr-2"></i>{{ $t('save') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center mt-10"
                                        @click="closeModalPaymentPassword()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->
    <!-- Modal para cambiar la direccion de la cartera -->
    <TransitionRoot as="template" :show="modal_direccion_billetera">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_direccion_billetera = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">
                                <div class="mb-4">
                                    <label for="image" class="block text-gray-700 font-bold mb-2">
                                        <i class="fas fa-edit mr-2"></i>
                                        {{ $t('Direccion de la billetera') }}
                                    </label>
                                    <div v-if="!user.direccion_billetera_binance">
                                        {{ $t('Introduce la direccion de tu billetera de binance') }}

                                        <input type="text" v-model="newWalletAddress" id="actualPassword"
                                            name="actualPassword" class="border-gray-300 rounded-md w-full px-3 mb-5">
                                    </div>
                                    <div v-else class="mt-5 relative">
                                        {{ $t('Tu dirección de billetera de Binance actual es:') }}
                                        <div class="relative flex items-center">
                                            <input v-model="user.direccion_billetera_binance" type="text"
                                                class="border-gray-300 rounded-md w-full px-3 mb-2" disabled>
                                            <button @click.prevent="copyToClipboard"
                                                class="absolute right-0 top-1/2 transform -translate-y-1/2 flex items-center px-2 text-gray-500 hover:text-gray-700">
                                                <i class="fa-solid fa-copy mb-2 mr-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p v-if="showCopyMessage" class="text-sm text-gray-500 mt-2">
                                        {{ $t('Copiado correctamente') }}
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        class="bg-teal-400 hover:bg-teal-600 font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center"
                                        @click="saveWallet()">
                                        <i class="far fa-save mr-2"></i>{{ $t('save') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="closeModalDireccionBilletera()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                    <button type="button"
                                        class="bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-3 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="deleteWallet()">
                                        <i class="fas fa-trash-alt mr-2"></i>{{ $t('delete') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->
    <!--<> Modal para hacer retiros<>-->
    <TransitionRoot as="template" :show="modal_retirar_dinero">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_retirar_dinero = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">
                                <div class="mb-4">
                                    <label for="image" class="block text-gray-700 font-bold mb-2"><i
                                            class="fas fa-edit mr-2"></i> {{
                                                $t('Retirar dinero')
                                            }}</label>
                                    <div class="mt-5">
                                        {{ $t('Tu saldo actual es:') }}
                                        <input v-model="accountBalance" type="number"
                                            class="border-gray-300 rounded-md w-full px-3 mb-5 mt-3" disabled>
                                    </div>
                                    <div class="mt-5">
                                        {{ $t('Monto a retirar:') }}
                                        <input v-model="MontoRetirar" type="number"
                                            class="border-gray-300 rounded-md w-full px-3 mb-5 mt-3"
                                            :class="{ 'border-red-500': errorField === 'Monto' }"
                                            @input="clearError('Monto')" />
                                    </div>
                                    <div v-if="error && errorField === 'Monto'" class="text-red-500 mt-1">{{ error }}</div>
                                    <div class="mt-5">
                                        {{ $t('Direccion del monedero:') }}
                                        <input v-model="user.direccion_billetera_binance" type="text"
                                            class="border-gray-300 rounded-md w-full px-3 mb-5 mt-3"
                                            :class="{ 'border-red-500': errorField === 'Wallet' }"
                                            @input="clearError('Wallet')" disabled>
                                    </div>
                                    <div v-if="error && errorField === 'Wallet'" class="text-red-500 mt-1">{{ error }}</div>
                                    <div class="mt-5">
                                        {{ $t('Contraseña de pago:') }}
                                        <input v-model="payment_password" type="password"
                                            class="border-gray-300 rounded-md w-full px-3 mb-5 mt-3"
                                            :class="{ 'border-red-500': errorField === 'PaymentPassword' }"
                                            @input="clearError('PaymentPassword')">
                                    </div>
                                    <div v-if="error && errorField === 'PaymentPassword'" class="text-red-500 mt-1">{{ error
                                    }}</div>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        class="bg-teal-400 hover:bg-teal-600 font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center"
                                        @click.prevent="retireMoney()">
                                        <i class="far fa-save mr-2"></i>{{ $t('Retirar') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-1 px-1 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="closeModalRetirarDinero()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--<> Fin del modal <>-->
</template>
  
  
  
<script>
import axios from 'axios';
import TronWeb from 'tronweb';
import { Buffer } from 'buffer';

window.Buffer = Buffer;

export default {
    data() {
        return {
            user: [],
            showModal: false,
            modal_wallet_tron: false,
            modal_transfers: false,
            modal_direccion_billetera: false,
            modal_payment_password: false,
            modal_new_password: false,
            modal_retirar_dinero: false,
            error: '',
            errorField: '',
            accountBalance: 0,
            userInitial: '',
            private_key: '',
            newWalletAddress: '',
            actualPassword: '',
            newPassword: '',
            confirmPassword: '',
            newPaymentPassword: '',
            confirmPaymentNewPassword: '',
            showActualPassword: false,
            showNewPassword: false,
            showConfirmNewPassword: false,
            showCopyMessage: '',
            showCopyMessageTron: '',
            MontoRetirar: ''
        };
    },
    mounted() {
        axios.get('/User-info').then(response => {
            this.user = response.data;
            this.private_key = this.user.private_key;
            this.direccion = this.user.direccion;
            this.getUserInitial();
            this.initialize(); // Llama a la función de inicialización después de asignar this.private_key
        });
    },
    methods: {
        getUserInitial() {
            if (this.user.name && this.user.name.trim() !== '') {
                this.userInitial = this.user.name.trim()[0].toUpperCase();
            } else {
                this.userInitial = '';
            }
        },
        initialize() {
            const direccion_usdt = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";
            const tronWeb = new TronWeb({
                fullNode: 'https://api.trongrid.io',
                solidityNode: 'https://api.trongrid.io',
                eventServer: 'https://api.trongrid.io',
                privateKey: this.private_key
            });

            const url = "https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=usd";

            const obtenerSaldo = async () => {
                const contractInstance = await tronWeb.contract().at(direccion_usdt);
                const balanceInSun = await contractInstance.balanceOf(this.direccion).call();
                const balanceInUSDT = balanceInSun / 1000000;

                const response = await fetch(url);
                const data = await response.json();
                const usdRate = data.tether.usd;
                const balanceInUSD = balanceInUSDT * usdRate;
                console.log(balanceInUSD)

                this.accountBalance = balanceInUSD.toFixed(4);
            }

            obtenerSaldo();
        },

        changePassword() {
            // Realizar validaciones
            if (this.actualPassword === '') {
                this.error = 'Ingrese la contraseña actual';
                return;
            }

            if (this.actualPassword != this.user.password) {
                this.error = 'La contraseña actual es incorrecta'
            }

            if (this.newPassword === '') {
                this.error = 'Ingrese la nueva contraseña';
                return;
            }
            if (this.confirmNewPassword === '') {
                this.error = 'Confirme la nueva contraseña';
                return;
            }
            if (this.newPassword !== this.confirmNewPassword) {
                this.error = 'Las contraseñas no coinciden';
                return;
            }

            // Realizar petición POST a la ruta /changePassword
            axios.post('/changePassword', {
                actualPassword: this.actualPassword,
                newPassword: this.newPassword
            })
                .then(response => {
                    // Procesar la respuesta de éxito aquí
                })
                .catch(error => {
                    // Procesar el error aquí
                });
        },

        togglePasswordVisibility(inputId) {
            if (inputId === 'ActualPassword') {
                this.showActualPassword = !this.showActualPassword;
            } else if (inputId === 'NewPassword') {
                this.showNewPassword = !this.showNewPassword;
            } else if (inputId === 'confirmNewPassword') {
                this.showConfirmNewPassword = !this.showConfirmNewPassword;
            }
        },


        saveWallet() {
            axios
                .post('/saveWallet', { walletAddress: this.newWalletAddress })
                .then(response => {
                    this.user.direccion_billetera_binance = this.newWalletAddress;
                    alert('¡La dirección de la billetera se guardó correctamente!');
                    this.closeModalDireccionBilletera();
                })
                .catch(error => {
                    alert('Ha ocurrido un error al guardar la dirección de la billetera. Por favor, inténtalo de nuevo más tarde.');
                    // Aquí puedes manejar el error de acuerdo a tus necesidades
                });
        },

        deleteWallet() {
            if (confirm("¿Estás seguro que deseas eliminar tu dirección de billetera de Binance?")) {
                axios.post('/deleteWallet')
                    .then(response => {
                        alert("¡La dirección de la billetera se eliminó correctamente!");
                        this.user.direccion_billetera_binance = '';
                        this.closeModalDireccionBilletera();
                    })
                    .catch(error => {
                        alert("Ha ocurrido un error al eliminar la dirección de la billetera. Por favor, inténtalo de nuevo más tarde.");
                        // Aquí puedes manejar el error de acuerdo a tus necesidades
                    });
            }
        },

        changePaymentPassword() {
            // Validar si la contraseña y su confirmación coinciden
            if (this.newPaymentPassword !== this.confirmPaymentNewPassword) {
                this.error = 'Las contraseñas no coinciden.';
                return;
            }

            this.error = '';
            // Realizar la petición Axios a la ruta correspondiente
            axios.post('/createPaymentPassword', { password: this.newPaymentPassword })
                .then(response => {
                    alert('¡La contraseña de pago se guardó correctamente!');
                    this.user.payment_password = this.newPaymentPassword
                    this.closeModalPaymentPassword();
                })
                .catch(error => {
                    alert('Ha ocurrido un error al guardar la contraseña de pago. Por favor, inténtalo de nuevo más tarde.');
                    // Aquí puedes manejar el error de acuerdo a tus necesidades
                });
        },

        copyToClipboard() {
            const input = document.createElement('input');
            input.value = this.user.direccion_billetera_binance;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            this.showCopyMessage = true;

            // Ocultar el mensaje de copia después de 2 segundos
            setTimeout(() => {
                this.showCopyMessage = false;
            }, 2000);
        },
        copyToClipboardTron() {
            const input = document.createElement('input');
            input.value = this.user.direccion;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            this.showCopyMessageTron = true;

            // Ocultar el mensaje de copia después de 2 segundos
            setTimeout(() => {
                this.showCopyMessageTron = false;
            }, 2000);
        },

        retireMoney() {
            if (!this.MontoRetirar || this.MontoRetirar === '') {
                this.error = 'Por favor, introduzca la cantidad que deseas retirar';
                this.errorField = 'Monto';
                return;
            }
            if (parseFloat(this.MontoRetirar) < 10) {
                this.error = 'La cantidad debe ser de mínimo 10 o superior';
                this.errorField = 'Monto';
                return;
            }

            if (!this.user.direccion_billetera_binance || this.user.direccion_billetera_binance === '') {
                this.error = 'Necesitas la direccion de tu monedero de binance';
                this.errorField = 'Wallet';
                return;
            }

            if (!this.payment_password || this.payment_password === '') {
                this.error = 'Introduce tu contraseña de pago';
                this.errorField = 'PaymentPassword';
                return;
            }

            if (this.payment_password != this.user.payment_password) {
                this.error = 'Tu contraseña de pago es incorrecta';
                this.errorField = 'PaymentPassword';
                return;
            }

            if (parseFloat(this.MontoRetirar) > parseFloat(this.accountBalance)) {
                this.error = 'Saldo insuficiente';
                this.errorField = 'Monto';
                return;
            }



        },
        clearError(field) {
            if (this.errorField === field) {
                this.error = '';
                this.errorField = '';
            }
        },

        openModalWalletTron() {
            this.modal_wallet_tron = true;
        },

        closeModalWalletTron() {
            this.modal_wallet_tron = false;
        },

        openModalTransfers() {
            this.modal_transfers = true;
        },

        closeModalTransfers() {
            this.modal_transfers = false;
        },

        openModalPassword() {
            this.modal_new_password = true;
        },

        closeModalPassword() {
            this.modal_new_password = false;
        },

        openModalPaymentPassword() {
            this.modal_payment_password = true;
        },

        closeModalPaymentPassword() {
            this.modal_payment_password = false;
        },

        openModalDireccionBilletera() {
            this.modal_direccion_billetera = true;
        },

        closeModalDireccionBilletera() {
            this.modal_direccion_billetera = false;
        },

        closeModal() {
            this.modal_image = false;
        },

        openModalRetirarDinero() {
            this.modal_retirar_dinero = true;
        },

        closeModalRetirarDinero() {
            this.modal_retirar_dinero = false;
        }
    }
};
</script>

<script setup>
//Script setup es per a que funcionigue el modal de headless
import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue'

</script>

<style scoped>
#saldoDIV {
    height: 100px;
    width: 400px;
}
</style>