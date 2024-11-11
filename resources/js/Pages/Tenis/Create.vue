<script setup>
import Form from './Form.vue';
const props = defineProps({
    clientes: {type: Object}
});
</script>

<template>
    <Form :clientes="clientes"/>
        
</template>