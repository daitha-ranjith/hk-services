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

                <div class="panel-heading">
                    Accounts
                    <a href="{{ route('accounts.create') }}" class="btn btn-xs btn-primary pull-right">
                        Create New
                    </a>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table table-hover">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->email }}</td>
                                        <td>
                                            <a href="{{ route('accounts.edit', $account->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        {{ $accounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
