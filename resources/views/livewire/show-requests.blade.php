<div class="container mx-auto p-8 text-right" style="direction: rtl;">

    <h2 class="text-2xl font-bold mb-4">عرض الملف</h2>
    <div class="mb-4">
        <a wire:click="test()"
           class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icon-tabler-arrow-back-up">
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
            <input wire:model="title" type="text" id="title" name="title" value="{{ $title }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-1">الوصف:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required
                      class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at"
                   value="{{ $received_at }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-1">فئة المرسل:</label>
            <input wire:model="category" type="text" id="sender" name="sender" value="{{ $category }}"
                   required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-1">المرسل:</label>
            <input wire:model="sender" type="text" id="sender" name="sender" value="{{ $sender }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-1">الولاية:</label>
            <input wire:model="state" id="state" name="state" value="{{ $state }}" required
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
    </form>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">الملفات المرفقة</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($files as $file)
                <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                    <div>{{ $file['title'] }}</div>
                    <button wire:click="downloadFile('{{ $file['file_path'] }}')"
                            class="px-3 py-1 bg-blue-500 text-white rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="icon icon-tabler icon-tabler-download">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($action as $act)
                <div>
                    <button wire:click="toggle({{ $act['id'] }})">
                        Toggle Responses for Action {{ $act['name'] }}
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
                        @if ($isOpen[$act['id']] ?? false)
                            <div class="panel-content">
                                @if (!empty($response[$act['id']]))
                                    @foreach ($response[$act['id']] as $item)
                                        <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                                            <div>{{ $item['response'] }}</div>
                                            <div>{{ $item['response_time'] }}</div>
                                            <div>{{ $item['file'] }}</div>


                                        </div>
                                    @endforeach
                                @else
                                    <div>No responses found.</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Centered Edit button -->
    <div class="flex justify-center">
        <button wire:click="goToEditRequest()"
                class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:bg-orange-600">
            <span class="ml-2">تعديل الملف</span>
        </button>
    </div>
</div>
