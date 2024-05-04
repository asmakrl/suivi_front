<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
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
        //error_log($this->requestId);
    }
    public function closeDialog()
    {
       // $this->reset(['showDialog', 'files']);
        $this->closeModalWithEvents([
            Test::class =>'requestUpdated'
        ]);

    }

    public function uploadFiles()
    {


        $apiUrl = 'http://localhost:8000/api/files/' . $this->requestId;

        $data = [];

        foreach ($this->fileInputs as $file) {
            $data[] = [
                'name' => 'files[]',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName()
            ];
        }
        // dd($data);
        $multipart = new MultipartStream($data);
        // dd($multipart);
        $http = new Client();
        $response = $http->post($apiUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary()
            ],
            'body' => $multipart
        ]);


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
