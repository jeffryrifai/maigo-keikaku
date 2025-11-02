<div class="flex overflow-auto w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid">
        <h1 class="text-2xl font-semibold text-neutral-800 dark:text-neutral-100">{{ __('Articles') }}</h1>
    </div>
    <div>
        <flux:input wire:model.live.debounce.250ms="search" class="px-2" icon="magnifying-glass" placeholder="Search artikel" />
    </div>
    <div class="flex gap-2 pl-2">
        <flux:modal.trigger name="filter-modal">
            <flux:button href="" icon="adjustments-horizontal">
                {{ __('Filter') }}
            </flux:button>
        </flux:modal>
        <flux:button href="{{ route('articles.create') }}" icon="plus" class="ml-2" variant="primary" color="blue">
            {{ __('Artikel Baru') }}
        </flux:button>
    </div>
    {{-- List tag yang sudah dipilih --}}
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach($tags_filter as $tag)
            <span class="px-2 py-1 text-sm bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-100 rounded-md">
                {{ $tag->nama_tag }}
                <button type="button" wire:click="removeTag({{ $tag->id }})" class="ml-1 text-red-500 hover:text-red-100">×</button>
            </span>
        @endforeach
    </div>
    <div class="grid md:grid-cols-3 gap-4 auto-rows-min">
        @foreach($articles as $article)
            <div class="grid overflow-hidden rounded border border-neutral-200 dark:border-neutral-700 p-4 min-h-[300px]">
                <a href="{{ route('articles.view', ['slug' => $article->slug]) }}">
                    <div>
                        <h2 class="font-semibold text-neutral-800 dark:text-neutral-100">{{ $article->title }}</h2>
                    </div>    
                </a>
                <div>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400">@if($article->created_at == $article->updated_at) Dibuat: {{ \Carbon\Carbon::parse($article->created_at)->format('d F Y') }} @else Diperbarui: {{ \Carbon\Carbon::parse($article->updated_at)->format('d F Y') }}@endif</p>
                </div>
                <div class="flex gap-2 text-neutral-800 dark:text-neutral-100">
                    @php
                        $tags = explode(',', $article->tags);
                    @endphp
                        <div class="flex flex-wrap py-1 gap-1 ">
                            <flux:icon.tag class="w-4" />
                            @if(isset($article->tags))
                            @foreach($tags as $tag)
                            <div>
                                <span class="px-2 py-1 text-xs bg-neutral-200 dark:bg-neutral-700 rounded-md">{{ $tag }}</span>   
                            </div>
                            @endforeach
                            @endif
                        </div>

                </div>
                <a href="{{ route('articles.view', ['slug' => $article->slug]) }}">
                    <div class="min-h-[160px] ">
                        <p class="break-all mt-2 text-sm text-neutral-600 dark:text-neutral-400 text-justify">{!! Str::limit(strip_tags(preg_replace('/\s+/', ' ', $article->short_description)), 300, '...') !!}</p>
                    </div>
                </a>
                <div class="mt-4 flex justify-between self-end">
                    <div class="flex gap-1 items-center text-neutral-800 dark:text-neutral-100">
                        <flux:icon.user-circle class="self-center" /> 
                        <span class="text-sm text-neutral-600 dark:text-neutral-400"> {{ $article->author_name }}</span>
                    </div>
                    @php
                        $view_count = \DB::table('tr_article_views')
                            ->where('id_artikel', $article->id)
                            ->sum('total_view');
                    @endphp
                    <div class="items-center self-end">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $view_count }} kali dilihat</span>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div>
        {{ $articles->links() }}
    </div>
    <div>
        <flux:modal name="filter-modal" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Filter Data</flux:heading>
                </div>
                <div class="flex gap-2 ">
                    <flux:select id="tags" label="Tags" wire:model="selectedTagId" class="flex-1 rounded-lg border border-neutral-300 dark:border-neutral-700">
                        <flux:select.option value="">Pilih tag</flux:select.option>
                        @foreach($article_tags as $tag)
                            <flux:select.option value="{{ $tag->id }}">{{ $tag->nama_tag }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:button type="button" wire:click="addTag" icon="plus" class="self-end" variant="filled"/>
                </div>
                {{-- List tag yang sudah dipilih --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($tags_filter as $tag)
                        <span class="px-2 py-1 text-sm bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-100 rounded-md">
                            {{ $tag->nama_tag }}
                            <button type="button" wire:click="removeTag({{ $tag->id }})" class="ml-1 text-red-500 hover:text-red-100">×</button>
                        </span>
                    @endforeach
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:button icon="arrow-path" wire:click="resetFilter">Reset</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
