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
                            <h6>
                                {{__('location')}} : {{$lostPersonDemand->location}}
                            </h6>
                            @if ($lostPersonDemand->group_type === 'group')
                            <h6>
                                {{ __('Number of Missing People') }}: {{ $lostPersonDemand->number_of_missing_persons }}
                            </h6>
                            @endif
                            <div class="col-md-6">
                                @if($lostPersonDemand->demand->file)
                                    <img src="{{ asset('storage/uploads/demands/' . $lostPersonDemand->demand->file) }}" alt="{{ $lostPersonDemand->demand->file }}" class="img-fluid">
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
                            @if(auth()->user()->is_admin)
                                <div class="card-body">
                                    <form id="typeChangeForm" method="POST" action="{{ route('demand.changeType', $lostPersonDemand->demand->id) }}">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label for="demand_type">{{ __('Select Demand Type') }}</label>
                                            <select name="demand_type" id="demand_type" class="form-control">
                                                <option value="App\Models\TestimonyDemand" {{ $lostPersonDemand->demand->demandable_type == 'App\Models\TestimonyDemand' ? 'selected' : '' }}>Testimony</option>
                                                <option value="App\Models\AssistanceDemand" {{ $lostPersonDemand->demand->demandable_type == 'App\Models\AssistanceDemand' ? 'selected' : '' }}>Assistance</option>
                                                <option value="App\Models\LostPersonDemand" {{ $lostPersonDemand->demand->demandable_type == 'App\Models\LostPersonDemand' ? 'selected' : '' }}>Lost Person</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Change Type') }}</button>
                                    </form>
                                </div>
                            @endif

                            @if ($lostPersonDemand->demand->status == 'pending')

{{--                                <form method="POST" action="{{ route('lostPerson.cloture', $lostPersonDemand->demand->id) }}" style="display: inline;">--}}
{{--                                    @csrf--}}
{{--                                    @method('PATCH')--}}
{{--                                    <button type="submit" class="btn btn-success">{{ __('treated') }}</button>--}}
{{--                                </form>--}}



                                @if ($lostPersonDemand->demand->status == 'pending' && auth()->user()->is_admin)

                                    <form id="sharedForm" method="get"
                                          action="{{route('lostPerson.assignLostPersonDemandToUser.create',$lostPersonDemand->id)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('GET')

                                        <div class="col-md-12 mt-4">
                                            <button type="submit" class="btn btn-success">{{ __('assign_to_user') }}</button>
                                        </div>


                                    </form>

                                @endif

                            @endif


                        </div>
                    </div>
                </div>
            </div>




















            <br>
            @if ($lostPersonDemand->demand->status != 'pending')

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('partner response') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            @if(!auth()->user()->is_admin && (!optional($partnerDecision)->status || !in_array($partnerDecision->status, ['accepted', 'refused'])))
                                <div class="col-md-12 mt-4">
                                    <form id="sharedForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="comment">{{ __('Comment') }}</label>
                                            <textarea name="comment" id="comment" class="form-control"
                                                      rows="4"></textarea>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="file">{{ __('Upload File') }}</label>
                                            <input type="file" name="file" id="file" class="form-control-file">
                                        </div>

                                        <button type="button" class="btn btn-success mt-3"
                                                onclick="submitForm('{{ route('lostPerson.treated', $partnerDecision->id) }}')">{{ __('Accepter') }}</button>
                                        <button type="button" class="btn btn-danger mt-3"
                                                onclick="submitForm('{{ route('lostPerson.notreated', $partnerDecision->id) }}')">{{ __('Refuser') }}</button>
                                    </form>
                                </div>

                                <script>
                                    function submitForm(action) {
                                        const form = document.getElementById('sharedForm');
                                        form.action = action;
                                        form.submit();
                                    }
                                </script>

                            @endif

{{--                            @if ($lostPersonDemand->demand->status != 'pending' && auth()->user()->is_admin)--}}
                                @if ($lostPersonDemand->demand->status != 'pending'
  //     && auth()->user()->is_admin
       && in_array($partnerDecision->status, ['accepted', 'refused','closed']))
                                <div class="mt-4">
                                    {{--                                <h5>{{ __('Partner Response') }}</h5>--}}
                                    <p>{{ __('partner_name') }}: {{ $user_name }}</p>

                                    <p>{{ __('Comment') }}
                                        : {{ $partnerDecision->comment ?: __("Awaiting partner's response .... ") }}</p>
                                    @if($partnerDecision->file)
                                        <a href="{{ asset('storage/uploads/demands/' . $partnerDecision->file) }}"
                                           download>{{ __('Download File') }}</a>
                                    @endif
                                </div>

                            @endif


                        </div>
                    </div>
                </div>

            @endif
            <br>
            @if ($lostPersonDemand->demand->status != 'pending' &&  $lostPersonDemand->demand->status != 'done' && auth()->user()->is_admin)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('admin response') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <form id="sharedForm" method="post"
                                      action="{{ route('lostPerson.cloture', $partnerDecision->id)}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="admin_comment">{{ __('admin_comment') }}</label>
                                        <textarea name="admin_comment" id="admin_comment" class="form-control"
                                                  rows="4"></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="partner_decision_file">{{ __('Upload File') }}</label>
                                        <input type="file" name="partner_decision_file" id="partner_decision_file"
                                               class="form-control-file">
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-success">{{ __('cloture') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
@endsection
