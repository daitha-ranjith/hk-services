@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-heading">Video Conferences</div>
                <div class="panel-body">
                    //
                </div>

                <div class="panel-heading">Messages</div>
                <div class="panel-body">
                    //
                </div>

                <div class="panel-heading">Emails</div>
                <div class="panel-body">
                    //
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
