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
    public $category;
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
        $this->category = $this->receivedData['sender']['category']['category'];
        $this->state = $this->receivedData['state']['nomAr'];

        $this->action = $this->receivedData['action'];
        $this->files = $this->receivedData['file'];


        //$this->actionName = $action['name'];
        //$this->actionTime = $action['action_time'];
        //$this->actionType = $this->action['type'];


        //dd($this->receivedData);

    }
    public function test(){
        dd(url()->previous());
    }

    public function downloadFile($file_path)
    {
        $remoteFileUrl = 'http://127.0.0.1:8000/'.$file_path;
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

    public function goToEditRequest(){
        //dd('test');

        //win rah l item ?ama? ok ok
        $temp = $this->receivedData;
        session()->put('dataToPass', $temp);

        $this->redirect('/editrequest');
    }


    public function render()
    {

        return view('livewire.show-requests');

    }
}
