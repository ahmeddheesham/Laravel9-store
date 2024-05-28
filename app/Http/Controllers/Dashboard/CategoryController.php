<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\CategoryDeleteRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainCategories = Category::where('parent_id', 0)->orWhere('parent_id', null)->get();
        $categories = Category::paginate(10);
        return view('dashboard.categories.index', compact('mainCategories', 'categories'));
    }

    
    public function getall() 
    {
        $query = Category::select('*')->with('parent');
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            return $btn = '
            <a 
            href="'.Route('dashboard.categories.edit', $row->id) .'"  
            class="edit btn btn-success btn-sm "> 
            <i class="fa fa-edit"></i> 
            </a>
            
            <button 
            type="button" 
            id="deleteBtn" 
            data_id="'. $row->id .'"  
            class= "btn btn-danger mt-md-0 mt-2"  
            data-bs-toggle="modal"
            data-original-title="test"
            data-bs-target="#deletemodal"> 
            <i class = "fa fa-tarsh"></i> 
            </button>' ;
        })

        ->addcolumn('parent', function($row) {
            return($row->parent == 0 ) ? 'قسم رئيسي'  : $row->parents->name;
        })

        ->addcolumn('image', function($row) {
            return '<img src="' .asset($row->image) . '"  width="100px"  height="100px"  >';
        })

        ->rawColumns(['parent', 'action', 'image'])
        ->make(true);
    }
        
            
   

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create(){
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(CategoryDeleteRequest $request)
    {
        Category::whereId($request->id)->delete();
        return redirect()->route('dashboard.categories.index');
    }
}
