<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Test extends Component
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;
public $receivedData;
    public function mount()
    {

//         Fetch data for the request being edited
        $this->receivedData = session()->get('dataToPass');

        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender_id'];
        $this->state = $this->receivedData['state_id'];


//        dd($this->receivedData);
    }



    public function sendEdit()
    {
        // Prepare the request data
        $requestData = [
            'title' => $this->title,
            'description' => $this->description,
            'received_at' => $this->received_at,
            'sender_id' => $this->sender,
            'state_id' => $this->state,
        ];

        // Create a GuzzleHttp client instance
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/requests/' . $this->id, [
            'json' => $requestData,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Resource edited successfully
            session()->flash('success', 'Resource edited successfully');
            return redirect()->route('requests');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to edit resource');
            return redirect()->back();
        }
    }
    public function render()
    {
        return view('livewire.test');
    }
}
