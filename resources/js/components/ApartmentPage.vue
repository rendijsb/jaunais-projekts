<template>
    <div class="min-h-screen bg-stone-50">
        <header class="bg-white border-b border-stone-200 sticky top-0 z-50">
            <div class="container mx-auto px-4 lg:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="/" class="flex items-center gap-2 text-stone-600 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="text-sm font-medium">Atpakaļ</span>
                    </a>
                </div>
                <a href="/" class="text-2xl font-bold tracking-tighter text-stone-800">
                    Skyline<span class="text-indigo-600">.</span>
                </a>
                <div class="w-20"></div>
            </div>
        </header>

        <div v-if="isLoading" class="flex items-center justify-center py-32">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-indigo-600 border-t-transparent"></div>
        </div>

        <main v-else-if="apartment" class="container mx-auto px-4 lg:px-6 py-8 lg:py-12">
            <nav class="mb-6">
                <ol class="flex items-center gap-2 text-sm text-stone-500">
                    <li><a href="/" class="hover:text-indigo-600 transition-colors">Sākums</a></li>
                    <li><span class="mx-1">/</span></li>
                    <li><span class="text-stone-800 font-medium">Dzīvoklis {{ apartment.flat_number }}</span></li>
                </ol>
            </nav>

            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                        <div class="p-4 border-b border-stone-100 flex items-center justify-between">
                            <h3 class="font-medium text-stone-800">{{ apartment.floor }}. stāva plāns</h3>
                            <span :class="statusBadgeClass">{{ statusLabel }}</span>
                        </div>
                        <div class="relative bg-stone-800 aspect-[4/3] flex items-center justify-center overflow-hidden">
                            <div class="relative w-full h-full flex items-center justify-center p-4">
                                <img
                                    ref="floorPlanRef"
                                    :src="`/images/floor-plans/floor-${apartment.floor}.jpg`"
                                    :alt="`${apartment.floor}. stāva plāns`"
                                    class="max-w-full max-h-full object-contain transition-opacity duration-500"
                                    :class="floorPlanLoaded ? 'opacity-30' : 'opacity-100'"
                                    @load="onFloorPlanLoad"
                                />
                                <svg
                                    v-if="floorPlanLoaded && apartmentCoords"
                                    class="absolute pointer-events-none"
                                    :style="floorPlanSvgStyle"
                                    :viewBox="floorPlanViewBox"
                                    preserveAspectRatio="none"
                                >
                                    <defs>
                                        <clipPath :id="`apartment-clip-${apartment.flat_number}`">
                                            <polygon :points="apartmentCoords" />
                                        </clipPath>
                                    </defs>
                                    <image
                                        :href="`/images/floor-plans/floor-${apartment.floor}.jpg`"
                                        :width="FLOOR_PLAN_WIDTH"
                                        :height="FLOOR_PLAN_HEIGHT"
                                        :clip-path="`url(#apartment-clip-${apartment.flat_number})`"
                                        preserveAspectRatio="none"
                                        class="apartment-highlight"
                                    />
                                    <polygon
                                        :points="apartmentCoords"
                                        :class="outlineClass"
                                    />
                                </svg>
                                <div
                                    v-if="floorPlanLoaded"
                                    class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-sm rounded-lg px-3 py-2 shadow-lg"
                                >
                                    <span class="text-xs text-stone-400 uppercase tracking-wider">Dzīvoklis</span>
                                    <span class="ml-2 text-lg font-semibold text-stone-900">{{ apartment.flat_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                        <div class="p-4 border-b border-stone-100">
                            <h3 class="font-medium text-stone-800">Dzīvokļa plāns</h3>
                        </div>
                        <div class="relative bg-stone-100 aspect-[4/3] flex items-center justify-center">
                            <div class="text-center text-stone-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm">Dzīvokļa detalizēts plāns</p>
                                <p class="text-xs mt-1">Drīzumā</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-sm font-medium text-stone-400 uppercase tracking-wider">Dzīvoklis</span>
                            <span :class="statusBadgeClass">{{ statusLabel }}</span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-light text-stone-900">
                            {{ apartment.flat_number }}<span class="text-stone-300">.</span>
                        </h1>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                        <h3 class="text-sm font-medium text-stone-400 uppercase tracking-wider mb-4">Pamatinformācija</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <div class="text-xs text-stone-400 uppercase tracking-wider mb-1">Stāvs</div>
                                <div class="text-2xl font-semibold text-stone-900">{{ apartment.floor }}</div>
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <div class="text-xs text-stone-400 uppercase tracking-wider mb-1">Platība</div>
                                <div class="text-2xl font-semibold text-stone-900">{{ apartment.flat_area }} <span class="text-base font-normal text-stone-500">m²</span></div>
                            </div>
                            <div v-if="apartment.terrace_area" class="p-4 bg-stone-50 rounded-xl">
                                <div class="text-xs text-stone-400 uppercase tracking-wider mb-1">Terase</div>
                                <div class="text-2xl font-semibold text-stone-900">{{ apartment.terrace_area }} <span class="text-base font-normal text-stone-500">m²</span></div>
                            </div>
                            <div v-if="apartment.balcony_area" class="p-4 bg-stone-50 rounded-xl">
                                <div class="text-xs text-stone-400 uppercase tracking-wider mb-1">Balkons</div>
                                <div class="text-2xl font-semibold text-stone-900">{{ apartment.balcony_area }} <span class="text-base font-normal text-stone-500">m²</span></div>
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl col-span-2">
                                <div class="text-xs text-stone-400 uppercase tracking-wider mb-1">Kopējā platība</div>
                                <div class="text-2xl font-semibold text-stone-900">{{ apartment.total_area }} <span class="text-base font-normal text-stone-500">m²</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-stone-900 to-stone-800 rounded-2xl p-6 text-white">
                        <div class="text-sm font-medium text-stone-400 uppercase tracking-wider mb-2">Cena</div>
                        <div class="text-4xl lg:text-5xl font-semibold mb-1">
                            {{ formatPrice(apartment.price) }} <span class="text-2xl font-normal text-stone-400">EUR</span>
                        </div>
                        <div class="text-sm text-stone-400">
                            {{ pricePerSqm }} EUR/m²
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                        <h3 class="text-sm font-medium text-stone-400 uppercase tracking-wider mb-4">Dokumenti</h3>
                        <button
                            class="w-full flex items-center justify-between p-4 bg-stone-50 rounded-xl hover:bg-stone-100 transition-colors group"
                            @click="downloadPdf"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-stone-800">Dzīvokļa specifikācija</div>
                                    <div class="text-sm text-stone-500">PDF dokuments</div>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-stone-400 group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                        <h3 class="text-sm font-medium text-stone-400 uppercase tracking-wider mb-4">Sazināties ar mums</h3>
                        <p class="text-stone-600 text-sm mb-6">
                            Interesē šis dzīvoklis? Sazinieties ar mūsu pārdošanas komandu, lai uzzinātu vairāk vai rezervētu apskati.
                        </p>
                        <div class="space-y-3">
                            <a href="tel:+37120000000" class="flex items-center gap-3 p-4 bg-stone-50 rounded-xl hover:bg-stone-100 transition-colors">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-stone-800">+371 20 000 000</div>
                                    <div class="text-sm text-stone-500">Zvanīt tagad</div>
                                </div>
                            </a>
                            <a href="mailto:info@skyline.lv" class="flex items-center gap-3 p-4 bg-stone-50 rounded-xl hover:bg-stone-100 transition-colors">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-stone-800">info@skyline.lv</div>
                                    <div class="text-sm text-stone-500">Rakstīt e-pastu</div>
                                </div>
                            </a>
                        </div>
                        <button
                            @click="showContactForm = true"
                            class="w-full mt-4 py-4 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20"
                        >
                            Pieteikties uz apskati
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <div v-else class="flex flex-col items-center justify-center py-32 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-stone-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h2 class="text-2xl font-semibold text-stone-800 mb-2">Dzīvoklis nav atrasts</h2>
            <p class="text-stone-500 mb-6">Atvainojiet, bet šis dzīvoklis neeksistē vai nav pieejams.</p>
            <a href="/" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
                Atgriezties uz sākumu
            </a>
        </div>

        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="showContactForm" class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" @click.self="showContactForm = false">
                    <Transition
                        enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 scale-95 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-4"
                    >
                        <div v-if="showContactForm" class="relative w-full max-w-md bg-white border border-stone-200 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="p-6 border-b border-stone-100 flex justify-between items-center bg-stone-50">
                                <h3 class="text-xl font-semibold text-stone-800">Pieteikties uz apskati</h3>
                                <button @click="showContactForm = false" class="text-stone-400 hover:text-stone-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-6 space-y-4">
                                <div class="p-3 bg-indigo-50 rounded-lg text-sm text-indigo-800">
                                    Dzīvoklis <strong>{{ apartment?.flat_number }}</strong> | {{ apartment?.flat_area }} m² | {{ formatPrice(apartment?.price) }} EUR
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">Vārds *</label>
                                    <input type="text" v-model="contactForm.name" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="Jūsu vārds">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">Tālrunis *</label>
                                    <input type="tel" v-model="contactForm.phone" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="+371 20 000 000">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">E-pasts</label>
                                    <input type="email" v-model="contactForm.email" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="jusu@epasts.lv">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-stone-500 uppercase tracking-wider">Ziņa</label>
                                    <textarea rows="3" v-model="contactForm.message" class="w-full bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" placeholder="Vēlamais apskates laiks vai jautājumi..."></textarea>
                                </div>
                            </div>

                            <div class="p-6 border-t border-stone-100 bg-stone-50">
                                <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                                    Nosūtīt pieteikumu
                                </button>
                            </div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, computed, inject, onMounted, watch } from 'vue';

const flatNumber = inject('flatNumber');
const apartment = ref(null);
const isLoading = ref(true);
const floorPlanRef = ref(null);
const floorPlanLoaded = ref(false);
const floorPlanDimensions = ref({ width: 0, height: 0 });
const showContactForm = ref(false);

const contactForm = ref({
    name: '',
    phone: '',
    email: '',
    message: ''
});

const FLOOR_PLAN_WIDTH = 8928;
const FLOOR_PLAN_HEIGHT = 4751;
const floorPlanViewBox = `0 0 ${FLOOR_PLAN_WIDTH} ${FLOOR_PLAN_HEIGHT}`;

const allApartmentCoords = {
    1: {
        101: "1439,3283 761,3283 753,3315 698,3315 698,3299 114,3299 122,2107 1147,2107 1155,2178 1447,2178",
        102: "1360,2068 1218,2076 1211,2115 114,2115 122,592 2149,592 2141,994 1826,994 1818,1215 1613,1215 1613,2312 1447,2312 1447,2115 1360,2115",
        103: "2252,2952 2252,1476 2133,1476 2141,994 1889,1002 1889,1215 2007,1215 2015,1286 1857,1286 1849,1231 1613,1231 1621,2960",
        104: "4689,923 4689,2123 5525,2123 5525,1010 5028,1010 5028,931",
        105: "2141,616 2133,1476 2259,1476 2252,2139 4334,2139 4334,1523 4499,1515 4499,1460 4484,1460 4491,1002 4491,639 4499,639 4499,616",
        106: "6810,3252 6029,3259 6029,3228 5485,3236 5485,2533 6006,2533 6006,2328 6802,2328",
    }
};

const apartmentCoords = computed(() => {
    if (!apartment.value) return null;
    const floorCoords = allApartmentCoords[apartment.value.floor];
    return floorCoords?.[apartment.value.flat_number] || null;
});

const statusLabel = computed(() => {
    if (!apartment.value) return '';
    switch (apartment.value.status) {
        case 'available': return 'Pieejams';
        case 'reserved': return 'Rezervēts';
        case 'sold': return 'Pārdots';
        default: return apartment.value.status;
    }
});

const statusBadgeClass = computed(() => {
    if (!apartment.value) return '';
    switch (apartment.value.status) {
        case 'available': return 'px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium';
        case 'reserved': return 'px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium';
        case 'sold': return 'px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium';
        default: return 'px-3 py-1 bg-stone-100 text-stone-700 rounded-full text-xs font-medium';
    }
});

const outlineClass = computed(() => {
    if (!apartment.value) return '';
    switch (apartment.value.status) {
        case 'available': return 'fill-none stroke-emerald-400 stroke-[4]';
        case 'reserved': return 'fill-none stroke-amber-400 stroke-[4]';
        case 'sold': return 'fill-none stroke-red-400 stroke-[4]';
        default: return 'fill-none stroke-indigo-400 stroke-[4]';
    }
});

const pricePerSqm = computed(() => {
    if (!apartment.value || !apartment.value.flat_area) return '0';
    const price = apartment.value.price / 100;
    const perSqm = Math.round(price / apartment.value.flat_area);
    return new Intl.NumberFormat('lv-LV').format(perSqm);
});

const formatPrice = (price) => {
    if (!price) return '0';
    return new Intl.NumberFormat('lv-LV').format(price / 100);
};

const onFloorPlanLoad = () => {
    floorPlanLoaded.value = true;
    if (floorPlanRef.value) {
        floorPlanDimensions.value = {
            width: floorPlanRef.value.offsetWidth,
            height: floorPlanRef.value.offsetHeight
        };
    }
};

const floorPlanSvgStyle = computed(() => {
    const { width, height } = floorPlanDimensions.value;
    if (!width || !height) return {};

    return {
        width: `${width}px`,
        height: `${height}px`,
        left: '50%',
        top: '50%',
        transform: 'translate(-50%, -50%)'
    };
});

const downloadPdf = () => {
    alert('PDF lejupielāde drīzumā būs pieejama.');
};

const fetchApartment = async () => {
    try {
        const response = await fetch(`/api/apartment/${flatNumber}`);
        if (!response.ok) {
            throw new Error('Apartment not found');
        }
        apartment.value = await response.json();
    } catch (error) {
        console.error('Error fetching apartment:', error);
        apartment.value = null;
    } finally {
        isLoading.value = false;
    }
};

watch(showContactForm, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    fetchApartment();
});
</script>

<style scoped>
svg polygon {
    vector-effect: non-scaling-stroke;
}

.apartment-highlight {
    filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
}
</style>
