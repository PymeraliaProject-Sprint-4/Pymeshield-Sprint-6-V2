<template>
    <div class="flex justify-center mt-5">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center"
            @click="ModalCrear = true">
            <PlusIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
            <span class="ml-2">{{ $t('create-company') }}</span>
        </button>
        <div class="w-4"></div> <!-- Espacio entre los botones -->
        <button @click="redirectToDeletedCompany()" id=""
            class="mr-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded flex items-center text-center">
            <EyeSlashIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Deleted.Company') }}
        </button>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-orange-400 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('company-name') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('email') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('phone') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('cif') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('functions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="companies.length > 0">
                                <tr v-for="(company, key) in companies" :key="key"
                                    class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white    ">
                                        {{ company.name }}
                                    </th>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ company.email }}
                                    </td>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ company.phone }}
                                    </td>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ company.cif }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-middle">
                                        <div class="inline-flex">
                                            <button
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded "
                                                @click="this.openModalBaja(company.id)">
                                                <TrashIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                            </button> <button
                                                class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                                                @click="this.openModalEditar(company.id, company.name, company.email, company.phone, company.cif)">
                                                <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <h1 class="text-lg content-center" v-else>{{ $t('no-existing-records') }}</h1>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Crear Empresa-->
    <TransitionRoot as="template" :show="ModalCrear">
        <Dialog as="div" class="relative z-10" @close="ModalCrear = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form @submit.prevent="submitForm">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="xl:items-start">
                                        <div class="flex space-x-2 items-center">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center sm:mx-0 sm:h-10 sm:w-10">
                                                <PlusCircleIcon class="h-6 w-6 text-black-400" aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                {{ $t('create-company') }}</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">

                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                            $t('name') }}</label>
                                                    <input v-model="crear.nameCrear" type="text" id="name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                    <span v-if="!crear.nameCrear"
                                                        class="absolute right-10 top-50 text-red-500">*</span>
                                                </div>
                                            </div>




                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                            $t('email') }}</label>
                                                    <input v-model="crear.emailCrear" type="text" id="email"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                    <span v-if="!crear.emailCrear"
                                                        class="absolute right-10 top-50 text-red-500">*</span>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                                $t('phone') }}</label>
                                                        <input v-model="crear.phoneCrear" type="text" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                        <span v-if="!crear.phoneCrear"
                                                            class="absolute left-50 top-50 text-red-500">*</span>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                                $t('cif') }}</label>
                                                        <input v-model="crear.cifCrear" type="text" id="cif"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                        <span v-if="!crear.cifCrear"
                                                            class="absolute right-10 top-50 text-red-500">*</span>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">

                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 "
                                        @click="ModalCrear = false" ref="cancelButtonRef"><i
                                            class="fas fa-times mr-2"></i>{{ $t('cancel') }}</button>
                                    <button type="button"
                                        class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center"
                                        @click="submitFormCrear()"><i class="fas fa-plus mr-2"></i> {{ $t('add') }}</button>


                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--Modal Editar Empresa-->

    <TransitionRoot as="template" :show="ModalEditar">
        <Dialog as="div" class="relative z-10" @close="ModalEditar = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form @submit.prevent="submitForm">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="xl:items-start">
                                        <div class="flex space-x-2 items-center">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center sm:mx-0 sm:h-10 sm:w-10">
                                                <i class="fas fa-edit mr-2"></i>
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                {{ $t('edit-company') }}</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">

                                            <div>
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                        $t('name') }}</label>
                                                <div class="relative">
                                                    <input v-model="editar.nameEditar" type="text" id="name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                    <span v-if="!editar.nameEditar"
                                                        class="absolute right-0 top-0 text-red-500">*</span>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                            $t('email') }}</label>
                                                    <div class="relative">
                                                        <input v-model="editar.emailEditar" type="text" id="email"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                        <span v-if="!editar.emailEditar"
                                                            class="absolute right-0 top-0 text-red-500">*</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">

                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                                $t('phone') }}</label>
                                                        <div class="relative">
                                                            <input v-model="editar.phoneEditar" type="text" id="phone"
                                                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                                required>
                                                            <span v-if="!editar.phoneEditar"
                                                                class="absolute right-0 top-0 text-red-500">*</span>
                                                        </div>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                                $t('cif') }}</label>
                                                        <div class="relative">
                                                            <input v-model="editar.cifEditar" type="text" id="cif"
                                                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                                required>
                                                            <span v-if="!editar.cifEditar"
                                                                class="absolute right-0 top-0 text-red-500">*</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" v-model="editar.id">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">

                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 "
                                        @click="ModalEditar = false" ref="cancelButtonRef"><i
                                            class="fas fa-times mr-2"></i>{{ $t('cancel') }}</button>
                                    <button type="button"
                                        class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center"
                                        @click="submitFormEditar()"> <i class="far fa-save mr-2"></i>{{ $t('save') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--Modal Dar De Baja Empresa-->

    <TransitionRoot as="template" :show="ModalBaja">
        <Dialog as="div" class="relative z-10" @close="ModalBaja = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form @submit.prevent="submitForm">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="xl:items-start">
                                        <div class="flex space-x-2 items-center">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center sm:mx-0 sm:h-10 sm:w-10">
                                                <PencilSquareIcon class="h-6 w-6 text-black-400" aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                {{ $t('deregister-company') }}</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">

                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                            $t('deregistration-reason') }}</label>
                                                    <textarea maxlength="255" v-model="baja.removed_reason"
                                                        class="w-full h-24 align-top bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        cols="auto" rows="10"></textarea>
                                                    <input type="hidden" v-model="baja.id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">

                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 "
                                        @click="ModalBaja = false" ref="cancelButtonRef"><i class="fas fa-times mr-2"></i>{{
                                            $t('cancel') }}

                                    </button>
                                    <button type="button"
                                        class="bg-red-600 hover:bg-red-800 text-white font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-6"
                                        @click="submitFormBaja()"><i class="fas fa-minus mr-2"></i>{{ $t('Deregister')
                                        }}</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--Notificacion Crear Empresa-->

    <TransitionRoot as="template" :show="NotificacionCrear">
        <Dialog as="div" class="relative z-10" @close="NotificacionCrear = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">{{
                                            $t('company-succesfully-created') }}</DialogTitle>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--Notificacion Editar Empresa-->

    <TransitionRoot as="template" :show="NotificacionEditar">
        <Dialog as="div" class="relative z-10" @close="NotificacionEditar = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                            {{ $t('company-succesfully-edited') }}</DialogTitle>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--Notificacion Baja Empresa-->

    <TransitionRoot as="template" :show="NotificacionBaja">
        <Dialog as="div" class="relative z-10" @close="NotificacionBaja = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                            {{ $t('company-succesfully-deleted') }}</DialogTitle>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>

