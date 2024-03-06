<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class RequestsForm extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $received_at;
    public $status;
    public $sender;
    public $state;
    public $categories;

    public $files;
    public $file_title;
    public $senderData = [];
    public $stateData = [];

    public function mount()
    {

        $this->getSender();
        $this->getState();
    }


    public function store()
    {
        $apiUrl = 'http://localhost:8000/api/requests';

        $data = [
            [
                'name' => 'title',
                'contents' => $this->title
            ],
            [
                'name' => 'description',
                'contents' => $this->description
            ],
            [
                'name' => 'received_at',
                'contents' => $this->received_at
            ],
            [
                'name' => 'status',
                'contents' => $this->status,
            ],
            [
                'name' => 'sender_id',
                'contents' => $this->sender
            ],
            [
                'name' => 'state_id',
                'contents' => $this->state
            ],
        ];

        foreach ($this->files as $file) {
            $data[] = [
                'name' => 'files[]',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName()
            ];
        }
        //dd($data);
        $multipart = new MultipartStream($data);
       // dd($multipart);
        $http = new Client();
        $response = $http->post($apiUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary()
            ],
            'body' => $multipart
        ]);

        if ($response->getStatusCode() == 201) {
            session()->flash('success', 'Resource created successfully');
            $this->resetFormFields(); // Reset form fields after successful submission
            $this->redirect('/');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to create resource');
        }
    }


    private function resetFormFields()
    {
        // Reset form fields after successful submission
        $this->title = '';
        $this->description = '';
        $this->received_at = '';
        $this->status = '';
        $this->sender = '';
        $this->state = '';
    }

    public function getSender()
    {

        $http = new Client();

        $response = $http->get('http://localhost:8000/api/senders');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->senderData = $data;

    }

    public function getState()
    {

        $http = new Client();

        $response = $http->get('http://localhost:8000/api/states');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->stateData = $data;

    }


    public function render()
    {
        return view('livewire.requests-form', [
            'sender' => $this->senderData
        ]);
    }
}
