<div class="container">
    <h2>Edit a Request</h2>
    <form wire:submit.prevent="sendEdit">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $title}}" required >
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"  required>  "{{ $description}}" </textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Received At (Date):</label>
            <input type="date" id="received_at" name="received_at" value="{{ $received_at}}" required>
        </div>
        <div class="form-group">
            <label for="sender">Sender:</label>
            <input type="text" id="sender" name="sender" value="{{ $sender}}" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input id="state" name="state" value="{{ $state}}" required>
        </div>

        <div class="form-group">
            <button type="submit">Update Request</button>
        </div>
    </form>
</div>
