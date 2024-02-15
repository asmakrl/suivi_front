<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Livewire\Component;

class RequestsForm extends Component
{

    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;


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

            // Make a POST request to create a new resource
           $http = new Client();
           $response= $http->post($apiUrl, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $requestData,
            ]);
        if ($response->getStatusCode()== 201) {
            // Resource created successfully
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




    public function render()
    {
        return view('livewire.requests-form');
    }
}
