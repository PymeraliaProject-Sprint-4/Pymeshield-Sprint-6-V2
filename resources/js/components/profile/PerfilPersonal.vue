<template>
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 left-table">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center ">
                                <img v-if="user.profile_image" :src="`/img/profile_images/${user.profile_image}`"
                                    alt="imagen_del_usuario" class="mb-3 rounded-full w-48 h-48 ml-9" id="block">
                                <img v-else src="/img/default_profile.png" alt="imagen_del_usuario"
                                    class="mb-3 rounded-full w-48 h-48" id="block">
                                <h4 id="block1" class="text-2xl font-bold">
                                    {{ user.name }} {{ user.last_name }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 right-table">
                    <h3 class="mt-5 font-bold" style="text-align: center;">{{ $t('personal-info') }}</h3>
                    <table class="table table-striped p-6">

                        <tbody>
                            <tr>
                                <td>{{ $t('name') }}</td>
                                <td>{{ user.name }}</td>
                            </tr>
                            <tr>
                                <td>{{ $t('lastname') }}</td>
                                <td>{{ user.last_name }}</td>
                            </tr>
                            <tr>
                                <td>{{ $t('username') }}</td>
                                <td>{{ user.nick_name }}</td>
                            </tr>
                            <tr>
                                <td>{{ $t('email') }}</td>
                                <td>{{ user.email }}</td>
                            </tr>
                            <tr>
                                <td>{{ $t('phone') }}</td>
                                <td>{{ user.phone }}</td>
                            </tr>
                            <tr>
                                <td>{{ $t('company') }}</td>
                                <td>{{ user.company_name }}</td>
                            </tr>
                        </tbody>

                    </table>

                    <a href="/Perfil_Personal/Editar_Perfil">
                        <button
                            class="bg-orange-400 hover:bg-orange-600 text-black font-medium py-2 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mx-2 mt-3">
                            <i class="fas fa-edit mr-2"></i> {{ $t('edit-profile') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5">
        <h1 class="p-3 text-center font-medium">{{ $t('Emblems') }}</h1>
        <table class="table-auto w-full shadow-lg rounded-lg p-4 overflow-hidden">
            <thead class0="rounded-t-lg">
                <tr class="bg-orange-400 text-white table-emblem">
                    <th class="px-6 py-3 uppercase">{{ $t('description') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('Emblems') }}</th>
                </tr>
            </thead>
            <tbody v-if="emblems != 0">
                <tr v-for="emblem in emblems" :key="emblem.id" class="bg-orange-50 hover:bg-orange-100 text-center">
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ emblem.emblem_name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center flex align-middle justify-center">
                        <img class="h-12" :src=emblem.image />
                    </td>
                </tr>
            </tbody>
            <tbody v-else class="p-2.5 font-medium items-center">
                <div class="m-2">
                    {{ $t('emblem.no-emblem') }}
                </div>
            </tbody>
        </table>
    </div><!-- tabla emblemas -->
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {},
            emblems: {},
        };
    },
    mounted() {
        axios.get('/user-info').then(response => {
            this.user = response.data.userInfo;
            this.emblems = response.data.userEmblem;
        });
    },
};
</script>

<style scoped>
.left-table {
    float: left;
    margin-left: 80px;
    margin-top: 40px;
    text-align: center;
}

.right-table {
    float: right;
    margin-right: 100px;
    margin-bottom: 20px;
}

.container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-body {
    width: 80%;
    height: 100%;
    margin: 0 auto;
}

.img-fluid {
    max-width: 200px;
    height: auto;
    border-radius: 50%;
}

.table-emblem {
    background-color: rgb(251 146 60) !important;
}

td {
    padding: 7px;
}

table {
    font-size: 16px;
    border: 1px solid black;
    width: 100%;
    height: 70%;
}

h4 {
    /*donarli forma al text del nom i cognom on esta la imatge*/
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

td:first-child {
    padding-right: 20px;
}

td:last-child {
    padding-left: 20px;
}

tr:nth-child(odd) {
    /*Ficar color a les linies inpars*/
    background-color: lightgray;
}

tr:nth-child(even) {
    /*Ficar color a les linies pars*/
    background-color: white;
}
</style>
