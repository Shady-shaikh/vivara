<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Validator;
use App\Models\backend\Coupons;
use App\Models\backend\Items;
use App\Models\backend\ProductCarousel;

class ProductCarouselController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {
    $coupons = ProductCarousel::with('get_item')->get();
    // dd($coupons->toArray());
    return view('backend.productcarousel.index', compact('coupons'));
  }

  public function create()
  {
    $items = Items::pluck('name', 'item_id');
    return view('backend.productcarousel.create',compact('items'));
  }

  public function store(Request $request)
  {
    // dd($request->all());
    $this->validate($request, [
      'name' => 'required',
      'image' => 'required',
    ]);

    $coupon = new ProductCarousel;
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('uploads'), $imageName);
    $coupon->image = $imageName;
    $coupon->fill($request->except('image')); 


    if ($coupon->save()) {
      return redirect()->route('admin.productcarousel')->with('success', 'New Product Carousel Item Added!');
    } else {
      return redirect()->route('admin.productcarousel')->with('error', 'Something went wrong!');
    }
  }

  public function destroy($id)
  {
    $coupon = ProductCarousel::findOrFail($id);
    $coupon->delete();
    return redirect()->route('admin.productcarousel')->with('success', 'Carousel Item Deleted!');
  }

  public function edit($id)
  {
    $coupon = ProductCarousel::findOrFail($id);
    $items = Items::pluck('name', 'item_id');
    return view('backend.productcarousel.edit', compact('coupon','items'));
  }




  public function update(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
    ]);
    $coupon = ProductCarousel::findOrFail($request->product_car_id);

    if(!empty($request->image)){
      $imageName = time() . '.' . $request->image->extension();
      $request->image->move(public_path('uploads'), $imageName);
      $coupon->image = $imageName;
      $coupon->fill($request->except('image')); 
    }else{
      $coupon->fill($request->all());
    }





    if ($coupon->save()) {
      return redirect()->route('admin.productcarousel')->with('success', 'Product Carousel Item Updated!');
    } else {
      return redirect()->route('admin.productcarousel')->with('error', 'Something went wrong!');
    }
  }
}
