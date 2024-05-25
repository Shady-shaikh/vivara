<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Items;
use App\Models\backend\Warehouses;
use Exception;
use Webleit\ZohoBooksApi\Modules\Organizations;
use Webleit\ZohoBooksApi\ZohoBooks;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class WarehouseController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

    // $client = get_zoho_client();
    // $items = Items::get();
    $items = Warehouses::get();
    // dd($items);
    return view('backend.warehouse.index', compact('items'));
  }

  public function show($item_id)
  {

    $item = Items::where('item_id',$item_id)->with('warehouses')->first();
    // dd($item->toArray());
    return view('backend.warehouse.show', compact('item'));
  }

  

}
