<template>
    <div
      v-if="editPriviledge.includes(currentUser.role_id)"
      class="w-16 bg-gray-400 rounded-r-lg h-full flex flex-col justify-evenly items-center "
    >
      <!-- Delete Button -->
      <button
        class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors duration-200 cursor-pointer text-gray-900 focus:outline-none"
        @click="$emit('delete', soal.id)"
      >
        <i class="fas fa-trash w-full text-3xl"></i>
      </button>
  
      <!-- Edit Open Button -->
      <button
        class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors duration-200 cursor-pointer text-gray-900 focus:outline-none"
        :class="'editOpenTA-' + soal.id"
        @click="$emit('edit', { soal, editing: true })"
      >
        <i class="fas fa-pen w-full text-3xl"></i>
      </button>
  
      <!-- Edit Close Button -->
      <button
        class="w-full p-3 hover:p-4 transition-all duration-150 cursor-pointer text-gray-900 hidden"
        :class="'editCloseTA-' + soal.id"
        @click="$emit('edit', { soal, editing: false })"
      >
        <i class="fas fa-times w-full text-3xl"></i>
      </button>
  
      <!-- Comment Button -->
      <div class="relative inline-block">
        <button
          class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors duration-200 cursor-pointer text-gray-900 focus:outline-none"
          @click="$emit('toggle-comments', soal)"
        >
          <i class="fas fa-comment text-3xl"></i>
        </button>
  
        <!-- Notification Badge -->
        <span
          v-if="commentCount > 0"
          class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white shadow-md"
        >
          {{ commentCount }}
        </span>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ActionButtons',
    props: {
      soal: {
        type: Object,
        required: true
      },
      editPriviledge: {
        type: Array,
        required: true
      },
      currentUser: {
        type: Object,
        required: true
      },
      commentCount: {
        type: Number,
        default: 0
      }
    },
    emits: ['delete', 'edit', 'toggle-comments'],

  };
  </script>
  
  <style scoped>
  /* optional custom style */
  </style>
  