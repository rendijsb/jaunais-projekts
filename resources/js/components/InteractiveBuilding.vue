<template>
    <div class="relative w-full" ref="containerRef">
        <div class="relative w-full overflow-hidden" :style="wrapperStyle">
            <img
                ref="imageRef"
                src="/images/building.jpg"
                alt="Luxury Building"
                class="absolute inset-0 w-full h-full object-cover object-bottom drop-shadow-2xl transition-all duration-500"
                @load="onImageLoad"
            />

            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[70%] h-32 bg-indigo-500/10 blur-[80px] rounded-[100%] z-0 pointer-events-none"></div>

            <svg
                v-if="imageLoaded"
                class="absolute z-30 transition-opacity duration-300"
                :style="svgStyle"
                viewBox="0 0 3840 2160"
                preserveAspectRatio="none"
            >
                <polygon
                    v-for="floor in [5, 4, 3, 2, 1]"
                    :key="floor"
                    :points="floors[floor]"
                    :class="getFloorClass(floor)"
                    @mouseenter="handleFloorHover(floor)"
                    @mouseleave="handleFloorLeave"
                    @click="handleFloorClick(floor)"
                />
            </svg>
        </div>

        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-500 cubic-bezier(0.16, 1, 0.3, 1)"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-300 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="showCard && activeFloorData"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-8 bg-black/50 backdrop-blur-sm"
                    @click.self="closeCard"
                >
                    <div class="relative w-full max-w-5xl bg-white/95 backdrop-blur-2xl rounded-[2rem] shadow-2xl shadow-black/20 ring-1 ring-black/5 overflow-hidden flex flex-col max-h-[90vh] overflow-y-auto" @click.stop>
                        <!-- Close Button -->
                        <button
                            @click.prevent.stop="closeCard"
                            type="button"
                            class="absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center rounded-full bg-white hover:bg-stone-100 text-stone-600 hover:text-stone-900 transition-all duration-200 shadow-lg cursor-pointer"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="w-full h-96 sm:h-[32rem] bg-stone-100 relative group overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:20px_20px] opacity-50"></div>

                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <img
                                    :src="`/images/floor-plans/floor-${activeFloorData.level}.jpg`"
                                    :alt="`${activeFloorData.level}. stāva plāns`"
                                    class="w-full h-full object-contain drop-shadow-lg transition-transform duration-500 group-hover:scale-105"
                                />
                            </div>

                            <div class="absolute -bottom-6 -left-4 text-[10rem] font-bold text-stone-200/50 leading-none select-none pointer-events-none">
                                {{ activeFloorData.level }}
                            </div>
                        </div>

                        <div class="w-full p-6 sm:p-8 flex flex-col">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <span class="text-sm font-medium text-stone-400 uppercase tracking-wider">Stāvs</span>
                                    <h2 class="text-4xl sm:text-5xl font-light text-stone-900 -mt-1">
                                        {{ activeFloorData.level }}<span class="text-stone-300">.</span>
                                    </h2>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-medium text-stone-400 uppercase tracking-wider">Cena no</span>
                                    <p class="text-2xl sm:text-3xl font-semibold text-stone-900">€{{ formatPrice(activeFloorData.min_price) }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-stone-600">Pieejamība</span>
                                    <span class="text-sm font-semibold text-stone-900">
                                        <span class="text-emerald-600">{{ activeFloorData.available_units }}</span>
                                        <span class="text-stone-400">/</span>
                                        <span>{{ activeFloorData.total_units }}</span>
                                        <span class="text-stone-400 font-normal ml-1">dzīvokļi pieejami</span>
                                    </span>
                                </div>
                                <div class="h-2 bg-stone-100 rounded-full overflow-hidden">
                                    <div
                                        class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-500"
                                        :style="{ width: `${(activeFloorData.available_units / activeFloorData.total_units) * 100}%` }"
                                    ></div>
                                </div>
                            </div>

                            <p class="text-sm text-stone-400 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Virziet kursoru uz stāva plāna, lai apskatītu dzīvokļus
                            </p>

                            <button
                                @click.stop="$emit('open-contact')"
                                type="button"
                                class="w-full py-4 bg-stone-900 text-white text-base rounded-xl font-semibold hover:bg-indigo-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-xl shadow-stone-900/10 hover:shadow-indigo-600/20 transform hover:-translate-y-0.5 cursor-pointer"
                            >
                                <span>Sazināties ar mums</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
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
    }
});

