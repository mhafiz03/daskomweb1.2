<template>
    <transition-group name="soal-list" tag="div">
        <div v-for="soal in filteredList" :key="soal.id" class="animation-enable w-full mb-4" :class="heightClass">
            <div class="w-full h-full flex rounded-lg bg-yellow-200">
                <!-- LEFT COLUMN -->
                <div :class="leftColClass">
                    <div v-if="['TP', 'TA', 'TK'].includes(layoutType)" class="flex font-merri-bold bg-yellow-400"
                        :class="titleSizeClass">
                        <div class="m-auto">{{ soal.judul }}</div>
                    </div>

                    <div v-if="['TP', 'TA', 'TK'].includes(layoutType)"
                        class="flex bg-yellow-300 font-overpass-mono-bold overflow-y-auto" :class="descSizeClass">
                        <div class="m-auto text-left p-4 break-words whitespace-pre-wrap">
                            <span>{{ soal.soal || soal.pertanyaan }}</span>
                        </div>
                    </div>

                    <div v-else class="w-full h-full flex font-merri-bold text-3xl bg-yellow-400 rounded-l-lg">
                        <div class="m-auto">
                            {{ soal.judul }}
                            <template v-if="layoutType === 'Jurnal'">
                                <br />{{ soal.isSulit ? '(Sulit)' : '(Sedang)' }}
                            </template>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div :class="rightColClass">
                    <template v-if="['TA', 'TK'].includes(layoutType)">
                        <div class="w-full h-full flex-row overflow-y-auto p-4 text-left font-overpass-bold text-xl">
                            <div v-for="(answer, idx) in answerList(soal)" :key="idx"
                                class="w-full h-auto break-words whitespace-pre-wrap mb-4 p-4 rounded-lg" :class="{
                                    'bg-green-500': answer.correct,
                                    'bg-red-500': !answer.correct
                                }">
                                <span>{{ answer.text }}</span>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="w-full h-full overflow-y-auto break-words whitespace-pre-wrap p-4 text-left font-overpass-bold"
                            :class="textSizeClass">
                            <span>{{ soal.soal }}</span>
                        </div>
                    </template>

                    <!-- Action Buttons -->
                    <SoalAction :soal="soal" :editPriviledge="editPriviledge" :currentUser="currentUser"
                        :commentCount="commentCount" @delete="$emit('delete', soal)" @edit="$emit('edit', soal)"
                        @toggle-comments="$emit('toggle-comments', soal)" />
                </div>
            </div>
        </div>
    </transition-group>
</template>

<script>
import SoalAction from '@/components/asisten/soal/SoalAction.vue';

export default {
    name: "SoalList",
    components: {
        SoalAction,
    },
    props: {
        list: Array,
        chosenModulID: {
            type: Number,
            default: 0
        },
        layoutType: String, // "TP", "TA", "TK", "Jurnal", "Mandiri", "FITB"
        editPriviledge: Array,
        currentUser: Object,
        commentCount: Number
    },
    computed: {
        filteredList() {
            return this.list.filter((item) => item.modul_id === this.chosenModulID);
        },
        heightClass() {
            return this.layoutType === "TP" ? "h-64" : "h-120";
        },
        leftColClass() {
            if (["TP"].includes(this.layoutType)) return "w-2/5 h-full flex-row";
            if (["TA", "TK"].includes(this.layoutType)) return "w-1/2 h-full flex-row";
            return "w-1/3 h-full flex-row";
        },
        rightColClass() {
            if (["TP"].includes(this.layoutType)) return "w-3/5 h-full flex";
            if (["TA", "TK"].includes(this.layoutType)) return "w-1/2 h-full flex";
            return "w-2/3 h-full flex";
        },
        titleSizeClass() {
            return this.layoutType === "TP" ? "text-2xl" : "text-xl";
        },
        descSizeClass() {
            return this.layoutType === "TP" ? "text-xl" : "text-lg";
        },
        textSizeClass() {
            return ["Jurnal", "Mandiri", "FITB"].includes(this.layoutType)
                ? "text-2xl"
                : "text-xl";
        }
    },
    methods: {
        answerList(soal) {
            return [
                { text: soal.jawaban_benar, correct: true },
                { text: soal.jawaban_salah1, correct: false },
                { text: soal.jawaban_salah2, correct: false },
                { text: soal.jawaban_salah3, correct: false }
            ];
        }
    },
};
</script>