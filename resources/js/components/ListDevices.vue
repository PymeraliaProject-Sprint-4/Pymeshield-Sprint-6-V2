<template>

    <div class="mx-5 mt-3">
        <div class="flex justify-between">
            <div class="flex items-center">
                <p class="text-2xl font-semibold">Listado dispositivos</p>
            </div>
            <div class="flex items-center">
                <button class="bg-orange-400 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="openModalCrear()">Crear dispositivo</button>
            </div>
        </div>
        <table class="mt-2 table-fixed w-full text-base text-left text-gray-800 dark:text-gray-400 text-center">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3 ">{{ $t('brand') }}</th>
                    <th scope="col" class="px-6 py-3">{{ $t('model') }}</th>
                    <th scope="col" class="px-6 py-3">MAC-ethernet</th>
                    <th scope="col" class="px-6 py-3">MAC-wifi</th>
                    <th scope="col" class="px-6 py-3">Tipo</th>
                    <th scope="col" class="px-6 py-3">Descripcion</th>
                    <th scope="col" class="px-6 py-3">Estado</th>
                    <th scope="col" class="w-29 px-6 py-3">Funciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="device in this.devicesData" :key="device.id"
                    class="bg-orange-50 hover:bg-orange-100 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ device.brand }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.model }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.mac_ethernet }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.mac_wifi }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ device.state }}
                    </td>
                    <td class="px-4 py-4 text-center align-middle">
                        <button @click="openModalBorrar(device.id)"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-2 ml-2 rounded ">
                            <ArchiveBoxArrowDownIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                        </button>
                        <button
                            @click="openModalEditar(device.id, device.brand, device.model, device.mac_ethernet, device.mac_wifi, device.type_device_id, device.state, device.serial_number, device.description)"
                            class="bg-orange-400 hover:bg-orange-600  text-white font-bold py-2 px-2 ml-2 rounded">
                            <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-center mt-4">
            <TailwindPagination :data="devices" @pagination-change-page="changePage"
                :current-page="devicesData.current_page" />
        </div>

    </div>

    <!-- Modal crear -->
    <TransitionRoot as="template" :show="ModalCrear">
        <Dialog as="div" class="relative z-10" @close="ModalCrear = false">
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
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <PlusCircleIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Crear
                                                nuevo dispositivo</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">
                                            <div v-if="errors.length > 0" class="bg-red-100 text-red-700 p-2 rounded-md">
                                                <ul>
                                                    <li v-for="error in errors" :key="error"> · {{ error }}</li>
                                                </ul>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</label>
                                                    <input v-model="crear.brand" type="text" id="brand"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modelo</label>
                                                    <input v-model="crear.model" type="text" id="model"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MAC-Ethernet</label>
                                                        <input v-model="crear.mac_ethernet" type="text" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MAC-Wifi</label>
                                                        <input v-model="crear.mac_wifi" type="text" id="cif"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                                                        <select v-model="crear.type_device_id"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400">
                                                            <option value="Seleccione">Seleccione un tipo...</option>
                                                            <option v-for="type_device in types_device"
                                                                :key="type_device.id" :value="type_device.id">{{
                                                                    type_device.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                        <select v-model="crear.state"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            crear.type_device_id>
                                                            <option value="Seleccione">Seleccione un estado...</option>
                                                            <option value="Operativo">Operativo</option>
                                                            <option value="En mantenimiento">En mantenimiento</option>
                                                            <option value="Deshabilitado">Deshabilitado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero
                                                        de serie</label>
                                                    <input v-model="crear.serial_number" type="text" id="serial_number"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                                    <textarea maxlength="255" v-model="crear.description"
                                                        class="w-full h-24 align-top bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        cols="auto" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-orange-400 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="submitFormCrear()">Crear</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="ModalCrear = false" ref="cancelButtonRef">Cancelar</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Modal editar -->
    <TransitionRoot as="template" :show="ModalEditar">
        <Dialog as="div" class="relative z-10" @close="ModalEditar = false">
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
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <PlusCircleIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Editar
                                                dispositivo</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">
                                            <div v-if="errors.length > 0" class="bg-red-100 text-red-700 p-2 rounded-md">
                                                <ul>
                                                    <li v-for="error in errors" :key="error"> · {{ error }}</li>
                                                </ul>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</label>
                                                    <input v-model="editar.brand" type="text" id="brand"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modelo</label>
                                                    <input v-model="editar.model" type="text" id="model"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MAC-Ethernet</label>
                                                        <input v-model="editar.mac_ethernet" type="text" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MAC-Wifi</label>
                                                        <input v-model="editar.mac_wifi" type="text" id="cif"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                                                        <select v-model="editar.type_device_id" id="type_device_id_editar"
                                                            ref="type_device_id_editar"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400">
                                                            <option v-for="type_device in types_device"
                                                                :key="type_device.id" :value="type_device.id">{{
                                                                    type_device.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="w-full">
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                        <select v-model="editar.state"
                                                            class="w-full bg-gray-50 border border-gray-300 text-black-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            crear.type_device_id>
                                                            <option value="Operativo">Operativo</option>
                                                            <option value="En mantenimiento">En mantenimiento</option>
                                                            <option value="Deshabilitado">Deshabilitado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero
                                                        de serie</label>
                                                    <input v-model="editar.serial_number" type="text" id="serial_number"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                                    <textarea maxlength="255" v-model="editar.description"
                                                        class="w-full h-24 align-top bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        cols="auto" rows="4"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" v-model="editar.id">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-orange-400 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="submitFormEditar()">Guardar</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="ModalEditar = false" ref="cancelButtonRef">Cancelar</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Modal eliminar -->
    <TransitionRoot as="template" :show="ModalBorrar">
        <Dialog as="div" class="relative z-10" @close="ModalBorrar = false">
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
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ArchiveBoxArrowDownIcon class="h-6 w-6 text-orange-400"
                                                    aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                Eliminar dispositivo</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">

                                            <div class="mt-2">
                                                <div>
                                                    <h4>Estas seguro que quieres eliminar este dispositivo?</h4>
                                                    <input type="hidden" v-model="borrar.id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" v-model="borrar.id">
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="submitFormBorrar()">Eliminar</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="ModalBorrar = false" ref="cancelButtonRef">Cancelar</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Notificacio crear dispositiu -->
    <TransitionRoot as="template" :show="NotificacionCrear">
        <Dialog as="div" class="relative z-10" @close="NotificacionCrear = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="xl:items-start">
                        <div class="flex space-x-2 items-center justify-center">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                            </div>
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Dispositivo creado correctamente</DialogTitle>
                        </div>
                    </div>
                    </div>
                </DialogPanel>
                </TransitionChild>
            </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Notificacio editar dispositiu -->
    <TransitionRoot as="template" :show="NotificacionEditar">
        <Dialog as="div" class="relative z-10" @close="NotificacionEditar = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="xl:items-start">
                        <div class="flex space-x-2 items-center justify-center">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                            </div>
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Dispositivo editado correctamente</DialogTitle>
                        </div>
                    </div>
                    </div>
                </DialogPanel>
                </TransitionChild>
            </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Notificacio eliminar dispositiu -->
    <TransitionRoot as="template" :show="NotificacionBorrar">
        <Dialog as="div" class="relative z-10" @close="NotificacionBorrar = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="items-center">
                        <div class="flex space-x-2 items-center justify-center">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ShieldCheckIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                            </div>
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Dispositivo eliminado correctamente</DialogTitle>
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
import { ref } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    data() {
        return {
            //Referencies per als diferents modalss
            ModalCrear: ref(false),
            ModalEditar: ref(false),
            ModalBorrar: ref(false),
            NotificacionCrear: ref(false),
            NotificacionEditar: ref(false),
            NotificacionBorrar: ref(false),
            devices: {},
            devicesData: [],
            errors: [],

            //Variables per guardar els arrays de les dades
            types_device: [],

            //Variables v-model
            crear: { brand: "", model: "", mac_ethernet: "", mac_wifi: "", type_device_id: "Seleccione", state: "Seleccione", serial_number: "", description: "" },
            editar: { id: "", brand: "", model: "", mac_ethernet: "", mac_wifi: "", type_device_id: "", state: "", serial_number: "", description: "" },
            borrar: { id: "" }
        };
    },
    mounted() {
        this.typeDevice();
        this.getDevices();
    },
    computed: {
        macValida() {
            const mac = this.crear.mac_ethernet || this.crear.mac_wifi;
            if (!mac) {
                return true; // Si no se ha ingresado ninguna dirección MAC, no es necesario validarla
            }
            const regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/; // Expresión regular para validar la dirección MAC
            return regex.test(mac); // Devuelve true si la dirección MAC es válida, de lo contrario, devuelve false
        },
        macValidaEditar(){
            const mac = this.editar.mac_ethernet || this.editar.mac_wifi;
            if (!mac) {
                return true; // Si no se ha ingresado ninguna dirección MAC, no es necesario validarla
            }
            const regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/; // Expresión regular para validar la dirección MAC
            return regex.test(mac); // Devuelve true si la dirección MAC es válida, de lo contrario, devuelve false
        }
    },
    watch: {
        ModalCrear(newValue, oldValue) {
            if (oldValue === true && newValue === false) {
                this.clearErrors();
            }
        },

        ModalEditar(newValue, oldValue) {
            if (oldValue === true && newValue === false) {
                this.clearErrors();
            }
        },
    },
    methods: {
        getDevices(page = 1) {
            this.devicesData.value = [];
            this.devicesData.data = [];
            axios.get("/devices/list?page=" + page)
                .then(response => {
                    this.devices = response.data;
                    this.devicesData = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        changePage(page) {
            this.getDevices(page)
        },
        openModalCrear() {
            this.typeDevice()
            this.ModalCrear = true;
        },
        openModalEditar(id, brand, model, mac_ethernet, mac_wifi, type_device_id, state, serial_number, description) {
            this.editar.id = id;
            this.editar.brand = brand;
            this.editar.model = model;
            this.editar.mac_ethernet = mac_ethernet;
            this.editar.mac_wifi = mac_wifi;
            this.editar.type_device_id = type_device_id;
            this.editar.state = state;
            this.editar.serial_number = serial_number;
            this.editar.description = description;

            this.ModalEditar = true;

            this.types_device.forEach(type => {
                // Si el tipus de dispositiu coincideix amb el valor seleccionat, el seleccionem al element select
                if (type.id === this.type_device_id) {
                    option.selected = true;
                }
            });
        },
        openModalBorrar(id) {
            this.borrar.id = id;
            this.ModalBorrar = true;
        },
        typeDevice() {
            axios.get('/devices/type_devices')
                .then((response) => {
                    this.types_device = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        submitFormCrear() {
            this.errors = [];

            if (!this.crear.brand) {
                this.errors.push("La marca es obligatoria");
            }

            if (!this.crear.model) {
                this.errors.push("El modelo es obligatorio");
            }

            if (!this.crear.mac_ethernet && !this.crear.mac_wifi) {
                this.errors.push("Se requiere al menos una dirección MAC");
            }else if (!this.macValida) {
                this.errors.push("La dirección MAC no es válida");
            }

            if (isNaN(this.crear.type_device_id)) {
                this.errors.push("Se requiere un tipo de dispositivo");
            }

            if (!["Operativo", "En mantenimiento", "Deshabilitado"].includes(this.crear.state)) {
                this.errors.push("Se requiere un estado válido");
            }

            if (!this.crear.serial_number) {
                this.errors.push("El número de serie es obligatorio");
            }

            if (this.errors.length === 0) {
                axios.post("/devices/create", {
                    brand: this.crear.brand,
                    model: this.crear.model,
                    mac_ethernet: this.crear.mac_ethernet,
                    mac_wifi: this.crear.mac_wifi,
                    type_device_id: this.crear.type_device_id,
                    description: this.crear.description,
                    state: this.crear.state,
                    serial_number: this.crear.serial_number
                })
                    .then(response => {
                        this.getDevices();
                        console.log(response);
                        this.ModalCrear = false;

                        this.crear.brand = "",
                        this.crear.description = "",
                        this.crear.mac_ethernet = "",
                        this.crear.mac_wifi = "",
                        this.crear.description = "",
                        this.crear.state = "",
                        this.crear.serial_number = ""
                        this.NotificacionCrear = true;
                        setTimeout(() => { this.NotificacionCrear = false; }, 2500);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            return true;
        },
        submitFormEditar() {
            this.errors = [];

            if (!this.editar.brand) {
                this.errors.push("La marca es obligatoria");
            }

            if (!this.editar.model) {
                this.errors.push("El modelo es obligatorio");
            }

            if (!this.editar.mac_ethernet && !this.editar.mac_wifi) {
                this.errors.push("Se requiere al menos una dirección MAC");
            }else if (!this.macValidaEditar) {
                this.errors.push("La dirección MAC no es válida");
            }

            if (isNaN(this.editar.type_device_id)) {
                this.errors.push("Se requiere un tipo de dispositivo");
            }

            if (!["Operativo", "En mantenimiento", "Deshabilitado"].includes(this.editar.state)) {
                this.errors.push("Se requiere un estado válido");
            }

            if (!this.editar.serial_number) {
                this.errors.push("El número de serie es obligatorio");
            }

            if (this.errors.length === 0) {
                axios.post('/devices/edit', {
                id: this.editar.id,
                brand: this.editar.brand,
                model: this.editar.model,
                mac_ethernet: this.editar.mac_ethernet,
                mac_wifi: this.editar.mac_wifi,
                type_device_id: this.editar.type_device_id,
                description: this.editar.description,
                state: this.editar.state,
                serial_number: this.editar.serial_number
                })
                .then(response => {
                    this.getDevices();
                    this.ModalEditar = false;
                    this.NotificacionEditar = true;
                    setTimeout(() => { this.NotificacionEditar = false; }, 2500);
                    console.log(response)
                })
                .then(error => {
                    console.log(error)
                })
            }
            return true;

        },
        submitFormBorrar(){
            this.$axios.post("devices/delete", {
                id: this.borrar.id
            })
                .then(response => {
                    this.getDevices();
                    this.ModalBorrar = false;
                    this.NotificacionBorrar = true;
                    setTimeout(() => { this.NotificacionBorrar = false; }, 2500);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        clearErrors() {
            this.errors = [];
        },
    },
};
</script>

<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { PlusCircleIcon, ArchiveBoxArrowDownIcon, ShieldCheckIcon, PencilSquareIcon, InboxArrowDownIcon } from '@heroicons/vue/24/outline'
</script>
