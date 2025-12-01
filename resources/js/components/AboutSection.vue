<template>
    <section id="about" class="py-32 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-stone-50/50 skew-x-12 translate-x-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-20">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="inline-block px-3 py-1 mb-6 rounded-full bg-indigo-50 border border-indigo-100">
                        <span class="text-xs font-bold tracking-widest uppercase text-indigo-600">Par Projektu</span>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-light text-stone-900 mb-8 leading-tight">
                        Dzīve <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Virsotnē</span>
                    </h2>
                    <p class="text-stone-600 text-lg leading-relaxed mb-8 font-light">
                        Skyline Tornis ir jauns orientieris pilsētas siluetā. Mēs piedāvājam ne tikai dzīvokļus, bet dzīvesveidu, kurā apvienojas mūsdienu arhitektūra, tehnoloģijas un komforts.
                    </p>
                    <p class="text-stone-600 text-lg leading-relaxed mb-12 font-light">
                        Katra detaļa ir pārdomāta, lai nodrošinātu jums vislabāko dzīves pieredzi – no elpu aizraujošiem skatiem līdz privātam konsjerža servisam.
                    </p>

                    <div class="grid grid-cols-3 gap-8 border-t border-stone-100 pt-10">
                        <div class="group">
                            <div class="text-4xl font-bold text-stone-900 mb-2 group-hover:text-indigo-600 transition-colors">24</div>
                            <div class="text-xs text-stone-400 uppercase tracking-widest font-medium">Stāvi</div>
                        </div>
                        <div class="group">
                            <div class="text-4xl font-bold text-stone-900 mb-2 group-hover:text-indigo-600 transition-colors">120</div>
                            <div class="text-xs text-stone-400 uppercase tracking-widest font-medium">Dzīvokļi</div>
                        </div>
                        <div class="group">
                            <div class="text-4xl font-bold text-stone-900 mb-2 group-hover:text-indigo-600 transition-colors">3.2m</div>
                            <div class="text-xs text-stone-400 uppercase tracking-widest font-medium">Griesti</div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative order-1 md:order-2">
                    <div class="relative z-10 aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl shadow-indigo-900/10 group">
                        <div class="absolute inset-0 bg-stone-200 group-hover:scale-105 transition-transform duration-1000 ease-out">
                             <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/10 to-orange-500/10 mix-blend-overlay"></div>
                        </div>

                        <div class="absolute bottom-0 left-0 w-full p-8 bg-gradient-to-t from-black/60 to-transparent">
                             <p class="text-white/90 font-light text-lg">"Arhitektūra, kas iedvesmo."</p>
                             <p class="text-white/60 text-sm mt-2">— Vadošais Arhitekts</p>
                        </div>

                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-light text-stone-500/30 uppercase tracking-[1em] -rotate-90">Skyline</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-600 rounded-full blur-3xl opacity-20 animate-pulse-slow"></div>
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-400 rounded-full blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: 1s;"></div>

                    <div class="absolute top-10 -left-10 z-20 bg-white p-4 rounded-xl shadow-xl shadow-stone-200/50 animate-float hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-stone-400 uppercase tracking-wide">Statuss</div>
                                <div class="text-sm font-bold text-stone-800">Nodotas ekspluatācijā</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
</script>
