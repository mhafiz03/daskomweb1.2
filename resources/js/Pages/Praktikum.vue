<template>
  <div class="w-full h-full overflow-hidden">

    <!-- Sound Part -->
    <div id="sound"></div>

    <!-- Main Menu -->
    <SidebarMenu :page-active="pageActive" :items="visibleMenuItems" :menu-container-class="menuContainerClass"
      :highlighted-menu="highlightedMenu" :menu-ref="menuRef" @hover="isMenuShown = false" @select="handleMenuSelect" />

    <!-- Profile Menu -->
    <AsistenProfilePanel :page-active="pageActive" :is-menu-shown="isMenuShown" :current-user="currentUser"
      :user-role="userRole" @update:isMenuShown="isMenuShown = $event" @sign-out="signOut" />

    <!-- Praktikum Layout (No praktikum exist || "i am the PJ") -->
    <div class="relative h-screen w-120full animation-enable" :class="[{ 'left-0': currentPage },
    { 'left-minFull': !currentPage }]" @mouseover="isMenuShown = false;">

      <div class="w-full h-full flex" v-if="isForbidden">
        <div class="m-auto w-auto h-auto text-center">
          <span class="font-monda-bold whitespace-pre-wrap break-words text-3xl text-white">Ada praktikum yang sedang
            berlangsung<br>(liat menu lain aja)</span>
        </div>
      </div>

      <div class="w-full h-full flex" v-if="!isForbidden">
        <div v-if="statusPraktikum === 5 ||
          statusPraktikum === 6" class="w-full h-24full flex-row absolute bottom-0 pointer-events-none">
          <div class="w-full h-36full flex pointer-events-auto px-10">
            <div v-if="statusPraktikum === 5" class="w-full h-full flex-row">
              <div class="w-full h-full flex">
                <div class="font-overpass-bold text-4xl text-white text-center m-auto">
                  PRAKTIKUM SELESAI <br>
                  Terimakasih atas kehadirannya <br>
                  (Silahkan rating asisten dan praktikumnya 😄 )
                </div>
              </div>
            </div>
            <div v-if="statusPraktikum === 6" class="w-3/4 h-24full px-5 m-auto flex-row">
              <div class="w-full h-1/5 flex">
                <div class="w-1/4 h-full flex">
                  <div class="ml-auto my-auto mr-4 font-monda-bold text-2xl text-white">
                    Asisten JAGA
                  </div>
                </div>
                <div class="w-3/4 h-full py-2 flex">
                  <div class="w-full h-full">
                    <input v-model="formHistoryJaga.allasisten_kode"
                      class="font-overpass-mono-bold uppercase text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                      id="kode" type="text" placeholder='Pisahkan dengan tanda "-" untuk penulisan'>
                  </div>
                </div>
              </div>
              <div class="w-full h-1/5 flex">
                <div class="w-1/4 h-full flex">
                  <div class="ml-auto my-auto mr-4 font-monda-bold text-2xl text-white">
                    Asisten IZIN
                  </div>
                </div>
                <div class="w-3/4 h-full py-2 flex">
                  <div class="w-full h-full">
                    <input v-model="formHistoryIzin_Izin.allasisten_kode"
                      class="font-overpass-mono-bold uppercase text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                      id="kode" type="text" placeholder='Pisahkan dengan tanda "-" untuk penulisan'>
                  </div>
                </div>
              </div>
              <div class="w-full h-1/5 flex">
                <div class="w-1/4 h-full flex">
                  <div class="ml-auto my-auto mr-4 font-monda-bold text-2xl text-white">
                    Asisten SAKIT
                  </div>
                </div>
                <div class="w-3/4 h-full py-2 flex">
                  <div class="w-full h-full">
                    <input v-model="formHistoryIzin_Sakit.allasisten_kode"
                      class="font-overpass-mono-bold uppercase text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                      id="kode" type="text" placeholder='Pisahkan dengan tanda "-" untuk penulisan'>
                  </div>
                </div>
              </div>
              <div class="w-full h-1/5 flex">
                <div class="w-1/4 h-full flex">
                  <div class="ml-auto my-auto mr-4 font-monda-bold text-2xl text-white">
                    Asisten ALFA
                  </div>
                </div>
                <div class="w-3/4 h-full py-2 flex">
                  <div class="w-full h-full">
                    <input v-model="formHistoryIzin_Alfa.allasisten_kode"
                      class="font-overpass-mono-bold uppercase text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                      id="kode" type="text" placeholder='Pisahkan dengan tanda "-" untuk penulisan'>
                  </div>
                </div>
              </div>
              <div class="w-full h-1/5 flex">
                <div class="w-1/4 h-full flex">
                  <div class="ml-auto my-auto mr-4 font-monda-bold text-2xl text-white">
                    Praktikan ALFA
                  </div>
                </div>
                <div class="w-3/4 h-full py-2 flex">
                  <div class="w-full h-full">
                    <input v-model="formPraktikan_Alfa.allpraktikan_nim"
                      class="font-overpass-mono-bold uppercase text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                      id="kode" type="text" placeholder='Pisahkan dengan tanda "-" untuk penulisan'>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="statusPraktikum === 6" class="w-1/4 pb-10 px-5 h-24full m-auto flex-row">
              <span class="font-merri w-full text-left text-white text-lg h-1/4">
                Laporan
                <p>(Edit Waktu mulai bila dirasa kurang tepat)</p>
              </span>
              <div class="w-full h-full">
                <textarea v-model="formLaporanPj.laporan" cols="30" rows="10"
                  class="font-overpass-mono-bold text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                  id="Laporan" type="text" placeholder="Ex: Asisten FAI jaga 2 kelompok, ingat cantumkan tanggal" />
              </div>
            </div>
          </div>
          <div class="w-1/3 h-full m-auto flex p-4 hover:p-5 animation-enable-short cursor-pointer pointer-events-auto"
            v-on:click="goToNextSection(false)">
            <div class="w-full h-16 bg-gray-300 flex font-merri-bold text-2xl items-center rounded-full">
              <div class="w-auto select-none h-full m-auto items-center flex">
                NEXT
              </div>
            </div>
          </div>
        </div>

        <div v-if="statusPraktikum === 0 ||
          statusPraktikum === 1 ||
          statusPraktikum === 2 ||
          statusPraktikum === 3 ||
          statusPraktikum === 4" class="w-full h-24full flex-row absolute bottom-0 pointer-events-none">
          <div class="w-full h-1/2 flex">
            <div class="w-auto text-white h-auto mx-auto mt-auto pt-24 text-center">
              <span class="font-overpass-bold text-3xl text-center" :class="[{ 'visible': statusPraktikum === 0 },
              { 'hidden': statusPraktikum != 0 }]">
                PRAKTIKUM DASKOM<br>
                (Klik START untuk memulai TA)
              </span>
              <span class="font-overpass-bold text-9xl " :class="[{ 'visible': statusPraktikum === 1 },
              { 'hidden': statusPraktikum != 1 }]">
                TA
              </span>
              <span class="font-overpass-bold text-9xl " :class="[{ 'visible': statusPraktikum === 2 },
              { 'hidden': statusPraktikum != 2 }]">
                JURNAL
              </span>
              <span class="font-overpass-bold text-9xl " :class="[{ 'visible': statusPraktikum === 3 },
              { 'hidden': statusPraktikum != 3 }]">
                MANDIRI
              </span>
              <span class="font-overpass-bold text-9xl " :class="[{ 'visible': statusPraktikum === 4 },
              { 'hidden': statusPraktikum != 4 }]">
                TK
              </span>
            </div>
          </div>
          <div class="w-full h-1/2 flex-row">
            <div class="w-full h-1/3 flex">
              <div class="w-3/4 bg-yellow-400 rounded-large font-monda-bold text-6xl h-full items-center m-auto flex">
                <div class="w-auto h-auto text-green-600 pt-1 m-auto">
                  {{ time }}
                </div>
              </div>
            </div>
            <div class="w-full h-24 flex">
              <div class="w-3/4 h-full m-auto flex">
                <div class="w-full h-full flex">
                  <div class="h-full flex p-4 hover:p-5 animation-enable-short cursor-pointer pointer-events-auto"
                    :class="[{ 'w-1/2': statusPraktikum === 0 },
                    { 'w-1/3': statusPraktikum !== 0 }]" v-on:click="rollbackPraktikum(false)">
                    <div class="w-full h-full bg-gray-300 flex font-merri-bold text-2xl items-center rounded-full">
                      <div class="w-auto select-none h-full m-auto items-center flex">
                        ROLLBACK
                      </div>
                    </div>
                  </div>
                  <div class="h-full flex p-4 hover:p-5 animation-enable-short cursor-pointer pointer-events-auto"
                    :class="[{ 'hidden': countdownStarted },
                    { 'visible': !countdownStarted },
                    { 'w-1/2': statusPraktikum === 0 },
                    { 'w-1/3': statusPraktikum !== 0 }]" v-on:click="startCountdown()">
                    <div class="w-full h-full bg-gray-300 flex font-merri-bold text-2xl items-center rounded-full">
                      <div class="w-auto select-none h-full m-auto items-center flex">
                        START
                      </div>
                    </div>
                  </div>
                  <div class="h-full flex p-4 hover:p-5 animation-enable-short cursor-pointer pointer-events-auto"
                    :class="[{ 'hidden': !countdownStarted },
                    { 'visible': countdownStarted },
                    { 'w-1/2': statusPraktikum === 0 },
                    { 'w-1/3': statusPraktikum !== 0 }]" v-on:click="pauseCountdown()">
                    <div class="w-full h-full bg-gray-300 flex font-merri-bold text-2xl items-center rounded-full">
                      <div class="w-auto select-none h-full m-auto items-center flex">
                        PAUSE
                      </div>
                    </div>
                  </div>
                  <div class="w-1/3 h-full flex p-4 hover:p-5 animation-enable-short cursor-pointer pointer-events-auto"
                    :class="[{ 'hidden': statusPraktikum === 0 },
                    { 'visible': statusPraktikum !== 0 }]" v-on:click="goToNextSection(false)">
                    <div class="w-full h-full bg-gray-300 flex font-merri-bold text-2xl items-center rounded-full">
                      <div class="w-auto select-none h-full m-auto items-center flex">
                        NEXT
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full h-24 px-8 mt-8 flex z-20">
          <div class="w-1/3 h-full flex-row">
            <div class="font-merri w-full flex text-left text-yellow-400 text-2xl mb-2 h-1/3">
              <span class="h-auto my-auto">
                Kelas
              </span>
            </div>
            <div class="w-full h-1/2 tatkOption">
              <select :onchange="getAllAsistenPraktikan()" v-model="chosenKelasID"
                class="block font-monda-bold text-xl appearance-none w-full h-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                id="grid-state" :class="[{ 'pointer-events-none': praktikumStart },
                { 'pointer-events-auto': !praktikumStart }]">
                <option class="hidden" value="" disabled selected>
                  Pilih kelas
                </option>
                <option v-for="kelas in allKelas" v-bind:key="kelas.id" :value="kelas.id" :disabled="!kelas.id">
                  {{ kelas.kelas }} [ {{ kelas.hari.toUpperCase() }} - Shift {{ kelas.shift }} ]
                </option>
              </select>
            </div>
          </div>
          <div class="w-2/3 pl-8 h-full flex-row">
            <div class="font-merri w-full flex text-left text-yellow-400 text-2xl mb-2 h-1/3">
              <span class="h-auto my-auto">
                Modul
              </span>
            </div>
            <div class="w-full h-1/2 tatkOption">
              <select v-model="chosenModulID"
                class="block font-monda-bold text-xl appearance-none w-full h-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                id="grid-state" :class="[{ 'pointer-events-none': praktikumStart },
                { 'pointer-events-auto': !praktikumStart }]">
                <option class="hidden" value="" disabled selected>
                  Pilih modul
                </option>
                <option v-for="modul in allModul" v-bind:key="modul.id" :value="modul.id" :disabled="!modul.id">
                  {{ modul.judul }}
                </option>
              </select>
            </div>
          </div>
        </div>

        <div class="w-full h-36full absolute animation-enable z-20" :class="[{ 'bottom-0': !praktikumStart },
        { 'bottom-minFull': praktikumStart }]">
          <div class="w-16full bg-green-500 rounded-t-lg mx-auto h-full" v-scrollbar>
            <div class="p-8">
              <div class="w-full h-auto flex rounded-lg bg-gray-300">
                <div class="w-full h-auto flex" v-if="listAllAsisten.length > 0 &&
                  listAllPraktikan.length > 0">
                  <div class="w-1/3 h-auto flex-row">
                    <transition-group name="asisten-list" tag="div">
                      <div v-for="(asisten, index) in listAllAsisten" v-bind:key="asisten.id"
                        class="animation-enable h-24 w-full flex-row" :class="[
                          { 'bg-gray-300 text-black': index % 2 === 0 },
                          { 'bg-gray-600 text-white': index % 2 !== 0 },
                          { 'rounded-tl-lg': index === 0 },
                          { 'rounded-bl-lg': index + 1 === listAllAsisten.length }]">
                        <div class="w-full h-2/3 flex">
                          <div class="mx-auto mt-auto font-overpass-bold text-4xl">
                            {{ asisten.kode }}
                          </div>
                        </div>
                        <div class="w-full -mt-4 flex">
                          <div class="mx-auto mb-auto font-merri text-2xl">
                            {{ index + 1 }}
                          </div>
                        </div>
                      </div>
                    </transition-group>
                  </div>

                  <div class="w-2/3 h-auto flex-row">
                    <transition-group name="asisten-list" tag="div">
                      <div v-for="(group, index) in listAllGroup" v-bind:key="index"
                        class="animation-enable w-full h-24 flex-row">
                        <div class="w-full h-full flex" :class="[{ 'rounded-tr-lg': index === 0 },
                        { 'rounded-br-lg': index === listAllGroup.length - 1 },
                        { 'bg-gray-600 text-white': index % 2 === 0 }]">
                          <div class="m-auto font-monda text-4xl whitespace-pre-wrap">Kelompok {{ group }}</div>
                        </div>
                      </div>
                    </transition-group>
                  </div>
                </div>
                <div class="w-auto m-auto h-24 items-center font-monda-bold text-2xl flex" v-if="listAllGroup < 1">
                  Tidak ada PRAKTIKAN di kelas ini
                </div>
                <div class="w-auto m-auto h-24 items-center font-merri-bold text-4xl flex" v-if="listAllAsisten.length < 1 &&
                  listAllGroup.length < 1">
                  &
                </div>
                <div class="w-auto m-auto h-24 items-center font-monda-bold text-2xl flex" v-if="listAllAsisten < 1">
                  Tidak ada ASISTEN di kelas ini
                </div>
              </div>

              <div class="w-full h-24 mt-4 mb-8 flex">
                <div class="w-full h-full flex py-4 px-8 hover:px-10 hover:py-5 animation-enable-short cursor-pointer"
                  v-on:click="startThePracticum()">
                  <div class="w-full h-full flex font-monda-bold text-4xl bg-yellow-400 rounded-full">
                    <div class="w-auto select-none h-auto m-auto">
                      START
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ConfirmationModal :open="bigLeaveQuestionShown"
      message="Apakah anda yakin ? (Any changes can't be revert back) <br>Are you sure ? (Semua perubahan tidak bisa dikembalikkan)"
      cancel-label="NOPE (lanjutkan praktikumnya)" confirm-label="YEAH (get me out)"
      @cancel="bigLeaveQuestionShown = false" @confirm="rollbackPraktikum(true)" />

    <ConfirmationModal :open="bigNextQuestionShown" message="Waktu belum selesai !!! <br>Apakah ingin tetap lanjut ?"
      cancel-label="NOPE (Salah pencet)" confirm-label="YEAH (Lanjut ke bagian berikutnya)"
      @cancel="bigNextQuestionShown = false" @confirm="goToNextSection(true)" />

    <ConfirmationModal :open="bigRatingQuestionShown"
      message='Apakah semua praktikan sudah rating ? <br>Jika sudah yakin maka klik "YEAH"'
      cancel-label="NOPE (Salah pencet)" confirm-label="YEAH (Lanjut ke bagian berikutnya)"
      @cancel="bigRatingQuestionShown = false" @confirm="goToNextSection(true)" />
  </div>
