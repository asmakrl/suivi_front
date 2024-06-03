<div wire:init="load" class="container mx-auto p-8 text-right" style="direction: rtl;">

    <h2 class="text-2xl font-bold mb-4">تعديل الطلب</h2>
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
    @if ($isLoading)
        <div class="absolute inset-0 flex items-center justify-center ">
            <div class="animate-pulse rounded-full h-12 w-12 border-4 border-blue-500"></div>
        </div>
    @endif
    <form wire:submit.prevent="sendEdit" class="grid grid-cols-3 gap-4">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="col-span-3 mb-4">
            <label for="title" class="block text-sm font-semibold mb-1">العنوان:</label>
            <input wire:model="title" type="text" id="title" name="title" value="{{ $title }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="col-span-3 mb-4">
            <label for="description" class="block text-sm font-semibold mb-1">الوصف:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required
                      class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="source" class="block text-sm font-semibold mb-2">المصدر:</label>
            <input wire:model="source" type="text" id="source" name="source" value="{{ $source }}" required
                   placeholder="ادخل مصدر الملف"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-2">ولاية المصدر:</label>
            <select name="state_id" wire:model="state_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{$state['nomAr']}}</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر الولاية</option>
                @endforelse
            </select>
        </div>
        <div class="col-span-3 mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-1">تاريخ الاستلام:</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at"
                   value="{{ $received_at }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-2">ولاية المرسل:</label>
            <select name="state_id" wire:model="state" wire:change="updatestate($event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{$state['nomAr']}}</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر الولاية</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="category" class="block text-sm font-semibold mb-2">فئة المرسل:</label>
            <select wire:model="category_id" id="category_id" wire:change="updatecat($event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر فئة المرسل</option>
                @foreach ($categoryData as $category)
                    <option value="{{ $category['id'] }}">{{ $category['category'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-2">المرسل:</label>
            <select name="sender_id" wire:model="sender_id" wire:model="getSender()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{$sender['name']}}</option>
                @forelse($senderData as $sen)
                    <option value="{{ $sen['id'] }}">{{ $sen['name'] }}</option>
                @empty
                    <option value="" disabled>لا يوجد مرسلون متاحون</option>
                @endforelse
            </select>
        </div>
        <div class="col-span-3 mb-4">
            <button type="submit"
                    class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">تحديث
                الطلب</button>
        </div>
    </form>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">ملفات المرفقة</h2>
        @if (!empty($files))
            <div class="grid grid-cols-3 gap-4">
                @foreach ($files as $file)
                    <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                        <div>{{ $file['title'] }}</div>
                        <button @click="if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) { $wire.deleteFile('{{ $file['id'] }}') }"
                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">حذف</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="mb-4">
        <!-- Button to open dialog -->
        <button
            wire:click="$dispatch('openModal', { component: 'file-uploader' , arguments: { requestId: {{ $id }} }})"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
            اضف ملفات اخرى
        </button>
        @livewire('wire-elements-modal')

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
                                    <li class="mb-2"><strong>نوع الإجراء:</strong> {{ $act['type']['action_type'] }}</li>
                                    <li class="mb-2"><strong>وقت الإجراء:</strong> {{ $act['action_time'] }}</li>
                                    <li class="mb-2"><strong>المرسل اليه:</strong> {{ $act['sender']['name'] }}</li>
                                    <li class="mb-2"><strong>الملاحظات:</strong>
                                        <pre> {{ $act['name'] }} </pre>
                                    </li>
                                </ul>
                                <div class="flex justify-end">
                                    <button wire:click="goToEditAction({{ $act['id'] }})" class="px-3 py-1 bg-green-500 text-white rounded-md mr-2 hover:bg-green-600 focus:outline-none focus:bg-green-600">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" /></svg></button>
                                    <button  @click="if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) { $wire.deleteAct({{ $act['id'] }}) }"   class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @if ($isOpen[$act['id']] ?? false)
                                <div class="panel-content">
                                    @if (!empty($response[$act['id']]))
                                        <div class="flex flex-col gap-4">
                                            @foreach ($response[$act['id']] as $item)
                                                <div class="bg-gray-100 rounded-md p-4 mb-4">
                                                    <div class="mb-4">
                                                        <label for="response" class="block text-sm font-semibold mb-1">الجواب:</label>
                                                        <textarea id="response" name="response" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $item['response'] }}</textarea>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="response_time" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
                                                        <input type="date" id="response_time" name="response_time" value="{{ $item['response_time'] }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                                                    </div>
                                                    <div class="mb-4">
                                                        @if (!empty($item['file']))
                                                            <label class="block text-sm font-semibold mb-1">عدد الملفات:</label>
                                                            <p class="text-blue-500 cursor-pointer" wire:click="showFiles({{ $item['id'] }})">{{ count($item['file']) }}</p>
                                                        @endif
                                                    </div>
                                                    @if ($isFileDialogOpen)
                                                        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                                <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                    <div class="flex justify-center mb-4">
                                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">ملفات الرد</h3>
                                                                    </div>
                                                                    <div class="mt-2 max-h-60 overflow-y-auto">
                                                                        @if (!empty($selectedFiles))
                                                                            <ul class="space-y-2">
                                                                                @foreach ($selectedFiles as $file)
                                                                                    <li class="flex justify-between items-center bg-gray-100 p-2 rounded-md">
                                                                                        <span>{{ $file['title'] }}</span>
                                                                                        <button wire:click="downloadFile('{{ $file['file_path'] }}')" class="px-3 py-1 bg-blue-500 text-white rounded-md flex items-center">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-download">
                                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                                                <path d="M7 11l5 5l5 -5" />
                                                                                                <path d="M12 4l0 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @else
                                                                            <p class="text-gray-500">لا توجد ملفات</p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center">
                                                                        <button wire:click="closeFileDialog" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                                            إغلاق
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                @endif
                                                <div class="flex justify-end">
                                                    <!-- Button to open dialog -->
                                                    <button
                                                        wire:click="$dispatch('openModal', { component: 'edit-response'})"
                                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                         </svg>
                                                    </button>
                                                    @livewire('wire-elements-modal')
                                                    <button  @click="if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) { $wire.deleteRes({{ $item['id'] }}) }"   class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </button>
                                                </div>
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







        <div class="flex justify-center" x-data>
            <button @click="if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) { $wire.delete({{ $id }}) }"
                    class="px-4 py-2 bg-red-500 text-white rounded">
                <span class="ml-2">حذف الملف</span>
            </button>
        </div>

    </div>
</div>
