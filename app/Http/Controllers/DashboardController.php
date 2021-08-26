<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Services;
use App\Bill; 
use App\BillServices;
use App\Bill_transaccion;  
use App\Bills_part_paid;
use App\Customer;
use DateTime;
use DataTables;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
           //GANANCIAS POR MES EN EL ANO EN CURSO


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
         //  dd($fecha_ini_last_moth);
         //  exit;


         $fecha_ini_this_moth = date('Y').'-'.date('m').'-01' ;   
         $fecha_fend_this_moth = date('Y').'-'.date('m').'-'.date("d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));

           

       /*    $fecha_ini_this_moth = new DateTime();
           $fecha_ini_this_moth->modify('first day of this month');
   
           $fecha_fend_this_moth = new DateTime();
           $fecha_fend_this_moth->modify('last day of this month'); */

          // dd($fecha_fend_this_moth);
          // exit;

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
         //  dd($consulta1p);
         //   exit;



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
      //  dd($comparacion);


     // dd($comparacion);
      //exit;

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
            
        $data=[
            $ene ,
            $feb ,
            $mar,
            $abr,
            $may,
            $jun,
            $jul,
            $ago,
            $sep,
            $oct,
            $nov, 
            $dic 
        ];

      //GANANCIAS POR MES DEL ANO PASADO

  $lastyear = date("Y") - 1;

      if($lastyear%4 == 0 && $lastyear%100 != 0) {
          $leapYear = 1;
      } elseif($lastyear%400 == 0) {
          $leapYear = 1;                          
      } else {
          $leapYear = 0;
      }
 
      $ene_ini = $lastyear."-01-01";
      $ene_end = $lastyear."-01-31";


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
      $enex = $ene1 +  $ene2;


      if($leapYear == 1){
          $feb_ini = $lastyear."-02-01";
          $feb_end = $lastyear."-02-29";
      }else{
          $feb_ini = $lastyear."-02-01";
          $feb_end = $lastyear."-02-28";
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
      $febx = $feb1 +  $feb2;



      $mar_ini = $lastyear."-03-01";
      $mar_end = $lastyear."-03-31";
  
      

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
               $data2a[] = $i;              
          }
      $mar2 = array_sum($data3a);           
      $marx = $mar1 +  $mar2;



      $abr_ini = $lastyear."-04-01";
      $abr_end = $lastyear."-04-30";
  
   
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
      $abrx = $abr1 +  $abr2;


      $may_ini = $lastyear."-05-01";
      $may_end = $lastyear."-05-31";
  
    

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
      $mayx = $may1 +  $may2;


      
      $jun_ini = $lastyear."-06-01";
      $jun_end = $lastyear."-06-30";   
     

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
      $junx = $jun1 +  $jun2;


      $jul_ini = $lastyear."-07-01";
      $jul_end = $lastyear."-07-31";
       

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
      $julx = $jul1 + $jul2;
     // $jul = array_sum($c);
  
      $ago_ini = $lastyear."-08-01";
      $ago_end = $lastyear."-08-31";
     
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
     $agox = $ago1 + $ago2;
     

      $sep_ini = $lastyear."-09-01";
      $sep_end = $lastyear."-09-30";
         
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
      $sepx = $sep1 + $sep2;

     // $sep = array_sum($c);
  
      $oct_ini = $lastyear."-10-01";
      $oct_end = $lastyear."-10-31";   
  
  
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
       $octx = $oct1 + $oct2;

      $nov_ini = $lastyear."-11-01";
      $nov_end = $lastyear."-11-30";
  
             
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
       $novx = $nov1 + $nov2;

      $dic_ini = $lastyear."-12-01";
      $dic_end = $lastyear."-12-31";
                  
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
        $dicx = $dic1 + $dic2;


    $datax=[
        $enex,
        $febx,
        $marx,
        $abrx,
        $mayx,
        $junx,
        $julx,
        $agox,
        $sepx,
        $octx,
        $novx, 
        $dicx 
    ];
       $request->user()->authorizeRoles(['admin']);      
        return view('dashboard')->with('data', $data)->with('datax',$datax)->with('comparacion',$comparacion);
    }

    

    public function Profile()
    {

        $usu = auth()->id();

        $item =  DB::table('users')
        ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=','role_user.id') 
        ->where('role_user.user_id','=', $usu)   
        ->select('users.name', 'users.email','users.password', 'roles.description', 'role_user.role_id','role_user.user_id')
        ->get();    
        
        return view('profiles')->with('item', $item);
    }

    public function customercount()
    {       
        $data = Customer::count();
        return response()->json($data);
    }


    public function billscount()
    {       

        $ini = new DateTime();
        $ini->modify('first day of this month');

        $fin = new DateTime();
        $fin->modify('last day of this month');

        $data = Bill::where('bill_type', '=', 'PAID')->whereBetween('bill_date', [$ini, $fin])->count();
        return response()->json($data);
    }


    public function profit()
    {
        //  FACTURAS PAGAS DESDE ARRANQUE DE LA APP
        $data = Bill::select('bill_total')->where('bill_type', '=', 'PAID')->get();
        return response()->json($data);
    }


    public function profitmonth()
    {

        // FACTURAS PAGAS ESTE MES

        $ini = new DateTime();
        $ini->modify('first day of this month');

        $fin = new DateTime();
        $fin->modify('last day of this month');                  
            
        $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PAID')->get();
         //dd($consulta1);
         //exit;
          
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

          $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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


       // $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $fin])->where('bill_type', '=', 'PAID')->get();

        return response()->json($mes_act);
    }


    public function profityear()
    {

        // GANANCIAS ESTE ANO
        $year = date("Y");      
        $ini = $year."-01-01";
        $fin = $year."-12-31";


        $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PAID')->get();
        //dd($consulta1);
        //exit;
         
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

         $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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


       // $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $fin])->where('bill_type', '=', 'PAID')->get();

        return response()->json($mes_act);
    }

    public function profittoday()
    {
        //GANANCIAS ESE DIA
        $year = date("Y-m-d");      
        $ini = $year;
        $fin = $year;


        $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PAID')->get();
        //dd($consulta1);
        //exit;
         
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

         $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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



       // $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $fin])->where('bill_type', '=', 'PAID')->get();

        return response()->json($mes_act);
    }




    public function profitrecordmonththisyear()
    {
        //GANANCIAS POR MES EN EL ANO EN CURSO
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






     $data=[
        'January'=> $ene ,
        'February'=> $feb ,
        'March'=>  $mar,
        'April'=> $abr ,
        'May'=> $may,
        'June'=>$jun ,
        'July'=>$jul,
        'August'=>$ago,
        'September'=>$sep ,
        'October'=> $oct ,
        'November'=> $nov  , 
        'December'=> $dic 
     ];
        return response()->json($data);
    }
  
    public function billscountyear()
    {       
 
     $year = date("Y");
     $ene_ini = $year."-01-01";
     $ene_end = $year."-12-31";
 
     $paid = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PAID')->count();  
     $anulate = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'ANULATED')->count();
     $partialy = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PARTIALLY-PAID')->count();
     $pending = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PENDING')->count();
     $total = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->count();  
     $data=[
         'paid'=> $paid ,
         'anulated'=> $anulate ,
         'partially_paid'=> $partialy,
         'pending'=> $pending ,
         'total'=> $total
      ];
 
 
 
        return response()->json($data);
    }
    
   // ANO PASADO

    
   public function anulatelastyear()
   {
       //  FACTURAS PAGAS DESDE ARRANQUE DE LA APP
       $year = date("Y") - 1;
       $ene_ini = $year."-01-01";
       $ene_end = $year."-12-31";
       $data = Bill::select('bill_total')->whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'ANULATED')->get();
       return response()->json($data);
   }

   public function paidlastyear()
   {
    
    $year = date("Y") - 1;
    $ene_ini = $year."-01-01";
    $ene_end = $year."-12-31";


     $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PAID')->get();
     //dd($consulta1);
     //exit;
      
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

      $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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


    // $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $fin])->where('bill_type', '=', 'PAID')->get();

     return response()->json($mes_act);




   }

   public function pendinglastyear()
   {
    $year = date("Y") - 1;
    $ene_ini = $year."-01-01";
    $ene_end = $year."-12-31";
       //  FACTURAS PAGAS DESDE ARRANQUE DE LA APP
       $data = Bill::select('bill_total')->whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PENDING')->get();
       return response()->json($data);
   }

   public function partyallypaidlastyear()
   {
    $year = date("Y") - 1;
    $ene_ini = $year."-01-01";
    $ene_end = $year."-12-31";
    $data = Bill::select('bill_total')->whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PARTIALLY-PAID')->get();
    return response()->json($data);
   }



   public function billscountlastyear()
   {       

    $year = date("Y") - 1;
    $ene_ini = $year."-01-01";
    $ene_end = $year."-12-31";

    $paid = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PAID')->count();  
    $anulate = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'ANULATED')->count();
    $partialy = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PARTIALLY-PAID')->count();
    $pending = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->where('bill_type', '=', 'PENDING')->count();
    $total = Bill::whereBetween('bill_date', [$ene_ini, $ene_end])->count();  


    $data=[
        'PAID'=> $paid ,
        'ANULATED'=> $anulate ,
        'PARTIALLY-PAID'=>  $partialy,
        'PENDING'=> $pending ,
        'TOTAL'=> $total

     ];



       return response()->json($data);
   }

 


    public function profitrecordmonthlastyear()
    {
        //GANANCIAS POR MES EN EL ANO PASADO
        $year = date("Y") - 1;

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


  
     $data=[
        'January'=> $ene ,
        'February'=> $feb ,
        'March'=>  $mar,
        'April'=> $abr ,
        'May'=> $may,
        'June'=>$jun ,
        'July'=>$jul,
        'August'=>$ago,
        'September'=>$sep ,
        'October'=> $oct ,
        'November'=> $nov  , 
        'December'=> $dic 
     ];
        return response()->json($data);
    }



   

    public function lastyeargan(){

        $year = date("Y");
        $lastyear = $year - 1 ;
     // var_dump($lastyear);
        $ini = $lastyear."-01-01";
        $fin = $lastyear."-12-31";


 $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PAID')->get();
 //dd($consulta1);
 //exit;
  
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

  $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $fin])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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


