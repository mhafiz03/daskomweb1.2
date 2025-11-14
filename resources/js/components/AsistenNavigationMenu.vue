<template>
  <div class="absolute w-full h-auto bg-green-700 flex py-1 px-5 rounded-b-lg mt-1 duration-500 animation-enable border-2 border-green-800 z-10">
    <div class="pt-3 px-2 w-full flex-row">
      
      <!-- Home/Profile Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuProfil }"
          class="px-4 rounded-full flex items-center text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('')">
          <i class="fas fa-home fa-lg h-6 w-6"></i>
        </span>
      </div>

      <!-- Praktikum Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuPraktikum }"
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('praktikum')">
          Praktikum
        </span>
      </div>

      <!-- History Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuHistory }"
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('history')">
          History
        </span>
      </div>

      <!-- Nilai Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuNilai }"
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('nilai')">
          Nilai
        </span>
      </div>

      <!-- Polling Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuPolling }"
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('polling')">
          Polling
        </span>
      </div>

      <!-- Set Praktikan Button -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          :class="{ 'bg-yellow-500': menuSetPraktikan }"
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="handleNavigate('setpraktikan')">
          Set Praktikan
        </span>
      </div>

      <!-- Expandable Menu Toggle -->
      <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
        <span 
          class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
          @click="showMore = !showMore">
          <i :class="['fas fa-angle-down h-6 w-6 duration-300', { 'transform rotate-180': showMore }]"></i>
        </span>
      </div>

      <!-- Expanded Menu Items -->
      <div v-show="showMore" class="w-full flex-row animation-enable">
        
        <!-- Kelas -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuKelas }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('kelas')">
            Kelas
          </span>
        </div>

        <!-- Laporan -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuAllLaporan }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('laporan')">
            Laporan
          </span>
        </div>

        <!-- Soal -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuSoal }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('soal')">
            Soal
          </span>
        </div>

        <!-- Plotting -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuPlotting }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('plotting')">
            Plotting
          </span>
        </div>

        <!-- Modul -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuModul }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('modul')">
            Modul
          </span>
        </div>

        <!-- Konfigurasi -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuKonfigurasi }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('konfigurasi')">
            Konfigurasi
          </span>
        </div>

        <!-- TP -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuTp }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('tp')">
            TP
          </span>
        </div>

        <!-- Lihat TP -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuLihatTp }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('lihat_tp')">
            Lihat TP
          </span>
        </div>

        <!-- Jawaban -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuJawaban }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('jawaban')">
            Jawaban
          </span>
        </div>

        <!-- Pelanggaran -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuPelanggaran }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('pelanggaran')">
            Pelanggaran
          </span>
        </div>

        <!-- Rating -->
        <div class="bg-yellow-300 hover:bg-yellow-400 rounded-full h-auto w-auto my-1 duration-300 hover:duration-300 flex">
          <span 
            :class="{ 'bg-yellow-500': menuRanking }"
            class="px-4 rounded-full text-green-800 hover:text-green-900 font-overpass text-2xl cursor-pointer duration-300"
            @click="handleNavigate('rating')">
            Rating
          </span>
        </div>

      </div>

    </div>
  </div>
</template>

<script>
import { ref, toRefs } from 'vue';
import { useNavigation } from '@/composables/useNavigation';

export default {
  name: 'AsistenNavigationMenu',
  
  props: {
    comingFrom: {
      type: String,
      default: '',
    },
    menuRef: {
      type: Object,
      default: null,
    },
    currentPage: {
      type: String,
      default: '',
    },
  },

  setup(props) {
    const showMore = ref(false);

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: props.menuRef,
      currentPage: props.currentPage,
    });

    // Initialize menu state based on comingFrom
    navigation.initializeMenu(props.comingFrom, true);

    const handleNavigate = (destination) => {
      navigation.travel(destination, {
        comingFrom: props.currentPage,
      });
    };

    return {
      showMore,
      handleNavigate,
      ...toRefs(navigation),
    };
  },
};
</script>
