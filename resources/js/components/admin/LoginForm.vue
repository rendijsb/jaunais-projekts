<template>
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-noise">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-stone-800">Modern Living</h1>
                <p class="text-stone-500 mt-2">Admin Portal</p>
            </div>

            <div class="glass-panel rounded-2xl p-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Sign in to your account</h2>

                <div v-if="error" class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <p class="text-sm text-red-600">{{ error }}</p>
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700 mb-2">
                            Email address
                        </label>
                        <input
                            type="email"
                            id="email"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white/50
                                   text-stone-800 placeholder-stone-400
                                   focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                   transition-all duration-200"
                            placeholder="admin@example.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-stone-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white/50
                                   text-stone-800 placeholder-stone-400
                                   focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                   transition-all duration-200"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="w-4 h-4 rounded border-stone-300 text-amber-600
                                       focus:ring-amber-500/50 focus:ring-offset-0"
                            >
                            <span class="text-sm text-stone-600">Remember me</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-3 px-4 rounded-xl font-semibold text-white
                               bg-gradient-to-r from-stone-800 to-stone-900
                               hover:from-stone-700 hover:to-stone-800
                               focus:outline-none focus:ring-2 focus:ring-stone-500/50 focus:ring-offset-2
                               transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]
                               shadow-lg shadow-stone-900/20
                               disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                    >
                        <span v-if="loading">Signing in...</span>
                        <span v-else>Sign in</span>
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-stone-500 mt-8">
                &copy; {{ currentYear }} Modern Living. All rights reserved.
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';

const form = reactive({
    email: '',
    password: '',
    remember: false
});

const loading = ref(false);
const error = ref('');

const currentYear = computed(() => new Date().getFullYear());

const handleSubmit = async () => {
    loading.value = true;
    error.value = '';

    try {
        const response = await fetch('/admin/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(form)
        });

        const data = await response.json();

        if (!response.ok) {
            error.value = data.message || 'Invalid credentials.';
            return;
        }

        window.location.href = data.redirect || '/admin/dashboard';
    } catch (e) {
        error.value = 'An error occurred. Please try again.';
    } finally {
        loading.value = false;
    }
};
</script>
