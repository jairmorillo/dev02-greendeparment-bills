<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function __construct()
    {
       // $this->middleware('auth');
    }


    public function index(Request $request)
    {        
       // $request->user()->authorizeRoles(['admin']);
        return 'Usted no tiene nada que hacer aqui Chu Chu Chu ..... : P';
    }

    public function estimate_part_one(Request $request) {
        
      $data = $_POST ;
      dd($data);
    }

    public function estimate_part_two(Request $request) {
        $data = $_POST;
        dd($data);
      }

}
