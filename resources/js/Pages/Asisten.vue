<template>
  <div class="bg-green-900 w-full h-full overflow-hidden">

    <!-- Main Layout -->
    <div class="absolute z-10 bottom-0 flex h-48full w-4full rounded-tl-large bg-yellow-500 animation-enable"
        :class="[{ 'right-0': pageActive && !isMessageShown },
                { 'right-minFull': !pageActive || changePage || isMessageShown }]">
      <div class="w-120full flex-row">
        <div class="mx-auto mt-4 px-4 break-words text-green-800 font-merri-bold text-4xl text-center">
          {{ currentUser.nama }}
        </div>
        <div class="relative w-full h-full">
          <div class="absolute w-full h-full px-8 pt-8">
            <div class="bg-yellow-800 rounded-t-lg w-full h-full flex-col overflow-y-auto">
              <!-- EDIT desc assistant -->
              <div class="pt-16 px-8 w-full h-auto text-center">
                <span class="p-3 bg-green-800 font-merri-bold text-xl cursor-pointer text-yellow-200 rounded-lg hover:bg-green-900 animation-enable"
                      v-if="!showEditForm"
                      v-on:click="editDescription(true)">Edit Description <img class="p-1 fas fa-pen fa-lg">
                </span>
                <span class="p-3 px-4 bg-red-600 font-merri-bold text-xl cursor-pointer text-white rounded-lg hover:bg-red-700 animation-enable"
                      v-if="showEditForm"
                      v-on:click="editDescription(false)">
                      <img class="p-1 fas fa-times fa-lg">
                </span>
                <span class="p-3 bg-green-600 font-merri-bold text-xl cursor-pointer text-white rounded-lg hover:bg-green-700 animation-enable"
                      v-if="showEditForm"
                      v-on:click="updateDeskripsi">
                      <img class="p-1 fas fa-check fa-lg">
                </span>
              </div>
              <!-- desc form -->
              <form id="descForm" class="animation-enable"
                    :class="{ hidden: !showEditForm, visible: showEditForm }">
                    <div class="pt-5">
                      <label class="block text-yellow-400 font-bold text-center" for="deskripsi">
                        Nomor HP:
                      </label>
                    </div>
                    <div class="text-center">
                      <input v-model="formDesc.nomor_telepon" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-1/4 py-2 px-4 text-gray-700 font-overpass-mono-bold text-xl focus:outline-none focus:bg-white focus:border-teal-500 text-center" id="nomor_telepon" type="text" placeholder="08xxxxxxxx">
                    </div>

                    <div class="pt-2">
                      <label class="block text-yellow-400 font-bold text-center" for="id_line">
                        ID Line:
                      </label>
                    </div>
                    <div class="text-center">
                      <input v-model="formDesc.id_line" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-1/4 py-2 px-4 text-gray-700 font-overpass-mono-bold text-xl focus:outline-none focus:bg-white focus:border-teal-500 text-center" id="id_line" type="text" placeholder="ID Line kamu">
                    </div>

                    <div class="pt-2">
                      <label class="block text-yellow-400 font-bold text-center" for="instagram">
                        Username Instagram:
                      </label>
                    </div>
                    <div class="text-center">
                      <input v-model="formDesc.instagram" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-1/4 py-2 px-4 text-gray-700 font-overpass-mono-bold text-xl focus:outline-none focus:bg-white focus:border-teal-500 text-center" id="instagram" type="text" placeholder="Username IG kamu">
                    </div>

                    <div class="pt-2">
                      <label class="block text-yellow-400 font-bold text-center" for="deskripsi">
                        Deskripsi:
                      </label>
                    </div>
                    <div class="text-center pt-1">
                      <textarea v-model="formDesc.deskripsi" cols="30" rows="5" class="font-overpass-mono-bold text-xl bg-gray-200 appearance-none border-2 text-center border-gray-200 rounded w-1/2 h-full py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"/>
                    </div>
              </form>

              <div class="w-full h-auto break-words pt-5 text-center text-yellow-200 font-merri text-2xl p-8 flex flex-col self-center mt-3">
                <div class="flex pt-1 self-center align-middle">
                    <div class="mr-2">
                      <img class="fas fa-phone w-8 h-8">
                    </div>
                    <div class="text-xl">
                      <span v-if="!currentUser.nomor_telepon || currentUser.nomor_telepon === '-'">Not Available</span>
                      <span v-else>{{ currentUser.nomor_telepon }}</span>
                    </div>
                </div>

                <div class="flex pt-1 self-center align-middle">
                    <div class="mr-2">
                      <img class="fab fa-line w-8 h-8">
                    </div>
                    <div class="text-xl">
                      <span v-if="!currentUser.id_line || currentUser.id_line === '-'">Not Available</span>
                      <span v-else>{{ currentUser.id_line }}</span>
                    </div>
                </div>

                <div class="flex pt-1 self-center align-middle">
                    <div class="mr-2">
                      <img class="fab fa-instagram w-8 h-8">
                    </div>
                    <div class="text-xl">
                      <span v-if="!currentUser.instagram || currentUser.instagram === '-'">Not Available</span>
                      <span v-else>{{ currentUser.instagram }}</span>
                    </div>
                </div>

                <div class="p-2 mb-1">
                  <span class="font-merri-bold text-lg p-2 px-4 bg-yellow-900 text-yellow-200 rounded-lg">Description:</span>
                </div>
                <div class="pb-16">
                  <span class="whitespace-pre-wrap">{{ currentUser.deskripsi }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="absolute w-full h-16 px-16 pt-2 z-20">
            <div class="bg-yellow-700 rounded-lg w-full h-full flex align-middle">
              <div class="flex w-1/2">
                <star-rating class="ml-auto pl-16"
                  style="width: 150px;" 
                  :increment="0.01" 
                  :fixed-points="2"
                  :read-only="true"
                  :show-rating="false"
                  :rating="ratingAsisten"
                  :star-size='30'/>
              </div>
              <!-- <div class="w-1 h-3/4 my-auto bg-yellow-500"/>
              <div class="flex w-1/2 mr-auto h-full pt-1 items-center font-overpass-bold text-2xl text-white ml-4">
                <span class="whitespace-pre-wrap">Jaga Reguler: {{ jagaReguler }} | Jaga Inter: {{ jagaInter }}</span> 
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>

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

    <!-- Message Menu -->
    <div class="absolute left-0 h-full w-120full flex" @mouseover="isMenuShown = false">

      <!-- Dummy Message Animation -->
      <div class="absolute top-0 left-0 w-full pr-16 animation-enable"
          :class="[{ 'h-16full': isMessageShown },
                  { 'h-16': !isMessageShown },
                  { 'top-0': pageActive },
                  { 'top-minFull': !pageActive || changePage }]">
        <div class="w-full h-full flex rounded-br-large bg-green-600">
          <div class="w-16full h-full"/>
          <div class="w-12 h-10 mt-auto mb-3 z-40 cursor-pointer pointer-events-auto" v-on:click="openMessage">
            <div class="animation-enable" 
                :class="[{ 'unrotated ml-0': !isMessageShown }, { 'rotated ml-8': isMessageShown }]">
              <span class="animation-enable" 
                  :class="[{ 'text-white': !isMessageShown }, { 'text-black': isMessageShown }]">
                <img class="w-full h-10 ml-2 fas fa-arrow-circle-down">
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Message Layout -->
      <div class="absolute top-0 left-0 w-full z-30 animation-enable"
          :class="[{ 'h-16full pr-16': isMessageShown },
                  { 'h-16 pr-32': !isMessageShown },
                  { 'top-0': pageActive },
                  { 'top-minFull': !pageActive || changePage }]">
        <div class="bg-green-300 border-green-600 w-full h-full relative animation-enable"
          :class="[{ 'rounded-br-large border-r-4 border-b-4': isMessageShown },
                  { 'rounded-0 border-r-0 border-b-0': !isMessageShown },]">
          <div class="flex w-full h-full"
              :class="[{ 'visible': !isMessageShown },
                      { 'hidden': isMessageShown }]">
            <span v-if="unreadMessages > 0" class="m-auto font-monda-bold text-2xl tracking-wide">
              Ada 
              <span class="text-yellow-700">
                {{ unreadMessages }}
              </span> 
              pesan baru
            </span>
            <span v-else class="m-auto font-monda-bold text-2xl tracking-wide">
              Tidak ada pesan baru
            </span>
          </div>

          <div class="absolute w-full h-full" v-scrollbar>
            <div class="flex-row w-full h-full"
                :class="[{ 'visible': isMessageShown },
                        { 'hidden': !isMessageShown }]">

              <div class="w-4full px-4 h-auto min-h-24 mb-16 my-4 flex relative"
                  v-for="message in userMessages" v-bind:key="message.id">
                <div class="flex pl-4 pr-4 pt-2 rounded-lg bg-gray-500 w-4full font-overpass-mono-bold text-2xl">
                  <div class="w-full h-full break-words">
                    {{ message.pesan }}
                    <div class="w-full h-8"/>
                  </div>
                </div>
                <div class="flex absolute pt-1 h-8 font-merri text-lg pl-4 pr-2 pb-1 left-0 ml-8 rounded-full bottom-min1rem bg-yellow-500 w-7/12">
                  <span class="w-10/12">
                    {{ message.nama }}
                  </span>
                  <div class="w-2/12 flex" v-if="!message.read">
                    <span class="w-auto px-4 py-1 font-overpass-bold text-sm rounded-full bg-red-500 ml-auto">
                      New !
                    </span>
                  </div>
                </div>
                <div class="absolute pt-1 h-8 font-merri text-lg px-4 right-0 mr-8 rounded-full bottom-min1rem bg-yellow-500 text-center w-2/12">
                  {{ message.kelas }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</template>
<style>
  .rotated {
    transform: rotate(180deg);
  }

  .unrotated {
    transform: rotate(0deg);
  }
</style>

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
    'messages',
    'userRole',
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
      currentPage: 'asisten'
    });
    const navigationRefs = toRefs(navigation);
    const { logoutAsisten } = useLogout();

    // Initialize menu state based on comingFrom prop
    navigation.initializeMenu(props.comingFrom, true);
    const toast = useToast();

    const sidebarMenu = useSidebarMenu({
      menuItems: MENU_ITEMS,
      privileges: PRIVILEGES,
      currentUser: toRef(props, 'currentUser'),
      currentPageId: 'asisten',
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
      pageActive: false,
      isMenuShown: false,
      isMessageShown: false,
      animate: true,
      userMessages: this.messages,

      ratingAsisten: 0,
      showEditForm: false,
      jagaInter: 0,
      jagaReguler: 0,

      formDesc: {
        id: '',
        deskripsi: '',
        nomor_telepon: '',
        id_line: '',
        instagram: '',
      },

    }
  },

  computed: {
    
    unreadMessages: function () {

      var i = 0;

      if(this.isEmpty(this.userMessages)){
        return 0;
      }

      this.userMessages.forEach(function(element) {
        if(!element.read)
          i++
      });
      return i;
    }
  },

  mounted() {
    document.body.classList.add('closed');

    const globe = this;

    if(this.comingFrom === 'login' ||
        this.comingFrom === 'none'){

      setTimeout(
        function() {
          globe.pageActive = true;
        }, 10); 
    } else if(this.comingFrom === 'kelas' ||
              this.comingFrom === 'soal'  ||
              this.comingFrom === 'modul'||
              this.comingFrom === 'plotting'||
              this.comingFrom === 'praktikum' ||
              this.comingFrom === 'konfigurasi' ||
              this.comingFrom === 'tp'||
              this.comingFrom === 'polling' ||
              this.comingFrom === 'history' ||
              this.comingFrom === 'nilai' ||
              this.comingFrom === 'pelanggaran' ||
              this.comingFrom === 'setpraktikan' ||
              this.comingFrom === 'rating' ||
              this.comingFrom === 'allLaporan' ||
              this.comingFrom === 'jawaban'){

      this.animate = false;
      this.pageActive = true;
      this.changePage = true;
      this.setActiveMenu(this.comingFrom);
      setTimeout(
        function() {
          globe.changePage = false;
          globe.setActiveMenu('');
          globe.animate = true;
        }, 10); 
    }

    globe.$axios.get('/asisten/profil/'+globe.currentUser.id).then(response => {

      if(response.data.message === "success") {
        globe.ratingAsisten = response.data.ratingAsisten;
        globe.jagaReguler = response.data.jagaReguler;
        globe.jagaInter = response.data.jagaInter;

      } else {
        globe.toast.error(response.data.message);
      }
    });

    
  },

  beforeUnmount() {
    document.body.classList.remove('closed');
  },

  methods: {

    handleMenuSelect(target) {
      this.setActiveMenu(target);
      this.travel(target);
    },

    editDescription: function($bool){
      this.showEditForm = !!$bool;

      if (this.showEditForm) {
        this.formDesc.deskripsi = this.currentUser.deskripsi ?? '';
        this.formDesc.nomor_telepon = this.currentUser.nomor_telepon ?? '';
        this.formDesc.id_line = this.currentUser.id_line ?? '';
        this.formDesc.instagram = this.currentUser.instagram ?? '';
      }
    },

    updateDeskripsi: function(){
      const globe = this;
      this.$axios.post('/asisten/update-desc', this.formDesc).then(response => {
        
        if(response.data.message === "success") {

          globe.toast.success("Deskripsi berhasil diperbaharui"   );

          globe.$inertia.get('/asisten', {}, {
            replace: true,
          });
          globe.editDescription(false);

        } else {
          globe.toast.error(response.data.message);
        }
      }).catch(function (error) {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          if(error.response.data.errors != null){
            if(error.response.data.errors.deskripsi != null)
              globe.toast.error(error.response.data.errors.deskripsi[0]);
            if(error.response.data.errors.nomor_telepon != null)
              globe.toast.error(error.response.data.errors.nomor_telepon[0]);
            if(error.response.data.errors.id_line != null)
              globe.toast.error(error.response.data.errors.id_line[0]);
            if(error.response.data.errors.instagram != null)
              globe.toast.error(error.response.data.errors.instagram[0]);
          }
        }
      });
    },

    travel: function($whereTo){
      const globe = this;
      this.setActiveMenu($whereTo);
      this.changePage = true;
      setTimeout(
        function() {
          const scrollPos = globe.menuRef ? globe.menuRef.scrollTop : 0;
          globe.$inertia.get('/asisten/' + $whereTo + '?comingFrom=asisten&position=' + scrollPos, {}, {
            replace: true,
          });
        }, 501); 
    },

    setCookie: function(name, value, days){
      
      var expires = "";
      if (days) {
          var date = new Date();
          date.setTime(date.getTime() + (days*24*60*60*1000));
          expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    },

    getCookie: function(name){
      
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for(var i=0;i < ca.length;i++) {
          var c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1,c.length);
          if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
    },

    openMessage: function(){

      this.$axios.post('/asisten/pesan').then(response => {
        //Do nothing 
      }).catch(function (error) {
        if (error.response) {
          globe.toast.error(error.response.data.errors);
        }
      });

      this.isMessageShown = !this.isMessageShown
    },

    isEmpty: function (obj) {
      for(var key in obj) {
          if(obj.hasOwnProperty(key))
              return false;
      }
      return true;
    },

    signOut: function(){
      this.pageActive = false;
      setTimeout(async () => {
        await this.logoutAsisten();
      }, 1010);
    }
  }
}
</script>
