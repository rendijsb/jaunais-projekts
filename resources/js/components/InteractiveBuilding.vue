<template>
    <div class="relative w-full h-full flex items-center justify-center group">
        <div class="relative inline-block">
            <img
                ref="imageRef"
                src="/images/building.jpg"
                alt="Luxury Building"
                class="max-w-full max-h-[85vh] object-contain block drop-shadow-2xl"
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
                    :points="floors[5]"
                    :class="getFloorClass(5)"
                    @mouseenter="$emit('hover-floor', 5)"
                    @mouseleave="$emit('hover-floor', null)"
                    @click="$emit('select-floor', 5)"
                />

                <polygon
                    :points="floors[4]"
                    :class="getFloorClass(4)"
                    @mouseenter="$emit('hover-floor', 4)"
                    @mouseleave="$emit('hover-floor', null)"
                    @click="$emit('select-floor', 4)"
                />

                <polygon
                    :points="floors[3]"
                    :class="getFloorClass(3)"
                    @mouseenter="$emit('hover-floor', 3)"
                    @mouseleave="$emit('hover-floor', null)"
                    @click="$emit('select-floor', 3)"
                />

                <polygon
                    :points="floors[2]"
                    :class="getFloorClass(2)"
                    @mouseenter="$emit('hover-floor', 2)"
                    @mouseleave="$emit('hover-floor', null)"
                    @click="$emit('select-floor', 2)"
                />

                <polygon
                    :points="floors[1]"
                    :class="getFloorClass(1)"
                    @mouseenter="$emit('hover-floor', 1)"
                    @mouseleave="$emit('hover-floor', null)"
                    @click="$emit('select-floor', 1)"
                />
            </svg>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

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

defineEmits(['select-floor', 'hover-floor']);

const imageRef = ref(null);
const imageLoaded = ref(false);

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
</style>
