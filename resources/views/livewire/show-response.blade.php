<div class="container mx-auto p-8 text-right" style="direction: rtl;">

    <h2 class="text-2xl font-bold">عرض الاجابة</h2>
    <div class="float-left">
        <a wire:click="test()" class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
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
            <label for="response" class="block text-sm font-semibold mb-1">الجواب:</label>
            <textarea wire:model="response" id="response" name="response" rows="4" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $response }}</textarea>
        </div>
        <div class="mb-4">
            <label for="response_time" class="block text-sm font-semibold mb-1">تم الاستلام في (التاريخ):</label>
            <input wire:model="response_time" type="date" id="response_time" name="response_time" value="{{ $response_time }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">الملفات المرفقة</h2>
        @foreach ($files as $file)
            <div class="flex items-center justify-between bg-gray-100 rounded-md p-4 mb-4">
                <div>{{ $file['title'] }}</div>
                <button wire:click="downloadFile('{{ $file['file_path'] }}')" class="px-3 py-1 bg-blue-500 text-white rounded">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                </button>
            </div>
        @endforeach
    </div>
    </form>
    <div class="mb-4">
        <!-- Button to open dialog -->
        <button wire:click="$dispatch('openModal', { component: 'edit-response'  }})" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
            اضف ملفات اخرى
        </button>
        @livewire('wire-elements-modal')
    </div>
</div>

