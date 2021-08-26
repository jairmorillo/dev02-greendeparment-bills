@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div id='reportPage'>
      <!-- Info boxes -->    
              <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box --> 
            <div class="small-box bg-warning ">
              <div class="inner">
                <h3> @money($comparacion['anterior']) </h3>
                <p>Last Month</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box  bg-info">
              <div class="inner">
              <h3> @money($comparacion['actual']) </h3>
                <p>This Month</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box   bg-success">
              <div class="inner">
              <h3>@comver($comparacion['diferencia'])<sup style="font-size: 20px">%</sup></h3>
                <p>Profit according to the last month</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->

        </div>  
      <div class="row">
     
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">This Month's Earnings</span>
                <span class="info-box-number" id="monthTU"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

              <div class="info-box-content">
              <a href="/dashboard/money">
                <span class="info-box-text">Invoices Paid This Month</span>
                <span class="info-box-number" id="paid"></span>
              </a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Customer</span>
                <span class="info-box-number" id="customer"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
              
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Anual Profit </strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                     <div class="col-md-4">
                    <p class="text-center">
                      <strong>Estadisticas Actuales</strong>
                    </p>

                    <div class="progress-group">
                      Paid Invoice
                      <span class="float-right"><b id="paidcount" ></b>/<b id="totalcount1">  </b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success  " id='percen1'></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Anulated Invoices
                      <span class="float-right"><b id="anulatecount" ></b>/<b id="totalcount2">  </b> </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" id='percen2'></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Pending Invoices</span>
                      <span class="float-right"><b id="pendingcount" ></b>/<b id="totalcount3"> </b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning " id='percen3' ></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Partialy Paid Invoices
                      <span class="float-right"><b id="partcount"></b>/ <b id="totalcount4">  </b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" id='percen4'></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"></span>
                      <h5 class="description-header"  id="today" ></h5>
                      <span class="description-text">TOTAL Today</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"> </span>
                      <h5 class="description-header" id="month"></h5>
                      <span class="description-text">TOTAL Month</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"></span>
                      <h5 class="description-header" id="year"  ></h5>
                      <span class="description-text" >TOTAL Year</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"></span>
                      <h5 class="description-header" id="PROFIT" ></h5>
                      <span class="description-text">TOTAL EVER</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    <div class='row'>
       <!-- /.col-md-6 -->
       <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Comparison with last year</h3>
                  <a href="/pdf/monthprofit"  target="_blank" >View Report to this Month</a>
                  <a href="/pdf/anualprofit"  target="_blank" >View Report to Last Year</a>

                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"></span>
                    <span></span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                       
                    </span>
                    <span class="text-muted"></span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Last year
                  </span>
                  <span>
                    <i class="fas fa-square text-gray"></i> This year 
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
    </div>
</div>

@stop
@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')
    <script> 
    


  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  // - MONTHLY SALES CHART -
  //-----------------------

  // Get context with jQuery - using jQuery's .get() method.
var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  //   console.log('data:', data)    
var salesChartData = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
  datasets: [
       {
      label: 'Profit',   
      data: [ @foreach($data as $link){{ $link }},@endforeach ] //["15566.59","27999.60","29217.59"]
    }
  ]
}

var salesChartOptions = {
  maintainAspectRatio: false,
  responsive: true,
  legend: {
    display: true
  },
  tooltips: {
						mode: 'index',
						intersect: true,
						yPadding: 10,
						xPadding: 10,
						caretSize: 50,
						backgroundColor: '#716c7de0',
						titleFontColor:'#ffffff' ,
						bodyFontColor:'#ffffff' ,
						borderColor: 'rgba(0,0,0,1)',
						borderWidth: 4,
            bodyFontSize: 20
					},
  scales: {
    xAxes: [{
      gridLines: {
        display: true
      }
    }],
    yAxes: [{
      gridLines: {
        display: true
      }
    }]
  }
}

// This will get the first returned node in the jQuery collection.
// eslint-disable-next-line no-unused-vars
var salesChart = new Chart(salesChartCanvas, {
    type: 'line',
    data: salesChartData,
    options: salesChartOptions
  }
)

//---------------------------
// - END MONTHLY SALES CHART -
//---------------------------
var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true
  

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['JAN','FEB','MAR','APR','MAY','JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [ @foreach($datax as $link){{ $link }},@endforeach ]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [ @foreach($data as $link){{ $link }},@endforeach ]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      
      tooltips: {
						mode: 'index',
						intersect: true,
						yPadding: 10,
						xPadding: 10,
						caretSize: 50,
						backgroundColor: '#716c7de0',
						titleFontColor:'#ffffff' ,
						bodyFontColor:'#ffffff' ,
						borderColor: 'rgba(0,0,0,1)',
						borderWidth: 4,
            bodyFontSize: 20
					},
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })






