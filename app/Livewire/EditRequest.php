<?php

namespace App\Livewire;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use function Laravel\Prompts\error;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
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
    public $source;
    public $state_id;

    public $action;
    public $status;
    public $category_id;
    public $receivedData;
    public $senderData=[];
    public $stateData=[];
    public $categoryData=[];
    public $category;
    public $files;
    public $senState_id;

    public $response=[];
    public $selectedId;
    public $isLoading=True;
    public $isOpen = [];
    public $isFileDialogOpen = false;
    public $selectedFiles = [];
    public $listeners = ['requestUpdated'=>'updateReq'];

    public function mount()
    {

       // dd($this->receivedData = session()->get('dataToPass'));
        $this->receivedData = session()->get('dataToPass');
        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender'];
         //dd($this->sender);
       // $this->response = $this->receivedData['action'][0]['response'];

        $this->category_id= $this->receivedData['sender']['category']['id'];

        // $this->sender2 = $this->receivedData['sender']['id'];
        $this->state = $this->receivedData['state'];
        $this->source = $this->receivedData['source'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];
        //$this->response = $this->receivedData['action']['response'];

        $this->sender_id = $this->receivedData['sender']['id'];
         $this->state_id = $this->receivedData['state']['id'];
        //$this->state_id = $this->receivedData['sender']['state']['id'];
         $this->senState_id = $this->receivedData['sender']['state']['id'];
        $this->category_id = $this->receivedData['sender']['category_id'];
        foreach ($this->action as $action) {
            $this->isOpen[$action['id']] = false; // Initialize all as closed
        }
    }
    public function load()
    {
        $this->getCategories();
        $this->getSender();
        $this->getState();
        $this->updateReq();
        $this->updateRes();


        $this->isLoading = false;
    }
    public function updateReq(){
        //error_log("dddddddd");
        $http = new Client();
        $response = $http->get('http://localhost:8000/api/files/'. $this->id);
        $data = json_decode($response->getBody(), true);
        $this->files = $data;

    }

    public function updateRes(){
        //error_log("dddddddd");
        $http = new Client();
        $response = $http->get('http://localhost:8000/api/responses/'. $this->id);

        $data = json_decode($response->getBody(), true);
        $this->response = $data;

    }

    public function toggle($id)
    {
        // Toggle the isOpen state
        $this->isOpen[$id] = !$this->isOpen[$id];

        // Find action by id and get responses
        $action = collect($this->action)->firstWhere('id', $id);

        if (isset($action['response'])) {
            $this->selectedId = $id;
            $this->response[$id] = $action['response'];
        } else {
            $this->response[$id] = [];
        }
    }

    public function showFiles($responseId)
    {
        //   dd($responseId);
        // dd($this->response);
        $response = collect($this->response[$this->selectedId])->firstWhere('id', $responseId);
        //dd($response);
        // Load the files for the selected response
        $this->selectedFiles = $response['file'] ?? [];

        // Open the file dialog
        $this->isFileDialogOpen = true;
    }
    public function closeFileDialog()
    {
        // Close the file dialog
        $this->isFileDialogOpen = false;
    }

    public function sendEdit()
    {
        // Prepare the request data

        $requestData = [
            'title' => $this->title,
            'description' => $this->description,
            'source' => $this->source,
            'received_at' => $this->received_at,
            'sender_id' => $this->sender_id,
            'state_id' => $this->state_id,
            //'action'=> $this->action,

        ];
   //  dd($requestData);
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
            $this->redirect('/editrequest');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to edit resource');
            return redirect()->back();
        }
    }

    public function updatecat($categoryId){
        $this->category_id = $categoryId;
        $this->getSender();
    }
    public function updatestate($stateId){
        $this->senState_id = $stateId;
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
                        return $sender['state_id'] == $this->senState_id;
                    });

                    // Assign filtered sender data to senderData property
                    $this->senderData = array_values($filteredSenders);
                }
            }
        }
    }
    public function getSender3(){
        if ($this->category_id && $this->state_id){
            $client = new Client();


            $response = $client->get('http://localhost:8000/api/senders/category/'. $this->category_id.'/state/'.$this->state_id);

            $senders = json_decode($response->getBody(), true);

            // Check if the request was successful
            if ($response->getStatusCode() == 200) {
                $this->senderData = $senders;
            }
            else{
                $this->senderData = [];
                logger()->error('Failed to fetch senders. Status code: ' . $response->getStatusCode());

            }}
    }

    public function getSender1()
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
                    // Assign sender data to senderData property
                    $this->senderData = $category['sender'];
                }
            }
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
        $this->getSender();

    }
    public function deleteAct($id){

        $http= New Client();

        $http->delete('http://localhost:8000/api/actions/' . $id);

        // Remove the deleted action from the $this->action array
        $this->action = array_filter($this->action, function ($act) use ($id) {
            return $act['id'] != $id;
        });
    }

    public function deleteRes($id){
      //dd($id);
       $http= New Client();

        $http->delete('http://localhost:8000/api/responses/' . $id);

        // Remove the deleted action from the $this->action array
        $this->response = array_filter($this->response, function ($res) use ($id){
            return isset($res['id']) && $res["id"] != $id;
        });
    }
    public function deleteFile($file_id)
    {
        $apiUrl = 'http://localhost:8000/api/files/' . $file_id;
        // dd($apiUrl);

        $http = new Client();


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
      // dd($temp);
        session()->put('dataToPass', $temp);

        $this->redirect('/editactions');
    }

    public function goToShowResponse($item){
        //dd($this->receivedData);
        $temp = $this->findResponseById($item);
        //dd($temp);
        session()->put('dataToPass', $temp);

        $this->redirect('/showresponses');
    }
    public function findActionById($id)
    {
        foreach ($this->action as $act) {
            if ($act['id'] == $id) {
                return $act;
            }
        }
    }

    public function findResponseById($id)
    {
        foreach ($this->response as $res) {
            if ($res['id'] == $id) {
                return $res;
            }
        }}


    public function render()
    {
        return view('livewire.edit-request');
    }
}
