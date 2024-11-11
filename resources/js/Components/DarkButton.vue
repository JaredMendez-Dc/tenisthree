<template>
  <button 
      :type="type" 
      class="rounded-full border border-gray-300 bg-[#B91C1C] px-6 py-2 text-sm font-semibold text-white shadow-md transition-all duration-200 ease-in-out hover:bg-yellow-500 hover:text-black hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 active:bg-yellow-600"
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
