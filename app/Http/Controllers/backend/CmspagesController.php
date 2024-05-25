<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\backend\Cmspages;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class CmspagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cmspages = Cmspages::all();

        return view('backend.cmspages.index', compact('cmspages'));
    }

    public function create()
    {
      return view('backend.cmspages.create');
        // exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'cms_pages_title' => ['required',],
          'column_type' => ['required',],
        ]);
        // echo "string";exit;
        // dd($request->all());
        $cmspage = new Cmspages();
        $cmspage->fill($request->all());

        if ($cmspage->save())
        {
          return redirect()->route('admin.cmspages')->with('success', 'New CMS Page Added!');
        }
        else
        {
          return redirect()->route('admin.cmspages')->with('error', 'Something went wrong!');
        }
    }

    public function edit($id)
    {
        $cmspage = Cmspages::findOrFail($id);

        return view('backend.cmspages.edit', compact('cmspage'));
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
          'cms_pages_title' => 'required',
          'column_type' => ['required',],
      ]);
      $id = $request->cms_pages_id ;
      $cmspages = Cmspages::findOrFail($id);
      $cmspages->cms_slug = null;
      $cmspages->update($request->all());

      Session::flash('message', 'Cmspage Updated!');
      Session::flash('status', 'success');

      return redirect('admin/cmspages');
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
        $cmspages = Cmspages::findOrFail($id);
        $cmspages->delete();
        return redirect()->route('admin.cmspages')->with('success', 'CMS page Deleted!');
    }
}
