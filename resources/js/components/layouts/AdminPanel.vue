<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog as="div" class="relative z-40 lg:hidden" @close="sidebarOpen = false">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
            </TransitionChild>

            <div class="fixed inset-0 z-40 flex">
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full" enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                    leave-to="-translate-x-full">
                    <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-orange-500 pt-5 pb-4">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                            enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button"
                                    class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                    @click="sidebarOpen = false">
                                    <span class="sr-only">{{ $t('close-sidebar') }}</span>
                                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>
                            </div>
                        </TransitionChild>
                        <div class="flex flex-shrink-0 items-center px-4">
                            <ShieldExclamationIcon class="h-6 w-6 text-black mr-3" aria-hidden="true" />PymeShield
                        </div>
                        <nav class="mt-5 h-full flex-shrink-0 divide-y divide-orange-700 overflow-y-auto custom-scrollbar"
                            aria-label="Sidebar">
                            <div class="space-y-1 px-2">
                                <a v-for="item in filteredNavigation" :key="item.name" :href="item.href"
                                    :class="[item.current ? 'bg-orange-700 text-white' : 'text-orange-100 hover:text-white hover:bg-orange-400', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']"
                                    :aria-current="item.current ? 'page' : undefined">
                                    <component :is="item.icon" class="mr-4 h-6 w-6 flex-shrink-0 text-orange-200"
                                        aria-hidden="true" />
                                    {{ item.name }}
                                </a>
                            </div>
                            <div v-if="can('dashadmin.config')" class="mt-6 pt-6">
                                <div class="mt-6 pt-6">
                                    <div class="space-y-1 px-2">
                                        <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href"
                                            :class="[item.current ? 'bg-orange-700 text-white' : 'text-orange-100 hover:text-white hover:bg-orange-400', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']"
                                            :aria-current="item.current ? 'page' : undefined">
                                            <component :is="item.icon" class="mr-4 h-6 w-6 text-orange-200"
                                                aria-hidden="true" />
                                            {{ item.name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </DialogPanel>
                </TransitionChild>
                <div class="w-14 flex-shrink-0" aria-hidden="true">
                    <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex flex-grow flex-col overflow-y-auto bg-orange-500 pt-5 pb-4">
            <div class="flex flex-shrink-0 items-center px-4">
                <a href="/admin"><img class="inline-block mr-3 w-12" src="/img/logo_pymeshield.png"
                        alt="Logo">PymeShield</a>
            </div>
            <nav class="mt-5 flex flex-1 flex-col divide-y divide-orange-800 overflow-y-auto custom-scrollbar"
                aria-label="Sidebar">
                <div class="space-y-1 px-2">
                    <a v-for="item in filteredNavigation" :key="item.name" :href="item.href"
                        :class="[item.current ? 'bg-orange-700 text-white' : 'text-orange-100 hover:text-white hover:bg-orange-400', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']"
                        :aria-current="item.current ? 'page' : undefined">
                        <component :is="item.icon" class="mr-4 h-6 w-6 flex-shrink-0 text-orange-200" aria-hidden="true" />
                        {{ item.name }}
                    </a>
                </div>
                <div v-if="can('dashadmin.config')" class="mt-6 pt-6">
                    <div class="space-y-1 px-2">
                        <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href"
                            :class="[item.current ? 'bg-orange-700 text-white' : 'text-orange-100 hover:text-white hover:bg-orange-400', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']"
                            :aria-current="item.current ? 'page' : undefined">
                            <component :is="item.icon" class="mr-4 h-6 w-6 text-orange-200" aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="flex flex-1 flex-col lg:pl-64">
        <div class="flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:border-none">
            <button type="button"
                class="border-r border-gray-200 px-4 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500 lg:hidden"
                @click="sidebarOpen = true">
                <span class="sr-only">{{ $t('open-sidebar') }}</span>
                <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true" />
            </button>
            <!-- Search bar -->
            <div class="flex flex-1 justify-between px-4 sm:px-6 lg:mx-auto lg:max-w-6xl lg:px-8">
                <div class="flex flex-1">
                    <form class="flex w-full md:ml-0" action="#" method="GET">
                        <label for="search-field" class="sr-only">{{ $t('search') }}</label>
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center" aria-hidden="true">
                                <MagnifyingGlassIcon class="h-5 w-5" aria-hidden="true" />
                            </div>
                            <input id="search-field" name="search-field"
                                class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
                                :placeholder="$t('search')" type="search" />
                        </div>
                    </form>
                </div>
                <div class="ml-4 flex items-center md:ml-6">


                    <Menu as="div" class="relative ml-3">
                        <div>
                            <MenuButton
                                class="rounded-full bg-gray-200 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">Abrir menú de usuario</span>
                                <LanguageIcon class="h-8 w-8 text-blue-500" aria-hidden="true" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-for="item in languaje" :key="languaje.name" v-slot="{ active }">
                                <a :href="item.href"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                    <img :src="item.flag" class="inline-block mr-2 h-5 w-5 object-cover rounded-full"
                                        aria-hidden="true" />{{
                                            item.name
                                        }}</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>

                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative ml-3">
                        <div>
                            <MenuButton
                                class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 lg:rounded-md lg:p-2 lg:hover:bg-gray-50">
                                <vue-avatar v-if="!user.profile_image" :size="40" :username="user.name + user.last_name" />
                                <vue-avatar v-else :size="40" :img-src="'/img/profile_images/' + user.profile_image" />
                                <ChevronDownIcon class="ml-1 hidden h-5 w-5 flex-shrink-0 text-gray-400 lg:block"
                                    aria-hidden="true" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-for="item in adminNavigation" :key="item.name" v-slot="{ active }">
                                <a :href="item.href" :target="item.target"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                    <component :is="item.icon" class="inline-block mr-1 h-5 w-5" aria-hidden="true" />{{
                                        item.name
                                    }}
                                </a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>
        <!-- Page header -->
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:mx-auto lg:max-w-6xl lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="min-w-0 flex-1">

                        <!-- Profile -->
                        <div class="flex items-center">
                            <vue-avatar v-if="!user.profile_image" :size="60" :username="user.name + user.last_name" />
                            <vue-avatar v-else :size="60" :img-src="'/img/profile_images/' + user.profile_image" />
                            <div>
                                <div class="flex items-center">
                                    <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:leading-9">
                                        {{ user.name + ' ' + user.last_name }}</h1>
                                </div>
                                <dl class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap">
                                    <dt class="sr-only">{{ $t('company') }}</dt>
                                    <dd class="flex items-center text-sm font-medium capitalize text-gray-500 sm:mr-6">
                                        <UserGroupIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                            aria-hidden="true" />
                                        {{ user.type }}
                                    </dd>
                                    <dt class="sr-only">{{ $t('account-status') }}</dt>
                                    <dd
                                        class="mt-3 flex items-center text-sm font-medium capitalize text-gray-500 sm:mr-6 sm:mt-0">
                                        <CheckCircleIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-green-400"
                                            aria-hidden="true" />
                                        {{ $t('verified-account') }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3CenterLeftIcon,
    CogIcon,
    HomeIcon,
    LockClosedIcon,
    QuestionMarkCircleIcon,
    ShieldCheckIcon,
    ShieldExclamationIcon,
    UserGroupIcon,
    XMarkIcon,
    IdentificationIcon,
    WrenchScrewdriverIcon,
    ArrowLeftOnRectangleIcon,
    LanguageIcon,
    UserCircleIcon,
    ClipboardIcon,
    LifebuoyIcon,
DocumentMagnifyingGlassIcon,
FingerPrintIcon,
} from '@heroicons/vue/24/outline'
import {
    AcademicCapIcon, CurrencyEuroIcon, QrCodeIcon, BriefcaseIcon, UserIcon,
    CheckCircleIcon,
    ChevronDownIcon,
    MagnifyingGlassIcon,
    ArrowUpTrayIcon,
    StarIcon,
    QueueListIcon,
} from '@heroicons/vue/20/solid'
import VueAvatar from "@webzlodimir/vue-avatar";
import "@webzlodimir/vue-avatar/dist/style.css";

const sidebarOpen = ref(false)
</script>
<script>
export default {
    data() {
        return {
            user: window.authUser,
            navigation: [
                { name: this.$t('home'), href: '/admin', current: false, icon: HomeIcon, },
                { name: this.$t('surveys'), href: '/questionnaire', current: false, icon: QueueListIcon },
                { name: this.$t('navbar.questions'), href: '/question', current: false, icon: QuestionMarkCircleIcon },
                { name: this.$t('Courses'), href: '/course', current: false, icon: AcademicCapIcon },
                { name: this.$t('QualifyCourse'), href: '/CursosCalificar', current: false, icon: ClipboardIcon },
                { name: this.$t('Emblems'), href: '/emblems', current: false, icon: StarIcon },
                { name: this.$t('budgets'), href: '/show_budgets_admin', current: false, icon: CurrencyEuroIcon },
                { name: this.$t('users'), href: '/userList', current: false, icon: UserIcon },
                { name: this.$t('companies'), href: '/llistatEmpreses', current: false, icon: BriefcaseIcon, role: 'admin' },
                { name: this.$t('inventory'), href: '/devices', current: false, icon: QrCodeIcon },
                { name: this.$t('navbar.restore'), href: '/restore', current: false, icon: ArrowUpTrayIcon },
            ],
            secondaryNavigation: [
                { name: this.$t('logs'), href: "/logs", current: false, icon: FingerPrintIcon },
                { name: this.$t('edit-terms'), href: "/edit_terms", current: false, icon: CogIcon },
                { name: this.$t('edit-privacy'), href: "/edit_privacy", current: false, icon: QuestionMarkCircleIcon },
                { name: this.$t('edit-cookies'), href: "/edit_cookies", current: false, icon: ShieldCheckIcon },
            ],
        };
    },
    computed: {
        permissionCompanies() {
            return this.can('dashadmin.companies');
        },
        filteredNavigation() {
            return this.navigation.filter(item => {
                // Mostrar empresa si tiene el permiso
                if (item.role === 'admin') {
                    return this.permissionCompanies;
                }
                else {
                    return true;
                }
            });
        },
        adminNavigation() {
            if (this.user.type === 'admin') {
                return [
                    { name: this.$t('profile'), href: '/PerfilPersonal_Admin', icon: IdentificationIcon },
                    { name: this.$t('help'), href: '/manuals/manual_admin.pdf', target: '_blank', icon: LifebuoyIcon },
                    { name: this.$t('client-mode'), href: '/home', icon: UserCircleIcon },
                    { name: this.$t('sign-out'), href: '/logout', icon: ArrowLeftOnRectangleIcon },
                ];
            } else {
                return [
                    { name: this.$t('profile'), href: '#', icon: IdentificationIcon },
                    { name: this.$t('help'), href: '/manuals/manual_admin.pdf', target: '_blank', icon: LifebuoyIcon },
                    { name: this.$t('sign-out'), href: '/logout', icon: WrenchScrewdriverIcon },
                ];
            }
        },
        languaje() {
            return [
                { name: this.$t('english'), href: '/language/en', flag: '/img/english.svg' },
                { name: this.$t('spanish'), href: '/language/es', flag: '/img/spanish.svg' },
                { name: this.$t('catalan'), href: '/language/ca', flag: '/img/catalan.svg' },
            ];

        }
    },
    components: { LockClosedIcon, ShieldExclamationIcon },
    mounted() {
        const currentUrl = window.location.pathname;
        const firstPathSegment = currentUrl.split('/')[1];
        this.navigation.forEach((item) => {
            const itemFirstPathSegment = item.href.split('/')[1];
            if (firstPathSegment === itemFirstPathSegment) {
                item.current = true;
            }
        });
        this.secondaryNavigation.forEach((item) => {
            if (currentUrl.startsWith(item.href)) {
                item.current = true;
            }
        });
    },
}
</script>
