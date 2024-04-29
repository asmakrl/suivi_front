<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploader extends Component
{
    use WithFileUploads;

    public $showDialog = false;
    public $files;

    public function openDialog()
    {
        $this->showDialog = true;
    }

    public function closeDialog()
    {
        $this->reset(['showDialog', 'files']);
    }

    public function uploadFiles()
    {
        // Validate files
        $this->validate([
            'files.*' => 'required|file|max:10240', // Example validation for maximum file size (10MB)
        ]);

        // Save uploaded files

        // Clear the file input
        $this->reset('files');

        // Close the dialog
        $this->closeDialog();
    }
    public function render()
    {
        return view('livewire.file-uploader');
    }

}
