<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import select2 from 'select2';
select2();
import Select2 from 'vue3-select2-component';

const props = defineProps({
    clientes: { type: Array }, // Lista completa de clientes
    teni: { type: Object },    // Datos del tenis (nulo si es creación)
    clientesOfTeni: { type: Array }, // Clientes relacionados con este tenis
});

const form = useForm({
    id: '', 
    model: '', 
    marca: '', 
    color: '', 
    precio: '', 
    talla: '', 
    material: '', 
    categoria: '', 
    image: '',
    clientes: []
});

const title_form = ref(
    props.teni == null ? 'Create tenis' : 'Edit tenis'
);


const req = ref('required');
const srcImg = ref('../../storage/imagenes_tenis/1.png');
const msj = ref('');
const classMsj = ref('hidden');
const options = ref([]);
props.clientes.forEach((cliente) => {
    options.value.push({ id: cliente.id, text: `${cliente.name} ${cliente.last_name}` });
});

if (props.teni != null) {
    form.id = props.teni.id;
    form.model = props.teni.model;
    form.marca = props.teni.marca;
    form.color = props.teni.color;
    form.precio = props.teni.precio;
    form.talla = props.teni.talla;
    form.material = props.teni.material;
    form.categoria = props.teni.categoria;
    form.image = props.teni.image;
    srcImg.value = '/' + props.teni.image;
    form.clientes = props.clientesOfTeni.map((cliente) => cliente.id);
}

const save = () => {
    if (props.teni == null) {
        form.post(route('tenis.store'), {
            onSuccess: () => ok('Tenis creado'),
        });
    } else {
        form.put(route('tenis.update', form.id), {
            onSuccess: () => ok('Tenis actualizado'),
        });
    }
};


const ok = (message) => {
    form.reset();
    msj.value = message;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000); // Ajustado a 8 segundos como en el script de libros
};

const showImg = (e) => {
    form.image = e.target.files[0];
    srcImg.value = URL.createObjectURL(e.target.files[0]);
};
</script>


<template>



    <Head title="Teni" />
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ title_form }}
                <NavLink :href="route('tenis.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
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

        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save">
                    <!-- Modelo -->
                    <InputGroup :text="'Modelo'" :required="'required'" v-model="form.model" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.model" />

                    <!-- Marca -->
                    <InputGroup :text="'Marca'" :required="'required'" v-model="form.marca" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.marca" />

                    <!-- Color -->
                    <InputGroup :text="'Color'" :required="'required'" v-model="form.color" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.color" />

                    <!-- Precio -->
                    <InputGroup :text="'Precio'" :required="'required'" v-model="form.precio" :type="'number'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.precio" />

                    <!-- Talla -->
                    <InputGroup :text="'Talla'" :required="'required'" v-model="form.talla" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.talla" />

                    <!-- Material -->
                    <InputGroup :text="'Material'" :required="'required'" v-model="form.material" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5M3.75 12h16.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.material" />

                    <!-- Categoría -->
                    <InputGroup :text="'Categoría'" :required="'required'" v-model="form.categoria" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75l7.5 7.5-7.5 7.5-7.5-7.5 7.5-7.5z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.categoria" />

                    <!-- Imagen -->
                    <InputGroup v-if="props.teni == null" @change="showImg($event)" :text="'Imagen'" :required="'required'" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>
                    <InputGroup v-else :text="'Imagen'" @change="showImg($event)" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.image" />

                    <span class="mt-3">
                        <div class="mt-4">Add clientes</div>
                    </span>
                    <Select2 v-model="form.clientes" :options="options" :settings="{multiple: true, width: '100%'}" class="select2" @change="form.clientes = $event.target.value" />
                    <InputError :message="form.errors.clientes" />
                    <PrimaryButton>Save</PrimaryButton>
                </form>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="srcImg" width="500">
            </div>
        </div>
    </AuthenticatedLayout>
</template>