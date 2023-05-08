<template>
    <div class="p-5">
        <h1 class="p-3 text-center font-medium">{{ $t('budget.budget-list-title') }}</h1>
        <table class="table-auto w-full shadow-lg rounded-lg p-4 overflow-hidden">
            <thead class0="rounded-t-lg">
                <tr class="bg-orange-400 text-white">
                    <th class="px-6 py-3 uppercase">{{ $t('budget.client-name') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('budget.client-surname') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('budget.company-name') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('budget.creation-date') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('budget.updated-date') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('budget.status') }}</th>
                </tr>
            </thead>
            <tbody v-if="budgetToColumns != 0">
                <tr v-for="result in budgetToColumns" :key="result.id" class="bg-orange-50 hover:bg-orange-100 text-center">
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ result.name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ result.last_name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ result.company_name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ formatDate(result.updated_at) }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ result.status }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900"><a :href="'Asignar-Precios/' + result.id" class="text-base font-medium bg-blue-500 hover:bg-blue-400 text-white py-2 px-4 rounded-full transition-colors duration-300">{{ $t('budget.price') }}</a></p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else class="p-2.5 font-medium items-center">
                <div class="m-2">
                    {{ $t('no-results') }}
                </div>
            </tbody>
        </table>
    </div>

</template>
<script>
import { format } from 'date-fns';

export default {
    mounted() {
        this.getBudgets();
    },

    data() {
        return {
            budgetToColumns: [],
        }
    },

    methods: {
        async getBudgets() {
            try {
                const response = await this.$axios.get('/show_budgets_admin/list_all_budgets')
                this.budgetToColumns = response.data
            } catch (error) {
                console.error(error)
            }
        },

        /** Método que formatea la fecha */
        formatDate(date) {
            return format(new Date(date), this.$t('date-format'));
        }
    },
}

</script>
