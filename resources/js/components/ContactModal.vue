<template>
    <transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" @click.self="$emit('close')">
            <transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-4"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-4"
            >
                <div class="relative w-full max-w-md bg-white border border-stone-200 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-stone-100 flex justify-between items-center bg-stone-50">
                        <h3 class="text-2xl font-light text-stone-800">Sazināties</h3>
                        <button @click="$emit('close')" class="text-stone-400 hover:text-stone-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <p class="text-stone-600 text-sm mb-4">
                            Interesē šis stāvs? Aizpildiet formu zemāk, un mēs ar jums sazināsimies tuvākajā laikā.
                        </p>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">Vārds</label>
                            <input type="text" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="Jūsu vārds">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">E-pasts</label>
                            <input type="email" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="jusu@epasts.lv">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">Ziņa</label>
                            <textarea rows="3" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="Es vēlos uzzināt vairāk par..."></textarea>
                        </div>
                    </div>

                    <div class="p-6 border-t border-stone-100 bg-stone-50">
                        <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                            Nosūtīt ziņu
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script setup>
defineProps({
    isOpen: Boolean
});

defineEmits(['close']);
</script>
