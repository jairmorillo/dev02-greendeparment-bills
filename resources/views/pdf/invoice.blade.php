<style type="text/css">
    .table-bordered {border:none;  }
    table {border: none;}
    .content{ margin: 10px 15px; width:80%; }
    .cols{float:left; width:50%; }
</style>


<page backtop="100mm" backbottom="2mm" backleft="1mm" backright="1mm" 

@foreach($bill as $item)
   @if ( $item->bill_type === 'PAID')
   
        backimg="https://bill.greendepartment.org/image/Imagen4.png"

   @elseif ($item->bill_type === 'PARTIALLY-PAID')
   
        backimg="https://bill.greendepartment.org/image/imagen-partial.png"

   @else
        backimg="https://bill.greendepartment.org/image/media.png"
   @endif
@endforeach

backimgy="top" 	>
<page_header>
        <table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; border:none;">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">

        @foreach($bill as $item)
            <tr>
                <td style="font-size:3.5em;text-transform: uppercase;">
                    
                   
                   
                   
                      @if ( $item->bill_type === 'PAID' )
                         <h2 style="padding:0px"> RECEIPT Nro.{{ $item->bill_number }}</h2>
                      @elseif ( $item->bill_type === 'PARTIALLY-PAID')
                         <h2 style="padding:0px"> RECEIPT Nro.{{ $item->bill_number }}</h2> 
                       @else
                             <h2 style="padding:0px"> INVOICE  Nro.{{ $item->bill_number }}</h2>
                       @endif
                   <h4 style="padding:0px 10px; font-size:2.5em;" ><b>DATE</b>:  <b>{{ Carbon\Carbon::parse($item->bill_date)->formatLocalized('%d %b %Y')   }}</b></h4>
                    
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 1cm; font-size:2.5em;line-height:18px;  text-transform: uppercase;">
                
                
                
                      @if ( $item->bill_type === 'PAID')
                            <h4><b>Receipt TO:</b></h4>   
                      @elseif ( $item->bill_type === 'PARTIALLY-PAID')
                            <h4><b>Receipt with pending payment TO:</b></h4>   
  
                       @else
                                    <h4><b>Invoice to:</b></h4>   
                       @endif
                
                
                
                {{ $item->customer_type_property }} <br>
                {{ $item->customer_name }} <br>
                {{ $item->customer_adress }} <br>
                PHONE: +1 {{ $item->customer_phone }} <br>
                {{ $item->customer_email }} 
    
            </td>
            <td style="padding: 1cm;"></td>
        </tr>
        @endforeach

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
    <table style="" style="border-collapse: collapse ;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 11%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">
        <tr>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>QUANTITY</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>DESCRIPTION</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>UNIT</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>RATE</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:15px;"><b>AMOUNT</b></th>
        </tr>  
        @foreach($billitems as $items)
        <tr>
            <td style="border-bottom:2px solid #ccc; ">{{ $items->serv_qty }}</td>
            <td style="font-size: medium; border-bottom:2px solid #ccc;" >{{ html_entity_decode($items->serv_description) }}</td>
            <td style="border-bottom:2px solid #ccc;">{{ $items->serv_unit }}</td>
            <td style="border-bottom:2px solid #ccc;"> $ {{ $items->serv_price }}</td>
            <td style="border-bottom:2px solid #ccc;"> $ {{ $items->serv_total_prices }}</td>
        </tr> 
        @endforeach
    </table>
    <br />
    <table style="border-collapse: collapse;" >
    <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 10%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">
    
    @foreach($billpartial as $itemxs)
        <tr>
            <td style="border-bottom:2px solid #ccc; ">1</td>
            <td style="font-size: medium; border-bottom:2px solid #ccc;" >
            
            @if ( $itemxs->partial_payment_cash === '0,00' )
                  DEPOSIT FOR  - {{ $itemxs->partial_payment_percents }}% - {{ $itemxs->partial_payment_date}}
             @else 
                  DEPOSIT FOR  - $ {{ $itemxs->partial_payment_cash }} - {{ $itemxs->partial_payment_date}}
           @endif             
            
            </td>
            <td style="border-bottom:2px solid #ccc;">INCLUDED</td>
            <td style="border-bottom:2px solid #ccc;">&nbsp;&nbsp;&nbsp;$0,00</td>
            <td style="border-bottom:2px solid #ccc;"> - $ {{ $itemxs->partial_payment_mont }}</td>
        </tr> 
  @endforeach
    
    </table>    <br /><br />

    <table style="border-collapse: collapse;" >
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 47%;">
                <col class="table-bordered" style="width: 10%;">
                <col class="table-bordered" style="width: 12%;">
                <col class="table-bordered" style="width: 15%;">

  @foreach($bill as $item)
        <tr>
            <td colspan="4" style=" text-align: right;">
                <b> Subtotal:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Sales Tax:</b>&nbsp;&nbsp;&nbsp;<br>                                  
                @if ( $item->discount_cash === '0,00' )
                <b> (- {{$item->discount}}% ) Discount:
                @else 
                <b> Discount:                                    
                @endif  
                </b>&nbsp;&nbsp;&nbsp;<br>
                <b> Total:</b>&nbsp;&nbsp;&nbsp;<br>
                                
                @if ( $item->bill_type === 'PAID')
                @elseif ($item->bill_type === 'PARTIALLY-PAID')
                    @if ( $item->partial_payment_cash === '0,00' )
                        <hr><br>
                        <b>LAST (- {{$item->partial_payment_percents}}% ) PAID IN ADVANCE:</b>&nbsp;&nbsp;&nbsp;<br>
                        <b> Outstanding balance:</b>&nbsp;&nbsp;&nbsp;
                    @else 
                        <hr><br>
                        <b>LAST PAID IN ADVANCE:</b>&nbsp;&nbsp;&nbsp;<br>
                        <b> Outstanding balance:</b>&nbsp;&nbsp;&nbsp;
                    @endif                
                @else
               @endif
                
                


            </td>
            <td style=" text-align: left;">
            &nbsp;&nbsp;$ {{ $item->bill_subtotal }}<br>
            &nbsp;&nbsp;$ {{ $item->bill_iva }}<br>
            &nbsp;&nbsp;$   @if ( $item->discount_cash === '0,00' )
                                     {{ $item->bill_discount }}
                                   @else
                                     {{ $item->discount_cash }} 
                                   @endif<br>
            &nbsp;&nbsp;$ {{ $item->bill_total }}<br>           
            
               @if ( $item->bill_type === 'PAID')
               @elseif ($item->bill_type === 'PARTIALLY-PAID')
                   <hr><br>
                            &nbsp;&nbsp;$
                         
                                   @if ( $item->partial_payment_percents === '0,00' )
                                     {{ $item->partial_payment_mont }}
                                   @else
                                     {{ $item->partial_payment_mont }} 
                                   @endif
                
                            <br>
                            @if ( $item->bill_type === 'PARTIALLY-PAID' )
                                                           &nbsp;&nbsp;$ {{ $item->partial_payment_rest }}

                            @else
                                                           &nbsp;&nbsp;$ {{ $item->bill_total }}

                            @endif
               @else
               @endif      
            </td>
        </tr>
        @endforeach
    </table>
</page>