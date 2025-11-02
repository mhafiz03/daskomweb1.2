import { reactive, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';

/**
 * Navigation composable for managing menu state and page transitions
 * Replaces duplicated setCurrentMenu and travel functions across components
 * 
 * @param {Object} config - Configuration object
 * @param {String} config.userType - 'asisten' or 'praktikan'
 * @param {Object} config.menuRef - Reference to scrollable menu element
 * @param {String} config.currentPage - Current page identifier
 * @returns {Object} Navigation state and methods
 */
export function useNavigation(config = {}) {
  const { userType = 'asisten', menuRef = null, currentPage = '' } = config;

  // Menu state management
  const menuState = reactive({
    menuPraktikum: false,
    menuSoal: false,
    menuHistory: false,
    menuPolling: false,
    menuProfil: false,
    menuKelas: false,
    menuModul: false,
    menuPlotting: false,
    menuKonfigurasi: false,
    menuTp: false,
    menuNilai: false,
    menuSetPraktikan: false,
    menuLihatTp: false,
    menuPelanggaran: false,
    menuRanking: false,
    menuAllLaporan: false,
    menuJawaban: false,
  });

  // Page transition state
  const transitionState = reactive({
    changePage: false,
    currentPage: false,  // Start as false for animation
  });

  /**
   * Route mapping for navigation
   */
  const routeMap = {
    // Asisten routes
    asisten: { route: '', menu: 'menuProfil' },
    praktikum: { route: 'praktikum', menu: 'menuPraktikum' },
    soal: { route: 'soal', menu: 'menuSoal' },
    history: { route: 'history', menu: 'menuHistory' },
    polling: { route: 'polling', menu: 'menuPolling' },
    kelas: { route: 'kelas', menu: 'menuKelas' },
    modul: { route: 'modul', menu: 'menuModul' },
    plotting: { route: 'plotting', menu: 'menuPlotting' },
    konfigurasi: { route: 'konfigurasi', menu: 'menuKonfigurasi' },
    tp: { route: 'tp', menu: 'menuTp' },
    nilai: { route: 'nilai', menu: 'menuNilai' },
    setpraktikan: { route: 'setpraktikan', menu: 'menuSetPraktikan' },
  lihat_tp: { path: '/lihat_tp', menu: 'menuLihatTp' },
    pelanggaran: { route: 'pelanggaran', menu: 'menuPelanggaran' },
    rating: { route: 'rating', menu: 'menuRanking' },
    laporan: { route: 'laporan', menu: 'menuAllLaporan' },
    allLaporan: { route: 'laporan', menu: 'menuAllLaporan' }, // Alias for laporan
    jawaban: { route: 'jawaban', menu: 'menuJawaban' },
    
    // Praktikan routes
    'contact-asisten': { route: 'contact-asisten', menu: null },
  };

  /**
   * Set menu state for a specific target
   * @param {String} target - Target menu identifier
   * @param {Boolean} value - Menu state (true/false)
   */
  const setCurrentMenu = (target, value = true) => {
    const route = routeMap[target];
    if (route && route.menu && menuState.hasOwnProperty(route.menu)) {
      menuState[route.menu] = value;
    }
  };

  /**
   * Reset all menu states
   */
  const resetMenuState = () => {
    Object.keys(menuState).forEach(key => {
      menuState[key] = false;
    });
  };

  /**
   * Initialize menu state based on current page
   * @param {String} comingFrom - Page identifier to activate
   * @param {Boolean} shouldAnimate - Whether to trigger animation
   */
  const initializeMenu = (comingFrom, shouldAnimate = true) => {
    if (comingFrom) {
      resetMenuState();
      setCurrentMenu(comingFrom, shouldAnimate);
      
      // Pages that should show animation when entering
      const animatedPages = [
        'asisten', 'none', 'kelas', 'soal', 'plotting', 'modul',
        'konfigurasi', 'tp', 'polling', 'history',
        'nilai', 'pelanggaran', 'setpraktikan', 'lihat_tp', 'rating',
        'allLaporan', 'laporan', 'jawaban'
      ];
      
      // Trigger animation by setting currentPage to true after a delay
      if (shouldAnimate && animatedPages.includes(comingFrom)) {
        setTimeout(() => {
          transitionState.currentPage = true;
        }, 10);
      } else {
        transitionState.currentPage = true;
      }
    }
  };

  /**
   * Navigate to a new page with Inertia
   * @param {String} destination - Destination page identifier
   * @param {Object} options - Navigation options
   */
  const travel = (destination, options = {}) => {
    const {
      comingFrom = currentPage,
      preserveScroll = false,
      replace = true,
      onBefore = null,
      onFinish = null,
    } = options;

    // Set menu state for destination
    setCurrentMenu(destination, true);
    
    // Update transition state
    transitionState.changePage = true;
    transitionState.currentPage = false;

    // Get scroll position if menu ref exists
    // Handle both ref.value (from setup) and direct ref access
    const scrollPosition = (menuRef?.value?.scrollTop ?? menuRef?.scrollTop) || 0;

    // Build URL based on user type
    let url = '';
    const route = routeMap[destination];
    
    if (userType === 'asisten') {
      if (route?.path) {
        const connector = route.path.includes('?') ? '&' : '?';
        url = `${route.path}${connector}comingFrom=${comingFrom}&position=${scrollPosition}`;
      } else {
        url = route?.route
          ? `/asisten/${route.route}?comingFrom=${comingFrom}&position=${scrollPosition}`
          : `/asisten?comingFrom=${comingFrom}&position=${scrollPosition}`;
      }
    } else if (userType === 'praktikan') {
      url = route?.route 
        ? `/praktikan/${route.route}?comingFrom=${comingFrom}&position=${scrollPosition}`
        : `/praktikan?comingFrom=${comingFrom}&position=${scrollPosition}`;
    }

    // Execute navigation with optional callbacks
    const navigateOptions = {
      replace,
      preserveScroll,
      onBefore: () => {
        if (onBefore) onBefore();
      },
      onFinish: () => {
        if (onFinish) onFinish();
        transitionState.changePage = false;
        transitionState.currentPage = true;
      },
    };

    // Small delay for smooth animation
    setTimeout(() => {
      router.get(url, {}, navigateOptions);
    }, 50);
  };

  /**
   * Navigate with animation (for login/special transitions)
   * @param {String} destination - Destination identifier
   * @param {Function} animationCallback - Animation to run before navigation
   */
  const travelWithAnimation = (destination, animationCallback) => {
    if (animationCallback) {
      animationCallback(() => {
        travel(destination, { comingFrom: 'login' });
      });
    } else {
      travel(destination, { comingFrom: 'login' });
    }
  };

  // Return a reactive object containing all state and methods
  return reactive({
    // State from menuState
    ...menuState,
    
    // State from transitionState
    ...transitionState,
    
    // Methods
    setCurrentMenu,
    resetMenuState,
    initializeMenu,
    travel,
    travelWithAnimation,
  });
}
