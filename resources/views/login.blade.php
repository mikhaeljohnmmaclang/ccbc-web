<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Christian Baptist Church of Caniogan Calumpit</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('images/icon.png')}}" />


    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('asset/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('asset/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('asset/css/theme-default.css')}}" class="template-customizer-theme-css" />
    {{-- <link rel="stylesheet" href="{{asset('asset/css/demo.css')}}" /> --}}

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('asset/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    {{--  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/parsley.css')}}" rel="stylesheet" type="text/css" />

     <link href="{{ asset('custom/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <!-- Page -->
    <link rel="stylesheet" href="{{asset('asset/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('asset/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('asset/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="my-3 justify-content-start">
                  <span class="app-brand-text demo text-body fw-bolder"><img src="{{ asset('images/logo.png') }}" width="15%"></span>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2 bold">Welcome to CCBC</h4>
              <p class="mb-4">Please sign-in to your account</p>

              <div id="msg"></div>

              <form class="mb-3" data-parsley-validate>
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input
                    type="text"
                    class="form-control"
                    name="email"
                    autofocus
                    autocomplete="off"
                    required
                    placeholder="email@mail.com"
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" >Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      class="form-control"
                      name="password"
                      autocomplete="off"
                      required
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" id="login_submit" type="submit">Sign in</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('asset/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('asset/libs/popper/popper.js')}}"></script>
    <script src="{{asset('asset/js/bootstrap.js')}}"></script>
    <script src="{{asset('asset/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('asset/js/menu.js')}}"></script>


    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('asset/js/main.js')}}"></script>

    {{-- <script src="{{asset('asset/js/ui-toasts.js')}}"></script> --}}


    {{-- <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/parsley.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>

    <!-- Nex Library -->
    <script src="{{ asset('js/nexlibrary.js') }}" type="text/javascript"></script>
    <script src="{{ asset('custom/js/login.js') }}" type="text/javascript"></script>

  </body>
</html>
