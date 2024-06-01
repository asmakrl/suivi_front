<div>
    <!-- Dialogue panel -->
    <div class="dialog-panel" style="width: 300px; height: 250px; border: 1px solid #ccc; padding: 20px; text-align: center; direction: rtl; font-family: 'Arial', sans-serif;">

        <h3>تعدبل الاجابة</h3>
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

        <form wire:submit.prevent="editResponse" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="mb-4">
                <label for="response" class="block text-sm font-semibold mb-1">الوصف:</label>
                <textarea wire:model="response" id="response" name="response" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $response }}</textarea>
            </div>
            <div class="mb-4">
                <label for="response_time" class="block text-sm font-semibold mb-1">تاريخ الاستلام:</label>
                <input wire:model="response_time" type="date" id="response_time" name="response_time" value="{{ $response_time }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">تحديث الملف</button>
            </div>
        </form>

        <button wire:click="closeDialog" style="background-color: #dc3545; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px;">إغلاق</button>
    </div>
</div>
