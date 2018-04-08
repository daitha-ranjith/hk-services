@extends('layouts.app')

@section('content')
    @php
        $url = env('APP_URL') . '/api/sms/send?access_token=' . env('DEMO_ACCESS_TOKEN');
    @endphp
    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading">SMS Demo</div>
                    <div class="panel-body">
                    <form action="{{ $url }}" method="POST">
                        <div class="form-group">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" name="phone" class="form-control" id="phone-number" placeholder="+9199XXXX">
                        </div>
                        <div class="form-group">
                            <label for="sms-message">Message</label>
                            <textarea name="message" class="form-control" id="sms-message" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="from" value="+12392042106">
                        <button type="submit" class="btn btn-success">Send</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('form').on('submit', function (e) {
                var self = $(this);

                var url = self.attr('action');

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: self.serialize(),
                    dataType: 'json',
                    error: function (err) {
                        console.log(err);
                    },
                    success: function (data) {
                        alert('SMS has been sent.')
                    }
                });

                e.preventDefault();
            })
        });
    </script>
@endsection
