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
    public $state_id;
    public $categoryData=[];
    public $senderData = [];
    public $stateData = [];
public function mount()
{

//    Fetch data for the request being edited
   //dd( $this->receivedData = session()->get('dataToPass'));
    $this->receivedData = session()->get('dataToPass');

    $this->id = $this->receivedData['id'];
    $this->name = $this->receivedData['name'];
    $this->action_time = $this->receivedData['action_time'];
    //$this->request_id = $this->receivedData['request_id'];

    $this->sender = $this->receivedData['sender'];
    //$this->category = $this->receivedData['category'];
    $this->type = $this->receivedData['type'];
    $this->state_id = $this->receivedData['sender']['state']['id'];


    $this->getCategories();
    $this->getSender();
    $this->gettype();
    $this->getState();

    // $this->getState();

//    dd($this->receivedData);
}

    public function updatecat($categoryId){
        $this->category_id = $categoryId;
        $this->getSender();
    }
    public function updatestate($stateId){
        $this->state_id = $stateId;
        $this->getSender();
    }


    public function getSender()
    {
        $this->senderData = [];

        // Check if the categoryData is not empty
        if (!empty($this->categoryData)) {
            // Filter the categoryData to get the specific category with the matching ID
            $filteredCategories = array_filter($this->categoryData, function ($cat) {
                return $cat['id'] == $this->category_id;
            });

            // Check if any category is found
            if (!empty($filteredCategories)) {
                // Get the first category (assuming there's only one category with the same ID)
                $category = reset($filteredCategories);

                // Check if the sender key exists in the category data
                if (isset($category['sender'])) {
                    // Filter senders based on state_id
                    $filteredSenders = array_filter($category['sender'], function ($sender) {
                        return $sender['state_id'] == $this->state_id;
                    });

                    // Assign filtered sender data to senderData property
                    $this->senderData = array_values($filteredSenders);
                }
            }
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

    public function getSender1($categoryId){

        error_log($categoryId);

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
        if($this->type_id == null){
        $actionData = [
            'name' => $this->name,
            'action_time' => $this->action_time,
            'sender_id' => $this->sender,
            'type_id' => $this->receivedData['type_id'],
        ];}
        else{
            $actionData = [
                'name' => $this->name,
                'action_time' => $this->action_time,
                 'sender_id' => $this->sender,
                'type_id' => $this->type_id,
            ];
        }


       //  dd($actionData);
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
