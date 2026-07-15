@extends('portal::layouts.app')

@section('body')
{{-- HERO SECTION --}}
<div class="absolute inset-0 h-full w-full bg-billmora-neutral-50 bg-[radial-gradient(#e5e7eb_1.5px,transparent_1.5px)] bg-size-[20px_20px] -z-10"></div>
<section class="max-w-7xl mx-auto">
    <div class="w-full min-h-[80vh] grid md:grid-cols-2 justify-around items-center px-4 py-16 gap-8">
        <div class="grid gap-6">
            <span class="text-billmora-primary-500 font-semibold text-sm uppercase tracking-wider">Servicios Informáticos, Tecnológicos & Soporte</span>
            <h1 class="text-5xl font-bold text-slate-800 leading-tight">
                Servicio <span class="text-billmora-primary-500">it</span><br>
                Servicios <span class="text-billmora-primary-500">Digitales</span>
            </h1>
            <p class="text-xl text-billmora-primary-500 font-semibold">Servidores / Hosting / Correos / Web / Apps</p>
            <p class="text-slate-600 leading-relaxed">
                La gestión de servicios de IT es un enfoque estratégico para <strong>diseñar, entregar, gestionar y mejorar</strong> la forma en que las empresas utilizan las tecnologías de la información.
            </p>
            <p class="text-slate-600 leading-relaxed">
                Con experiencia desde <strong>1999</strong> y clientes satisfechos en diferentes sectores, te asesoramos en implementaciones tecnológicas y manejo de información.
            </p>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('client.store') }}" class="bg-billmora-primary-500 hover:bg-billmora-primary-600 px-6 py-3 text-white font-semibold rounded-lg transition shadow-lg shadow-billmora-primary-500/30">
                    {{ __('portal.get_started') }}
                </a>
                @guest
                <a href="{{ route('client.login') }}" class="border-2 border-billmora-primary-500 text-billmora-primary-500 hover:bg-billmora-primary-50 px-6 py-3 font-semibold rounded-lg transition">
                    {{ __('common.sign_in') }}
                </a>
                @endguest
            </div>
        </div>
        <div class="hidden md:flex ml-auto items-center justify-center">
            <div class="relative">
                <div class="absolute inset-0 bg-billmora-primary-500/10 blur-3xl rounded-full"></div>
                <img src="{{ Billmora::getGeneral('company_logo') }}" alt="SERVICIO IT" class="w-72 h-auto relative">
            </div>
        </div>
    </div>
</section>

{{-- ITSM SECTION --}}
<section class="bg-white py-20 border-y border-slate-100">
    <div class="max-w-5xl mx-auto px-4 grid gap-8">
        <div class="grid gap-3">
            <span class="text-billmora-primary-500 font-bold text-6xl">01</span>
            <h2 class="text-3xl font-bold text-slate-800">Information Technology Service Management (ITSM)</h2>
            <p class="text-lg text-slate-600 leading-relaxed">
                ITSM incluye todas las actividades y procesos discretos que respaldan un servicio a lo largo de su ciclo de vida, desde la gestión de servicios hasta la gestión de cambios, la gestión de problemas e incidentes, la gestión de activos y la gestión del conocimiento.
            </p>
        </div>
        <div class="bg-billmora-neutral-50 border-l-4 border-billmora-primary-500 rounded-r-xl p-6 grid gap-2">
            <p class="text-lg text-slate-700 font-semibold">¿Tienes un servicio y no funciona como debería?</p>
            <a href="mailto:soporte@servicio.it" class="text-billmora-primary-500 font-semibold hover:underline">¡Contáctanos y con gusto te ayudaremos!</a>
        </div>
    </div>
</section>

