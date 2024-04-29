<div class="container mx-auto p-8 text-right" style="direction: rtl;">

    <h2 class="text-2xl font-bold mb-4">تعديل الطلب</h2>
    <hr class="border-b border-gray-300 mb-4">
    <form wire:submit.prevent="sendEdit">
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
            <label for="received_at" class="block text-sm font-semibold mb-1">تاريخ الاستلام:</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" value="{{ $received_at }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="category" class="block text-sm font-semibold mb-2">فئة المرسل:</label>
            <select name="category_id" wire:model="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" wire:change="getSender($event.target.value)">
                <option value="">{{$sender['category']['category']}}</option>
                @foreach ($categoryData  as $item)
                    <option value="{{ $item['id'] }}">{{ $item['category'] }}</option>
                @endforeach
            </select>
            <label for="sender" class="block text-sm font-semibold mb-2">المرسل:</label>
            <select name="sender_id" wire:model="sender_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{$sender['name']}}</option>
                @forelse($senderData as $obj)
                    <option value="{{ $obj['id'] }}">{{ $obj['name'] }}</option>
                @empty
                    <option value="" disabled>لا يوجد مرسلون متاحون</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-1">الحالة:</label>
            <select name="state_id" wire:model="state_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{ $state['nomAr'] }}</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر حالات</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">تحديث الطلب</button>
        </div>
    </form>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">ملفات المرفقة</h2>
        @foreach ($files as $file)
            <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                <div>{{ $file['title'] }}</div>
                <button onclick="confirm('هل أنت متأكد أنك تريد حذف هذا الملف؟')" wire:click="deleteFile('{{ $file['id'] }}', '{{$file['request_id']}}')" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">حذف</button>
            </div>
        @endforeach
    </div>

    <div class="mb-4">
        <!-- Button to open dialog -->
        <button wire:click="openDialog" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
            اضف ملفات اخرى
        </button>
    </div>


    <div>
        <h2 class="text-xl font-semibold mb-2">قائمة الإجراءات</h2>
        @foreach ($action as $act)
            <div class="bg-gray-100 rounded-md p-4 mb-4">
                <ul class="list-none p-0">
                    <li class="mb-2"><strong>نوع الإجراء:</strong> {{ $act['type']['action_type'] }}</li>
                    <li class="mb-2"><strong>وقت الإجراء:</strong> {{ $act['action_time'] }}</li>
                    <li class="mb-2"><strong>الملاحظات:</strong> {{ $act['name'] }}</li>
                </ul>
                <div class="flex justify-end">
                    <button wire:click="goToEditAction({{ $act['id'] }})" class="px-3 py-1 bg-red-500 text-white rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600">تعديل</button>
                    <button onclick="confirm('هل أنت متأكد أنك تريد حذف هذا الإجراء؟')" wire:click="deleteAct({{ $act['id'] }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">حذف</button>
                </div>
            </div>
        @endforeach
    </div>
    <button onclick="confirm('هل أنت متأكد من حذف هذا الطلب؟')"
            wire:click="delete({{ $id}})"
            class="mr-2 ml-2 px-4 py-2 bg-red-500 text-white rounded"><svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-trash" width="24" height="24"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 7l16 0" />
            <path d="M10 11l0 6" />
            <path d="M14 11l0 6" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg></button>


</div>
