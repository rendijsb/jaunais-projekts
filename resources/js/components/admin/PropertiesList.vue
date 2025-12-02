<template>
    <div>
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-stone-900">Īpašumi</h2>
                    <p class="text-stone-500 mt-1">Pārvaldiet īpašumu sarakstu un to statusus</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-sm font-medium">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                        {{ statusCounts.available }} pieejami
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-sm font-medium">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        {{ statusCounts.reserved }} rezervēti
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-stone-100 text-stone-600 rounded-full text-sm font-medium">
                        <span class="w-2 h-2 bg-stone-400 rounded-full"></span>
                        {{ statusCounts.sold }} pārdoti
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-xl border border-stone-200 p-4 mb-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-stone-600">Statuss:</label>
                    <select
                        v-model="filters.status"
                        @change="fetchProperties"
                        class="px-3 py-2 rounded-lg border border-stone-200 bg-stone-50 text-sm text-stone-700
                               focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                               transition-colors"
                    >
                        <option value="">Visi</option>
                        <option
                            v-for="option in statusOptions"
                            :key="option.value"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-stone-600">Stāvs:</label>
                    <select
                        v-model="filters.floor"
                        @change="fetchProperties"
                        class="px-3 py-2 rounded-lg border border-stone-200 bg-stone-50 text-sm text-stone-700
                               focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                               transition-colors"
                    >
                        <option value="">Visi</option>
                        <option v-for="floor in availableFloors" :key="floor" :value="floor">
                            {{ floor }}. stāvs
                        </option>
                    </select>
                </div>
                <button
                    v-if="filters.status || filters.floor"
                    @click="resetFilters"
                    class="flex items-center gap-1.5 px-3 py-2 text-sm text-stone-500 hover:text-stone-700 hover:bg-stone-100
                           rounded-lg transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Notīrīt
                </button>
                <div class="flex-1"></div>
                <div class="text-sm text-stone-500">
                    {{ totalCount }} īpašumi
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="bg-white rounded-xl border border-stone-200 p-16 text-center shadow-sm">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 mb-4">
                <svg class="w-6 h-6 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <p class="text-stone-600 font-medium">Ielādē īpašumus...</p>
        </div>

        <!-- Properties Table -->
        <div v-else class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-stone-100 bg-stone-50/50">
                            <th
                                @click="toggleSort('flat_number')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Dzīvoklis
                                    <SortIcon :active="sort.by === 'flat_number'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('floor')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Stāvs
                                    <SortIcon :active="sort.by === 'floor'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('flat_area')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Platība
                                    <SortIcon :active="sort.by === 'flat_area'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('terrace_area')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Terase
                                    <SortIcon :active="sort.by === 'terrace_area'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('balcony_area')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Balkons
                                    <SortIcon :active="sort.by === 'balcony_area'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('total_area')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Kopā
                                    <SortIcon :active="sort.by === 'total_area'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('price')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Cena
                                    <SortIcon :active="sort.by === 'price'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th
                                @click="toggleSort('status')"
                                class="px-5 py-4 text-left text-xs font-semibold text-stone-500 uppercase tracking-wider cursor-pointer hover:text-stone-700 select-none"
                            >
                                <div class="flex items-center gap-1">
                                    Statuss
                                    <SortIcon :active="sort.by === 'status'" :direction="sort.direction" />
                                </div>
                            </th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-stone-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <tr
                            v-for="property in properties"
                            :key="property.id"
                            class="group hover:bg-amber-50/40 transition-colors"
                        >
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-stone-100 to-stone-200 flex items-center justify-center">
                                        <span class="text-sm font-bold text-stone-600">{{ property.flat_number }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-stone-900">Nr. {{ property.flat_number }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 text-sm text-stone-600">
                                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ property.floor }}. stāvs
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-stone-600 font-medium">{{ property.flat_area }} m²</td>
                            <td class="px-5 py-4 text-sm text-stone-500">
                                {{ property.terrace_area ? `${property.terrace_area} m²` : '—' }}
                            </td>
                            <td class="px-5 py-4 text-sm text-stone-500">
                                {{ property.balcony_area ? `${property.balcony_area} m²` : '—' }}
                            </td>
                            <td class="px-5 py-4 text-sm text-stone-600 font-medium">{{ property.total_area }} m²</td>
                            <td class="px-5 py-4">
                                <span class="text-sm font-semibold text-stone-900">{{ formatPrice(property.price) }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <select
                                    :value="property.status"
                                    @change="updateStatus(property.id, $event.target.value)"
                                    :disabled="updatingStatus === property.id"
                                    :class="[
                                        'px-3 py-1.5 rounded-lg text-xs font-semibold border cursor-pointer appearance-none',
                                        'focus:outline-none focus:ring-2 focus:ring-offset-1 transition-all',
                                        'disabled:opacity-50 disabled:cursor-wait',
                                        statusClasses[property.status]
                                    ]"
                                >
                                    <option
                                        v-for="option in statusOptions"
                                        :key="option.value"
                                        :value="option.value"
                                    >
                                        {{ option.label }}
                                    </option>
                                </select>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button
                                    @click="openEditModal(property)"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-stone-600
                                           hover:text-amber-700 hover:bg-amber-100 rounded-lg transition-colors
                                           opacity-0 group-hover:opacity-100"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Rediģēt
                                </button>
                            </td>
                        </tr>
                        <tr v-if="properties.length === 0">
                            <td colspan="9" class="px-5 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-stone-100 mb-4">
                                    <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <p class="text-stone-600 font-medium">Nav atrasts neviens īpašums</p>
                                <p class="text-stone-400 text-sm mt-1">Mēģiniet mainīt filtrus</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
        <PropertyEditModal
            v-if="editingProperty"
            :property="editingProperty"
            @close="editingProperty = null"
            @saved="handlePropertySaved"
        />
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import PropertyEditModal from './PropertyEditModal.vue';
import { PropertyStatus, PropertyStatusOptions } from '@/enums/PropertyStatus.js';

