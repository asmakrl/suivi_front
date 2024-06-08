<div class="container mx-auto p-8 text-right" style="direction: rtl;">

    <h2 class="text-2xl font-bold mb-4">عرض الملف</h2>
    <div class="float-left">
        <a href="{{ url()->previous() }}" class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                <path stroke="none" d="M0 0h24v24H0z"></path>
                <path d="M9 14l-4 -4l4 -4"></path>
                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
            </svg>
            <span class="ml-2">رجوع</span>
        </a>
    </div>
    <hr class="border-b border-gray-300 mb-4">

    <form style="direction: rtl;">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold mb-1">العنوان:</label>
            <input wire:model="title" type="text" id="title" name="title" value="{{ $title }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-1">الوصف:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" value="{{ $received_at }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-1">فئة المرسل:</label>
            <input wire:model="category" type="text" id="sender" name="sender" value="{{ $category }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-1">المرسل:</label>
            <input wire:model="sender" type="text" id="sender" name="sender" value="{{ $sender }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-1">الولاية:</label>
            <input wire:model="state" id="state" name="state" value="{{ $state }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
    </form>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">الملفات المرفقة</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($files as $file)
                <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                    <div>{{ $file['title'] }}</div>
                    <button wire:click="downloadFile('{{ $file['file_path'] }}')" class="px-3 py-1 bg-blue-500 text-white rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">قائمة الإجراءات</h2>
        @if (!empty($action))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($action as $act)
                    <div>
                        <button wire:click="toggle({{ $act['id'] }})">
                            {{ $isOpen[$act['id']] ? 'اخفي' : 'اظهر' }}
                            اجابة {{ $act['sender']['name'] }}
                        </button>
                        <div class="bg-gray-100 rounded-md p-4 mb-4">
                            <ul class="list-none p-0">
                                <li class="mb-2"><strong>نوع الإجراء:</strong> {{ $act['type']['action_type'] }}
                                </li>
                                <li class="mb-2"><strong>وقت الإجراء:</strong> {{ $act['action_time'] }}</li>
                                <li class="mb-2"><strong>المرسل اليه:</strong> {{ $act['sender']['name'] }}</li>
                                <li class="mb-2"><strong>الملاحظات:</strong>
                                    <pre> {{ $act['name'] }} </pre>
                                </li>
                            </ul>
                        </div>

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
                                                           class="block text-sm font-semibold mb-1">تم الاستلام في
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
                                                    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                            <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                    <div class="sm:flex sm:items-start">
                                                                        <div class="text-center sm:mt-0 sm:text-left w-full">
                                                                            <div class="flex justify-center mb-4">
                                                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">ملفات الرد</h3>
                                                                            </div>                                                                            <div class="mt-2 max-h-60 overflow-y-auto">
                                                                                @if (!empty($selectedFiles))
                                                                                    <ul class="space-y-2">
                                                                                        @foreach ($selectedFiles as $file)
                                                                                            <li class="flex justify-between items-center bg-gray-100 p-2 rounded-md">
                                                                                                <span class="text-gray-700">{{ $file['title'] }}</span>
                                                                                                <div class="flex space-x-2">
                                                                                                    <button wire:click="downloadFile('{{ $file['file_path'] }}')" class="px-3 py-1 bg-blue-500 text-white rounded-md flex items-center hover:bg-blue-600">
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-download">
                                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                                                            <path d="M7 11l5 5l5 -5" />
                                                                                                            <path d="M12 4l0 12" />
                                                                                                        </svg>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <p class="text-gray-500">لا توجد ملفات</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center">
                                                                    <button wire:click="closeFileDialog" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                                        إغلاق
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach

                                    </div>
                                @else
                                    <div>لا يوجد اجابة</div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
