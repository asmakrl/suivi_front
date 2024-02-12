<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;

class RequestsTable extends Component
{
    use WithPagination;
    public $requests;


    public function mount()
    {
        $this->fetchRequests();
    }

    public function fetchRequests()
    {
        $http = new Client();

        $response = $http->get('http://localhost:8000/api/requests', [
            'page' => $this->paginators,
        ]);
        //dd($response);
        //$this->requests = response()->json($response);
        $this->requests = json_decode($response->getBody(), true);

    }

    public function render()
    {
        return view('livewire.requests-table');

    }
}
