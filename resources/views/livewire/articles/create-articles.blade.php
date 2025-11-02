<div class="grid max-w-3xl mx-auto space-y-6">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('articles.index') }}">
            Artikel
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ __('Form Artikel') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-2xl font-semibold text-neutral-800 dark:text-neutral-100">{{ __('Form Artikel') }}</h1>
    <form wire:submit.prevent="save"> 
        {{-- Judul Artikel --}}
        <div class="pb-4">
            <flux:input label="Judul Artikel" id="title" wire:model="title" placeholder="Masukkan judul artikel" class="w-full" />
        </div>

        {{-- Deskripsi Singkat --}}
        <div class="pb-4">
            <flux:textarea label="Deskripsi Singkat" id="summary" wire:model="summary" rows="3" placeholder="Tuliskan deskripsi singkat..." class="w-full" />
        </div>

        {{-- Isi Artikel (Quill.js) --}}
        <div class="pb-7">
            <flux:field>
                <flux:label>Isi Artikel</flux:label>
                    <div wire:ignore>
                        <div id="editor" data-content="{{ $content }}" data-content_delta="{{ $content_delta }}"  class=" min-h-[200px] "></div>
                    </div>
                <flux:error name="content" />
            </flux:field>
        </div>

        {{-- Tags --}}
        <div class="pt-6">

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
                @foreach($tags as $tag)
                    <span class="px-2 py-1 text-sm bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-100 rounded-md">
                        {{ $tag->nama_tag }}
                        <button type="button" wire:click="removeTag({{ $tag->id }})" class="ml-1 text-red-500 hover:text-red-100">×</button>
                    </span>
                @endforeach
            </div>
        </div>

        

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <flux:button type="submit" wire:loading.attr="disabled"  variant="primary" color="blue">
                Simpan Artikel
            </flux:button>
        </div>

    </form>
    
</div>


