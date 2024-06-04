<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditResponse extends ModalComponent
{
    public int $responseID;

    public $response;
    public $response_time;
    public $responseData=[];
    public $files;
    public function mount(){
        error_log($this->responseID);
  }
    public function closeDialog()
    {
        // $this->reset(['showDialog', 'files']);
        $this->closeModal();

    }

    public function getResponse(){

        $client = New Client();
        $response = $client->get('http://localhost:8000/api/responses/' . $this->responseID);

        $data  = json_decode($response->getBody(), true);
        if (isset($data['data']) && is_array($data['data'])) {
            // Assign the requests data to the property
            $this->responseData = $data['data'];
            // Assign pagination data
          //  $this->response = $data['response'];

           // $this->response_time = $data['response_time'];
        }

    }

    public function editResponse() {
        // Prepare the request data

        $responseData = [
            'response' => $this->response,
            'response_time' => $this->response_time,

        ];
      //     dd($responseData);
        // Create a GuzzleHttp client instance
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/responses/' . $this->responseID, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $responseData,

        ]);


        $this->closeModalWithEvents([
            EditRequest::class =>'requestUpdated'
        ]);

    }
    public function render()
    {
        return view('livewire.edit-response');
    }
}