</template>

<style>
.asisten-list-enter,
.asisten-list-leave-to {
  opacity: 0;
  transform: translateY(100%);
}

.asisten-list-leave-active {
  position: absolute;
}
</style>

<script>
import moment from 'moment';
import { MENU_ITEMS, PRIVILEGES } from '../constants';
import MenuList from '../components/praktikum/MenuList.vue';
import ConfirmationModal from '../components/praktikum/ConfirmationModal.vue';
import SidebarMenu from '@/components/asisten/SidebarMenu.vue';
import AsistenProfilePanel from '@/components/asisten/ProfilePanel.vue';
import { useToast } from '@/composables/useToast';
import { useSidebarMenu } from '@/composables/useSidebarMenu';
import { useLogout } from '@/composables/useLogout';
const staticMenuDefinitions = [
  { key: 'asisten', label: 'Profil', icon: 'fa-address-card' },
  { key: 'praktikum', label: 'Praktikum', icon: 'fa-code' },
  { key: 'history', label: 'History', icon: 'fa-history' },
  { key: 'nilai', label: 'Nilai', icon: 'fa-clipboard-check' },
  { key: 'polling', label: 'Polling', icon: 'fa-chart-area' },
  { key: 'kelas', label: 'Kelas', icon: 'fa-chalkboard-teacher', privilege: 'kelas' },
  { key: 'soal', label: 'Soal', icon: 'fa-file-code', privilege: 'soal' },
  { key: 'plotting', label: 'Plotting', icon: 'fa-calendar-alt', privilege: 'plotting' },
  { key: 'modul', label: 'Modul', icon: 'fa-book', privilege: 'modul' },
  { key: 'konfigurasi', label: 'Konfigurasi', icon: 'fa-cog', privilege: 'konfigurasi' },
  { key: 'tp', label: 'Tugas Pendahuluan', icon: 'fa-book-open', privilege: 'tp' },
  { key: 'jawaban', label: 'Jawaban', icon: 'fa-tasks', privilege: 'jawaban' },
];