// $data = Bill::select('bill_total')->whereBetween('bill_date', [$ini, $fin])->where('bill_type', '=', 'PAID')->get();     

        return response()->json($mes_act);
    } 



    public function month_incoming_money(Request $request){

      
        $ini = date('Y').'-'.date('m').'-01' ;   
        $end = date('Y').'-'.date('m').'-'.date("d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));


        $consulta1 = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $end])->where('bill_type_p', '=', 'PAID')->get();
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

          $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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
         // dd($mes_act);
           // exit;


           $consulta1p = Bills_part_paid::select('partial_payment_mont')->whereBetween('partial_payment_date', [$ini, $end])->where('bill_type_p', '=', 'PARTIALLY-PAID')->get();
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
          // dd($mes_act);
            // exit;




        if ($request->ajax()) {
            $data =  DB::table('bills_part_paid')
            ->leftjoin('bills', 'bills_part_paid.bill_id_p', '=', 'bills.id')
            ->whereBetween('partial_payment_date', [$ini, $end])
            ->select('bills.customer_name', 'bills.bill_description','bills_part_paid.*')
            ->get(); 


       return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row->bill_type_p=='PAID' OR $row->bill_type_p=='ANULATED'  ){ 
                            $btn = '<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                         
                        }                    
                        else{
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-pen"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Paid" class="edit btn btn-primary btn-sm editpay"><i class="fas fa-money-check"></i></a>';
                            $btn = $btn .'<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                         }                       
                     return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
             }        
             $request->user()->authorizeRoles(['admin']);
             return view('bill.list_bill')->with('mes_act',$mes_act)->with('mes_act_t',$mes_act_t)->with('mes_act_p',$mes_act_p);
       //dd($item);
       // return response()->json($item);
        
    }
}










