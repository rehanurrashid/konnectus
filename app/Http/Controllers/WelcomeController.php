<?php 
namespace App\Http\Controllers;
use App\Products;

class WelcomeController extends Controller {
    public function welcome(){
        $products = new Product;
        $data = $products->data();
        return view('welcome',compact('data'));
    }
}