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

    <div class="absolute w-120full h-full flex animation-enable"
        :class="[{ 'left-minFull': !currentPage },
                { 'left-0': currentPage }]">
      <div v-if="listAllHistory.length > 0" 
          class="w-full h-full" v-scrollbar>
        <div>
          <transition-group name="history-list" tag="div">
            <div v-for="(history) in listAllHistory" v-bind:key="history.id" 
                class="animation-enable w-full h-72 flex mb-8">
              <div class="w-full h-full px-6 flex-row mt-2">
                <div class="w-full h-12 flex">
                  <div class="w-1/2 h-auto my-auto whitespace-pre-wrap break-words font-monda-bold text-2xl text-yellow-400">
                    <span>{{ history.hari.toUpperCase() }} - {{ history.shift }}  (Rp.25000)</span>
                  </div>
                  <div class="w-1/2 h-auto text-right my-auto whitespace-pre-wrap break-words font-monda-bold text-2xl text-yellow-400">
                    <span>{{ history.created_at }}</span>
                  </div>
                </div>
                <div class="w-full h-12full flex bg-gray-300 rounded-lg">
                  <div class="w-1/3 h-full p-4 overflow-y-auto flex">
                    <div class="w-auto h-auto m-auto whitespace-pre-wrap break-words font-merri-bold text-2xl text-black">
                      <span>Modul<br>{{ history.judul }}</span>
                    </div>
                  </div>
                  <div class="w-2/3 h-full p-4 bg-gray-200 rounded-r-lg overflow-y-auto flex">
                    <div class="w-full h-full whitespace-pre-wrap break-words font-overpass text-2xl text-black">
                      <span class="font-monda-bold text-3xl">Laporan :</span>
                      <br>
                      <span>{{ history.laporan }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </transition-group>
        </div>
      </div>
      <div v-if="listAllHistory.length === 0"
          class="w-full h-full flex">
        <div class="w-auto h-auto m-auto font-monda-bold text-5xl text-white">
          <span>Anda belum pernah menjaga praktikum :(</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import { MENU_ITEMS, PRIVILEGES } from '../constants';
import { ref, toRef, toRefs } from 'vue';
import { useNavigation } from '@/composables/useNavigation';
import { useToast } from '@/composables/useToast';
import { useSidebarMenu } from '@/composables/useSidebarMenu';
import { useLogout } from '@/composables/useLogout';
import SidebarMenu from '@/components/asisten/SidebarMenu.vue';
import AsistenProfilePanel from '@/components/asisten/ProfilePanel.vue';
export default {
  props: [
    'comingFrom',
    'currentUser',
    'position',
    'userRole',
    'allHistory',
  ],

  components: {
    SidebarMenu,
    AsistenProfilePanel,
  },

  setup(props) {
    const menuRef = ref(null);

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: menuRef,
      currentPage: 'history'
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
      currentPageId: 'history',
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
      listAllHistory: this.allHistory,
    }
  },

  mounted() {

    $('body').addClass('closed');
    
    // Restore scroll position if provided
    if (this.menuRef && this.position != null) {
      this.$nextTick(() => {
        const target = Number(this.position) || 0;
        if (this.menuRef && this.menuRef.scrollTop !== undefined) {
          this.menuRef.scrollTop = target;
        }
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
        this.comingFrom === 'tp' ||
        this.comingFrom === 'polling' ||
        this.comingFrom === 'konfigurasi'||
        this.comingFrom === 'nilai'||
        this.comingFrom === 'pelanggaran'||
        this.comingFrom === 'setpraktikan'||
        this.comingFrom === 'rating' ||
        this.comingFrom === 'allLaporan' ||
        this.comingFrom === 'jawaban'){

      setTimeout(
        function() {
          globe.currentPage = true;
        }, 10); 
    }
  },
  
  filters: {
    moment: function (date) {
      return moment(date).format('MMMM Do YYYY, h:mm:ss a');
    }
  },

  methods: {

    handleMenuSelect(target) {
      this.setActiveMenu(target);
      this.travel(target);
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
