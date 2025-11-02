<template>
  <div>
    <div
      class="w-72 bg-gray-200 absolute top-0 mr-6 mt-4 h-40 rounded-lg flex-row animation-enable"
      :class="[
        { hidden: !isMenuShown },
        { visible: isMenuShown },
        { 'right-min20rem': !pageActive },
        { 'right-0': pageActive },
      ]"
      @mouseover="setMenuVisibility(true)"
      @mouseleave="setMenuVisibility(false)"
    >
      <div class="w-full h-3/4" />
      <div class="w-full h-1/4 flex">
        <div class="rounded-b-lg bg-gray-400 flex hover:bg-gray-500 w-full h-full cursor-pointer" @click="$emit('sign-out')">
          <span class="m-auto font-monda-bold text-lg text-right w-full">
            Logout
          </span>
            <i class="select-none fas fa-sign-out-alt text-2xl p-3 mr-20 m-auto"></i>
        </div>
      </div>
    </div>

    <div
      class="absolute top-0 w-120 flex animation-enable"
      :class="[
        { 'right-0': pageActive },
        { 'right-min20rem': !pageActive },
        { 'h-48': !isMenuShown },
        { 'h-36': isMenuShown },
      ]"
      @mouseover="setMenuVisibility(true)"
    >
      <div class="w-auto m-auto h-full flex">
        <div class="w-24 h-full flex mr-4">
          <div
            class="flex w-24 h-24 m-auto rounded-full"
            :class="[
              { 'bg-green-400': !isMenuShown },
              { 'bg-green-600': isMenuShown },
            ]"
          >
            <img
              class="select-none w-20 h-20 m-auto rounded-full bg-white object-cover"
              :src="`/assets/${currentUser.kode}.jpg`"
              alt="asisten profile"
            />
          </div>
        </div>
        <div class="w-auto h-full flex-row ml-4 cursor-default">
          <div class="h-3/5 w-full flex">
            <span
              class="select-none font-overpass-mono-bold text-5xl self-end text-left w-full -mb-2 uppercase tracking-widest"
              :class="[
                { 'text-black': isMenuShown },
                { 'text-white': !isMenuShown },
              ]"
            >
              {{ currentUser.kode }}
            </span>
          </div>
          <div class="h-2/5 text-xl w-full text-left -mt-2">
            <span
              class="select-none font-overpass-thin font-semibold capitalize"
              :class="[
                { 'text-black': isMenuShown },
                { 'text-white': !isMenuShown },
              ]"
            >
              [ {{ userRole }} ]
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AsistenProfilePanel',
  props: {
    pageActive: {
      type: Boolean,
      default: false,
    },
    isMenuShown: {
      type: Boolean,
      default: false,
    },
    currentUser: {
      type: Object,
      required: true,
    },
    userRole: {
      type: String,
      default: '',
    },
  },
  emits: ['update:isMenuShown', 'sign-out'],
  methods: {
    setMenuVisibility(value) {
      this.$emit('update:isMenuShown', value);
    },
  },
};
</script>
