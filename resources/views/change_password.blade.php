@extends('layouts.master')
@section('title', "Change Password")
@section('maintenance', "active open")
@section('settings', "active")
@section('specific-css')
<style>

</style>
@endsection
@section('main_content')
<div class="card mb-4">
  <h5 class="card-header">Profile Details</h5>
  <!-- Account -->
  <div class="card-body">
    <div class="d-flex align-items-start align-items-sm-center gap-4">
      <img src="{{ asset('images/logo.png')}}" alt="user-avatar" class="d-block rounded" id="uploadedAvatar" width="100" height="100">
      <div class="container-fluid pl-0 ml-0">
        <h3 class="mb-3">{{ Auth::user()->name }}</h3>
        <p class="text-muted mb-0">{{ Auth::user()->role }}</p>
      </div>
      <div class="d-none button-wrapper">
        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
          <span class="d-none d-sm-block">Upload new photo</span>
          <i class="bx bx-upload d-block d-sm-none"></i>
          <input type="file" id="upload" class="account-file-input" accept="image/png, image/jpeg" hidden="">
        </label>
        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
          <i class="bx bx-reset d-block d-sm-none"></i>
          <span class="d-none d-sm-block">Reset</span>
        </button>

        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
      </div>
    </div>
  </div>

  <hr class="my-0">

  <div class="card-body">

    <h4 class="text-primary bold">Change Password</h4>
    <form method="POST" id="change_password_form" action="{{ route('change_pass') }}" data-parsley-validate>
      @csrf

      <div class="mb-3 col-md-6">
        <label class="form-label">Old Password</label>
        <input class="form-control" type="password" name="old_password" placeholder="Enter old password" required data-parsley-required>
      </div>

      <div class="mb-3 col-md-6">
        <label class="form-label">New Password</label>
        <input type="password" data-parsley-trigger="keyup" required name="new_password" id="new_password" class="form-control" placeholder="Enter new password" data-parsley-required minlength="6">
      </div>

      <div class="mb-3 col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" data-parsley-trigger="keyup" name="confirm_password" id="confirm_password" required class="form-control" placeholder="Enter confirm password" data-parsley-required="" data-parsley-equalto="#new_password" data-parsley-equalto-message="This value should be the same to the new password.">
      </div>

      <div class="mt-2">
        <button type="submit" class="btn btn-primary me-2" id="save_btn">Save changes</button>
        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
      </div>
    </form>
  </div>
  <!-- /Account -->
</div>

</div>
@endsection

@section('specific-js')
<script src="{{ asset('custom/js/change_pass.js')}}" type="text/javascript"></script>
@endsection