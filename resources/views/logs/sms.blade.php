@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>SID</th>
                                <th>Mobile</th>
                                <th>Message</th>
                                <th>Characters</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th>Delivered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->sid }}</td>
                                    <td>{{ $message->sent_to }}</td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->characters }}</td>
                                    <td>{{ $message->status }}</td>
                                    <td>{{ $message->sent_at }}</td>
                                    <td>{{ $message->delivered }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        // ..
   </script>
@endsection
