<template>
    <div class="min-h-screen bg-gradient-to-br from-stone-100 via-stone-50 to-amber-50">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-stone-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <h1 class="text-xl font-bold text-stone-800">Modern Living</h1>
                        <span class="text-stone-400">|</span>
                        <span class="text-stone-600">Admin Dashboard</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-stone-600">{{ userEmail }}</span>
                        <button
                            @click="handleLogout"
                            class="px-4 py-2 text-sm font-medium text-stone-600 hover:text-stone-800
                                   hover:bg-stone-100 rounded-lg transition-colors"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <slot></slot>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    userEmail: {
        type: String,
        default: 'admin@example.com'
    }
});

const handleLogout = async () => {
    try {
        await fetch('/admin/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        window.location.href = '/admin/login';
    } catch (e) {
        console.error('Logout failed:', e);
    }
};
</script>
