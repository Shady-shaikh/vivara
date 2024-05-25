<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\backend\Cmspages;
use App\Models\backend\Faqs;
use App\Models\frontend\User;
use Illuminate\Support\Facades\Auth;
use App\Models\backend\FrontendImages;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use App\Models\backend\LoginManagement;
use App\Models\frontend\Cart;

use Session;
use Redirect;
use PHPMailer\PHPMailer;
use DB;
use Hash;

class GuestController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    public function movetocart(){
        if(!auth()->user())
      {
          //not logged in go back
         return redirect('/login');
      }
      if(session()->has('cart') && count(session('cart'))< 1){
        return redirect('/');
      }
      //fetch userid
      $user_id = auth()->user()->id;
      $uid = ['user_id' => $user_id];
      echo "user id is".$user_id;
    //   user cart
      $cart = Cart::where('user_id',$user_id)->with(['products','product_images','product_variant'])->get();

      //check cart already empty then directly move ithem to the cart
      if(count($cart) ==0 ){
          $i=0;
          foreach(session('cart') as $name => $item)
          {
            $qty = ['qty' => $item['quantity']];
            $data = array_merge($uid,$item,$qty);
            $cartobj = new Cart;
            $cartobj->fill($data);
            $cartobj->save();
            $i++;
          }
          if($i== count(session('cart'))){
              session()->forget('cart');
          }
          return redirect()->to('/')->with('success','Login Successfully');

      } //user cart already empty move data directly in the cart function end

      //foreach loop to insert data in cart
      foreach (session('cart') as $name => $item) {
// print_r($name);
// echo $item['product_id'];
        $previous = Cart::where('user_id', $user_id)->where('product_id','=', $item['product_id'])->get();
        $previous_data = $previous->toArray();
        if(count($previous_data) == 0){
            $qty = ['qty' => $item['quantity']];
            $data = array_merge($uid,$item,$qty);
            $cartobj = new Cart;
            $cartobj -> fill($data);
            $cartobj -> save();
        }
        else if( count($previous_data) > 0 ){
            foreach($previous_data as $key => $value){}
            if(($value['product_id'] == $item['product_id']) && ($value['product_variant_id'] == $item['product_variant_id']) &&  ($value['product_type'] == $item['product_type']) ){
                $quantity =['qty' => $value['qty']+$item['quantity']] ;
                $cart_id = ['id'=> $value['id']];
                $data = array_merge($uid,$cart_id,$item,$quantity);
                $cartobj = Cart::find($value['id']);
                $cartobj -> fill($data);
                $cartobj -> save();
            }else{
                $quantity =['qty' => $item['quantity']] ;
                $data = array_merge($uid,$item,$quantity);
                $cartobj = new Cart;
                $cartobj -> fill($data);
                $cartobj -> save();

            }
        }

      } //end of foreeach
      session()->forget('cart');
      return redirect()->to('/')->with('success','Login Successfully');
    } //end of move to cart function










} // End of Class
