<div class="container">
    <h2>Edit a Request</h2>
    <form wire:submit.prevent="sendEdit">
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
        <div>
            <h2>List of Actions</h2>
            @foreach ($action as $act)
                <div class="action-container bg-gray-100 rounded-md p-4 mb-4">
                    <ul class="list-none p-0">
                        <li class="mb-2"><strong>Notes:</strong> {{ $act['name'] }}</li>
                        <li class="mb-2"><strong>Action Time:</strong> {{ $act['action_time'] }}</li>
                        <li class="mb-2"><strong>Action Type:</strong> {{ $act['type']['action_type'] }}</li>
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <button type="submit">Update Request</button>
        </div>
    </form>
</div>
