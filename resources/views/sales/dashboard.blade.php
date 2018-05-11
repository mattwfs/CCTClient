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
        <span style="font-size:30px; font-weight:bold;">{{ count($trials) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>

    <div class="col-md-3"><b>Submissions</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($submissions) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Site Declined</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($site_declined) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>PSVs</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($psvs) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
</div>
<div class="row" style="margin-top:40px;">
    <div class="col-md-3"><b>SIVs</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($psvs) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Awarded</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($awarded) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Sponsor Declined</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($not_awarded) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
</div>
<div class="row" style="margin-top:40px;">
    <div class="col-md-3"><b>Sites</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($sites) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
        <small>Difference: 100%</small>
    </div>
    <div class="col-md-3"><b>Users</b><br/>
        <span style="font-size:30px; font-weight:bold;">{{ count($users) }}</span> <i class="fa fa-angle-up fa-2x" style="vertical-align:middle; margin-top:-3px; color:green;"></i><br/>
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

        @if($finances)
        @foreach($applications as $application)
            google.charts.setOnLoadCallback(function(){drawFinanceChart("{{ $application->trial->title }}", {{ $application->id }}, {{ $application->budget }}, {{ (int)$finances[$application->trial->id] }})});
        @endforeach
        @endif
        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'New Studies','Submissions','Site Declined','PSVs','SIVs','Awarded','Not Awarded'],
                ['February', {{ count($trials) }},{{ count($submissions) }},{{ count($site_declined) }},{{ count($psvs) }},{{ count($sivs) }},{{ count($awarded) }},{{ count($not_awarded) }}]
        ]);

        var options = {
            chart: {
                title: 'Studies',
                subtitle: '',
                chartArea: {'padding': '20px'}
            },
            bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));

        chart.draw(data, options);
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