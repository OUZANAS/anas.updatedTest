<x-filament-widgets::widget>
    <x-filament::section heading="Quick actions">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            @if (Route::has('filament.admin.resources.posts.create'))
                <x-filament::button tag="a" href="{{ route('filament.admin.resources.posts.create') }}" icon="heroicon-o-plus-circle">
                    Create Post
                </x-filament::button>
            @endif

            @if (Route::has('filament.admin.resources.careers.create'))
                <x-filament::button tag="a" href="{{ route('filament.admin.resources.careers.create') }}" icon="heroicon-o-briefcase">
                    Create Career
                </x-filament::button>
            @endif

            @if (Route::has('filament.admin.resources.static-pages.create'))
                <x-filament::button tag="a" href="{{ route('filament.admin.resources.static-pages.create') }}" icon="heroicon-o-document-text">
                    Add Static Page
                </x-filament::button>
            @endif

            <x-filament::button tag="a" href="{{ url('https://wwp-wpwp.vercel.app/') }}" target="_blank" icon="heroicon-o-globe-alt">
                View Site
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
