<template>
  <div class="bg-green-900 w-full h-full overflow-hidden">

    <!-- Main Menu -->
    <div class="absolute w-120 z-20 h-48full bottom-0 right-0 animation-enable"
        :class="[{ 'right-0': pageActive },
                { 'right-min20rem': !pageActive }]" @mouseover="isMenuShown = false">
      <div class="w-full h-full animation-enable overflow-y-auto"
          :class="[{ 'rounded-none': changePage && menuProfil },
                  { 'rounded-tl-large': !changePage || !menuProfil }]" ref="menuRef">
        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuProfil },
                    { 'bg-yellow-500 text-white': changePage && menuProfil }]"
            v-on:click="travel('')">
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-address-card">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Profil
          </span>
        </div>

        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuPraktikum },
                    { 'bg-yellow-500 text-white': changePage && menuPraktikum }]"
            v-on:click='travel("praktikum")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-code">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Praktikum
          </span>
        </div>


        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuHistory },
                    { 'bg-yellow-500 text-white': changePage && menuHistory }]"
            v-on:click='travel("history")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-history">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            History
          </span>
        </div>

        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuNilai },
                    { 'bg-yellow-500 text-white': changePage && menuNilai }]"
            v-on:click='travel("nilai")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-clipboard-check">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Nilai
          </span>
        </div>

        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuPolling },
                    { 'bg-yellow-500 text-white': changePage && menuPolling }]"
            v-on:click='travel("polling")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-chart-area">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Polling
          </span>
        </div>

        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuSetPraktikan },
                    { 'bg-yellow-500 text-white': changePage && menuSetPraktikan }]"
            v-on:click='travel("setpraktikan")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-users">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Set Praktikan
          </span>
        </div>

        <!-- Role Based Menu -->
        <div v-if="kelasPriviledge.includes(currentUser.role_id) || kelasPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuKelas },
                      { 'bg-yellow-500 text-white': changePage && menuKelas }]"
              v-on:click='travel("kelas")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-chalkboard-teacher">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Kelas
            </span>
          </div>
        </div>

        <div v-if="allLaporanPriviledge.includes(currentUser.role_id) || allLaporanPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuAllLaporan },
                      { 'bg-yellow-500 text-white': changePage && menuAllLaporan }]"
              v-on:click='travel("laporan")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-file-medical-alt">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              All Laporan
            </span>
          </div>
        </div>

        <div v-if="soalPriviledge.includes(currentUser.role_id) || soalPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuSoal },
                      { 'bg-yellow-500 text-white': changePage && menuSoal }]"
              v-on:click='travel("soal")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-file-code">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Soal
            </span>
          </div>
        </div>

        <div v-if="plottingPriviledge.includes(currentUser.role_id) || plottingPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuPlotting },
                      { 'bg-yellow-500 text-white': changePage && menuPlotting }]"
              v-on:click='travel("plotting")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-calendar-alt">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Plotting
            </span>
          </div>
        </div>

        <div v-if="modulPriviledge.includes(currentUser.role_id) || modulPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuModul },
                      { 'bg-yellow-500 text-white': changePage && menuModul }]"
              v-on:click='travel("modul")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-book">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Modul
            </span>
          </div>
        </div>

        <div v-if="konfigurasiPriviledge.includes(currentUser.role_id) || konfigurasiPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuKonfigurasi },
                      { 'bg-yellow-500 text-white': changePage && menuKonfigurasi }]"
              v-on:click='travel("konfigurasi")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-cog">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Konfigurasi
            </span>
          </div>
        </div>
        
        <div v-if="tpPriviledge.includes(currentUser.role_id) || tpPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuTp },
                      { 'bg-yellow-500 text-white': changePage && menuTp }]"
              v-on:click='travel("tp")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-book-open">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Tugas Pendahuluan
            </span>
          </div>
        </div>

        <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
            :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuLihatTp },
                    { 'bg-yellow-500 text-white': changePage && menuLihatTp }]"
            v-on:click='travel("lihat_tp")'>
          <div class="w-7/12 my-2 flex">
            <div class="w-4/6"/>
            <img class="select-none m-auto w-2/6 h-auto fas fa-eye">
          </div>
          <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
            Lihat TP
          </span>
        </div>

        <div v-if="jawabanPriviledge.includes(currentUser.role_id) || jawabanPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none animation-enable"
              :class="[{ 'bg-yellow-500 text-white': !changePage },
                      { 'bg-yellow-400 text-black': changePage }]">
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-tasks">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Jawaban
            </span>
          </div>
        </div>
        
        <div v-if="pelanggaranPriviledge.includes(currentUser.role_id) || pelanggaranPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuPelanggaran },
                      { 'bg-yellow-500 text-white': changePage && menuPelanggaran }]"
              v-on:click='travel("pelanggaran")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-radiation-alt">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Pelanggaran
            </span>
          </div>
        </div>

        <div v-if="RankingPriviledge.includes(currentUser.role_id) || RankingPriviledge == 'all'">
          <div class="w-full p-4 h-24 flex select-none cursor-pointer hover:text-white animation-enable"
              :class="[{ 'bg-yellow-400 hover:bg-yellow-600': !changePage || !menuRanking },
                      { 'bg-yellow-500 text-white': changePage && menuRanking }]"
              v-on:click='travel("rating")'>
            <div class="w-7/12 my-2 flex">
              <div class="w-4/6"/>
              <img class="select-none m-auto w-2/6 h-auto fas fa-star">
            </div>
            <span class="ml-6 font-merri-bold font-medium w-full text-start self-center text-xl">
              Ranking Praktikan
            </span>
          </div>
        </div>  
      </div>
    </div>

    <!-- Profile Menu -->
    <div class="w-72 bg-gray-200 absolute top-0 mr-6 mt-4 h-40 rounded-lg flex-row animation-enable"
        :class="[{ 'hidden': !isMenuShown },
                { 'visible': isMenuShown },
                { 'right-min20rem': !pageActive },
                { 'right-0': pageActive }]" @mouseover="isMenuShown = true" @mouseleave="isMenuShown = false">
        <div class="w-full h-3/4"/>
        <div class="w-full h-1/4 flex">
          <div class="rounded-b-lg bg-gray-400 flex hover:bg-gray-500 w-full h-full cursor-pointer" v-on:click="signOut">
            <span class="m-auto font-monda-bold text-lg text-right w-full">
              Logout
            </span>
            <i class="select-none fas fa-sign-out-alt text-2xl p-3 mr-20 m-auto"></i>
          </div>
        </div>
    </div>

    <!-- Assistant's Profile -->
    <div class="absolute top-0 w-120 flex animation-enable"
        :class="[{ 'right-0': pageActive },
                { 'right-min20rem': !pageActive },
                { 'h-48': !isMenuShown },
                { 'h-36': isMenuShown }]" @mouseover="isMenuShown = true;">
      <div class="w-auto m-auto h-full flex">
        <div class="w-24 h-full flex mr-4">
          <div class="flex w-24 h-24 m-auto rounded-full"
              :class="[{ 'bg-green-400': !isMenuShown },
                      { 'bg-green-600': isMenuShown }]">
            <img class="select-none w-20 h-20 m-auto rounded-full bg-white object-cover" :src="'/assets/'+currentUser.kode+'.jpg'" alt="daskom logo">
          </div>
        </div>
        <div class="w-auto h-full flex-row ml-4 cursor-default">
          <div class="h-3/5 w-full flex">
            <span class="select-none font-overpass-mono-bold text-5xl self-end text-left w-full -mb-2 uppercase tracking-widest"
                :class="[{ 'text-black': isMenuShown },
                        { 'text-white ': !isMenuShown }]">
              {{ currentUser.kode }}
            </span>
          </div>
          <div class="h-2/5 text-xl w-full text-left -mt-2">
            <span class="selec-none font-overpass-thin font-semibold capitalize"
                :class="[{ 'text-black': isMenuShown },
                        { 'text-white ': !isMenuShown }]">
              [ {{ userRole }} ]
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Jawaban's Contents -->
    <div class="absolute left-0 h-full w-120full flex flex-col m-auto animation-enable"
        :class="[{ 'left-minFull': !currentPage },
                    { 'left-0': currentPage }]">
      <div class="w-3/5 h-5/6 m-auto flex flex-col">
          <div class="w-full h-1/6 font-overpass-mono-bold text-2xl">
            <div class="flex font-overpass-mono-bold text-3xl text-gray-200 mr-12">
              <div class="w-5/6 flex justify-center mr-40">
                MODUL
              </div>
              <div class="w-1/6 flex justify-center">
                LOCK/UNLOCK
              </div>
            </div>
          </div>
          <div class="overflow-y-auto divide-y-2 divide-gray-400">
              <div v-for="modul in all_modul" v-bind:key="modul.id"
                  class="flex flex-col font-overpass-mono-bold text-2xl py-4 px-5"
                  :class="[{ 'text-yellow-200': !modul.isUnlocked },
                           { 'text-yellow-500': modul.isUnlocked }]">
                 <div class="flex">
                   <div class="w-5/6 pt-1">{{ modul.judul }}</div>
                   <div class="w-1/6 flex justify-center mr-8">
                     <toggle-button
                         v-on:change="setActive(modul)" 
                         v-model="modul.isUnlocked"
                         :value="modul.isUnlocked"
                         :sync="true"
                         :labels="true"
                         :width="100"
                         :height="40"
                         :font-size="15"/>
                   </div>
                 </div>
             </div>
          </div>
      </div>
    </div>

  </div>