const emit = defineEmits(['select-floor', 'hover-floor', 'open-contact']);

const imageRef = ref(null);
const imageContainerRef = ref(null);
const containerRef = ref(null);
const imageLoaded = ref(false);
const showCard = ref(false);
const isMobile = ref(false);
const floorsData = ref({});
const isLoading = ref(true);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024;
};

const fetchFloors = async () => {
    try {
        const response = await fetch('/api/floors');
        const data = await response.json();
        // Convert array to object keyed by level for easier access
        floorsData.value = data.reduce((acc, floor) => {
            acc[floor.level] = floor;
            return acc;
        }, {});
    } catch (error) {
        console.error('Error fetching floors:', error);
    } finally {
        isLoading.value = false;
    }
};

const formatPrice = (price) => {
    if (!price) return '0';
    return new Intl.NumberFormat('lv-LV').format(price / 100);
};

const getStatusClass = (status) => {
    switch (status) {
        case 'available':
            return 'bg-green-100 text-green-700';
        case 'reserved':
            return 'bg-yellow-100 text-yellow-700';
        case 'sold':
            return 'bg-red-100 text-red-700';
        default:
            return 'bg-stone-100 text-stone-700';
    }
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'available':
            return 'Pieejams';
        case 'reserved':
            return 'Rezervēts';
        case 'sold':
            return 'Pārdots';
        default:
            return status;
    }
};

const floors = {
    1: "180,1467 207,1477 210,1680 980,1701 1303,1599 1309,1524 1387,1497 1442,1480 1513,1484 1693,1484 1947,1487 1957,1504 2042,1504 2059,1521 2327,1521 2361,1578 2412,1656 2442,1701 2500,1707 2554,1741 3633,1772 3633,1524 3681,1504 2503,1494 2368,1439 2364,1399 1995,1399 1676,1399 1479,1395 1309,1416 1113,1456 977,1480",
    2: "58,1463 980,1477 1309,1419 1435,1402 1479,1389 1710,1399 2364,1399 2364,1436 2497,1494 3813,1504 3809,1375 3718,1372 3721,1226 3813,1226 3809,1209 2500,1216 2364,1243 2364,1260 2364,1243 2398,1253 2405,1256 2330,1263 1459,1266 1411,1263 974,1219 58,1226 58,1248 170,1248 170,1360 58,1363",
    3: "54,1226 977,1219 1425,1260 2364,1258 2392,1238 2500,1217 3813,1211 3809,1095 3718,1095 3718,970 3813,949 3813,926 2500,956 2368,1068 2364,1082 2398,1082 2402,1122 2042,1126 2046,1136 2042,1126 2046,1143 1737,1146 1459,1150 1428,1150 1303,1112 1306,1078 980,990 58,1007 58,1031 166,1048 170,1143 58,1146",
    4: "58,1007 980,990 1309,1075 1303,1112 1428,1150 2039,1139 2049,1126 2398,1122 2395,1082 2364,1078 2364,1072 2497,956 3813,926 3809,821 3718,821 3718,705 3813,671 3813,627 2500,685 2364,878 2364,909 2405,912 2405,956 2049,963 2046,987 1428,1004 1425,1021 1275,953 1279,943 1306,936 1313,905 977,746 58,777 58,810 166,841 166,926 61,929",
    5: "54,777 977,746 1309,902 1309,936 1275,949 1428,1021 1432,1004 2049,987 2049,963 2405,956 2405,909 2368,905 2368,871 2500,685 3813,627 3813,502 3718,505 3721,482 3694,485 3674,498 3616,471 3555,498 3511,478 3579,437 3572,417 3518,417 2771,458 2724,465 2656,559 2507,566 2371,804 2368,814 2096,821 2096,831 2052,834 2052,868 1747,875 1737,861 1713,865 1720,878 1391,888 1394,868 1350,868 1343,858 1350,861 1313,858 1309,838 980,637 47,682 51,743"
};

