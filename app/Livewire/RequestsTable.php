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
    public $typeData = [];
    public $isStatusDialogOpen = false;
    public $selectedRequestId;
    public $statuses = [];
    public $isLoading=True;
    public $selectedStatusId=1;

    public function mount()
    {
       // $this->goToPage($this->currentPage);
      //  $this->getStatus();
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
        $this->isLoading=False;
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
       // dd($apiUrl);

        $http= New Client();


        $http->delete($apiUrl);

        $this->redirect('/');

    }

    public function goToLink(){
        //dd('test');
        $this->redirect('/addrequest');
    }
    public function goToLink2($item){
        //dd('test');

        //win rah l item ?ama? ok ok
        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/editrequest');
    }

    public function goToLink3($item){
        //dd('test');

        //win rah l item ?ama? ok ok
        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/addactions');
    }

    public function goToLink4($item){
        //dd('test');

        //win rah l item ?ama? ok ok
        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/showrequests');
    }

    public function openStatusDialog($requestId)
    {
        $this->selectedRequestId = $requestId;
        $http = new Client();

        $response = $http->get('http://localhost:8000/api/statuses');

        // Check if the request was successful (status code 2xx)

        // Get the response body as an array
        $data = json_decode($response->getBody(), true);

        // Check if the decoding was successful

        $this->statuses = $data;
        $this->isStatusDialogOpen = true;
    }

    public function closeStatusDialog()
    {
        $this->isStatusDialogOpen = false;
    }

    public function changeStatus()
    {
        $http = new Client();
        $response = $http->get('http://localhost:8000/api/requests/'.$this->selectedRequestId.'/statuses/'.$this->selectedStatusId);
        foreach ($this->requests as &$request) {
            if ($request['id'] == $this->selectedRequestId) {
                $request['last_status'] = $this->getStatusName($this->selectedStatusId);
                break;
            }
        }
        $this->closeStatusDialog();

    }
    public function getStatusName($statusId)
    {
        $http = new Client();
        $response = $http->get('http://localhost:8000/api/statuses/'.$statusId);

        $data = json_decode($response->getBody(), true);

        return $data['status'];
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
    public function findRequestById($id)
    {
        foreach ($this->requests as $request) {
            if ($request['id'] == $id) {
                return $request;
            }
        }
    }
}