</template>

<script>
import { ref, toRefs } from 'vue';
import { useNavigation } from '@/composables/useNavigation';
import { useToast } from '@/composables/useToast';
import { useLogout } from '@/composables/useLogout';
export default {
  props: [
    'comingFrom',
    'currentUser',
    'position',
    'userRole',
    'allTP',
    'allModul',
  ],

  setup(props) {
    const menuRef = ref(null);

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: menuRef,
      currentPage: 'jawaban'
    });

    // Initialize menu state based on comingFrom prop
    navigation.initializeMenu(props.comingFrom, true);
    const toast = useToast();
    const { logoutAsisten } = useLogout();
    // Return all navigation state and methods
    return {
      toast,
      menuRef,
      ...toRefs(navigation),
      logoutAsisten,
    };
  },

  data() {
    return {
      kelasPriviledge: [1,2,4,5],
      plottingPriviledge: [1,2,4,5],
      modulPriviledge: [1,2,4,15,7],
      konfigurasiPriviledge: [1,2,4,18,7],
      tpPriviledge: [1,2,15,11,7],
      pelanggaranPriviledge: [1,2,4,5,6,18],
      RankingPriviledge: [1,2,4,5,8,16],
      allLaporanPriviledge: [1,2,4,5,6],
      jawabanPriviledge: [1,2,7,11,15],
      soalPriviledge: "all",
      tryChange: false,

      all_modul : [],

      pageActive: true,
      isMenuShown: false,
      
      processing: false,

    };
  },

  mounted() {

    $('body').addClass('closed');
    
    // Restore scroll position if provided
    if (this.$refs.menuRef && this.position != null) {
      this.$nextTick(() => {
        this.$refs.menuRef.scrollTop = this.position;
      });
    }

    const globe = this;

    if(this.comingFrom === 'asisten' ||
        this.comingFrom === 'none' ||
        this.comingFrom === 'soal'||
        this.comingFrom === 'modul'||
        this.comingFrom === 'praktikum' ||
        this.comingFrom === 'plotting' ||
        this.comingFrom === 'kelas' ||
        this.comingFrom === 'polling' ||
        this.comingFrom === 'tp' ||
        this.comingFrom === 'konfigurasi' ||
        this.comingFrom === 'history'||
        this.comingFrom === 'nilai'||
        this.comingFrom === 'pelanggaran'||
        this.comingFrom === 'setpraktikan'||
        this.comingFrom === 'rating' ||
        this.comingFrom === 'allLaporan' ||
        this.comingFrom === 'lihat_tp'){

      setTimeout(
        function() {
          globe.currentPage = true;
        }, 10); 
    }

    globe.all_modul = globe.allModul.filter(function(modul){
      modul.isUnlocked === 1 ? modul.isUnlocked = true : modul.isUnlocked = false;
      switch (modul.id) {
        case 1:
          modul.idINT = 6;
          break;
        case 2:
          modul.idINT = 7;
          break;
        case 3:
          modul.idINT = 8;
          break;
        case 4:
          modul.idINT = 9;
          break;
        case 5:
          modul.idINT = 10;
          break;
        case 11:
          modul.idINT = 16;
          break;
        case 12:
          modul.idINT = 17;
          break;
        case 13:
          modul.idINT = 18;
          break;
        case 14:
          modul.idINT = 19;
          break;
        case 15:
          modul.idINT = 20;
          break;
        default:
          modul.idINT = null;
          break;
      }
      return modul;
    });
  },

  methods: {

    setActive: function($modul){
      const globe = this;
        this.$axios.post('/asisten/modul/jawaban-config', $modul).then(response => {
          if(response.data.message === "success" && $modul.isUnlocked === true) {
            globe.toast.success("Jawaban berhasil diaktifkan");
          } else if(response.data.message === "success" && $modul.isUnlocked === false) {
            globe.toast.success("Jawaban berhasil dinon-aktifkan");
          }
          else {
            globe.toast.error(response.data.message);
          }
        })
    },
   
    signOut: function(){
      this.pageActive = false;
      this.currentPage = false;
      setTimeout(async () => {
        await this.logoutAsisten();
      }, 1010);
    },
  }
}
</script>
