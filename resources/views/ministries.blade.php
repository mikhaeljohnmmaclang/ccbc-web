@extends('layouts.master')
@section('title', "Ministries")
@section('ministries', "active")
@section('specific-css')
@endsection

@section('main_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Ministries</h4>
            <!-- hidden logged role -->
            <input type="hidden" disabled value="{{ Auth::user()->role }}" id="logged_role">
            @if(Auth::user()->role == 'Admin')
            <div class="">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal_add">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    Create new
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <!-- Table -->
        <table class="table" id="ministries_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Funds</th>
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Create Ministry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="add_form" method="post" action="{{ route('add') }}">
                @csrf
                <div class="modal-body">

                    <!-- table -->
                    <input type="hidden" value="ministries" name="table" required>

                    <div class="form-group mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Edit Ministry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_form" method="post" action="{{ route('edit') }}">
                @csrf
                <div class="modal-body">

                    <!-- hidden values for edit universal route -->
                    <input type="hidden" class="form-control" name="id" id="hidden_id_edit">
                    <input type="hidden" class="form-control" name="table" id="hidden_edit_in_table">

                    <div class="form-group mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
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
    <script src="{{ asset('custom/js/ministries.js') }}" type="text/javascript"></script>
    @endsection