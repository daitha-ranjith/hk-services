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

                    <div class="panel-heading">Account</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <form class="form-horizontal" action="{{ route('accounts.update', $account->id) }}" method="POST">
                                {{ csrf_field() }}

                                {{ method_field('PUT') }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $account->name }}" autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $account->email }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                    <label for="mobile_no" class="col-md-4 control-label">Mobile No</label>

                                    <div class="col-md-6">
                                        <input id="mobile_no" type="tel" class="form-control" name="mobile_no" value="{{ $account->details->mobile_no }}" autofocus>

                                        @if ($errors->has('mobile_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('mobile_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address" class="col-md-4 control-label">Address</label>

                                    <div class="col-md-6">
                                        <textarea id="address" class="form-control" name="address" rows="5">{{ $account->details->address }}</textarea>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="panel-heading">
                    Sub-Accounts
                    <a href="{{ route('sub-accounts.create', $account->id) }}" class="btn btn-xs btn-primary pull-right">
                        Create New
                    </a>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table table-hover">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Services Active</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subAccounts as $subAccount)
                                    <tr>
                                        <td>{{ $subAccount->label }}</td>
                                        <td>
                                            @foreach ($subAccount->config as $index => $config)
                                                @if ($config['active'])
                                                    {{ ucfirst($index) }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('sub-accounts.edit', [$account->id, $subAccount->id]) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        {{ $subAccounts->links() }}
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>

@endsection

