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
    public $id;
    public $category_id;

    public $files;
    public $status;

    public $file_title;
    public $senderData = [];
    public $stateData = [];
    public $categoryData = [];

    public $statusData =[];
    public $isLoading=True;
    public function mount()
    {
        // $this->getSender($this->category_id);
        // $this->getState();
        // $this->getCategories();
        // $this->getstatus();
    }

    public Function loadData(){
        $this->getSender($this->category_id);
        $this->getState();
        $this->getCategories();
        $this->getstatus();
        $this->isLoading=False;

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

        ];
        if($this->files){
            foreach ($this->files as $file) {
                $data[] = [
                    'name' => 'files[]',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ];
            }}
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

    public function getSender($categoryId){

        $client = new Client();

        $response = $client->get('http://localhost:8000/api/senders/'. $categoryId);

        $senders = json_decode($response->getBody(), true);

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            $this->senderData = $senders;
        }
        else{
            $this->senderData = [];
            logger()->error('Failed to fetch senders. Status code: ' . $response->getStatusCode());

        }
    }
    public function getSender2($category_id)
    {

        $client = new Client;

        // Make a request to the API endpoint to retrieve all senders
        $response = $client->get('http://localhost:8000/api/senders');

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Decode the response body
            $allSenders = json_decode($response->getBody(), true);

            // Filter the sender data based on the category ID
            $filteredSenders = array_filter($allSenders, function ($sender) use ($category_id) {
                return $sender['category_id'] == $category_id;
            });

            // Update the senderData property with the filtered senders
            $this->senderData = array_values($filteredSenders);
        } else {
            // Handle the case where the request fails
            // You can log an error message or set senderData to an empty array
            $this->senderData = [];
            // Log the error if needed
            logger()->error('Failed to fetch senders. Status code: ' . $response->getStatusCode());
        }
    }


    public function getSender1($category_id)
    {
        $http = new Client();

        // Make a request to the API endpoint to retrieve senders based on the category ID
        $response = $http->get('http://localhost:8000/api/senders');

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Decode the response body
            $data = json_decode($response->getBody(), true);

            // Update the senderData property with the retrieved senders
            $this->senderData = $data;
        } else {
            // Handle the case where the request fails
            // You can log an error message or set senderData to an empty array
            $this->senderData = [];
            // Log the error if needed
            logger()->error('Failed to fetch senders. Status code: ' . $response->getStatusCode());
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
