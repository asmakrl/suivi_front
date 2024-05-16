<div class="container mx-auto p-8" style="direction: rtl;">

        <h2 class="text-2xl font-bold">إضافة إجراء</h2>
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
    <form wire:submit.prevent="save">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">اختر إجراءً:</label>
            <select name="action_id" wire:model="action" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر إجراءً</option>
                @forelse($typeData as $type)
                    <option value="{{ $type['id'] }}">{{ $type['action_type'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر إجراءات</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="action_date" class="block text-sm font-semibold mb-1">تاريخ الإجراء (التاريخ):</label>
            <input wire:model="date" type="date" id="date" name="date" value="{{ $date }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="category" class="block text-sm font-semibold mb-2">فئة المرسل اليه:</label>
            <select wire:model="category_id" id="category_id" wire:change="getSender($event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر فئة المرسل اليه</option>
                @foreach ($categoryData as $category)
                    <option value="{{ $category['id'] }}">{{ $category['category'] }}</option>
                @endforeach
            </select>
            <label for="sender" class="block text-sm font-semibold mb-2">المرسل اليه:</label>
            <select name="sender_id" wire:model="sender"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر المرسل اليه</option>
                @forelse($senderData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                @empty
                    <option value="" disabled>لا يوجد مرسلون متاحون</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-sm font-semibold mb-1">ملاحظات:</label>
            <textarea wire:model="name" id="name" name="name" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $name }}</textarea>
        </div>
        <div class="flex items-center justify-center">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">حفظ</button>
        </div>
    </form>
</div>
