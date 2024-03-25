<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowRequests extends Component
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender = [];
    public $state = [];
    public $action;
    public $actionTime;
    public $actionType;
    public $receivedData;
    public $files = [];

    public function mount()
    {
        // Fetch data for the request being edited
        $this->receivedData = session()->get('dataToPass');
        //dd($this->receivedData = session()->get('dataToPass'));
        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender']['name'];
        $this->state = $this->receivedData['state']['nomAr'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];


        //$this->actionName = $action['name'];
        //$this->actionTime = $action['action_time'];
        //$this->actionType = $this->action['type'];


        //dd($this->receivedData);

    }


    public function downloadFile($file_path)
    {

        // Call the API endpoint to download the file
//        $http= New Client();
//        $response = $http->get('http://localhost:8000/api/files/' . $fileId.'/download');
//        //dd($response);
//        // Check if the request was successful
//        if ($response->getStatusCode()===200) {
//            // Get the file name and contents from the response
//            $fileName = $response->getHeader('Content-Disposition');
//            $fileContents = $response->getBody();
//
//
//            // Trigger the file download in the browser
//            return response()->streamDownload(function () use ($fileContents) {
//                echo $fileContents;}
//                 , $fileName);}
//         else {
//            // Handle the case where the request fails
//            session()->flash('error', 'Failed to download file.');
//        }
        return Storage::disk(name: 'local')->download($file_path);
    }


    public function render()
    {
        return view('livewire.show-requests');
    }
}
