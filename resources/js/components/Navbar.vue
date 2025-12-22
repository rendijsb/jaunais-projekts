<template>
    <nav :class="['fixed top-0 left-0 w-full z-50 transition-all duration-300 border-b', isScrolled ? 'bg-white/90 backdrop-blur-md py-3 lg:py-4 border-stone-200 shadow-sm' : 'bg-transparent py-3 lg:py-5 border-transparent']">
        <div class="container mx-auto px-4 lg:px-6 flex items-center justify-between">
            <a href="#" class="text-2xl font-bold tracking-tighter text-stone-800">
                Skyline<span class="text-indigo-600">.</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-sm font-medium text-stone-600 hover:text-indigo-600 transition-colors">Sākums</a>
                <a href="#about" class="text-sm font-medium text-stone-600 hover:text-indigo-600 transition-colors">Par Projektu</a>
                <a href="#features" class="text-sm font-medium text-stone-600 hover:text-indigo-600 transition-colors">Priekšrocības</a>
                <a href="#gallery" class="text-sm font-medium text-stone-600 hover:text-indigo-600 transition-colors">Galerija</a>
            </div>

            <div class="hidden md:block">
                <button @click="$emit('open-contact')" class="px-5 py-2 bg-indigo-600 text-white rounded-full text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-md shadow-indigo-500/20">
                    Sazināties
                </button>
            </div>

            <button class="md:hidden text-stone-800" @click="isMobileMenuOpen = !isMobileMenuOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div v-if="isMobileMenuOpen" class="absolute top-full left-0 w-full bg-white border-b border-stone-200 p-6 md:hidden flex flex-col space-y-4 shadow-xl">
                <a href="#home" @click="isMobileMenuOpen = false" class="text-stone-600 hover:text-indigo-600">Sākums</a>
                <a href="#about" @click="isMobileMenuOpen = false" class="text-stone-600 hover:text-indigo-600">Par Projektu</a>
                <a href="#features" @click="isMobileMenuOpen = false" class="text-stone-600 hover:text-indigo-600">Priekšrocības</a>
                <a href="#gallery" @click="isMobileMenuOpen = false" class="text-stone-600 hover:text-indigo-600">Galerija</a>
                <button @click="$emit('open-contact'); isMobileMenuOpen = false" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold">
                    Sazināties
                </button>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

defineEmits(['open-contact']);

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>
