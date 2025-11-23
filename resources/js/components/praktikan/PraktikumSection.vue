<template>
  <div class="w-full h-full flex">
    <PollingMode
      v-if="isPollingEnabled"
      :all-asisten="allAsisten"
      :all-asisten-polling="allAsistenPolling"
      :all-polling="allPolling"
      :polling-complete="pollingComplete"
      :current-user="currentUser"
      @saved="handlePollingSaved"
    />

    <div v-else class="w-full h-full flex">
      <div v-if="currentPraktikum.status === '' || currentPraktikum.status === 777" class="w-full h-full flex">
        <div class="font-monda-bold h-auto w-auto m-auto text-center text-5xl">
          Tidak ada <br> Praktikum saat ini
        </div>
      </div>

      <div v-if="currentPraktikum.status === 0" class="w-full h-full flex-row">
        <div class="w-full h-24full flex">
          <div class="font-overpass text-3xl m-auto px-16">
            <span>
              Bersiap untuk praktikum modul <br /><span class="font-merri-bold text-5xl"> {{ currentModul.judul }} </span>
            </span>
          </div>
        </div>
        <div v-if="programmingQuote !== 'nothing'" class="w-full h-24 flex">
          <div class="font-overpass-mono-thin text-sm m-auto flex">
            <div class="m-auto text-center">"{{ programmingQuote }}"<br />by {{ quoteAuthor }}</div>
          </div>
        </div>
      </div>

      <div v-if="currentPraktikum.status === 1" class="w-full h-full flex">
        <div class="w-1/4 h-full flex-row overflow-y-hidden">
          <div class="w-full h-2/3 flex bg-yellow-700 px-2 overflow-x-hidden rounded-tl-large overflow-y-auto">
            <div class="h-auto text-white w-auto m-auto text-center font-monda-bold text-3xl">
              Modul <br /> <span class="font-merri">{{ currentModul.judul }}</span>
            </div>
          </div>
          <div class="w-full h-1/3 flex bg-yellow-600 rounded-bl-large">
            <div class="h-auto text-white text-center w-auto m-auto font-monda-bold text-2xl">
              TES <br /> AWAL
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex">
          <div class="w-full h-full overflow-y-auto">
            <div class="w-full h-auto flex-row">
              <QuestionBlock
                v-if="soalTa && soalTa.length > 0"
                mode="options"
                :questions="soalTa"
                :options-list="jawabanTa"
                :selected-answers="selectedAnswers"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="ta"
                question-key="pertanyaan"
                :on-option-select="payload => emitQuestionOptionSelect('TA', payload)"
              />
              <div
                v-else
                class="w-full h-32 flex items-center justify-center mt-72 pt-32"
              >
                <div class="w-full h-24full flex">
                  <div class="font-overpass text-3xl m-auto px-16">
                      <span class="font-merri-bold text-5xl"> Tidak ada soal </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="currentPraktikum.status === 2" class="w-full h-full flex">
        <div class="w-full h-full flex overflow-hidden" :class="[{ hidden: !showNilaiTa }, { visible: showNilaiTa }]">
          <div class="w-24full h-16full m-auto flex-row">
            <div class="w-full h-1/3 flex">
              <span class="w-auto h-auto mt-auto font-overpass text-3xl text-black">
                Nilai TA Kamu
                <span :class="[{ 'text-red-500': nilaiTa <= 50 }, { 'text-green-500': nilaiTa > 50 }]">
                  {{ nilaiTa !== '' ? nilaiTa : 'ERROR' }}
                </span>
              </span>
            </div>
            <div class="w-full h-2/3 flex-row">
              <span class="w-auto h-auto mb-auto font-monda-bold text-4xl text-black">
                {{ generateScoreText(nilaiTa) }}
              </span>

              <div class="w-full flex flex-col items-center gap-4 mt-4">
                <div
                  v-if="taSubmissionFailed"
                  class="w-64 h-24 flex"
                >
                  <div
                    class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                    :class="{ 'opacity-70 pointer-events-none': isTaRetrying }"
                    @click="$emit('retry-submit-ta')"
                  >
                    <div class="h-full w-full flex font-merri text-xl bg-red-700 rounded-lg text-center m-auto">
                      <div class="m-auto text-white">
                        {{ isTaRetrying ? 'Mengirim Ulang...' : 'Kirim Ulang Jawaban' }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="w-64 h-24 flex">
                  <div
                    class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                    @click="emitShowNilaiTa(false)"
                  >
                    <div class="h-full w-full flex font-merri text-xl bg-gray-800 rounded-lg text-center m-auto">
                      <div class="m-auto text-white">Lanjut Ke Jurnal</div>
                    </div>
                  </div>
                </div>

                <div
                  v-if="taSubmissionFailed && taSubmissionError"
                  class="font-overpass text-center text-red-600 text-xl"
                >
                  {{ taSubmissionError }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="w-1/4 h-full flex-row overflow-y-hidden"
          :class="[{ visible: !showNilaiTa }, { hidden: showNilaiTa }]"
        >
          <div class="w-full h-2/3 flex bg-yellow-700 px-2 overflow-x-hidden rounded-tl-large overflow-y-auto">
            <div class="h-auto text-white w-auto m-auto text-center font-monda-bold text-3xl">
              Modul <br /> <span class="font-merri">{{ currentModul.judul }}</span>
            </div>
          </div>
          <div class="w-full h-1/3 flex-row bg-yellow-600 rounded-bl-large">
            <div class="h-1/2 text-white flex text-center w-auto m-auto font-monda-bold text-2xl">
              <div class="m-auto">JURNAL</div>
            </div>
            <div class="h-1/2 w-full flex" v-if="modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(false)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Soal</div>
                </div>
              </div>
            </div>
            <div class="h-1/2 w-full flex" v-if="!modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(true)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Modul</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="w-3/4 h-full flex"
          :class="[{ visible: !showNilaiTa }, { hidden: showNilaiTa }]"
          v-if="!modulShown"
        >
          <div class="w-full h-full overflow-y-auto">
            <div class="w-full h-auto flex-row">
              <QuestionBlock
                :questions="soalFitb"
                :answers="jawabanFitb"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="fitb"
                :on-answer-change="payload => emitTextAnswerChange('jawabanFitb', payload)"
              />
              <QuestionBlock
                :questions="soalJurnal"
                :answers="jawabanJurnal"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="jurnal"
                :numbering-offset="soalFitb.length"
                :on-answer-change="payload => emitTextAnswerChange('jawabanJurnal', payload)"
              />
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex" v-if="modulShown">
          <div class="w-full h-full font-overpass text-xl whitespace-pre-wrap p-4 text-justify break-words overflow-y-auto">
            <span>{{ currentModul.isi }}</span>
          </div>
        </div>
      </div>

      <div v-if="currentPraktikum.status === 123" class="w-full h-full flex">
        <div class="w-1/4 h-full flex-row overflow-y-hidden">
          <div class="w-full h-2/3 flex bg-yellow-700 px-2 overflow-x-hidden rounded-tl-large overflow-y-auto">
            <div class="h-auto text-white w-auto m-auto text-center font-monda-bold text-3xl">
              Modul <br /> <span class="font-merri">{{ currentModul.judul }}</span>
            </div>
          </div>
          <div class="w-full h-1/3 flex-row bg-yellow-600 rounded-bl-large">
            <div class="h-1/2 text-white flex text-center w-auto m-auto font-monda-bold text-2xl">
              <div class="m-auto">JURNAL</div>
            </div>
            <div class="h-1/2 w-full flex" v-if="modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(false)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Soal</div>
                </div>
              </div>
            </div>
            <div class="h-1/2 w-full flex" v-if="!modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(true)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Modul</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex" v-if="!modulShown">
          <div class="w-full h-full overflow-y-auto">
            <div class="w-full h-auto flex-row">
              <QuestionBlock
                :questions="soalRunmod"
                :answers="jawabanRunmod"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="jurnal"
                :on-answer-change="payload => emitTextAnswerChange('jawabanRunmod', payload)"
              />
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex" v-if="modulShown">
          <div class="w-full h-full font-overpass text-xl whitespace-pre-wrap p-4 text-justify break-words overflow-y-auto">
            <span>{{ currentModul.isi }}</span>
          </div>
        </div>
      </div>

      <div v-if="currentPraktikum.status === 3" class="w-full h-full flex">
        <div class="w-1/4 h-full flex-row overflow-y-hidden">
          <div class="w-full h-2/3 flex bg-yellow-700 px-2 overflow-x-hidden rounded-tl-large overflow-y-auto">
            <div class="h-auto text-white w-auto m-auto text-center font-monda-bold text-3xl">
              Modul <br /> <span class="font-merri">{{ currentModul.judul }}</span>
            </div>
          </div>
          <div class="w-full h-1/3 flex-row bg-yellow-600 rounded-bl-large">
            <div class="h-1/2 text-white flex text-center w-auto m-auto font-monda-bold text-2xl">
              <div class="m-auto">MANDIRI</div>
            </div>
            <div class="h-1/2 w-full flex" v-if="modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(false)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Soal</div>
                </div>
              </div>
            </div>
            <div class="h-1/2 w-full flex" v-if="!modulShown">
              <div
                class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                @click="emitModulShown(true)"
              >
                <div class="h-full w-full flex font-overpass-mono-bold text-xl bg-gray-300 rounded-large text-center m-auto">
                  <div class="m-auto">Lihat Modul</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex" v-if="!modulShown">
          <div class="w-full h-full overflow-y-auto">
            <div class="w-full h-auto flex-row">
              <QuestionBlock
                :questions="soalMandiri"
                :answers="jawabanMandiri"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="mandiri"
                :on-answer-change="payload => emitTextAnswerChange('jawabanMandiri', payload)"
              />
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex" v-if="modulShown">
          <div class="w-full h-full font-overpass text-xl whitespace-pre-wrap p-4 text-justify break-words overflow-y-auto">
            <span>{{ currentModul.isi }}</span>
          </div>
        </div>
      </div>

      <div v-if="currentPraktikum.status === 4" class="w-full h-full flex">
        <div class="w-1/4 h-full flex-row overflow-y-hidden">
          <div class="w-full h-2/3 flex bg-yellow-700 px-2 overflow-x-hidden rounded-tl-large overflow-y-auto">
            <div class="h-auto text-white w-auto m-auto text-center font-monda-bold text-3xl">
              Modul <br /> <span class="font-merri">{{ currentModul.judul }}</span>
            </div>
          </div>
          <div class="w-full h-1/3 flex bg-yellow-600 rounded-bl-large">
            <div class="h-auto text-white text-center w-auto m-auto font-monda-bold text-2xl">
              TES <br /> AKHIR
            </div>
          </div>
        </div>
        <div class="w-3/4 h-full flex">
          <div class="w-full h-full overflow-y-auto">
            <div class="w-full h-auto flex-row">
              <QuestionBlock
                v-if="soalTk && soalTk.length > 0"
                mode="options"
                :questions="soalTk"
                :options-list="jawabanTk"
                :selected-answers="selectedAnswers"
                :praktikan-id="currentUser.id"
                :show-comments="isTotClass"
                tipe-soal="tk"
                question-key="pertanyaan"
                :on-option-select="payload => emitQuestionOptionSelect('TK', payload)"
              />
              <div
                v-else
                class="w-full h-32 flex items-center justify-center mt-72 pt-32"
              >
                <div class="w-full h-24full flex">
                  <div class="font-overpass text-3xl m-auto px-16">
                      <span class="font-merri-bold text-5xl"> Tidak ada soal </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="currentPraktikum.status !== 777 &&
              currentPraktikum.status !== 0 &&
              currentPraktikum.status !== '' &&
              currentPraktikum.status !== 1 &&
              currentPraktikum.status !== 2 &&
              currentPraktikum.status !== 3 &&
              currentPraktikum.status !== 4 &&
              currentPraktikum.status !== 123"
        class="w-full h-full flex"
      >
        <div class="w-full h-full flex overflow-hidden" :class="[{ hidden: !showNilaiTk }, { visible: showNilaiTk }]">
          <div class="w-24full h-16full m-auto flex-row">
            <div class="w-full h-1/3 flex">
              <span class="w-auto h-auto mt-auto font-overpass text-3xl text-black">
                Nilai TK Kamu
                <span :class="[{ 'text-red-500': nilaiTk <= 50 }, { 'text-green-500': nilaiTk > 50 }]">
                  {{ nilaiTk !== '' ? nilaiTk : 'ERROR' }}
                </span>
              </span>
            </div>
            <div class="w-full h-2/3 flex-row">
              <span class="w-auto h-auto mb-auto font-monda-bold text-4xl text-black">
                {{ generateScoreText(nilaiTk) }}
              </span>

              <div class="w-full flex flex-col items-center gap-4 mt-4">
                <div
                  v-if="tkSubmissionFailed"
                  class="w-64 h-24 flex"
                >
                  <div
                    class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                    :class="{ 'opacity-70 pointer-events-none': isTkRetrying }"
                    @click="$emit('retry-submit-tk')"
                  >
                    <div class="h-full w-full flex font-merri text-xl bg-red-700 rounded-lg text-center m-auto">
                      <div class="m-auto text-white">
                        {{ isTkRetrying ? 'Mengirim Ulang...' : 'Kirim Ulang Jawaban' }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="w-64 h-24 flex">
                  <div
                    class="h-full w-full flex p-4 hover:p-5 cursor-pointer animation-enable-short"
                    @click="emitShowNilaiTk(false)"
                  >
                    <div class="h-full w-full flex font-merri text-xl bg-gray-800 rounded-lg text-center m-auto">
                      <div class="m-auto text-white">Lanjut Ke Feedback</div>
                    </div>
                  </div>
                </div>

                <div
                  v-if="tkSubmissionFailed && tkSubmissionError"
                  class="font-overpass text-center text-red-600 text-xl"
                >
                  {{ tkSubmissionError }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="w-full h-full flex-row overflow-y-auto overflow-x-hidden"
          :class="[{ visible: !showNilaiTk }, { hidden: showNilaiTk }]"
        >
          <div class="w-full h-24 flex mt-4">
            <div class="w-1/2 h-full flex">
              <select
                :value="laporanPraktikan.asisten_id"
                class="block font-monda-bold text-4xl appearance-none w-2/3 ml-auto mr-2 my-auto h-3/4 bg-gray-600 border border-gray-600 text-white py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-gray-500 focus:border-teal-500"
                id="grid-state"
                @change="onLaporanChange('asisten_id', $event.target.value)"
              >
                <option value="" disabled selected>Pilih Asisten Jaga</option>
                <option v-for="asisten in allAsisten" :key="asisten.id" :value="asisten.id">
                  {{ asisten.kode }} [{{ asisten.nama }}]
                </option>
              </select>
            </div>
            <div class="w-1/2 h-full flex">
              <star-rating
                class="mr-auto ml-2 my-auto"
                style="width: 250px;"
                :model-value="laporanPraktikan.rating_asisten"
                :increment="0.01"
                :fixed-points="2"
                :show-rating="false"
                :star-size="50"
                @update:modelValue="onLaporanChange('rating_asisten', $event)"
              />
            </div>
          </div>
          <div class="w-3/4 h-2 bg-black m-auto mt-4 rounded-full" />
          <div class="w-3/4 mx-auto h-auto flex mt-4">
            <div class="w-1/2 h-auto flex-row">
              <div class="w-auto h-auto m-auto font-overpass-bold text-3xl text-center break-words">
                Bagaimana menurutmu <br /> praktikum saat ini ?
              </div>
              <div class="w-full h-auto flex mt-2">
                <star-rating
                  class="m-auto"
                  style="width: 250px;"
                  :model-value="laporanPraktikan.rating_praktikum"
                  :increment="0.01"
                  :fixed-points="2"
                  :show-rating="false"
                  :star-size="50"
                  @update:modelValue="onLaporanChange('rating_praktikum', $event)"
                />
              </div>
            </div>
            <div class="w-1/2 h-auto flex">
              <textarea
                :value="laporanPraktikan.pesan"
                cols="30"
                rows="5"
                class="font-overpass-mono-bold resize-none text-2xl bg-gray-600 appearance-none border-2 border-gray-300 rounded w-full h-full py-2 px-4 text-white leading-tight focus:outline-none focus:bg-gray-700 focus:border-teal-500"
                type="text"
                placeholder="Ketikkan feedback mengenai praktikum / asisten saat ini ..."
                @input="onLaporanChange('pesan', $event.target.value)"
              />
            </div>
          </div>
          <div class="w-full h-24 flex mt-4 mb-8">
            <div
              class="w-1/2 h-full mx-auto p-4 hover:p-5 cursor-pointer animation-enable-short"
              @click="$emit('finish-praktikum')"
            >
              <div class="w-full h-full flex rounded-full font-overpass-bold text-xl text-white pt-1 bg-green-600">
                <div class="m-auto">SELESAI</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PollingMode from './PollingMode.vue';
import QuestionBlock from '@/components/praktikan/QuestionBlock.vue';

export default {
  name: 'PraktikumSection',
  components: {
    PollingMode,
    QuestionBlock,
  },
  props: {
    isPollingEnabled: {
      type: Boolean,
      default: false,
    },
    pollingComplete: {
      type: Boolean,
      default: false,
    },
    currentUser: {
      type: Object,
      required: true,
    },
    isTotClass: {
      type: Boolean,
      default: false,
    },
    allAsisten: {
      type: Array,
      default: () => [],
    },
    allAsistenPolling: {
      type: Array,
      default: () => [],
    },
    allPolling: {
      type: Array,
      default: () => [],
    },
    currentPraktikum: {
      type: Object,
      required: true,
    },
    currentModul: {
      type: Object,
      required: true,
    },
    programmingQuote: {
      type: String,
      default: 'nothing',
    },
    quoteAuthor: {
      type: String,
      default: '',
    },
    modulShown: {
      type: Boolean,
      default: false,
    },
    showNilaiTa: {
      type: Boolean,
      default: false,
    },
    showNilaiTk: {
      type: Boolean,
      default: false,
    },
    taSubmissionFailed: {
      type: Boolean,
      default: false,
    },
    taSubmissionError: {
      type: String,
      default: '',
    },
    tkSubmissionFailed: {
      type: Boolean,
      default: false,
    },
    tkSubmissionError: {
      type: String,
      default: '',
    },
    soalFitb: {
      type: Array,
      default: () => [],
    },
    jawabanFitb: {
      type: Array,
      default: () => [],
    },
    soalJurnal: {
      type: Array,
      default: () => [],
    },
    jawabanJurnal: {
      type: Array,
      default: () => [],
    },
    soalRunmod: {
      type: Array,
      default: () => [],
    },
    jawabanRunmod: {
      type: Array,
      default: () => [],
    },
    soalMandiri: {
      type: Array,
      default: () => [],
    },
    jawabanMandiri: {
      type: Array,
      default: () => [],
    },
    soalTa: {
      type: Array,
      default: () => [],
    },
    jawabanTa: {
      type: Array,
      default: () => [],
    },
    soalTk: {
      type: Array,
      default: () => [],
    },
    jawabanTk: {
      type: Array,
      default: () => [],
    },
    laporanPraktikan: {
      type: Object,
      required: true,
    },
    nilaiTa: {
      type: [Number, String],
      default: '',
    },
    nilaiTk: {
      type: [Number, String],
      default: '',
    },
    generateScoreText: {
      type: Function,
      required: true,
    },
    selectedAnswers: {
      type: Object,
      default: () => ({}),
    },
    isTaRetrying: {
      type: Boolean,
      default: false,
    },
    isTkRetrying: {
      type: Boolean,
      default: false,
    },
  },
  emits: [
    'polling-saved',
    'finish-praktikum',
    'text-answer-change',
    'question-option-select',
    'update:modulShown',
    'update:showNilaiTa',
    'update:showNilaiTk',
    'update:laporanPraktikan',
    'retry-submit-ta',
    'retry-submit-tk',
  ],
  methods: {
    handlePollingSaved() {
      this.$emit('polling-saved');
    },
    emitQuestionOptionSelect(type, payload) {
      this.$emit('question-option-select', { type, payload });
    },
    emitTextAnswerChange(arrayName, payload) {
      this.$emit('text-answer-change', { arrayName, payload });
    },
    emitModulShown(value) {
      this.$emit('update:modulShown', value);
    },
    emitShowNilaiTa(value) {
      this.$emit('update:showNilaiTa', value);
    },
    emitShowNilaiTk(value) {
      this.$emit('update:showNilaiTk', value);
    },
    onLaporanChange(field, value) {
      const updated = {
        ...this.laporanPraktikan,
        [field]: value,
      };
      this.$emit('update:laporanPraktikan', updated);
    },
  },
  watch: {
    currentPraktikum: {
      handler(newVal, oldVal) {
        console.log('🔍 currentPraktikum changed:');
        console.log('  Old:', oldVal);
        console.log('  New:', newVal);
        console.log('  Status:', newVal.status, '(type:', typeof newVal.status, ')');
      },
      deep: true,
      immediate: true // This will log on component mount
    },
    'currentPraktikum.status'(newVal, oldVal) {
      console.log('📊 Status changed:', oldVal, '→', newVal, '(type:', typeof newVal, ')');
    }
  },
};
</script>
