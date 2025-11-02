<template>
  <div class="bg-green-900 w-full h-full overflow-hidden">

    <!-- Main Layout -->
    <div class="absolute my-auto z-40 h-full pointer-events-none flex animation-enable" :class="[{ 'right-0': pageActive },
    { 'right-minFull': !pageActive },
    { 'w-24full': !openWide },
    { 'w-full': openWide }]" @mouseover="isMenuShown = false">
      <div class="my-auto flex w-full pointer-events-none animation-enable" :class="[{ 'h-36full': !openWide },
      { 'h-4full': openWide }]">
        <div class="h-full w-12 flex pointer-events-auto">
          <div class="w-8 h-8 m-auto" :class="[{ 'visible': !praktikumExist },
          { 'hidden': praktikumExist }]">
            <span class="w-full h-full cursor-pointer" :class="[{ 'visible': !openWide },
            { 'hidden': openWide }]" v-on:click="openWide = true;">
              <img class="w-full h-full fas fa-caret-left text-white">
            </span>
            <span class="w-full h-full cursor-pointer" :class="[{ 'visible': openWide },
            { 'hidden': !openWide }]" v-on:click="openWide = false;">
              <img class="w-full h-full fas fa-caret-right text-white">
            </span>
          </div>
        </div>
        <div class="rounded-l-large h-full w-12full bg-yellow-200 pointer-events-auto overflow-y-auto">

          <!-- Profil Layout -->
          <div v-if="isProfil">
            <div class="h-auto w-full flex">
              <div class="ml-6 mt-6 flex-row w-auto h-auto whitespace-pre-wrap font-monda-bold text-5xl">
                <span>{{ currentUser.nama }}</span>
                <span class="font-merri-italic text-4xl mt-2"> ({{ currentUser.email }})</span>
              </div>
            </div>
            <div class="h-auto w-full flex-row pb-2" :class="[{ 'hidden': viewPassForm },
            { 'visible': !viewPassForm }]">
              <div class="h-1/3 w-full flex">
                <div class="w-auto h-auto ml-16 mt-8">
                  <span class="font-overpass text-3xl">Kelas : </span>
                  <span class="whitespace-pre-wrap font-overpass-bold text-3xl"> {{ currentUser.kelas }}</span>
                </div>
              </div>
              <div class="h-1/3 w-full flex">
                <div class="w-auto h-auto ml-16 mt-4">
                  <span class="font-overpass text-3xl">Nomor Telepon : </span>
                  <span class="whitespace-pre-wrap font-overpass-bold text-3xl"> {{ currentUser.nomor_telepon }}</span>
                </div>
              </div>
              <div class="h-1/3 w-full flex">
                <div class="w-auto h-auto ml-16 mt-4">
                  <span class="font-overpass text-3xl">Alamat : </span>
                  <span class="whitespace-pre-wrap font-overpass-bold text-3xl"> {{ currentUser.alamat }}</span>
                </div>
              </div>
            </div>
            <div class="h-1/3 w-full flex pb-4">
              <div class="w-auto h-auto ml-16 mt-4" :class="[{ 'hidden': viewPassForm },
              { 'visible': !viewPassForm }]">
                <span
                  class="font-overpass text-2xl bg-red-500 text-white p-3 pb-2 rounded-lg hover:bg-red-600 cursor-pointer duration-300 hover:duration-300"
                  v-on:click="formPassword(true)">Ganti Password<img class="ml-1 p-1 fas fa-pen fa-lg"></span>
              </div>
              <div class="w-auto h-auto ml-4 mt-4" :class="[{ 'hidden': viewPassForm },
              { 'visible': !viewPassForm }]">
                <span
                  class="font-overpass text-2xl bg-green-800 text-yellow-300 p-3 pb-2 rounded-lg hover:bg-green-600 cursor-pointer duration-300 hover:duration-300"
                  v-on:click='travel("contact-asisten")'>Kontak Asisten<img class="ml-1 p-1 fas fa-users fa-lg"></span>
              </div>
            </div>
            <div class="h-1/3 w-full flex-col pb-4" :class="[{ 'hidden': !viewPassForm },
            { 'visible': viewPassForm }]">
              <div class="w-2/3 h-auto ml-16 mt-2 flex-col">
                <div class="font-overpass-bold"> Input Password baru:</div>
                <input v-model="resetPass.password"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-1/4 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                  id="password" type="password" placeholder="******************">
              </div>
              <div class="w-2/3 h-auto ml-16 mt-2 flex-col">
                <div class="font-overpass-bold"> Ulangi Password baru:</div>
                <input v-model="resetPass.repeatpass"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-1/4 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                  id="repeatpass" type="password" placeholder="******************">
              </div>
              <div class="w-2/3 h-auto ml-16 mt-2 flex">
                <span
                  class="p-2 px-3 bg-red-600 font-merri-bold text-xl cursor-pointer text-white rounded-lg hover:bg-red-700 animation-enable"
                  v-on:click="formPassword(false)">
                  <img class="p-1 fas fa-times fa-lg">
                </span>
                <span
                  class="p-2 bg-green-600 font-merri-bold text-xl cursor-pointer text-white rounded-lg hover:bg-green-700 animation-enable mx-2"
                  v-on:click="resetPassword">
                  <img class="p-1 fas fa-check fa-lg">
                </span>
              </div>
            </div>
          </div>

          <!-- TP Layout -->
          <div v-if="isTP" class="w-full h-full flex">
            <div class="w-full h-full flex" v-if="!qrcodeShown">
              <div v-if="soalTPEssay.length === 0 && soalTPProgram.length === 0" class="w-full h-full flex">
                <div class="font-monda-bold h-auto w-auto m-auto text-center text-5xl">
                  Tidak ada <br> Tugas Pendahuluan saat ini <br>
                  <span class="text-xl">Silahkan cek kembali setelah ada pengumuman di OA line: @875lgds</span>
                </div>
              </div>

              <div class="h-full w-full flex-row relative" v-if="soalTPEssay.length > 0 && soalTPProgram.length > 0">
                <div class="w-full flex absolute top-0 rounded-tl-large animation-enable" :class="[{ 'bg-green-400 h-12': soalOpened },
                { 'bg-green-100 h-12full': !soalOpened }]">
                  <div class="w-full h-full relative flex">
                    <div
                      class="h-12 w-full select-none absolute bottom-0 flex pb-1 mx-auto font-overpass-mono-bold text-2xl animation-enable"
                      :class="[{ 'text-yellow-100 cursor-pointer': soalOpened },
                      { 'text-black': !soalOpened }]" v-on:click="soalOpened = false">
                      <span class="m-auto">PEMBAHASAN</span>
                    </div>
                    <div class="absolute top-0 w-full h-12full flex">
                      <div class="w-full h-full" v-scrollbar>
                        <div>
                          <div class="whitespace-pre-wrap break-words p-5 font-overpass text-2xl">
                            <span>{{ pembahasanTp.pembahasan }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="w-full flex absolute bottom-0 rounded-bl-large animation-enable" :class="[{ 'bg-green-100 h-12full': soalOpened },
                { 'bg-green-400 h-12': !soalOpened }]">
                  <div class="w-full h-full relative flex">
                    <div
                      class="h-12 z-30 w-full select-none absolute top-0 flex pt-1 font-overpass-mono-bold text-2xl animation-enable"
                      :class="[{ 'text-yellow-100 cursor-pointer': !soalOpened },
                      { 'text-black': soalOpened }]" v-on:click="soalOpened = true">
                      <span class="m-auto">SOAL <span class="font-overpass text-lg pt-0">(klik tombol simpan di paling
                          bawah untuk menyimpan)</span></span>
                    </div>
                    <div class="absolute bottom-0 w-full h-12full flex">
                      <div class="w-full h-full" v-scrollbar>
                        <div>
                          <QuestionBlock :questions="soalTPEssay" :answers="jawabanTP" :secure-text="true"
                            :praktikan-id="currentUser.id" :show-comments="isTotClass" tipe-soal="tp"
                            :on-answer-change="payload => onTextAnswerChange('jawabanTP', payload)" />

                          <QuestionBlock :questions="soalTPProgram" :answers="jawabanTP" :secure-text="true"
                            :praktikan-id="currentUser.id" :show-comments="isTotClass" tipe-soal="tp"
                            :numbering-offset="soalTPEssay.length" :answer-index-offset="soalTPEssay.length"
                            :on-answer-change="payload => onTextAnswerChange('jawabanTP', payload)" />

                          <div class="w-1/2 h-20 mx-auto">
                            <div class="w-full h-full p-4 cursor-pointer hover:p-5 animation-enable-short"
                              v-on:click="saveJawabanTP()">
                              <div
                                class="w-full h-full font-overpass-bold text-xl text-white flex pt-1 rounded-full bg-green-600">
                                <div class="m-auto">
                                  Simpan
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Nilai Layout -->
          <div v-if="isNilai" class="w-full h-full flex">
            <chart class="w-full h-full p-4" :chartdata="allNilaiData" :options="{
              responsive: true,
              maintainAspectRatio: false,

              scales: {
                y: {
                  beginAtZero: true,
                  grid: {
                    display: false,
                  },
                },
                x: {
                  grid: {
                    display: false,
                  },
                },
              }
            }">
            </chart>
          </div>

          <!--Jawaban Layout -->
          <JawabanSection v-if="isJawaban" :modules="all_modul" :current-module-id="currentJawabanJurnal"
            :answers="allJawabanJurnal" :ta-answers="jawabanTaAnswers" :tk-answers="jawabanTkAnswers"
            :answers-visible="jawabanShown" :answers-refreshing="jawabanChanged" :current-user="currentUser"
            @select-module="onJawabanModuleSelect" />

          <!-- Praktikum Layout -->
          <PraktikumSection v-if="isPraktikum" :is-polling-enabled="isPollingEnabled"
            :polling-complete="pollingComplete_mutable" :current-user="currentUser" :is-tot-class="isTotClass"
            :all-asisten="allAsisten" :all-asisten-polling="allAsistenPolling" :all-polling="allPolling"
            :current-praktikum="current_praktikum" :current-modul="current_modul" :programming-quote="programmingQuote"
            :quote-author="quoteAuthor" :modul-shown="modulShown" :show-nilai-ta="showNilaiTA"
            :show-nilai-tk="showNilaiTK" :soal-fitb="soalFitb" :jawaban-fitb="jawabanFitb" :soal-jurnal="soalJurnal"
            :jawaban-jurnal="jawabanJurnal" :soal-runmod="soalRunmod" :jawaban-runmod="jawabanRunmod"
            :soal-mandiri="soalMandiri" :jawaban-mandiri="jawabanMandiri" :soal-ta="soalTA" :jawaban-ta="jawabanTA"
            :soal-tk="soalTK" :jawaban-tk="jawabanTK" :laporan-praktikan="laporanPraktikan" :nilai-ta="nilaiTA"
            :nilai-tk="nilaiTK" :selected-answers="selectedAnswers" :generate-score-text="generateScoreText"
            @polling-saved="handlePollingSaved" @finish-praktikum="finishPraktikum"
            @text-answer-change="handleTextAnswerChange" @question-option-select="handleQuestionOptionSelect"
            @update:modulShown="value => modulShown = value" @update:showNilaiTa="value => showNilaiTA = value"
            @update:showNilaiTk="value => showNilaiTK = value"
            @update:laporanPraktikan="value => laporanPraktikan = value" />
        </div>
      </div>
    </div>

    <!-- Main Menu -->
    <div class="absolute w-24full right-0 h-16 flex animation-enable" :class="[{ 'bottom-0': pageActive },
    { 'bottom-min4rem': !pageActive }]">
      <div class="m-auto h-full w-3/5 flex">

        <!-- Dummy For Animation -->
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <!-- END -->

        <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-1/11': !isProfil },
        { 'w-9/11': isProfil }]" v-on:click="showProfil">
          <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-full': !isProfil },
          { 'w-1/2': isProfil }]">
            <div class="h-full animation-enable pointer-events-none" :class="[{ 'w-0': !isProfil },
            { 'w-9/12': isProfil }]" />
            <img
              class="profilIcon w-full iconYellowHover select-none cursor-pointer pointer-events-auto self-center h-8 fas fa-address-card animation-enable">
          </div>
          <span class="self-center text-left font-monda-bold text-lg text-white animation-enable-short" :class="[{ 'w-0 opacity-0 tracking-tighter': !isProfil },
          { 'w-1/2 opacity-100 tracking-widest': isProfil }]">
            Profil
          </span>
        </div>

        <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-1/11': !isPraktikum },
        { 'w-9/11': isPraktikum }]" v-on:click="showPraktikum">
          <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-full': !isPraktikum },
          { 'w-1/2': isPraktikum }]">
            <div class="h-full animation-enable pointer-events-none" :class="[{ 'w-0': !isPraktikum },
            { 'w-9/12': isPraktikum }]" />
            <img
              class="praktikumIcon w-full iconYellowHover select-none cursor-pointer pointer-events-auto self-center h-8 fas fa-code animation-enable">
          </div>
          <span class="self-center text-left font-monda-bold text-lg text-white animation-enable-short" :class="[{ 'w-0 opacity-0 tracking-tighter': !isPraktikum },
          { 'w-1/2 opacity-100 tracking-widest': isPraktikum }]">
            Praktikum
          </span>
        </div>

        <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-1/11': !isTP },
        { 'w-9/11': isTP }]" v-on:click="showTP">
          <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-full': !isTP },
          { 'w-1/2': isTP }]">
            <div class="h-full animation-enable pointer-events-none" :class="[{ 'w-0': !isTP },
            { 'w-9/12': isTP }]" />
            <img
              class="tpIcon w-full iconYellowHover select-none cursor-pointer pointer-events-auto self-center h-8 fas fa-file-code animation-enable">
          </div>
          <span class="self-center text-left font-monda-bold text-lg text-white animation-enable-short" :class="[{ 'w-0 opacity-0 tracking-tighter': !isTP },
          { 'w-1/2 opacity-100 tracking-widest': isTP }]">
            Tugas Pendahuluan
          </span>
        </div>

        <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-1/11': !isNilai },
        { 'w-9/11': isNilai }]" v-on:click="showNilai">
          <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-full': !isNilai },
          { 'w-1/2': isNilai }]">
            <div class="h-full animation-enable pointer-events-none" :class="[{ 'w-0': !isNilai },
            { 'w-9/12': isNilai }]" />
            <img
              class="nilaiIcon w-full iconYellowHover select-none cursor-pointer pointer-events-auto self-center h-8 fas fa-chart-area animation-enable">
          </div>
          <span class="self-center text-left font-monda-bold text-lg text-white animation-enable-short" :class="[{ 'w-0 opacity-0 tracking-tighter': !isNilai },
          { 'w-1/2 opacity-100 tracking-widest': isNilai }]">
            Nilai
          </span>
        </div>

        <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-1/11': !isJawaban },
        { 'w-9/11': isJawaban }]" v-on:click="showJawaban">
          <div class="h-full flex animation-enable pointer-events-none" :class="[{ 'w-full': !isJawaban },
          { 'w-1/2': isJawaban }]">
            <div class="h-full animation-enable pointer-events-none" :class="[{ 'w-0': !isJawaban },
            { 'w-9/12': isJawaban }]" />
            <img
              class="jawabanIcon w-full iconYellowHover select-none cursor-pointer pointer-events-auto self-center h-8 fas fa-book animation-enable">
          </div>
          <span class="self-center text-left font-monda-bold text-lg text-white animation-enable-short" :class="[{ 'w-0 opacity-0 tracking-tighter': !isJawaban },
          { 'w-1/2 opacity-100 tracking-widest': isJawaban }]">
            Jawaban
          </span>
        </div>

        <!-- Dummy For Animation -->
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <div class="h-full animation-enable" :class="[{ 'w-1/11': !isPraktikum && !isNilai && !isTP && !isProfil && !isJawaban },
        { 'w-0': isPraktikum || isNilai || isTP || isProfil || isJawaban }]" />
        <!-- END -->

      </div>
    </div>

    <!-- Profile Menu -->
    <div class="absolute top-0 right-0 z-40 w-24full h-24 flex" :class="[{ 'visible': isMenuShown && pageActive },
    { 'hidden': !isMenuShown }]" @mouseleave="isMenuShown = false">
      <div class="m-auto h-full w-56 flex-row bg-gray-600 mt-2 rounded-lg">
        <div class="w-full h-2/3" />
        <div class="w-full h-1/3 flex">
          <div class="rounded-b-lg bg-gray-400 flex hover:bg-gray-500 w-full h-full cursor-pointer"
            v-on:click="signOut">
            <span class="m-auto font-monda-bold text-sm text-right w-full">
              Logout
            </span>
            <i class="select-none fas fa-sign-out-alt text-2xl p-2 mr-16 m-auto"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Layout -->
    <div class="absolute right-0 w-24full h-16 flex animation-enable" :class="[{ 'top-0': pageActive },
    { 'top-min4rem': !pageActive },
    { 'z-40': !openWide },
    { 'z-0': openWide }]">
      <div class="m-auto h-12 mt-4 w-48 flex items-center font-monda-bold text-lg text-white">
        <span class="m-auto flex items-center z-10" @mouseover="isMenuShown = true">
          {{ currentUser.nim }}
          <div class="w-4" />
          <img class="select-none w-8 h-8 fas fa-arrow-circle-down" style="color: white;">
        </span>
      </div>
    </div>

    <!-- Message Layout -->
    <div class="absolute z-50 bottom-0 w-full h-full bg-black animation-enable pointer-events-none" :class="[{ 'opacity-75': messageOpened },
    { 'opacity-0': !messageOpened }]" />
    <div class="absolute z-50 w-full h-36 bg-gray-500 rounded-b-lg animation-enable" :class="[{ 'top-0': messageOpened },
    { ' top-min20rem': !messageOpened }]">
      <form id="messageForm" class="w-full h-full pl-24 flex">
        <div class="w-2/12 h-full flex-row py-4">
          <span class="font-merri w-full text-left text-lg h-1/4">
            Kode Asisten
          </span>
          <div class="w-full h-3/4">
            <input v-model="formMessage.kode"
              class="font-overpass-mono-bold uppercase text-5xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
              id="Kode" type="text" placeholder="FAI">
          </div>
        </div>
        <div class="w-9/12 h-full flex-row py-4 pl-4">
          <span class="font-merri w-full text-left text-lg h-1/4">
            Pesan Kepada
            <span class="uppercase">
              [ {{ formMessage.kode }} ]
            </span>
          </span>
          <div class="w-full h-3/4">
            <textarea v-model="secretMessage" cols="30" rows="10"
              class="font-overpass-mono-bold text-2xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
              :class="[{ 'hidden': formMessage.kode.toUpperCase() != 'FAI' },
              { 'visible': formMessage.kode.toUpperCase() == 'FAI' }]" id="Kode" type="text"
              placeholder="just for a test" />
            <textarea v-model="formMessage.pesan" cols="30" rows="10"
              class="font-overpass-mono-bold text-2xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
              :class="[{ 'hidden': formMessage.kode.toUpperCase() == 'FAI' },
              { 'visible': formMessage.kode.toUpperCase() != 'FAI' }]" id="Kode" type="text"
              placeholder="just for a test" />
          </div>
        </div>
        <div class="w-1/12 h-full">
          <span class="w-full h-full cursor-pointer" v-on:click="sendMessage">
            <img class="w-full h-full mt-4 p-8 fas fa-paper-plane" style="color: black;">
          </span>
        </div>
      </form>
    </div>

    <!-- Message Menu (OPEN) -->
    <span class="messageIcon absolute top-0 mt-6 ml-6 w-12 h-12 cursor-pointer animation-enable" :class="[{ 'left-min20rem': !pageActive || messageOpened },
    { 'left-0': pageActive && !messageOpened },
    { 'z-50': !openWide },
    { 'z-0': openWide }]" v-on:click="messageOpened = true">
      <img class="iconGreenHover w-full h-full fas fa-envelope">
    </span>

    <!-- Message Menu (CLOSE) -->
    <span class="messageIcon absolute left-0 mt-20 ml-5 w-12 h-12 p-0 hover:p-1 cursor-pointer animation-enable" :class="[{ 'top-0': messageOpened },
    { 'top-min20rem': !messageOpened },
    { 'z-50': !openWide },
    { 'z-0': openWide }]" v-on:click="messageOpened = false">
      <img class="w-full h-full fas fa-window-close" style="color: black;">
    </span>
  </div>
