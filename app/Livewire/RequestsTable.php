<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;

class RequestsTable extends Component
{
    use WithPagination;
    public $size = 20;
    public $currentPage = 1;
    public $totalPages = 1;
    public $requests = [];

    public function mount()
    {
        $this->goToPage($this->currentPage);
    }
    public function fetchRequests()
    {
        $http = new Client();

        //$this->size = request()->query('size',20); // Get the current page from query string, default is 1

        $response = $http->get('http://localhost:8000/api/requests?size=' . $this->size . '&page=' . $this->currentPage);
        // convert response to LengthAwarePaginator


        $data = json_decode($response->getBody(), true);

        $this->requests = $data['data'];

        // Calculate the total number of pages
        $this->totalPages = $data['last_page'];
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;


        $this->fetchRequests();
    }

    public function changeSize($size)
    {
       $this->size = $size;


        $this->fetchRequests();
    }

    public function delete($id)
    {

        $apiUrl = 'http://localhost:8000/api/requests/' . $id;
        //dd($apiUrl);

        $http= New Client();


        $http->delete($apiUrl);

        $this->redirect('/');

    }



    public function render()
    {
        return view('livewire.requests-table', [
            'requests' => $this->requests,
            //'size'=> $this->size,
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
        ]);
    }
}
