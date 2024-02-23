@extends('layouts.master')
@section('title', "Dashboard")
@section('dashboard', "active")
@section('specific-css')
<link rel="stylesheet" href="{{ asset('asset/vendor/libs/apex-charts/apex-charts.css')}}" />
<style>
  /* style here */
  .activity-logs {
    overflow: auto;
    height: 450px !important;
  }
</style>
@endsection
@section('main_content')

<div class="row">
  <!-- Total Revenue -->
  <div class="col-md-12">

    <!-- Total FirstFruits this Year -->
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Total Firstfruits</h5>
              <span class="badge bg-label-info rounded-pill">Year {{$firstfruits_year }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title mb-2">&#8369 {{ number_format($firstfruits) }}</h3>
            </div>
          </div>
        </div>
      </div>
      <!-- Total FirstFruits Collection -->
      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Total Collections</h5>
              @php
              $ff_collection_percentage = 0;
              @endphp
              @if($firstfruits == 0 || $firstfruits == null)
              @php
              $ff_collection_percentage = 0;
              @endphp
              @else
              @php
              $ff_collection_percentage = ($total_ff_collection / $firstfruits)*100
              @endphp
              @endif

              @if($ff_collection_percentage < 40) <span class="badge bg-danger-light text-red rounded-pill">{{ round($ff_collection_percentage) }}%</span>
                @elseif($ff_collection_percentage > 40 && $ff_collection_percentage < 70 ) <span class="badge bg-warning-light text-orange rounded-pill">{{ round($ff_collection_percentage) }}%</span>
                  @else
                  <span class="badge bg-primary text-white rounded-pill">{{ round($ff_collection_percentage) }}%</span>
                  @endif
            </div>
            <h3 class="card-title mb-2">&#8369; {{ number_format($total_ff_collection) }}</h3>
          </div>
        </div>
      </div>
      <!-- Total Church Funds this Year -->
      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Church Funds</h5>
              <span class="badge bg-label-primary rounded-pill">as of {{ date('Y') }}</span>
            </div>
            <h3 class="card-title mb-2">&#8369; {{ $church_funds }}</h3>
          </div>
        </div>
      </div>
      <!-- Total Member -->
      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Members</h5>

            </div>
            <h3 class="card-title mb-2">{{ $member_count }}</h3>
          </div>
        </div>
      </div>
    </div>
    <br />
  </div>
</div>

<div class="row">
  <!-- Offerings -->
  <div class="col-md-7 mb-4  h-100">
    <!-- notifs -->
    <div class="card">
      <div class="card-header bg-primary d-flex justify-content-between">
        <h5 class="semi-bold text-white m-0">Monthly Offerings </h5>
        <span class="badge bg-label-primary rounded-pill">as of {{ date('F') }}</span>
      </div>
      <div id="data_offerings"></div>
    </div>


  </div>
  <div class="col-md-5 mb-4 h-100">
    <!-- Expenses -->
    <div class="card">
      <div class="card-header bg-primary d-flex justify-content-between">
        <h5 class="semi-bold text-white m-0">Weekly Expenses </h5>
        <span class="badge bg-label-primary rounded-pill">as of {{ date('F') }}</span>
      </div>
    </div>
    <div class="bg-white h-100 justify-content-center d-flex">
      <div id="data_expenses"></div>
    </div>
  </div>

</div>

<div class="row">
  <!-- Offerings -->
  <div class="col-md-5 mb-4  h-100">
    <!-- notifs -->
    <div class="card">
      <div class="card-header bg-primary d-flex justify-content-between">
        <h5 class="semi-bold text-white m-0">Ministries Funds </h5>
        <span class="badge bg-label-primary rounded-pill">as of {{ date('Y') }}</span>
      </div>
      <div class="d-flex flex-column justify-content-center align-items-center py-3">
        <div id="data_ministries"></div>
      </div>
    </div>


  </div>
  <div class="col-md-7 mb-4 h-100">
    <!-- Expenses -->
    <div class="card">
      <div class="card-header bg-primary">
        <h5 class=" semi-bold text-white m-0">Activity Logs</h5>
      </div>
    </div>
    <div class="bg-white h-100 justify-content-center d-flex flex-column align-items-center activity-logs">
      <div class="card w-100 h-100">
        <div class="card-body overflow-auto" id="activity_logs_list">
          <!-- Activity Logs List -->
        </div>
      </div>
    </div>
  </div>

</div>



@endsection

@section('specific-js')
<!-- <script src="{{ asset('asset/js/dashboards-analytics.js') }}" type="text/javascript"></script>  -->
<script src="{{ asset('custom/js/dashboard.js') }}" type="text/javascript"></script>
@endsection