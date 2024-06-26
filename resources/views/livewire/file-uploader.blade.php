<div class="dialog-panel"
     style="width: auto; height: auto; border: 1px solid #ccc; padding: 20px; text-align: center; direction: rtl; font-family: 'Arial', sans-serif;">
    <h3>تحميل الملفات</h3>
    <form wire:submit.prevent="uploadFiles" style="margin-top: 20px;">
        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
             x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress">
            <input type="file" wire:model.defer="fileInputs" multiple>
            @if ($fileInputs)
                <div class="mt-2">
                    <h4 class="font-semibold">الملفات المحددة:</h4>
                    <ul>
                        @foreach ($fileInputs as $file)
                            <li>{{ $file->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Progress Bar -->
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>
        <button type="submit"
                style="background-color: #007bff; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px;">تحميل</button>
    </form>
    <div wire:loading wire:target="fileInputs" style="margin-top: 20px;">
        جاري التحميل...
    </div>
    <div wire:loading.remove wire:target="uploadFiles" style="margin-top: 20px;">
        @if ($uploadStatus)
            <span>{{ $uploadStatus }}</span>
        @endif
    </div>
    <button wire:click="closeDialog"
            style="background-color: #dc3545; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px;">إغلاق</button>
</div>
