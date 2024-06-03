<div wire:init="loadData"class="container mx-auto p-8 text-right" style="direction: rtl;">
    @if ($isLoading)
        <div class="absolute inset-0 flex items-center justify-center ">
            <div class="animate-pulse rounded-full h-12 w-12 border-4 border-blue-500"></div>
        </div>
    @endif
    <h2 class="text-2xl font-bold">إضافة ملف جديد</h2>
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

    <form wire:submit.prevent="store" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
          style="direction: rtl; text-align: right;">

        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold mb-2">العنوان:</label>
            <input wire:model="title" type="text" id="title" name="title" required
                   placeholder="ادخل عنوان الملف"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-2">الوصف:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required
                      placeholder="ادخل وصف الملف"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
        </div>
        <div class="mb-4">
            <label for="source" class="block text-sm font-semibold mb-2">المصدر:</label>
            <input wire:model="source" type="text" id="source" name="source" required
                   placeholder="ادخل مصدر الملف"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-2">ولاية المصدر:</label>
            <select name="state_id" wire:model="state"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر الولاية</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر الولاية</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="received_at" class="block text-sm font-semibold mb-2">تاريخ الاستلام:</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" required
                   placeholder="اختر تاريخ الاستلام"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-2">ولاية المرسل:</label>
            <select name="state_id" wire:model="state_id" wire:change="updatestate($event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر ولاية المرسل</option>
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
            <select name="sender_id" wire:model="sender" wire:model="getSender()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر المرسل</option>
                @forelse($senderData as $sen)
                    <option value="{{ $sen['id'] }}">{{ $sen['name'] }}</option>
                @empty
                    <option value="" disabled>لا يوجد مرسلون متاحون</option>
                @endforelse
            </select>
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-semibold mb-2">تحميل الملفات:</label>
            <input name="files[]" type="file" wire:model="files" multiple>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">إرسال</button>
        </div>
    </form>
</div>
