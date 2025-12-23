<template>
    <section id="gallery" class="py-32 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                <div class="max-w-xl">
                    <h2 class="text-4xl md:text-5xl font-light text-stone-900 mb-6">
                        Ieskats <span class="font-bold">Nākotnē</span>
                    </h2>
                    <p class="text-stone-600 text-lg font-light">
                        Izpētiet mūsu rūpīgi izstrādātos interjerus un elpu aizraujošos skatus, kas paveras no Liedega Nams.
                    </p>
                </div>
                <div class="hidden md:block">
                    <button class="px-8 py-3 rounded-full border border-stone-200 text-stone-600 hover:bg-stone-900 hover:text-white hover:border-stone-900 transition-all duration-300">
                        Skatīt Visu Galeriju
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
                <div class="group relative md:col-span-2 md:row-span-2 rounded-3xl overflow-hidden bg-stone-100 cursor-pointer">
                    <div class="absolute inset-0 bg-stone-300 group-hover:scale-105 transition-transform duration-700 ease-out">
                         <div class="w-full h-full flex items-center justify-center text-stone-400 bg-stone-200">
                            <span class="text-2xl font-light">Viesistaba</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>

                    <div class="absolute bottom-0 left-0 p-10 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <div class="overflow-hidden">
                            <h3 class="text-3xl text-white font-bold mb-2 transform translate-y-0 transition-transform duration-500">Viesistaba</h3>
                            <p class="text-stone-300 text-lg opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-100">Plašs un gaišs interjers ar panorāmas logiem</p>
                        </div>
                    </div>
                </div>

                <div class="group relative rounded-3xl overflow-hidden bg-stone-100 cursor-pointer">
                    <div class="absolute inset-0 bg-stone-300 group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="w-full h-full flex items-center justify-center text-stone-400 bg-stone-200">
                            <span class="text-xl font-light">Guļamistaba</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-xl text-white font-bold">Guļamistaba</h3>
                    </div>
                </div>

                <div class="group relative rounded-3xl overflow-hidden bg-stone-100 cursor-pointer">
                    <div class="absolute inset-0 bg-stone-300 group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="w-full h-full flex items-center justify-center text-stone-400 bg-stone-200">
                            <span class="text-xl font-light">Vannas Istaba</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-xl text-white font-bold">Vannas Istaba</h3>
                    </div>
                </div>

                <div class="group relative md:col-span-2 rounded-3xl overflow-hidden bg-stone-100 cursor-pointer">
                    <div class="absolute inset-0 bg-stone-300 group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="w-full h-full flex items-center justify-center text-stone-400 bg-stone-200">
                            <span class="text-xl font-light">Skats no Balkona</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-2xl text-white font-bold">Skats no Balkona</h3>
                        <p class="text-stone-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-75">Rīgas panorāma jūsu plaukstā</p>
                    </div>
                </div>

                <div class="group relative rounded-3xl overflow-hidden bg-stone-100 cursor-pointer">
                    <div class="absolute inset-0 bg-stone-300 group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="w-full h-full flex items-center justify-center text-stone-400 bg-stone-200">
                            <span class="text-xl font-light">Lobby</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-xl text-white font-bold">Lobby</h3>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center md:hidden">
                 <button class="px-8 py-3 rounded-full border border-stone-200 text-stone-600 hover:bg-stone-900 hover:text-white hover:border-stone-900 transition-all duration-300">
                    Skatīt Visu Galeriju
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
</script>
