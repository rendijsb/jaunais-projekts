<template>
    <div class="relative w-full min-h-screen bg-stone-50 font-sans text-stone-800 selection:bg-indigo-500/30">
        <Navbar @open-contact="isContactModalOpen = true" />

        <section id="home" class="relative w-full lg:min-h-screen overflow-hidden bg-stone-50">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-indigo-200/30 rounded-full blur-[120px] animate-float"></div>
                <div class="absolute bottom-[-20%] left-[-10%] w-[800px] h-[800px] bg-orange-100/50 rounded-full blur-[120px] animate-float-delayed"></div>
                <div class="absolute top-[40%] left-[20%] w-[500px] h-[500px] bg-rose-100/30 rounded-full blur-[100px] animate-pulse-slow"></div>
                <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E')]"></div>
            </div>

            <div class="relative z-10 lg:min-h-screen">
                <div class="pt-20 pb-4 sm:pb-6 px-4 sm:px-6 bg-stone-50 relative z-10">
                    <div class="max-w-4xl mx-auto text-center">
                        <div class="inline-block px-3 py-1 mb-2 rounded-full bg-white/80 border border-stone-200 backdrop-blur-sm shadow-sm">
                            <span class="text-xs font-semibold tracking-widest uppercase text-stone-600">Premium Dzīvesveids</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl xl:text-5xl 2xl:text-6xl font-light mb-2 tracking-tight text-stone-800 leading-[0.95]">
                            Skyline
                            <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Tornis</span>
                        </h1>
                        <p class="text-stone-600 text-sm xl:text-base max-w-lg mx-auto leading-relaxed font-light mb-3">
                            Izvēlieties savu stāvu un atklājiet jaunas iespējas.
                        </p>

                        <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                            <button
                                @click="isContactModalOpen = true"
                                class="px-4 sm:px-5 py-2 sm:py-2.5 bg-stone-900 text-white rounded-xl font-semibold hover:bg-indigo-600 transition-all duration-300 shadow-lg shadow-stone-900/20 hover:shadow-indigo-600/30 flex items-center gap-2 text-sm"
                            >
                                <span>Sazināties</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <a
                                href="#about"
                                class="px-4 sm:px-5 py-2 sm:py-2.5 bg-white/90 text-stone-700 rounded-xl font-semibold hover:bg-white transition-all duration-300 border border-stone-200/50 text-sm backdrop-blur-sm shadow-sm"
                            >
                                Uzzināt vairāk
                            </a>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <InteractiveBuilding
                        :hovered-floor="hoveredFloor"
                        :selected-floor="selectedFloor"
                        @hover-floor="handleHoverFloor"
                        @select-floor="handleSelectFloor"
                        @open-contact="isContactModalOpen = true"
                        class="w-full"
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
