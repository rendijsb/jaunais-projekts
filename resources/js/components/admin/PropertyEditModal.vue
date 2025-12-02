<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-150"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm"
                    @click="$emit('close')"
                ></div>
            </Transition>

            <div class="flex min-h-full items-center justify-center p-4">
                <Transition
                    enter-active-class="transition-all duration-200"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition-all duration-150"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl transform"
                        @click.stop
                    >
                        <div class="px-6 py-5 border-b border-stone-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-stone-900">
                                        Rediģēt īpašumu
                                    </h3>
                                    <p class="text-sm text-stone-500">Dzīvoklis Nr. {{ form.flat_number }}</p>
                                </div>
                            </div>
                            <button
                                @click="$emit('close')"
                                class="absolute top-4 right-4 p-2 text-stone-400 hover:text-stone-600
                                       rounded-lg hover:bg-stone-100 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form @submit.prevent="handleSubmit" class="p-6">
                            <div v-if="error" class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-red-700">{{ error }}</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-medium text-stone-900 mb-4 flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-stone-100 flex items-center justify-center text-xs font-semibold text-stone-600">1</span>
                                        Pamatinformācija
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Dzīvokļa numurs
                                            </label>
                                            <input
                                                type="number"
                                                v-model.number="form.flat_number"
                                                required
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Stāvs
                                            </label>
                                            <input
                                                type="number"
                                                v-model.number="form.floor"
                                                required
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-stone-900 mb-4 flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-stone-100 flex items-center justify-center text-xs font-semibold text-stone-600">2</span>
                                        Platības
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Dzīvokļa platība (m²)
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                v-model.number="form.flat_area"
                                                required
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Kopējā platība (m²)
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                v-model.number="form.total_area"
                                                required
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Terases platība (m²)
                                                <span class="text-stone-400 font-normal">— neobligāts</span>
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                v-model.number="form.terrace_area"
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Balkona platība (m²)
                                                <span class="text-stone-400 font-normal">— neobligāts</span>
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                v-model.number="form.balcony_area"
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-stone-900 mb-4 flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-stone-100 flex items-center justify-center text-xs font-semibold text-stone-600">3</span>
                                        Cena un statuss
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Cena (EUR)
                                            </label>
                                            <input
                                                type="number"
                                                v-model.number="form.price"
                                                required
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900 placeholder-stone-400
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-stone-600 mb-1.5">
                                                Statuss
                                            </label>
                                            <select
                                                v-model="form.status"
                                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-50
                                                       text-stone-900
                                                       focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500
                                                       focus:bg-white transition-all"
                                            >
                                                <option
                                                    v-for="option in statusOptions"
                                                    :key="option.value"
                                                    :value="option.value"
                                                >
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-stone-100">
                                <button
                                    type="button"
                                    @click="$emit('close')"
                                    class="px-5 py-2.5 text-sm font-medium text-stone-600 hover:text-stone-800
                                           hover:bg-stone-100 rounded-xl transition-colors"
                                >
                                    Atcelt
                                </button>
                                <button
                                    type="submit"
                                    :disabled="saving"
                                    class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl
                                           bg-stone-900 hover:bg-stone-800
                                           focus:outline-none focus:ring-2 focus:ring-stone-500 focus:ring-offset-2
                                           disabled:opacity-50 disabled:cursor-not-allowed
                                           transition-all inline-flex items-center gap-2"
                                >
                                    <svg v-if="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ saving ? 'Saglabā...' : 'Saglabāt izmaiņas' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import { PropertyStatus, PropertyStatusOptions } from '@/enums/PropertyStatus.js';

const props = defineProps({
    property: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close', 'saved']);

const statusOptions = PropertyStatusOptions;

const form = reactive({
    flat_number: 0,
    floor: 0,
    flat_area: 0,
    total_area: 0,
    terrace_area: null,
    balcony_area: null,
    price: 0,
    status: PropertyStatus.AVAILABLE
});

const saving = ref(false);
const error = ref('');

watch(() => props.property, (newProperty) => {
    Object.assign(form, {
        flat_number: newProperty.flat_number,
        floor: newProperty.floor,
        flat_area: newProperty.flat_area,
        total_area: newProperty.total_area,
        terrace_area: newProperty.terrace_area,
        balcony_area: newProperty.balcony_area,
        price: newProperty.price,
        status: newProperty.status
    });
}, { immediate: true });

const handleSubmit = async () => {
    saving.value = true;
    error.value = '';

    try {
        const response = await fetch(`/admin/api/properties/${props.property.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(form)
        });

        const data = await response.json();

        if (!response.ok) {
            error.value = data.message || 'Neizdevās saglabāt izmaiņas.';
            return;
        }

        emit('saved', data);
    } catch (e) {
        error.value = 'Radās kļūda. Lūdzu, mēģiniet vēlreiz.';
    } finally {
        saving.value = false;
    }
};
</script>
