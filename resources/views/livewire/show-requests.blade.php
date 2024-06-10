<div style="direction: rtl;">

    <h2 class="text-2xl font-bold mb-4">عرض الملف</h2>
    <div class="float-left">
        <button wire:click="goBack()"
                class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                <path stroke="none" d="M0 0h24v24H0z"></path>
                <path d="M9 14l-4 -4l4 -4"></path>
                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
            </svg>
            <span class="ml-2">رجوع</span>
        </button>
    </div>
    <hr class="border-b border-gray-300 mb-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <form class="container mx-auto p-8 text-right bg-gray-100" style="direction: rtl;">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold mb-1">العنوان:</label>
                <input wire:model="title" type="text" id="title" name="title" value="{{ $title }}"
                       required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold mb-1">الوصف:</label>
                <textarea wire:model="description" id="description" name="description" rows="4" required
                          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="received_at" class="block text-sm font-semibold mb-1">المصدر:</label>
                <input wire:model="source" type="text" id="source" name="source"
                       value="{{ $source }}" required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="state" class="block text-sm font-semibold mb-1">ولاية المصدر:</label>
                <input wire:model="state" id="state" name="state" value="{{ $state }}" required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="received_at" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
                <input wire:model="received_at" type="date" id="received_at" name="received_at"
                       value="{{ $received_at }}" required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="state" class="block text-sm font-semibold mb-2">ولاية المرسل:</label>
                <input wire:model="state_sender" name="state"
                       value="{{$state_sender}}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">

            </div>
            <div class="mb-4">
                <label for="sender" class="block text-sm font-semibold mb-1">فئة المرسل:</label>
                <input wire:model="category" type="text" id="sender" name="sender" value="{{ $category }}"
                       required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="sender" class="block text-sm font-semibold mb-1">المرسل:</label>
                <input wire:model="sender" type="text" id="sender" name="sender" value="{{ $sender }}"
                       required
                       class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>

        </form>

        <div class="container mx-auto p-8 text-right bg-gray-100" style="direction: rtl;">
            <h2 class="text-xl font-semibold mb-2">الملفات المرفقة</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach ($files as $file)
                    @php
                        $fileExtension = strtolower(pathinfo($file['file_path'], PATHINFO_EXTENSION));
                    @endphp

                    <div
                        class="container mx-auto p-8 bg-gray-100 flex flex-col items-center justify-center text-center">
                        @if ($fileExtension === 'pdf')
                            <!-- SVG for PDF with color and larger size -->
                            <svg height="40px" width="40px" version="1.1" id="Layer_1"
                                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="-81.92 -81.92 675.84 675.84" xml:space="preserve" fill="#000000"
                                 stroke="#000000" stroke-width="0.00512">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path style="fill:#E2E5E7;"
                                          d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z">
                                    </path>
                                    <path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z">
                                    </path>
                                    <polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "></polygon>
                                    <path style="fill:#F15642;"
                                          d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z">
                                    </path>
                                    <g>
                                        <path style="fill:#FFFFFF;"
                                              d="M101.744,303.152c0-4.224,3.328-8.832,8.688-8.832h29.552c16.64,0,31.616,11.136,31.616,32.48 c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.688-3.184-8.688-8.816V303.152z M118.624,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504c0-8.944-6.784-16.368-15.36-16.368H118.624z">
                                        </path>
                                        <path style="fill:#FFFFFF;"
                                              d="M196.656,384c-4.224,0-8.832-2.304-8.832-7.92v-72.672c0-4.592,4.608-7.936,8.832-7.936h29.296 c58.464,0,57.184,88.528,1.152,88.528H196.656z M204.72,311.088V368.4h21.232c34.544,0,36.08-57.312,0-57.312H204.72z">
                                        </path>
                                        <path style="fill:#FFFFFF;"
                                              d="M303.872,312.112v20.336h32.624c4.608,0,9.216,4.608,9.216,9.072c0,4.224-4.608,7.68-9.216,7.68 h-32.624v26.864c0,4.48-3.184,7.92-7.664,7.92c-5.632,0-9.072-3.44-9.072-7.92v-72.672c0-4.592,3.456-7.936,9.072-7.936h44.912 c5.632,0,8.96,3.344,8.96,7.936c0,4.096-3.328,8.704-8.96,8.704h-37.248V312.112z">
                                        </path>
                                    </g>
                                    <path style="fill:#CAD1D8;"
                                          d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z">
                                    </path>
                                </g>
                            </svg>
                        @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                            <!-- SVG for Image with color and larger size -->
                            <svg height="40px" width="40px" version="1.1" id="Layer_1"
                                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="-81.92 -81.92 675.84 675.84" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path style="fill:#E2E5E7;"
                                          d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z">
                                    </path>
                                    <path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z">
                                    </path>
                                    <polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "></polygon>
                                    <path style="fill:#50BEE8;"
                                          d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z">
                                    </path>
                                    <g>
                                        <path style="fill:#FFFFFF;"
                                              d="M141.968,303.152c0-10.752,16.896-10.752,16.896,0v50.528c0,20.096-9.6,32.256-31.728,32.256 c-10.88,0-19.952-2.96-27.888-13.184c-6.528-7.808,5.76-19.056,12.416-10.88c5.376,6.656,11.136,8.192,16.752,7.936 c7.152-0.256,13.44-3.472,13.568-16.128v-50.528H141.968z">
                                        </path>
                                        <path style="fill:#FFFFFF;"
                                              d="M181.344,303.152c0-4.224,3.328-8.832,8.704-8.832H219.6c16.64,0,31.616,11.136,31.616,32.48 c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.704-3.184-8.704-8.816 L181.344,303.152L181.344,303.152z M198.24,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504 c0-8.944-6.784-16.368-15.36-16.368H198.24z">
                                        </path>
                                        <path style="fill:#FFFFFF;"
                                              d="M342.576,374.16c-9.088,7.552-20.224,10.752-31.472,10.752c-26.88,0-45.936-15.344-45.936-45.808 c0-25.824,20.096-45.904,47.072-45.904c10.112,0,21.232,3.44,29.168,11.248c7.792,7.664-3.456,19.056-11.12,12.288 c-4.736-4.608-11.392-8.064-18.048-8.064c-15.472,0-30.432,12.4-30.432,30.432c0,18.944,12.528,30.464,29.296,30.464 c7.792,0,14.448-2.32,19.184-5.76V348.08h-19.184c-11.392,0-10.24-15.616,0-15.616h25.584c4.736,0,9.072,3.584,9.072,7.552v27.248 C345.76,369.568,344.752,371.712,342.576,374.16z">
                                        </path>
                                    </g>
                                    <path style="fill:#CAD1D8;"
                                          d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z">
                                    </path>
                                </g>
                            </svg>
                        @endif
                        <div class="text-center text-lg font-medium mb-4">{{ $file['title'] }}</div>
                        <button wire:click="downloadFile('{{ $file['file_path'] }}')"
                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="icon icon-tabler icon-tabler-download mr-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 11l5 5l5 -5" />
                                <path d="M12 4l0 12" />
                            </svg>
                            تحميل
                        </button>
                    </div>
                @endforeach
            </div>
        </div>


    </div>
    <div class="container mx-auto p-8 text-right bg-gray-100" style="direction: rtl;">
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">قائمة الإجراءات</h2>


            @if (!empty($action))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($action as $act)
                        <div>

                            <div class="container mx-auto p-8 text-right bg-gray-100">


                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-between"
                                    wire:click="toggle({{ $act['id'] }})">
                                    <!-- Icône SVG pour la liste -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 28 28"
                                         fill="currentColor">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M3 7C3 6.44771 3.44772 6 4 6H24C24.5523 6 25 6.44771 25 7C25 7.55229 24.5523 8 24 8H4C3.44772 8 3 7.55229 3 7Z"
                                                fill="#ffffff"></path>
                                            <path
                                                d="M3 14C3 13.4477 3.44772 13 4 13H24C24.5523 13 25 13.4477 25 14C25 14.5523 24.5523 15 24 15H4C3.44772 15 3 14.5523 3 14Z"
                                                fill="#ffffff"></path>
                                            <path
                                                d="M4 20C3.44772 20 3 20.4477 3 21C3 21.5523 3.44772 22 4 22H24C24.5523 22 25 21.5523 25 21C25 20.4477 24.5523 20 24 20H4Z"
                                                fill="#ffffff"></path>
                                        </g>
                                    </svg>
                                    <!-- Texte du bouton -->
                                    <span>
                                        {{ $isOpen[$act['id']] ? 'اخفي' : 'اظهر' }}
                                        اجابة {{ $act['sender']['name'] }}
                                    </span>
                                    <!-- Icône SVG pour le chevron -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <ul class="space-y-4 text-black-600 text-lg">
                                    <li><strong class="font-semibold">نوع الإجراء:</strong> <span
                                            class="font-light">{{ $act['type']['action_type'] }}</span></li>
                                    <li><strong class="font-semibold">وقت الإجراء:</strong> <span
                                            class="font-light">{{ $act['action_time'] }}</span></li>
                                    <li><strong class="font-semibold">المرسل اليه:</strong> <span
                                            class="font-light">{{ $act['sender']['name'] }}</span></li>
                                    <li><strong class="font-semibold">الملاحظات:</strong>
                                        <pre class="bg-gray-100 p-2 rounded text-sm text-gray-800"> {{ $act['name'] }} </pre>
                                    </li>
                                </ul>
                                @if ($isOpen[$act['id']] ?? false)
                                    <div class="panel-content">

                                        @if (!empty($response[$act['id']]))
                                            <div class="flex flex-col gap-4">
                                                @foreach ($response[$act['id']] as $index => $item)
                                                    <div class="bg-gray-100 rounded-md p-4 mb-4">
                                                        <div class="mb-4">
                                                            <label for="response-{{ $item['id'] }}"
                                                                   class="block text-sm font-semibold mb-1">الجواب:</label>
                                                            <textarea wire:model="reponse.{{ $item['id'] }}" id="response-{{ $item['id'] }}"
                                                                      name="response-{{ $item['id'] }}" rows="4" required
                                                                      class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $item['response'] }}</textarea>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="response_time-{{ $item['id'] }}"
                                                                   class="block text-sm font-semibold mb-1">تم
                                                                الاستلام في
                                                                (التاريخ)
                                                                :</label>
                                                            <input wire:model="response_time.{{ $item['id'] }}"
                                                                   type="date" id="response_time-{{ $item['id'] }}"
                                                                   name="response_time-{{ $item['id'] }}"
                                                                   value="{{ $item['response_time'] }}" required
                                                                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                                                        </div>
                                                        <div class="mb-4">
                                                            @if (!empty($item['file']))
                                                                <label class="block text-sm font-semibold mb-1">عدد
                                                                    الملفات:</label>
                                                                <p class="text-blue-500 cursor-pointer"
                                                                   wire:click="showFiles({{ $item['id'] }})">
                                                                    {{ count($item['file']) }}</p>
                                                            @endif
                                                        </div>

                                                        @if ($isFileDialogOpen)
                                                            <div class="fixed z-10 inset-0 overflow-y-auto"
                                                                 aria-labelledby="modal-title" role="dialog"
                                                                 aria-modal="true">
                                                                <div
                                                                    class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                                         aria-hidden="true"></div>
                                                                    <span
                                                                        class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                        aria-hidden="true">&#8203;</span>
                                                                    <div
                                                                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                        <div
                                                                            class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                            <div class="sm:flex sm:items-start">
                                                                                <div
                                                                                    class="text-center sm:mt-0 sm:text-left w-full">
                                                                                    <div
                                                                                        class="flex justify-center mb-4">
                                                                                        <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                                                            id="modal-title">ملفات
                                                                                            الرد
                                                                                        </h3>
                                                                                    </div>
                                                                                    <div
                                                                                        class="mt-2 max-h-60 overflow-y-auto">
                                                                                        @if (!empty($selectedFiles))
                                                                                            <ul class="space-y-2">
                                                                                                @foreach ($selectedFiles as $file)
                                                                                                    <li
                                                                                                        class="flex justify-between items-center bg-gray-100 p-2 rounded-md">
                                                                                                        <span
                                                                                                            class="text-gray-700">{{ $file['title'] }}</span>
                                                                                                        <div
                                                                                                            class="flex space-x-2">
                                                                                                            <button
                                                                                                                wire:click="downloadFile('{{ $file['file_path'] }}')"
                                                                                                                class="px-3 py-1 bg-blue-500 text-white rounded-md flex items-center hover:bg-blue-600">
                                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                     width="24"
                                                                                                                     height="24"
                                                                                                                     viewBox="0 0 24 24"
                                                                                                                     fill="none"
                                                                                                                     stroke="currentColor"
                                                                                                                     stroke-width="2"
                                                                                                                     stroke-linecap="round"
                                                                                                                     stroke-linejoin="round"
                                                                                                                     class="icon icon-tabler icon-tabler-download">
                                                                                                                    <path
                                                                                                                        stroke="none"
                                                                                                                        d="M0 0h24v24H0z"
                                                                                                                        fill="none" />
                                                                                                                    <path
                                                                                                                        d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                                                                    <path
                                                                                                                        d="M7 11l5 5l5 -5" />
                                                                                                                    <path
                                                                                                                        d="M12 4l0 12" />
                                                                                                                </svg>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                @endforeach
                                                                                            </ul>
                                                                                        @else
                                                                                            <p class="text-gray-500">
                                                                                                لا
                                                                                                توجد
                                                                                                ملفات</p>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center">
                                                                            <button wire:click="closeFileDialog"
                                                                                    type="button"
                                                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                                                إغلاق
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <hr class="border-b border-gray-300 my-1">
                                                    </div>
                                                @endforeach

                                            </div>
                                        @else
                                            <div>لا يوجد اجابة</div>
                                        @endif
                                    </div>
                                @endif
                            </div>


                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
