<?php namespace App\Http\Controllers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class PagesController extends Controller {

    public fonction about(){
      $title ="A propos";
      $numbers =[1,2,3,4,5,6,7,8,9];
      return view('pages/about', compact('title','numbers'));
    }

    public function contact(){
        Mail::
    }
}
