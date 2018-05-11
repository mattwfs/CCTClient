@extends('layouts.users')
@section('main-content')
<div class="row">

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Training Instructions</div>
        <div class="panel-body">
            <p>Welcome to the Conduct Clinical Trials Training Portal. We specialize in research naive sites and have tailored this training especially for you.<br/><br/>Click on a link below and it will open a new tab or window to take you to the training for each topic.</p>
        </div>

        <!-- List group -->
        <ul class="list-group">
            <li class="list-group-item"><a href="/training/gcp/story_html5.html" target="_blank">GCP Training <span style="color:red">(Mandatory for ALL Study Staff)</span></a><span style="float:right">(Estimated time to complete: 3 hours)</span></li>
            <li class="list-group-item"><a href="/training/investigator-training/story_html5.html" target="_blank">Investigator Training <span style="color:red;">(Highly Recommended for Principal & Sub-Investigators)</span></a></li>
            <li class="list-group-item"><a href="/training/study-coordinator/story_html5.html" target="_blank"">Study Coordinator Training <span style="color:red;">(Mandatory)</span></a></li>
            <li class="list-group-item"><a href="/training/patient-recruitment-strategies/story_html5.html" target="_blank">Patient Recruitment Strategies <span style="color:red;">(Highly Recommended)</span></a></li>
        </ul>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Resources</div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item"><a href="{{asset('assets/CCTSOPS_Revised_2016.docx')}}" target="_blank">SOPs</a></li>
                <li class="list-group-item"><a href="{{asset('assets/TempLog.pdf')}}" target="_blank">Temperature Log</a></li>
            </ul>

        </div>
    </div>
    @endsection

    @section('page_title')
    Training Portal
    @endsection