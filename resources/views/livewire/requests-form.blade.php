<div class="container">
    <form wire:submit.prevent="store">

        <h2>Make a Request</h2>

        <div class="form-group">
            <label for="title">Title:</label>
            <input wire:model="title" type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Received At (Date):</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" required>
        </div>
        <div class="form-group">
            <label for="sender">Sender:</label>
            <select name="sender_id" wire:model="sender">
                <option value="">Select a sender</option>
                @forelse($senderData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                @empty
                    <option value="" disabled>No senders available</option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <select name="state_id" wire:model="state">
                <option value="">Select a state</option>
                @forelse($stateData as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nomAr'] }}</option>
                @empty
                    <option value="" disabled>No states available</option>
                @endforelse
            </select>
        </div>
        <div class="px-4 py-3 flex items-center justify-end">
            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Submit</button>
        </div>
    </form>
</div>
