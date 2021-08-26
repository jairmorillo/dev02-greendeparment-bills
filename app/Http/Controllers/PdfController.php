<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Services;
use App\Bill; 
use App\BillServices;
use App\Purchase_request;
use App\Request_item;
use App\Item_request;
use App\Bill_transaccion;  
use App\Bills_part_paid;
use App\Customer;
use DataTables;
use App\Http\Controllers\File;
use Carbon\Carbon;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use DateTime;


class PdfController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    public function invoice($id)
    {
     
        $bill = Bill::where("id","=",$id)->get();
        $billitems = BillServices::where("bill_id","=",$id)->get();
        $billpartial = Bills_part_paid::where("bill_id_p","=",$id)->get();
        // dd($billpartial);
       //  exit;
        $item = Bills_part_paid::find($id);

        ini_set("memory_limit", "-1");
        set_time_limit(0);
        ob_start();
     
      
        $content = view('pdf.invoice')->with('bill', $bill)->with('billitems', $billitems)->with('billpartial', $billpartial);
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
            $html2pdf->pdf->SetTitle('Invoices');               
            $html2pdf->WriteHTML($content);
           // $html2pdf->Output('example.pdf');
           foreach($bill as $item ){
            $html2pdf->Output(''.$item->bill_number.'-'. $item->customer_name.'.pdf');
           }

            ob_flush();
            ob_end_clean();
        }
        catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }



    public function request($id)
    {
     
        $bill = Purchase_request::where("id","=",$id)->get();
        $billitems = Request_item::where("request_id","=",$id)->get();
   
     // dd($bilitems);
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        ob_start();
     
      
        $content = view('pdf.request')->with('bill', $bill)->with('billitems', $billitems);
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
            $html2pdf->pdf->SetTitle('Invoices');
            
            $html2pdf->setTestIsImage(false);
            $html2pdf->setFallbackImage('https://bill.greendepartment.org/image/pagina.png');
            $html2pdf->WriteHTML($content);
            $html2pdf->Output('request.pdf');

            ob_flush();
            ob_end_clean();
        }
        catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item =  Services::updateOrCreate(['id' => $request->Item_id],
                ['name' => $request->name, 'description' => $request->description,'prices' => $request->prices]);        
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
    
    
    public function preview(Request $request)
    {
      $mytime = date('Y-m-d H:i:s');
      $bill = [
            "customer_name" => $_GET ['customer_name'],
            "customer_adress" => $_GET ['customer_adress'],
            "customer_phone" => $_GET ['customer_phone'],
            "customer_email" => $_GET ['customer_email'],
            "customer_type_property" => $_GET ['customer_type_property'],
            "bill_number" => "D0000",
            "bill_description" => $_GET ['bill_description'],
            "bill_total" => $_GET ['bill_totalg'],
            "bill_subtotal" => $_GET ['bill_subtotalg'],
            "bill_iva" => $_GET ['bill_ivag'],
            "bill_discount" => $_GET ['bill_discountg'],          
            "partial_payment_mont" => $_GET ['partial_payment_montg'],
            "partial_payment_rest" => $_GET ['partial_payment_restg'],
            "tasa" => $_GET ['tasa'],
            "discount" => $_GET ['discount'],
            "discount_cash" => $_GET ['discount_cash'],
            "bill_date" => $mytime           
        ];          
        
        $billitems = [ 
            "serv_qty" => $_GET ['serv_qty'],
            "serv_name" => $_GET ['serv_name'],
            "serv_description" => $_GET ['serv_description'],
            "serv_unit" => $_GET ['serv_unit'],
            "serv_price" => $_GET ['serv_price'],
            "serv_total_prices" => $_GET ['serv_total_prices']
        ];
            ini_set("memory_limit", "-1");
            set_time_limit(0);
            ob_start();
        
        
            $content = view('pdf.preview')->with('bill', $bill)->with('billitems', $billitems);
            try {
                    $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
                    $html2pdf->pdf->SetTitle('Invoices');
                    $html2pdf->WriteHTML($content);
                    $html2pdf->Output('example.pdf');
                ob_flush();
                ob_end_clean();
            }
            catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
     

    }


    public function previewresquest(Request $request)
    {

      // $mytime = Carbon::now();
      $mytime = date('Y-m-d H:i:s');
      $bill = [
            "employer_name" => $_GET ['employer_name'],
            "employer_adress" => $_GET ['employer_adress'],
            "employer_phone" => $_GET ['employer_phone'],
            "employer_email" => $_GET ['employer_email'],
            "request_number" => "D0000",
            "request_total" => $_GET ['request_total'],
            "request_subtotal" => $_GET ['request_subtotal'],
            "request_taxes_num" => $_GET ['request_taxes_num'],
            "request_type" => $_GET ['request_type'],
            "request_tax" => $_GET ['request_tax'],
            "request_date" => $mytime 
                     
        ];          
        
        $billitems = [ 
            "request_qty" => $_GET ['request_qty'],
            "request_name" => $_GET ['request_name'],
            "request_description" => $_GET ['request_description'],
            "request_price" => $_GET ['request_price'],
            "request_total_prices" => $_GET ['request_total_prices']
        ];
            ini_set("memory_limit", "-1");
            set_time_limit(0);
            ob_start();
        
            $content = view('pdf.previewrequest',compact("bill","billitems"))->render();
            try {
                $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
                $html2pdf->pdf->SetTitle('Request');
                $html2pdf->WriteHTML($content);
                $html2pdf->Output('example.pdf');

                ob_flush();
                ob_end_clean();
            }
            catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
     

    }


    public function monthprofit()
    {  
        
    

      $year = date("Y");
    if($year%4 == 0 && $year%100 != 0) {
       $leapYear = 1;
        } elseif($year%400 == 0) {
            $leapYear = 1;                          
        } else {
            $leapYear = 0;
        }  

             
    $ene_ini = $year."-01-01";
    $ene_end = $year."-01-31";


    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ene_ini, $ene_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data1 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data1[] = $i;              
        }
    $ene1 = array_sum($data1);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ene_ini, $ene_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data1a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data1a[] = $i;              
        }
    $ene2 = array_sum($data1a);           
    $ene = $ene1 +  $ene2;

    if($leapYear == 1){
        $feb_ini = $year."-02-01";
        $feb_end = $year."-02-29";
    }else{
        $feb_ini = $year."-02-01";
        $feb_end = $year."-02-28";
    }

        
    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$feb_ini, $feb_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data2 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data2[] = $i;              
        }
    $feb1 = array_sum($data2);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$feb_ini, $feb_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data2a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data2a[] = $i;              
        }
    $feb2 = array_sum($data2a);           
    $feb = $feb1 +  $feb2;



    $mar_ini = $year."-03-01";
    $mar_end = $year."-03-31";

    

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$mar_ini, $mar_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data3 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data3[] = $i;              
        }
    $mar1 = array_sum($data3);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$mar_ini, $mar_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data3a = array();        
        foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data3a[] = $i;              
        }
    $mar2 = array_sum($data3a);      
   // dd($mar_end);
  //  exit;
    $mar = $mar1 +  $mar2;



    $abr_ini = $year."-04-01";
    $abr_end = $year."-04-30";

 
    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$abr_ini, $abr_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data4 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data4[] = $i;              
        }
    $abr1 = array_sum($data4);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$abr_ini, $abr_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data4a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data4a[] = $i;              
        }
    $abr2 = array_sum($data4a);           
    $abr = $abr1 +  $abr2;


    $may_ini = $year."-05-01";
    $may_end = $year."-05-31";

  

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$may_ini, $may_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data5 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data5[] = $i;              
        }
    $may1 = array_sum($data5);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$may_ini, $may_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data5a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data5a[] = $i;              
        }
    $may2 = array_sum($data5a);           
    $may = $may1 +  $may2;


    
    $jun_ini = $year."-06-01";
    $jun_end = $year."-06-30";   
   

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jun_ini, $jun_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data6 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data6[] = $i;              
        }
    $jun1 = array_sum($data6);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jun_ini, $jun_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data6a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data6a[] = $i;              
        }
    $jun2 = array_sum($data6a);           
    $jun = $jun1 +  $jun2;


    $jul_ini = $year."-07-01";
    $jul_end = $year."-07-31";
     

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jul_ini, $jul_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data7 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data7[] = $i;              
        }
    $jul1 = array_sum($data7);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jul_ini, $jul_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data7a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data7a[] = $i;              
        }
    $jul2 = array_sum($data7a);           
    $jul = $jul1 + $jul2;
   // $jul = array_sum($c);

    $ago_ini = $year."-08-01";
    $ago_end = $year."-08-31";
   
   $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ago_ini, $ago_end])->where('bill_type_p', '=', 'PAID')->get();
   $b = json_decode( json_encode( $a ), true );
   $union = array_map('serialize', $b); 
   $data8 = array();        
       foreach ($union as $v) {
        $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
            $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
            $c =str_replace('";}',' ',$b );
            $d =str_replace('.','',$c );
            $e =str_replace(',','.',$d );
            $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
            $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
            $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
            $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
            $data8[] = $i;              
       }
   $ago1 = array_sum($data8);

   $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ago_ini, $ago_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
   $b = json_decode( json_encode( $a ), true );
   $union = array_map('serialize', $b); 
   $data8a = array();        
       foreach ($union as $v) {
        $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
            $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
            $c =str_replace('";}',' ',$b );
            $d =str_replace('.','',$c );
            $e =str_replace(',','.',$d );
            $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
            $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
            $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
            $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
            $data8a[] = $i;              
       }
   $ago2 = array_sum($data8a);           
   $ago = $ago1 + $ago2;
   

    $sep_ini = $year."-09-01";
    $sep_end = $year."-09-30";
       
    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$sep_ini, $sep_end])->where('bill_type_p', '=', 'PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data9 = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data9[] = $i;              
        }
    $sep1 = array_sum($data9);

    $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$sep_ini, $sep_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
    $b = json_decode( json_encode( $a ), true );
    $union = array_map('serialize', $b); 
    $data9a = array();        
        foreach ($union as $v) {
         $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
             $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
             $c =str_replace('";}',' ',$b );
             $d =str_replace('.','',$c );
             $e =str_replace(',','.',$d );
             $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
             $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
             $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
             $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
             $data9a[] = $i;              
        }
    $sep2 = array_sum($data9a);           
    $sep = $sep1 + $sep2;

   // $sep = array_sum($c);

    $oct_ini = $year."-10-01";
    $oct_end = $year."-10-31";   


     $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$oct_ini, $oct_end])->where('bill_type_p', '=', 'PAID')->get();
     $b = json_decode( json_encode( $a ), true );
     $union = array_map('serialize', $b); 
     $data10 = array();        
         foreach ($union as $v) {
          $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
              $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
              $c =str_replace('";}',' ',$b );
              $d =str_replace('.','',$c );
              $e =str_replace(',','.',$d );
              $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
              $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
              $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
              $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
              $data10[] = $i;              
         }
     $oct1 = array_sum($data10);

     $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$oct_ini, $oct_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
     $b = json_decode( json_encode( $a ), true );
     $union = array_map('serialize', $b); 
     $data10a = array();        
         foreach ($union as $v) {
          $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
              $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
              $c =str_replace('";}',' ',$b );
              $d =str_replace('.','',$c );
              $e =str_replace(',','.',$d );
              $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
              $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
              $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
              $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
              $data10a[] = $i;              
         }
     $oct2 = array_sum($data10a);           
     $oct = $oct1 + $oct2;

    $nov_ini = $year."-11-01";
    $nov_end = $year."-11-30";

           
     $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$nov_ini, $nov_end])->where('bill_type_p', '=', 'PAID')->get();
     $b = json_decode( json_encode( $a ), true );
     $union = array_map('serialize', $b); 
     $data11 = array();        
         foreach ($union as $v) {
          $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
              $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
              $c =str_replace('";}',' ',$b );
              $d =str_replace('.','',$c );
              $e =str_replace(',','.',$d );
              $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
              $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
              $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
              $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
              $data11[] = $i;              
         }
     $nov1 = array_sum($data11);

     $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$nov_ini, $nov_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
     $b = json_decode( json_encode( $a ), true );
     $union = array_map('serialize', $b); 
     $data11a = array();        
         foreach ($union as $v) {
          $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
              $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
              $c =str_replace('";}',' ',$b );
              $d =str_replace('.','',$c );
              $e =str_replace(',','.',$d );
              $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
              $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
              $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
              $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
              $data11a[] = $i;              
         }
     $nov2 = array_sum($data11a);           
     $nov = $nov1 + $nov2;

    $dic_ini = $year."-12-01";
    $dic_end = $year."-12-31";

          
   
      $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$dic_ini, $dic_end])->where('bill_type_p', '=', 'PAID')->get();
      $b = json_decode( json_encode( $a ), true );
      $union = array_map('serialize', $b); 
      $data12 = array();        
          foreach ($union as $v) {
           $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $data12[] = $i;              
          }
      $dic1 = array_sum($data12);

      $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$dic_ini, $dic_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
      $b = json_decode( json_encode( $a ), true );
      $union = array_map('serialize', $b); 
      $data12a = array();        
          foreach ($union as $v) {
           $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $data12a[] = $i;              
          }
      $dic2 = array_sum($data12a);           
      $dic = $dic1 + $dic2;
        
 
      $mes_actual = date('m');

      if($mes_actual== 1){

       $ano_anterior = date('Y', strtotime('-1 year'));
       $mes_anterior = date('m', strtotime('-1 month'));


       $fecha_ini_last_moth = $ano_anterior.'-'. $mes_anterior.'-01';           
       $fecha_fend_last_moth =$ano_anterior.'-'. $mes_anterior.'-' .date("d",(mktime(0,0,0,$mes_anterior+1,1,$ano_anterior)-1));

       
      }else {

      $fecha_ini_last_moth = new DateTime();
      $fecha_ini_last_moth->modify('first day of last month');

      $fecha_fend_last_moth = new DateTime();
      $fecha_fend_last_moth->modify('last day of last  month');

      }
     // dd($fecha_fend_last_moth);

      
     $fecha_ini_this_moth = date('Y').'-'.date('m').'-01' ;   
     $fecha_fend_this_moth = date('Y').'-'.date('m').'-'.date("d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));


   /*   $fecha_ini_this_moth = new DateTime();
      $fecha_ini_this_moth->modify('first day of this month');

      $fecha_fend_this_moth = new DateTime();
      $fecha_fend_this_moth->modify('last day of this month'); */
     // dd($fecha_ini_this_moth);

      $consulta2 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$fecha_ini_last_moth, $fecha_fend_last_moth])->where('bill_type_p', '=', 'PAID')->get();
     // exit;
    
      $array = json_decode( json_encode( $consulta2 ), true );
      $union = array_map('serialize', $array); 
    //  dd($union);
      $dataant = array();        
          foreach ($union as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $dataant[] = $i;                 
          }
      $mes_ant_t = array_sum($dataant);

    //  dd($union);

      $consulta2p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$fecha_ini_last_moth, $fecha_fend_last_moth])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
      $array1 = json_decode( json_encode( $consulta2p ), true );
      $union1 = array_map('serialize', $array1); 
      $dataantp = array();        
          foreach ($union1 as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $dataantp[] = $i;                 
          }

     $mes_ant_p = array_sum($dataantp);

     $mes_ant = $mes_ant_t + $mes_ant_p;


     
       
     $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$fecha_ini_this_moth, $fecha_fend_this_moth])->where('bill_type_p', '=', 'PAID')->get();
    // dd($consulta1);
     // exit;
      
      $array = json_decode( json_encode( $consulta1 ), true );
      $union = array_map('serialize', $array); 
     // dd($union);
      $dataact = array();        
          foreach ($union as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $dataact[] = $i;              
          }
      $mes_act_t = array_sum($dataact);

      $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$fecha_ini_this_moth, $fecha_fend_this_moth])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
      $array1 = json_decode( json_encode( $consulta1p ), true );
      $union1 = array_map('serialize', $array1); 
      $dataantp = array();        
          foreach ($union1 as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
               $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
               $c =str_replace('";}',' ',$b );
               $d =str_replace('.','',$c );
               $e =str_replace(',','.',$d );
               $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
               $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
               $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
               $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
               $dataantp[] = $i;                 
          }

      $mes_act_p = array_sum($dataantp);  
      $mes_act = $mes_act_t + $mes_act_p;
   //   dd($mes_act);




      //dd($mes_act);

      if($mes_ant==0){

          $procentage_comp = 100;

      }else{

          $procentage_comp =  $mes_act /  $mes_ant * 100;
          $procentage_comp = $procentage_comp - 100;
      }
     

      $comparacion=[
         'actual' =>  $mes_act ,
         'anterior' =>  $mes_ant ,
         'diferencia' =>  $procentage_comp
     ];
       

       
     
       
       $ini = date('Y').'-'.date('m').'-01';

       $end = date('Y').'-'.date('m').'-'.date("d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));


       $paid = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PAID')->count();  
       $anulate = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'ANULATED')->count();
       $partialy = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PARTIALLY-PAID')->count();
       $pending = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PENDING')->count();
       $total = Bill::whereBetween('bill_date', [$ini, $end])->count();  

       $data=[
           'paid'=> $paid ,
           'anulated'=> $anulate ,
           'partially_paid'=> $partialy,
           'pending'=> $pending ,
           'total'=> $total
        ];
   



        $datayear=[
            'enero'=> $ene ,
            'febrero'=> $feb ,
            'marzo'=> $mar,
            'abril'=> $abr,
            'mayo'=> $may,
            'junio'=> $jun,
            'julio'=> $jul,
            'agosto'=> $ago,
            'septiembre'=>  $sep,
            'octubre'=> $oct,
            'noviembre'=> $nov, 
            'diciembre'=> $dic 
          ];
        
             
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        ob_start();
    
        $content = view('pdf.monthprofit')->with('data', $data)->with('comparacion',$comparacion)->with('datayear',$datayear);
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
            $html2pdf->pdf->SetTitle('monthprofit');
            $html2pdf->WriteHTML($content);
            $html2pdf->Output('monthprofit.pdf');

            ob_flush();
            ob_end_clean();
        }
        catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
      // return view('pdf.monthprofit')->render();
       
    }


    public function anualprofit()
    {  
        

        $year = date('Y', strtotime('-1 year'));

        if($year%4 == 0 && $year%100 != 0) {
            $leapYear = 1;
        } elseif($year%400 == 0) {
            $leapYear = 1;                          
        } else {
            $leapYear = 0;
        }
             
        $ene_ini = $year."-01-01";
        $ene_end = $year."-01-31";
 
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ene_ini, $ene_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data1 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data1[] = $i;              
            }
        $ene1 = array_sum($data1);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ene_ini, $ene_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data1a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data1a[] = $i;              
            }
        $ene2 = array_sum($data1a);           
        $ene = $ene1 +  $ene2;
 
 
 
 
        if($leapYear == 1){
            $feb_ini = $year."-02-01";
            $feb_end = $year."-02-29";
        }else{
            $feb_ini = $year."-02-01";
            $feb_end = $year."-02-28";
        }
    
            
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$feb_ini, $feb_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data2 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data2[] = $i;              
            }
        $feb1 = array_sum($data2);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$feb_ini, $feb_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data2a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data2a[] = $i;              
            }
        $feb2 = array_sum($data2a);           
        $feb = $feb1 +  $feb2;
 
        $mar_ini = $year."-03-01";
        $mar_end = $year."-03-31";   
         
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$mar_ini, $mar_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data3 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data3[] = $i;              
            }
        $mar1 = array_sum($data3);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$mar_ini, $mar_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data3a = array();        
            foreach ($union as $v) {
                 $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data3a[] = $i;              
            }
        $mar2 = array_sum($data3a);      
       // dd($mar_end);
      //  exit;
        $mar = $mar1 +  $mar2;
 
        $abr_ini = $year."-04-01";
        $abr_end = $year."-04-30";
         
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$abr_ini, $abr_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data4 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data4[] = $i;              
            }
        $abr1 = array_sum($data4);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$abr_ini, $abr_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data4a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data4a[] = $i;              
            }
        $abr2 = array_sum($data4a);           
        $abr = $abr1 +  $abr2;
    
        $may_ini = $year."-05-01";
        $may_end = $year."-05-31";  
       
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$may_ini, $may_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data5 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data5[] = $i;              
            }
        $may1 = array_sum($data5);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$may_ini, $may_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data5a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data5a[] = $i;              
            }
        $may2 = array_sum($data5a);           
        $may = $may1 +  $may2;  
        
        $jun_ini = $year."-06-01";
        $jun_end = $year."-06-30";          
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jun_ini, $jun_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data6 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data6[] = $i;              
            }
        $jun1 = array_sum($data6);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jun_ini, $jun_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data6a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data6a[] = $i;              
            }
        $jun2 = array_sum($data6a);           
        $jun = $jun1 +  $jun2;
  
        $jul_ini = $year."-07-01";
        $jul_end = $year."-07-31";         
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jul_ini, $jul_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data7 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data7[] = $i;              
            }
        $jul1 = array_sum($data7);
 
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$jul_ini, $jul_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data7a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data7a[] = $i;              
            }
        $jul2 = array_sum($data7a);           
        $jul = $jul1 + $jul2;
       // $jul = array_sum($c);
    
        $ago_ini = $year."-08-01";
        $ago_end = $year."-08-31";
       
       $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ago_ini, $ago_end])->where('bill_type_p', '=', 'PAID')->get();
       $b = json_decode( json_encode( $a ), true );
       $union = array_map('serialize', $b); 
       $data8 = array();        
           foreach ($union as $v) {
            $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                $c =str_replace('";}',' ',$b );
                $d =str_replace('.','',$c );
                $e =str_replace(',','.',$d );
                $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                $data8[] = $i;              
           }
       $ago1 = array_sum($data8);
 
       $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ago_ini, $ago_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
       $b = json_decode( json_encode( $a ), true );
       $union = array_map('serialize', $b); 
       $data8a = array();        
           foreach ($union as $v) {
            $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                $c =str_replace('";}',' ',$b );
                $d =str_replace('.','',$c );
                $e =str_replace(',','.',$d );
                $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                $data8a[] = $i;              
           }
       $ago2 = array_sum($data8a);           
       $ago = $ago1 + $ago2;
       
 
        $sep_ini = $year."-09-01";
        $sep_end = $year."-09-30";
           
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$sep_ini, $sep_end])->where('bill_type_p', '=', 'PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data9 = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data9[] = $i;              
            }
        $sep1 = array_sum($data9);
  
        $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$sep_ini, $sep_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
        $b = json_decode( json_encode( $a ), true );
        $union = array_map('serialize', $b); 
        $data9a = array();        
            foreach ($union as $v) {
             $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                 $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                 $c =str_replace('";}',' ',$b );
                 $d =str_replace('.','',$c );
                 $e =str_replace(',','.',$d );
                 $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                 $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                 $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                 $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                 $data9a[] = $i;              
            }
        $sep2 = array_sum($data9a);           
        $sep = $sep1 + $sep2;
 
       // $sep = array_sum($c);
    
        $oct_ini = $year."-10-01";
        $oct_end = $year."-10-31";   
    
    
         $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$oct_ini, $oct_end])->where('bill_type_p', '=', 'PAID')->get();
         $b = json_decode( json_encode( $a ), true );
         $union = array_map('serialize', $b); 
         $data10 = array();        
             foreach ($union as $v) {
              $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                  $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                  $c =str_replace('";}',' ',$b );
                  $d =str_replace('.','',$c );
                  $e =str_replace(',','.',$d );
                  $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                  $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                  $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                  $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                  $data10[] = $i;              
             }
         $oct1 = array_sum($data10);
   
         $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$oct_ini, $oct_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
         $b = json_decode( json_encode( $a ), true );
         $union = array_map('serialize', $b); 
         $data10a = array();        
             foreach ($union as $v) {
              $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                  $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                  $c =str_replace('";}',' ',$b );
                  $d =str_replace('.','',$c );
                  $e =str_replace(',','.',$d );
                  $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                  $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                  $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                  $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                  $data10a[] = $i;              
             }
         $oct2 = array_sum($data10a);           
         $oct = $oct1 + $oct2;
  
        $nov_ini = $year."-11-01";
        $nov_end = $year."-11-30";
    
               
         $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$nov_ini, $nov_end])->where('bill_type_p', '=', 'PAID')->get();
         $b = json_decode( json_encode( $a ), true );
         $union = array_map('serialize', $b); 
         $data11 = array();        
             foreach ($union as $v) {
              $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                  $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                  $c =str_replace('";}',' ',$b );
                  $d =str_replace('.','',$c );
                  $e =str_replace(',','.',$d );
                  $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                  $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                  $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                  $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                  $data11[] = $i;              
             }
         $nov1 = array_sum($data11);
   
         $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$nov_ini, $nov_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
         $b = json_decode( json_encode( $a ), true );
         $union = array_map('serialize', $b); 
         $data11a = array();        
             foreach ($union as $v) {
              $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                  $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                  $c =str_replace('";}',' ',$b );
                  $d =str_replace('.','',$c );
                  $e =str_replace(',','.',$d );
                  $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                  $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                  $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                  $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                  $data11a[] = $i;              
             }
         $nov2 = array_sum($data11a);           
         $nov = $nov1 + $nov2;
  
        $dic_ini = $year."-12-01";
        $dic_end = $year."-12-31";
    
              
       
          $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$dic_ini, $dic_end])->where('bill_type_p', '=', 'PAID')->get();
          $b = json_decode( json_encode( $a ), true );
          $union = array_map('serialize', $b); 
          $data12 = array();        
              foreach ($union as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                   $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                   $c =str_replace('";}',' ',$b );
                   $d =str_replace('.','',$c );
                   $e =str_replace(',','.',$d );
                   $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                   $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                   $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                   $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                   $data12[] = $i;              
              }
          $dic1 = array_sum($data12);
    
          $a = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$dic_ini, $dic_end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
          $b = json_decode( json_encode( $a ), true );
          $union = array_map('serialize', $b); 
          $data12a = array();        
              foreach ($union as $v) {
               $a =str_replace('a:1:{s:20:"partial_payment_mont";s:9:"',' ',$v );
                   $b =str_replace('a:1:{s:20:"partial_payment_mont";s:8:"',' ',$a );
                   $c =str_replace('";}',' ',$b );
                   $d =str_replace('.','',$c );
                   $e =str_replace(',','.',$d );
                   $f =str_replace('a:1:{s:20:"partial_payment_mont";s:6:"','',$e );
                   $g =str_replace('a:1:{s:20:"partial_payment_mont";s:5:"','',$f );
                   $h =str_replace('a:1:{s:20:"partial_payment_mont";s:4:"','',$g );
                   $i =str_replace('a:1:{s:20:"partial_payment_mont";s:10:"','',$h );
                   $data12a[] = $i;              
              }
          $dic2 = array_sum($data12a);           
          $dic = $dic1 + $dic2;

     $datayear=[
       'enero'=> $ene ,
       'febrero'=> $feb ,
       'marzo'=> $mar,
       'abril'=> $abr,
       'mayo'=> $may,
       'junio'=> $jun,
       'julio'=> $jul,
       'agosto'=> $ago,
       'septiembre'=>  $sep,
       'octubre'=> $oct,
       'noviembre'=> $nov, 
       'diciembre'=> $dic 
     ];

    $ano_anterior = date('Y', strtotime('-1 year'));

    $ini = $ano_anterior.'-01-01' ;
    $end = $ano_anterior.'-12-31';

        
    $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PAID')->get();
    $array = json_decode( json_encode( $data ), true );      
    $union = array_map('serialize', $array); 
    $data33 = array();        
        foreach ($union as $v) {
            $a =str_replace('a:1:{s:10:"bill_total";s:9:"',' ',$v );
            $b =str_replace('a:1:{s:10:"bill_total";s:8:"',' ',$a );
            $c =str_replace('";}',' ',$b );
            $d =str_replace('.','',$c );
            $e =str_replace(',','.',$d );
            $f =str_replace('a:1:{s:10:"bill_total";s:6:"','',$e );
            $g =str_replace('a:1:{s:10:"bill_total";s:5:"','',$f );
            $h =str_replace('a:1:{s:10:"bill_total";s:4:"','',$g );
            $data33[] = $h;
        }


        $sumtotal =  array_sum($data33);



     $ano_previo = date('Y', strtotime('-2 year'));

    $ini = $ano_previo.'-01-01' ;
    $end = $ano_previo.'-12-31';

        
    $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PAID')->get();
    $array = json_decode( json_encode( $data ), true );      
    $union = array_map('serialize', $array); 
    $data39 = array();        
        foreach ($union as $v) {
            $a =str_replace('a:1:{s:10:"bill_total";s:9:"',' ',$v );
            $b =str_replace('a:1:{s:10:"bill_total";s:8:"',' ',$a );
            $c =str_replace('";}',' ',$b );
            $d =str_replace('.','',$c );
            $e =str_replace(',','.',$d );
            $f =str_replace('a:1:{s:10:"bill_total";s:6:"','',$e );
            $g =str_replace('a:1:{s:10:"bill_total";s:5:"','',$f );
            $h =str_replace('a:1:{s:10:"bill_total";s:4:"','',$g );
            $data39[] = $h;
        }


        $sumtotal2 = array_sum($data39);


            if($sumtotal2 == 0){

                $procentage_comp = 100.00;
    
            }else{
    
                $procentage_comp =  $sumtotal /  $sumtotal2 * 100;
                $procentage_comp = $procentage_comp - 100;
            }
           
    
            $comparacion=[
               'anterior' => $sumtotal ,
               'ano1'=> $ano_anterior,
               'previo' =>  $sumtotal2 ,
               'ano2'=>$ano_previo,
               'diferencia' =>  $procentage_comp
           ];           



     $ano_anterior1 = date('Y', strtotime('-1 year'));

    $ini = $ano_anterior1.'-01-01' ;
    $end = $ano_anterior1.'-12-31';

       $paid = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PAID')->count();  
       $anulate = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'ANULATED')->count();
       $partialy = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PARTIALLY-PAID')->count();
       $pending = Bill::whereBetween('bill_date', [$ini, $end])->where('bill_type', '=', 'PENDING')->count();
       $total = Bill::whereBetween('bill_date', [$ini, $end])->count();  

       $data=[
           'paid'=> $paid ,
           'anulated'=> $anulate ,
           'partially_paid'=> $partialy,
           'pending'=> $pending ,
           'total'=> $total
        ];   
             

        ini_set("memory_limit", "-1");
        set_time_limit(0);
        ob_start();
    
        $content = view('pdf.anualprofit')->with('data', $data)->with('datayear',$datayear)->with('comparacion',$comparacion);
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(15, 10, 15, 10));
            $html2pdf->pdf->SetTitle('anualprofit');
            $html2pdf->WriteHTML($content);
            $html2pdf->Output('anualprofit.pdf');

            ob_flush();
            ob_end_clean();
        }
        catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
      // return view('pdf.monthprofit')->render();
       
    }


}