<template>
  <div class="bg-green-900 w-full h-full overflow-hidden">

    <!-- Main Menu -->
    <SidebarMenu
      :page-active="pageActive"
      :items="visibleMenuItems"
      :menu-container-class="menuContainerClass"
      :highlighted-menu="highlightedMenu"
      :menu-ref="menuRef"
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

    <div class="absolute h-full w-120full animation-enable flex flex-row"
        :class="[{ 'left-minFull': !currentPage },
                { 'left-0': currentPage }]">
      <div class="h-full w-36">
        <div v-if="listJenisPollings.length > 0" 
            class="w-full h-full" v-scrollbar>
          <div>
            <div v-for="(polling) in listJenisPollings" v-bind:key="polling.id" 
                class="animation-enable w-auto h-10 flex m-4"
                v-on:click="openPollingList(polling.judul)">
              <div class="w-full h-full rounded-sm p-2 flex cursor-pointer hover:font-bold hover:bg-green-500"
                  :class="[{ 'font-bold bg-green-600 text-white' : currentActivePolling == polling.id },
                  { 'font-normal bg-green-400 text-black' : currentActivePolling != polling.id }]">
                <div class="w-auto h-auto m-auto font-overpass">
                  <span>{{ polling.judul }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="h-full w-36full">
        <div v-if="currentPollingList.length > 0" 
            class="w-full h-full" v-scrollbar>
          <div>
            <transition-group name="polling-list" tag="div">
              <div v-for="(polling, index) in currentPollingList" v-bind:key="polling.id" 
                  class="animation-enable w-auto h-full flex m-4">
                <span class="text-white"
                  :class="[{ 'font-monda-bold text-xl' : index == 0 },
                          { 'font-monda text-lg' : index != 0 }]">
                  {{ index+1 }}. {{ polling.kode }} dengan total vote ({{ polling.jumlah_poll }})
                </span>
              </div>
            </transition-group>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.polling-list-enter, .polling-list-leave-to{
  opacity: 0;
  transform: translateX(-100%);
}
.polling-list-leave-active {
  position: absolute;
}
</style>

<script>
import { ref, toRefs, toRef } from 'vue';
import { useNavigation } from '@/composables/useNavigation';
import { useSidebarMenu } from '@/composables/useSidebarMenu';
import { MENU_ITEMS, PRIVILEGES } from '../constants';
import { useLogout } from '@/composables/useLogout';
import SidebarMenu from '../components/asisten/SidebarMenu.vue';
import AsistenProfilePanel from '../components/asisten/ProfilePanel.vue';

export default {
  components: {
    SidebarMenu,
    AsistenProfilePanel,
  },

  props: [
    'comingFrom',
    'currentUser',
    'position',
    'userRole',
    'allJenisPollings',
    'allPollingResults',
  ],

  setup(props) {
    const menuRef = ref(null);

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: menuRef,
      currentPage: 'polling'
    });
    const navigationRefs = toRefs(navigation);

    // Initialize menu state based on comingFrom prop
    navigation.initializeMenu(props.comingFrom, true);
    const { logoutAsisten } = useLogout();

    const sidebarMenu = useSidebarMenu({
      menuItems: MENU_ITEMS,
      privileges: PRIVILEGES,
      currentUser: toRef(props, 'currentUser'),
      currentPageId: 'polling',
      changePage: navigationRefs.changePage,
    });

    // Return all navigation state and methods
    // Wrap menuRef to prevent auto-unwrapping in template
    return {
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

      listJenisPollings: this.allJenisPollings,
      listPollingResults: this.allPollingResults,

      currentActivePolling: '',
      currentPollingList: [],

    }
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

    this.currentActivePolling = globe.listJenisPollings[0].id; 
    this.openPollingList(globe.listJenisPollings[0].judul);

    if(this.comingFrom === 'asisten' ||
        this.comingFrom === 'none' ||
        this.comingFrom === 'soal'||
        this.comingFrom === 'modul'||
        this.comingFrom === 'praktikum' ||
        this.comingFrom === 'plotting' ||
        this.comingFrom === 'kelas' ||
        this.comingFrom === 'tp' ||
        this.comingFrom === 'history'||
        this.comingFrom === 'nilai'||
        this.comingFrom === 'pelanggaran'||
        this.comingFrom === 'konfigurasi'||
        this.comingFrom === 'setpraktikan'||
        this.comingFrom === 'rating' ||
        this.comingFrom === 'allLaporan' ||
        this.comingFrom === 'jawaban' ||
        this.comingFrom === 'lihat_tp'){

      setTimeout(
        function() {
          globe.currentPage = true;
        }, 10); 
    }
  },

  methods: {
    handleMenuSelect(menuKey) {
      // Capture current scroll position before navigation
      const position = this.menuRef?.scrollTop || 0;
      
      // Navigate with scroll position (travel and setCurrentMenu are available via this)
      this.travel(menuKey, position);
      this.setCurrentMenu(menuKey);
    },

    openPollingList: function($judul){

      const globe = this;
      globe.currentPollingList = [];

      this.listJenisPollings.forEach(element => {
        if(element.judul == $judul)
          globe.currentActivePolling = element.id
      });

      this.listPollingResults.forEach(element => {

        var $jumlah_poll = 0;
        element.polling.forEach(poll => {
          if($judul == poll.jenis)
            $jumlah_poll = poll.jumlah_poll;
        });

        globe.currentPollingList.push({
          id: element.id,
          nama: element.nama,
          kode: element.kode,
          judul: $judul,
          jumlah_poll: $jumlah_poll, 
        })
      });

      this.currentPollingList.sort(function(a, b) {
        if (a.jumlah_poll < b.jumlah_poll) 
          return 1; 
        if (a.jumlah_poll > b.jumlah_poll) 
          return -1; 
        return 0; 
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
