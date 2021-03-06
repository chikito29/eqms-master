@extends('layouts.main')

@section('page-title')
    Home | Cpar Show
@endsection

@section('nav-audit-findings') active @endsection

@section('page-content')
    <div class="page-content-wrap">
        @if(session('attention'))
            @include('layouts.attention')
        @endif
        <div class="page-title">
            <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
        </div>

        <div class="row">
            <div class="col-md-9">

                <form class="form-horizontal" role="form" id="form-cpar" action="/action-summary/{{ $cpar->id }}"
                      method="GET" target="_blank">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            @if($cpar->cpar_number)
                                @component('components.show-single-line')
                                    @slot('label') CPAR Number @endslot
                                    {{ $cpar->cpar_number }}
                                @endcomponent
                            @endif
                            @component('components.show-single-line')
                                @slot('label') Raised By @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->raised_by)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Department @endslot
                                {{ $cpar->department }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Branch @endslot
                                {{ $cpar->branch }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Severity Of Findings @endslot
                                    {{ strip_tags(str_replace('&nbsp;', '', $cpar->severity)) }}
                            @endcomponent
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
                                <div class="col-md-9 col-xs-12">
                                    <textarea class="summernote" name="proposed_revision" id="summernote" disabled>{!! $body !!}</textarea>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
								<div class="col-md-9 col-xs-12">
	                                @foreach(explode(',', $cpar->tags) as $tag)
	                                    <label style="border: solid 1px; border-color: rgb(220,220,220); padding: 4px 13px; border-radius: 3px; background-color: rgb(250,250,250);"><span class="fa fa-tag"> {{ $tag }}</span></label><br><br>
	                                @endforeach
								</div>
                            </div>
                            @component('components.show-single-line')
                                @slot('label') Source Of Non-Comformity @endslot
                                    {{ $cpar->source }}
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Others: (Please specify) @endslot
                                {{ $cpar->other_source }}
                            @endcomponent
                            @component('components.show-multi-line')
                                @slot('label') Details @endslot
                                {{ $cpar->details }}
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Person Reporting To Non-Conformity @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->raised_by)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @component('components.show-single-line')
                                @slot('label') Person Responsible For Taking The CPAR @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->person_responsible)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @if($cpar->correction)
                                @component('components.show-multi-line')
                                    @slot('label') Correction @endslot
                                    {{ $cpar->correction }}
                                    @slot('help') Action To Eliminate The Detected Non-Conformity @endslot
                                @endcomponent
                            @endif
                            @if($cpar->root_cause)
                                @component('components.show-multi-line')
                                    @slot('label') Root Cause Analysis @endslot
                                    {{ $cpar->correction }}
                                    @slot('help') What Failed In The System To Allow This Non-Conformance To Occur? @endslot
                                @endcomponent
                            @endif
                            @if($cpar->cp_action)
                                @component('components.show-multi-line')
                                    @slot('label') Corrective/Preventive Action @endslot
                                    {{ $cpar->cp_action }}
                                    @slot('help') Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence @endslot
                                @endcomponent
                            @endif
                            @component('components.show-single-line')
                                @slot('label') Proposed Corrective Action Complete Date @endslot
                                {{ $cpar->proposed_date }}
                            @endcomponent
                            @if($cpar->date_completed)
                                @component('components.show-single-line')
                                    @slot('label') Corrective/Preventive Complete Date @endslot
                                    {{ $cpar->date_completed }}
                                @endcomponent
                            @endif
                            @component('components.show-single-line')
                                @slot('label') Department Head @endslot
                                @foreach($employees as $employee)
                                    @if($employee->id == $cpar->chief)
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    @endif
                                @endforeach
                            @endcomponent
                            @if($cpar->date_confirmed)
                                @component('components.show-single-line')
                                    @slot('label') Date Confirmed By Department Head @endslot
                                    {{ $cpar->date_confirmed }}
                                @endcomponent
                            @endif
                            @if(($cpar->cparAnswered->status == 1 && request('user.role') == 'admin') ||
                                ($cpar->cparClosed->status == 1 || $cpar->cpar_number <> null))
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4><strong>To Be Filled By The QMR / Auditor</strong></h4>
                                    </div>
                                </div>
                                @if($cpar->cpar_acceptance)
                                    @component('components.show-multi-line')
                                        @slot('label') Acceptance of CPAR @endslot
                                        {{ $cpar->cpar_acceptance }}
                                        @slot('help') Comments If Any @endslot
                                    @endcomponent
                                @endif
                                @component('components.show-single-line')
                                    @slot('label') Date Cpar Accepted @endslot
                                    {{ $cpar->date_accepted }}
                                @endcomponent
                                @if($cpar->verified_by)
                                    @component('components.show-single-line')
                                        @slot('label') Name @endslot
                                        @foreach($employees as $employee)
                                            @if($employee->id == $cpar->verified_by)
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                            @endif
                                        @endforeach
                                        @slot('help') QMR / AUDITOR / CEO @endslot
                                    @endcomponent
                                @endif
                                @if($cpar->cpar_acceptance)
                                    @component('components.show-single-line')
                                        @slot('label') Verification Date @endslot
                                        {{ $cpar->date_verified }}
                                    @endcomponent
                                @endif
                                @if($cpar->result)
                                    @component('components.show-multi-line')
                                        @slot('label') Result Of Verification @endslot
                                        {{ $cpar->result }}
                                    @endcomponent
                                @endif
                            @endif
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Attachments</label>
                                <div class="col-md-9 col-xs-7">
                                    @if($cpar->attachments->count() > 0)
                                        @if(request('user.role') == 'default' && request('user.id') != $cpar->chief)
                                            <label class="control-label">Confidential</label>
                                        @elseif(request('user.id') == $cpar->raised_by || request('user.id') == $cpar->person_responsible
                                        || request('user.role') == 'admin' || request('user.role') == 'document-controller'
                                        || request('user.id') == $cpar->chief)
                                            @foreach($cpar->attachments as $attachment)
                                                <a class="control-label" href="{{ asset($attachment->file_path) }}" target="_blank">
                                                    {{ $attachment->file_name }}</a> uploaded by: {{ $attachment->uploaded_by }}<br>
                                            @endforeach
                                        @endif
                                    @else
                                        No Attachment Avaible For This CPAR
                                    @endif
                                </div>
                            </div>
                            <div class="panel-footer">
                                @yield('verify-button')
                                @if(request('user.role') == 'admin')
                                    <button class="btn btn-primary btn-rounded pull-right">Print CPAR</button>
                                @endif
                            </div>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="col-md-3">

                <div class="panel panel-default form-horizontal">
                    <div class="panel-body">
                        <h3><span class="fa fa-info-circle"></span> Quick Info</h3>
                        <p>Some quick info about this user</p>
                    </div>
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Role</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.role') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Username</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.username') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Department</label>
                            <div class="col-md-8 col-xs-7">{{ request('user.department') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Branch</label>
                            <div class="col-md-8 col-xs-7 line-height-30">{{ request('user.branch') }}</div>
                        </div>
                    </div>

                </div>

            </div>

            </div>

    </div>
@stop

@yield('modals')

@section('scripts')
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            var formBody = $('#form-cpar').html();

            $("#file-simple").fileinput({
                showUpload: false,
                showCaption: true,
                uploadUrl: "{{ route('revision-requests.store') }}",
                browseClass: "btn btn-primary",
                browseLabel: "Browse Document",
                allowedFileExtensions : ['.jpg']
            });
        });

        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['misc', ['fullscreen']]
            ],
        });

        function printCpar() {
            $('#form-cpar').html(formBody);
            $('#form-cpar').submit();
        }
    </script>
@stop