</template>
<style>
.youngYellowIcon {
  color: #faf089;
}

.iconGreenHover {
  color: #c6f6d5;
}

.iconGreenHover:hover {
  color: #48bb78;
}

.iconYellowHover {
  color: #d69e2e;
}

.iconYellowHover:hover {
  color: #faf089;
}

.bg-yellow-300-active:active {
  background-color: #faf089 !important;
}

.bg-yellow-300-nonActive:active {
  background-color: #b7791f !important;
}

.bg-yellow-500-Active:active {
  background-color: #ecc94b !important;
}
</style>

<script>
import debounce from 'lodash.debounce';
import { useToast } from '@/composables/useToast';
import QuestionBlock from '@/components/praktikan/QuestionBlock.vue';
import PraktikumSection from '@/components/praktikan/PraktikumSection.vue';
import JawabanSection from '@/components/praktikan/JawabanSection.vue';
export default {
  props: [
    'comingFrom',
    'currentUser',
    'isTotClass',
    'allAsisten',
    'allAsistenPolling',
    'isRunmod',
    'pollingComplete',
    'allPolling',
    'allModul',
    'allJurnal',
  ],

  components: {
    QuestionBlock,
    PraktikumSection,
    JawabanSection,
  },

  data() {
    return {
      pageActive: false,
      isPraktikum: false,
      isTP: false,
      isNilai: false,
      isJawaban: false,
      isProfil: false,
      isMenuShown: false,
      messageOpened: false,
      openWide: false,
      echoChannel: null,
      modulShown: false,

      currentJawabanJurnal: '',
      jawabanShown: false,
      jawabanChanged: false,

      isPollingEnabled: false,

      pollingComplete_mutable: this.pollingComplete,
      praktikumExist: false,

      current_praktikum: {
        kelas_id: '',
        modul_id: '',
        asisten_id: '',
        status: '',
      },

      current_modul: {
        judul: '',
        deskripsi: '',
        isi: '',
      },

      soalOpened: true,

      formMessage: {
        kode: '',
        pesan: '',
        praktikan_id: this.currentUser.id,
        kelas_id: this.currentUser.kelas_id,
      },

      all_modul: [],
      choosenModulID: '',
      allJawabanJurnal: [],

      programmingQuote: 'nothing',
      quoteAuthor: '',
      randomNumber: '',
      soalPresentasi: [],
      soalTA: [],
      soalTK: [],
      soalTPEssay: [],
      soalTPProgram: [],
      soalMandiri: [],
      soalJurnal: [],
      soalFitb: [],
      soalRunmod: [],

      jawabanTA: [],
      jawabanTK: [],

      // Reactive state for tracking selected answers
      selectedAnswers: {},

      chosenJawaban: [],
      jawabanPraktikan: {
        soal_id: '',
        jawaban: '',
      },

      pembahasanTp: {
        modul_id: '',
        pembahasan: '',
      },

      qrcodeData: {
        praktikan_id: '',
        modul_id: '',
        kelas_id: '',
        allJawaban_id: '',
      },

      ecnryptedData: '',
      qrcodeShown: false,

      jawabanFitb: [],
      jawabanJurnal: [],
      jawabanMandiri: [],
      jawabanTP: [],
      jawabanRunmod: [],
      jawabanTaAnswers: [],
      jawabanTkAnswers: [],

      laporanPraktikan: {
        pesan: '',
        rating_asisten: 0,
        rating_praktikum: 0,
        asisten_id: '',
        praktikan_id: '',
        modul_id: '',
      },

      allNilaiData: {
        labels: [],
        datasets: []
      },

      allNilaiTP: [],
      allNilaiTA: [],
      allNilaiJURNAL: [],
      allNilaiTK: [],
      allNilaiSKILL: [],
      allNilaiDISKON: [],

      showNilaiTA: false,
      showNilaiTK: false,

      nilaiTA: '',
      nilaiTK: '',

      goodScoreText: [
        "Mantap gini nih kalau sebelum praktikum belajar",
        "Wah beruntung apa gimana nih ?"
      ],

      badScoreText: [
        "Ayo lebih semangat lagi belajarnya!!!",
        "Waduh jangan mau kalah sama temen yang lain"
      ],

      secretMessage: 'VnRjdHggQU4gdnAgV1RZUCBxbGNsaGxqX2VjdHhwIG9weXJseSBhcGRseSA6IHF3bHJ7cGxkZXBjX3Bycl8xX290ZXB4ZnZseX0=',

      resetPass: {
        password: '',
        repeatpass: '',
      },

      viewPassForm: false,

    }
  },

  async mounted() {
    this.toast = useToast();

    const originalErrorToast = this.toast.error.bind(this.toast);
    this.toast.error = (message, options) => {
      const stackLines = new Error().stack?.split('\n') ?? [];
      const callSiteLine = stackLines.find((line) => line.includes('Praktikan.vue')) ?? stackLines[2] ?? '';
      const normalizedCallSite = callSiteLine.trim().replace(/^at\s+/i, '') || 'unknown source';
      const debugPrefix = `[Praktikan.vue -> ${normalizedCallSite}] `;

      console.error('[Praktikan Toast Error]', {
        message,
        callSite: normalizedCallSite,
        stack: stackLines.join('\n'),
      });

      return originalErrorToast(`${debugPrefix}${message ?? ''}`, options);
    };

    $('body').addClass('closed');
    this.showProfil();

    if (this.comingFrom === 'login' || this.comingFrom === 'none') {
      setTimeout(() => {
        this.pageActive = true;
      }, 10);
    }

    await this.initializePolling();
    await this.initializePraktikum();
    await this.initializeNilai();
    await this.initializeTpResources();
    this.setupRealtimeChannel();
  },

  beforeUnmount() {
    this.cleanupRealtimeChannel();
  },

  methods: {

    generateScoreText: function ($nilai) {

      if ($nilai > 50)
        return this.goodScoreText[Math.floor(Math.random() * this.goodScoreText.length)];
      else
        return this.badScoreText[Math.floor(Math.random() * this.badScoreText.length)];
    },

    handleTextAnswerChange(event) {

      if (!event || !event.arrayName) {
        return;
      }

      this.onTextAnswerChange(event.arrayName, event.payload || {});
    },

    handleQuestionOptionSelect(event) {

      if (!event || !event.type) {
        return;
      }

      this.onQuestionOptionSelect(event.type, event.payload || {});
    },

    async initializePolling() {
      try {
        const { data } = await this.$axios.post('/praktikan/polling/check');

        if (data.message === 'success') {
          this.isPollingEnabled = Boolean(data.isPollingEnabled);
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memeriksa status polling');
      }
    },

    async initializePraktikum() {
      try {
        const { data } = await this.$axios.post('/praktikum/check');

        if (data.message === 'success' && data.current_praktikum && data.current_praktikum.kelas_id === this.currentUser.kelas_id) {
          await this.setCurrentPraktikumState(data.current_praktikum, false);
        } else if (data.message !== 'success') {
          this.toast.error(data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memeriksa status praktikum');
      }
    },

    async initializeNilai() {
      try {
        const { data } = await this.$axios.post(`/praktikan/nilai/${this.currentUser.id}`);

        // if (data.message !== 'success') {
        //   if (data.message !== 'nope') {
        //     this.toast.error(data.message);
        //   }
        //   return;
        // }

        this.resetNilaiCollections();

        const nilaiList = Array.isArray(data.allNilai) ? data.allNilai : [];

        nilaiList.forEach((nilai) => {
          this.allNilaiData.labels.push(nilai.judul);
          this.allNilaiTP.push(nilai.tp);
          this.allNilaiTA.push(nilai.ta);
          this.allNilaiJURNAL.push(nilai.jurnal);
          this.allNilaiTK.push(nilai.tk);
          this.allNilaiSKILL.push(nilai.skill);
          this.allNilaiDISKON.push(nilai.diskon);
        });

        this.allNilaiData.datasets = this.buildNilaiDatasets();
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat data nilai');
      }
    },

    async initializeTpResources() {
      const isInternational = this.currentUser.kelas.substring(6, 10) === 'INT';

      this.all_modul = this.allModul
        .filter((modul) => (isInternational ? modul.isEnglish === 1 : modul.isEnglish === 0) && modul.id <= 20)
        .map((modul) => ({
          ...modul,
          isUnlocked: modul.isUnlocked === 1,
        }));

      await this.loadTpQuestions(isInternational);
      await this.loadTpDiscussion(isInternational);
    },

    async loadTpQuestions(isInternational) {
      const flag = isInternational ? 'true' : 'false';

      try {
        const { data } = await this.$axios.get(`/api/soal/tp/${flag}/${this.currentUser.id}`);

        // if (data.message !== 'success') {
        //   this.toast.error(data.message);
        //   return;
        // }

        const essayQuestions = data.all_soalEssay || [];
        const programQuestions = data.all_soalProgram || [];

        this.soalTPEssay = essayQuestions;
        this.soalTPProgram = programQuestions;
        this.jawabanTP = [];

        const appendAnswer = (soal) => {
          this.jawabanTP.push({
            soal_id: soal.soal_id == null ? soal.id : soal.soal_id,
            modul_id: soal.modul_id,
            praktikan_id: this.currentUser.id,
            jawaban: soal.jawaban ?? '',
          });
        };

        essayQuestions.forEach(appendAnswer);
        programQuestions.forEach(appendAnswer);
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal TP');
      }
    },

    async loadTpDiscussion(isInternational) {
      const flag = isInternational ? 'true' : 'false';

      try {
        const { data } = await this.$axios.post(`/tp/pembahasan/${flag}`);

        if (data.message === 'success' && data.tp) {
          this.pembahasanTp.modul_id = data.tp.modul_id;
          this.pembahasanTp.pembahasan = data.tp.pembahasan;
          this.qrcodeData.modul_id = data.tp.modul_id;
        } else if (data.message === 'nope') {
          this.pembahasanTp.modul_id = null;
          this.pembahasanTp.pembahasan = '';
          this.qrcodeData.modul_id = null;
          console.info('[TP Discussion] Pembahasan tidak diaktifkan saat ini.');
        } else if (data.message !== 'success') {
          this.pembahasanTp.modul_id = null;
          this.pembahasanTp.pembahasan = '';
          this.qrcodeData.modul_id = null;
          console.info('[TP Discussion] Pembahasan tidak tersedia:', data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat pembahasan TP');
      }
    },

    setupRealtimeChannel() {
      if (!window.Echo) {
        return;
      }

      this.cleanupRealtimeChannel();
      this.echoChannel = window.Echo
        .channel(`praktikum.${this.currentUser.kelas_id}`)
        .listen('.PraktikumStatusUpdated', (data) => {
          this.setCurrentPraktikumState(data.current_praktikum, true);
        });
    },

    cleanupRealtimeChannel() {
      if (window.Echo) {
        window.Echo.leave(`praktikum.${this.currentUser.kelas_id}`);
      }

      this.echoChannel = null;
    },

    resetNilaiCollections() {
      this.allNilaiData.labels = [];
      this.allNilaiData.datasets = [];

      this.allNilaiTP = [];
      this.allNilaiTA = [];
      this.allNilaiJURNAL = [];
      this.allNilaiTK = [];
      this.allNilaiSKILL = [];
      this.allNilaiDISKON = [];
    },

    buildNilaiDatasets() {
      const definitions = [
        { label: 'TP', data: this.allNilaiTP },
        { label: 'TA', data: this.allNilaiTA },
        { label: 'JURNAL', data: this.allNilaiJURNAL },
        { label: 'TK', data: this.allNilaiTK },
        { label: 'SKILL', data: this.allNilaiSKILL },
        { label: 'DISKON', data: this.allNilaiDISKON },
      ];

      return definitions.map(({ label, data }) => this.createDataset(label, data));
    },

    createDataset(label, data) {
      return {
        label,
        backgroundColor: 'rgba(75,192,192,0.1)',
        borderColor: '#00c853',
        pointBackgroundColor: 'black',
        borderWidth: 2,
        pointBorderColor: 'black',
        data: [...data],
      };
    },

    handleRequestError(error, fallbackMessage) {
      const errorCode = error?.code || '';
      const errorMessage = typeof error?.message === 'string' ? error.message.toLowerCase() : '';

      // Ignore cancellations or aborted requests
      if (errorCode === 'ERR_CANCELED' || error?.name === 'CanceledError' || errorMessage.includes('canceled')) {
        return;
      }

      if (error?.response?.data?.message) {
        this.toast.error(error.response.data.message);
      } else if (fallbackMessage) {
        this.toast.error(fallbackMessage);
      }
    },

    async loadCurrentModul() {
      try {
        const { data } = await this.$axios.post(`/modul/${this.current_praktikum.modul_id}`);

        if (data.message === 'success' && data.modul) {
          this.current_modul.judul = data.modul.judul;
          this.current_modul.deskripsi = data.modul.deskripsi;
          this.current_modul.isi = data.modul.isi;

          if (this.current_praktikum.status === 0) {
            await this.loadRandomQuote();
          }
        } else if (data.message !== 'success') {
          this.toast.error(data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat informasi modul');
      }
    },

    async loadRandomQuote() {
      try {
        const { data } = await this.$axios.get('http://api.quotable.io/random');
        if (data?.content && data?.author) {
          this.programmingQuote = data.content;
          this.quoteAuthor = data.author;
        }
      } catch (error) {
        // Mengabaikan kegagalan pemuatan kutipan agar tidak mengganggu alur utama.
      }
    },

    async submitJawaban(endpoint, payload, onSuccess) {
      try {
        const { data } = await this.$axios.post(endpoint, payload);

        if (data.message === 'success') {
          if (typeof onSuccess === 'function') {
            onSuccess(data);
          }
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        // Handle new robust controller error responses
        if (error.response?.status === 422) {
          this.toast.error(error.response.data.message || 'Data yang dikirim tidak valid');
        } else if (error.response?.status === 409) {
          this.toast.error(error.response.data.message || 'Tidak ada soal untuk modul ini');
        } else if (error.response?.status === 500) {
          this.toast.error(error.response.data.message || 'Terjadi kesalahan dalam penilaian');
        } else {
          this.handleRequestError(error, 'Gagal mengirim jawaban');
        }
      }
    },

    // Autosave functionality

    // Debounced autosave for MCQ (TA/TK)
    saveAutosave: debounce(async function (tipesoal) {
      if (!this.current_praktikum.modul_id) {
        return;
      }

      try {
        // Convert chosenJawaban array to object format {soal_id: answer}
        const jawabanObject = {};
        this.chosenJawaban.forEach(item => {
          if (item.soal_id && item.jawaban) {
            jawabanObject[item.soal_id] = item.jawaban;
          }
        });

        // Only save if there are answers
        if (Object.keys(jawabanObject).length === 0) {
          return;
        }

        const payload = {
          praktikan_id: this.currentUser.id,
          modul_id: this.current_praktikum.modul_id,
          tipe_soal: tipesoal,
          jawaban: jawabanObject
        };

        await this.$axios.post('/praktikan/autosave', payload);
      } catch (error) {
        // Silent fail for autosave to not interrupt user experience
        console.warn('[SAVE] Autosave failed:', error);
      }
    }, 500),

    async loadAutosave(tipesoal) {

      if (!this.current_praktikum.modul_id) {
        return {};
      }

      try {
        const requestParams = {
          praktikan_id: this.currentUser.id,
          modul_id: this.current_praktikum.modul_id,
          tipe_soal: tipesoal
        };

        const { data } = await this.$axios.get('/praktikan/autosave', {
          params: requestParams
        });

        // Find autosave entry for this tipe_soal
        const autosaveEntry = data.find(entry => entry.tipe_soal === tipesoal);

        const result = autosaveEntry ? autosaveEntry.jawaban : {};
        return result;
      } catch (error) {
        console.warn('[AUTOSAVE] Failed to load autosave:', error);
        return {};
      }
    },

    async clearAutosave(tipesoal = null) {
      if (!this.current_praktikum.modul_id) {
        return;
      }

      try {
        const payload = {
          praktikan_id: this.currentUser.id,
          modul_id: this.current_praktikum.modul_id
        };

        if (tipesoal) {
          payload.tipe_soal = tipesoal;
        }

        await this.$axios.delete('/praktikan/autosave/clear', { data: payload });
      } catch (error) {
        console.warn('Failed to clear autosave:', error);
      }
    },

    // Restore answers from autosave
    restoreAnswersFromAutosave(savedAnswers, soalType) {

      if (!savedAnswers || Object.keys(savedAnswers).length === 0) {
        return;
      }

      // Update chosenJawaban array with saved answers
      this.chosenJawaban.forEach((item, index) => {
        if (item.soal_id && savedAnswers[item.soal_id]) {
          item.jawaban = savedAnswers[item.soal_id];

          // Update reactive state instead of jQuery
          const jawabanArray = soalType === "TA" ? this.jawabanTA : this.jawabanTK;
          if (jawabanArray[index]) {
            const answerIndex = jawabanArray[index].indexOf(item.jawaban);
            if (answerIndex !== -1) {
              const key = `${index}-${answerIndex}`;
              this.selectedAnswers[key] = true;
            }
          }
        }
      });
    },

    // Debounced autosave for text-based answers (jurnal, fitb, mandiri)
    saveTextAutosave: debounce(async function (tipesoal, answersArray) {
      if (!this.current_praktikum.modul_id || !Array.isArray(answersArray)) {
        return;
      }

      try {
        // Convert answers array to object format {soal_id: answer}
        const jawabanObject = {};
        answersArray.forEach(item => {
          if (item.soal_id && item.jawaban) {
            jawabanObject[item.soal_id] = item.jawaban;
          }
        });

        // Only save if there are answers
        if (Object.keys(jawabanObject).length === 0) {
          return;
        }

        await this.$axios.post('/praktikan/autosave', {
          praktikan_id: this.currentUser.id,
          modul_id: this.current_praktikum.modul_id,
          tipe_soal: tipesoal,
          jawaban: jawabanObject
        });
      } catch (error) {
        // Silent fail for autosave to not interrupt user experience
        console.warn('Text autosave failed:', error);
      }
    }, 500),

    // Restore text answers from autosave
    restoreTextAnswersFromAutosave(savedAnswers, answersArray) {
      if (!savedAnswers || Object.keys(savedAnswers).length === 0 || !Array.isArray(answersArray)) {
        return;
      }

      // Update answers array with saved answers
      answersArray.forEach(item => {
        if (item.soal_id && savedAnswers[item.soal_id]) {
          item.jawaban = savedAnswers[item.soal_id];
        }
      });
    },

    // Question ID management to prevent refresh exploitation
    async storeQuestionIds(tipesoal, questionIds) {
      if (!this.current_praktikum.modul_id || this.isTotClass) {
        return; // Don't store for TOT classes
      }

      try {
        await this.$axios.post('/praktikan/autosave/questions', {
          praktikan_id: this.currentUser.id,
          modul_id: this.current_praktikum.modul_id,
          tipe_soal: tipesoal,
          question_ids: questionIds,
        });
      } catch (error) {
        console.warn('[QUESTION_IDS] Failed to store question IDs:', error);
      }
    },

    async getStoredQuestionIds(tipesoal) {
      if (!this.current_praktikum.modul_id || this.isTotClass) {
        return { has_stored_questions: false, question_ids: [] };
      }

      try {
        const { data } = await this.$axios.get('/praktikan/autosave/questions', {
          params: {
            praktikan_id: this.currentUser.id,
            modul_id: this.current_praktikum.modul_id,
            tipe_soal: tipesoal,
          }
        });

        return {
          has_stored_questions: data.has_stored_questions || false,
          question_ids: data.question_ids || [],
          created_at: data.created_at,
        };
      } catch (error) {
        console.warn('[QUESTION_IDS] Failed to get stored question IDs:', error);
        return { has_stored_questions: false, question_ids: [] };
      }
    },

    async loadSoalTa() {
      this.soalTA = [];
      this.jawabanTA = [];
      this.chosenJawaban = [];
      this.selectedAnswers = {}; // Clear selected answers
      
      try {
        let questions = [];
        
        // Check if we already have stored question IDs (to prevent refresh exploitation)
        const storedQuestions = await this.getStoredQuestionIds('ta');
        
        if (storedQuestions.has_stored_questions && storedQuestions.question_ids.length > 0) {
          // Use stored question IDs
          const { data } = await this.$axios.post('/api/soal/ta/by-ids', {
            question_ids: storedQuestions.question_ids,
            modul_id: this.current_praktikum.modul_id,
          });
          
          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
          }
        } else {
          // First visit - get random questions and store their IDs
          const { data } = await this.$axios.get(`/api/soal/ta/${this.current_praktikum.modul_id}/${this.current_praktikum.kelas_id}`);

          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
            
            // Store question IDs for future visits (only for non-TOT classes)
            if (questions.length > 0 && !this.isTotClass) {
              const questionIds = questions.map(q => q.id);
              await this.storeQuestionIds('ta', questionIds);
            }
          }
        }

        if (questions.length === 0) {
          this.toast.error(storedQuestions.has_stored_questions ? 'Stored questions not found' : 'No TA questions available');
          return;
        }

        this.soalTA = questions;

        if (questions.length === 0) {
          this.chosenJawaban.push({
            modul_id: this.current_praktikum.modul_id,
            praktikan_id: this.currentUser.id,
            soal_id: null,
            jawaban: '',
          });
        } else {
          questions.forEach((soal) => {
            const shuffledAnswers = this.shuffleArr([
              soal.jawaban_benar,
              soal.jawaban_salah1,
              soal.jawaban_salah2,
              soal.jawaban_salah3,
            ]);

            this.chosenJawaban.push({
              modul_id: this.current_praktikum.modul_id,
              praktikan_id: this.currentUser.id,
              soal_id: soal.id,
              jawaban: '',
            });

            this.jawabanTA.push(shuffledAnswers);
          });

          // Load autosaved answers
          const savedAnswers = await this.loadAutosave('ta');
          this.restoreAnswersFromAutosave(savedAnswers, 'TA');
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal TA');
      }
    },

    async loadSoalJurnalAndFitb() {
      await Promise.all([this.loadSoalJurnal(), this.loadSoalFitb()]);
    },

    async loadSoalJurnal() {
      this.soalJurnal = [];
      this.jawabanJurnal = [];
      try {
        const { data } = await this.$axios.get('/api/soal/jurnal');

        if (data.message !== 'success') {
          this.toast.error(data.message);
          return;
        }

        const list = (data.all_soal || []).filter(Boolean);
        this.soalJurnal = list;
        this.jawabanJurnal = list.map((soal) => ({
          soal_id: soal.id,
          modul_id: soal.modul_id,
          praktikan_id: this.currentUser.id,
          jawaban: '',
        }));

        // Load autosaved answers
        if (list.length > 0) {
          const savedAnswers = await this.loadAutosave('jurnal');
          this.restoreTextAnswersFromAutosave(savedAnswers, this.jawabanJurnal);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal Jurnal');
      }
    },

    async loadSoalFitb() {
      this.soalFitb = [];
      this.jawabanFitb = [];
      try {
        const { data } = await this.$axios.get('/api/soal/fitb');

        if (data.message !== 'success') {
          this.toast.error(data.message);
          return;
        }

        const list = (data.all_soal || []).filter(Boolean);
        this.soalFitb = list;
        this.jawabanFitb = list.map((soal) => ({
          soal_id: soal.id,
          modul_id: soal.modul_id,
          praktikan_id: this.currentUser.id,
          jawaban: '',
        }));

        // Load autosaved answers
        if (list.length > 0) {
          const savedAnswers = await this.loadAutosave('fitb');
          this.restoreTextAnswersFromAutosave(savedAnswers, this.jawabanFitb);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal FITB');
      }
    },

    async loadSoalMandiri() {
      this.soalMandiri = [];
      this.jawabanMandiri = [];
      
      try {
        let questions = [];
        
        // Check if we already have stored question IDs (to prevent refresh exploitation)
        const storedQuestions = await this.getStoredQuestionIds('mandiri');
        
        if (storedQuestions.has_stored_questions && storedQuestions.question_ids.length > 0) {
          // Use stored question IDs
          const { data } = await this.$axios.post('/api/soal/mandiri/by-ids', {
            question_ids: storedQuestions.question_ids,
            modul_id: this.current_praktikum.modul_id,
          });
          
          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
          }
        } else {
          // First visit - get random questions and store their IDs
          const { data } = await this.$axios.get(`/api/soal/mandiri/${this.current_praktikum.modul_id}/${this.current_praktikum.kelas_id}`);

          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
            
            // Store question IDs for future visits (only for non-TOT classes)
            if (questions.length > 0 && !this.isTotClass) {
              const questionIds = questions.map(q => q.id);
              await this.storeQuestionIds('mandiri', questionIds);
            }
          }
        }

        if (questions.length === 0) {
          this.toast.error(storedQuestions.has_stored_questions ? 'Stored questions not found' : 'No Mandiri questions available');
          return;
        }

        this.soalMandiri = questions;
        this.jawabanMandiri = questions.map((soal) => ({
          soal_id: soal.id,
          modul_id: soal.modul_id,
          praktikan_id: this.currentUser.id,
          jawaban: '',
        }));

        // Load autosaved answers
        if (questions.length > 0) {
          const savedAnswers = await this.loadAutosave('mandiri');
          this.restoreTextAnswersFromAutosave(savedAnswers, this.jawabanMandiri);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal Mandiri');
      }
    },

    async loadSoalTk() {
      this.soalTK = [];
      this.chosenJawaban = [];
      this.jawabanTK = [];
      this.selectedAnswers = {}; // Clear selected answers
      
      try {
        let questions = [];
        
        // Check if we already have stored question IDs (to prevent refresh exploitation)
        const storedQuestions = await this.getStoredQuestionIds('tk');
        
        if (storedQuestions.has_stored_questions && storedQuestions.question_ids.length > 0) {
          // Use stored question IDs
          const { data } = await this.$axios.post('/api/soal/tk/by-ids', {
            question_ids: storedQuestions.question_ids,
            modul_id: this.current_praktikum.modul_id,
          });
          
          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
          }
        } else {
          // First visit - get random questions and store their IDs
          const { data } = await this.$axios.get(`/api/soal/tk/${this.current_praktikum.modul_id}/${this.current_praktikum.kelas_id}`);

          if (data.message === 'success') {
            questions = Array.isArray(data.all_soal) ? data.all_soal : [];
            
            // Store question IDs for future visits (only for non-TOT classes)
            if (questions.length > 0 && !this.isTotClass) {
              const questionIds = questions.map(q => q.id);
              await this.storeQuestionIds('tk', questionIds);
            }
          }
        }

        if (questions.length === 0) {
          this.toast.error(storedQuestions.has_stored_questions ? 'Stored questions not found' : 'No TK questions available');
          return;
        }

        this.soalTK = questions;

        // Always ensure chosenJawaban has at least basic info for submission
        if (questions.length === 0) {
          // Add empty entry with praktikan_id and modul_id for empty questions
          this.chosenJawaban.push({
            modul_id: this.current_praktikum.modul_id,
            praktikan_id: this.currentUser.id,
            soal_id: null,
            jawaban: '',
          });
        } else {
          questions.forEach((soal) => {
            const answers = this.shuffleArr([
              soal.jawaban_benar,
              soal.jawaban_salah1,
              soal.jawaban_salah2,
              soal.jawaban_salah3,
            ]);

            this.chosenJawaban.push({
              modul_id: this.current_praktikum.modul_id,
              praktikan_id: this.currentUser.id,
              soal_id: soal.id,
              jawaban: '',
            });

            this.jawabanTK.push(answers);
          });

          // Load autosaved answers
          const savedAnswers = await this.loadAutosave('tk');
          this.restoreAnswersFromAutosave(savedAnswers, 'TK');
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal TK');
      }
    },

    async loadSoalRunmod() {
      this.soalRunmod = [];
      this.jawabanRunmod = [];
      try {
        const { data } = await this.$axios.get('/api/soal/runmod');

        if (data.message !== 'success') {
          this.toast.error(data.message);
          return;
        }

        const list = data.all_soal || [];
        this.soalRunmod = list;
        this.jawabanRunmod = list.map((soal) => ({
          soal_id: soal.id,
          modul_id: soal.modul_id,
          praktikan_id: this.currentUser.id,
          jawaban: '',
        }));
      } catch (error) {
        this.handleRequestError(error, 'Gagal memuat soal Runmod');
      }
    },

    async checkExistingLaporan() {
      try {
        const { data } = await this.$axios.post(`/praktikan/laporan/${this.currentUser.id}/${this.current_praktikum.modul_id}`);

        if (data.message === 'done') {
          this.current_praktikum.status = 777;
          this.praktikumExist = false;
          this.openWide = false;
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal memeriksa laporan praktikan');
      }
    },

    startPraktikum() {
      this.praktikumExist = true;
      this.showPraktikum();
      this.openWide = true;
    },

    async startTA() {
      await this.loadSoalTa();
    },

    async startJurnal(isRealtime) {
      if (isRealtime) {
        await this.submitJawaban('/praktikan/jawaban/ta', this.chosenJawaban, (data) => {
          this.nilaiTA = data.nilaiTa;
          this.showNilaiTA = true;
          // Clear TA autosave after successful submission
          this.clearAutosave('ta');
        });
      }

      await this.loadSoalJurnalAndFitb();
    },

    async startMandiri(isRealtime) {
      if (isRealtime) {
        await Promise.all([
          this.submitJawaban('/praktikan/jawaban/jurnal', this.jawabanJurnal, () => {
            this.clearAutosave('jurnal');
          }),
          this.submitJawaban('/praktikan/jawaban/fitb', this.jawabanFitb, () => {
            this.clearAutosave('fitb');
          }),
        ]);
      }

      await this.loadSoalMandiri();
    },

    async startTK(isRealtime) {
      if (isRealtime) {
        await this.submitJawaban('/praktikan/jawaban/mandiri', this.jawabanMandiri, () => {
          this.clearAutosave('mandiri');
        });
      }

      await this.loadSoalTk();
    },

    async startFeedback(isRealtime) {
      if (this.isRunmod) {
        if (isRealtime) {
          await this.submitJawaban('/praktikan/jawaban/jurnal', this.jawabanRunmod);
        }
      } else if (isRealtime) {
        await this.submitJawaban('/praktikan/jawaban/tk', this.chosenJawaban, (data) => {
          this.nilaiTK = data.nilaiTk;
          this.showNilaiTK = true;
          // Clear TK autosave after successful submission
          this.clearAutosave('tk');
        });
      }

      await this.checkExistingLaporan();
    },

    async handleStatusRunmod() {
      await this.loadSoalRunmod();
    },

    handleStatusDefault() {
      this.current_praktikum.status = 777;
      this.praktikumExist = false;
      this.openWide = false;
    },

    onTextAnswerChange(arrayName, payload) {

      const target = this[arrayName];
      if (!Array.isArray(target)) {
        return;
      }

      const { answerIndex, value } = payload;
      const entry = target[answerIndex];
      if (entry && typeof entry === 'object') {
        entry.jawaban = value;

        // Trigger autosave for text answers
        const tipesoalMap = {
          'jawabanJurnal': 'jurnal',
          'jawabanFitb': 'fitb',
          'jawabanMandiri': 'mandiri'
        };

        if (tipesoalMap[arrayName]) {
          this.saveTextAutosave(tipesoalMap[arrayName], target);
        }
      }
    },

    onQuestionOptionSelect(type, payload) {

      const question = payload.question || {};
      const soalId = question.id || question.soal_id || question.question_id || question.soalId;
      if (!soalId) {
        return;
      }

      this.chooseJawaban(
        type,
        payload.option,
        soalId,
        payload.questionIndex,
        payload.optionIndex,);
    },

    shuffleArr: function ($arr) {

      for (let i = $arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [$arr[i], $arr[j]] = [$arr[j], $arr[i]];
      }

      return $arr;
    },

    async saveJawabanTP() {

      try {
        const { data } = await this.$axios.post('/praktikan/tp/save-jawaban', this.jawabanTP);

        if (data.message === "success") {
          this.toast.success("TP ANDA BERHASIL DISIMPAN");
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal menyimpan jawaban TP');
      }
    },

    async finishPraktikum() {

      if (this.laporanPraktikan.asisten_id === '') {
        this.toast.error('Pilih asisten yang mengajar anda terlebih dahulu (dibagian paling atas samping kiri rating)');
        return;
      }

      if (this.laporanPraktikan.pesan === '') {
        this.toast.error('Masukkan pesan untuk praktikum / asisten terlebih dahulu');
        return;
      }

      if (this.laporanPraktikan.pesan.length < 20) {
        this.toast.error('Pesan berisi minimal 20 karakter');
        return;
      }

      if (this.laporanPraktikan.rating_asisten === 0) {
        this.toast.error('Beri rating untuk asisten terlebih dahulu');
        return;
      }

      if (this.laporanPraktikan.rating_praktikum === 0) {
        this.toast.error('Beri rating untuk praktikum terlebih dahulu');
        return;
      }

      this.laporanPraktikan.praktikan_id = this.currentUser.id;
      this.laporanPraktikan.modul_id = this.current_praktikum.modul_id;

      try {
        const { data } = await this.$axios.post('/praktikan/laporan', this.laporanPraktikan);

        if (data.message === "success") {
          this.current_praktikum.status = 777;

          // Clear all autosaved answers when praktikum ends
          await this.clearAutosave();

          this.toast.success("Praktikum telah selesai :)");
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        this.handleRequestError(error, 'Gagal mengirim laporan praktikum');
      }
    },

    setCurrentPraktikumState: async function (current_praktikum, isRealtime) {

      this.current_praktikum.asisten_id = current_praktikum.asisten_id;
      this.current_praktikum.modul_id = current_praktikum.modul_id;
      this.current_praktikum.kelas_id = current_praktikum.kelas_id;
      this.current_praktikum.status = current_praktikum.status;

      if (this.current_praktikum.kelas_id !== this.currentUser.kelas_id) {
        return;
      }

      await this.loadCurrentModul();

      switch (this.current_praktikum.status) {

        case 0:
          this.startPraktikum();
          break;

        case 1:
          await this.startTA();
          break;

        case 2:
          await this.startJurnal(isRealtime);
          break;

        case 3:
          await this.startMandiri(isRealtime);
          break;

        case 4:
          await this.startTK(isRealtime);
          break;

        case 5:
          await this.startFeedback(isRealtime);
          break;

        case 123:
          await this.handleStatusRunmod();
          break;

        default:
          this.handleStatusDefault();
          break;
      }
    },

    chooseJawaban: function ($soalType, $jawaban, $soalId, $soalIndex, $jawabanIndex) {
      // Determine which array to use based on soal type
      const jawabanArray = $soalType === "TA" ? this.jawabanTA : this.jawabanTK;

      // Find the corresponding chosen jawaban entry
      const chosenJawabanIndex = this.chosenJawaban.findIndex(item => item.soal_id === $soalId);

      if (chosenJawabanIndex !== -1) {
        const currentAnswer = this.chosenJawaban[chosenJawabanIndex].jawaban;

        // If there's a previous answer, clear its selection state
        if (currentAnswer !== '') {
          for (let i = 0; i < jawabanArray[chosenJawabanIndex].length; i++) {
            if (jawabanArray[chosenJawabanIndex][i] === currentAnswer) {
              const previousKey = `${chosenJawabanIndex}-${i}`;
              this.selectedAnswers[previousKey] = false;
              break;
            }
          }
        }

        // Update the answer in the chosen jawaban array
        this.chosenJawaban[chosenJawabanIndex].jawaban = $jawaban;

        // Set the new selection state
        const currentKey = `${$soalIndex}-${$jawabanIndex}`;
        this.selectedAnswers[currentKey] = true;

        // Trigger autosave after answer change
        this.saveAutosave($soalType.toLowerCase());
      }
    },

    handlePollingSaved() {
      this.pollingComplete_mutable = true;
    },

    showPraktikum: function () {

      this.isPraktikum = true;
      this.isTP = false;
      this.isNilai = false;
      this.isProfil = false;
      this.isJawaban = false;

      this.allJawabanJurnal = [];
      this.jawabanShown = false;
      this.currentJawabanJurnal = '';

      $('.tpIcon , .nilaiIcon , .profilIcon, .jawabanIcon').removeClass('w-3/12');
      $('.tpIcon , .nilaiIcon , .profilIcon, .jawabanIcon').removeClass('youngYellowIcon');
      $('.tpIcon , .nilaiIcon , .profilIcon, .jawabanIcon').addClass('iconYellowHover');
      $('.tpIcon , .nilaiIcon , .profilIcon, .jawabanIcon').addClass('w-full');

      $('.praktikumIcon').removeClass('w-full');
      $('.praktikumIcon').removeClass('iconYellowHover');
      $('.praktikumIcon').addClass('youngYellowIcon');
      $('.praktikumIcon').addClass('w-3/12');
    },

    showNilai: function () {
      this.isPraktikum = false;
      this.isTP = false;
      this.isNilai = true;
      this.isProfil = false;
      this.isJawaban = false;

      this.allJawabanJurnal = [];
      this.jawabanShown = false;
      this.currentJawabanJurnal = '';

      $('.praktikumIcon , .tpIcon , .profilIcon, .jawabanIcon').removeClass('w-3/12');
      $('.praktikumIcon , .tpIcon , .profilIcon, .jawabanIcon').removeClass('youngYellowIcon');
      $('.praktikumIcon , .tpIcon , .profilIcon, .jawabanIcon').addClass('iconYellowHover');
      $('.praktikumIcon , .tpIcon , .profilIcon, .jawabanIcon').addClass('w-full');

      $('.nilaiIcon').removeClass('w-full');
      $('.nilaiIcon').removeClass('iconYellowHover');
      $('.nilaiIcon').addClass('youngYellowIcon');
      $('.nilaiIcon').addClass('w-3/12');
    },

    showTP: function () {
      this.isPraktikum = false;
      this.isTP = true;
      this.isNilai = false;
      this.isProfil = false;
      this.isJawaban = false;

      this.allJawabanJurnal = [];
      this.jawabanShown = false;
      this.currentJawabanJurnal = '';

      $('.praktikumIcon , .nilaiIcon , .profilIcon, .jawabanIcon').removeClass('w-3/12');
      $('.praktikumIcon , .nilaiIcon , .profilIcon, .jawabanIcon').removeClass('youngYellowIcon');
      $('.praktikumIcon , .nilaiIcon , .profilIcon, .jawabanIcon').addClass('iconYellowHover');
      $('.praktikumIcon , .nilaiIcon , .profilIcon, .jawabanIcon').addClass('w-full');

      $('.tpIcon').removeClass('iconYellowHover');
      $('.tpIcon').removeClass('w-full');
      $('.tpIcon').addClass('youngYellowIcon');
      $('.tpIcon').addClass('w-3/12');
    },

    showProfil: function () {
      this.isPraktikum = false;
      this.isTP = false;
      this.isNilai = false;
      this.isProfil = true;
      this.isJawaban = false;

      this.allJawabanJurnal = [];
      this.jawabanShown = false;
      this.currentJawabanJurnal = '';

      $('.praktikumIcon , .nilaiIcon , .tpIcon, .jawabanIcon').removeClass('w-3/12');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .jawabanIcon').removeClass('youngYellowIcon');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .jawabanIcon').addClass('iconYellowHover');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .jawabanIcon').addClass('w-full');

      $('.profilIcon').removeClass('iconYellowHover');
      $('.profilIcon').removeClass('w-full');
      $('.profilIcon').addClass('youngYellowIcon');
      $('.profilIcon').addClass('w-3/12');
    },

    showJawaban: function () {
      this.isPraktikum = false;
      this.isTP = false;
      this.isNilai = false;
      this.isProfil = false;
      this.isJawaban = true;

      $('.praktikumIcon , .nilaiIcon , .tpIcon, .profilIcon').removeClass('w-3/12');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .profilIcon').removeClass('youngYellowIcon');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .profilIcon').addClass('iconYellowHover');
      $('.praktikumIcon , .nilaiIcon , .tpIcon, .profilIcon').addClass('w-full');

      $('.jawabanIcon').removeClass('iconYellowHover');
      $('.jawabanIcon').removeClass('w-full');
      $('.jawabanIcon').addClass('youngYellowIcon');
      $('.jawabanIcon').addClass('w-3/12');
    },

    onJawabanModuleSelect({ id, isUnlocked }) {

      this.jawabanChanged = Boolean(isUnlocked);

      setTimeout(() => {
        if (isUnlocked) {

          this.jawabanShown = true;
          this.currentJawabanJurnal = id;

          // Fetch jurnal answers
          this.$axios.post(`/praktikan/jawaban/jurnal/${this.currentUser.id}/${id}`).then(response => {
            if (response.data.message === "success") {
              this.allJawabanJurnal = response.data.allJawabanJurnal;
            } else {
              this.toast.error(response.data.message);
            }
          });

          // Fetch TA answers
          this.$axios.get(`/praktikan/jawaban/ta/${this.currentUser.id}/${id}`).then(response => {
            if (response.data.message === "success") {
              this.jawabanTaAnswers = response.data.data;
              console.log('TA Answers (Praktikan):', response.data.data);
            } else {
              console.log('Failed to fetch TA answers:', response.data.message);
              this.jawabanTaAnswers = [];
            }
          }).catch(error => {
            console.error('Error fetching TA answers:', error);
            this.jawabanTaAnswers = [];
          });

          // Fetch TK answers
          this.$axios.get(`/praktikan/jawaban/tk/${this.currentUser.id}/${id}`).then(response => {
            if (response.data.message === "success") {
              this.jawabanTkAnswers = response.data.data;
              console.log('TK Answers (Praktikan):', response.data.data);
            } else {
              console.log('Failed to fetch TK answers:', response.data.message);
              this.jawabanTkAnswers = [];
            }
          }).catch(error => {
            console.error('Error fetching TK answers:', error);
            this.jawabanTkAnswers = [];
          });
        }
      }, 250);

      setTimeout(() => {
        if (this.jawabanChanged === true)
          this.jawabanChanged = false;
      }, 1000);
    },

    travel: function ($whereTo) {
      setTimeout(() => {
        this.$inertia.get('/praktikan/' + $whereTo, {}, {
          replace: true,
        });
      }, 500);
    },

    signOut: function () {

      this.pageActive = false;
      this.isMenuShown = false;
      setTimeout(() => {
        this.$inertia.get('/auth/praktikan/logout', {}, {
          replace: true,
        });
      }, 1010);
    },

    async sendMessage() {

      try {
        const { data } = await this.$axios.post('/praktikan/pesan', this.formMessage);

        if (data.message === "success") {
          this.toast.success("Pesan berhasil terkirim");
          this.messageOpened = false;
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        const errors = error?.response?.data?.errors;
        if (errors) {
          if (errors.kode?.[0]) {
            this.toast.error(errors.kode[0]);
          }
          if (errors.pesan?.[0]) {
            this.toast.error(errors.pesan[0]);
          }
        } else {
          this.handleRequestError(error, 'Gagal mengirim pesan');
        }
      }
    },

    formPassword: function ($bool) {
      this.viewPassForm = $bool;
      if (!$bool) {
        this.resetPass.password = '';
        this.resetPass.repeatpass = '';
      }
    },

    async resetPassword() {
      try {
        const { data } = await this.$axios.post('/praktikan/reset-password', this.resetPass);

        if (data.message === "success") {
          this.toast.success("Password berhasil diperbaharui");
          this.signOut();
        } else {
          this.toast.error(data.message);
        }
      } catch (error) {
        const errors = error?.response?.data?.errors;
        if (errors) {
          if (errors.password?.[0])
            this.toast.error(errors.password[0]);
          if (errors.repeatpass?.[0])
            this.toast.error(errors.repeatpass[0]);
        } else {
          this.handleRequestError(error, 'Gagal memperbarui password');
        }
      }
    }
  }
}
</script>
