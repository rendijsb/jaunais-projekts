<template>
    <div class="hidden lg:flex w-full h-full items-stretch" ref="containerRef">
        <div class="w-72 flex-shrink-0 flex items-center pr-6">
            <div class="w-full">
                <div
                    v-if="activeFloorData && showCard"
                    class="backdrop-blur-xl bg-white/95 border border-white/60 rounded-2xl p-5 shadow-2xl shadow-black/10 ring-1 ring-black/5 transition-opacity duration-200"
                >
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="text-xs text-stone-400 uppercase tracking-wider font-medium">Stāvs</span>
                            <h3 class="text-2xl font-light text-stone-800">{{ activeFloorData.level }}.</h3>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase bg-stone-900 text-white">
                            {{ activeFloorData.status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <div class="p-2 rounded-xl bg-stone-50 border border-stone-100">
                            <span class="block text-[10px] text-stone-400 mb-0.5">Pieejamība</span>
                            <span class="block text-sm font-semibold text-stone-800">{{ activeFloorData.units }}</span>
                        </div>
                        <div class="p-2 rounded-xl bg-stone-50 border border-stone-100">
                            <span class="block text-[10px] text-stone-400 mb-0.5">Cena no</span>
                            <span class="block text-sm font-semibold text-stone-800">{{ activeFloorData.price.split(' - ')[0] }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-stone-500 leading-relaxed mb-3">
                        {{ activeFloorData.description }}
                    </p>

                    <button
                        @click.stop="$emit('open-contact')"
                        class="w-full py-2.5 bg-stone-900 text-white text-sm rounded-xl font-semibold hover:bg-indigo-600 transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <span>Uzzināt vairāk</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
                <div v-else class="border-2 border-dashed border-stone-200 rounded-2xl p-5 text-center transition-opacity duration-200">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-stone-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="text-sm text-stone-400 font-medium">Izvēlieties stāvu</p>
                    <p class="text-xs text-stone-300 mt-1">Virziet kursoru uz ēkas</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-end justify-center h-full min-h-0">
            <div class="relative flex items-end justify-center h-full w-full" ref="imageContainerRef">
                <img
                    ref="imageRef"
                    src="/images/building.jpg"
                    alt="Luxury Building"
                    class="max-h-full max-w-full w-auto object-contain drop-shadow-2xl"
                    @load="onImageLoad"
                />

                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[60%] h-16 bg-indigo-500/20 blur-[40px] rounded-[100%] z-0"></div>

                <svg
                    v-if="imageLoaded && imageRef"
                    class="absolute z-30"
                    :style="svgStyle"
                    viewBox="0 0 3840 2160"
                    preserveAspectRatio="none"
                >
                    <polygon
                        v-for="floor in [5, 4, 3, 2, 1]"
                        :key="floor"
                        :points="floors[floor]"
                        :class="getFloorClass(floor)"
                        @mouseenter="handleFloorHover(floor, $event)"
                        @mouseleave="handleFloorLeave"
                        @click="handleFloorClick(floor)"
                    />
                </svg>
            </div>
        </div>
    </div>

    <div class="lg:hidden relative w-full h-full flex items-center justify-center">
        <div class="relative inline-block">
            <img
                src="/images/building.jpg"
                alt="Luxury Building"
                class="max-w-full max-h-full object-contain block drop-shadow-2xl"
                @load="onImageLoad"
            />

            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[80%] h-20 bg-indigo-500/20 blur-[50px] rounded-[100%] z-0"></div>

            <svg
                v-if="imageLoaded"
                class="absolute top-0 left-0 w-full h-full z-30"
                viewBox="0 0 3840 2160"
                preserveAspectRatio="none"
            >
                <polygon
                    v-for="floor in [5, 4, 3, 2, 1]"
                    :key="floor"
                    :points="floors[floor]"
                    :class="getFloorClass(floor)"
                    @click="handleFloorClick(floor)"
                    @touchstart.passive="handleFloorClick(floor)"
                />
            </svg>
        </div>
    </div>

    <Teleport to="body">
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="translate-y-full"
            enter-to-class="translate-y-0"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="translate-y-0"
            leave-to-class="translate-y-full"
        >
            <div
                v-if="activeFloorData && showCard && isMobile"
                class="fixed bottom-0 left-0 right-0 z-[9999] p-3 sm:p-4"
                style="padding-bottom: max(12px, env(safe-area-inset-bottom));"
            >
                <div class="backdrop-blur-xl bg-white border border-stone-200 rounded-2xl p-3 sm:p-4 shadow-2xl shadow-black/20 max-w-md mx-auto">
                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                        <div class="w-8 sm:w-10 h-1 bg-stone-300 rounded-full"></div>
                        <button
                            @click.stop="closeCard"
                            class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center rounded-full bg-stone-100 text-stone-500 hover:bg-stone-200 transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-start gap-2 sm:gap-3 mb-2 sm:mb-3">
                        <div class="flex-shrink-0">
                            <span class="text-[9px] sm:text-[10px] text-stone-400 uppercase tracking-wider font-medium">Stāvs</span>
                            <h3 class="text-xl sm:text-2xl font-light text-stone-800 leading-tight">{{ activeFloorData.level }}.</h3>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block px-2 py-0.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold tracking-wide uppercase bg-stone-900 text-white mb-1">
                                {{ activeFloorData.status }}
                            </span>
                            <p class="text-[11px] sm:text-xs text-stone-500 leading-snug line-clamp-2">
                                {{ activeFloorData.description }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2 mb-2 sm:mb-3">
                        <div class="flex-1 p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-stone-50 border border-stone-100">
                            <span class="block text-[9px] sm:text-[10px] text-stone-400">Pieejamība</span>
                            <span class="block text-xs sm:text-sm font-semibold text-stone-800">{{ activeFloorData.units }}</span>
                        </div>
                        <div class="flex-1 p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-stone-50 border border-stone-100">
                            <span class="block text-[9px] sm:text-[10px] text-stone-400">Cena no</span>
                            <span class="block text-xs sm:text-sm font-semibold text-stone-800">{{ activeFloorData.price.split(' - ')[0] }}</span>
                        </div>
                    </div>

                    <button
                        @click.stop="$emit('open-contact')"
                        class="w-full py-2 sm:py-2.5 bg-stone-900 text-white text-xs sm:text-sm rounded-lg sm:rounded-xl font-semibold hover:bg-indigo-600 active:bg-indigo-700 transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <span>Sazināties</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>
    </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    hoveredFloor: {
        type: Number,
        default: null
    },
    selectedFloor: {
        type: Number,
        default: null
    },
    floorsData: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['select-floor', 'hover-floor', 'open-contact']);

const imageRef = ref(null);
const imageContainerRef = ref(null);
const containerRef = ref(null);
const imageLoaded = ref(false);
const showCard = ref(false);
const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

const onImageLoad = () => {
    imageLoaded.value = true;
};

const floors = {
    1: "180,1467 207,1477 210,1680 980,1701 1303,1599 1309,1524 1387,1497 1442,1480 1513,1484 1693,1484 1947,1487 1957,1504 2042,1504 2059,1521 2327,1521 2361,1578 2412,1656 2442,1701 2500,1707 2554,1741 3633,1772 3633,1524 3681,1504 2503,1494 2368,1439 2364,1399 1995,1399 1676,1399 1479,1395 1309,1416 1113,1456 977,1480",
    2: "58,1463 980,1477 1309,1419 1435,1402 1479,1389 1710,1399 2364,1399 2364,1436 2497,1494 3813,1504 3809,1375 3718,1372 3721,1226 3813,1226 3809,1209 2500,1216 2364,1243 2364,1260 2364,1243 2398,1253 2405,1256 2330,1263 1459,1266 1411,1263 974,1219 58,1226 58,1248 170,1248 170,1360 58,1363",
    3: "54,1226 977,1219 1425,1260 2364,1258 2392,1238 2500,1217 3813,1211 3809,1095 3718,1095 3718,970 3813,949 3813,926 2500,956 2368,1068 2364,1082 2398,1082 2402,1122 2042,1126 2046,1136 2042,1126 2046,1143 1737,1146 1459,1150 1428,1150 1303,1112 1306,1078 980,990 58,1007 58,1031 166,1048 170,1143 58,1146",
    4: "58,1007 980,990 1309,1075 1303,1112 1428,1150 2039,1139 2049,1126 2398,1122 2395,1082 2364,1078 2364,1072 2497,956 3813,926 3809,821 3718,821 3718,705 3813,671 3813,627 2500,685 2364,878 2364,909 2405,912 2405,956 2049,963 2046,987 1428,1004 1425,1021 1275,953 1279,943 1306,936 1313,905 977,746 58,777 58,810 166,841 166,926 61,929",
    5: "54,777 977,746 1309,902 1309,936 1275,949 1428,1021 1432,1004 2049,987 2049,963 2405,956 2405,909 2368,905 2368,871 2500,685 3813,627 3813,502 3718,505 3721,482 3694,485 3674,498 3616,471 3555,498 3511,478 3579,437 3572,417 3518,417 2771,458 2724,465 2656,559 2507,566 2371,804 2368,814 2096,821 2096,831 2052,834 2052,868 1747,875 1737,861 1713,865 1720,878 1391,888 1394,868 1350,868 1343,858 1350,861 1313,858 1309,838 980,637 47,682 51,743"
};

const defaultFloorsData = {
    1: { level: 1, status: 'Komerctelpas', units: '4 Vietas', price: '€2.5M - €5M', description: 'Premium klases tirdzniecības telpas ar augstu apmeklētāju plūsmu.' },
    2: { level: 2, status: 'Biroji', units: '8 Biroji', price: '€1.2M - €3M', description: 'Mūsdienīgi biroji ar atvērtu plānojumu un dabisko apgaismojumu.' },
    3: { level: 3, status: 'Dzīvokļi', units: '6 Dzīvokļi', price: '€850K - €2.1M', description: 'Luksusa dzīvokļi ar panorāmas skatu uz pilsētu.' },
    4: { level: 4, status: 'Penthausi', units: '4 Penthausi', price: '€3.5M - €6M', description: 'Ekskluzīvi penthausi ar plašām terasēm un privātu liftu.' },
    5: { level: 5, status: 'Sky Lounge', units: '2 Rezidences', price: '€8M - €12M', description: 'Izcilākās rezidences ar privātu baseinu un SPA zonu.' }
};

const activeFloor = computed(() => props.hoveredFloor || props.selectedFloor);
const activeFloorData = computed(() => {
    if (!activeFloor.value) return null;
    return props.floorsData[activeFloor.value] || defaultFloorsData[activeFloor.value];
});

const svgStyle = computed(() => {
    if (!imageRef.value) return {};
    const img = imageRef.value;
    return {
        width: `${img.offsetWidth}px`,
        height: `${img.offsetHeight}px`,
        left: '50%',
        bottom: '0',
        transform: 'translateX(-50%)'
    };
});

const handleFloorHover = (floor, event) => {
    emit('hover-floor', floor);
    showCard.value = true;
};

const handleFloorLeave = () => {
    emit('hover-floor', null);
    if (!props.selectedFloor) {
        showCard.value = false;
    }
};

const handleFloorClick = (floor) => {
    emit('select-floor', floor);
    showCard.value = true;
};

const closeCard = () => {
    showCard.value = false;
    emit('select-floor', null);
    emit('hover-floor', null);
};

watch(() => props.selectedFloor, (newVal) => {
    if (newVal) {
        showCard.value = true;
    }
});

const getFloorClass = (floor) => {
    const isHovered = props.hoveredFloor === floor;
    const isSelected = props.selectedFloor === floor;

    return [
        'cursor-pointer',
        'transition-all duration-300',
        {
            'fill-indigo-500/40 stroke-indigo-400 stroke-2': isHovered || isSelected,
            'fill-transparent stroke-transparent hover:fill-indigo-500/20 hover:stroke-indigo-400 hover:stroke-2': !isHovered && !isSelected
        }
    ];
};
</script>

<style scoped>
svg polygon {
    vector-effect: non-scaling-stroke;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
