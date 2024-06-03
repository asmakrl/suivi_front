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
    public $category_id;
    public $state_id;
    public $response_id ='01';
    public $receivedData;
    public $typeData = [];
    public $senderData = [];
    public $stateData = [];
    public $categoryData=[];


    public function mount()
    {
        //dd($this->receivedData = session()->get('dataToPass'));
        $this->receivedData = session()->get('dataToPass');
        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
       // $this->category = $this->receivedData['category'];
        $this->sender = $this->receivedData['sender'];
        $this->state_id = $this-> receivedData['sender']['state']['id'];
        $this->state = $this->receivedData['state']['nomAr'];
        $this->action = $this->receivedData['action'];

//         Fetch data for the request being edited

         $this->getType()  ;
         $this->getCategories();
         $this->getSender();
         $this->getState();

//        dd($this->receivedData);
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

    public function getSende2r($categoryId){

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


    public function save(){

        $http = new Client();
        $actionData = [
            'name' => $this->name,
            'action_time' =>$this->date,//$this->date,
            'request_id' => $this->id,

            'sender_id' => $this->sender['id'],

            'type_id' => $this->action,
           // 'response_id' => $this->response_id,


        ];
      //  dd($actionData);
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
        return view('livewire.add-actions');
    }
}
