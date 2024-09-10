@extends('layout.app')

@section('title')
    {{ __('Assistance Demand Details') }}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-xl-9 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Assistance Demand Details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>{{ __('First Name') }}: {{ $assistanceDemand->demand->first_name }}</h6>
                            <h6>{{ __('Last Name') }}: {{ $assistanceDemand->demand->last_name }}</h6>
                            <h6>{{ __('Email') }}: {{ $assistanceDemand->demand->email }}</h6>
                            <h6>{{ __('Region') }}: {{ $assistanceDemand->region }}</h6>
                            <h6>{{ __('Request Submitter') }}: {{ $assistanceDemand->requestSubmitter }}</h6>
                            <h6>{{ __('Phone Number') }}: {{ $assistanceDemand->demand->phone_number }}</h6>
                            <h6>{{ __('Date of Submission') }}: {{ $assistanceDemand->demand->created_at }}</h6>
                            @if($type)
                                <h6>{{ __('Type') }}: {{ $type->name }}</h6>
                            @endif

                            <div class="col-md-6 mt-3">
                                @if($assistanceDemand->demand->file)
                                    <img src="{{ asset('storage/uploads/demands/' . $assistanceDemand->demand->file) }}"
                                         alt="{{ $assistanceDemand->demand->first_name }}" class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($assistanceDemand->demand->voice_message)
                                    <audio controls>
                                        <source
                                            class="form-control"
                                            src="{{ asset('storage/uploads/demands/' . $lostPersonDemand->demand->voice_message)  }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
