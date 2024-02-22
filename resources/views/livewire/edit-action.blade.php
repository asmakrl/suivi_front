<div class="container">
    <h2>Show a Request</h2>
    <form wire:submit.prevent="updateAction">
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea wire:model="name" id="name" name="name" rows="4">  "{{ $name}}" </textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Action Date (Date):</label>
            <input wire:model="action_time" type="date" id="date" name="date" value="{{ $action_time}}">
        </div>
        <label>
            <select name="type_id" wire:model="type_id" >
                <option value="">{{$type['action_type']}}}</option>
                @forelse($typeData as $type)

                    <option value="{{ $type['id'] }}" >{{ $type['action_type'] }}</option>
                @empty
                    <option value="" disabled>No actions available</option>
                @endforelse
            </select>
        </label>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
