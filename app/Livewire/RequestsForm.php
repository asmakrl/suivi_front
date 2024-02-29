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
    public $sender;
    public $state;
    public $file;
    public $senderData = [];
    public $stateData = [];

    public function mount()
    {

        $this->getSender();
        $this->getState();
    }

    public function store()
    {

        // Replace the API endpoint with your actual endpoint for creating a resource
        $apiUrl = 'http://localhost:8000/api/requests';


        // Prepare the request data
        $requestData = [
            'title' => $this->title,
            'description' => $this->description,
            'received_at' => $this->received_at,
            'sender_id' => $this->sender,
            'state_id' => $this->state,
        ];
//        $requestData['file'] = base64_encode(file_get_contents($this->file->getRealPath()));
        //dd($requestData);
        // Make a POST request to create a new resource
        $filePath = $this->file->store('uploads');
        $http = new Client();
        $multipart = new MultipartStream([
            [
                'name' => 'title',
                'contents' => $this->title // Assuming 'title' is a form field
            ],
            [
                'name' => 'description',
                'contents' => $this->description // Assuming 'description' is a form field
            ],
            [
                'name' => 'received_at',
                'contents' => $this->received_at// Assuming 'received_at' is a form field
            ],
            [
                'name' => 'sender_id',
                'contents' => $this->sender // Assuming 'sender_id' is a form field
            ],
            [
                'name' => 'state_id',
                'contents' => $this->state // Assuming 'state_id' is a form field
            ],
            [
                'name' => 'file',
                'contents' => fopen($this->file->getRealPath(), 'r'),
                'filename' => $this->file->getClientOriginalName(),
            ]
        ]);
        $response = $http->post($apiUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary()
            ],
            'body' => $multipart
        ]);
        if ($response->getStatusCode() == 201) {
            // Resource created successfully
            dd($response->getBody());
            session()->flash('success', 'Resource created successfully');
            $this->resetFormFields();// Reset form fields after successful submission
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
            'sender' => $this->senderData]);
    }
}
