<template>
    <div class="relative w-full min-h-screen bg-stone-50 font-sans text-stone-800 selection:bg-indigo-500/30">
        <Navbar @open-contact="isContactModalOpen = true" />

        <section id="home" class="relative w-full min-h-screen overflow-hidden bg-stone-50">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-indigo-200/30 rounded-full blur-[120px] animate-float"></div>
                <div class="absolute bottom-[-20%] left-[-10%] w-[800px] h-[800px] bg-orange-100/50 rounded-full blur-[120px] animate-float-delayed"></div>
                <div class="absolute top-[40%] left-[20%] w-[500px] h-[500px] bg-rose-100/30 rounded-full blur-[100px] animate-pulse-slow"></div>
                <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E')]"></div>
            </div>

            <div class="relative z-10 h-screen hidden lg:flex flex-col">
                <div class="flex-shrink-0 pt-16 pb-2 px-8 xl:px-16 relative z-20">
                    <div class="max-w-4xl mx-auto text-center">
                        <div class="inline-block px-3 py-1 mb-2 rounded-full bg-white/50 border border-stone-200 backdrop-blur-sm">
                            <span class="text-xs font-semibold tracking-widest uppercase text-stone-500">Premium Dzīvesveids</span>
                        </div>
                        <h1 class="text-4xl xl:text-5xl font-light mb-2 tracking-tight text-stone-900 leading-[0.95]">
                            Skyline
                            <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Tornis</span>
                        </h1>
                        <p class="text-stone-600 text-base max-w-lg mx-auto leading-relaxed font-light mb-3">
                            Izbaudiet luksusa dzīvi virsotnē. Izvēlieties savu stāvu un atklājiet jaunas iespējas.
                        </p>

                        <div class="flex flex-wrap justify-center gap-3">
                            <button
                                @click="isContactModalOpen = true"
                                class="px-5 py-2.5 bg-stone-900 text-white rounded-xl font-semibold hover:bg-indigo-600 transition-all duration-300 shadow-lg shadow-stone-900/10 hover:shadow-indigo-600/20 flex items-center gap-2 text-sm"
                            >
                                <span>Sazināties</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <a
                                href="#about"
                                class="px-5 py-2.5 bg-white/50 text-stone-700 rounded-xl font-semibold hover:bg-white transition-all duration-300 border border-stone-200 text-sm"
                            >
                                Uzzināt vairāk
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex-1 px-8 xl:px-16 pb-24 min-h-0">
                    <InteractiveBuilding
                        :hovered-floor="hoveredFloor"
                        :selected-floor="selectedFloor"
                        :floors-data="floorsData"
                        @hover-floor="handleHoverFloor"
                        @select-floor="handleSelectFloor"
                        @open-contact="isContactModalOpen = true"
                        class="w-full h-full"
                    />
                </div>
            </div>

            <div class="relative z-10 lg:hidden flex flex-col h-screen">
                <div class="flex-shrink-0 px-4 sm:px-6 md:px-12 pt-20 sm:pt-24 pb-3 sm:pb-4 text-center">
                    <div class="inline-block px-2.5 py-1 mb-3 sm:mb-4 rounded-full bg-white/50 border border-stone-200 backdrop-blur-sm">
                        <span class="text-[10px] sm:text-xs font-semibold tracking-widest uppercase text-stone-500">Premium Dzīvesveids</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-light mb-2 sm:mb-3 tracking-tight text-stone-900 leading-[0.95]">
                        Skyline
                        <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Tornis</span>
                    </h1>
                    <p class="text-stone-600 text-sm sm:text-base md:text-lg max-w-sm sm:max-w-md mx-auto leading-relaxed font-light mb-3 sm:mb-4">
                        Izvēlieties savu stāvu un atklājiet jaunas iespējas.
                    </p>

                    <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                        <button
                            @click="isContactModalOpen = true"
                            class="px-4 sm:px-5 py-2 sm:py-2.5 bg-stone-900 text-white rounded-lg sm:rounded-xl font-semibold hover:bg-indigo-600 transition-all duration-300 shadow-lg shadow-stone-900/10 flex items-center gap-2 text-xs sm:text-sm"
                        >
                            <span>Sazināties</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <a
                            href="#about"
                            class="px-4 sm:px-5 py-2 sm:py-2.5 bg-white/50 text-stone-700 rounded-lg sm:rounded-xl font-semibold hover:bg-white transition-all duration-300 border border-stone-200 text-xs sm:text-sm"
                        >
                            Uzzināt vairāk
                        </a>
                    </div>

                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-indigo-50 border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                        <span class="text-[10px] sm:text-xs font-medium text-indigo-600">Spiediet uz stāva</span>
                    </div>
                </div>

                <div class="flex-1 relative px-2 sm:px-4 pb-4">
                    <InteractiveBuilding
                        :hovered-floor="hoveredFloor"
                        :selected-floor="selectedFloor"
                        :floors-data="floorsData"
                        @hover-floor="handleHoverFloor"
                        @select-floor="handleSelectFloor"
                        @open-contact="isContactModalOpen = true"
                        class="w-full h-full"
                    />
                </div>
            </div>

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex-col items-center gap-2 text-stone-400 z-20 hidden lg:flex">
                <span class="text-[10px] uppercase tracking-widest">Ritināt</span>
                <div class="w-5 h-8 rounded-full border-2 border-stone-300 flex items-start justify-center p-1">
                    <div class="w-1 h-2 bg-stone-400 rounded-full animate-bounce"></div>
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
import { ref } from 'vue';
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

const floorsData = {
    1: {
        level: 1,
        status: 'Komerctelpas',
        units: '4 Vietas',
        price: '€2.5M - €5M',
        description: 'Premium klases tirdzniecības telpas ar augstu apmeklētāju plūsmu un tiešu piekļuvi no ielas.'
    },
    2: {
        level: 2,
        status: 'Biroji',
        units: '8 Biroji',
        price: '€1.2M - €3M',
        description: 'Mūsdienīgi biroji ar atvērtu plānojumu, bagātīgu dabisko apgaismojumu.'
    },
    3: {
        level: 3,
        status: 'Dzīvokļi',
        units: '6 Dzīvokļi',
        price: '€850K - €2.1M',
        description: 'Luksusa dzīvokļi ar panorāmas skatu uz pilsētu un privātiem balkoniem.'
    },
    4: {
        level: 4,
        status: 'Penthausi',
        units: '4 Penthausi',
        price: '€3.5M - €6M',
        description: 'Ekskluzīvi penthausi ar plašām terasēm un 360° panorāmas skatu.'
    },
    5: {
        level: 5,
        status: 'Sky Lounge',
        units: '2 Rezidences',
        price: '€8M - €12M',
        description: 'Izcilākās rezidences ar privātu baseinu, SPA zonu un nepārspējamu skatu.'
    }
};

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
