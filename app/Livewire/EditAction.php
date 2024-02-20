<?php

namespace App\Livewire;

use Livewire\Component;

class EditAction extends Component
{
    public function mount(){
        dd('test');
}
    public function render()
    {
        return view('livewire.edit-action');
    }
}
