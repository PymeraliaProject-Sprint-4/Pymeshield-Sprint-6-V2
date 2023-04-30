@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3 left-table">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($authenticatedUser->profile_image)
                                    <img src="{{ asset('img/profile_images/' . $authenticatedUser->profile_image) }}"
                                        alt="imagen_del_usuario" class="mb-3 rounded-full w-48 h-48 ml-6" id="block">
                                @else
                                    <img src="{{ asset('img/default_profile.png') }}" alt="imagen_del_usuario"
                                        class="mb-3 rounded-full w-48 h-48" id="block">
                                @endif
                                <h4 id="block1" class="text-2xl font-bold ">
                                    {{ $authenticatedUser->name }} {{ $authenticatedUser->last_name }}
                                </h4>

                                <form action="{{ route('updateProfileImage') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <!-- Botón para abrir el modal -->
                                        <button type="button"
                                            class="bg-orange-400 hover:bg-orange-600 text-black font-medium py-2 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mx-2 mt-3"
                                            onclick="openModal()">
                                            <i class="fas fa-images mr-2"></i>{{ __('image-changes') }}
                                        </button>

                                        <!-- Contenedor del modal -->
                                        <div id="modal1" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden">
                                            <div
                                                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-6 bg-white rounded-lg">
                                                <!-- Formulario para cambiar la imagen del usuario -->
                                                <form action="{{ route('updateProfileImage') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <label for="profile_image" class="block font-medium mb-2 "><i
                                                            class="fas fa-images mr-2"></i>{{ __('select-image') }}</label>
                                                    <input type="file" name="profile_image" id="profile_image"
                                                        class="mb-4">
                                                    <div class="flex justify-end">

                                                        <button type="submit"
                                                            class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center">
                                                            <i class="far fa-save mr-2"></i>{{ __('save') }}
                                                        </button>
                                                        <button type="button"
                                                            class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                                            onclick="closeModal()">
                                                            <i class="fas fa-times mr-2"></i>{{ __('cancel') }}
                                                        </button>
                                                        <button type="button" onclick="confirmDelete()"
                                                            class="bg-red-600 hover:bg-red-800 text-white  font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mx-2 mt-1 ml-4 flex items-center">
                                                            <i class="far fa-trash-alt mr-2"></i>
                                                            <span class="ml-2">{{ __('delete') }}</span>
                                                        </button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Capa de fondo para cerrar el modal -->
                                        <div id="modal-background"
                                            class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 hidden">
                                        </div>

                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 right-table">
                <h3 class="mt-5 font-bold right-table1" style="text-align: center;">{{ __('personal-info') }}

                </h3>

                <form method="POST" action="{{ route('profile.update') }}" novalidate>
                    @csrf
                    <table class="table table-striped p-6">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ __('name') }}</td>
                                <td>
                                    <input name="name" type="text" value="{{ $authenticatedUser->name }}"
                                        maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lastname') }}</td>
                                <td>
                                    <input name="last_name" type="text" value="{{ $authenticatedUser->last_name }}"
                                        maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('username') }}</td>
                                <td>
                                    <input name="nick_name" type="text" value="{{ $authenticatedUser->nick_name }}"
                                        maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('email') }}</td>
                                <td>
                                    <input name="email" type="text" value="{{ $authenticatedUser->email }}"
                                        maxlength="40" />
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('phone') }}</td>
                                <td>
                                    <input name="phone" type="text" value="{{ $authenticatedUser->phone }}"
                                        maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('company-name') }}</td>
                                <td>{{ $authenticatedUser->company_name }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- py-2 es per a donarli el grosor del boton
                                                                              px-4 es per a donarli la llargada del boton-->
                    <div>
                        <button type="submit"
                            class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-10"
                            style="margin-top: 20px;"> <i class="far fa-save mr-2"></i>
                            {{ __('save-changes') }}
                        </button>
                </form>
                <!-- Botón para abrir el modal -->

                <button type="button"
                    class="bg-orange-400 hover:bg-orange-600 text-black font-medium py-2 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110  mx-2 mt-3 "
                    onclick="openModal1()" style="margin-top: 20px;"><i class="fas fa-edit mr-2"></i>
                    {{ __('change-password') }}
                </button>

                <button type="button"
                    class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-2 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110  mx-2 mt-3"
                    onclick="window.history.back()">
                    <i class="fas fa-times mr-2"></i>{{ __('cancel') }}
                </button>
            </div>

            <!-- Contenedor del modal de cambiar contraseña -->
            <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden">
                <div class="flex items-center justify-center h-full">
                    <div class="bg-white rounded-lg w-full max-w-md p-6">
                        <h2 class="text-lg font-bold mb-3"><i class="fas fa-edit mr-2 "></i>{{ __('change-password') }}
                        </h2>
                        <form action="{{ route('changePassword') }}" method="POST" id="change-password-form">
                            @csrf
                            <div class="mb-4">
                                <div class="mb-4 relative">
                                    <label for="current_password"
                                        class="block text-gray-700 font-bold mb-2">{{ __('password') }}</label>
                                    <div class="relative">
                                        <input type="password" id="actualPassword" name="current_password"
                                            class="w-full border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                            required autocomplete="off">
                                        <button type="button" class="absolute right-0 top-0 mt-2 mr-2"
                                            onclick="togglePasswordVisibility('actualPassword')">
                                            <i id="current_password_toggle" class="far fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-4">
                                <label for="new_password"
                                    class="block text-gray-700 font-bold mb-2">{{ __('new-password') }}</label>
                                <div class="relative">
                                    <input type="password" id="newPassword" name="new_password"
                                        class="w-full border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required autocomplete="off">
                                    <button type="button" class="absolute right-0 top-0 mt-2 mr-2"
                                        onclick="togglePasswordVisibility('newPassword')">
                                        <i id="new_password_toggle" class="far fa-eye-slash"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="mb-4">
                                <label for="confirm_password"
                                    class="block text-gray-700 font-bold mb-2">{{ __('confirm-new-password') }}</label>
                                <div class="relative">
                                    <input type="password" id="confirmPassword" name="confirm_password"
                                        class="w-full border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required autocomplete="off">
                                    <button type="button" class="absolute right-0 top-0 mt-2 mr-2"
                                        onclick="togglePasswordVisibility('confirmPassword')">
                                        <i id="confirm_password_toggle" class="far fa-eye-slash"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="flex items-center justify-between">
                                <button type="button"
                                    class="bg-orange-500 hover:bg-white text-black font-medium py-1 px-2 mr-1 rounded-lg border-2 border-black transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block"
                                    onclick="submitFormIfValid()">
                                    <i class="far fa-save mr-2"></i>{{ __('save') }}
                                </button>

                                <button type="button"
                                    class="bg-gray-400 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg border-2 border-black transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4"
                                    onclick="closeModal1()">
                                    <i class="fas fa-times mr-2"></i>{{ __('cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Capa de fondo para cerrar el modal -->
            <div id="modal-background1" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 hidden"></div>

            <script>
                function openModal() {
                    document.getElementById('modal1').classList.remove('hidden');
                    document.getElementById('modal-background').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('modal1').classList.add('hidden');
                    document.getElementById('modal-background').classList.add('hidden');
                }
                // Cerrar el modal cuando se hace clic en la capa de fondo
                document.getElementById('modal-background').addEventListener('click', closeModal);

                function confirmDelete() {
                    if (confirm('¿Estás seguro de que deseas eliminar tu imagen de perfil?')) {
                        // Crea una instancia de XMLHttpRequest o usa fetch
                        var xhr = new XMLHttpRequest();
                        window.location.reload();

                        // Configura la solicitud
                        xhr.open('POST', '/delete-profile-image');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        window.location.reload();

                        // Define la función que se ejecutará cuando se complete la solicitud
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var data = JSON.parse(xhr.responseText);
                                if (data.success) {
                                    // Mostrar un mensaje de éxito
                                    alert(data.success);
                                }
                            } else {
                                console.log(xhr.statusText);
                            }
                        };

                        // Envía la solicitud
                        xhr.send();
                    }
                }

                function openModal1() {
                    document.getElementById('modal').classList.remove('hidden');
                    document.getElementById('modal-background1').classList.remove('hidden');
                }


                function closeModal1() {
                    document.getElementById('modal').classList.add('hidden');
                    document.getElementById('modal-background1').classList.add('hidden');
                }

                // Cerrar el modal cuando se hace clic en la capa de fondo
                document.getElementById('modal-background1').addEventListener('click', closeModal1);

                function togglePasswordVisibility(inputId) {
                    const input = document.getElementById(inputId);
                    const toggle = input.nextSibling.querySelector("i");
                    if (input.type === "password") {
                        input.type = "text";
                        toggle.classList.remove("fa-eye-slash");
                        toggle.classList.add("fa-eye");
                    } else {
                        input.type = "password";
                        toggle.classList.remove("fa-eye");
                        toggle.classList.add("fa-eye-slash");
                    }
                }

                function validatePassword(password) {
                    const currentPassword = document.getElementById('actualPassword').value;
                    const newPassword = document.getElementById('newPassword').value;
                    const confirmNewPassword = document.getElementById('confirmPassword').value;

                    // Validaciones
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    if (newPassword !== confirmNewPassword) {
                        alert('Las contraseñas no coinciden');
                        return false;
                    } else if (!passwordRegex.test(newPassword)) {
                        alert(
                            'La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un numero y un caracter especial'
                        );
                        return false;
                    }
                    return true;
                }

                function submitFormIfValid() {
                    if (validatePassword()) {
                        document.getElementById('change-password-form').submit();
                    }
                }
            </script>
        </div>
    </div>
    </div>
    </div>
    <style>
        #block1 {
            margin-right: 0px;

        }

        .left-table {
            float: left;
            margin-left: 50px;
            margin-top: 40px;
            text-align: center;
        }

        .right-table {
            float: right;
            margin-bottom: 20px;
        }

        .right-table1 {
            float: right;
            margin-bottom: 5px;
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

        td {
            padding: 7px;
        }

        table {
            border: 1px solid black;
            width: 100%;
            height: 70%;
            border-collapse: separate;
            border-spacing: 10px;
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
@endsection

