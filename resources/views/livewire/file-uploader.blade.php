<div>
        <!-- Dialogue panel -->
        <div class="dialog-panel" style = "width: 200px; height: 200px;">
            <form wire:submit.prevent="uploadFiles">
                <input type="file" wire:model="fileInputs" multiple>
                <button type="submit">Upload</button>
            </form>

            <button wire:click="closeDialog">Close</button>
        </div>
</div>
