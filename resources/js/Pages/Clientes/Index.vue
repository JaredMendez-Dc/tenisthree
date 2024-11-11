<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';

// Aquí definimos los props y demás lógica
const props = defineProps({
    clientes: {
        type: Object
    },
    countries:{
        type: Object
    }
});
const form = useForm({name: '', last_name: '', country_id: ''});
const v = ref({id: '', name: '', last_name: '', tenis: []});
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const model = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

// Funciones...
const openModalView = (c) => {
    v.value.name = c.last_name + ' ' + c.name;
    v.value.country = c.country.country;
    v.value.tenis = c.tenis;
    showModalView.value = true;
};
const openModalForm = (op, c) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        model.value = 'Create cliente';
    } else {
        model.value = 'Edit cliente';
        form.name = c.name;
        form.last_name = c.last_name; // Corrección aquí
        form.country_id = c.country_id;
        v.value.id = c.id;
    }
};

const openModalDel = (c) => {
    showModalDel.value = true;
    v.value.id = c.id;
    v.value.name = c.last_name+' '+c.name;
};
const closeModalView = () => {
    showModalView.value = false;
};
const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
};
const closeModalDel = () => {
    showModalDel.value = false;
};

const save = () => {
    if (operation.value === 1) {
        form.post(route('clientes.store'), {
            onSuccess: () => ok('Cliente creado con éxito')
        });
    } else {
        form.put(route('clientes.update', v.value.id), {
            onSuccess: () => ok('Cliente actualizado con éxito')
        });
    }
};

const update = () => {
    
}
const ok = (m) => {
    if (operation.value == 2) {
        closeModalForm();
    }
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block'; 
    setTimeout(() => {
        classMsj.value = 'hidden'; 
    }, 9000);
};
const deleteClientes = (m) => {
form.delete(route('clientes.destroy',v.value.id),{
    onSuccess: () => ok('Cliente eliminado con éxito')
})
};

</script>

<template>
    	<Head title="clientes" />

        <AuthenticatedLayout>
            <template #header>
                Clientes <br>
                <DarkButton @click="openModalForm(1)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </DarkButton>
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
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Apellidos</th>
                            <th class="px-4 py-3">Pais</th>
                            <th class="px-4 py-3">Detalle</th>
                            <th class="px-4 py-3 ">Editar</th>
                            <th class="px-4 py-3">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="c,i in clientes" :key="c.id" class="text-green-700">
                                <td class="px-4 py-4 text-sm">{{ i + 1 }}</td>
                                <td class="px-4 py-4 text-sm">{{ c.name }}</td>
                                <td class="px-4 py-4 text-sm">{{ c.last_name }}</td>
                                <td class="px-4 py-4 text-sm">{{ c.country.country }}</td>
                                <td class="px-4 py-4 text-sm">
                                    <SecondaryButton @click="openModalView(c)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18V8.25m-18 0V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6ZM7.5 6h.008v.008H7.5V6Zm2.25 0h.008v.008H9.75V6Z" />
                                    </svg>
                                    </SecondaryButton>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <WarningButton @click="openModalForm(2,c)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                        </svg>
                                    </WarningButton>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <DangerButton @click="openModalDel(c)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Modal :show="showModalView" @close="closeModalView">
                <div class="p-6">
                    <p>Cliente: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
                    <p>Country: <span class="text-lg font-medium text-gray-900">{{ v.country }}</span></p>
                    tenis:
                    <ol>
                        <li class="text-lg font-medium text-gray-900" v-for="t,i in v.tenis">
                            {{ (i+1)+') '+t.model }}
                        </li>
                    </ol>
                </div>
                <div class="m-6 flex justify-end">
                    <SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
                </div>
            </Modal>
            
            <Modal :show="showModalForm" @close="closeModalForm">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">{{ model }}</h2>
                    <div class="mt-6 mb-6 space-y-6">
                        <InputGroup :text="'Nombre del cliente'" :required="'required'" v-model="form.name" :type="text">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                            </svg>
                            <InputError class="mt-1" :message="form.errors.name"></InputError>
                        </InputGroup>
                        <InputGroup :text="'Apellidos'" :required="'required'" v-model="form.last_name" :type="text">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                            <InputError class="mt-1" :message="form.errors.last_name"></InputError>
                        </InputGroup>
                        <SelectInput :text="'Pais'" :required="'required'" v-model="form.country_id" :options="countries">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                            <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
                            </svg>

                            <InputError class="mt-1" :message="form.errors.country_id"></InputError>
                        </SelectInput>
                        <PrimaryButton @click="save">Save</PrimaryButton>

                    </div>
                </div>
                <div class="m-6 flex justify-end">
                    <SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
                </div>
            </Modal>
            
            <Modal :show="showModalDel" @close="closeModalDel">
                <div class="p-6">
                    <p class="text-2xl text-gray-500">
                        ESTAS SEGURO DE ELIMINAR AL CLIENTE?
                    <span class="text-2xl font-medium text-gray-900">{{ v.name }}</span></p>
                    <div class="mt-3">
                        <SecondaryButton @click="deleteClientes">SI QUIERO ELIMINARLO</SecondaryButton>
                    </div>    
                </div>
                <div class="m-6 flex justify-end">
                    <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
                </div>
            </Modal>
        </AuthenticatedLayout>
</template> 