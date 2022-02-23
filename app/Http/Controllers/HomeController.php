<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\RequestTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class HomeController extends Controller
{

    private RequestTypeRepositoryInterface $requestTypeRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(RequestTypeRepositoryInterface $requestTypeRepository, UserRepositoryInterface $userRepository){
        $this->requestTypeRepository = $requestTypeRepository;
        $this->userRepository = $userRepository;
    }

    public function index(){
        $site="https://tibbotu.com/domain/";
        $kr=file_get_contents($site);

        $KrJson=json_decode($kr,true);
        $domain_number = $KrJson['current'];

        if(session()->has('loggedInUser')){
            $request_types = $this->requestTypeRepository->get();
            $user = $this->userRepository->getByUserName(session('loggedInUser'));
            return view('front.home', ['domain_number' => $domain_number, 'request_types' => $request_types, 'user' => $user]);
        }
        else{
            return view('front.home', ['domain_number' => $domain_number]);
        }
        
    }
}
