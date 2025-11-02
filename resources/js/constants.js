export const PRIVILEGES = {
  kelas: [1, 2, 4, 5],
  plotting: [1, 2, 4, 5],
  modul: [1, 2, 4, 15, 7],
  konfigurasi: [1, 2, 4, 18, 7],
  tp: [1, 2, 15, 11, 7],
  pelanggaran: [1, 2, 4, 5, 6, 18],
  ranking: [1, 2, 4, 5, 8, 16],
  allLaporan: [1, 2, 4, 5, 6],
  jawaban: [1, 2, 7, 11, 15],
  soal: 'all',
  edit: [1, 2, 15, 11, 7],
};

export const MENU_ITEMS = [
  {
    id: 'asisten',
    label: 'Profil',
    icon: 'fas fa-address-card',
  },
  {
    id: 'praktikum',
    label: 'Praktikum',
    icon: 'fas fa-code',
  },
  {
    id: 'history',
    label: 'History',
    icon: 'fas fa-history',
  },
  {
    id: 'nilai',
    label: 'Nilai',
    icon: 'fas fa-clipboard-check',
  },
  {
    id: 'polling',
    label: 'Polling',
    icon: 'fas fa-chart-area',
  },
  {
    id: 'setpraktikan',
    label: 'Set Praktikan',
    icon: 'fas fa-users',
  },
  {
    id: 'kelas',
    label: 'Kelas',
    icon: 'fas fa-chalkboard-teacher',
    privilege: 'kelas',
  },
  {
    id: 'allLaporan',
    label: 'All Laporan',
    icon: 'fas fa-file-medical-alt',
    privilege: 'allLaporan',
  },
  {
    id: 'soal',
    label: 'Soal',
    icon: 'fas fa-file-code',
    privilege: 'soal',
    isCurrentPage: true,
  },
  {
    id: 'plotting',
    label: 'Plotting',
    icon: 'fas fa-calendar-alt',
    privilege: 'plotting',
  },
  {
    id: 'modul',
    label: 'Modul',
    icon: 'fas fa-book',
    privilege: 'modul',
  },
  {
    id: 'konfigurasi',
    label: 'Konfigurasi',
    icon: 'fas fa-cog',
    privilege: 'konfigurasi',
  },
  {
    id: 'tp',
    label: 'Tugas Pendahuluan',
    icon: 'fas fa-book-open',
    privilege: 'tp',
  },
  {
    id: 'lihat_tp',
    label: 'Lihat TP',
    icon: 'fas fa-eye',
  },
  {
    id: 'jawaban',
    label: 'Jawaban',
    icon: 'fas fa-tasks',
    privilege: 'jawaban',
  },
  {
    id: 'pelanggaran',
    label: 'Pelanggaran',
    icon: 'fas fa-radiation-alt',
    privilege: 'pelanggaran',
  },
  {
    id: 'rating',
    label: 'Ranking Praktikan',
    icon: 'fas fa-star',
    privilege: 'ranking',
  },
];

export const SOAL_TABS = [
  { id: 'TP', label: 'TP' },
  { id: 'TA', label: 'TA' },
  { id: 'TK', label: 'TK' },
  { id: 'Jurnal', label: 'Jurnal' },
  { id: 'Mandiri', label: 'Mandiri' },
  { id: 'FITB', label: 'FITB', extraClasses: 'rounded-tr-large' },
];
