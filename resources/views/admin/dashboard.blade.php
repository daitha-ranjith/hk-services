@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-success services-{{ $interrupted ? 'interrupted' : 'operational' }}" role="alert">
                <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
                &nbsp;
                {{ $interrupted ? 'Few Services Stopped' : 'All Services Operational' }}
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($services as $service)
                    <div class="panel-heading">
                        <strong>
                            {{ ucfirst($service->name) }} Services
                        </strong>

                        @if ($service->active)
                            <div class="pull-right text-success">Operational</div>
                        @else
                            <div class="pull-right text-danger">Stopped</div>
                        @endif
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('status.update') }}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="service" value="{{ $service->name }}">
                            <input type="hidden" name="status" value="{{ $service->active ? "0" : "1" }}">

                            <button type="submit" class="btn btn-sm btn-{{ $service->active ? 'default' : 'primary' }}">
                                Click to {{ $service->active ? 'Stop' : 'Start' }}
                            </button>

                        </form>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