const interactiveMenuDefinitions = [
  { key: 'asisten', label: 'Profil', icon: 'fa-address-card', route: 'asisten' },
  { key: 'praktikum', label: 'Praktikum', icon: 'fa-code', route: null },
  { key: 'history', label: 'History', icon: 'fa-history', route: 'history' },
  { key: 'nilai', label: 'Nilai', icon: 'fa-clipboard-check', route: 'nilai' },
  { key: 'polling', label: 'Polling', icon: 'fa-chart-area', route: 'polling' },
  { key: 'setpraktikan', label: 'Set Praktikan', icon: 'fa-users', route: 'setpraktikan' },
  { key: 'kelas', label: 'Kelas', icon: 'fa-chalkboard-teacher', route: 'kelas', privilege: 'kelas' },
  { key: 'allLaporan', label: 'All Laporan', icon: 'fa-file-medical-alt', route: 'allLaporan', privilege: 'allLaporan' },
  { key: 'soal', label: 'Soal', icon: 'fa-file-code', route: 'soal', privilege: 'soal' },
  { key: 'plotting', label: 'Plotting', icon: 'fa-calendar-alt', route: 'plotting', privilege: 'plotting' },
  { key: 'modul', label: 'Modul', icon: 'fa-book', route: 'modul', privilege: 'modul' },
  { key: 'konfigurasi', label: 'Konfigurasi', icon: 'fa-cog', route: 'konfigurasi', privilege: 'konfigurasi' },
  { key: 'tp', label: 'Tugas Pendahuluan', icon: 'fa-book-open', route: 'tp', privilege: 'tp' },
  { key: 'jawaban', label: 'Jawaban', icon: 'fa-tasks', route: 'jawaban', privilege: 'jawaban' },
  { key: 'pelanggaran', label: 'Pelanggaran', icon: 'fa-radiation-alt', route: 'pelanggaran', privilege: 'pelanggaran' },
  { key: 'rating', label: 'Ranking Praktikan', icon: 'fa-star', route: 'rating', privilege: 'ranking' },
];

