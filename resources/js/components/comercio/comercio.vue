<template>
    <div class="flex justify-center items-start h-screen">
        <div class="bg-teal-400 rounded-lg p-8 mt-10">
            <h1 class="font-bold text-white text-3xl mb-6">Operaciones de Trading</h1>
            <form @submit.prevent="submitForm">
                <div class="mb-6">
                    <label for="amount" class="font-bold text-white">Cantidad:</label>
                    <div class="flex items-center">
                        <input v-model="amount" type="number" id="amount" name="amount"
                            class="border rounded-md px-2 py-1 mr-2" :class="{ 'border-red-500': errorField === 'amount' }"
                            @input="clearError('amount')" />
                        <button type="button" @click="setMaximumAmount"
                            class="font-bold bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800">
                            MAX
                        </button>
                    </div>
                    <div v-if="error && errorField === 'amount'" class="text-red-500 mt-1">{{ error }}</div>
                </div>
                <div class="mb-6">
                    <label for="duration" class="font-bold text-white">Duración:</label>
                    <select v-model="duration" id="duration" name="duration" class="ml-3 border rounded-md px-2 py-1 w-32"
                        :class="{ 'border-red-500': errorField === 'duration' }" @change="clearError('duration')">
                        <option value="2">2 horas</option>
                        <option value="8">8 horas</option>
                        <option value="16">16 horas</option>
                        <option value="24">24 horas</option>
                    </select>
                    <div v-if="error && errorField === 'duration'" class="text-red-500 mt-1">{{ error }}</div>
                </div>
                <div class="mb-6">
                    <label for="robot" class="font-bold text-white">Robot:</label>
                    <input v-model="robot" type="text" id="robot" name="robot" class="ml-3 border rounded-md px-2 py-1"
                        :class="{ 'border-red-500': errorField === 'robot' }" @input="clearError('robot')" />
                    <div v-if="error && errorField === 'robot'" class="text-red-500 mt-1">{{ error }}</div>
                </div>
                <button type="submit" class="font-bold bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Enviar
                </button>
                <div v-if="error && errorField === 'submit'" class="text-red-500 mt-2">{{ error }}</div>
            </form>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';
import TronWeb from 'tronweb';
import { Buffer } from 'buffer';

window.Buffer = Buffer;

export default {
    data() {
        return {
            user: {},
            error: '',
            errorField: '',
            accountBalance: 0,
            private_key: '',
            amount: '',
            duration: '',
            robot: '',
        };
    },
    mounted() {
        axios.get('/User-info').then((response) => {
            this.user = response.data;
            this.private_key = this.user.private_key;
            this.direccion = this.user.direccion;
            this.initialize();
        });
    },
    methods: {
        initialize() {
            const direccion_usdt = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';
            const tronWeb = new TronWeb({
                fullNode: 'https://api.trongrid.io',
                solidityNode: 'https://api.trongrid.io',
                eventServer: 'https://api.trongrid.io',
                privateKey: this.private_key,
            });

            const url = 'https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=usd';

            const obtenerSaldo = async () => {
                const contractInstance = await tronWeb.contract().at(direccion_usdt);
                const balanceInSun = await contractInstance.balanceOf(this.direccion).call();
                const balanceInUSDT = balanceInSun / 1000000;

                const response = await fetch(url);
                const data = await response.json();
                const usdRate = data.tether.usd;
                const balanceInUSD = balanceInUSDT * usdRate;

                this.accountBalance = balanceInUSD.toFixed(2);
            };

            obtenerSaldo();
        },
        setMaximumAmount() {
            this.amount = parseInt(this.accountBalance);
            this.clearError('amount');
        },
        submitForm() {
            if (!this.amount || this.amount === '') {
                this.error = 'Por favor, introduzca una cantidad';
                this.errorField = 'amount';
                return;
            }

            if (parseInt(this.amount) < 10) {
                this.error = 'La cantidad debe ser de mínimo 10 o superior';
                this.errorField = 'amount';
                return;
            }

            if (!this.duration || this.duration === '') {
                this.error = 'Por favor, introduzca la duración';
                this.errorField = 'duration';
                return;
            }

            if (!this.robot || this.robot === '') {
                this.error = 'Por favor, seleccione su robot';
                this.errorField = 'robot';
                return;
            }

            if (parseInt(this.amount) > this.accountBalance) {
                this.error = 'Saldo insuficiente';
                this.errorField = 'amount';
                return;
            }

            // Crear un objeto con los datos del formulario
            const formData = {
                userId: this.user.id,
                walletAmount: this.amount,
                duration: this.duration,
                publicKey: this.user.public_key,
                privateKey: this.private_key,
                walletAddress: this.direccion,
            };

            axios
                .post('/quantitative-trading', formData)
                .then((response) => {
                    console.log(response.data);
                    // ...
                })
                .catch((error) => {
                    console.error(error);
                });


            // Si todo está bien, puedes limpiar el mensaje de error
            this.error = '';
            this.errorField = '';
        },
        clearError(field) {
            if (field === this.errorField) {
                this.error = '';
                this.errorField = '';
            }
        },
    },
};
</script>
  