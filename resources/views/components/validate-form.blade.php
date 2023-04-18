<script>
    function validateEmail() {
        const emailInput = document.getElementById("email-address");
        const emailError = document.getElementById("email-error");

        // Expresión regular para validar correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(emailInput.value)) {
            // Si el correo electrónico no es válido, muestra un mensaje de error
            emailError.textContent = "{{ __('validation.email') }}";
            emailError.classList.remove("hidden");
            emailInput.classList.add("border-red-500");
            emailInput.classList.remove("border-green-500");
        } else {
            // Si el correo electrónico es válido, oculta el mensaje de error
            emailError.classList.add("hidden");
            emailInput.classList.remove("border-red-500");
            emailInput.classList.add("border-green-500");
        }
    }

    function validatePassword() {
        const passwordInput = document.getElementById("password");

        if (passwordInput.value.trim() === "") {
            passwordInput.classList.add("border-red-500");
            passwordInput.classList.remove("border-green-500");
        } else {
            passwordInput.classList.remove("border-red-500");
            passwordInput.classList.add("border-green-500");
        }
    }

    document.getElementById("password").addEventListener("blur", validatePassword);
</script>