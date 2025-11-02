
    <div class="flex overflow-auto w-full flex-1 flex-col gap-4 rounded">
        <div class="flex flex-wrap items-center justify-between gap-4 p-2">
            <div class="">
                <h1 class="text-2xl text-neutral-800 dark:text-neutral-100 font-semibold">{{ __('Dashboard') }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <div class="grid grid-cols-2">
                    <div class="relative w-full max-w-xs pr-2">
                        <flux:input wire:model.live="filter_tgl_mulai" type="date" label="Tanggal Mulai" />
                    </div>
                    <div class="relative w-full max-w-xs pr-2">
                        <flux:input wire:model.live="filter_tgl_selesai" type="date" label="Tanggal Selesai" />
                    </div>
                </div>

            </div>

        </div>

        <div class="space-y-6">
            <!-- Total Permohonan Resource -->
            <div>
                <h2 class="text-lg font-semibold text-neutral-800 dark:text-neutral-100 mb-3">
                Total Permohonan Resource
                </h2>
                <div class="grid gap-4 md:grid-cols-3">
                <!-- vCPU -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        vCPU
                    </h3>
                    <x-icon name="cpu-chip" class="w-5 h-5 text-blue-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($perm_vcpu,0,',','.') }}
                    </p>
                </div>

                <!-- Memory -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        Memory (GB)
                    </h3>
                    <x-icon name="inbox-stack" class="w-5 h-5 text-green-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($perm_memory,0,',','.') }}

                    </p>
                </div>

                <!-- Storage -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        Storage (GB)
                    </h3>
                    <x-icon name="circle-stack" class="w-5 h-5 text-purple-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($perm_storage,0,',','.') }}

                    </p>
                </div>
                </div>
            </div>

            <!-- Total Hasil Assessment -->
            <div>
                <h2 class="text-lg font-semibold text-neutral-800 dark:text-neutral-100 mb-3">
                Total Hasil Assessment
                </h2>
                <div class="grid gap-4 md:grid-cols-3">
                <!-- vCPU -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        vCPU
                    </h3>
                    <x-icon name="cpu-chip" class="w-5 h-5 text-blue-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($assess_vcpu,0,',','.') }}

                    </p>
                </div>

                <!-- Memory -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        Memory (GB)
                    </h3>
                    <x-icon name="inbox-stack" class="w-5 h-5 text-green-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($assess_memory,0,',','.') }}

                    </p>
                </div>

                <!-- Storage -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 shadow-sm hover:shadow-md transition-all"
                >
                    <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        Storage (GB)
                    </h3>
                    <x-icon name="circle-stack" class="w-5 h-5 text-purple-500" />
                    </div>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                    {{ number_format($assess_storage,0,',','.') }}

                    </p>
                </div>
                </div>
            </div>
        </div>



        <div class="grid md:grid-cols-3 gap-4 content-start">
            <div class="col-span-2">
                <h2 class="font-semibold text-neutral-800 dark:text-neutral-100">Artikel Trending</h2>
                <div class="relative flex-1 rounded border border-neutral-200 dark:border-neutral-700">
                    <div class="flex w-full flex-col items-center justify-center gap-2 p-4">
                        <table class="w-full text-sm text-gray-700 dark:text-gray-300">
                            <thead>
                                <tr>
                                    <th class="py-2 text-left font-semibold">Judul Artikel</th>
                                    <th class="py-2 text-right font-semibold">Penulis</th>
                                    <th class="py-2 text-right font-semibold">Jumlah dibaca</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($artikel as $row)
                                
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                    
                                        <td class="py-2 font-medium text-gray-900 dark:text-gray-100 w-8/12"><a href="{{ route('articles.view', ['slug' => $row->slug]) }}">{{ $row->title }}</a></td>
                                        <td class="py-2 text-gray-900 dark:text-gray-100 text-right">{{ $row->name }}</td>
                                        <td class="py-2 text-right font-medium">{{ number_format($row->total_view,0,',','.') }} kali</td>
                                    </tr>

                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid">
                <h2 class="font-semibold">Grafik Kekurangan Tenan</h2>
                <div wire:ignore class="rounded border border-neutral-200 dark:border-neutral-700 p-2 h-64 w-full">
                    <canvas id="tenantIssuesChart" ></canvas>   
                </div>
            </div>
        </div>
    </div>


