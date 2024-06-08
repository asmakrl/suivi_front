<div class="container mx-auto p-8" style="direction: rtl;">
    <h2 class="text-2xl font-bold">إضافة جواب</h2>
    <div class="float-left">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                <path stroke="none" d="M0 0h24v24H0z"></path>
                <path d="M9 14l-4 -4l4 -4"></path>
                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
            </svg>
            <span class="ml-2">رجوع</span>
        </a>
    </div>

    <hr class="border-b border-gray-300 mb-4">
    <form wire:submit.prevent="save">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-2">الوصف:</label>
            <textarea wire:model="response" id="response" name="response" rows="4" required placeholder="ادخل وصف الملف"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
        </div>
        <div class="mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-2">تاريخ الاستلام:</label>
            <input wire:model="response_time" type="date" id="response_time" name="response_time" required
                   placeholder="اختر تاريخ الاستلام"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="action_id" class="block text-sm font-semibold mb-2">اختيار الاجراء:</label>
            <select wire:model="selectedActionId" id="action_id" name="action_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @foreach ($actions as $action)
                    <option value="{{ $action['id'] }}">{{ $action['sender']['name'] . ' ' . $action['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-semibold mb-2">تحميل الملفات:</label>
            <input type="file" wire:model="files" multiple>
            @if ($files)
                <div class="mt-2">
                    <h4 class="font-semibold">الملفات المحددة:</h4>
                    <ul>
                        @foreach ($files as $file)
                            <li>{{ $file->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-center">
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">إرسال
            </button>
        </div>
    </form>
</div>
