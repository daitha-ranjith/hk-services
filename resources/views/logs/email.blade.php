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
                <div class="panel-heading">Email Logs</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Content</th>
                                <th>Other Details</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emails as $email)
                                <tr>
                                    <td>{{ getStringFromJson($email['email']['to']) }}</td>
                                    <td>{{ $email['email']['subject'] }}</td>
                                    <td>{{ $email['email']['content'] }}</td>
                                    <td>
                                        CC: {{ getStringFromJson($email['email']['cc']) }}
                                        <br>
                                        BCC: {{ getStringFromJson($email['email']['bcc']) }}
                                    </td>
                                    <td>{{ $email->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $emails->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/see-more.min.js') }}"></script>
    <script>
        $('td').shorten({"showChars":25,"moreText":"See More","lessText":"Less"});
    </script>
@endsection