{{-- CATALOGS SECTION --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 grid gap-10">
        <div class="grid text-center gap-2">
            <h3 class="text-3xl text-slate-800 font-bold">{{ $portalThemeConfig['catalog_title'] }}</h3>
            <span class="text-lg text-slate-500">{{ $portalThemeConfig['catalog_description'] }}</span>
        </div>
        <div
            x-data="{
                current: 0,
                total: {{ $catalogs->count() }},
                cols: 1,
                init() {
                    this.updateCols();
                    window.addEventListener('resize', () => {
                        this.updateCols();
                        this.current = Math.min(this.current, this.maxIndex());
                    });
                },
                updateCols() {
                    if (window.innerWidth >= 1024) this.cols = 3;
                    else if (window.innerWidth >= 768) this.cols = 2;
                    else this.cols = 1;
                },
                maxIndex() {
                    return Math.max(0, this.total - this.cols);
                },
                prev() { if (this.current > 0) this.current-- },
                next() { if (this.current < this.maxIndex()) this.current++ },
            }"
            class="relative min-w-0"
        >
            <div class="overflow-hidden w-full">
                <div
                    class="flex w-full transition-transform duration-300 ease-in-out gap-4"
                    :style="`transform: translateX(calc(-${current} * (100% / ${cols} + 16px / ${cols})))`"
                >
                    @foreach ($catalogs as $catalog)
                        <a
                            href="{{ route('client.store.catalog', ['catalog' => $catalog->slug]) }}"
                            class="flex-none bg-white border-2 border-billmora-neutral-100 rounded-2xl p-6 hover:border-billmora-primary-500 transition duration-200 grid gap-3"
                            :style="`width: calc(${100 / cols}% - ${16 * (cols - 1) / cols}px)`"
                        >
                            @if ($catalog->icon)
                                <div class="w-24 h-24 rounded-xl bg-billmora-neutral-100 flex items-center justify-center shrink-0 overflow-hidden">
                                    <img src="{{ Storage::url($catalog->icon) }}" alt="{{ $catalog->name }}" class="w-full h-full object-contain p-3">
                                </div>
                            @endif
                            <div class="grid gap-1 min-w-0 mb-auto">
                                <span class="text-slate-700 font-semibold text-lg truncate">{{ $catalog->name }}</span>
                                <p class="text-slate-500 text-sm line-clamp-2">{!! $catalog->description !!}</p>
                            </div>
                            <span class="text-billmora-primary-500 text-sm font-semibold inline-flex items-center gap-1 mt-auto">
                                {{ __('portal.explore') }}
                                <x-lucide-arrow-right class="w-4 h-4" />
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @if ($catalogs->count() > 1)
                <div class="flex justify-center items-center gap-3 mt-6">
                    <button type="button" x-on:click="prev" :disabled="current === 0"
                        class="p-2 rounded-full border-2 border-billmora-neutral-100 text-slate-500 hover:border-billmora-primary-500 hover:text-billmora-primary-500 disabled:opacity-30 disabled:cursor-not-allowed transition">
                        <x-lucide-chevron-left class="w-5 h-5" />
                    </button>
                    <div class="flex gap-2">
                        <template x-for="i in (maxIndex() + 1)" :key="i">
                            <button type="button" x-on:click="current = i - 1"
                                class="h-2 rounded-full transition-all duration-200"
                                :class="current === i - 1 ? 'bg-billmora-primary-500 w-4' : 'bg-billmora-neutral-100 w-2'">
                            </button>
                        </template>
                    </div>
                    <button type="button" x-on:click="next" :disabled="current >= maxIndex()"
                        class="p-2 rounded-full border-2 border-billmora-neutral-100 text-slate-500 hover:border-billmora-primary-500 hover:text-billmora-primary-500 disabled:opacity-30 disabled:cursor-not-allowed transition">
                        <x-lucide-chevron-right class="w-5 h-5" />
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- WHAT WE DO SECTION --}}
<section class="bg-white py-20 border-y border-slate-100">
    <div class="max-w-5xl mx-auto px-4 grid gap-8">
        <div class="grid gap-3">
            <span class="text-billmora-primary-500 font-bold text-6xl">02</span>
            <h2 class="text-3xl font-bold text-slate-800">¿Qué es un Servicio Digital?</h2>
            <p class="text-lg text-slate-600 leading-relaxed">
                Un servicio de IT permite el acceso a la información y los procesos para lograr importantes objetivos comerciales o proporcionar valor. Los servicios de IT incluyen la implementación y el soporte de aplicaciones empresariales, como <strong>Servidores WEB</strong> y/o de <strong>CORREO</strong>; diseñar y optimizar la infraestructura de IT, como el <strong>almacenamiento</strong>, las <strong>redes</strong> y los recursos en la <strong>nube</strong>.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mt-4">
            <div class="grid gap-2 p-6 rounded-xl bg-billmora-neutral-50">
                <div class="w-12 h-12 rounded-lg bg-billmora-primary-500/10 flex items-center justify-center">
                    <x-lucide-server class="w-6 h-6 text-billmora-primary-500" />
                </div>
                <h3 class="font-bold text-slate-800 text-lg mt-2">Infraestructura</h3>
                <p class="text-slate-500 text-sm">Servidores, hosting, almacenamiento y recursos en la nube.</p>
            </div>
            <div class="grid gap-2 p-6 rounded-xl bg-billmora-neutral-50">
                <div class="w-12 h-12 rounded-lg bg-billmora-primary-500/10 flex items-center justify-center">
                    <x-lucide-mail class="w-6 h-6 text-billmora-primary-500" />
                </div>
                <h3 class="font-bold text-slate-800 text-lg mt-2">Correos</h3>
                <p class="text-slate-500 text-sm">Implementación y soporte de correo empresarial profesional.</p>
            </div>
            <div class="grid gap-2 p-6 rounded-xl bg-billmora-neutral-50">
                <div class="w-12 h-12 rounded-lg bg-billmora-primary-500/10 flex items-center justify-center">
                    <x-lucide-code class="w-6 h-6 text-billmora-primary-500" />
                </div>
                <h3 class="font-bold text-slate-800 text-lg mt-2">Desarrollos</h3>
                <p class="text-slate-500 text-sm">Aplicaciones web y soluciones a medida para tu negocio.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto bg-billmora-primary-500 rounded-3xl px-8 py-16 text-center grid gap-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-56 h-56 bg-white/10 rounded-full"></div>
        <div class="relative grid gap-4">
            <h3 class="text-3xl text-white font-bold">{{ $portalThemeConfig['cta_title'] }}</h3>
            <p class="text-lg text-white/80 max-w-xl mx-auto">{{ $portalThemeConfig['cta_description'] }}</p>
        </div>
        <div class="relative flex justify-center gap-3 flex-wrap">
            @guest
                <a href="{{ route('client.register') }}" class="bg-white px-6 py-3 text-billmora-primary-500 font-semibold rounded-lg transition shadow-lg">
                    {{ __('common.sign_up') }}
                </a>
                <a href="mailto:soporte@servicio.it" class="bg-white/20 border-2 border-white/40 px-6 py-3 text-white font-semibold rounded-lg transition hover:bg-white/10">
                    Contáctanos
                </a>
            @else
                <a href="{{ route('client.dashboard') }}" class="bg-white px-6 py-3 text-billmora-primary-500 font-semibold rounded-lg transition shadow-lg">
                    {{ __('portal.client_area') }}
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection
