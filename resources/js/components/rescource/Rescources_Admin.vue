<template>
    <h1 class="mt-5 ml-9 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Admin') }}</span>
    </h1>
    <p class="ml-9 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $t('phrase.1.rescources') }}
    </p>

    <div style="display: flex; justify-content: center;">
        <!-- Modal toggle -->
        <button id="" @click="modal_crear_recurs_text = true"
            class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 ml-5 flex items-center"
            type="button">
            <PlusIcon class="h-6 w-6 text-white-400 font" aria-hidden="true" />
            {{ $t('Add') }} {{ $t('rescource') }} {{ $t('text') }}
        </button>

        <button id="" @click="modal_crear_recurs_url = true"
            class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 ml-5 flex items-center"
            type="button">
            <PlusIcon class="h-6 w-6 text-white-400 font" aria-hidden="true" />
            {{ $t('Add') }} {{ $t('rescource') }} {{ $t('URL') }}
        </button>

        <button id="" @click="modal_crear_recurs_arxiu = true"
            class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 ml-5 flex items-center"
            type="button">
            <PlusIcon class="h-6 w-6 text-white-400 font" aria-hidden="true" />
            {{ $t('Add') }} {{ $t('rescource') }} {{ $t('file') }}
        </button>

        <button id="" @click="redirectToCourses()"
            class=" ml-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded mt-5 flex items-center text-center ">
            <ArrowLeftCircleIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Courses') }}
        </button>

        <button id="" @click="redirectToCategories()"
            class=" ml-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded mt-5 flex items-center text-center ">
            <ArrowLeftCircleIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Categories') }}
        </button>

    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900">
                <div class="flex items-center">
                    <div class="mr-5">
                        <button
                            class="text-black font-bold focus:ring-4 focus:outline-none rounded ml-5 flex items-center text-center h-6 px-2">
                            <select v-model="selectedType" @change="sortTable">
                                <option value="text">{{ $t('text') }}</option>
                                <option value="URL" selected>{{ $t('URL') }}</option>
                                <option value="file">{{ $t('file') }}</option>
                            </select>
                        </button>
                    </div>
                    <div class="flex justify-end">
                        <div class="mb-4">
                            <input v-model="searchTerm" type="text"
                                class=" mt-5 px-4 py-2 border rounded-lg w-60 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                :placeholder="$t('Search')" />
                        </div>
                    </div>
                </div>
                <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full shadow-lg rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr class="bg-orange-400">
                                <th scope="col" class="text-xs text-white uppercase p-4">
                                    {{ $t('Rescources') }}
                                </th>
                                <th scope="col" class="text-xs text-white uppercase p-4">
                                    {{ $t('Options') }}

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-orange-50 hover:bg-orange-100 text-center" v-for="rescource in filteredRescources"
                                :key="rescource.id">
                                <td class="break-all px-6 py-4 font-medium text-gray-900">
                                    {{ rescource.name }}
                                </td>
                                <td>
                                    <div class="inline-flex">
                                        <!-- Modal toggle -->
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                                            @click="openModal(rescource)">
                                            <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>

                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded "
                                            @click="ModalEliminarRecurs(rescource)">
                                            <TrashIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-center items-center mt-8">
                        <nav class="bg-white p-6 rounded-lg shadow-lg">
                            <ul class="flex space-x-4">
                                <li v-if="pagination.length > 0 && currentPage > 1">
                                    <button @click="changePage(currentPage - 1)"
                                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md">
                                        {{ $t('Previous') }}
                                    </button>
                                </li>
                                <li v-for="page in Math.ceil(rescources.length / perPage)" :key="page">
                                    <button @click="changePage(page)"
                                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md"
                                        :class="{ 'bg-orange-400': page === currentPage }">
                                        {{ page }}
                                    </button>
                                </li>
                                <li v-if="pagination.length > 0 && currentPage < Math.ceil(rescources.length / perPage)">
                                    <button @click="changePage(currentPage + 1)"
                                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md">
                                        {{ $t('Next') }}
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL CREAR RECURS TIPO TEXT-->
    <TransitionRoot as="template" :show="modal_crear_recurs_text">
        <Dialog as="div" class="relative z-10" @close="modal_crear_recurs_text = false">
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
                            <form action="" id="category-form" method="POST">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Create') }} {{ $t('new') }} {{ $t('rescource') }} {{ $t('text') }}
                                        </DialogTitle>
                                    </div>
                                    <div class="sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('rescource') }}
                                                </label>
                                                <input maxlength="50" required v-model="name" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Description') }} {{ $t('Of') }} {{ $t('rescource') }}
                                                </label>
                                                <input maxlength="50" required v-model="description" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.categories') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(category, index) in categories" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="radio" name="selectedCategory"
                                                                :value="category.id" v-model="selectedCategory">
                                                            {{ category.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="saveResourceText()">
                                        <i class="far fa-save mr-2"></i> {{ $t('Create') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_crear_recurs_text = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--FIN MODAL-->

    <!--MODAL CREAR RECURS TIPO URL-->
    <TransitionRoot as="template" :show="modal_crear_recurs_url">
        <Dialog as="div" class="relative z-10" @close="modal_crear_recurs_url = false">
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
                            <form action="" id="category-form" method="POST">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Create') }} {{ $t('new') }} {{ $t('rescource') }} {{ $t('URL') }}
                                        </DialogTitle>
                                    </div>
                                    <div class="sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('rescource') }}
                                                </label>
                                                <input maxlength="50" required v-model="name" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    Locate
                                                </label>
                                                <input maxlength="50" required v-model="locate" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.categories') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(category, index) in categories" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="radio" name="selectedCategory"
                                                                :value="category.id" v-model="selectedCategory">
                                                            {{ category.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="saveResourceURL()">
                                        <i class="far fa-save mr-2"></i> {{ $t('Create') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_crear_recurs_url = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--FIN MODAL-->

    <!--MODAL CREAR RECURS TIPO ARXIU-->
    <TransitionRoot as="template" :show="modal_crear_recurs_arxiu">
        <Dialog as="div" class="relative z-10" @close="modal_crear_recurs_arxiu = false">
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
                            <form action="" id="category-form" method="POST">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Create') }} {{ $t('new') }} {{ $t('rescource') }} {{ $t('file') }}
                                        </DialogTitle>
                                    </div>
                                    <div class="sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>

                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('rescource') }}
                                                </label>
                                                <input maxlength="50" required v-model="name" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    Locate
                                                </label>
                                                <input maxlength="50" required v-model="locate" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.categories') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(category, index) in categories" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="radio" name="selectedCategory"
                                                                :value="category.id" v-model="selectedCategory">
                                                            {{ category.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="saveResourceFile()">
                                        <i class="far fa-save mr-2"></i> {{ $t('Create') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_crear_recurs_arxiu = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--FIN MODAL-->


    <!--//MODAL EDITAR RECURS TEXT   -->
    <TransitionRoot as="template" :show="modal_editar_recurs_text">
        <Dialog as="div" class="relative z-10" @close="modal_editar_recurs_text = false">
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
                            <form action="" id="course-edit" method="POST" v-on:submit.prevent="updateResourceText()">

                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Edit') }} {{ $t('rescource') }}
                                        </DialogTitle>
                                    </div>
                                    <div class=" sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('rescource') }} </label>
                                                <input maxlength="50" v-model="selectedRescource" type="text"
                                                    name="category-edits" id="name_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>
                                            <div>
                                                <label for="name_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Description') }} {{ $t('Of') }} {{ $t('rescource') }} </label>
                                                <input maxlength="50" v-model="description" type="text"
                                                    name="category-edits" id="name_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.categories') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(category, index) in categories" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="radio" :value="category.id"
                                                                v-model="selectedCategory">
                                                            {{ category.name }}
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="bg-orange-400 hover:bg-orange-600 font-medium py-2 px-2 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto">
                                        <i class="far fa-save mr-2"></i> {{ $t('Save') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="closeModalEdit()" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--//MODAL EDITAR RECURS URL I ARXIU   -->
    <TransitionRoot as="template" :show="modal_editar_recurs_URL_FILE">
        <Dialog as="div" class="relative z-10" @close="modal_editar_recurs_URL_FILE = false">
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
                            <form action="" id="course-edit" method="POST" v-on:submit.prevent="updateResourceURL_FILE()">

                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Edit') }} {{ $t('rescource') }}
                                        </DialogTitle>
                                    </div>
                                    <div class=" sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('rescource') }} </label>
                                                <input maxlength="50" v-model="selectedRescource" type="text"
                                                    name="category-edits" id="name_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>
                                            <div>
                                                <label for="name_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('location') }} </label>
                                                <input maxlength="50" v-model="location" type="text" name="category-edits"
                                                    id="name_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.categories') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(category, index) in categories" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="radio" :value="category.id"
                                                                v-model="selectedCategory">
                                                            {{ category.name }}
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="bg-orange-400 hover:bg-orange-600 font-medium py-2 px-2 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto">
                                        <i class="far fa-save mr-2"></i> {{ $t('Save') }}
                                    </button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="closeModalEdit()" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!--MODAL ELIMINAR RECURS-->
    <TransitionRoot as="template" :show="modal_eliminar_recurs">
        <Dialog as="div" class="relative z-10" @close="modal_eliminar_recurs = false">
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
                            <form>

                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('delete') }} {{ $t('rescource') }}
                                        </DialogTitle>
                                    </div>
                                    <div class=" sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name_delete" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('phrase.deleteRescource') }} </label>
                                                <input maxlength="50" v-model="selectedRescource" type="text"
                                                    name="category-edits" id="name_delete"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="ml-2 bg-red-600 hover:bg-red-800 text-white font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-6"
                                        @click="deleteResource()">
                                        <i class="far fa-trash-alt mr-2"></i>{{ $t('delete')
                                        }}</button>
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_eliminar_recurs = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--FIN MODAL-->
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            rescources: [],
            categories: [],
            modal_crear_recurs_text: false,
            modal_crear_recurs_url: false,
            modal_crear_recurs_arxiu: false,
            modal_editar_recurs_text: false,
            modal_editar_recurs_URL_FILE: false,
            modal_eliminar_recurs: false,
            selectedRescource: '',
            selectedCourse: '',
            selectedType: '',
            searchTerm: '',
            pagination: {},
            page: 1,
            perPage: 7, // cantidad de elementos por página
            currentPage: 1 // página actual

        }
    },
    mounted() {
        this.loadRescources(this.currentPage);
        this.selectedType = 'text';
    },

    methods: {
        loadRescources(page = 1) {
            axios
                .get(`/rescources/admin-datos-TEXT?page=${page}`)
                .then((response) => {
                    this.rescources = response.data.data;
                    this.currentPage = page;
                })
                .catch((error) => {
                    console.log(error);
                });
            axios
                .get('/allCategories')
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        changePage(page) {
            this.loadRescources(page);
        },

        sortTable() {
            let url = '';
            switch (this.selectedType) {
                case 'text':
                    url = '/rescources/admin-datos-TEXT';
                    break;
                case 'URL':
                    url = '/rescources/admin-datos-URL';
                    break;
                case 'file':
                    url = '/rescources/admin-datos-FILE';
                    break;
            }
            axios.get(url)
                .then(response => {
                    this.rescources = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        saveResourceText() {
            axios.post('/CreateResourceText', {
                name: this.name,
                description: this.description,
                selectedCategory: this.selectedCategory
            })
                .then(async response => {

                    this.name = '';
                    this.description = '';
                    this.modal_crear_recurs_text = false;
                    this.selectedCategory = '';
                    console.log("Merequetengue");
                })
                .catch(error => {

                    console.log(error.response)
                })
        },

        saveResourceURL() {
            axios.post('/CreateResourceURL', {
                name: this.name,
                locate: this.locate,
                selectedCategory: this.selectedCategory
            })
                .then(async response => {

                    this.name = '';
                    this.locate = '';
                    this.modal_crear_recurs_url = false;
                    this.selectedCategory = '';
                    console.log("Merequetengue");
                })
                .catch(error => {

                    console.log(error.response)
                })

        },

        saveResourceFile() {
            axios.post('/CreateResourceFile', {
                name: this.name,
                locate: this.locate,
                selectedCategory: this.selectedCategory
            })
                .then(async response => {

                    this.name = '';
                    this.locate = '';
                    this.modal_crear_recurs_arxiu = false;
                    this.selectedCategory = '';
                    console.log("Merequetengue");
                })
                .catch(error => {

                    console.log(error.response)
                })

        },

        openModal(rescource) {
            if (rescource.type === 'text') {
                this.ModalEditRescourceText(rescource);
            } else if (rescource.type === 'url' || rescource.type === 'file') {
                this.ModalEditRescourceURL_FILE(rescource);
            } else {
                // handle error or do nothing if type is not recognized
            }
        },

        ModalEditRescourceText(rescource) {
            this.modal_editar_recurs_text = true;
            this.selectedRescource = rescource.name;
            this.description = rescource.description;
            this.selectedCategory = rescource.category_id;
            this.id = rescource.id;

        },

        ModalEditRescourceURL_FILE(rescource) {
            this.modal_editar_recurs_URL_FILE = true;
            this.selectedRescource = rescource.name;
            this.location = rescource.location;
            this.selectedCategory = rescource.category_id;
            this.type = rescource.type;
            this.id = rescource.id;

        },

        closeModalEdit() {
            this.modal_editar_recurs_text = false;
            this.modal_editar_recurs_URL_FILE = false;
            this.selectedRescource = '';
            this.description = '';
            this.locate = '';
            this.selectedCategory = null;
            this.id = null;
        },

        updateResourceText() {
            axios.put('/resource/text/' + this.id + '/edit', {
                name_edit: this.selectedRescource,
                description_edit: this.description,
                selectedCategory: this.selectedCategory
            })
                .then(response => {
                    this.selectedRescource = '';
                    this.selectedCategory = response.data.categories;

                    this.modal_editar_recurs_text = false;
                })
                .catch(error => {
                    console.log(error.response)
                });
        },


        updateResourceURL_FILE() {
            axios.put('/resource/' + this.type + '/' + this.id + '/edit', {
                name_edit: this.selectedRescource,
                location_edit: this.location,
                selectedCategory: this.selectedCategory
            })
                .then(response => {
                    this.selectedRescource = '';
                    this.location = '';
                    this.selectedCategory = response.data.categories;
                    this.modal_editar_recurs_URL_FILE = false;
                })
                .catch(error => {
                    console.log(error.response)
                });

        },

        ModalEliminarRecurs(rescource) {
            this.modal_eliminar_recurs = true;
            this.id = rescource.id;
            this.type = rescource.type;
            this.selectedRescource = rescource.name;
            console.log(rescource);
        },

        deleteResource() {
            axios.post('/resource/' + this.type + '/' + this.id + '/delete', {})
                .then(async response => {
                    this.id = '';
                    this.modal_eliminar_recurs = false;
                    // Agrega aquí el cierre del modal
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        redirectToCourses() {
            window.location.href = "/course";
        },
        redirectToCategories() {
            window.location.href = "/course/categories";
        }
    },

    computed: {
        filteredRescources() {
            const searchTermLower = this.searchTerm.toLowerCase();
            return this.rescources.filter(rescource => {
                return rescource.name.toLowerCase().includes(searchTermLower);
            });
        }
    },
}


</script>


<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    AcademicCapIcon,
    PlusIcon,
    TrashIcon,
    PencilSquareIcon,
    ArrowLeftCircleIcon,
} from '@heroicons/vue/24/outline'
</script>
