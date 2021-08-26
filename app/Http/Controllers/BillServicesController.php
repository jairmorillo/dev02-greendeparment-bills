<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\BillServices;
use App\Bill;

use DataTables;

class BillServicesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = BillServices::where("bill_id","=",1)->get();      
        $request->user()->authorizeRoles(['admin']);
        return response()->json($data);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BillServices::updateOrCreate(['id' => $request->Item_id],
                ['name' => $request->name,
                 'description' => $request->description,
                 'unit' => $request->unit,
                 'prices' => $request->prices]);        
        return response()->json(['success'=>'Item saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {            
        $data = BillServices::where("bill_id","=",$id)->get();      
        return response()->json($data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
       BillServices::find($id)->delete();     
       return response()->json(['success'=>'Item deleted successfully.']);
    }

    public function show()
    {
        $data = BillServices::latest()->get();
        return response()->json($data);
    }


}
