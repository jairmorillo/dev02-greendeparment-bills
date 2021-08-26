<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Services;

use DataTables;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Services::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-paint-brush"></i></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-window-close" aria-hidden="true"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }               
        $request->user()->authorizeRoles(['admin']);
        return view('services.services');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item =  Services::updateOrCreate(
            ['id' => $request->Item_id],
                ['name' => $request->name, 
                'description' => $request->description,
                'unit' => $request->unit,
                'prices' => $request->prices]);        
        return  response()->json($item);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Services::find($id);
        return response()->json($item);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Services::find($id)->delete();     
       return response()->json(['success'=>'Item deleted successfully.']);
    }
   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        $data = Services::latest()->get();
        return response()->json($data);
    }


    public function search(Request $request)
    {
        
     $search = $request->search;

        if($search == ''){
           $customer = Services::orderby('description','asc')->limit(10)->get();
        }else{
           $customer = Services::orderby('description','asc')->where('description', 'like', '%' .$search . '%')->limit(10)->get();
        }
    return response()->json($customer);


    }

}
