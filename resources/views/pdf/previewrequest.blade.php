<style type="text/css">
    .table-bordered {border:none;  }
    table {border: none;}
    .content{ margin: 10px 15px; width:80%; }
    .cols{float:left; width:50%; }
</style>
<page backtop="90mm" backbottom="2mm" backleft="1mm" backright="1mm"  backimg="http://bill.greendepartment.org/image/media.png"  backimgy="top">
<page_header>
        <table border="0" cellspacing="0" cellpadding="0" class="page_header"   style="width: 100%; border:none;">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">
        <col class="table-bordered" style="width: 33%">

            <tr>
              <td style="font-size:3.5em;text-transform: uppercase;"><br>
              <h2 style="padding:0px"> REQUEST Nro.{{ $bill['request_number'] }} </h2>

                   <h3 style="padding:0px 10px; font-size:2.5em;" ><b>DATE</b>:  <b>{{ Carbon\Carbon::parse($bill['request_date'])->formatLocalized('%d %b %Y')   }}</b></h3>
                    
                </td>
                <td></td>
                <td></td>
            </tr>
        <tr>
              <td colspan="2" style="padding: 1cm; font-size:2.5em;line-height:18px;  text-transform: uppercase;"><h4><b>REQUIRED BY :</b></h4>         
                {{ $bill['employer_name'] }} <br>
                {{ $bill['employer_adress'] }} <br>
                PHONE: {{ $bill['employer_phone'] }} <br>
                {{ $bill['employer_email'] }}     
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
    <br>
    <br>
    <h1>{{ $bill['request_type'] }} ORDER </h1>
    <br>
    <br>
    <table style="border-collapse: collapse;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 57%;">
                <col class="table-bordered" style="width: 15%;">
                <col class="table-bordered" style="width: 15%;">
       <tr>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>QUANTITY</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>DESCRIPTION</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:13px;"><b>RATE</b></th>
            <th style="border-bottom:3px solid #ccc;  color:#9370db; font-size:15px;"><b>AMOUNT</b></th>
        </tr>  
        @foreach($billitems['request_name'] as $items => $valor )
            <tr>
                <td>{{ $billitems['request_qty'][$items]  }}</td>
                <td style="font-size: medium;" >{{ $billitems['request_description'][$items] }}</td>
                <td> $ {{ $billitems['request_price'][$items]  }}</td>
                <td> $ {{ $billitems['request_total_prices'][$items] }}</td>
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
                <b> Tax:</b>&nbsp;&nbsp;&nbsp;<br>
                <b> Total:</b>&nbsp;&nbsp;&nbsp;<br>
            </td>
            <td style=" text-align: left;">
            &nbsp;&nbsp;$ {{ $bill['request_subtotal'] }}<br>
            &nbsp;&nbsp;$ {{ $bill['request_taxes_num'] }}<br>
            &nbsp;&nbsp;$ {{ $bill['request_total'] }}
            </td>
        </tr>
    </table>
</page>