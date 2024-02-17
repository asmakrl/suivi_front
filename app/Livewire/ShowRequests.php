<?php

namespace App\Livewire;

use Livewire\Component;

class ShowRequests extends Component
{
    public $id;
    public $title;
    public $description;
    public $received_at;
    public $sender;
    public $state;
    public $action;
    public $date;
    public $type;
    public $receivedData;
    public function mount()
    {

//         Fetch data for the request being edited
        $this->receivedData = session()->get('dataToPass');
        //dd($this->receivedData = session()->get('dataToPass'));
        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender_id'];
        $this->state = $this->receivedData['state_id'];
        $this->action = $this->receivedData['action'];
       // $this->action = $this->receivedData['action']['name'];
       // $this->date = $this->receivedData['action']['action_time'];
        //$this->type = $this->receivedData['action']['type'];


//        dd($this->receivedData);
    }
    public function show(){
        dd('test');
    }
    public function render()
    {
        return view('livewire.show-requests');
    }
}
