<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class AddActions extends Component
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;
    public $action;
    public $receivedData;
    public $actionData = [];


    public function mount()
    {
        $this->receivedData = session()->get('dataToPass');

        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender_id'];
        $this->state = $this->receivedData['state_id'];

//         Fetch data for the request being edited

        $this->getAction() ;
//        dd($this->receivedData);
    }

    public function getAction()
    {
        $http = new Client();

            $response = $http->get('http://localhost:8000/api/actions');

            // Check if the request was successful (status code 2xx)

                // Get the response body as an array
        $data = json_decode($response->getBody(), true);

                // Check if the decoding was successful


        $this->actionData = $data;




    }
    public function save(){
        dd('test');
    }
    public function render()
    {
        return view('livewire.add-actions',[
            'actions' => $this->actionData]);
    }
}
