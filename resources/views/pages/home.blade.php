@extends('layouts.main') @section('content')
<div class="py-20">
    <div class="flex h-32 w-full flex-col rounded-2xl bg-sky-800 p-2">
        <div class="flex h-full w-full p-2">
            <div class="flex flex-col items-start justify-center text-center">
                <h3
                    class="text-center text-sm font-semibold leading-relaxed text-sky-50"
                >
                    Selamat Datang di Sistem Tata Kelola Penduduk Terpadu
                </h3>
                <h3
                    class="mt-2 w-full items-center text-center text-xs font-medium leading-relaxed text-sky-50"
                >
                    - Paguyuban Desa Mandiri -
                </h3>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h3 class="mb-4 font-semibold text-sky-900">Pelayanan</h3>
        <div class="grid grid-cols-4 gap-4">
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
            <livewire:village-service />
        </div>
    </div>
</div>
@stop
