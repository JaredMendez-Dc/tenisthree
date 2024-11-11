<script setup>
import Form from './Form.vue';
const props = defineProps({
    clientes: {type: Object},
    teni: {type: Object},
    clientesOfTeni: {type: Object},
});
</script>

<template>
    <Form :clientes="clientes" :teni="teni" :clientesOfTeni="clientesOfTeni"/>
        
</template>