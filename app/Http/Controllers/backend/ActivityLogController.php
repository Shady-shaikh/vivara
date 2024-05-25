<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\backend\Company;
use App\Models\backend\Category;
use App\Models\backend\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $activity_log = ActivityLog::orderBy('activity_log_id', 'DESC')->get();
        return view('backend.activity_log.index', compact('activity_log'));
    }
    public function create()
    {
        return view('backend.category.create_category');
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);
        $category = new Category();
        $category->fill($request->all());
        if ($category->save()) {
            return redirect()->route('admin.category')->with('success', 'Category Created Successfully!');
        } else {
            return redirect()->route('admin.category')->with('error', 'Failed to Create Category!');
        }
    }
    public function edit($id)
    {
        $category = Category::where('category_id', $id)->first();
        return view('backend.category.edit_category', compact('category'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);
        $data = Category::where('category_id', $request->category_id)->get();
        if (count($data) > 0) {
            $category = Category::where('category_id', $request->category_id)->first();

            $category->fill($request->all());
            if ($category->save()) {
                return redirect('/admin/category')->with('success', 'Category Has Been Updated');
            } else {
                return redirect('/admin/category/edit')->with('error', 'Failed to update Category');
            }
        }
    }
    public function destroy($id)
    {
        $category = Category::where('category_id', $id)->get();
        if (count($category) > 0) {
            if (Category::where('category_id', $id)->delete()) {
                return redirect('/admin/category')->with('success', 'Category Has Been Deleted');
            }
        }
    }
}
