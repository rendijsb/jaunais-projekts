<template>
    <div class="relative w-full min-h-screen bg-stone-50 font-sans text-stone-800 selection:bg-indigo-500/30">
        <Navbar @open-contact="isContactModalOpen = true" />

        <section id="home" class="relative w-full h-screen overflow-hidden bg-stone-50">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-indigo-200/30 rounded-full blur-[120px] animate-float"></div>
                <div class="absolute bottom-[-20%] left-[-10%] w-[800px] h-[800px] bg-orange-100/50 rounded-full blur-[120px] animate-float-delayed"></div>
                <div class="absolute top-[40%] left-[20%] w-[500px] h-[500px] bg-rose-100/30 rounded-full blur-[100px] animate-pulse-slow"></div>

                <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E')]"></div>
            </div>

            <div class="relative z-10 w-full h-full flex flex-col md:flex-row pt-24 md:pt-0">

                <div class="w-full md:w-5/12 h-full px-8 md:pl-20 flex flex-col justify-center relative z-20 pointer-events-none">
                    <div class="mb-16 pointer-events-auto">
                        <div class="inline-block px-3 py-1 mb-6 rounded-full bg-white/50 border border-stone-200 backdrop-blur-sm">
                            <span class="text-xs font-semibold tracking-widest uppercase text-stone-500">Premium Dzīvesveids</span>
                        </div>
                        <h1 class="text-6xl md:text-8xl font-light mb-6 tracking-tight text-stone-900 leading-[0.9]">
                            Skyline<br/>
                            <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Tornis</span>
                        </h1>
                        <p class="text-stone-600 text-lg md:text-xl max-w-md leading-relaxed font-light">
                            Izbaudiet luksusa dzīvi virsotnē. Atklājiet jaunu perspektīvu Rīgas panorāmā.
                        </p>
                    </div>

                    <transition
                        enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 translate-y-8 scale-95"
                        enter-to-class="opacity-100 translate-y-0 scale-100"
                        leave-active-class="transition duration-300 ease-in"
                        leave-from-class="opacity-100 translate-y-0 scale-100"
                        leave-to-class="opacity-0 translate-y-8 scale-95"
                    >
                        <div v-if="activeFloorData" class="pointer-events-auto backdrop-blur-xl bg-white/80 border border-white/60 rounded-3xl p-8 shadow-2xl shadow-indigo-900/5 ring-1 ring-white/50 relative overflow-hidden group">
                            <div class="absolute -top-20 -right-20 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-colors duration-500"></div>

                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <span class="text-sm text-stone-400 uppercase tracking-wider font-medium">Izvēlētais Stāvs</span>
                                        <h2 class="text-4xl font-light text-stone-800 mt-1">{{ activeFloorData.level }}.</h2>
                                    </div>
                                    <span class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase bg-stone-900 text-white shadow-lg shadow-stone-900/20">
                                        {{ activeFloorData.status }}
                                    </span>
                                </div>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="p-3 rounded-2xl bg-stone-50 border border-stone-100">
                                            <span class="block text-xs text-stone-400 mb-1">Pieejamība</span>
                                            <span class="block text-lg font-semibold text-stone-800">{{ activeFloorData.units }}</span>
                                        </div>
                                        <div class="p-3 rounded-2xl bg-stone-50 border border-stone-100">
                                            <span class="block text-xs text-stone-400 mb-1">Cena no</span>
                                            <span class="block text-lg font-semibold text-stone-800">{{ activeFloorData.price.split(' - ')[0] }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <p class="text-sm text-stone-600 leading-relaxed font-medium">
                                            {{ activeFloorData.description }}
                                        </p>
                                    </div>

                                    <button @click="isContactModalOpen = true" class="w-full py-4 bg-stone-900 text-white rounded-2xl font-semibold hover:bg-indigo-600 transition-all duration-300 shadow-xl shadow-stone-900/10 hover:shadow-indigo-600/20 hover:-translate-y-0.5 flex items-center justify-center group/btn">
                                        <span>Rezervēt Apskati</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>

                <div class="w-full md:w-7/12 h-1/2 md:h-full relative flex items-center justify-center md:translate-x-10">
                    <InteractiveBuilding
                        :hovered-floor="hoveredFloor"
                        :selected-floor="selectedFloor"
                        @hover-floor="handleHoverFloor"
                        @select-floor="handleSelectFloor"
                        class="w-full h-full scale-90 md:scale-110 origin-center transition-transform duration-1000 ease-out"
                    />
                </div>
            </div>
        </section>

        <AboutSection />
        <FeaturesSection />
        <GallerySection />
        <Footer />

        <ContactModal
            :is-open="isContactModalOpen"
            @close="isContactModalOpen = false"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Navbar from './Navbar.vue';
import InteractiveBuilding from './InteractiveBuilding.vue';
import AboutSection from './AboutSection.vue';
import FeaturesSection from './FeaturesSection.vue';
import GallerySection from './GallerySection.vue';
import Footer from './Footer.vue';
import ContactModal from './ContactModal.vue';

const hoveredFloor = ref(null);
const selectedFloor = ref(null);
const isContactModalOpen = ref(false);

const floors = {
    1: {
        level: 1,
        status: 'Komerctelpas',
        units: '4 Vietas',
        price: '€2.5M - €5M',
        description: 'Premium klases tirdzniecības telpas ar augstu apmeklētāju plūsmu un tiešu piekļuvi no ielas. Ideāli piemērotas vadošajiem veikaliem.'
    },
    2: {
        level: 2,
        status: 'Biroji',
        units: '8 Biroji',
        price: '€1.2M - €3M',
        description: 'Mūsdienīgi biroji ar atvērtu plānojumu, bagātīgu dabisko apgaismojumu un vismodernākajām komunikācijām.'
    },
    3: {
        level: 3,
        status: 'Dzīvokļi',
        units: '6 Dzīvokļi',
        price: '€850K - €2.1M',
        description: 'Luksusa dzīvokļi ar panorāmas skatu uz pilsētu, privātiem balkoniem un ekskluzīvām ērtībām.'
    },
    4: {
        level: 4,
        status: 'Penthausi',
        units: '4 Penthausi',
        price: '€3.5M - €6M',
        description: 'Ekskluzīvi penthausi ar plašām terasēm, privātu liftu un 360° panorāmas skatu uz Rīgas vēsturisko centru.'
    },
    5: {
        level: 5,
        status: 'Sky Lounge',
        units: '2 Rezidences',
        price: '€8M - €12M',
        description: 'Izcilākās rezidences ar privātu baseinu, SPA zonu un nepārspējamu skatu. Augstākā līmeņa luksuss.'
    }
};

const activeFloorData = computed(() => {
    const floor = hoveredFloor.value || selectedFloor.value;
    return floor ? floors[floor] : null;
});

const handleHoverFloor = (floorNumber) => {
    hoveredFloor.value = floorNumber;
};

const handleSelectFloor = (floorNumber) => {
    selectedFloor.value = floorNumber === selectedFloor.value ? null : floorNumber;
};
</script>

<style scoped>
html {
    scroll-behavior: smooth;
}
</style>
