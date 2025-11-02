<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('articles.index') }}">
            Artikel
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $article->title }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <!-- Judul dan Info -->
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-100 leading-tight">
            {{ $article->title }}
        </h1>

        <p class="text-sm text-neutral-500 dark:text-neutral-400">
            Dibuat pada {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}
            @if($article->author_name)
                oleh <span class="font-medium text-neutral-700 dark:text-neutral-300">{{ $article->author_name }}</span>
            @endif
        </p>
    </div>

    <!-- Isi Artikel -->
    <div class=" max-w-none break-words text-neutral-700 dark:text-neutral-300">
        {!! $article->content !!}
    </div>
    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
        <!-- Tombol Edit -->
        <a href="{{ route('articles.edit', ['slug' => $article->slug]) }}">
            <flux:button icon="pencil" variant="outline" size="sm" class="flex items-center gap-2">
                Edit
            </flux:button>
        </a>

        <!-- Tombol Hapus -->

        <flux:button icon="trash" variant="danger" size="sm" wire:click="delete" wire:confirm="Yakin ingin hapus?" class="flex items-center gap-2">
            Hapus
        </flux:button>

    </div>
</div>
