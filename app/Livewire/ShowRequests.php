<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ShowRequests extends ModalComponent
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender = [];
    public $state = [];
    public $action;
    public $category;
    public $actionTime;
    public $actionType;
    public $receivedData;
    public $files = [];
    public $response = [];
    public $isOpen = [];
    public $isFileDialogOpen = false;
    public $selectedFiles = [];
    public $selectedId;


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
        $this->category = $this->receivedData['sender']['category']['category'];
        $this->state = $this->receivedData['state']['nomAr'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];
        foreach ($this->action as $action) {
            $this->isOpen[$action['id']] = false; // Initialize all as closed
        }

        //$this->actionName = $action['name'];
        //$this->actionTime = $action['action_time'];
        //$this->actionType = $this->action['type'];


        //dd($this->receivedData);

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
   /* public function goToAddResponse(){
        //dd('test');

        $temp = $this->receivedData;
        //dd($temp);
        session()->put('dataToPass', $temp);

        $this->redirect('/addresponses');
    }*/
    public function test()
    {
        dd(url()->previous());
    }

    public function downloadFile($file_path)
    {
        $remoteFileUrl = 'http://127.0.0.1:8000/' . $file_path;
        //dd($remoteFileUrl);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'downloaded_file');

        // Télécharger le fichier localement
        $fileContent = file_get_contents($remoteFileUrl);
        file_put_contents($tempFilePath, $fileContent);

        // Obtenir le nom de fichier à partir de l'URL
        $fileName = basename($remoteFileUrl);

        // Téléchargez le fichier localement en utilisant Laravel Storage
        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
    }

    public function showFiles($responseId)
    {
     //   dd($responseId);
        // Find the response by ID
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


   /* public function goToEditRequest()
    {
        //dd('test');

        $temp = $this->receivedData;
        session()->put('dataToPass', $temp);

        $this->redirect('/editrequest');
    }*/


    public function render()
    {

        return view('livewire.show-requests');
    }
}
