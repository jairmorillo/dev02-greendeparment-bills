<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

//Models
use App\PaymentTransaction;
use App\Bill;
use DataTables;

class PaymentTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = PaymentTransaction::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="/transaction/'.$row->id.'/edit" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-paint-brush"></i></a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-window-close" aria-hidden="true"></i></a>';
                           $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Pay Link" class="enlace btn btn-primary btn-sm editItem"><i class="fa fa-link"></i></a>';

                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }               
        $request->user()->authorizeRoles(['admin']);

        return view('paid.list');
    }

    public function create()
    {
        $bill  = Bill::latest()->get();
        return view('paid.create')->with('bill', $bill);
    }

    /**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $request->validate([
            'amount' => 'required',
            'payment_bill_id' => 'required',
            'payment_bill_code' => 'required',
            'payment_bill_customer' => 'required',
            'payment_bill_description' => 'required',
            'payment_bill_total' => 'required',
            'payment_partial_payment_mont' => 'required',
            'payment_partial_payment_rest' => 'required',
            'payment_transaction_status' => 'required',

            'payment_response_code' => 'nullable',
            'payment_transaction_id' => 'nullable',
            'payment_auth_id' => 'nullable',
            'payment_message_code' => 'nullable',
            'payment_name_on_card' => 'nullable',
            'payment_token' => 'nullable',
            'payment_quantity' => 'nullable',
           ]);
        
           $check = PaymentTransaction::updateOrCreate( 
            ['id' => $_POST['idt']],
            ['amount' => $data['amount'],
            'payment_bill_id' => $data['payment_bill_id'],
            'payment_bill_code' => $data['payment_bill_code'],
            'payment_bill_customer' => $data['payment_bill_customer'],
            'payment_bill_description' => $data['payment_bill_description'],
            'payment_bill_total' => $data['payment_bill_total'],
            'payment_partial_payment_mont' => $data['payment_partial_payment_mont'],
            'payment_partial_payment_rest' => $data['payment_partial_payment_rest'],
            'payment_transaction_status' => $data['payment_transaction_status'],
            'payment_token' => Crypt::encrypt($data['payment_bill_id']),
         ]);

       // return back()->with('success', 'Transaction created successfully.');
       // return response()->json($check);
       return redirect()->route('transaction.index')->with('success','Link Generated Successfully');

    }

  /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = PaymentTransaction::find($id);
       // dd($item);
      //   $bill  = Bill::latest()->get();
        return view('paid.edit')->with('id',$id);
       // return response()->json($item);
    }

    
    public function show($id)
    {
        $item = PaymentTransaction::find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
            
       $update = PaymentTransaction::find();
       $update->amount = $request->amount;
       $update->save();

        return redirect()->route('transaction.index')
            ->with('success','Product updated successfully');
    }




    public function destroy($id)
    {
        PaymentTransaction::find($id)->delete();     
       return response()->json(['success'=>'Item deleted successfully.']);
    }


}
