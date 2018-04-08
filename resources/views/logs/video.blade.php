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
                <div class="panel-heading">Video Logs</div>

                <div class="panel-body">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Room SID</th>
                                <th>Room Name</th>
                                <th>Participants</th>
                                <th>Status</th>
                                <th>Duration</th>
                                <th>Started At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conferences as $conference)
                                <tr>
                                    <td>{{ $conference->sid }}</td>
                                    <td>{{ $conference->name }}</td>
                                    <td>{{ $conference->participants_count }}</td>
                                    <td>{{ $conference->status }}</td>
                                    <td>{{ $conference->duration }}</td>
                                    <td>{{ $conference->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $conferences->links() }}
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
