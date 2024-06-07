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
    public int $id;
    public string $param;
    public int $index;
    public $uploadStatus = '';

    public $fileInputs = [];




    public function mount()
    {
        // Gate::authorize('uploadFiles', $this->requestId);
        //error_log($this->requestId);
    }
    public function closeDialog()
    {
        $this->reset('fileInputs', 'uploadStatus');
        $this->closeModal();
    }

    public function uploadFiles()
    {
        $this->uploadStatus = 'بدأ التحميل...';

        $apiUrl = 'http://localhost:8000/api/files/' . $this->id;

        $data = [
            [
                'name' => 'param',
                'contents' => $this->param
            ],
        ];

        foreach ($this->fileInputs as $file) {
            $data[] = [
                'name' => 'files[]',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName()
            ];
        }

        try {
            $http = new Client();
            $response = $http->post($apiUrl, [
                'multipart' => $data,
            ]);

            $this->uploadStatus = 'تم تحميل الملفات بنجاح!';
        } catch (\Exception $e) {
            $this->uploadStatus = 'فشل في تحميل الملفات: ' . $e->getMessage();
        }

        // Clear file inputs after upload
        $this->fileInputs = [];

        // Close the dialog
        if ($this->param == 'request') {
            $this->closeModalWithEvents([
                EditRequest::class => ['requestUpdated', [$this->param]]
            ]);
        } else {
            $this->closeModalWithEvents([
                EditRequest::class => ['responseUpdated', [$this->param, $this->index]]
            ]);
        }
    }



    public function render()
    {
        return view('livewire.file-uploader');
    }
}
