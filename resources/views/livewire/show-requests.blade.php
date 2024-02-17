<div class="container">
    <h2>Show a Request</h2>
    <form>
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
            <textarea wire:model="actionName" id="action" name="name" rows="4"  required>  "{{ $actionName}}" </textarea>
        </div>
        <div class="form-group">
            <label for="action-time">Action Date (Date):</label>
            <input wire:model="actionTime" type="date" id="date" name="date" value="{{ $actionTime}}" required>
        </div>
        <div class="form-group">
            <label for="action_type">Action Type:</label>
            <input wire:model="actionType" type="text" id="date" name="texte" value="{{ $actionType}}" required>
        </div>


    </form>
</div>

