<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddResponse extends Component
{
    public $id;
    public $response;
    public $response_time;
    public $action;
    public $files = [];

    use WithFileUploads;

    public function mount(){

        //dd($this->receivedData = session()->get('dataToPass'));
        $this->receivedData = session()->get('dataToPass');
        $this->id = $this->receivedData['id'];
        $this->response = $this->receivedData['response'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        // $this->category = $this->receivedData['category'];
        $this->sender = $this->receivedData['sender'];

}

    public function save(){
        //dd('test');

        $apiUrl = 'http://localhost:8000/api/responses';

        $data = [
            [
                'name' => 'response',
                'contents' => $this->response
            ],
            [
                'name' => 'response_time',
                'contents' => $this->response_time
            ],

            [
                'name' => 'action_id',
                'contents' => $this->action
            ],
        ];
        if($this->files){
            foreach ($this->files as $file) {
                $data[] = [
                    'name' => 'files[]',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ];
            }}
        // dd($data);
        $multipart = new MultipartStream($data);
        // dd($multipart);
        $http = new Client();
        $response = $http->post($apiUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary()
            ],
            'body' => $multipart
        ]);

        if ($response->getStatusCode() == 201) {
            session()->flash('success', 'Resource created successfully');
           // $this->resetFormFields(); // Reset form fields after successful submission
            $this->redirect('/showrequests');
        } else {
            // Handle other status codes or scenarios
            session()->flash('error', 'Failed to create resource');
        }
    }
    public function render()
    {
        return view('livewire.add-response');
    }
}
