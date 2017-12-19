@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-board">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-heading">Create Account</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('accounts.store') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Account Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="label" placeholder="Label" name="label" value="" required>
                                @if ($errors->has('label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Create</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
