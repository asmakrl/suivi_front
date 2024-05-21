<?php

namespace App\Livewire;

use Livewire\Component;

class ShowResponse extends Component
{
    public $id;

    public $response;
    public $response_time;

    public $files;

    public function mount()
    {

        //  dd($this->receivedData = session()->get('dataToPass'));
        $this->receivedData = session()->get('dataToPass');
        $this->id = $this->receivedData['id'];
        $this->response = $this->receivedData['response'];
        $this->response_time = $this->receivedData['response_time'];
        $this->files = $this->receivedData['file'];


    }

    public function test(){

    }
    public function render()
    {
        return view('livewire.show-response');
    }
}
