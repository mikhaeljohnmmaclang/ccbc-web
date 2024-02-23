@extends('layouts.master')
@section('title', "Members")
@section('members', "active")
@section('specific-css')
<style>
    .f-poppins {
        font-family: poppins;
    }

    .name {
        font-size: 30px;
        color: black;
        font-weight: normal !important;
    }

    .custom-width{
        width: 90px;
        text-align: right;
    }

    @media (max-width:768px) {
        .name {
            font-size: 18px;
        }
    }

    @media (max-width:520px) {
        .name {
            font-size: 18px;
        }
    }
</style>
@endsection

@section('main_content')


<input type="hidden" id="member_id" value="{{ $member_data->id }}">

<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex bread-crumbs">
            <a class="mr-3" href="/members">Members</a>
            <span class="mx-3">/</span>
            <label>{{ ucfirst($member_data->first_name . " " . substr($member_data->middle_name, 0, 1) . ". " . $member_data->last_name) }}</label>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <h4 class="f-poppins text-primary mb-0">Member Information </h4>
        </div>
    </div>
    <!-- Member -->
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 my-2">
                <div class="d-flex align-items-center align-items-sm-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="user-avatar" class="d-block rounded" height="100" width="100">
                    <div class="d-flex flex-column">
                        <label class="name">{{ $member_data->first_name . " " . $member_data->middle_name . " " . $member_data->last_name }}</label>
                        <label class="address">
                            @if($member_data->address)
                            {{ $member_data->address }}
                            @else
                            <label class="text-italize">Address not defined</label>
                            @endif
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Email: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->email)
                                        {{ $member_data->email }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Contact No: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->contact_number)
                                        {{ $member_data->contact_number }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Gender: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->gender)
                                        {{ ucwords($member_data->gender) }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Age: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->birthdate)
                                        {{ \Carbon\Carbon::parse($member_data->birthdate)->age }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Birthdate: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->birthdate)
                                        {{ date("F j, Y", strtotime($member_data->birthdate)) }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex my-1 flex-column justify-content-center align-items-start">
                            <div class="d-flex w-100">
                                <div class="label me-3 custom-width">
                                    <label class="text-black">Occupation: </label>
                                </div>
                                <div class="label">
                                    <label> @if($member_data->occupation)
                                        {{ ucwords($member_data->occupation) }}
                                        @else
                                        <label class="text-italize">N/A</label>
                                        @endif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="card-body">

    </div>
    <!-- /Member -->
</div>


<div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations, {{ 
                            ucfirst($member_data->first_name)
                        }}! 🎉</h5>
                        <p class="mb-4">
                            You have commited almost <span class="fw-bold">{{ round($ff_percentage) }}%</span> of your Firstfruit. God bless you!
                        </p>
                        <p class="mb-2">
                            Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver.<br>

                        </p>
                        <p class="mb-3 fw-bold">
                            2 Corinthians 9:7
                        </p>

                        <!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> -->
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img 
                        @if($member_data->gender)
                        @if($member_data->gender == 'male')
                        src="
                        {{ asset('images/laptop.png') }}
                        "
                        @else
                        src="
                        {{ asset('images/girl2.png') }}
                        "
                        @endif
                        @else
                        src="
                        {{ asset('images/laptop.png') }}
                        "
                        @endif
                        height="140">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-4 col-md-4 order-1">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Firstfruit Commitment</h5>
                    <span class="badge bg-label-primary rounded-pill">Year {{ date('Y') }}</span>
                </div>
                <div class="mt-3">
                    <h4 class="mb-1">
                        @if($ff)
                        &#8369; {{ $ff }}
                        @else
                        No commitment declared
                        @endif
                    </h4>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Firstfruit Collection</h5>
                    <span class="badge bg-label-secondary rounded-pill">as of {{ date('F') }}</span>
                </div>
                <div class="mt-3">
                    <h4>
                        @if($ff)
                        @if($ff_collection)
                        &#8369; {{ $ff_collection }}
                        @else
                        No collected yet
                        @endif
                        @else
                        No commitment declared
                        @endif
                    </h4>
                    @if($ff_percentage < 20) <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-red" role="progressbar" style="width: {{$ff_percentage}}%" aria-valuenow="{{$ff_collection}}" aria-valuemin="0" aria-valuemax="100">{{round($ff_percentage)}}%</div>
                </div>
                @elseif($ff_percentage > 20 && $ff_percentage < 49) <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange" role="progressbar" style="width: {{$ff_percentage}}%" aria-valuenow="{{$ff_collection}}" aria-valuemin="0" aria-valuemax="100">{{round($ff_percentage)}}%</div>
            </div>
            @else
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-green" role="progressbar" style="width: {{$ff_percentage}}%" aria-valuenow="{{$ff_collection}}" aria-valuemin="0" aria-valuemax=" {{$ff}}">{{round($ff_percentage)}}%</div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0 me-2 pb-3">Total Offerings</h5>
                    <span class="badge bg-label-primary rounded-pill">as of {{ date('Y') }}</span>
                </div>
            </div>
            <div class="card-body">

                <!-- Table -->
                <table class="table" id="offering_summary">
                    <thead>
                        <tr>
                            <th>Ministry</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>
</div>





@endsection

@section('specific-js')
<script src="{{ asset('custom/js/view_member.js') }}" type="text/javascript"></script>
@endsection