<div>
    <!-- Dialogue panel -->
    <div class="dialog-panel" style="width: 300px; height: 250px; border: 1px solid #ccc; padding: 20px; text-align: center; direction: rtl; font-family: 'Arial', sans-serif;">

        <h3>تحميل الملفات</h3>

        <form wire:submit.prevent="uploadFiles" style="margin-top: 20px;">
            <input type="file" wire:model="fileInputs" multiple>
            <button type="submit" style="background-color: #007bff; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">تحميل</button>
        </form>

        <button wire:click="closeDialog" style="background-color: #dc3545; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px;">إغلاق</button>
    </div>
</div>
