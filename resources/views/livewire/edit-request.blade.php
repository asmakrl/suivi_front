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
        <div class="col-span-3 mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-1">تاريخ الاستلام:</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at"
                   value="{{ $received_at }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="col-span-3 mb-4">
            <label for="category" class="block text-sm font-semibold mb-2">فئة المرسل:</label>
            <select wire:change="getSender()" id="category_id" wire:model="category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @if (!empty($categoryData))
                    @foreach ($categoryData as $item)
                        <option value="{{ $item['id'] }}">{{ $item['category'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-span-3 mb-4">
            <label for="sender" class="block text-sm font-semibold mb-2">المرسل:</label>
            <select name="sender_id" wire:model="sender"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @if (!empty($senderData))
                    @forelse($senderData as $obj)
                        <option value="{{ $obj['id'] }}">{{ $obj['name'] }}</option>
                    @empty
                        <option value="" disabled>لا يوجد مرسلون متاحون</option>
                    @endforelse
                @endif
            </select>
        </div>
        <div class="col-span-3 mb-4">
            <label for="state" class="block text-sm font-semibold mb-1">الحالة:</label>
            <select name="state_id" wire:model="state_id"
                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{ $state['nomAr'] }}</option>
                @if (!empty($stateData))
                    @forelse($stateData as $item)
                        <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                    @empty
                        <option value="" disabled>لا تتوفر حالات</option>
                    @endforelse
                @endif
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

        <div>
            <h2 class="text-xl font-semibold mb-2">قائمة الإجراءات</h2>
            @if (!empty($action))
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($action as $act)
                        <div class="expansion-panel">
                            <button wire:click="toggle({{ $act['id'] }})">
                                {{ $isOpen[$act['id']] ? 'Collapse' : 'Expand' }}
                            </button>
                            <div class="bg-gray-100 rounded-md p-4 mb-4">
                                <ul class="list-none p-0">
                                    <li class="mb-2"><strong>نوع الإجراء:</strong> {{ $act['type']['action_type'] }}</li>
                                    <li class="mb-2"><strong>وقت الإجراء:</strong> {{ $act['action_time'] }}</li>
                                    <li class="mb-2"><strong>المرسل اليه:</strong> {{ $act['sender']['name'] }}</li>
                                    <li class="mb-2"><strong>الملاحظات:</strong>
                                        <pre> {{ $act['name'] }}</pre>
                                    </li>
                                </ul>
                                <div class="flex justify-end">
                                    @if(!empty($act['response']))
                                        <button wire:click="goToShowResponse({{$act['response'][0]['id']}})" class="px-3 py-1 bg-blue-500 text-white rounded-md mr-2 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-clipboard" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                                <path
                                                    d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            </svg></button>
                                    @endif
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
                            @if($isOpen[$act['id']])
                                <div class="panel-content">
                                    <p>This is the content of the expansion panel.</p>
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
