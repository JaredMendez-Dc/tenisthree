<template>
  <button 
      :type="type" 
       class="inline-flex items-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 active:bg-blue-600"
  >
    <slot />
  </button>
</template>

<script setup>
defineProps({
  type: {
      type: String,
      default: 'submit',
  },
});
</script>
