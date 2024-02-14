<?php
namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RequestsEdit extends Component
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;

    public function mount($id)
    {

    // Fetch data for the request being edited
    $response = Http::get('http://localhost:8000/api/requests/' . $id);

    if ($response->successful()) {
    $requestData = $response->json();

    $this->id = $id;
    $this->title = $requestData['title'];
    $this->description = $requestData['description'];
    $this->received_at = $requestData['received_at'];
    $this->sender = $requestData['sender_id'];
    $this->state = $requestData['state_id'];
    } else {
    // Handle error when fetching data
    // For example, redirect to an error page
    }
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
        return view('livewire.requests-edit');
    }
}
