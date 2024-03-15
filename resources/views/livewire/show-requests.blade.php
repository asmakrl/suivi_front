<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-4">عرض الطلب</h2>
    <hr class="border-b border-gray-300 mb-4">
    <form style="direction: rtl;">
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
            <label for="received_at" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" value="{{ $received_at }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="sender" class="block text-sm font-semibold mb-1">المرسل:</label>
            <input wire:model="sender" type="text" id="sender" name="sender" value="{{ $sender }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="state" class="block text-sm font-semibold mb-1">الولاية:</label>
            <input wire:model="state" id="state" name="state" value="{{ $state }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">قائمة الإجراءات</h2>
            @foreach ($action as $act)
                <div class="bg-gray-100 rounded-md p-4 mb-4">
                    <ul class="list-none p-0">
                        <li class="mb-2"><strong>الملاحظات:</strong> {{ $act['name'] }}</li>
                        <li class="mb-2"><strong>وقت الإجراء:</strong> {{ $act['action_time'] }}</li>
                        <li class="mb-2"><strong>نوع الإجراء:</strong> {{ $act['type']['action_type'] }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    </form>
</div>
