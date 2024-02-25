<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-4">Show An Action</h2>
    <hr class="border-b border-gray-300 mb-4">
    <form wire:submit.prevent="updateAction">
        <div class="mb-4">
            <label for="notes" class="block text-sm font-semibold mb-1">Notes:</label>
            <textarea wire:model="name" id="name" name="name" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $name }}</textarea>
        </div>
        <div class="mb-4">
            <label for="action_date" class="block text-sm font-semibold mb-1">Action Date (Date):</label>
            <input wire:model="action_time" type="date" id="action_date" name="action_date" value="{{ $action_time }}" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Action Type:</label>
            <select name="type_id" wire:model="type_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                <option value="">{{ $type['action_type'] }}</option>
                @forelse($typeData as $actType)
                    <option value="{{ $actType['id'] }}">{{ $actType['action_type'] }}</option>
                @empty
                    <option value="" disabled>No actions available</option>
                @endforelse
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg></button>
        </div>
    </form>
</div>