const activeFloor = computed(() => props.hoveredFloor || props.selectedFloor);
const activeFloorData = computed(() => {
    if (!activeFloor.value) return null;
    return floorsData.value[activeFloor.value];
});

const containerDimensions = ref({ width: 0, height: 0 });
const screenSize = ref('mobile'); // 'mobile' | 'tablet' | 'desktop'

// Image natural dimensions (3840x2160)
const IMAGE_WIDTH = 3840;
const IMAGE_HEIGHT = 2160;
const ASPECT_RATIO = IMAGE_WIDTH / IMAGE_HEIGHT;

const updateContainerDimensions = () => {
    if (containerRef.value) {
        containerDimensions.value = {
            width: containerRef.value.offsetWidth,
            height: containerRef.value.offsetHeight
        };
    }
    const width = window.innerWidth;
    if (width >= 1024) {
        screenSize.value = 'desktop';
    } else if (width >= 600) {
        screenSize.value = 'tablet';
    } else {
        screenSize.value = 'mobile';
    }
};

// Wrapper style - different aspect ratios based on screen size
// Heights calculated:
// Desktop (>=1024): 16:9 → 576px at 1024px
// Tablet (600-1024): 4:3 → 450px at 600px, 768px at 1024px
// Mobile (<600): 1:1 → 375-600px (matches width)
const wrapperStyle = computed(() => {
    if (screenSize.value === 'desktop') {
        return { aspectRatio: '16 / 9' };
    }

    if (screenSize.value === 'tablet') {
        return { aspectRatio: '4 / 3' };
    }

    // Mobile: square ratio works well for phones
    return { aspectRatio: '1 / 1' };
});

const svgStyle = computed(() => {
    const { width: containerWidth, height: containerHeight } = containerDimensions.value;
    if (!containerWidth || !containerHeight) return {};

    // For desktop with natural 16:9, SVG matches container exactly
    if (screenSize.value === 'desktop') {
        return { inset: '0' };
    }

    // For tablet/mobile with object-cover object-bottom, calculate SVG position
    const scaleX = containerWidth / IMAGE_WIDTH;
    const scaleY = containerHeight / IMAGE_HEIGHT;
    const scale = Math.max(scaleX, scaleY);

    const renderedWidth = IMAGE_WIDTH * scale;
    const renderedHeight = IMAGE_HEIGHT * scale;

    // Horizontal: centered, Vertical: bottom-aligned (matches object-bottom)
    const offsetX = (renderedWidth - containerWidth) / 2;
    const offsetY = renderedHeight - containerHeight;

    return {
        width: `${renderedWidth}px`,
        height: `${renderedHeight}px`,
        left: `-${offsetX}px`,
        top: `-${offsetY}px`
    };
});

let resizeObserver = null;

const handleEscapeKey = (e) => {
    if (e.key === 'Escape' && showCard.value) {
        closeCard();
    }
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
    window.addEventListener('keydown', handleEscapeKey);
    fetchFloors();

    // Initialize ResizeObserver to track container size changes
    if (containerRef.value) {
        resizeObserver = new ResizeObserver(() => {
            updateContainerDimensions();
        });
        resizeObserver.observe(containerRef.value);
        updateContainerDimensions();
    }
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
    window.removeEventListener('keydown', handleEscapeKey);
    if (resizeObserver) {
        resizeObserver.disconnect();
    }
});

const onImageLoad = () => {
    imageLoaded.value = true;
    updateContainerDimensions();
    // Start observing if not already
    if (!resizeObserver && containerRef.value) {
        resizeObserver = new ResizeObserver(() => {
            updateContainerDimensions();
        });
        resizeObserver.observe(containerRef.value);
    }
};

const handleFloorHover = (floor) => {
    emit('hover-floor', floor);
    // Don't show card on hover anymore
};

const handleFloorLeave = () => {
    emit('hover-floor', null);
    // Don't hide card on leave if it was opened by click
};

const handleFloorClick = (floor) => {
    emit('select-floor', floor);
    showCard.value = true;
};

const closeCard = () => {
    showCard.value = false;
    emit('select-floor', null);
    // Don't clear hover state immediately to prevent flickering if mouse is still there
};

watch(() => props.selectedFloor, (newVal) => {
    if (newVal) {
        showCard.value = true;
    } else {
        showCard.value = false;
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
