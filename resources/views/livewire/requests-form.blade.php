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
            <input wire:model="sender" type="text" id="sender" name="sender" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input wire:model="state" id="state" name="state" required>
        </div>
        <div class="px-4 py-3 flex items-center justify-end">
            <button class="px-3 py-1 bg-blue-500 text-white rounded">submit</button>
        </div>
    </form>

</div>
