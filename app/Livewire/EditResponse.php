<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditResponse extends ModalComponent
{
    public $id;

    public $response;
    public $response_time;
    public $responseData = [];
    public $files;
    public function mount(){

    }
    public function closeDialog()
    {
        // $this->reset(['showDialog', 'files']);
        $this->closeModal();

    }
    public function editResponse() {
        // Prepare the request data

        $responseData = [
            'response' => $this->response,
            'response_time' => $this->response_time,

        ];
        //   dd($requestData);
        // Create a GuzzleHttp client instance
        $client = new Client();

        // Send the form data to the API endpoint using GuzzleHttp
        $response = $client->put('http://localhost:8000/api/reponses/' . $this->id, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $responseData,

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
    public function render()
    {
        return view('livewire.edit-response');
    }
}
