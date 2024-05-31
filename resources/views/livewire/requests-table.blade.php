<div wire:init="fetchRequests" class="container mx-auto p-8">
    <!-- Search bar -->
    <div class="mt-8">
        <!-- Search input field -->
        <div class="flex items-center">
            <input type="search" wire:model.live="SearchKey" wire:keydown.enter="search" placeholder="البحث"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            <button wire:click="search" class="ml-2 px-3 py-2 bg-blue-500 text-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24"
                     height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="10" cy="10" r="7" />
                    <line x1="21" y1="21" x2="15" y2="15" />
                </svg>
            </button>
        </div>
    </div>
    <div class="mt-8 overflow-x-auto relative">
        <!-- Loading indicator -->
        @if ($isLoading)
            <div class="absolute inset-0 flex items-center justify-center ">
                <div class="animate-pulse rounded-full h-12 w-12 border-4 border-blue-500"></div>
            </div>
        @endif

        <div class="mt-8 flex justify-between items-center">
            <div>
                <button wire:click="goToaddrRequest()" class="mb-2 px-6 py-3 bg-blue-500 text-white rounded"> إضافة ملف</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse table-auto">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-right">العنوان</th>
                    <th class="py-3 px-6 text-right">الوصف</th>
                    <th class="py-3 px-6 text-right">التاريخ</th>
                    <th class="py-3 px-6 text-right">الوضعية</th>
                    <th class="py-3 px-6 text-right">مجموع الاجراءات</th>
                    <th class="py-3 px-6 text-center">الإجراءات</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @foreach ($requests as $item)
                    <!-- Request row -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <!-- Title column -->
                        <td class="py-3 px-6 text-right whitespace-nowrap">{{ $item['title'] }}</td>
                        <!-- Description column -->
                        <td class="py-3 px-6 text-right">{{ $item['description'] }}</td>
                        <!-- Received at column -->
                        <td class="py-3 px-6 text-right">{{ $item['received_at'] }}</td>
                        <!-- Status column -->
                        <td class="py-3 px-6 text-right">
                            <button wire:click="openStatusDialog({{ $item['id'] }})"
                                    class="px-4 py-2 bg-blue-500 text-white rounded">{{ $item['last_status'] }}</button>
                        </td>
                        <!-- Action count column -->
                        <td class="py-3 px-6 text-right">{{ count($item['action']) }}</td>
                        <!-- Actions column -->
                        <td class="py-3 px-6 text-center">
                            <div class="flex justify-center items-center">
                                <button wire:click="goToShowRequest({{ $item['id'] }})"
                                        class="mr-2 px-4 py-2 bg-blue-500 text-white rounded"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-clipboard" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path
                                            d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    </svg></button>
                                <button wire:click="goToAddAction({{ $item['id'] }})"
                                        class="mr-2 px-4 py-2 bg-green-500 text-white rounded"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-playlist-add" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19 8h-14" />
                                        <path d="M5 12h9" />
                                        <path d="M11 16h-6" />
                                        <path d="M15 16h6" />
                                        <path d="M18 13v6" />
                                    </svg></button>
                                <button wire:click="goToAddResponse({{ $item['id'] }})"
                                        class="mr-2 px-4 py-2 bg-green-500 text-white rounded"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-playlist-add" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19 8h-14" />
                                        <path d="M5 12h9" />
                                        <path d="M11 16h-6" />
                                        <path d="M15 16h6" />
                                        <path d="M18 13v6" />
                                    </svg></button>
                                <button wire:click="goToEditRequest({{ $item['id'] }})"
                                        class="mr-2 px-4 py-2 bg-green-500 text-white rounded"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Dialogue panel -->
        @if ($isStatusDialogOpen)
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                 aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <!-- Dialogue panel content -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <!-- Status dropdown -->
                            <label for="status" class="block text-sm font-semibold mb-2">تغيير الوضعية:</label>
                            <select wire:model='selectedStatusId' id="status" name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status['id'] }}">{{ $status['status'] }}</option>
                                @endforeach
                            </select>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <!-- Save and Cancel buttons -->
                                <button wire:click="changeStatus()" type="button"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    حفظ
                                </button>
                                <button wire:click="closeStatusDialog" type="button"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    إلغاء
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-between items-center">
            <div>
                <label for="page-size" class="mr-2">لكل صفحة:</label>
                <select id="page-size" wire:model='size' wire:change="changeSize($event.target.value)"
                        class="border border-gray-300 rounded-md px-4 py-2">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="text-sm text-gray-600 mb-4">
                عرض
                <span class="font-semibold">{{ ($currentPage - 1) * $size + 1 }}</span>
                إلى
                <span class="font-semibold">{{ max($currentPage * $size, $totalPages) }}</span>
                من
                <span class="font-semibold">{{ $totalItems }}</span>
                مُدخل
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <nav aria-label="Page navigation">
                <ul class="flex list-none">
                    <!-- Previous Page Button -->
                    <li>
                        <button wire:click="previousPage"
                                class="px-3 py-2 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded">
                            السابق
                        </button>
                    </li>

                    <!-- Page Buttons -->
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li>
                            <button wire:click="goToPage({{ $i }})"
                                    class="px-3 py-2 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded {{ $i == $currentPage ? 'font-bold' : '' }}">
                                {{ $i }}
                            </button>
                        </li>
                    @endfor

                    <!-- Next Page Button -->
                    <li>
                        <button wire:click="nextPage"
                                class="px-3 py-2 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded">
                            التالي
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
