@extends('layouts.master')
@section('title', "Users")
@section('maintenance', "active open")
@section('users', "active")
@section('specific-css')
<style>

</style>
@endsection
@section('main_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Users</h4>

            <div class="">
                    <button  class="btn btn-primary"
                      type="button"
                      data-bs-toggle="modal" data-bs-target="#modal_add">
                      <i class="menu-icon tf-icons bx bx-plus"></i>
                      Create new
                    </button>
                </div>
        </div>
    </div>

    <div class="card-body overflow-auto">
        <!-- Table -->
        <table class="table" id="users_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th></th>
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
        <h5 class="modal-title bold text-primary" id="modalTopTitle">Create User</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>

      <form id="add_form" method="post" action="{{ route('add_user') }}">
            @csrf
            <div class="modal-body">

                 <!-- table -->
                <input type="hidden" value="users" name="table" required>

                <div class="form-group mb-2">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" required 
                    data-parsley-required data-parsley-remote 
                    data-parsley-remote-validator='check_unique_email' 
                    data-parsley-trigger="keyup" data-parsley-remote-message="Email already exists.">
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="role" required>
                        <option selected disabled>Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                    </select>
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
            <h5 class="modal-title bold text-primary" id="modalTopTitle">Edit User</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
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
               
                        <div class="form-group mb-2">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required 
                            data-parsley-required data-parsley-remote 
                            data-parsley-remote-validator='check_unique_email_edit' 
                            data-parsley-trigger="keyup" data-parsley-remote-message="Email already exists.">
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="Director">Director</option>
                                <option value="Admin">Admin</option>
                            </select>
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


<!-- Reset Modal -->
<div class="modal  fade" id="modal_reset" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title bold text-primary" id="backDropModalTitle">Reset User</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
         <form id="reset_pass_form" method="post" action="{{ route('reset_pass') }}">
              @csrf
              <div class="modal-body">  
                  <input type="hidden" class="form-control" name="id" id="reset_pass_id">


                   <div class="text-center">
                        <h1><i class="fa fa-lock-open"></i></h1>
                        
                        <h4>Are you sure?</h4>
                        <span> Do you realy want to reset this account?</span>
                        <br/>
                        <span>
                            <label class="form-label">Default Password  <span class="semi-bold">123456</span></label>

                        </span>
                    </div>

                  {{-- <div class="form-group mb-0">
                      <label class="form-label">Default Password: <b class="f-s11">123456</b></label>
                      <br/>
                      <label id="reset_pass_label">Are you sure you want to reset password this account?</label>
                  </div> --}}
              </div>
          

              <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                  <button type="submit" class="btn btn-primary" id="reset_btn">Reset</button>
              </div>
          </form>
      </div>
  </div>
</div>






@endsection

@section('specific-js')
<script src="{{ asset('custom/js/users.js') }}" type="text/javascript"></script>
@endsection