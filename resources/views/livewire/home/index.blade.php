@section('title') PAGUYUBAN DESA @endsection

<div>
    <livewire:components.banner />
    <div class="mt-4">
        <h3 class="mb-4 font-semibold text-sky-900">Pelayanan Desa</h3>
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
