<div class="container">
    <h2>Show a Request</h2>
    <form wire:submit.prevent="save">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group">
            <label for="title">Title:</label>
            <input wire:model="title" type="text" id="title" name="title" value="{{ $title}}" required >
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea wire:model="description" id="description" name="description" rows="4"  required>  "{{ $description}}" </textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Received At (Date):</label>
            <input wire:model="received_at" type="date" id="received_at" name="received_at" value="{{ $received_at}}" required>
        </div>
        <div class="form-group">
            <label for="sender">Sender:</label>
            <input wire:model="sender" type="text" id="sender" name="sender" value="{{ $sender}}" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input wire:model="state" id="state" name="state" value="{{ $state}}" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea wire:model="name" id="name" name="name" rows="4"  required>  "{{ $name}}" </textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Action Date (Date):</label>
            <input wire:model="date" type="date" id="date" name="date" value="{{ $date}}" required>
        </div>
        <label>
            <select name="action_id" wire:model="action" >
                <option value="">Select an action</option>
                @forelse($actionData['data'] as $action)

                        <option value="{{ $action['type']['id'] }}" >{{ $action['type']['action_type'] }}</option>
                @empty
                        <option value="" disabled>No actions available</option>
                @endforelse
            </select>
        </label>




        <div class="form-group">
            <button  type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Save</button>
        </div>
    </form>
</div>
