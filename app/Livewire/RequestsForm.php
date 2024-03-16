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
    public $id;
    public $category_id=0;

    public $files;
    public $file_title;
    public $senderData = [];
    public $stateData = [];
    public $categoryData = [];

    public $statusData =[];

    public function mount()
    {
        $this->getSender($this->category_id);
        $this->getState();
        $this->getCategories();
        $this->getstatus();
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
                'name' => 'sender_id',
                'contents' => $this->sender
            ],
            [
                'name' => 'state_id',
                'contents' => $this->state
            ],
            [
                'name' => 'status_id',
                'contents' => $this->status,
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

    public function getSender($categoryId)
    {
        // Send a GET request to the API endpoint with the provided category_id
        $response = Http::get("http://localhost:8000/api/senders?category_id={$categoryId}");

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Get the response body as an array
            $this->senderData = $response->json();
        } else {
            // Handle the case when the request was not successful
            // For example, log an error or display a message to the user
            // You may also want to initialize senderData with an empty array or null here
            $this->senderData = [];
            // Log error or show error message
            logger()->error("Failed to fetch sender data. Status code: {$response->status()}");
            // Or show error message to user
            // $this->addError('senderData', 'Failed to fetch sender data.');
        }
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

    public function getCategories()
    {

        $http = new Client();

        $response = $http->get('http://localhost:8000/api/categories');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->categoryData = $data;

    }
    public function getStatus()
    {

        $http = new Client();

        $response = $http->get('http://localhost:8000/api/statuses');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->statusData = $data;

    }
    public function render()
    {
        return view('livewire.requests-form', [
            'sender' => $this->senderData
        ]);
    }
}
