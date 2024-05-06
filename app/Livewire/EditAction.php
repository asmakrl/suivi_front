<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class EditAction extends Component
{
    public $id;
    public $name;
    public $action_time;

    public $type;
    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;
    public $receivedData;

    public $type_id;
    public $typeData;
public function mount()
{

//         Fetch data for the request being edited
   $this->receivedData = session()->get('dataToPass');

    $this->id = $this->receivedData['id'];
    $this->name = $this->receivedData['name'];
    $this->action_time = $this->receivedData['action_time'];
    //$this->request_id = $this->receivedData['request_id'];
    $this->type = $this->receivedData['type'];

    $this->gettype();
   // $this->getState();


       //dd($this->receivedData);
}

    public function updateAction()
    {
        $http = new Client();
        // hadi erreur lowla hna ndirou check if type_id ==nul nedou type[id] eli b3athnah m3a session ok ?ok
        if($this->type_id == null){
        $actionData = [
            'name' => $this->name,
            'action_time' => $this->action_time,
           // 'request_id' => $this->request_id,
            'type_id' => $this->receivedData['type_id'],
        ];}
        else{
            $actionData = [
                'name' => $this->name,
                'action_time' => $this->action_time,
                // 'request_id' => $this->request_id,
                'type_id' => $this->type_id,
            ];
        }


         //dd($actionData);
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/actions/'.$this->id, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $actionData,

        ]);


        if ($response->getStatusCode() == 200) {
            session()->flash('message', 'Action Updated.');
            $data= json_decode($response->getBody(), true);
           //  dd($data);
            session()->put('dataToPass', $data);
            $this->redirect('/editrequest');
        } else {
            session()->flash('error', 'Failed to update action.');
        }
    }

    public function getType()
    {

        $http = new Client();

        $response = $http->get('http://localhost:8000/api/types');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->typeData = $data;

    }
    public function render()
    {
        return view('livewire.edit-action');
    }
}
