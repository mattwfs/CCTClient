@extends('layouts.sales')
@section('main-content')
<div class="row">
    <select class="form-control" name="dashboard_sort" style="width:200px;">
        <option value="0">All Doctors</option>
        <option value="1">Test Doctor #1</option>
        <option value="1">Test Doctor #2</option>
        </select>

    </select>
</div>
<div class="row" style="margin-top:20px;">
    <div class="col-md-3"><b>New Studies</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>

    <div class="col-md-3"><b>Submissions</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Site Declined</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>PSVs</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
</div>
<div class="row" style="margin-top:40px;">
    <div class="col-md-3"><b>SIVs</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Awarded</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Not Awarded</b><br/>
        <span style="font-size:30px; font-weight:bold;">0</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
</div>
<div class="row" style="margin-top:40px;">
    <div class="col-md-3"><b>Clinics</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{$clinics}}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Reps</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{count(auth()->user()->sales_reps)}}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
</div>
<div class="row">
    <h2>Studies</h2>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart','bar']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        @foreach($applications as $application)
            google.charts.setOnLoadCallback(function(){drawFinanceChart("{{ $application->trial->title }}", {{ $application->id }}, {{ $application->budget }}, {{ (int)$finances[$application->trial->id] }})});
        @endforeach

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'New Studies - 0','Submissions - 0','Site Declined - 0','PSVs - 0','SIVs - 0','Awarded - 0','Not Awarded - 0'],
                ['February', 0, 0, 0, 0, 0, 0, 0]
            ]);

            var options = {
                chart: {
                    title: '',
                    subtitle: ''
                },
                bars: 'vertical' // Required for Material Bar Charts.
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));

            chart.draw(data, google.charts.Bar.convertOptions(options));


        }

        function drawFinanceChart(title, id, total, payments) {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Amount'],
                ['Payments - $'+payments, payments ],
                ['Budget Remaining - $'+(total-payments), (total-payments) ]
            ]);

            var options2 = {
                title: title+' - $'+ total+' Awarded',
                pieHole: 0.5,
                pieSliceTextStyle: {
                    color: 'black'
                },
                colors: ["#53d359","#ff0000"]
            };

            var chart = new google.visualization.PieChart(document.getElementById('finance'+id));
            chart.draw(data, options2);

        }

    </script>
    <div id="chart_div" style="height:400px;width:80%"></div>

</div>

<div class="row" style="margin-top:20px;">
    <h2>Finances</h2>
    @foreach($applications as $application)
    <div id="finance{{ $application->id }}" style="height:400px; width:30%"></div>
    @endforeach

</div>

@endsection

@section('page_title')
        Sales Dashboard
@endsection