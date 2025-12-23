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

const floorPlanDimensionsMap = {
    1: { width: 8928, height: 4751 },
    2: { width: 7634, height: 4622 },
    3: { width: 7598, height: 4551 },
    4: { width: 7596, height: 4538 },
};

const getFloorDimensions = (floor) => {
    return floorPlanDimensionsMap[floor] || floorPlanDimensionsMap[1];
};

const FLOOR_PLAN_WIDTH = computed(() => apartment.value ? getFloorDimensions(apartment.value.floor).width : 8928);
const FLOOR_PLAN_HEIGHT = computed(() => apartment.value ? getFloorDimensions(apartment.value.floor).height : 4751);
const floorPlanViewBox = computed(() => `0 0 ${FLOOR_PLAN_WIDTH.value} ${FLOOR_PLAN_HEIGHT.value}`);

const allApartmentCoords = {
    1: {
        101: "1439,3282 761,3282 753,3314 698,3314 698,3298 114,3298 122,2106 1147,2106 1155,2177 1447,2177",
        102: "1360,2067 1218,2075 1211,2114 114,2114 122,591 2149,591 2141,993 1826,993 1818,1214 1613,1214 1613,2311 1447,2311 1447,2114 1360,2114",
        103: "2252,2951 2252,1475 2133,1475 2141,993 1889,1001 1889,1214 2007,1214 2015,1285 1857,1285 1849,1230 1613,1230 1621,2959",
        104: "4689,922 4689,2122 5525,2122 5525,1009 5028,1009 5028,930",
        105: "2141,615 2133,1475 2259,1475 2252,2138 4334,2138 4334,1522 4499,1514 4499,1459 4484,1459 4491,1001 4491,638 4499,638 4499,615",
        106: "6810,3251 6029,3258 6029,3227 5485,3235 5485,2532 6006,2532 6006,2327 6802,2327",
    },
    2: {
        201: "992,3799 924,3806 918,3880 851,3880 844,4323 904,4316 904,4323 824,4329 824,4423 911,4423 911,4457 2260,4457 2267,3202 1824,3202 1824,3249 1522,3255 1522,3443 998,3450 992,3591",
        202: "1015,2091 1015,3454 995,3487 995,3805 921,3805 921,3879 853,3879 840,4331 711,4324 705,4344 786,4338 779,4432 705,4432 705,4466 280,4466 273,4061 118,4061 118,3137 273,3137 273,2961 118,2961 118,2037 266,2037 273,2091",
        203: "1204,2280 1204,1200 1723,1187 1743,492 1055,93 880,404 1008,478 974,546 280,552 273,937 118,937 118,1861 273,1855 273,2084 1015,2091 1022,2280",
        204: "1190,2927 1858,2927 1858,2961 2013,2961 2013,2043 1858,2037 1858,1443 1723,1443 1723,1187 1204,1200",
        205: "4394,782 4394,1463 4232,1470 4232,1787 4225,1801 4218,2070 4232,2077 4225,2131 4191,2138 4191,2259 5088,2259 5088,1254 5581,1261 5574,465 4839,471 4839,606 4744,606 4569,606 4576,788",
        206: "4394,1456 4232,1463 4225,1483 4036,1490 4036,1645 3112,1645 3106,1497 2903,1490 2903,1166 2971,1166 2971,1058 3213,1058 3220,782 4394,782",
        207: "2896,1483 2876,1490 2876,1497 2977,1497 2971,1645 2053,1645 2053,1490 1878,1490 1871,1443 1723,1443 1723,519 1743,492 1588,397 1757,93 2290,397 2465,93 3261,552 3362,552 3362,782 3220,782 3220,1058 2964,1065 2964,1160 2896,1160",
        208: "6552,2853 6558,1686 6943,1686 6943,1483 7199,1483 7199,1767 7543,2361 7239,2536 7543,3069 7192,3272 7091,3110 7024,3137 6855,2853",
        209: "6053,4466 6053,4270 6039,4270 6039,3238 6255,3238 6268,2738 6552,2732 6558,2853 6855,2853 7024,3130 7091,3096 7192,3272 7239,3245 7543,3784 7186,3980 7105,3852 7044,3886 7044,4466",
        210: "6053,4466 5048,4473 5061,3204 5547,3191 5547,3123 5392,3123 5392,2698 5567,2698 5574,2077 6019,2064 6383,2070 6383,2732 6262,2745 6255,3231 6026,3238",
        211: "5574,2077 5574,2259 5088,2259 5088,1254 5581,1261 5581,465 6511,465 6511,1268 6053,1268 6053,2057",
    },
    3: {
        301: "977,3778 909,3785 903,3859 836,3859 829,4302 889,4295 889,4302 809,4308 809,4402 896,4402 896,4436 2245,4436 2252,3181 1809,3181 1809,3228 1507,3234 1507,3422 983,3429 977,3570",
        302: "1015,2091 1015,3454 995,3487 995,3805 921,3805 921,3879 853,3879 840,4331 711,4324 705,4344 786,4338 779,4432 705,4432 705,4466 280,4466 273,4061 118,4061 118,3137 273,3137 273,2961 118,2961 118,2037 266,2037 273,2091",
        303: "1204,2280 1204,1200 1723,1187 1743,492 1055,93 880,404 1008,478 974,546 280,552 273,937 118,937 118,1861 273,1855 273,2084 1015,2091 1022,2280",
        304: "1190,2927 1858,2927 1858,2961 2013,2961 2013,2043 1858,2037 1858,1443 1723,1443 1723,1187 1204,1200",
        305: "4394,782 4394,1463 4232,1470 4232,1787 4225,1801 4218,2070 4232,2077 4225,2131 4191,2138 4191,2259 5088,2259 5088,1254 5581,1261 5574,465 4839,471 4839,606 4744,606 4569,606 4576,788",
        306: "4394,1456 4232,1463 4225,1483 4036,1490 4036,1645 3112,1645 3106,1497 2903,1490 2903,1166 2971,1166 2971,1058 3213,1058 3220,782 4394,782",
        307: "2896,1483 2876,1490 2876,1497 2977,1497 2971,1645 2053,1645 2053,1490 1878,1490 1871,1443 1723,1443 1723,519 1743,492 1588,397 1757,93 2290,397 2465,93 3261,552 3362,552 3362,782 3220,782 3220,1058 2964,1065 2964,1160 2896,1160",
        308: "6552,2853 6558,1686 6943,1686 6943,1483 7199,1483 7199,1767 7543,2361 7239,2536 7543,3069 7192,3272 7091,3110 7024,3137 6855,2853",
        309: "6053,4466 6053,4270 6039,4270 6039,3238 6255,3238 6268,2738 6552,2732 6558,2853 6855,2853 7024,3130 7091,3096 7192,3272 7239,3245 7543,3784 7186,3980 7105,3852 7044,3886 7044,4466",
        310: "6053,4466 5048,4473 5061,3204 5547,3191 5547,3123 5392,3123 5392,2698 5567,2698 5574,2077 6019,2064 6383,2070 6383,2732 6262,2745 6255,3231 6026,3238",
        311: "5574,2077 5574,2259 5088,2259 5088,1254 5581,1261 5581,465 6511,465 6511,1268 6053,1268 6053,2057",
    },
    4: {
        401: "977,3778 909,3785 903,3859 836,3859 829,4302 889,4295 889,4302 809,4308 809,4402 896,4402 896,4436 2245,4436 2252,3181 1809,3181 1809,3228 1507,3234 1507,3422 983,3429 977,3570",
        402: "1015,2091 1015,3454 995,3487 995,3805 921,3805 921,3879 853,3879 840,4331 711,4324 705,4344 786,4338 779,4432 705,4432 705,4466 280,4466 273,4061 118,4061 118,3137 273,3137 273,2961 118,2961 118,2037 266,2037 273,2091",
        403: "1204,2280 1204,1200 1723,1187 1743,492 1055,93 880,404 1008,478 974,546 280,552 273,937 118,937 118,1861 273,1855 273,2084 1015,2091 1022,2280",
        404: "1190,2927 1858,2927 1858,2961 2013,2961 2013,2043 1858,2037 1858,1443 1723,1443 1723,1187 1204,1200",
        405: "4394,782 4394,1463 4232,1470 4232,1787 4225,1801 4218,2070 4232,2077 4225,2131 4191,2138 4191,2259 5088,2259 5088,1254 5581,1261 5574,465 4839,471 4839,606 4744,606 4569,606 4576,788",
        406: "4394,1456 4232,1463 4225,1483 4036,1490 4036,1645 3112,1645 3106,1497 2903,1490 2903,1166 2971,1166 2971,1058 3213,1058 3220,782 4394,782",
        407: "2896,1483 2876,1490 2876,1497 2977,1497 2971,1645 2053,1645 2053,1490 1878,1490 1871,1443 1723,1443 1723,519 1743,492 1588,397 1757,93 2290,397 2465,93 3261,552 3362,552 3362,782 3220,782 3220,1058 2964,1065 2964,1160 2896,1160",
        408: "6552,2853 6558,1686 6943,1686 6943,1483 7199,1483 7199,1767 7543,2361 7239,2536 7543,3069 7192,3272 7091,3110 7024,3137 6855,2853",
        409: "6053,4466 6053,4270 6039,4270 6039,3238 6255,3238 6268,2738 6552,2732 6558,2853 6855,2853 7024,3130 7091,3096 7192,3272 7239,3245 7543,3784 7186,3980 7105,3852 7044,3886 7044,4466",
        410: "6053,4466 5048,4473 5061,3204 5547,3191 5547,3123 5392,3123 5392,2698 5567,2698 5574,2077 6019,2064 6383,2070 6383,2732 6262,2745 6255,3231 6026,3238",
        411: "5574,2077 5574,2259 5088,2259 5088,1254 5581,1261 5581,465 6511,465 6511,1268 6053,1268 6053,2057",
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