function reverseFormatNumber(val,locale){
        var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
        var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, '');
        var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
        reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
        return Number.isNaN(reversedVal)?0:reversedVal;
    }

    $.get("{{url('/')}}/dashboard/billscountyear", function (data) {  
      
            $("#paidcount").append(''+data.paid+'');
            $("#totalcount1").append(''+data.total+'');

            $("#anulatecount").append(''+data.anulated+'');
            $("#totalcount2").append(''+data.total+'');

            $("#pendingcount").append(''+data.pending+'');
            $("#totalcount3").append(''+data.total+'');

            $("#partcount").append(''+data.partially_paid+'');
            $("#totalcount4").append(''+data.total+'');

            var percen1 =  data.paid / data.total * 100 ;
            var percen2 =  data.anulated / data.total * 100 ;
            var percen3 =  data.pending / data.total * 100 ;
            var percen4 =  data.partially_paid / data.total * 100 ;

            $("#percen1").attr("style",'width:'+percen1+'%');
            $("#percen2").attr("style",'width:'+percen2+'%');
            $("#percen3").attr("style",'width:'+percen3+'%');
            $("#percen4").attr("style",'width:'+percen4+'%');


            //  alert(profit);
            console.log(percen1);
      });

    

    $.get("{{url('/')}}/dashboard/profit", function (data) {  //   console.log('data:', data);
          profit = 0;

          for(var i = 0; i < data.length; i++) {           
            profit = profit + eval( reverseFormatNumber(data[i].bill_total,'de') );
          }  
          var profitformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(profit);
            
          $("#PROFIT").append('$'+ profitformat +'');

            //  alert(profit);
            //  console.log(profit);
      });

      $.get("{{url('/')}}/dashboard/profitmonth", function (data) {  //   console.log('data:', data);
          profit = 0;

          for(var i = 0; i < data.length; i++) {           
            profit = profit + eval( reverseFormatNumber(data[i].bill_total,'de') );
          }  
          var profitformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(profit);
            
          $("#month").append('$'+ profitformat +'');

            //  alert(profit);
            //  console.log(profit);
      });


      $.get("{{url('/')}}/dashboard/profityear", function (data) {  //   console.log('data:', data);
          
          var profitformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data);
            
          $("#year").append('$'+ profitformat +'');
            //  alert(profit);
            //  console.log(profit);  profittoday
      });



      $.get("{{url('/')}}/dashboard/profittoday", function (data) {  //   console.log('data:', data);
          profit = 0;

                   var profitformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data);
            
          $("#today").append('$'+ profitformat +'');

            //  alert(profit);
            //  console.log(profit);  
      });




      $.get("{{url('/')}}/dashboard/profitmonth", function (data) {  //   console.log('data:', data);
          profit = 0;

          //for(var i = 0; i < data.length; i++) {           
          //   profit = profit + eval( reverseFormatNumber(data[i].bill_total,'de') );
          // }  
          var profitformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data);
            
          $("#monthTU").append('$'+ profitformat +'');

            //  alert(profit);
            //  console.log(profit);
      });



      $.get("{{url('/')}}/dashboard/customercount", function (data) {  //   console.log('data:', data)       
                $("#customer").append(''+ data +'');            
      });

      $.get("{{url('/')}}/dashboard/billscount", function (data) {  //   console.log('data:', data)       
                $("#paid").append(''+ data +'');            
      });



$('#downloadPdf').click(function(event) {
  // get size of report page
  var reportPageHeight = $('#reportPage').innerHeight();
  var reportPageWidth = $('#reportPage').innerWidth();
  
  // create a new canvas object that we will populate with all other canvas objects
  var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
  });
  
  // keep track canvas position
  var pdfctx = $(pdfCanvas)[0].getContext('2d');
  var pdfctxX = 10;
  var pdfctxY = 10;
  var buffer = 200;
  
  // for each chart.js chart
  $("canvas").each(function(index) {
    // get the chart height/width
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();
    
    // draw the chart into the new canvas
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;
    
    // our report page is in a grid pattern so replicate that in the new canvas
    if (index % 2 === 1) {
      pdfctxX = 0;
      pdfctxY += canvasHeight + buffer;
    }
  });
  
  // create new pdf and add our new canvas as an image
  var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
  pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
  
  // download the pdf
  pdf.save('filename.pdf');
});
   
 </script>
@stop