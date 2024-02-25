<div class="container mx-auto p-8" style="direction: rtl;">
    <h2 class="text-2xl font-bold mb-4">إضافة إجراء</h2>
    <hr class="border-b border-gray-300 mb-4">
    <form wire:submit.prevent="save">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">

        <div class="mb-4">
            <label for="notes" class="block text-sm font-semibold mb-1">ملاحظات:</label>
            <textarea wire:model="name" id="name" name="name" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $name }}</textarea>
        </div>
        <div class="mb-4">
            <label for="action_date" class="block text-sm font-semibold mb-1">تاريخ الإجراء (التاريخ):</label>
            <input wire:model="date" type="date" id="date" name="date" value="{{ $date }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">اختر إجراءً:</label>
            <select name="action_id" wire:model="action" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">اختر إجراءً</option>
                @forelse($actionData['data'] as $act)
                    <option value="{{ $act['type']['id'] }}">{{ $act['type']['action_type'] }}</option>
                @empty
                    <option value="" disabled>لا تتوفر إجراءات</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">حفظ</button>
        </div>
    </form>
</div>
