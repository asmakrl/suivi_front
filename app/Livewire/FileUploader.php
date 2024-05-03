<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class FileUploader extends ModalComponent
{
    use WithFileUploads;
    // This will inject just the ID
     public int $requestId;
    public $fileInputs = [];




    public function mount()
    {
       // Gate::authorize('uploadFiles', $this->requestId);
       // error_log($this->requestId);
    }
    public function closeDialog()
    {
       // $this->reset(['showDialog', 'files']);
        $this->closeModal();

    }

    public function uploadFiles()
    {
        $http = new Client();
        foreach ($this->fileInputs as $uploadedFile) {
             $http->attach(

                'files[]',
                $uploadedFile->getRealPath(),
                $uploadedFile->getClientOriginalName()
            )->post('http://localhost:8000/api/files/' . $this->requestId);


        }

        // Clear file inputs after upload
        $this->fileInputs = [];

        // Close the dialog
        $this->closeDialog();
    }
    public function render()
    {
        return view('livewire.file-uploader');
    }

}
