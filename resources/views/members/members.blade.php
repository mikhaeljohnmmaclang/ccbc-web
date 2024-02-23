@extends('layouts.master')
@section('title', "Members")
@section('members', "active")
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
            <h4 class="text-primary mb-0 semi-bold">Members</h4>
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
    <div class="card-body">
        <!-- Table -->
        <table class="table" id="members_table">
            <thead>
                <tr>
                    <th>Name</th>
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Create Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="add_form" method="post" action="{{ route('add_member') }}">
                @csrf
                <div class="modal-body">

                    <!-- table -->
                    <input type="hidden" value="members" name="table" required>

                    <div class="form-group mb-2">
                        <label class="form-label">First Name<span class="text-red">*</span></label>
                        <input type="text" id="create_first_name" class="form-control" name="first_name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="create_middle_name" class="form-control" name="middle_name">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Last Name<span class="text-red">*</span></label>
                        <input type="text" id="create_last_name" class="form-control" name="last_name" data-parsley-remote data-parsley-remote-validator='check_unique_member_name' data-parsley-trigger="keyup" data-parsley-remote-message="Member already exists." required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Birthdate</label>
                        <input type="date" class="form-control" name="birthdate">
                    </div>


                    <div class="form-group mb-2">
                        <label class="form-label">Gender</label> <br>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" value="male" name="gender" id="male" autocomplete="off">
                            <label class="btn btn-outline-primary" for="male">Male</label>
                            <input type="radio" class="btn-check" value="female" name="gender" id="female" autocomplete="off">
                            <label class="btn btn-outline-primary" for="female">Female</label>

                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Contact Number</label>
                        <input type="text" minlength="11" maxlength="11" pattern="^(09|\+639)\d{9}$" class="form-control" name="contact_number">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Address</label>
                        <textarea cols="4" class="form-control" name="address"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Occupation</label>
                        <input type="text" class="form-control" name="occupation">
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Edit Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_form" method="post" action="{{ route('edit') }}">
                @csrf
                <div class="modal-body">

                    <!-- hidden values for edit universal route -->
                    <input type="hidden" class="form-control" name="id" id="hidden_id_edit">
                    <input type="hidden" class="form-control" name="table" id="hidden_edit_in_table">

                    <div class="form-group mb-2">
                        <label class="form-label">First Name<span class="text-red">*</span></label>
                        <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" id="edit_middle_name">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Last Name<span class="text-red">*</span></label>
                        <input type="text" class="form-control" name="last_name" id="edit_last_name" data-parsley-remote data-parsley-remote-validator='check_unique_member_name_edit' data-parsley-trigger="keyup" data-parsley-remote-message="Choose another name. This name already exists." required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="edit_email">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="edit_birthdate" name="birthdate">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Gender</label> <br>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" value="male" name="gender" id="male_edit" autocomplete="off">
                            <label class="btn btn-outline-primary" for="male_edit">Male</label>
                            <input type="radio" class="btn-check" value="female" name="gender" id="female_edit" autocomplete="off">
                            <label class="btn btn-outline-primary" for="female_edit">Female</label>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Contact Number</label>
                        <input type="number" id="edit_contact" minlength="11" pattern="^(09|\+639)\d{9}$" class="form-control" name="contact_number">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Address</label>
                        <textarea cols="4" id="edit_address" class="form-control" name="address"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Occupation</label>
                        <input type="text" id="edit_occupation" class="form-control" name="occupation">
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

<!-- Add Offering -->
<div class="modal modal-top fade" data-bs-backdrop="static" id="modal_add_offerings" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Add Offerings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="add_offering_form" method="post" action="{{ route('add_transaction') }}">
                @csrf
                <div class="modal-body">

                    <!-- member id -->
                    <input type="hidden" id="hidden_member_id" name="member_id">


                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label semi-bold me-3 text-primary">Date</label>
                        </div>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <!-- services list -->
                    @if(count($services) > 0)
                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label semi-bold me-3 text-primary">Service</label>
                        </div>
                        <select class="form-control text-primary semi-bold" name="service">
                            @foreach($services as $s)
                            <option value="{{  $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h5 class="text-danger">No Service found. Please add service <a class="text-primary" href="{{ route('services') }}">here</a>.</h5>
                    </div>
                    @endif


                    <!-- ministry list -->
                    @if(count($ministries) > 0)
                    @foreach($ministries as $m)
                    <div class="d-flex align-items-center justify-content-stretch my-2">
                        <div style="width: 35%">
                            <label class="form-label me-3">{{ $m->name }}</label>
                        </div>
                        <input type="hidden" value="{{ $m->id }}" name="m_id[]">
                        <input type="number" step=".01" min="0" value="0" class="form-control offering-amount" name="amount[]">
                    </div>
                    @endforeach
                    @else

                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h5 class="text-danger">No Ministries found. Please Add ministry <a class="text-primary" href="{{ route('ministries') }}">here</a>.</h5>
                    </div>
                    @endif

                    <div class="d-flex align-items-center justify-content-stretch">
                        <div style="width: 35%">
                            <label class="form-label text-primary me-3">[Others]-Remarks</label>
                        </div>
                        <input type="text" class="form-control" name="remarks" placeholder="Enter remarks">
                    </div>

                    <div class="d-flex align-items-center justify-content-stretch mt-4 my-2">
                        <div style="width:35%">
                            <h4 class="form-label me-3 semi-bold  text-primary">Total:</h4>
                        </div>
                        <h5 id="total_offering" class="text-primary semi-bold">0.00</h5>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="reset" class="btn btn-outline-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary" id="save_offering">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Set Firstfruit -->
<div class="modal modal-top fade" data-bs-backdrop="static" id="modal_set_ff" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Set Firstfruit Commitment - {{ date('Y') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="edit_ff_form" method="post" action="{{ route('set_member_firstfruit') }}">
                @csrf
                <div class="modal-body">

                    <!-- member id -->
                    <input type="hidden" id="hidden_ff_member_id" name="id">
                    <input type="hidden" id="hidden_commitment_id" name="commitment_id">


                    <div class="form-group mb-2">
                        <label class="form-label">Amount:<span class="text-red">*</span></label>
                        <input id="ff_amount" type="number" class="form-control" name="amount" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="reset" class="btn btn-outline-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary" id="save_ff">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection

@section('specific-js')
<script src="{{ asset('custom/js/members.js') }}" type="text/javascript"></script>
@endsection