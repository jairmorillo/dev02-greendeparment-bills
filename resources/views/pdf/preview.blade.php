<style type="text/css">
    .table-bordered {border:none;  }
    table {border: none;}
    .content{ margin: 10px 15px; width:80%; }
    .cols{float:left; width:50%; }
</style>
<page backtop="100mm" backbottom="2mm" backleft="1mm" backright="1mm"  backimg="https://bill.greendepartment.org/image/media.png"  backimgy="top">
<page_header>
        <table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; border:none;">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">

            <tr>
                 <td style="font-size:3.5em;text-transform: uppercase;">
                   <h2 style="padding:0px"> INVOICE Nro.{{  $bill['bill_number']  }} </h2>
                   <h4 style="padding:0px 10px; font-size:2.5em;" ><b>DATE</b>:  <b>{{ Carbon\Carbon::parse($bill['bill_date'])->formatLocalized('%d %b %Y')   }}</b></h4>
                    
                </td>
                <td></td>
                <td></td>
            </tr>
        <tr>
              <td colspan="2" style="padding: 1cm; font-size:2.5em;line-height:18px;  text-transform: uppercase;"><h4><b>INVOICE TO:</b></h4>         
                {{ $bill['customer_type_property']  }} <br>
                {{ $bill['customer_name'] }} <br>
                {{ $bill['customer_adress'] }} <br>
                PHONE: +1 {{ $bill['customer_phone'] }} <br>
                {{ $bill['customer_email'] }}     
            </td>
            <td style="padding: 1cm;"></td>
        </tr>

        </table>
    </page_header>
    <page_footer > 
      <table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; border:none;">
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

    <table style="border-collapse: collapse;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 10%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">
       <tr>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>QUANTITY</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>DESCRIPTION</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>UNIT</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>RATE</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:15px;"><b>AMOUNT</b></th>
        </tr>  
        @foreach($billitems['serv_name'] as $items => $valor )
            <tr>
                <td>{{ $billitems['serv_qty'][$items]  }}</td>
                <td style="font-size: medium;" >{{ html_entity_decode($billitems['serv_description'][$items]) }}</td>
                <td>{{ $billitems['serv_unit'][$items] }}</td>
                <td> $ {{ $billitems['serv_price'][$items]  }}</td>
                <td> $ {{ $billitems['serv_total_prices'][$items] }}</td>
            </tr> 
        @endforeach

    </table>
    <br />
    <table style="border-collapse: collapse;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 10%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">
        <tr>
            <td colspan="4" style=" text-align: right;">
                <b> Subtotal:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Sales Tax:</b>&nbsp;&nbsp;&nbsp;<br>
                <b>(- {{$bill['discount']}} % ) Discount:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Total:</b>&nbsp;&nbsp;&nbsp;<br><hr><br>
                <b>(- {{$bill['partial_payment_percents']}} % ) PAID IN ADVANCE:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Outstanding balance:</b>&nbsp;&nbsp;&nbsp;<br>

            </td>
            <td style=" text-align: left;">
                &nbsp;&nbsp;$ {{ $bill['bill_subtotal'] }}<br>
                &nbsp;&nbsp;$ {{ $bill['bill_iva'] }}<br>
                &nbsp;&nbsp;$ {{ $bill['bill_discount'] }}                
                          @if ( $bill['discount_cash'] === '0,00' )
                                     {{ $bill['bill_discount']  }}
                                   @else
                                     {{ $bill['discount_cash'] }}
                         @endif<br>               
                
                <br>
                &nbsp;&nbsp;$ {{ $bill['bill_total'] }}<br><hr><br>
                &nbsp;&nbsp;$ 
                   @if ( $bill['partial_payment_percents'] === '0,00')
                    {{ $bill['partial_payment_cash']  }}
                   @else
                     {{ $bill['partial_payment_mont'] }}
                   @endif
                <br>
                @if ( $bill['partial_payment_percents'] === '0,00' && $bill['partial_payment_cash']  ==='0,00' )
                   &nbsp;&nbsp;$ {{ $bill['bill_total'] }}
                @else
                   &nbsp;&nbsp;$ {{ $bill['partial_payment_rest'] }}
                @endif
            
            </td>
        </tr>
    </table>
</page>