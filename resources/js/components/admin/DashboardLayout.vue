<template>
    <div class="min-h-screen bg-stone-50">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-stone-900 text-white z-50 hidden lg:block">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="px-6 py-5 border-b border-stone-700/50">
                    <h1 class="text-xl font-bold tracking-tight">Liedega Nams</h1>
                    <p class="text-stone-400 text-xs mt-0.5">Administrācijas panelis</p>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1">
                    <a
                        href="/admin/dashboard"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-stone-800 text-white font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Īpašumi
                    </a>
                </nav>

                <!-- User section -->
                <div class="px-3 py-4 border-t border-stone-700/50">
                    <div class="flex items-center gap-3 px-3 py-2">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-stone-900 font-semibold text-sm">
                            {{ userInitials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ userEmail }}</p>
                            <p class="text-xs text-stone-400">Administrators</p>
                        </div>
                    </div>
                    <button
                        @click="handleLogout"
                        class="w-full mt-2 flex items-center gap-3 px-3 py-2.5 rounded-lg text-stone-400 hover:text-white hover:bg-stone-800 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Iziet
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile header -->
        <header class="lg:hidden sticky top-0 z-40 bg-white border-b border-stone-200">
            <div class="flex items-center justify-between px-4 h-14">
                <div class="flex items-center gap-3">
                    <button
                        @click="mobileMenuOpen = true"
                        class="p-2 -ml-2 text-stone-600 hover:text-stone-900 hover:bg-stone-100 rounded-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="font-semibold text-stone-900">Liedega Nams</h1>
                </div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-stone-900 font-semibold text-xs">
                    {{ userInitials }}
                </div>
            </div>
        </header>

        <!-- Mobile menu overlay -->
        <div
            v-if="mobileMenuOpen"
            class="fixed inset-0 z-50 lg:hidden"
        >
            <div class="fixed inset-0 bg-black/50" @click="mobileMenuOpen = false"></div>
            <aside class="fixed inset-y-0 left-0 w-64 bg-stone-900 text-white">
                <div class="flex flex-col h-full">
                    <div class="px-6 py-5 border-b border-stone-700/50 flex items-center justify-between">
                        <div>
                            <h1 class="text-xl font-bold tracking-tight">Liedega Nams</h1>
                            <p class="text-stone-400 text-xs mt-0.5">Administrācijas panelis</p>
                        </div>
                        <button @click="mobileMenuOpen = false" class="p-1 text-stone-400 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 px-3 py-4 space-y-1">
                        <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-stone-800 text-white font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Īpašumi
                        </a>
                    </nav>
                    <div class="px-3 py-4 border-t border-stone-700/50">
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-stone-900 font-semibold text-sm">
                                {{ userInitials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ userEmail }}</p>
                                <p class="text-xs text-stone-400">Administrators</p>
                            </div>
                        </div>
                        <button
                            @click="handleLogout"
                            class="w-full mt-2 flex items-center gap-3 px-3 py-2.5 rounded-lg text-stone-400 hover:text-white hover:bg-stone-800 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Iziet
                        </button>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Main Content -->
        <main class="lg:pl-64">
            <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl">
                <slot></slot>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    userEmail: {
        type: String,
        default: 'admin@example.com'
    }
});

const mobileMenuOpen = ref(false);

const userInitials = computed(() => {
    return props.userEmail
        .split('@')[0]
        .split('.')
        .map(part => part[0]?.toUpperCase() || '')
        .join('')
        .slice(0, 2) || 'A';
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
