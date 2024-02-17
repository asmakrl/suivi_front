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
    public $actionName;
    public $actionTime;
    public $actionType;
    public $receivedData;
    public function mount()
    {
        // Fetch data for the request being edited
        $this->receivedData = session()->get('dataToPass');
        //dd($this->receivedData = session()->get('dataToPass'));
        $this->id = $this->receivedData['id'];
        $this->title = $this->receivedData['title'];
        $this->description = $this->receivedData['description'];
        $this->received_at = $this->receivedData['received_at'];
        $this->sender = $this->receivedData['sender_id'];
        $this->state = $this->receivedData['state_id'];

        foreach ($this->receivedData['action'] as $action) {

            $this->actionName = $action['name'];
            $this->actionTime = $action['action_time'];
            $this->actionType = $action['type']['action_type'];




            //dd($this->receivedData);
        }
    }

    public function show(){
        dd('test');
    }
    public function render()
    {
        return view('livewire.show-requests');
    }
}
