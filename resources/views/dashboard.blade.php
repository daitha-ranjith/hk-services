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

                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    {!! $videoChart->html() !!}
                </div>
                <hr>
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! $smsChart->html() !!}
                    </div>
                    <div class="col-md-6">
                        {!! $emailChart->html() !!}
                    </div>
                </div>

                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {!! Charts::scripts() !!}

    {!! $videoChart->script() !!}
    {!! $smsChart->script() !!}
    {!! $emailChart->script() !!}
@endsection
