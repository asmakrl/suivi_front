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
    public $sender_id;


    public $state;
    public $state_id;
    public $action;
    public $receivedData;
    public $senderData;
    public $stateData;
    public function mount()
    {

//         Fetch data for the request being edited
        $this->receivedData = session()->get('dataToPass');

        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender'];
       // $this->sender2 = $this->receivedData['sender']['id'];
        $this->state = $this->receivedData['state'];
        //$this->state2 = $this->receivedData['state']['id'];

        $this->action = $this->receivedData['action'];

        $this->getSender();
        $this->getState();


       // dd($this->receivedData);
    }



    public function sendEdit()
    {
        // Prepare the request data

        $requestData = [
            'title' => $this->title,
            'description' => $this->description,
            'received_at' => $this->received_at,
            'sender_id' => $this->sender_id,
            'state_id' => $this->state_id,
             //'action'=> $this->action,

        ];

        // Create a GuzzleHttp client instance
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/requests/' . $this->id, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $requestData,

        ]);

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Resource edited successfully
            session()->flash('success', 'Resource edited successfully');
            $this->redirect('/');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to edit resource');
            return redirect()->back();
        }
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
    public function delete($id)
    {
        $client = new Client();

        try {
            $response = $client->delete('http://localhost:8000/api/actions/' . $id);

            if ($response->getStatusCode() == 200) {
                session()->flash('message', 'Action Deleted.');
                $this->redirect('/showrequest'); // Redirect to desired page after deletion
            } else {
                session()->flash('error', 'Failed to delete action.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function goToEditAction($item){
        //dd('test');

        $temp = $this->findActionById($item);
        //dd($temp);
        session()->put('dataToPass', $temp);

        $this->redirect('/editactions');
    }
    public function findActionById($id)
    {
        foreach ($this->action as $act) {
            if ($act['id'] == $id) {
                return $act;
            }
        }
    }




    public function render()
    {
        return view('livewire.test');
    }
}
