
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GREEN DEPARTMENT PAYMENTS </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style>
            body {
                font-size: 0.8rem !important;
                line-height: 1.2;
                background: #212121;
                color: #fff;
                text-transform: uppercase;
            }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                GREEN DEPARTMENT PAYMENTS
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">                  
                </div>
            </div>
        </nav>

        <main class="py-4">


@php
    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
@endphp
<!-- Company Overview section START -->
<section class="container-fluid inner-Page" >
    <div class="card-panel">
        <div class="media wow fadeInUp" data-wow-duration="1s"> 
            <div class="companyIcon">
            </div>
            <div class="media-body">
                
                <div class="container">
                    @if(session('success_msg'))
                    <div class="alert alert-success fade in alert-dismissible show">                
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true" style="font-size:20px">×</span>
                        </button>
                        {{ session('success_msg') }}
                    </div>
                    @endif
                    @if(session('error_msg'))
                    <div class="alert alert-danger fade in alert-dismissible show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true" style="font-size:20px">×</span>
                        </button>    
                        {{ session('error_msg') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                  

                            <h1>Payment</h1>
                        </div>                       
                    </div>    
                    <div class="row">                        
                        <div class="col-xs-12 col-md-6" style="background: #212121;border-radius: 5px;padding: 10px;">
                            <div class="panel panel-primary">                                       
                                <div class="creditCardForm">                                    
                                    <div class="payment">
                                        <form id="payment-card-info" method="post" action="{{ route('dopay.online') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group owner col-md-8">
                                                    <label for="owner">Owner</label>
                                                    <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" required>
                                                    <span id="owner-error" class="error text-red">Please enter owner name</span>
                                                </div>
                                                <div class="form-group CVV col-md-4">
                                                    <label for="cvv">CVV</label>
                                                    <input type="number" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" required>
                                                    <span id="cvv-error" class="error text-red">Please enter cvv</span>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="form-group col-md-8" id="card-number-field">
                                                    <label for="cardNumber">Card Number</label>
                                                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" required>
                                                    <span id="card-error" class="error text-red">Please enter valid card number</span>
                                                </div>
                                                <div class="form-group col-md-4" >
                                                    <label for="amount">Amount</label>
                                                   
                                                    @foreach( $transaction as $item)
                                                            <input type="text" class="form-control" id="amount" name="amount" min="1" value="{{$item->amount}}" required readonly/>
                                                    @endforeach

                                                    <span id="amount-error" class="error text-red"> Amount</span>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="form-group col-md-6" id="expiration-date">
                                                    <label>Expiration Date</label><br/>
                                                    <select class="form-control" id="expiration-month" name="expiration-month" style="float: left; width: 100px; margin-right: 10px;">
                                                        @foreach($months as $k=>$v)
                                                            <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>                                                        
                                                        @endforeach
                                                    </select>  
                                                    <select class="form-control" id="expiration-year" name="expiration-year"  style="float: left; width: 100px;">
                                                        
                                                        @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>            
                                                        @endfor
                                                    </select>
                                                </div>                                                
                                                <div class="form-group col-md-6" id="credit_cards" style="margin-top: 22px;">
                                                    <img src="{{ asset('image/visa.jpg') }}" id="visa">
                                                    <img src="{{ asset('image/mastercard.jpg') }}" id="mastercard">
                                                    <img src="{{ asset('image/amex.jpg') }}" id="amex">
                                                </div>
                                            </div>
                                            
                                            <br/>
                                            <div class="form-group" id="pay-now">
                                                <button type="submit" class="btn btn-success themeButton" id="confirm-purchase">Confirm Payment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>                                
                            </div>
                        </div>   
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="background: #212121; border-radius: 5px; padding: 10px;">
                            <h3>Customer Data</h3>
                            <table class="table table-bordered">
                                <tbody>

                               @foreach( $data as $item)
                                <tr>
                                    <th>
                                        Customer
                                    </th>
                                    <td>
                                        {{ $item->customer_name }}                                     </td>
                                </tr>
                                <tr>
                                    <th>
                                        Address
                                    </th>
                                    <td>
                                        {{ $item->customer_adress }}                                     </td>
                                </tr>
                                <tr>
                                    <th>
                                        Phone
                                    </th>
                                    <td>
                                    {{ $item->customer_phone }} 
                                </tr>
                                <tr>
                                    <th>
                                        Customer
                                    </th>
                                    <td>
                                    {{ $item->customer_email }} 
                                      </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bill Number
                                    </th>
                                    <td>
                                    {{ $item->bill_number }} 
                                      </td>
                                </tr>
                                    
                                    <tr>
                                    <th>
                                        Description
                                    </th>
                                    <td>
                                    {{ $item->bill_description }} 
                                      </td>
                                </tr>
                                    
                                  <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td>
                                    {{ $item->bill_total }} 
                                      </td>
                                </tr>
                                     <tr>
                                    <th>
                                        Outstanding balance

                                    </th>
                                    <td>
                                    {{ $item->partial_payment_rest }} 
                                      </td>
                                </tr>   
                                    
                               @endforeach

                           
                           
                                </tbody>
                            </table>
                        </div>         
                    </div>
                </div>
            </div>

        </div>
    </div> 
    <div class="clearfix"></div>
</section>        
</main>
    </div>
    
    @yield('script_bottom')

</body>
</html>