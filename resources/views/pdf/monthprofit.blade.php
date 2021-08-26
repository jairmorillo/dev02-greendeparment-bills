<style type="text/css">
    .table-bordered {border:none;  }
    table {border: none;}
    #tepe tr td  {
        height: 59px;
        }
   #tepeint tr td  {
        height: 59px;
        }
    .content{ margin: 10px 15px; width:80%; }
    .cols{float:left; width:50%; }
</style>

<page backtop="64.33mm" backbottom="2mm" backleft="1mm" backright="1mm" backimg="https://bill.greendepartment.org/image/motna.png"  backimgy="top" 	>
<page_header>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<br>
<br>
<table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; border:none;">
        <col class="table-bordered" style="width: 0%">
        <col class="table-bordered" style="width: 100%">
        <col class="table-bordered" style="width: 0%">
 <tr>
   <td></td>
   <td style="color:#000; text-align:center; border:0px solid #000;"><h1> Billing Report </h1></td>
   <td></td>
 </tr>
       

        </table>
    </page_header>
    <page_footer > 
      <table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; ">
        <col class="table-bordered" style="width: 23%">
        <col class="table-bordered" style="width: 53%">
        <col class="table-bordered" style="width: 23%">
           <tr>
                <td  style=" text-align: center;"></td>
                <td  style=" text-align: center;">Page <strong>[[page_cu]]</strong> of <strong>[[page_nb]]</strong></td>
                <td  style=" text-align: center;"></td>
            </tr>
            <tr>
                <td  colspan="3" style=" text-align: right;"> <b> Questions?</b> Contact Green Department INC at <b>billing@greendepartment.org</b> or call at +1(800) 824-4440.</td>
            </tr>
        </table>
    </page_footer> 
 
    <table style="border-collapse: collapse ; width: 100%;">
                <col class="table-bordered" style="width: 23.33%;">
                <col class="table-bordered" style="width: 43.33%;">
                <col class="table-bordered" style="width: 33.33%;">               
        <tr>
            <th style="  color:#000; font-size:11px; border:0px solid #000;">
            <table   id="tepe"  style=" width: 100%; margin-left:0px;">
             <tr>
                <td>
                 <table  style=" width: 50%; height:auto !important; margin-top:4px; margin-left:45px;color:#000; font-size:11px; border:0px solid #000;">
                 <col class="table-bordered" style="width: 100%;">
                 <tr><td>PAID - {{ $data['paid']}}/{{ $data['total']}}</td></tr> </table>
                </td>
             </tr>
             <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PART-PAID - {{ $data['partially_paid']}}/{{ $data['total']}}</td></tr>
             <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PENDING - {{ $data['pending']}}/{{ $data['total']}}</td></tr>
             <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANULATED - {{ $data['anulated']}}/{{ $data['total']}} </td></tr>     
             <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>     
             <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>     
             <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>     

            </table>
          </th>
          <th colspan=2  style="color:#fff; font-size:30px; border:0px solid #000;">
          <table  cellspacing="0" cellpadding="0"  id="tepeint" style="border-collapse: collapse;  border:1px solid #000;">
                <col class="table-bordered" style="width: 5%;">
                <col class="table-bordered" style="width: 90%;">
                <col class="table-bordered" style="width: 5%;">
                <tr>
                    <td style="color:#fff; font-size:30px; border:0px solid #000;"></td>
                    <td style="color:#fff; font-size:30px; border:0px solid #000;">
                    <table  cellspacing="0" cellpadding="0"  id="tepeint" style="border-collapse: collapse;  border:0px solid #000;">
                    <col class="table-bordered" style="width: 33.33%;">
                    <col class="table-bordered" style="width: 33.33%;">
                    <col class="table-bordered" style="width: 33.33%;">
                    <tr>
                        <td style="color:#fff; font-size:18px; border:0px solid #000;"><div style="margin-top:-10px;">@money($comparacion['anterior'])<br><span style='font-size:12px;'>  </span></div></td>
                        <td style="color:#fff; font-size:18px; border:0px solid #000;"><div style="margin-top:0px;">&nbsp;@money($comparacion['actual'])<br>&nbsp;<span style='font-size:12px;'>    </span>  </div></td>
                        <td style="color:#fff; font-size:18px; border:0px solid #000;"><div style="margin-top:0px;">&nbsp;&nbsp;&nbsp;@comver($comparacion['diferencia']) % <br>&nbsp;&nbsp;&nbsp;<span style='font-size:12px; padding-left:160px; display:block;'></span></div></td>    
                    </tr>                      
                    </table>
                    </td>
                    <td style="color:#fff; font-size:30px; border:0px solid #000;"></td>
                </tr>  
                <tr>
                    <td style="color:#fff; font-size:13px; border:0px solid #000;"></td>
                    <td style="color:#000; font-size:15px; border:0px solid #000; text-align:center;"><h3>Earnings per month per current year</h3></td>
                    <td style="color:#fff; font-size:13px; border:0px solid #000;"></td>
                </tr>  
                <tr>
                        <td colspan="3" style="color:#000; font-size:15px; border:0px solid #000;"> 
                            <table  cellspacing="0" cellpadding="0"  id="" style="border-collapse: collapse;  border:1px solid #000;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <tr>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['enero']) <br><span style='font-size:12px;'> <b>January</b></span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['febrero'])<br><span style='font-size:12px;'> <b>February</b> </span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['marzo'])<br><span style='font-size:12px;'><b>March</b></span></td>    
                                </tr>                      
                            </table>
                        </td>
                </tr>   
                <tr>
                <td colspan="3" style="color:#000; font-size:15px; border:0px solid #000;"> 
                            <table  cellspacing="0" cellpadding="0"  id="" style="border-collapse: collapse;  border:1px solid #000;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <tr>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['abril'])<br><span style='font-size:12px;'> <b>April</b></span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['mayo'])<br><span style='font-size:12px;'> <b>May</b> </span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['junio'])<br><span style='font-size:12px;'><b>June</b></span></td>    
                                </tr>                      
                            </table>
                        </td>
                </tr>   
                <tr>
                <td colspan="3" style="color:#000; font-size:15px; border:0px solid #000;"> 
                            <table  cellspacing="0" cellpadding="0"  id="" style="border-collapse: collapse;  border:1px solid #000;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <tr>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['julio'])<br><span style='font-size:12px;'> <b>July</b></span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['agosto'])<br><span style='font-size:12px;'> <b>August</b> </span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['septiembre']) <br><span style='font-size:12px;'><b>September</b></span></td>    
                                </tr>                      
                            </table>
                        </td>
                </tr> 
                <tr>
                <td colspan="3" style="color:#000; font-size:15px; border:0px solid #000;"> 
                            <table  cellspacing="0" cellpadding="0"  id="" style="border-collapse: collapse;  border:1px solid #000;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <col class="table-bordered" style="width: 33.33%;">
                                <tr>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['octubre'])<br><span style='font-size:12px;'><b>October</b></span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['noviembre'])<br><span style='font-size:12px;'><b>November</b> </span></td>
                                    <td style="color:#000; font-size:18px; border:1px solid #000;text-align:center;">@money($datayear['diciembre']) <br><span style='font-size:12px;'><b>December</b></span></td>    
                                </tr>                      
                            </table>
                        </td>
                </tr>          
         </table>
         
          
          </th>
            
        </tr>  
     
    </table>
    <br />
    <table cellspacing="0" cellpadding="0"  style="border-collapse: collapse;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 10%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">
        
    </table>
</page>