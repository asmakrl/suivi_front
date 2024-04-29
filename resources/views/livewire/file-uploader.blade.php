<div>
    @if($showDialog)
        <!-- Dialogue panel -->
        <div class="dialog-panel">
            <form wire:submit.prevent="uploadFiles">
                <input type="file" wire:model="files" multiple>
                <button type="submit">Upload</button>
                <button wire:click="closeDialog">Close</button>
            </form>
        </div>
    @endif
</div>
