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
    public $requestData;
    public function mount()
    {

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

       // $this->delete($this->action['id']);
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

        // Check if the request was successful  pour afficher les erreur chabin koul wahda son message / coleur / crtique ou pas ....okkkk ida kan erreur me serveur return l home sinn y3awed yeb3ath sinn ...:p je vois dailleurs lyoumaweritlou w kali zidi afayess =Dhhhhhhh ma3lich apres nchofouhoum nebdaw fi hadi ?
        /// makhalitekch meme pas takray  lol mdrrr okkk nkhalik testé wela ?? rak tssakssi? nn ok lol aya nokhrej 3la jal les data okkkk
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
    public function delete($id){

        $http= New Client();

        $http->delete('http://localhost:8000/api/actions/' . $id);

        // Remove the deleted action from the $this->action array
        $this->action = array_filter($this->action, function ($act) use ($id) {
            return $act['id'] != $id;
        });
    }



    public function goToEditAction($item){
        //dd('test');

        $temp = $this->findActionById($item);
        //dd($temp);
        session()->put('dataToPass', $temp);
        // hna nzidou ndirou ssesion -> w nzidou request w ki ndirou edit l action n3awdou nrej3ouha mais ma3alablich ida c bien ookk ?okk

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
