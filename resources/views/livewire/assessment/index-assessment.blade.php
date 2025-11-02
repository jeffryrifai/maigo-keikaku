<div class="flex overflow-auto w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid">
        <h1 class="text-2xl font-semibold">{{ __('History Assessment') }}</h1>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-2">
        <flux:button href="{{ route('assessment.create') }}" icon="plus" class="ml-2" variant="primary" color="blue">
            {{ __('Tambah Assessment') }}
        </flux:button>
        <div class="flex items-center gap-2">

            <div class="relative w-full max-w-xs pr-2">
                <flux:input icon="magnifying-glass" placeholder="Search" />
            </div>
        </div>
    </div>
    <div>
        <flux:navbar>
            <flux:navbar.item :current="$current_table == 'semua'" wire:click="setHalaman('semua')">Semua Tiket</flux:navbar.item>
            <flux:navbar.item :current="$current_table == 'resource'" wire:click="setHalaman('resource')">Permohonan Resource</flux:navbar.item>
        </flux:navbar>
    </div>
    @if($current_table == "semua")
    <div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Nomor Tiket</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis Permohonan</th>
                    <th class="px-4 py-3 text-left font-semibold">Kekurangan Kelengkapan</th>
                    <th class="px-4 py-3 text-left font-semibold">Nilai Urgensi</th>
                    <th class="px-4 py-3 text-left font-semibold">Dampak Operasional</th>
                    <th class="px-4 py-3 text-left font-semibold">Rekomendasi</th>
                    <th class="px-4 py-3 text-left font-semibold">Assessor</th>
                    <th class="px-4 py-3 text-left font-semibold">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($data_assess as $row)
                @php
                $current_selected_category = \DB::table('tm_assess_category')->where('id', $row->id_category)->first();
                $required_criteria = \DB::table('tm_assess_criteria')
                    ->when($current_selected_category != '', function($query) use($current_selected_category) {
                        if($current_selected_category != 'general'){
                            $query->where('jenis', $current_selected_category->jenis)
                                ->orWhere('jenis', 'required');
                        }else{
                            $query->where('jenis', 'required');
                        }
                    })->get();
                $assess_score = \DB::table('tr_assess_score')->where('id_assess', $row->id);
                $crit_checklist = $required_criteria->filter(function ($criteria) {
                    return $criteria->tipe_kriteria == 'checklist';
                });
                $assess_score_urgensi = \DB::table('tr_assess_score')->where('id_assess', $row->id)->where('id_criteria', 7)->first();
                $assess_score_dampak = \DB::table('tr_assess_score')->where('id_assess', $row->id)->where('id_criteria', 8)->first();
                $count_kurang = 0;
    
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900 dark:text-gray-100 w-32">{{ $row->kode_tiket }}</div>
                        <div class="text-xs text-gray-500">{{ $row->nama_tenant }}</div>
                    </td>
                    <td class="px-4 py-3">{{ $row->nama_kategori }}</td>

                    <td class="px-4 py-3">
                        <ul>
                        @foreach($crit_checklist as $crit)
                            @php 
                            $sub_crit = \DB::table('tm_assess_criteria_sub')->where('id_criteria', $crit->id)->get();
                            @endphp
                            @foreach($sub_crit as $sub)
                            @if(!\DB::table('tr_assess_score')->where('id_assess', $row->id)->where('id_criteria', $crit->id)
                            ->where('id_criteria_sub', $sub->id)->where('score', 1)->exists())
                            @php $count_kurang++; @endphp
                            <li class="list-disc">{{ $sub->nama_sub_kriteria }} @if($sub->sub_type == "benar") salah @elseif($sub->sub_type = "ada") tidak ada @endif</li>
                            @endif
                            @endforeach
                        @endforeach
                        </ul>
                        @if($count_kurang == 0)
                        Lengkap
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ isset($assess_score_urgensi) ? $map_level[$assess_score_urgensi->score] : '' }}</td>
                    <td class="px-4 py-3">{{ isset($assess_score_dampak) ? $map_level[$assess_score_dampak->score]  : ''}}</td>
                    <td class="px-4 py-3">
                        @if($row->rekomendasi == "Approved Tiket")
                        <flux:badge color="green">{{$row->rekomendasi}}</flux:badge>
                        @elseif($row->rekomendasi == "Reject Tiket")
                        <flux:badge color="red">{{$row->rekomendasi}}</flux:badge>
                        @else 
                        <flux:badge color="cyan">{{$row->rekomendasi}}</flux:badge>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        {{$row->name}}
                    </td>
                    <td class="px-4 py-3">
                        @if($row->id_user == auth()->user()->id)
                        <div class="grid gap-2">
                            <flux:button wire:click="edit({{ $row->id }})" size="xs" icon="pencil-square" variant="primary" color="yellow">Edit</flux:button>
                            <flux:button wire:click="delete({{ $row->id }})" wire:confirm="Yakin ingin hapus?" size="xs" icon="trash" variant="primary" color="red">Hapus</flux:button>

                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $data_assess->links() }}
    </div>
    @else
    <div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold" rowspan=2>Nomor Tiket</th>
                    <th class="px-4 py-3 text-center font-semibold" colspan=3>Permohonan</th>
                    <th class="px-4 py-3 text-center font-semibold" colspan=3>Hasil Assessment</th>
                    <th class="px-4 py-3 text-left font-semibold" rowspan=2>Assessor</th>
                    <th class="px-4 py-3 text-left font-semibold" rowspan=2>Opsi</th>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-center font-semibold">vCPU</th>
                    <th class="px-4 py-3 text-center font-semibold">Memory (GB)</th>
                    <th class="px-4 py-3 text-center font-semibold">Storage (GB)</th>
                    <th class="px-4 py-3 text-center font-semibold">vCPU</th>
                    <th class="px-4 py-3 text-center font-semibold">Memory (GB)</th>
                    <th class="px-4 py-3 text-center font-semibold">Storage (GB)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($data_resource as $res)
                @php 
                $reso_minta = \DB::table('tr_assess_resource')->where('id_assess', $res->id)->where('id_criteria', 5)->first();
                $reso_assess = \DB::table('tr_assess_resource')->where('id_assess', $res->id)->where('id_criteria', 6)->first();
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900 dark:text-gray-100 w-32">{{ $res->kode_tiket }}</div>
                        <div class="text-xs text-gray-500">{{ $res->nama_tenant }}</div>
                    </td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_minta->vcpu, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_minta->memory, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_minta->storage, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_assess->vcpu, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_assess->memory, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($reso_assess->storage, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">{{$res->name}}</td>
                    <td class="px-4 py-3">
                        @if($res->id_user == auth()->user()->id)
                        <div class="grid gap-2">
                            <flux:button wire:click="edit({{ $res->id }})" size="xs" icon="pencil-square" variant="primary" color="yellow">Edit</flux:button>
                            <flux:button wire:click="delete({{ $res->id }})" wire:confirm="Yakin ingin hapus?" size="xs" icon="trash" variant="primary" color="red">Hapus</flux:button>

                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $data_resource->links() }}
    </div>
    <div>
        <flux:field variant="inline">
            <flux:checkbox wire:model.live="show_legacy" />
            <flux:label>Tampilkan pendataan lama</flux:label>
        </flux:field>
    </div>
        @if($show_legacy)
        <div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold" rowspan=2>Nomor Tiket</th>
                        <th class="px-4 py-3 text-center font-semibold" colspan=3>Permohonan</th>
                        <th class="px-4 py-3 text-center font-semibold" colspan=3>Hasil Assessment</th>
                        <th class="px-4 py-3 text-left font-semibold" rowspan=2>Assessor</th>
                        <th class="px-4 py-3 text-left font-semibold" rowspan=2>Opsi</th>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-center font-semibold">vCPU</th>
                        <th class="px-4 py-3 text-center font-semibold">Memory (GB)</th>
                        <th class="px-4 py-3 text-center font-semibold">Storage (GB)</th>
                        <th class="px-4 py-3 text-center font-semibold">vCPU</th>
                        <th class="px-4 py-3 text-center font-semibold">Memory (GB)</th>
                        <th class="px-4 py-3 text-center font-semibold">Storage (GB)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($data_resource_legacy as $leg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 dark:text-gray-100 w-32">{{ $leg->kode_tiket }}</div>
                            <div class="text-xs text-gray-500">{{ $leg->nama_tenant }}</div>
                        </td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->perm_vcpu, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->perm_memory, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->perm_storage, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->assess_vcpu, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->assess_memory, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ number_format($leg->assess_storage, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Data Import</td>
                        <td class="px-4 py-3">
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
        <div>
            {{ $data_resource_legacy->links() }}
        </div>
        @endif
    @endif
</div>