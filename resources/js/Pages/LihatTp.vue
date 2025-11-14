<template>
  <div class="bg-green-900 w-full h-full overflow-hidden">

    <!-- Main Menu -->
    <SidebarMenu
      :page-active="pageActive"
      :items="visibleMenuItems"
      :menu-container-class="menuContainerClass"
      :highlighted-menu="highlightedMenu"
      :menu-ref="menuRefWrapped.ref"
      @hover="isMenuShown = false"
      @select="handleMenuSelect"
    />

    <!-- Profile Menu -->
    <AsistenProfilePanel
      :page-active="pageActive"
      :is-menu-shown="isMenuShown"
      :current-user="currentUser"
      :user-role="userRole"
      @update:isMenuShown="isMenuShown = $event"
      @sign-out="signOut"
    />

    <div class="absolute h-full w-120full animation-enable"
        :class="[{ 'left-minFull': !currentPage },
                { 'left-0': currentPage }]">
      <div class="w-full h-full overflow-hidden flex flex-col">

        <div v-if="tpSearchHistory.length" class="px-6 pt-6">
          <div class="bg-green-800/70 border border-green-700 rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between gap-4">
              <span class="font-merri text-yellow-300 text-lg">Riwayat pencarian</span>
              <span class="text-sm font-overpass text-green-200">Klik salah satu untuk menampilkan ulang</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <div
                v-for="search in tpSearchHistory"
                :key="search.id"
                class="flex items-center gap-2 rounded-full border border-green-600 bg-green-700/60 px-4 py-2 transition"
                :class="{
                  'ring-2 ring-yellow-400 bg-green-700': search.id === activeSearchId,
                  'cursor-pointer hover:bg-green-700': true,
                }"
                @click="activateSavedSearch(search.id)"
              >
                <span class="text-sm font-monda-bold text-yellow-200">
                  {{ search.nim }} - {{ search.modulTitle }}
                </span>
                <button
                  class="text-xs font-overpass-mono-bold text-yellow-200 hover:text-white transition"
                  @click="refreshSavedSearch(search.id, $event)"
                >
                  Refresh
                </button>
                <button
                  class="text-xs font-overpass-mono-bold text-red-300 hover:text-red-100 transition"
                  @click="removeSavedSearch(search.id, $event)"
                >
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="tpDataShown" class="px-6 pt-4">
          <div class="flex flex-col items-stretch justify-end gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-y-2">
            <button
              v-if="activeSearchId"
              class="bg-green-700 hover:bg-green-600 text-yellow-100 font-overpass-mono-bold text-sm rounded-full px-5 py-2 transition disabled:cursor-not-allowed disabled:opacity-60"
              :disabled="isLoading"
              @click="refreshActiveSearch"
            >
              {{ isLoading ? 'Memuat...' : 'Refresh' }}
            </button>
            <button
              class="bg-yellow-400 hover:bg-yellow-300 text-green-900 font-monda-bold text-sm rounded-full px-5 py-2 transition"
              @click="resetSearch"
            >
              Cari lagi
            </button>
          </div>
        </div>

        <div v-if="tpDataShown" class="px-6">
          <div class="w-full rounded-2xl bg-green-600 shadow-xl sm:flex sm:flex-row sm:items-stretch overflow-hidden">
            <div class="sm:w-1/3 w-full px-6 py-4 flex items-center justify-center border-b sm:border-b-0 sm:border-r border-green-500/60">
              <span class="font-overpass-bold text-yellow-200 text-lg">{{ praktikanNim !== '' ? praktikanNim : 'none' }}</span>
            </div>
            <div class="sm:w-1/3 w-full px-6 py-4 flex items-center justify-center border-b sm:border-b-0 sm:border-r border-green-500/60">
              <span class="font-overpass-bold text-yellow-200 text-lg text-center">{{ selectedModulTitle }}</span>
            </div>
            <div class="sm:w-1/3 w-full px-6 py-4 flex items-center justify-center">
              <span class="font-overpass text-sm text-green-100" v-if="activeSearchTimestampLabel !== ''">
                Terakhir diperbarui {{ activeSearchTimestampLabel }}
              </span>
              <span class="font-overpass text-sm text-green-100" v-else>
                Belum ada riwayat
              </span>
            </div>
          </div>
        </div>

        <div class="w-full flex-1 overflow-hidden"
            :class="[{ 'hidden': !tpDataShown },
                      { 'visible': tpDataShown }]">
          <div class="w-full h-full max-h-full px-6 pb-10 overflow-y-auto" v-scrollbar>
            <div v-if="allTpData.length === 0" class="w-full h-full flex items-center justify-center">
              <span class="font-merri text-green-100 text-lg">Belum ada data TP untuk pencarian ini.</span>
            </div>
            <div v-else>
              <div class="w-full h-auto flex-row">
                <div v-for="(jawaban, index) in allTpData" :key="jawaban.id"
                    class="w-full flex-row h-auto">
                  <div class="w-full h-auto flex my-10">
                    <div class="h-full w-12 flex font-merri-bold text-sm sm:text-xl text-white">
                      <div class="m-auto w-auto h-auto">{{ index + 1 }}</div>
                    </div>
                    <div class="h-12 px-1 w-4">
                      <div class="h-full w-full bg-white" />
                    </div>
                    <div class="h-full w-16full break-words whitespace-pre-wrap flex px-2 font-monda text-lg sm:text-2xl text-white">
                      <span>{{ jawaban.soal }}</span>
                    </div>
                  </div>
                  <div class="w-full h-auto flex px-5">
                    <textarea v-model="allTpData[index].jawaban" cols="30" rows="10"
                          class="font-overpass-mono-bold resize-none text-lg sm:text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                          type="text" disabled />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full flex-1 py-4 flex"
            :class="[{ 'visible': !tpDataShown },
                      { 'hidden': tpDataShown }]">
          <div class="w-72 h-72 m-auto">
            <div class="w-full h-full flex-row">
              <div class="w-full py-2 px-5 h-1/4 flex-row">
                <span class="font-merri w-full text-left text-yellow-400 text-lg h-1/4">
                  NIM
                </span>
                <div class="w-full h-3/4">
                  <input v-model="praktikanNim"
                        class="font-overpass-mono-bold text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                        id="Kelas" type="text" placeholder="101022130600">
                </div>
              </div>
              <div class="w-full h-1/4 flex-row py-2 px-5">
                <span class="font-merri w-full text-left text-yellow-400 text-lg h-1/4">
                  Pilihan modul
                </span>
                <select v-model="chosenModulID"
                      class="block font-monda-bold text-xl appearance-none w-full h-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-teal-500">
                  <option class="hidden" value="" disabled selected>
                    Pilih modul
                  </option>
                  <option v-for="modul in allModul" :key="modul.id" :value="modul.id" :disabled="!modul.id">
                    {{ modul.judul }}
                  </option>
                </select>
              </div>
              <div class="w-full h-1/4 mt-8 p-2 animation-enable-short flex"
                  :class="[{ 'hover:p-3 cursor-pointer': !isLoading }, { 'opacity-60 cursor-wait': isLoading }]"
                  @click="cekTpPraktikan">
                <div class="w-full h-full bg-green-600 rounded-lg flex">
                  <div class="w-auto h-auto m-auto font-monda-bold text-white text-2xl">
                    <span>{{ isLoading ? 'MENCARI...' : 'CEK TP' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { MENU_ITEMS, PRIVILEGES } from '../constants';
import { ref, toRef, toRefs } from 'vue';
import { useNavigation } from '@/composables/useNavigation';
import { useToast } from '@/composables/useToast';
import { useSidebarMenu } from '@/composables/useSidebarMenu';
import { useLogout } from '@/composables/useLogout';
import SidebarMenu from '@/components/asisten/SidebarMenu.vue';
import AsistenProfilePanel from '@/components/asisten/ProfilePanel.vue';

const HISTORY_STORAGE_KEY = 'lihat_tp_history_v1';
const HISTORY_LIMIT = 3;

export default {
  props: [
    'comingFrom',
    'currentUser',
    'position',
    'userRole',
    'allModul',
  ],

  components: {
    SidebarMenu,
    AsistenProfilePanel,
  },

  setup(props) {
    const menuRef = ref(null);

    const navigation = useNavigation({
      userType: 'asisten',
      menuRef,
      currentPage: 'lihat_tp',
    });
    const navigationRefs = toRefs(navigation);

    navigation.initializeMenu(props.comingFrom, true);
    const toast = useToast();
    const { logoutAsisten } = useLogout();

    const sidebarMenu = useSidebarMenu({
      menuItems: MENU_ITEMS,
      privileges: PRIVILEGES,
      currentUser: toRef(props, 'currentUser'),
      currentPageId: 'lihat_tp',
      changePage: navigationRefs.changePage,
    });

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
      privileges: { ...PRIVILEGES },

      soalPriviledge: 'all',

      pageActive: true,
      isMenuShown: false,

      praktikanNim: '',
      chosenModulID: '',

      tpDataShown: false,
      allTpData: [],
      tpSearchHistory: [],
      activeSearchId: null,
      isLoading: false,
    };
  },

  computed: {
    activeSearchEntry() {
      if (! this.activeSearchId) {
        return null;
      }

      return this.tpSearchHistory.find(item => item.id === this.activeSearchId) ?? null;
    },

    activeSearchTimestampLabel() {
      if (! this.activeSearchEntry?.updatedAt) {
        return '';
      }

      try {
        return new Date(this.activeSearchEntry.updatedAt).toLocaleString();
      } catch (error) {
        return this.activeSearchEntry.updatedAt;
      }
    },

    selectedModulTitle() {
      const modulId = Number(this.chosenModulID);

      if (! modulId) {
        return 'none';
      }

      const modul = this.allModul?.find(item => Number(item.id) === modulId);

      if (modul) {
        return modul.judul;
      }

      return this.activeSearchEntry?.modulTitle ?? 'none';
    },
  },

  mounted() {
    $('body').addClass('closed');

    this.loadSearchHistory();

    if (this.menuRef && this.position != null) {
      this.$nextTick(() => {
        const target = Number(this.position) || 0;

        if (this.menuRef && this.menuRef.scrollTop !== undefined) {
          this.menuRef.scrollTop = target;
        }
      });
    }

    const globe = this;

    if (
      this.comingFrom === 'asisten' ||
      this.comingFrom === 'none' ||
      this.comingFrom === 'soal' ||
      this.comingFrom === 'modul' ||
      this.comingFrom === 'praktikum' ||
      this.comingFrom === 'plotting' ||
      this.comingFrom === 'kelas' ||
      this.comingFrom === 'tp' ||
      this.comingFrom === 'polling' ||
      this.comingFrom === 'konfigurasi' ||
      this.comingFrom === 'nilai' ||
      this.comingFrom === 'pelanggaran' ||
      this.comingFrom === 'history' ||
      this.comingFrom === 'rating' ||
      this.comingFrom === 'allLaporan' ||
      this.comingFrom === 'jawaban' ||
      this.comingFrom === 'lihat_tp'
    ) {
      setTimeout(() => {
        globe.currentPage = true;
      }, 10);
    }
  },

  methods: {
    handleMenuSelect(target) {
      this.setActiveMenu(target);
      this.travel(target);
    },

    cekTpPraktikan() {
      if (this.isLoading) {
        return;
      }

      if (this.praktikanNim === '') {
        this.toast.error('Isikan nim nya terlebih dahulu');
        return;
      }

      if (this.chosenModulID === '') {
        this.toast.error('Pilih modul nya terlebih dahulu');
        return;
      }

      this.performSearch(this.praktikanNim, this.chosenModulID, { persist: true });
    },

    performSearch(nim, modulId, { persist = true } = {}) {
      const normalizedModulId = String(modulId ?? '');
      this.isLoading = true;

      this.$axios.post(`/api/get-tp/${nim}/${normalizedModulId}`).then(response => {
        if (response.data.message === 'success') {
          const answers = Array.isArray(response.data.all_tp) ? response.data.all_tp : [];
          this.tpDataShown = true;
          this.praktikanNim = nim;
          this.chosenModulID = normalizedModulId;
          this.allTpData = this.cloneAnswers(answers);

          if (persist) {
            const modulTitle = this.resolveModulTitle(normalizedModulId);
            this.saveSearchResult(nim, normalizedModulId, modulTitle, answers);
          } else {
            this.activeSearchId = `${nim}-${normalizedModulId}`;
          }
        } else {
          this.toast.error(response.data.message);
        }
      }).catch(() => {
        this.toast.error('Terjadi kesalahan saat mengambil data TP');
      }).finally(() => {
        this.isLoading = false;
      });
    },

    resolveModulTitle(modulId) {
      const modul = this.allModul?.find(item => String(item.id) === String(modulId));

      if (modul) {
        return modul.judul;
      }

      const fromHistory = this.tpSearchHistory.find(item => item.modulId === String(modulId));

      return fromHistory?.modulTitle ?? 'Modul';
    },

    saveSearchResult(nim, modulId, modulTitle, answers) {
      const id = `${nim}-${modulId}`;
      const existingIndex = this.tpSearchHistory.findIndex(item => item.id === id);
      const entry = {
        id,
        nim,
        modulId: String(modulId),
        modulTitle,
        answers: this.cloneAnswers(answers),
        updatedAt: new Date().toISOString(),
      };

      if (existingIndex !== -1) {
        this.tpSearchHistory.splice(existingIndex, 1);
      }

      this.tpSearchHistory.unshift(entry);

      if (this.tpSearchHistory.length > HISTORY_LIMIT) {
        this.tpSearchHistory = this.tpSearchHistory.slice(0, HISTORY_LIMIT);
      }

      this.persistSearchHistory();
      this.activeSearchId = entry.id;
    },

    loadSearchHistory() {
      if (typeof window === 'undefined' || ! window.localStorage) {
        return;
      }

      try {
        const raw = window.localStorage.getItem(HISTORY_STORAGE_KEY);

        if (! raw) {
          return;
        }

        const parsed = JSON.parse(raw);

        if (Array.isArray(parsed)) {
          this.tpSearchHistory = parsed.map(entry => ({
            id: entry.id,
            nim: entry.nim,
            modulId: String(entry.modulId),
            modulTitle: entry.modulTitle,
            answers: this.cloneAnswers(entry.answers ?? []),
            updatedAt: entry.updatedAt ?? null,
          }));
        }
      } catch (error) {
        console.error('Failed to load TP history', error);
        this.tpSearchHistory = [];
      }
    },

    persistSearchHistory() {
      if (typeof window === 'undefined' || ! window.localStorage) {
        return;
      }

      try {
        window.localStorage.setItem(HISTORY_STORAGE_KEY, JSON.stringify(this.tpSearchHistory));
      } catch (error) {
        console.error('Failed to store TP history', error);
      }
    },

    activateSavedSearch(id) {
      const entry = this.tpSearchHistory.find(item => item.id === id);

      if (! entry) {
        return;
      }

      this.activeSearchId = entry.id;
      this.praktikanNim = entry.nim;
      this.chosenModulID = String(entry.modulId);
      this.tpDataShown = true;
      this.allTpData = this.cloneAnswers(entry.answers ?? []);
    },

    refreshSavedSearch(id, event) {
      if (event) {
        event.stopPropagation();
      }

      const entry = this.tpSearchHistory.find(item => item.id === id);

      if (! entry || this.isLoading) {
        return;
      }

      this.performSearch(entry.nim, entry.modulId, { persist: true });
    },

    refreshActiveSearch() {
      if (! this.activeSearchId) {
        return;
      }

      this.refreshSavedSearch(this.activeSearchId);
    },

    resetSearch() {
      this.tpDataShown = false;
      this.allTpData = [];
      this.praktikanNim = '';
      this.chosenModulID = '';
      this.activeSearchId = null;
    },

    removeSavedSearch(id, event) {
      if (event) {
        event.stopPropagation();
      }

      const index = this.tpSearchHistory.findIndex(item => item.id === id);

      if (index === -1) {
        return;
      }

      this.tpSearchHistory.splice(index, 1);
      this.persistSearchHistory();

      if (this.activeSearchId === id) {
        this.resetSearch();
      }
    },

    cloneAnswers(answers) {
      return JSON.parse(JSON.stringify(Array.isArray(answers) ? answers : []));
    },

    signOut() {
      this.pageActive = false;
      this.currentPage = false;
      setTimeout(async () => {
        await this.logoutAsisten();
      }, 1010);
    },
  },
};
</script>