@extends('layout.app')

@section('title')
    {{ __('testimony_demand_details') }}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('testimony_demand_details') }}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                {{ __('First Name') }}: {{ $testimonyDemand->demand->first_name }}
                            </h6>
                            <h6>
                                {{ __('Last Name') }}: {{ $testimonyDemand->demand->last_name }}
                            </h6>
                            <h6>
                                {{ __('Email') }}: {{ $testimonyDemand->demand->email }}
                            </h6>
                            <h6>
                                {{ __('Phone Number') }}: {{ $testimonyDemand->demand->phone_number }}
                            </h6>
                            <h6>
                                {{ __('Description') }}: {{ $testimonyDemand->demand->description }}
                            </h6>
                            @if($type)
                                <h6>
                                    {{ __('type') }}: {{ $type->name }}
                                </h6>
                            @endif

                            <div class="col-md-6">
                                @if($testimonyDemand->demand->file)
                                    <img src="{{ asset('storage/uploads/demands/' . $testimonyDemand->demand->file) }}"
                                         alt="{{ $testimonyDemand->demand->first_name }}" class="img-fluid">
                                @endif
                            </div>

                            <div class="col-md-6">
                                @if($testimonyDemand->demand->voice_message)
                                    <audio controls>
                                        <source
                                            class="form-control"
                                            src="{{ asset('storage/uploads/demands/' . $testimonyDemand->demand->voice_message)  }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <br>

        </div>
    </div>
@endsection
