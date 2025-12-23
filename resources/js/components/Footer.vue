<template>
    <footer class="bg-stone-950 border-t border-stone-900 pt-24 pb-12 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none overflow-hidden">
            <span class="absolute top-10 left-1/2 -translate-x-1/2 text-[20vw] font-bold text-stone-900/30 tracking-tighter leading-none select-none">Liedega Nams</span>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-20">
                <div class="md:col-span-5">
                    <a href="#" class="text-4xl font-bold tracking-tighter text-white mb-8 block">
                        Liedega Nams<span class="text-indigo-500">.</span>
                    </a>
                    <p class="text-stone-400 max-w-md mb-8 text-lg font-light leading-relaxed">
                        Jūsu jaunās mājas pilsētas sirdī. Izbaudiet komfortu, drošību un elpu aizraujošus skatus katru dienu.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 rounded-full bg-stone-900 border border-stone-800 flex items-center justify-center text-stone-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-stone-900 border border-stone-800 flex items-center justify-center text-stone-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="md:col-span-3 md:col-start-7">
                    <h4 class="text-white font-bold mb-8 text-lg">Saites</h4>
                    <ul class="space-y-4">
                        <li><a href="#home" class="text-stone-400 hover:text-white transition-colors hover:translate-x-1 inline-block">Sākums</a></li>
                        <li><a href="#about" class="text-stone-400 hover:text-white transition-colors hover:translate-x-1 inline-block">Par Projektu</a></li>
                        <li><a href="#features" class="text-stone-400 hover:text-white transition-colors hover:translate-x-1 inline-block">Priekšrocības</a></li>
                        <li><a href="#gallery" class="text-stone-400 hover:text-white transition-colors hover:translate-x-1 inline-block">Galerija</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-white font-bold mb-8 text-lg">Kontakti</h4>
                    <ul class="space-y-6 text-stone-400">
                        <li class="flex items-start group">
                            <span class="mr-4 text-indigo-500 group-hover:scale-110 transition-transform mt-1">📍</span>
                            <span class="group-hover:text-stone-200 transition-colors">Brīvības iela 123,<br>Rīga, LV-1001</span>
                        </li>
                        <li class="flex items-center group">
                            <span class="mr-4 text-indigo-500 group-hover:scale-110 transition-transform">📞</span>
                            <span class="group-hover:text-stone-200 transition-colors">+371 20 123 456</span>
                        </li>
                        <li class="flex items-center group">
                            <span class="mr-4 text-indigo-500 group-hover:scale-110 transition-transform">✉️</span>
                            <span class="group-hover:text-stone-200 transition-colors">info@skyline.lv</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-stone-900 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-stone-600 text-sm mb-4 md:mb-0">
                    &copy; {{ new Date().getFullYear() }} Liedega Nams. Visas tiesības aizsargātas.
                </p>
                <div class="flex space-x-8 text-sm text-stone-600">
                    <a href="#" class="hover:text-white transition-colors">Privātuma Politika</a>
                    <a href="#" class="hover:text-white transition-colors">Lietošanas Noteikumi</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
</script>
