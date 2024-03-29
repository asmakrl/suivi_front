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
    public $status;
    public $category_id=0;
    public $receivedData;
    public $senderData;
    public $stateData;
    public $categoryData;
    public $category;
    public $files;
    public function mount()
    {

        $this->receivedData = session()->get('dataToPass');

        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender'];
        //$this->category= $this->receivedData['sender']['category'];

        // $this->sender2 = $this->receivedData['sender']['id'];
        $this->state = $this->receivedData['state'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];


        $this->getSender($this->category_id);
        $this->getState();
        $this->getCategories();

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
            'sender_id' => $this->sender,
            'state_id' => $this->state,
            //'action'=> $this->action,

        ];
       dd($requestData);
        // Create a GuzzleHttp client instance
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/requests/' . $this->id, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $requestData,

        ]);

        if ($response->getStatusCode() == 200) {
            // Resource edited successfully
            session()->flash('success', 'Resource edited successfully');
            $this->redirect('/showrequest');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to edit resource');
            return redirect()->back();
        }
    }

    public function deleteFile(){

    }
    public function getSender($categoryId)
    {
        $http = new Client();

        // Make a request to the API endpoint to retrieve all senders
        $response = $http->get('http://localhost:8000/api/senders');

        // Check if the request was successful
        if ($response->getStatusCode() === 200) {
            // Decode the response body
            $allSenders = json_decode($response->getBody(), true);

            // Filter the sender data based on the category ID
            $filteredSenders = array_filter($allSenders, function ($sender) use ($categoryId) {
                return $sender['category_id'] == $categoryId;
            });

            // Update the senderData property with the filtered senders
            $this->senderData = array_values($filteredSenders); // Re-index the array
        } else {
            // Handle the case where the request fails
            // You can log an error message or set senderData to an empty array
            $this->senderData = [];
            // Log the error if needed
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
