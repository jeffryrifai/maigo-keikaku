<x-layouts.app :title="__('Dashboard')">
    <div class="flex overflow-auto w-full flex-1 flex-col gap-4 rounded">
        <div class="flex gap-4 p-2">
            <div class="basis-2/3 w-full ">
                <h1 class="text-2xl text-neutral-800 dark:text-neutral-100 font-semibold">{{ __('Dashboard') }}</h1>
            </div>
            <div class="basis-1/3 max-w-xs flex gap-2"> 
                   
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
                    2,000
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
                    2,000
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
                    2,000
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
                    2,000
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
                    2,000
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
                    2,000
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
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100 w-8/12">VPN dan OKTA</td>
                                    <td class="py-2 text-gray-900 dark:text-gray-100 text-right">Cepi</td>
                                    <td class="py-2 text-right font-medium">1,961 kali</td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">Migrasi PDNS-2</td>
                                    <td class="py-2 text-gray-900 dark:text-gray-100 text-right">Cepi</td>
                                    <td class="py-2 text-right font-medium">1,972 kali</td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">Be</td>
                                    <td class="py-2 text-gray-900 dark:text-gray-100 text-right">Cepi</td>
                                    <td class="py-2 text-right font-medium">1,975 kali</td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">Shining Star</td>
                                    <td class="py-2 text-gray-900 dark:text-gray-100 text-right">Cepi</td>
                                    <td class="py-2 text-right font-medium">1,975 kali</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid">
                <h2 class="font-semibold">Grafik Kekurangan Tenan</h2>
                <div class="relative h-full flex-1 rounded border border-neutral-200 dark:border-neutral-700 p-2">         
                    <div class="flex w-full flex-col items-center justify-center gap-2">
                        <canvas id="tenantIssuesChart" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>