import axios from 'axios';
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/outline'


export default {
    data() {
        return {
            ModalCrear: ref(false),
            NotificacionCrear: ref(false),
            ModalEditar: ref(false),
            NotificacionEditar: ref(false),
            ModalBaja: ref(false),
            NotificacionBaja: ref(false),
            companies: [],
            crear: { nameCrear: "", emailCrear: "", phoneCrear: "", cifCrear: "" },
            editar: { id: "", nameEditar: "", emailEditar: "", phoneEditar: "", cifEditar: "" },
            baja: { id: "", removed_reason: "" },
            paginaActual: 1
        };
    },
    mounted() {
        this.getCompanies();
    },
    methods: {
        openModalCrear() {
            this.ModalCrear = true;
        },
        openModalEditar(id, name, email, phone, cif) {
            this.ModalEditar = true;
            this.editar.id = id
            this.editar.nameEditar = name;
            this.editar.emailEditar = email;
            this.editar.phoneEditar = phone;
            this.editar.cifEditar = cif;
        },
        openModalBaja(id) {
            this.baja.id = id;
            this.ModalBaja = true;
        },
        getCompanies() {
            axios.get("/listadoEmpresas/listCompanies")
                .then(response => {
                    this.companies = [];
                    this.companies = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        submitFormCrear() {
            axios.post("listadoEmpresas/createCompany", {
                name: this.crear.nameCrear,
                email: this.crear.emailCrear,
                phone: this.crear.phoneCrear,
                cif: this.crear.cifCrear
            })
                .then(response => {
                    this.getCompanies();
                    console.log(response);
                    this.ModalCrear = false;
                    this.crear.nameCrear = "";
                    this.crear.emailCrear = "";
                    this.crear.phoneCrear = "";
                    this.crear.cifCrear = "";
                    this.NotificacionCrear = true;
                    setTimeout(() => { this.NotificacionCrear = false; }, 2500);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitFormEditar() {
            axios.post("listadoEmpresas/editCompany", {
                id: this.editar.id,
                name: this.editar.nameEditar,
                email: this.editar.emailEditar,
                phone: this.editar.phoneEditar,
                cif: this.editar.cifEditar
            })
                .then(response => {
                    this.getCompanies();
                    console.log(response);
                    this.ModalEditar = false;
                    this.editar.id = "";
                    this.editar.nameEditar = "";
                    this.editar.emailEditar = "";
                    this.editar.phoneEditar = "";
                    this.editar.cifEditar = "";
                    this.NotificacionEditar = true;
                    setTimeout(() => { this.NotificacionEditar = false; }, 2000);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitFormBaja() {
            axios.post("listadoEmpresas/unsuscribeCompany", {
                id: this.baja.id,
                removed_reason: this.baja.removed_reason
            })
                .then(response => {
                    this.getCompanies();
                    console.log(response);
                    this.ModalBaja = false;
                    this.NotificacionBaja = true;
                    setTimeout(() => { this.NotificacionBaja = false; }, 2000);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        redirectToDeletedCompany() {
            window.location.href = "/listcompanyhidden";
        }
    },
};
</script>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, EyeSlashIcon } from '@heroicons/vue/24/outline'
</script>



