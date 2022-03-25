<?php

namespace App\Http\Controllers;
use App\Interfaces\RequestRepositoryInterface;

use Illuminate\Http\Request;

class HomeReguestController extends Controller
{
    private RequestRepositoryInterface $requestRepository;

    public function __construct(
        RequestRepositoryInterface $requestRepository

    ){
        $this->requestRepository = $requestRepository;
    }

    public function updatedHomeRequests(){
        $requests = $this->requestRepository->getNew();
        return view('front.components.user-table-content-component', ['user' => $requests]);
    }
}
