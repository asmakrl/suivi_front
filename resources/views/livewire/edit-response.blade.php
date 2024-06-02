<div>
    <!-- Dialogue panel -->
    <div class="dialog-panel" style="width:500px; height: 500px; border: 1px solid #ccc; padding: 20px; text-align: center; direction: rtl; font-family: 'Arial', sans-serif;">

        <h3>تعدبل الاجابة</h3>

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
