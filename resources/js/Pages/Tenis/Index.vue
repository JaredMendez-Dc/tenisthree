<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    tenis: {type: Object},flash: {type: Object}
});

const form = useForm({id:'',model:''});
const showModalDel = ref(false);
const msj = ref((props.flash.success !=null) ? props.flash.success: '');
const classMsj = ref((props.flash.success !=null) ? '' : 'hidden');

const openModalDel = (t) =>{
    form.id = t.id;
    form.model = t.model;
    showModalDel.value = true;
}
const closeModalDel = () =>{
    showModalDel.value = false;
}
const deleteTeni = (m) =>{
    form.delete(route('tenis.destroy',form.id),{
        onSuccess: () => {ok('Tenis Eliminado')}
    })
};
const ok = (m) => {
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block'; 
    setTimeout(() => {
        classMsj.value = 'hidden'; 
    }, 5000);
};
</script>

<template>
    <Head title="Tenis" />

    <AuthenticatedLayout>
        <template #header>
            Tenis
        </template>

        <div class="inline-flex overflow-hidden mb-4 w-full bg-gray-800 rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                </svg>
            </div>
            
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>
        
        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-green-700 uppercase border-b dark:border-red-700 bg-gray-50 dark:text-green-400 dark:bg-gray-800">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Modelo</th>
                        <th class="px-4 py-3">Marca</th>
                        <th class="px-4 py-3">Color</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Talla</th>
                        <th class="px-4 py-3">Material</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Imagen</th>
                        <th class="px-4 py-3">Detalle</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="t,i in tenis.data" :key="t.id" class="text-green-700">
                            <td class="px-4 py-3 text-sm">{{ i + 1 }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.model }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.marca }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.color }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.precio }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.talla }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.material }}</td>
                            <td class="px-4 py-3 text-sm">{{ t.categoria }}</td>
                            <td class="px-4 py-3 text-sm"><img :src="`/${t.image}`" width="50"></td>
                            <td class="px-4 py-4 text-sm">
                                <NavLink :href="route('tenis.show',t.id)">
                                <SecondaryButton >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18V8.25m-18 0V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6ZM7.5 6h.008v.008H7.5V6Zm2.25 0h.008v.008H9.75V6Z" />
                                </svg>
                                </SecondaryButton>
                                </NavLink>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <NavLink :href="route('tenis.edit',t.id)">
                                <WarningButton>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                    </svg>
                                </WarningButton>
                                </NavLink>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <DangerButton @click="openModalDel(t)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="tenis.links" />
				</div>
        </div>
        
        
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-2xl text-gray-500">
                    ESTAS SEGURO DE ELIMINAR EL TENIS?
                <span class="text-2xl font-medium text-gray-900">{{ form.model }}</span></p>
                <div class="mt-3">
                    <DarkButton @click="deleteTeni">SI QUIERO ELIMINARLO</DarkButton>
                </div>    
            </div>
            
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template> 