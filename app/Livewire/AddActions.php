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
    public $receivedData;
    public $typeData = [];
    public $senderData = [];

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

        $this->state = $this->receivedData['state']['nomAr'];

//         Fetch data for the request being edited

         $this->getType()  ;
         $this->getCategories();
         $this->getSender($this->category_id);

//        dd($this->receivedData);
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

            'sender_id' => $this->sender,

            'type_id' => $this->action,

        ];
       //dd($actionData);
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
