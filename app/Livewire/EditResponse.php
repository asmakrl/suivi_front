<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditResponse extends ModalComponent
{
    public $id;

    public $response;
    public $response_time;

    public $files;
    public function mount(){

    }
    public function closeDialog()
    {
        // $this->reset(['showDialog', 'files']);
        $this->closeModal();

    }
    public function editResponse() {

    }
    public function render()
    {
        return view('livewire.edit-response');
    }
}