// Sort Icon Component
const SortIcon = {
    props: {
        active: Boolean,
        direction: String
    },
    template: `
        <svg class="w-4 h-4 transition-colors" :class="active ? 'text-amber-500' : 'text-stone-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!active || direction === 'asc'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            <path v-if="active && direction === 'desc'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    `
};

const properties = ref([]);
const availableFloors = ref([]);
const statusCounts = ref({ available: 0, reserved: 0, sold: 0 });
const totalCount = ref(0);
const loading = ref(true);
const editingProperty = ref(null);
const updatingStatus = ref(null);

const statusOptions = PropertyStatusOptions;

const filters = reactive({
    status: '',
    floor: ''
});

const sort = reactive({
    by: 'flat_number',
    direction: 'asc'
});

const statusClasses = {
    [PropertyStatus.AVAILABLE]: 'bg-emerald-50 text-emerald-700 border-emerald-200 focus:ring-emerald-500/30',
    [PropertyStatus.RESERVED]: 'bg-amber-50 text-amber-700 border-amber-200 focus:ring-amber-500/30',
    [PropertyStatus.SOLD]: 'bg-stone-100 text-stone-600 border-stone-200 focus:ring-stone-500/30'
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('lv-LV', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 0
    }).format(price);
};

const buildQueryParams = () => {
    const params = new URLSearchParams();

    if (filters.status) {
        params.append('status', filters.status);
    }
    if (filters.floor) {
        params.append('floor', filters.floor);
    }
    if (sort.by) {
        params.append('sort_by', sort.by);
        params.append('sort_direction', sort.direction);
    }

    return params.toString();
};

const fetchProperties = async () => {
    loading.value = true;
    try {
        const queryString = buildQueryParams();
        const url = `/admin/api/properties${queryString ? `?${queryString}` : ''}`;

        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        properties.value = data.properties;
        availableFloors.value = data.floors;
        statusCounts.value = data.status_counts;
        totalCount.value = data.total;
    } catch (e) {
        console.error('Failed to fetch properties:', e);
    } finally {
        loading.value = false;
    }
};

const toggleSort = (column) => {
    if (sort.by === column) {
        sort.direction = sort.direction === 'asc' ? 'desc' : 'asc';
    } else {
        sort.by = column;
        sort.direction = 'asc';
    }
    fetchProperties();
};

const resetFilters = () => {
    filters.status = '';
    filters.floor = '';
    fetchProperties();
};

const updateStatus = async (propertyId, newStatus) => {
    updatingStatus.value = propertyId;
    try {
        const response = await fetch(`/admin/api/properties/${propertyId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
        });

        if (response.ok) {
            // Refresh to get updated counts
            await fetchProperties();
        }
    } catch (e) {
        console.error('Failed to update status:', e);
    } finally {
        updatingStatus.value = null;
    }
};

const openEditModal = (property) => {
    editingProperty.value = { ...property };
};

const handlePropertySaved = async () => {
    editingProperty.value = null;
    await fetchProperties();
};

onMounted(fetchProperties);
</script>
