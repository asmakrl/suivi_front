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
    public $category;

    public $state;
    public $category_id;

    public $receivedData;

    public $type_id;
    public $action;
    public $typeData;
    public $categoryData;
    public $senderData;
public function mount()
{

//    Fetch data for the request being edited
 //   dd( $this->receivedData = session()->get('dataToPass'));
    $this->receivedData = session()->get('dataToPass');

    $this->id = $this->receivedData['id'];
    $this->name = $this->receivedData['name'];
    $this->action_time = $this->receivedData['action_time'];
    //$this->request_id = $this->receivedData['request_id'];

    $this->sender = $this->receivedData['sender'];
    //$this->category = $this->receivedData['category'];
    $this->type = $this->receivedData['type'];

    $this->getCategories();
    $this->getSender($this->category_id);
    $this->gettype();
   // $this->getState();

    //dd($this->category);
}

    public function getSender($category_id)
    {

        $http = new Client();

        // Make a request to the API endpoint to retrieve all senders
        $response = $http->get('http://localhost:8000/api/senders');

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
