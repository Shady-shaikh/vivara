<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\backend\Items;
use App\Models\backend\Schemes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ApplyoffersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $model = Items::where('offer', '!=', null)->with('get_offers')->get();
        // dd($model);

        return view('backend.offers.index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = Items::pluck('name', 'item_id');
        $offers = Schemes::pluck('scheme_title', 'schemes_id');
        return view('backend.offers.create', compact('items', 'offers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'item_id' => 'required',
            'schemes_id' => 'required',
        ]);
        $model = Items::where('item_id', $request->item_id)->first();
        $model->offer = $request->schemes_id;
        $model->save();

        Session::flash('success', 'Offer applied successfully!');
        Session::flash('status', 'success');

        return redirect('admin/offers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $schemes = Schemes::findOrFail($id);

        return view('backend.offers.show', compact('schemes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $model = Items::where('item_id', $id)->first();

        // dd($model);

        $items = Items::pluck('name', 'item_id');
        $offers = Schemes::pluck('scheme_title', 'schemes_id');
        return view('backend.offers.edit', compact('model', 'items', 'offers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'item_id' => 'required',
            'schemes_id' => 'required',
        ]);

        // dd($request->all());
        $model = Items::where('item_id', $request->id)->first();
        $model->offer = null;
        if($model->save()){
        $data = Items::where('item_id', $request->item_id)->first();
        $data->offer = $request->schemes_id;
        $data->save();
        }


        Session::flash('success', 'Offer updated Successfylly!');
        Session::flash('status', 'success');

        return redirect('admin/offers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $model = Items::where('item_id', $id)->first();
        $model->offer = null;
        $model->save();

        Session::flash('success', 'Offer deleted!');
        Session::flash('status', 'success');

        return redirect('admin/offers');
    }
}
