@extends('layouts.master')
@section('title', "Transactions")
@section('transactions', "active")
@section('specific-css')
<style>
    .text-red {
        color: red !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection

@section('main_content')
<input type="hidden" id="has_msg" value="{{ $msg }}">
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Transactions</h4>
            <!-- hidden logged role -->
            <input type="hidden" disabled value="{{ Auth::user()->role }}" id="logged_role">
            <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#generate_reports">
                <i class="fa fa-file-pdf me-2" aria-hidden="true"></i> Generate Report
            </button>
        </div>
    </div>
    <div class="card-body overflow-auto">
        <!-- Table -->
        <table class="table" id="transactions_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Member</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>




<!-- Generate Reports -->
<div class="modal modal-top fade" id="generate_reports" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Generate Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="generate_reports_form">
                @csrf
                <div class="modal-body">
                    <form>

                        <div class="form-group mb-2">
                            <label class="form-label">Service:</label><br>
                            @if(count($services) > 0)

                            <select class="form-control text-primary semi-bold" id="service_filter" name="service">
                                <option selected value="ALL">ALL</option>
                                @foreach($services as $s)
                                <option value="{{  $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @else
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h5 class="text-danger">No Service found. Please add service <a class="text-primary" href="{{ route('services') }}">here</a>.</h5>
                            </div>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Filter Dates: <label class="text-danger">*[Default: today]</label></label><br>
                            <input class="form-control" type="text" id="date_range_report" name="daterange" />
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Aphabetical Order: </label><br>
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="is_alphabetical" id="sort_yes" checked="" autocomplete="off">
                              <label class="btn btn-outline-primary" for="sort_yes">Yes</label>
                              <input type="radio" class="btn-check" name="is_alphabetical" id="sort_no" autocomplete="off">
                              <label class="btn btn-outline-primary" for="sort_no">No</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary" id="generate_btn">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal modal-top fade" id="modal_edit" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Edit Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_form" method="post" action="{{ route('edit_transaction') }}">
                @csrf
                <div class="modal-body">

                    <!-- member id -->
                    <input type="hidden" id="hidden_transaction_id" name="transaction_id">

                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label semi-bold me-3 text-primary">Date</label>
                        </div>
                        <input id="edit_date" type="date" name="date" class="form-control">
                    </div>

                    <!-- services list -->
                    @if($services)
                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label semi-bold me-3 text-primary">Service</label>
                        </div>
                        <select class="form-control text-primary semi-bold" id="edit_transaction_service" name="service">
                            @foreach($services as $s)
                            <option value="{{  $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else

                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h3>No Service found. Please add service <a href="{{ route('services') }}">here</a>.</h3>
                    </div>
                    @endif


                    <!-- ministry list -->
                    @if($ministries)
                    @foreach($ministries as $m)
                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label me-3">{{ $m->name }}</label>
                        </div>
                        <input type="hidden" value="{{ $m->id }}" name="m_id[]">
                        <input id="ministry_{{ $m->id }}" type="number" step=".01" min="0" value="0" class="form-control offering-amount" name="amount[]">
                    </div>
                    @endforeach
                    @else

                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h3>No Ministries found. Please Add ministry <a href="{{ route('ministries') }}">here</a>.</h3>
                    </div>
                    @endif

                    <!-- Reference Offering Data -->
                    @if($ministries)
                    @foreach($ministries as $m)
                    <input id="ref_ministry_{{ $m->id }}" type="hidden" readonly class="form-control text-red" name="ref_amount[]">
                    @endforeach
                    @endif

                    <div class="d-flex align-items-center justify-content-stretch">
                        <div style="width: 35%">
                            <label class="form-label text-primary me-3">[Others]-Remarks</label>
                        </div>
                        <input type="text" class="form-control" id="edit_remarks" name="remarks" placeholder="Enter remarks">
                    </div>

                    <div class="d-flex align-items-center justify-content-stretch mt-4 my-2">
                        <div style="width: 26%">
                            <h4 class="form-label me-3 semi-bold  text-primary">Total</h4>
                        </div>
                        <h5 id="edit_total" class="text-primary semi-bold">123123</h5>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="reset" class="btn btn-outline-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary" id="update_btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('specific-js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('custom/js/transactions.js') }}" type="text/javascript"></script>
@endsection