<style type="text/css">
    .table-bordered {border:none;  }
    table {border: none;}
    .content{ margin: 10px 15px; width:80%; }
    .cols{float:left; width:50%; }
</style>


<page backtop="90mm" backbottom="2mm" backleft="1mm" backright="1mm" 

@foreach($bill as $item)
   @if ( $item->request_type === 'PAID')
        backimg="http://bill.greendepartment.org/image/Imagen4.png"
   @else
        backimg="http://bill.greendepartment.org/image/media.png"
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
                   <h2 style="padding:0px"> INVOICE Nro.{{ $item->request_number }} </h2>
                   <h4 style="padding:0px 10px; font-size:2.5em;" ><b>DATE</b>:  <b>{{ Carbon\Carbon::parse($item->request_date)->formatLocalized('%d %b %Y')   }}</b></h4>
                    
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 1cm; font-size:2.5em;line-height:18px;  text-transform: uppercase;"><h4><b>REQUIRED BY :</b></h4>         
                {{ $item->employer_name }} <br>
                {{ $item->employer_adress }} <br>
                PHONE: {{ $item->employer_phone }} <br>
                {{ $item->employer_email }} 
    
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
    @foreach($bill as $item)
        <br>
        <h1>{{ $item->request_type }}  ORDER </h1>
        <br>
        <br>
    @endforeach

    <table style="" style="border-collapse: collapse ;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 52%;">
                <col class="table-bordered" style="width: 17%;">
                <col class="table-bordered" style="width: 15%;">
        <tr>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>QUANTITY</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>DESCRIPTION</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>RATE</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:15px;"><b>AMOUNT</b></th>
        </tr>  
           @foreach($billitems as $items)
        <tr>
            <td style="border-bottom:2px solid #ccc; ">{{ $items->request_qty }}</td>
            <td style="font-size: medium; border-bottom:2px solid #ccc;" >{{ $items->request_description }}</td>
            <td style="border-bottom:2px solid #ccc;"> $ {{ $items->request_price }}</td>
            <td style="border-bottom:2px solid #ccc;"> $ {{ $items->request_total_prices }}</td>
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
                @foreach($bill as $item)
        <tr>
            <td colspan="4" style=" text-align: right;">
                <b> Subtotal:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Tax:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Total:</b>&nbsp;&nbsp;&nbsp;<br>
            </td>
            <td style=" text-align: left;">
            &nbsp;&nbsp;$ {{ $item->request_subtotal }}<br>
            &nbsp;&nbsp;$ {{ $item->request_taxes_num }}<br>
            &nbsp;&nbsp;$ {{ $item->request_total }}
            </td>
        </tr>
        @endforeach
    </table>
</page>