<script setup>
import DarkButton from '@/Components/DarkButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
const props = defineProps({
    teni: { type: Object },
    clientes: { type: Object }
});
</script>

<template>
    <Head title="Teni" />
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ teni.model }}
                <NavLink :href="route('tenis.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Marca: <span class="text-gray-900 font-semibold">{{ teni.marca }}</span></p>
                <p>Color: <span class="text-gray-900 font-semibold">{{ teni.color }}</span></p>
                <p>Precio: <span class="text-gray-900 font-semibold">{{ teni.precio }}</span></p>
                <p>Talla: <span class="text-gray-900 font-semibold">{{ teni.talla }}</span></p>
                <p>Material: <span class="text-gray-900 font-semibold">{{ teni.material }}</span></p>
                <p>Categoria: <span class="text-gray-900 font-semibold">{{ teni.categoria }}</span></p>
                <p>Clientes: <span v-for="c,i in clientes" class="text-gray-900 font-semibold">
                    <a v-if="i == (clientes.length-1)">{{ c.last_name+' '+c.name }}</a>
                    <a v-else>{{ c.last_name+' '+c.name+', ' }}</a>
                </span></p>

            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="`/${teni.image}`" width="600">
            </div>
        </div>
    </AuthenticatedLayout>
</template>
