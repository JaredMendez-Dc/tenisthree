<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);
import { ref } from 'vue';

const props = defineProps({
    clientes: { type: Object }, // Cambiado de authors a clientes
    tenis: { type: Number },    // Cambiado de books a tenis
    countries: { type: Object } // Este permanece igual
});

const cli = ref([]); // Cambiado de aut
const cou = ref([]);
const chartData1 = ref([]);
const charOptions1 = ref([]);
const chartData2 = ref([]);
const charOptions2 = ref([]);
const cli2 = ref([]); // Cambiado de aut2
const ten = ref([]);  // Cambiado de boo
const colors = ref([]);

// Generar colores aleatorios
const random = () => {
    return Math.floor(Math.random() * 256);
};

// Gráfico 1: Clientes por país
props.countries.map((row) => (
    cou.value.push(row.country),
    cli.value.push(row.clientes.length), // Cambiado authors a clientes
    colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
));
charOptions1.value = { responsive: true };
chartData1.value = {
    labels: cou.value,
    datasets: [{
        label: 'Clientes',
        data: cli.value,
        backgroundColor: colors
    }]
};

// Gráfico 2: Tenis por cliente
props.clientes.map((row) => (
    ten.value.push(row.tenis.length), // Cambiado books a tenis
    cli2.value.push(row.last_name + ' ' + row.name),
    colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
));
charOptions2.value = { responsive: true };
chartData2.value = {
    labels: cli2.value,
    datasets: [{
        label: 'Tenis',
        data: ten.value,
        backgroundColor: colors
    }]
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>
        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card: Total Clientes -->
                <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Clientes
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ clientes.length }}
                        </p>
                    </div>
                </div>
                <!-- Card: Total Tenis -->
                <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Tenis
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ tenis }}
                        </p>
                    </div>
                </div>
                <!-- Card: Total Countries -->
                <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Countries
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ countries.length }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 rounded-lg">
                <div class="min-w-0 p-4 rounded-lg shadow-xs border">
                    <span class="text-lg p-4">Clientes by Country</span>
                    <div class="flex items-center">
                        <Bar :data="chartData1" :options="charOptions1"></Bar>
                    </div>
                </div>
                <div class="min-w-0 p-4 rounded-lg shadow-xs border">
                    <span class="text-lg p-4">Tenis by Clientes</span>
                    <div class="flex items-center">
                        <Pie :data="chartData2" :options="charOptions2" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
