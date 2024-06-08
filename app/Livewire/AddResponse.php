<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddResponse extends Component
{
    public $id;
    public $receivedData;

    public $response;
    public $response_time;
    public $action = [];
    public $selectedActionId;
    public $files = [];

    use WithFileUploads;

    public function mount()
    {
        // Ensure the session data is retrieved correctly
        $this->receivedData = session()->get('dataToPass');
        if ($this->receivedData && isset($this->receivedData['action'])) {
            $this->action = $this->receivedData['action'];
        }
        // Set default selected action id if available
        if (!empty($this->action)) {
            $this->selectedActionId = $this->action[0]['id'];
        }
    }

    public function save()
    {
        // API URL to post data
        $apiUrl = 'http://localhost:8000/api/responses';

        // Prepare the data for multipart form submission
        $data = [
            [
                'name' => 'response',
                'contents' => $this->response
            ],
            [
                'name' => 'response_time',
                'contents' => $this->response_time
            ],
            [
                'name' => 'action_id',
                'contents' => $this->selectedActionId
            ],
        ];

        // Handle file uploads
        if ($this->files) {
            foreach ($this->files as $file) {
                $data[] = [
                    'name' => 'files[]',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ];
            }
        }
        //dd($data);
        // Create MultipartStream from data
        $multipart = new MultipartStream($data);

        // Initialize HTTP client and send request
        $http = new Client();
        $response = $http->post($apiUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary()
            ],
            'body' => $multipart
        ]);

        // Check response status and handle accordingly
        if ($response->getStatusCode() == 201) {
            session()->flash('success', 'Resource created successfully');
            $this->redirect('/');
        } else {
            session()->flash('error', 'Failed to create resource');
        }
    }

    public function render()
    {
        return view('livewire.add-response', [
            'actions' => $this->action
        ]);
    }
}
