@section('title') PAGUYUBAN DESA @endsection

<div>
    <livewire:components.banner />
    <div class="mt-4">
        <h3 class="mb-4 font-semibold text-sky-900">Pelayanan Desa</h3>
        <div class="grid grid-cols-4 gap-4">
            <livewire:village-service title="Info UMKM" />
            <livewire:village-service title="Bantuan Sosial" />
            <livewire:village-service title="Layanan Pendidikan" />
            <livewire:village-service title="Layanan Kesehatan" />
            <livewire:village-service title="Bantuan Hukum" />
            <livewire:village-service title="Layanan Administrasi" />
            <livewire:village-service title="Pelaporan Cepat" />
            <livewire:village-service title="Peningkatan SDM - SDA" />
        </div>
    </div>
    <div class="mt-4">
        <h3 class="mb-4 font-semibold text-sky-900">Kabar Desa</h3>
        <div class="grid grid-cols-2 gap-4">
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
            <livewire:components.card-post />
        </div>
    </div>
    <div class="mb-24"></div>
</div>
