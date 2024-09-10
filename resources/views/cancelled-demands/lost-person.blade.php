@extends('layout.app')

@section('title')
    {{ __('Lost Person Demand Details') }}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Lost Person Demand Details') }}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                {{ __('first_name') }}: {{ $lostPersonDemand->demand->first_name }}
                            </h6>
                            <h6>
                                {{ __('last_name') }}: {{ $lostPersonDemand->demand->last_name }}
                            </h6>
                            <h6>
                                {{ __('Region') }}: {{ $lostPersonDemand->region }}
                            </h6>
                            <h6>
                                {{ __('Notification Sender') }}: {{ $lostPersonDemand->notification_sender }}
                            </h6>
                            <h6>
                                {{ __('Missing Person Gender') }}: {{ $lostPersonDemand->missing_person_gender }}
                            </h6>
                            <h6>
                                {{ __('Missing Person Age') }}: {{ $lostPersonDemand->missing_person_age }}
                            </h6>
                            <h6>
                                {{ __('Nationality') }}: {{ $lostPersonDemand->nationality }}
                            </h6>
                            <h6>
                                {{ __('Description') }}: {{ $lostPersonDemand->demand->description }}
                            </h6>
                            <h6>
                                {{ __('Phone Number') }}: {{ $lostPersonDemand->demand->phone_number }}
                            </h6>
                            <h6>
                                {{ __('Date of Submission') }}: {{ $lostPersonDemand->demand->created_at }}
                            </h6>
                            <h6>
                                {{ __('Status') }}: {{ ucfirst($lostPersonDemand->demand->status) }}
                            </h6>
                            <h6>
                                {{ __('Type of missing person') }}: {{ $lostPersonDemand->group_type }}
                            </h6>
                            @if ($lostPersonDemand->group_type === 'group')
                                <h6>
                                    {{ __('Number of Missing People') }}
                                    : {{ $lostPersonDemand->number_of_missing_persons }}
                                </h6>
                            @endif
                            <div class="col-md-6">
                                @if($lostPersonDemand->demand->file)
                                    <img src="{{ asset('storage/uploads/demands/' . $lostPersonDemand->demand->file) }}"
                                         alt="{{ $lostPersonDemand->demand->file }}" class="img-fluid">
                                @endif
                            </div>

                            <div class="col-md-6">
                                @if($lostPersonDemand->demand->voice_message)
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