import { ref, toRef, toRefs } from 'vue';
import { useNavigation } from '@/composables/useNavigation';

export default {
  components: {
    MenuList,
    ConfirmationModal,
    SidebarMenu,
    AsistenProfilePanel,
  },
  props: [
    'comingFrom',
    'currentUser',
    'position',
    'userRole',
    'allKelas',
    'allModul',
    'isRunmod',
  ],

  setup(props) {
    const menuRef = ref(null);

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: menuRef,
      currentPage: 'praktikum'
    });
    const navigationRefs = toRefs(navigation);

    // Initialize menu state based on comingFrom prop
    navigation.initializeMenu(props.comingFrom, true);
    const toast = useToast();
    const { logoutAsisten } = useLogout();

    const sidebarMenu = useSidebarMenu({
      menuItems: MENU_ITEMS,
      privileges: PRIVILEGES,
      currentUser: toRef(props, 'currentUser'),
      currentPageId: 'praktikum',
      changePage: navigationRefs.changePage,
    });

    // Return all navigation state and methods
    // Wrap menuRef to prevent auto-unwrapping in template
    return {
      toast,
      menuRef,
      menuRefWrapped: { ref: menuRef },
      ...navigationRefs,
      ...sidebarMenu,
      logoutAsisten,
    };
  },

  data() {
    return {
      pageActive: true,
      isMenuShown: false,
      isForbidden: false,
      menuDisabled: false,
      activeMenu: 'praktikum',

      // Note: changePage, currentPage, and all menu* properties now come from useNavigation composable

      listAllAsisten: [],
      listAllPraktikan: [],
      listAllGroup: [],
      totalGroup: '',

      praktikumStart: false,
      countdownStarted: false,
      firstTimeCounting: true,
      bigLeaveQuestionShown: false,
      bigNextQuestionShown: false,
      bigRatingQuestionShown: false,
      soundPlayed: false,

      asistenBanned: [],
      praktikanBanned: [],
      praktikanGroups: [],
      spaceToggled: false,

      oldKelasID: '',
      chosenKelasID: '',
      chosenModulID: '',
      praktikanLeft: '',
      praktikanComplete: '',

      /****************************/
      /*  JENIS STATUS (7 Steps)  */
      /****************************/
      // 0: Just started (First default initialization)
      // 1: Begin TA countdown
      // 2: Go To Jurnal Section
      // 3: Go To Mandiri || presentasi Section  //presentasi made in 2018 in charge (developAND)
      // 4: Go To TK section
      // 5: Open The Laporan Praktikan 
      //    (Tell them to rate the assistant and the prakikum)
      // 6: Open The Laporan PJ and write down the condition of the praktikum
      //    (Only shows "DONE" button for ending the praktikum)
      //    (Dont forget to add data to history_jaga table)
      // 123: Special Case (RunMod Start)
      statusPraktikum: 0,

      formPraktikum: {
        kelas_id: '',
        modul_id: '',
        pj_id: '',
        laporan_id: '',
      },

      formHistoryJaga: {
        allasisten_kode: '',
        hari: '',
        shift: '',
        pj: '',
        asisten_id: '',
      },

      formHistoryIzin_Izin: {
        allasisten_kode: '',
        hari: '',
        shift: '',
        status: 1,
        modul_id: '',
      },

      formHistoryIzin_Sakit: {
        allasisten_kode: '',
        hari: '',
        shift: '',
        status: 2,
        modul_id: '',
      },

      formHistoryIzin_Alfa: {
        allasisten_kode: '',
        hari: '',
        shift: '',
        status: 3,
        modul_id: '',
      },

      formPraktikan_Alfa: {
        allpraktikan_nim: '',
        modul_id: '',
      },

      formCurrentPraktikum: {
        asisten_id: '', //Current Asisten ID (Assuming he/she is the PJ)
        kelas_id: '',
        modul_id: '',
      },

      formLaporanPj: {
        id: '',
        allasisten_id: '',
        hari: '',
        shift: '',
        laporan: '',
        modul_id: '',
      },

      // ***************************************************** //
      // CHANGE THIS PRAKTIKUM TIMING BASED ON YOUR OWN SYSTEM //
      // ***************************************************** //
      TAtiming: moment().startOf('day').add(10, 'minutes'),
      JURNALtiming: moment().startOf('day').add(85, 'minutes'),
      RUNMODtiming: moment().startOf('day').add(40, 'minutes'),
      MANDIRItiming: moment().startOf('day').add(15, 'minutes'),
      TKtiming: moment().startOf('day').add(10, 'minutes'),
      countDown: moment().startOf('day').add(10, 'minutes'), //(TIME IN MILLIS) // Default: Based on TAtiming\
      today: moment().format(),
    }
  },

  computed: {
    time: function () {
      return this.countDown.format('HH : mm : ss');
    }
  },

  mounted() {

    $('body').addClass('closed');

    // Restore scroll position if provided
    if (this.menuRef && this.position) {
      this.menuRef.scrollTop = this.position;
    }

    const globe = this;

    if (this.comingFrom === 'asisten' ||
      this.comingFrom === 'none' ||
      this.comingFrom === 'kelas' ||
      this.comingFrom === 'soal' ||
      this.comingFrom === 'plotting' ||
      this.comingFrom === 'modul' ||
      this.comingFrom === 'konfigurasi' ||
      this.comingFrom === 'tp' ||
      this.comingFrom === 'polling' ||
      this.comingFrom === 'history' ||
      this.comingFrom === 'nilai' ||
      this.comingFrom === 'pelanggaran' ||
      this.comingFrom === 'setpraktikan' ||
      this.comingFrom === 'rating' ||
      this.comingFrom === 'allLaporan' ||
      this.comingFrom === 'jawaban' ||
      this.comingFrom === 'lihat_tp') {

      setTimeout(
        function () {
          globe.currentPage = true;
        }, 10);
    }

    globe.$axios.post('/asisten/praktikum/check').then(response => {

      if (response.data.message === "success") {

        if (response.data.current_praktikum != null) {

          if (response.data.current_praktikum.asisten_id !== globe.currentUser.id) {
            globe.isForbidden = true;
            return;
          }

          //There is currently active praktikum
          globe.formCurrentPraktikum.asisten_id = response.data.current_praktikum.asisten_id;
          globe.formCurrentPraktikum.kelas_id = response.data.current_praktikum.kelas_id;
          globe.formCurrentPraktikum.modul_id = response.data.current_praktikum.modul_id;
          globe.statusPraktikum = response.data.current_praktikum.status;
          globe.chosenKelasID = response.data.current_praktikum.kelas_id;
          globe.chosenModulID = response.data.current_praktikum.modul_id;
          globe.formPraktikum.kelas_id = this.chosenKelasID;
          globe.formPraktikum.modul_id = this.chosenModulID;

          globe.getAllAsistenPraktikan();
          globe.praktikumStart = true;
          globe.menuDisabled = true;

          //(If status Praktikum === 1, means all the layout condition still on its default state)
          switch (globe.statusPraktikum) {
            case 2:
              if (!globe.isRunmod) {
                globe.countDown = globe.JURNALtiming;
              }
              else {
                globe.countDown = globe.RUNMODtiming;
              }

              break;
            case 3:
              globe.countDown = globe.MANDIRItiming;
              break;
            case 4:
              globe.countDown = globe.TKtiming;
              break;
          }

          globe.$axios.post('/asisten/laporan-pj/current').then(response => {

            if (response.data.message === "success") {

              globe.formLaporanPj.id = response.data.latestLaporanID;

            } else {
              globe.toast.error(response.data.message);
            }
          });

          globe.$axios.post('/asisten/history/jaga/latest-pj').then(response => {

            if (response.data.message === "success") {

              globe.formHistoryJaga.hari = response.data.latestPJHistory.hari;
              globe.formHistoryJaga.shift = response.data.latestPJHistory.shift;
              globe.formHistoryJaga.pj = response.data.latestPJHistory.pj;
              globe.formHistoryJaga.asisten_id = response.data.latestPJHistory.asisten_id;
              globe.formHistoryJaga.modul_id = globe.chosenModulID;

            } else {
              globe.toast.error(response.data.message);
            }
          });
        }

      } else {
        globe.toast.error(response.data.message);
      }
    });
  },

  methods: {
    // Note: setCurrentMenu() and travel() methods are now provided by useNavigation composable

    handleMenuSelect(menuKey) {
      // Capture current scroll position before navigation
      const position = this.menuRef?.scrollTop || 0;

      // Navigate with scroll position (travel and setCurrentMenu are available via this)
      this.travel(menuKey, position);
      this.setCurrentMenu(menuKey);
    },

    playSound: function (filename) {

      var mp3Source = '<source src="/assets/' + filename + '.mp3" type="audio/mpeg">';
      var oggSource = '<source src="/assets/' + filename + '.ogg" type="audio/ogg">';
      var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename + '.mp3">';
      document.getElementById("sound").innerHTML = '<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
    },

    countDownTimer: function () {

      const globe = this;
      setInterval(() => {
        if (globe.countdownStarted && !globe.countDown.isSame(moment().startOf('day')))
          globe.countDown = moment(globe.countDown.subtract(1, 'seconds'))
        else if (globe.countdownStarted && globe.countDown.isSame(moment().startOf('day')) && !globe.soundPlayed) {

          globe.playSound("completeSound");
          globe.soundPlayed = true;
        } else
          globe.countdownStarted = false;
      }, 1000);
    },

    goToNextSection: function ($force) {
      const globe = this;
      if (!$force) {

        if (!globe.countDown.isSame(moment().startOf('day')) &&
          globe.statusPraktikum !== 5 &&
          globe.statusPraktikum !== 6) {
          globe.bigNextQuestionShown = true;
          return;
        }

        if (globe.statusPraktikum === 5) {
          globe.bigRatingQuestionShown = true;
          return;
        }

        if (globe.statusPraktikum === 6) {

          var sumAllAsisten_kode = [];

          if (globe.formHistoryJaga.allasisten_kode !== '') {
            var tempArr = globe.formHistoryJaga.allasisten_kode.split("-");
            for (let index = 0; index < tempArr.length; index++) {
              const data = tempArr[index];
              if (data === "") {
                globe.toast.error('Tidak perlu tanda "-" pada awal dan akhir isian');
                return;
              }
            }
            sumAllAsisten_kode.push(globe.formHistoryJaga.allasisten_kode.split("-"));
          }

          if (globe.formHistoryIzin_Izin.allasisten_kode !== '') {
            var tempArr = globe.formHistoryIzin_Izin.allasisten_kode.split("-");
            for (let index = 0; index < tempArr.length; index++) {
              const data = tempArr[index];
              if (data === "") {
                globe.toast.error('Tidak perlu tanda "-" pada awal dan akhir isian');
                return;
              }
            }
            sumAllAsisten_kode.push(globe.formHistoryIzin_Izin.allasisten_kode.split("-"));
          }

          if (globe.formHistoryIzin_Sakit.allasisten_kode !== '') {
            var tempArr = globe.formHistoryIzin_Sakit.allasisten_kode.split("-");
            for (let index = 0; index < tempArr.length; index++) {
              const data = tempArr[index];
              if (data === "") {
                globe.toast.error('Tidak perlu tanda "-" pada awal dan akhir isian');
                return;
              }
            }
            sumAllAsisten_kode.push(globe.formHistoryIzin_Sakit.allasisten_kode.split("-"));
          }

          if (globe.formHistoryIzin_Alfa.allasisten_kode !== '') {
            var tempArr = globe.formHistoryIzin_Alfa.allasisten_kode.split("-");
            for (let index = 0; index < tempArr.length; index++) {
              const data = tempArr[index];
              if (data === "") {
                globe.toast.error('Tidak perlu tanda "-" pada awal dan akhir isian');
                return;
              }
            }
            sumAllAsisten_kode.push(globe.formHistoryIzin_Alfa.allasisten_kode.split("-"));
          }

          var sumAllPraktikan_Alfa = [];
          if (globe.formPraktikan_Alfa.allpraktikan_nim !== '') {
            var tempArr = globe.formPraktikan_Alfa.allpraktikan_nim.split("-");
            for (let index = 0; index < tempArr.length; index++) {
              const data = tempArr[index];
              if (data === "") {
                globe.toast.error('Tidak perlu tanda "-" pada awal dan akhir isian');
                return;
              }
            }
            sumAllPraktikan_Alfa.push(globe.formPraktikan_Alfa.allpraktikan_nim.split("-"));
          }

          sumAllAsisten_kode = [].concat.apply([], sumAllAsisten_kode); // Flatten array of arrays
          sumAllAsisten_kode = sumAllAsisten_kode.map(function (x) { return x.toUpperCase() }) // Convert all string to uppercase

          let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index); // Checking for duplicates
          if (findDuplicates(sumAllAsisten_kode).length > 0) {
            globe.toast.error("Satu asisten tidak boleh berada dalam kolom yang berbeda");
            return;
          }

          if (sumAllAsisten_kode.length === 0) {
            globe.toast.error("Isi data terlebih dahulu");
            return;
          }

          if (sumAllPraktikan_Alfa.length === 0 && globe.formPraktikan_Alfa.allpraktikan_nim !== "*") {
            globe.toast.error("Ketikkan '*' pada praktikan alfa jika tidak ada praktikan yang alfa");
            return;
          } else if (globe.formPraktikan_Alfa.allpraktikan_nim !== "*") {

            for (let index = 0; index < sumAllPraktikan_Alfa.length; index++) {
              const praktikan = sumAllPraktikan_Alfa[index];

              var isExist = false;
              globe.listAllPraktikan.forEach(allPraktikan => {
                if (allPraktikan.nim == praktikan)
                  isExist = true;
              });

              if (!isExist) {
                globe.toast.error('Praktikan dengan nim "' + praktikan + '" tidak ada dalam kelas ini');
                return;
              }
            }
          }

          if (sumAllAsisten_kode.includes(globe.currentUser.kode)) {
            globe.toast.error("Asisten PJ tidak perlu ditulis disini");
            return;
          }

          var listAllAsistenKode = [];
          globe.listAllAsisten.forEach(asisten => {
            if (asisten.kode != globe.currentUser.kode)
              listAllAsistenKode.push(asisten.kode);
          });

          let diff_FromList = sumAllAsisten_kode.filter(x => !listAllAsistenKode.includes(x));
          let diff_FromSum = listAllAsistenKode.filter(x => !sumAllAsisten_kode.includes(x));

          for (let index = 0; index < diff_FromList.length; index++) {
            const element = diff_FromList[index];

            if (sumAllAsisten_kode.includes(element)) {
              globe.toast.error("Asisten " + diff_FromList + " tidak ada dalam praktikum ini");
              return;
            }
          }

          for (let index = 0; index < diff_FromSum.length; index++) {
            const element = diff_FromSum[index];
            if (listAllAsistenKode.includes(element)) {
              globe.toast.error("Asisten " + diff_FromSum + " belum dimasukkan");
              return;
            }
          }

          globe.allKelas.forEach(kelas => {
            if (kelas.id === globe.chosenKelasID) {
              globe.formHistoryJaga.hari = kelas.hari;
              globe.formHistoryJaga.shift = kelas.shift;
              globe.formHistoryIzin_Izin.hari = kelas.hari;
              globe.formHistoryIzin_Izin.shift = kelas.shift;
              globe.formHistoryIzin_Sakit.hari = kelas.hari;
              globe.formHistoryIzin_Sakit.shift = kelas.shift;
              globe.formHistoryIzin_Alfa.hari = kelas.hari;
              globe.formHistoryIzin_Alfa.shift = kelas.shift;
            }
          });

          globe.formHistoryJaga.pj = 0;
          globe.formHistoryJaga.asisten_id = null;
          globe.formHistoryJaga.modul_id = globe.chosenModulID;
          globe.formHistoryIzin_Izin.modul_id = globe.chosenModulID;
          globe.formHistoryIzin_Sakit.modul_id = globe.chosenModulID;
          globe.formHistoryIzin_Alfa.modul_id = globe.chosenModulID;

          globe.$axios.post('/asisten/history/jaga', globe.formHistoryJaga).then(response => {

            if (response.data.message === "success") {

              globe.$axios.post('/asisten/history/izin', globe.formHistoryIzin_Izin).then(response => {

                if (response.data.message === "success") {

                  globe.$axios.post('/asisten/history/izin', globe.formHistoryIzin_Sakit).then(response => {

                    if (response.data.message === "success") {

                      globe.$axios.post('/asisten/history/izin', globe.formHistoryIzin_Alfa).then(response => {

                        if (response.data.message === "success") {

                          if (globe.formPraktikan_Alfa.allpraktikan_nim !== '*') {

                            globe.formPraktikan_Alfa.modul_id = globe.chosenModulID;
                            globe.$axios.delete('/asisten/praktikan/alfa', { data: globe.formPraktikan_Alfa }).then(response => {

                              if (response.data.message === "success") {
                                // Do nothing as its working as it supposed to be

                              } else {
                                globe.toast.error(response.data.message);
                              }
                            });
                          }

                          globe.$axios.put('/asisten/laporan-pj', globe.formLaporanPj).then(response => {

                            if (response.data.message === "success") {

                              globe.formPraktikum.pj_id = globe.currentUser.id;
                              globe.formPraktikum.laporan_id = globe.formLaporanPj.id;
                              globe.$axios.post('/asisten/praktikum', globe.formPraktikum).then(response => {

                                if (response.data.message === "success") {

                                  globe.toast.success("Praktikum berhasil tersimpan");

                                } else {
                                  globe.toast.error(response.data.message);
                                }
                              });
                              globe.$axios.delete('/asisten/praktikum/stop').then(response => {

                                globe.praktikumStart = false;
                                globe.statusPraktikum = 0;
                                globe.menuDisabled = false;
                              });

                            } else {
                              globe.toast.error(response.data.message);
                            }
                          });

                        } else {
                          globe.toast.error(response.data.message);
                        }
                      });

                    } else {
                      globe.toast.error(response.data.message);
                    }
                  });

                } else {
                  globe.toast.error(response.data.message);
                }
              });

            } else {
              globe.toast.error(response.data.message);
            }
          });
        }
      }

      globe.bigNextQuestionShown = false;
      globe.bigRatingQuestionShown = false;
      globe.soundPlayed = false;
      globe.countdownStarted = false;

      globe.statusPraktikum++;

      globe.$axios.put('/asisten/praktikum/continue/' + globe.statusPraktikum).then(response => {

        if (response.data.message === "success") {
          //DO NOTHING (it runs as we expected)

        } else {
          globe.toast.error(response.data.message);
        }
      });

      //(If status Praktikum === 1, means all the layout condition still on its default state)
      switch (globe.statusPraktikum) {
        case 2:
          if (!globe.isRunmod) {
            globe.countDown = globe.JURNALtiming;
          }
          else {
            globe.countDown = globe.RUNMODtiming;
          }
          break;
        case 3:
          globe.countDown = globe.MANDIRItiming;
          break;
        case 4:
          globe.countDown = globe.TKtiming;
          break;
      }
    },

    rollbackPraktikum: function ($force) {

      const globe = this;

      if (!$force) {
        if (!globe.firstTimeCounting) {
          globe.bigLeaveQuestionShown = true;
          return;
        }
      } else
        globe.bigLeaveQuestionShown = false;

      globe.countdownStarted = false;
      globe.bigNextQuestionShown = false;
      globe.bigRatingQuestionShown = false;

      globe.firstTimeCounting = true;
      globe.praktikumStart = false;
      globe.soundPlayed = false;
      globe.statusPraktikum = 0;
      globe.menuDisabled = false;
      globe.$axios.delete('/asisten/praktikum/stop');
      globe.$axios.delete('/asisten/laporan-pj/' + globe.formLaporanPj.id);
      globe.$axios.delete('/asisten/history/jaga', { data: globe.formHistoryJaga }).then(response => {

        if (response.data.message === "success") {
          //DO NOTHING (it runs as we expected)

        } else {
          globe.toast.error(response.data.message);
        }
      });
    },

    startCountdown: function () {

      this.countdownStarted = true;
      const globe = this;

      if (this.statusPraktikum === 0) {

        this.statusPraktikum = 1;

        globe.$axios.put('/asisten/praktikum/continue/' + globe.statusPraktikum).then(response => {

          if (response.data.message === "success") {
            //DO NOTHING (it runs as we expected)

          } else {
            globe.toast.error(response.data.message);
          }
        });
      }

      if (this.firstTimeCounting) {
        this.countDownTimer(); // THIS IS FOR STARTING THE COUNTDOWN
        this.firstTimeCounting = false;
      }
    },

    pauseCountdown: function () {

      this.countdownStarted = false;
    },

    startThePracticum: function () {

      const globe = this;

      globe.$axios.post('/praktikum/check').then(response => {
        if (response.data.message === "success") {
          if (response.data.current_praktikum != null) {
            if (response.data.current_praktikum.asisten_id !== globe.currentUser.id) {
              globe.isForbidden = true;
              return;
            }
          }
        } else {

          globe.toast.error(response.data.message);
        }
      });

      if (this.chosenKelasID === "") {

        globe.toast.error("Pilih kelas terlebih dahulu");
        return;
      }

      if (this.listAllAsisten.length < 1) {

        globe.toast.error("Tidak terdapat asisten di kelas ini");
        return;
      }

      if (this.listAllPraktikan.length < 1) {

        globe.toast.error("Tidak terdapat praktikan di kelas ini");
        return;
      }

      if (this.chosenModulID === '') {

        globe.toast.error("Pilih modul terlebih dahulu");
        return;
      }

      var isKodeExist = false;
      globe.listAllAsisten.forEach(element => {
        if (element.kode === globe.currentUser.kode)
          isKodeExist = true;
      });

      if (!isKodeExist) {

        globe.toast.error("Anda tidak ada dalam praktikum kelas ini. Hanya asisten dalam praktikum ini yang bisa mengaktivasinya");
        return;
      }

      this.formPraktikum.kelas_id = this.chosenKelasID;
      this.formPraktikum.modul_id = this.chosenModulID;
      this.$axios.post('/asisten/praktikum/check', this.formPraktikum).then(response => {

        if (response.data.message === "success") {

          globe.allKelas.forEach(kelas => {
            if (kelas.id === globe.chosenKelasID) {
              globe.formLaporanPj.hari = kelas.hari;
              globe.formLaporanPj.shift = kelas.shift;
            }
          });
          globe.formLaporanPj.laporan = "Tanggal: " + moment().format('ll') + "          Mulai: " + moment().format('LT') + "      Selesai: .....";
          globe.formLaporanPj.allasisten_id = "";
          for (let index = 0; index < globe.listAllAsisten.length; index++) {
            const element = globe.listAllAsisten[index];
            globe.formLaporanPj.allasisten_id += element.id;
            if (index != globe.listAllAsisten.length - 1)
              globe.formLaporanPj.allasisten_id += "-";
          }
          globe.formLaporanPj.modul_id = this.chosenModulID;

          globe.$axios.post('/asisten/laporan-pj', globe.formLaporanPj).then(response => {

            if (response.data.message === "success") {

              globe.formLaporanPj.id = response.data.id;
              globe.praktikumStart = true;

            } else {
              globe.toast.error(response.data.message);
            }
          });

          globe.formCurrentPraktikum.kelas_id = globe.chosenKelasID;
          globe.formCurrentPraktikum.modul_id = globe.chosenModulID;
          globe.formCurrentPraktikum.asisten_id = globe.currentUser.id;
          globe.$axios.post('/asisten/praktikum/start', globe.formCurrentPraktikum).then(response => {

            if (response.data.message === "success") {
              globe.menuDisabled = true;

            } else {
              globe.toast.error(response.data.message);
            }
          });

          globe.allKelas.forEach(kelas => {
            if (kelas.id === globe.chosenKelasID) {
              globe.formHistoryJaga.hari = kelas.hari;
              globe.formHistoryJaga.shift = kelas.shift;
            }
          });
          globe.formHistoryJaga.pj = 1;
          globe.formHistoryJaga.asisten_id = globe.currentUser.id;
          globe.formHistoryJaga.modul_id = globe.chosenModulID;
          globe.$axios.post('/asisten/history/jaga', globe.formHistoryJaga).then(response => {

            if (response.data.message === "success") {
              //DO NOTHING (it runs as we expected)

            } else {
              globe.toast.error(response.data.message);
            }
          });

        } else {
          globe.toast.error(response.data.message);
        }
      });
    },

    toggleSpace: function ($spaceString) {

      const globe = this;
      globe.spaceToggled = true;

      if (parseInt($spaceString.substring(0, 1)) == 3) {

        /********************/
        /* Toggling Asisten */
        /********************/

        let kodeAsisten = document.getElementById('asisten-' + $spaceString).innerHTML

        // Banning the current clicked asisten space (if exist)
        if (kodeAsisten != '') {

          globe.asistenBanned.push({
            kode: kodeAsisten
          })

          document.getElementById('asisten-' + $spaceString).innerHTML = "";
        } else if (globe.asistenBanned.length > 0) {

          // Un Banning random asisten to current clicked space (if there any)

          let randomedId = Math.floor(Math.random() * globe.asistenBanned.length)

          document.getElementById('asisten-' + $spaceString).innerHTML = globe.asistenBanned[randomedId].kode;

          globe.asistenBanned.splice(randomedId, 1);
        }

      } else if (parseInt($spaceString.substring(0, 1)) == 1 || parseInt($spaceString.substring(0, 1)) == 2) {

        /**********************/
        /* Toggling Praktikan */
        /**********************/

        let nimPraktikan = document.getElementById('praktikan-' + $spaceString).innerHTML

        // Banning the current clicked praktikan space (if exist)
        if (nimPraktikan != '') {

          globe.praktikanBanned.push({
            nim: nimPraktikan
          })

          document.getElementById('praktikan-' + $spaceString).innerHTML = "";
        } else if (globe.praktikanBanned.length > 0) {

          // Un Banning random praktikan to current clicked space (if there any)

          let randomedId = Math.floor(Math.random() * globe.praktikanBanned.length)

          document.getElementById('praktikan-' + $spaceString).innerHTML = globe.praktikanBanned[randomedId].nim;

          globe.praktikanBanned.splice(randomedId, 1);
        }
      }
    },

    getAllAsistenPraktikan: function () {

      const globe = this;
      if (this.chosenKelasID === "" || this.chosenKelasID === this.oldKelasID)
        return;

      this.oldKelasID = this.chosenKelasID;

      this.$axios.post('/asisten/kelas/' + this.chosenKelasID).then(response => {

        if (response.data.message === "success") {

          globe.listAllAsisten = response.data.all_asisten;
          globe.listAllPraktikan = response.data.all_praktikan;
          globe.praktikanLeft = response.data.all_praktikan.length % response.data.all_asisten.length;
          globe.praktikanComplete = parseInt(response.data.all_praktikan.length / response.data.all_asisten.length);
          globe.totalGroup = response.data.totalGroup;
          globe.listAllGroup = [];

          for (var i = 0; i < globe.totalGroup[0].totalGroup; i++) {
            globe.listAllGroup.push(i + 1);
          }

          // Set praktikanGroups array size to match with listAllAsisten.length
          for (var i = 0; i < globe.listAllAsisten.length; i++) {
            globe.praktikanGroups.push([]);
          }

          // Group every praktikan inside praktikanGroups
          for (var i = 0; i < globe.listAllAsisten.length; i++)
            for (var j = 0; j < globe.listAllPraktikan.length; j++)
              if (globe.praktikanGroups[i].length < 3)
                globe.praktikanGroups[i].push({
                  nim: globe.listAllPraktikan[(3 * i) + j].nim
                })
              else
                continue;

        } else {
          globe.toast.error(response.data.message);
        }
      }).catch(function (error) {
        if (error.response) {
          globe.toast.error(error.response.data);
        }
      });
    },

    signOut: function () {
      this.pageActive = false;
      this.currentPage = false;
      setTimeout(async () => {
        await this.logoutAsisten();
      }, 1010);
    },
  }
}
</script>
