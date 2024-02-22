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
    public $name;
    public $date;
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
        $this->sender = $this->receivedData['sender']['name'];
        $this->state = $this->receivedData['state']['nomAr'];

//         Fetch data for the request being edited

         $this->getAction()  ;
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
        //:dd('test');
        //localhost:8000/api/requests/29/actions/4
        // win rahi l'action ?hadi li telfetli lol ah ok ok
        // hna dok ndirou notre json
        $http = new Client();
        $actionData = [
            'name' => $this->name,
            'action_time' =>'2024-12-12',//$this->date,
            'request_id' => $this->id,
            'type_id' => $this->action,

        ];
 //       dd($actionData);
//        $response = $http->post('http://localhost:8000/api/actions');
        $response= $http->post('http://localhost:8000/api/actions', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $actionData,
        ]);
        if ($response->getStatusCode()== 201) {
            // Resource created successfully
            session()->flash('success', 'Resource created successfully');
            // Reset form fields after successful submission
            $this->redirect('/');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to create resource');
        }

    }


    public function render()
    {
        return view('livewire.add-actions',[
            'actions' => $this->actionData]);
    }
}
