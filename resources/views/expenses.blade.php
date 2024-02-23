@extends('layouts.master')
@section('title', "Expenses")
@section('expenses', "active")
@section('specific-css')
<style>
    .text-red {
        color: red !important;
    }
</style>
@endsection

@section('main_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Expenses</h4>
            <!-- hidden logged role -->
            <input type="hidden" disabled value="{{ Auth::user()->role }}" id="logged_role">
            <div class="">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal_add">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    Create new
                </button>
            </div>
        </div>
    </div>
    <div class="card-body overflow-auto">
        <!-- Table -->
        <table class="table" id="expenses_table">
            <thead>
                <tr>
                    <th>Voucher No.</th>
                    <th>Deducted From</th>
                    <th>Expense</th>
                    <th>Descriptions</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Recorded By</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- Create Modal -->
<div class="modal modal-top fade" data-bs-backdrop="static" id="modal_add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Create Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="add_form" method="post" action="{{ route('add_expense') }}">
                @csrf
                <div class="modal-body">

                    <!-- table -->
                    <input type="hidden" value="expenses" name="table" required>
                    <input type="hidden" value="{{ Auth::user()->id }}" name="recorded_by" required>

                    <div class="form-group mb-2">
                        <label class="form-label">Date<span class="text-red">*</span></label>
                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Voucher No<span class="text-red">*</span></label>
                        <input type="text" class="form-control" name="voucher_number" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Ministries<span class="text-red">*</span></label>
                          <!-- ministry list -->
                      @if(count($ministries) > 0)
                      <select name="ministries" class="form-control">
                        
                      @foreach($ministries as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                      @endforeach
                    </select>
                      @else
  
                      <div class="d-flex flex-column justify-content-center align-items-center">
                      <h5 class="text-danger">No Ministries found. Please Add ministry <a class="text-primary" href="{{ route('ministries') }}">here</a>.</h5>
                      </div>
                      @endif
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Name<span class="text-red">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Amount<span class="text-red">*</span></label>
                        <input type="number" step=".01" min="0" value="0"  class="form-control" name="amount">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Descriptions</label>
                        <textarea class="form-control" rows="6" name="descriptions"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="reset" class="btn btn-outline-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary" id="save_btn">Create new</button>
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_form" method="post" action="{{ route('edit') }}">
                @csrf
                <div class="modal-body">

                    <!-- hidden values for edit universal route -->
                    <input type="hidden" class="form-control" name="id" id="hidden_id_edit">
                    <input type="hidden" class="form-control" name="table" id="hidden_edit_in_table">


                    <div class="form-group mb-2">
                        <label class="form-label">Date<span class="text-red">*</span></label>
                        <input type="date" id="edit_date" value="{{ date('Y-m-d') }}" class="form-control" name="date" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Voucher No<span class="text-red">*</span></label>
                        <input type="text" id="edit_voucher_number" class="form-control" name="voucher_number" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Name<span class="text-red">*</span></label>
                        <input type="text" id="edit_name" class="form-control" name="name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Amount<span class="text-red">*</span></label>
                        <input type="number" step=".01" min="0" value="0" id="edit_amount" class="form-control" name="amount">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Descriptions</label>
                        <textarea id="edit_descriptions" class="form-control" rows="6" name="descriptions"></textarea>
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


    @endsection

    @section('specific-js')
    <script src="{{ asset('custom/js/expenses.js') }}" type="text/javascript"></script>
    @endsection