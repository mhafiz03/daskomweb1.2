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
      <div class="w-full h-full py-4 flex">
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
                <option v-for="modul in allModul" v-bind:key="modul.id" :value="modul.id" :disabled="!modul.id">
                  {{ modul.judul }}
                </option>
              </select>
            </div>
            <div class="w-full h-1/4 mt-8 p-2 hover:p-3 cursor-pointer animation-enable-short flex"
                v-on:click="setThisPraktikan()">
              <div class="w-full h-full bg-green-600 rounded-lg flex">
                <div class="w-auto h-auto m-auto font-monda-bold text-white text-2xl">
                  <span>SET</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-140 h-72 m-auto">
          <div class="w-full h-full flex-row">
            <div class="w-full py-2 px-5 h-1/4 flex-row">
              <span class="font-merri w-full text-left text-yellow-400 text-lg h-1/4">
                NIM
              </span>
              <div class="w-full h-3/4">
                <input v-model="praktikanNimPass"
                      class="font-overpass-mono-bold text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                      id="Kelas" type="text" placeholder="101022130600">
              </div>
            </div>
            <div class="w-full h-1/4 flex-row pt-2 px-5">
              <span class="font-merri w-full text-left text-yellow-400 text-lg h-1/4">
                Pass Baru
              </span>
              <div class="w-full h-3/4">
                <input v-model="newPass"
                      class="font-overpass-mono-bold text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                      id="Kelas" type="text" placeholder="Jangan sampe lupa lagi !!!!">
              </div>
            </div>
            <div class="w-full h-1/4 mt-8 p-2 hover:p-3 cursor-pointer animation-enable-short flex"
                v-on:click="changePass()">
              <div class="w-full h-full bg-green-600 rounded-lg flex">
                <div class="w-auto h-auto m-auto font-monda-bold text-white text-2xl">
                  <span>GANTI PASS</span>
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

    // Initialize navigation composable
    const navigation = useNavigation({
      userType: 'asisten',
      menuRef: menuRef,
      currentPage: 'setpraktikan'
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
      currentPageId: 'setpraktikan',
      changePage: navigationRefs.changePage,
    });

    // Return all navigation state and methods
    // Wrap menuRef to prevent auto-unwrapping in template
    return {
      toast,
      menuRef,
      menuRefWrapped: { ref: menuRef }, // Wrapped for template
      ...navigationRefs,
      ...sidebarMenu,
        logoutAsisten,
    };
  },

  data() {
    return {
      privileges: { ...PRIVILEGES },

      soalPriviledge: "all",
      
      pageActive: true,
      isMenuShown: false,

      
      praktikanNim: '',
      chosenModulID: '',

      praktikanNimPass: '',
      newPass: '',
    };
  },

  mounted() {
    $('body').addClass('closed');
    
    // Restore scroll position if provided
    if (this.menuRef && this.position != null) {
      this.$nextTick(() => {
        const target = Number(this.position) || 0;
        
        // menuRef is auto-unwrapped in Options API, so we can access properties directly
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
        this.comingFrom === 'history'||
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
    handleMenuSelect(target) {
      this.setActiveMenu(target);
      this.travel(target);
    },

    changePass: function(){

      const globe = this;

      if(this.praktikanNimPass === '') {
        globe.toast.error("Isikan nim nya terlebih dahulu");
        return;
      }

      if(this.newPass === ''){
        globe.toast.error("Isikan password yang barunya");
        return;
      }

      globe.$axios.put('/asisten/praktikan/password/'+this.praktikanNimPass+'/'+this.newPass).then(response => {

        if(response.data.message === "success") {
          globe.toast.success("Password praktikan "+this.praktikanNim+" berhasil diubah");

        } else {
          globe.toast.error(response.data.message);
        }
      });
    },

    setThisPraktikan: function(){

      const globe = this;

      if(this.praktikanNim === '') {
        globe.toast.error("Isikan nim nya terlebih dahulu");
        return;
      }

      if(this.chosenModulID === ''){
        globe.toast.error("Pilih modul nya terlebih dahulu");
        return;
      }

      globe.$axios.post('/asisten/praktikan/set/'+this.praktikanNim+'/'+this.currentUser.id+'/'+this.chosenModulID).then(response => {

        if(response.data.message === "success") {
          globe.toast.success("Praktikan "+this.praktikanNim+" berhasil di set manual");

        } else {
          globe.toast.error(response.data.message);
        }
      });
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
