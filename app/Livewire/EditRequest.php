<?php

namespace App\Livewire;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use function Laravel\Prompts\error;

class EditRequest extends Component
{
    use WithFileUploads;

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
    public $category_id;
    public $receivedData;
    public $senderData;
    public $stateData;
    public $categoryData;
    public $category;
    public $files;
    public $isLoading=True;
    public $listeners = ['requestUpdated'=>'updateReq'];

    public function mount()
    {

        $this->receivedData = session()->get('dataToPass');

        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender'];
        $this->category_id= $this->receivedData['sender']['category']['id'];

        // $this->sender2 = $this->receivedData['sender']['id'];
        $this->state = $this->receivedData['state'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];
        $this->sender_id = $this->receivedData['sender']['id'];
        $this->state_id = $this->receivedData['state']['id'];

        $this->getCategories();

        $this->getSender($this->category_id);
        $this->getState();
        $this->updateReq();
        // $this->delete($this->action['id']);
        // dd($this->action);
    }

    public function updateReq(){
        //error_log("dddddddd");
        $http = new Client();
        $response = $http->get('http://localhost:8000/api/files/'. $this->id);
        $data = json_decode($response->getBody(), true);
        $this->files = $data;

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
    //   dd($requestData);
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
            $data = json_decode($response->getBody(), true);

            session()->put('dataToPass', $data);
            $this->redirect('/showrequests');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to edit resource');
            return redirect()->back();
        }
    }

    public function getSender($categoryId){
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
    public function getSender2($categoryId)
    {
        $http = new Client();

        // Make a request to the API endpoint to retrieve all senders
        $response = $http->get('http://localhost:8000/api/senders');

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
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
    public function deleteAct($id){

        $http= New Client();

        $http->delete('http://localhost:8000/api/actions/' . $id);

        // Remove the deleted action from the $this->action array
        $this->action = array_filter($this->action, function ($act) use ($id) {
            return $act['id'] != $id;
        });
    }
    public function deleteFile($file_id, $request_id)
    {

        $apiUrl = 'http://localhost:8000/api/files/' . $file_id;
        // dd($apiUrl);

        $http= New Client();


        $http->delete($apiUrl);

        // Remove the deleted action from the $this->action array
        $this->files = array_filter($this->files, function ($file) use ($file_id) {
            return $file['id'] != $file_id;
        });
    }
    public function delete($id)
    {

        $apiUrl = 'http://localhost:8000/api/requests/' . $id;
        // dd($apiUrl);

        $http= New Client();


        $http->delete($apiUrl);

        $this->redirect('/');

    }

    public function goToEditAction($item){
        //dd('test');

        $temp = $this->findActionById($item);
//        dd($temp);
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
        return view('livewire.edit-request');
    }
}
