<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\backend\CategoryCarousel;
use DB;
use Session;
use Validator;
use App\Models\backend\Coupons;
use App\Models\backend\Items;
use App\Models\backend\ProductCarousel;

class CategoryCarouselController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {
    $coupons = CategoryCarousel::get();
    // dd($coupons);
    return view('backend.categorycarouse.index', compact('coupons'));
  }

  public function create()
  {
    $categories = Items::distinct()->pluck('category');
    return view('backend.categorycarouse.create',compact('categories'));
  }

  public function store(Request $request)
  {
    // dd($request->all());
    $this->validate($request, [
      'name' => 'required',
      'image' => 'required',
    ]);

    $coupon = new CategoryCarousel;
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('uploads'), $imageName);
    $coupon->image = $imageName;
    $coupon->fill($request->except('image')); 


    if ($coupon->save()) {
      return redirect()->route('admin.categorycarouse')->with('success', 'New Category Carousel Item Added!');
    } else {
      return redirect()->route('admin.categorycarouse')->with('error', 'Something went wrong!');
    }
  }

  public function destroy($id)
  {
    $coupon = CategoryCarousel::findOrFail($id);
    $coupon->delete();
    return redirect()->route('admin.categorycarouse')->with('success', 'Carousel Item Deleted!');
  }

  public function edit($id)
  {
    $coupon = CategoryCarousel::findOrFail($id);
    $categories = Items::distinct()->pluck('category','category');

    return view('backend.categorycarouse.edit', compact('coupon','categories'));
  }




  public function update(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
    ]);
    $coupon = CategoryCarousel::findOrFail($request->product_car_id);

    if(!empty($request->image)){
      $imageName = time() . '.' . $request->image->extension();
      $request->image->move(public_path('uploads'), $imageName);
      $coupon->image = $imageName;
      $coupon->fill($request->except('image')); 
    }else{
      $coupon->fill($request->all());
    }





    if ($coupon->save()) {
      return redirect()->route('admin.categorycarouse')->with('success', 'Category Carousel Item Updated!');
    } else {
      return redirect()->route('admin.categorycarouse')->with('error', 'Something went wrong!');
    }
  }
}
