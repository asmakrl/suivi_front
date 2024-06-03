<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;
use function Laravel\Prompts\error;

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
    public $SearchKey = '';
    public $totalItems;
    public function mount()
    {
       // $this->goToPage($this->currentPage);
      //  $this->getStatus();
    }
    public function fetchRequests()
    {
        $http = new Client();

        // Fetch the requests from the API with pagination parameters
        $response = $http->get('http://localhost:8000/api/requests', [
            'query' => [
                'size' => $this->size,
                'page' => $this->currentPage,
            ],
        ]);

        // Decode the response
        $data = json_decode($response->getBody(), true);

        // Check if the response contains the necessary data
        if (isset($data['data']) && is_array($data['data'])) {
            // Assign the requests data to the property
            $this->requests = $data['data'];
            // Assign pagination data
            $this->totalPages = $data['last_page'];
            $this->totalItems = $data['total'];
        } else {
            // Handle error or unexpected response structure
            $this->requests = [];
            $this->totalPages = 0;
            $this->totalItems = 0;
        }

        // Indicate that loading is complete
        $this->isLoading = false;
    }


    public function search()
    {
        $http = new Client();

        //$this->size = request()->query('size',20); // Get the current page from query string, default is 1
        if (!empty($this->SearchKey)) {

            $response = $http->get('http://localhost:8000/api/requests/search/'.$this->SearchKey);
        // convert response to LengthAwarePaginator


        $data = json_decode($response->getBody(), true);


        $this->requests = $data['data'];
        // Calculate the total number of pages
        $this->totalPages = $data['last_page'];

        $this->isLoading=False;
    }
    }


    public function goToPage($page)
    {
        $this->currentPage = $page;


        $this->fetchRequests();

    }
    public function nextPage()
    {
        if ($this->currentPage < $this->totalPages) {
            $this->currentPage++;
            $this->fetchRequests();
        }
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->fetchRequests();
        }
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

    public function goToaddrRequest(){
        //dd('test');
        $this->redirect('/addrequest');
    }
    public function goToEditRequest($item){
        //dd('test');

        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/editrequest');
    }

    public function goToAddAction($item){
        //dd('test');

        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/addactions');
    }

    public function goToShowRequest($item){
        //dd('test');

        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/showrequests');
    }

    public function goToAddResponse($item){
        //dd('test');

        $temp = $this->findRequestById($item);
        session()->put('dataToPass', $temp);

        $this->redirect('/addresponses');
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
    public function updated($name,$value){
        error_log($name);
        error_log($value);
        if($name=='SearchKey' && $value==''){
            $this->fetchRequests();
        }

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
