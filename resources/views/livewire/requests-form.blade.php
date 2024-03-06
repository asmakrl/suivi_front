<div class="container mx-auto">
    <form wire:submit.prevent="store" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" style="direction: rtl; text-align: right;">

        <h2 class="text-2xl font-bold mb-4 text-center">إضافة ملف جديد</h2>
        <hr class="border-b border-gray-300 mb-4">

        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold mb-2">العنوان:</label>
            <input wire:model="title" type="text" id="title" name="title" required placeholder="ادخل عنوان الملف" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-2">الوصف:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required placeholder="ادخل وصف الملف" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
        </div>
        <div class="mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-2">تاريخ الاستلام:</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" required placeholder="اختر تاريخ الاستلام" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-2">المرسل:</label>
            <select name="sender_id" wire:model="sender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر المرسل</option>
                @forelse($senderData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                @empty
                    <option value="" disabled>لا يوجد مرسلون متاحون</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-2">الحالة:</label>
            <select name="state_id" wire:model="state" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر الحالة</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر حالات</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-semibold mb-2">الوضعية:</label>
            <select wire:model="status" id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="على قيد الدراسة" {{ $status == 'على قيد الدراسة' ? 'selected' : '' }}>على قيد الدراسة</option>
                <option value="مخلق" {{ $status == 'مخلق' ? 'selected' : '' }}>مخلق</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="file" class="block text-sm font-semibold mb-2">تحميل الملفات:</label>
            <input name="files[]" type="file" wire:model="files" multiple>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">إرسال</button>
        </div>
    </form>
</div>
