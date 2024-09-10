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
                                            src="{{ asset('storage/uploads/demands/' . $assistanceDemand->demand->voice_message)  }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            </div>
                            @if(auth()->user()->is_admin)
                                <div class="card-body">
                                    <form id="typeChangeForm" method="POST" action="{{ route('demand.changeType', $assistanceDemand->demand->id) }}">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label for="demand_type">{{ __('Select Demand Type') }}</label>
                                            <select name="demand_type" id="demand_type" class="form-control">
                                                <option value="App\Models\TestimonyDemand" {{ $assistanceDemand->demand->demandable_type == 'App\Models\TestimonyDemand' ? 'selected' : '' }}>Testimony</option>
                                                <option value="App\Models\AssistanceDemand" {{ $assistanceDemand->demand->demandable_type == 'App\Models\AssistanceDemand' ? 'selected' : '' }}>Assistance</option>
                                                <option value="App\Models\LostPersonDemand" {{ $assistanceDemand->demand->demandable_type == 'App\Models\LostPersonDemand' ? 'selected' : '' }}>Lost Person</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Change Type') }}</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        @if ($assistanceDemand->demand->status == 'pending' && auth()->user()->is_admin)
                            <form id="assignForm" method="get"
                                  action="{{ route('assistance.assignAssistanceDemandToUser.create', $assistanceDemand->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('GET')
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-success">{{ __('Assign to User') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>

                    @if ($assistanceDemand->demand->status != 'pending')
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Partner Response') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if(!auth()->user()->is_admin && (!optional($partnerDecision)->status || !in_array($partnerDecision->status, ['accepted', 'refused'])))
                                        <div class="col-md-12 mt-4">
                                            <form id="partnerResponseForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="comment">{{ __('Comment') }}</label>
                                                    <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="file">{{ __('Upload File') }}</label>
                                                    <input type="file" name="file" id="file" class="form-control-file">
                                                </div>
                                                <button type="button" class="btn btn-success mt-3"
                                                        onclick="submitForm('{{ route('assistance.treated', $partnerDecision->id) }}')">{{ __('Accept') }}</button>
                                                <button type="button" class="btn btn-danger mt-3"
                                                        onclick="submitForm('{{ route('assistance.notreated', $partnerDecision->id) }}')">{{ __('Reject') }}</button>
                                            </form>
                                            <script>
                                                function submitForm(action) {
                                                    const form = document.getElementById('partnerResponseForm');
                                                    form.action = action;
                                                    form.submit();
                                                }
                                            </script>
                                        </div>
                                    @endif

                                    @if ($assistanceDemand->demand->status != 'pending' && in_array($partnerDecision->status, ['accepted', 'refused', 'closed']))
                                        <div class="mt-4">
                                            <p>{{ __('Partner Name') }}: {{ $user_name }}</p>
                                            <p>{{ __('Comment') }}: {{ $partnerDecision->comment ?: __("Awaiting partner's response .... ") }}</p>
                                            @if($partnerDecision->file)
                                                <a href="{{ asset('storage/uploads/demands/' . $partnerDecision->file) }}" download>{{ __('Download File') }}</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($assistanceDemand->demand->status != 'pending' && $assistanceDemand->demand->status != 'done' && auth()->user()->is_admin)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Admin Response') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <form id="adminResponseForm" method="POST" action="{{ route('assistance.cloture', $partnerDecision->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="admin_comment">{{ __('Admin Comment') }}</label>
                                                <textarea name="admin_comment" id="admin_comment" class="form-control" rows="4"></textarea>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="partner_decision_file">{{ __('Upload File') }}</label>
                                                <input type="file" name="partner_decision_file" id="partner_decision_file" class="form-control-file">
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" class="btn btn-success">{{ __('Close') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($assistanceDemand->demand->status != 'pending' && auth()->user()->is_admin)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Change Demand Type') }}</h5>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
