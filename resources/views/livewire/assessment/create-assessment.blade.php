<div class="grid max-w-3xl mx-auto space-y-6">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('assessment.index') }}">
            Assessment
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ __('Tools Assessment') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-2xl font-semibold text-neutral-800 dark:text-neutral-100">{{ __('Tools Assessment') }}</h1>
    <form wire:submit.prevent="save"> 
        <div class="grid md:grid-cols-2 gap-4">
            <flux:input label="Kode Tiket" wire:model="kode_tiket" placeholder="Kode Tiket"/>
            <flux:select id="tenant" label="Tenant" wire:model="selected_tenant" class="flex-1 rounded-lg border border-neutral-300 dark:border-neutral-700">
                <flux:select.option value="">Pilih Tenant</flux:select.option>
                @foreach($tenant as $ten)
                    <flux:select.option value="{{ $ten->id }}">{{ $ten->nama_tenant }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="pt-4">
            <flux:select id="category" label="Kategori" wire:model.live="selected_category" class="flex-1 rounded-lg border border-neutral-300 dark:border-neutral-700">
                <flux:select.option value="">Pilih Kategori</flux:select.option>
                @foreach($category as $cat)
                    <flux:select.option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        @if($form_assess)
            @foreach($form_assess as $row)
            <div class="pt-4">
                <flux:field>
                    <flux:label>{{ $row->nama_kriteria }}</flux:label>
                    @if($row->tipe_kriteria == 'checklist')
                    @php
                    $form_sub = \DB::table('tm_assess_criteria_sub')
                                ->where('id_criteria', $row->id)
                                ->get();
                    @endphp
                    @foreach($form_sub as $row_sub)
                        <flux:field variant="inline">
                            <flux:checkbox wire:model="form_data.{{ $row->id }}.value.{{ $row_sub->id }}"  />
                            <flux:label>{{ $row_sub->nama_sub_kriteria }}</flux:label>
                            <flux:error name="" />
                        </flux:field>
                    @endforeach
                    @endif
                    @if($row->tipe_kriteria == 'resource')
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <flux:input type="number" label="vCPU" wire:model="form_data.{{ $row->id }}.value.vcpu" placeholder="vCPU"/>
                        </div>
                        <div>
                            <flux:input type="number" label="Memory (GB)" wire:model="form_data.{{ $row->id }}.value.memory" placeholder="Memory (GB)" />
                        </div>
                        <div>
                            <flux:input type="number" label="Storage (GB)" wire:model="form_data.{{ $row->id }}.value.storage" placeholder="Storage (GB)" />
                        </div>
                    </div>
                    @endif
                    @if($row->tipe_kriteria == 'level')
                    <flux:radio.group label="" wire:model="form_data.{{ $row->id }}.value" variant="segmented" class="hover:cursor-pointer">
                        <flux:radio label="Sangat Rendah" value="1" />
                        <flux:radio label="Rendah" value="2" />
                        <flux:radio label="Menengah" value="3" />
                        <flux:radio label="Tinggi" value="4" />
                        <flux:radio label="Sangat Tinggi" value="5"/>
                    </flux:radio.group>
                    @endif
                </flux:field>
            </div>
            @endforeach
            <div class="pt-4">
                <flux:textarea label="Keterangan" wire:model="keterangan" placeholder="Keterangan" />
            </div>
            <div class="pt-4">
                <div class="flex justify-end">
                    <flux:button type="submit" wire:loading.attr="disabled" variant="primary" color="blue">
                        Simpan Assessment
                    </flux:button>
                </div>
            </div>
        @endif
    </form>
    <flux:modal wire:model="showNotice" :dismissible="false" @close="confirmRedirect">
        <flux:heading>
            Hasil Input
        </flux:heading>

        <p class="text-neutral-800 dark:text-neutral-100 mt-2">
            Rekomendasi untuk tiket ini adalah: <strong>{{ $recommendation }}</strong>
        </p>

        <div class="mt-6 flex justify-end space-x-2">
            <flux:button wire:click="confirmRedirect" variant="primary">
                OK
            </flux:button>
        </div>
    </flux:modal>
</div>
