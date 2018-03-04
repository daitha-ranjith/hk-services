@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading">E-mail Demo</div>
                    <div class="panel-body">
                    <form action="https://hk-services.herokuapp.com/api/email/send?access_token=uy0boiRWoZjMB1emLj9IOPyRyrMmUJEZE3zJYbWiAWksLSLKDirBadCG25df" method="POST">
                        <div class="form-group">
                            <label for="to">To Email(s)</label>
                            <input type="text" name="to" class="form-control" id="to" placeholder="ex@example.com,ex@ex.com">
                        </div>
                        <div class="form-group">
                            <label for="cc">CC Email(s)</label>
                            <input type="text" name="cc" class="form-control" id="cc" placeholder="ex@example.com,ex@ex.com">
                        </div>
                        <div class="form-group">
                            <label for="bcc">BCC Email(s)</label>
                            <input type="text" name="bcc" class="form-control" id="bcc" placeholder="ex@example.com,ex@ex.com">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject of the email">
                        </div>
                        <div class="form-group">
                            <label for="sender_email">Sender Email</label>
                            <input type="email" name="sender_email" class="form-control" id="sender_email" placeholder="ex@example.com">
                        </div>
                        <div class="form-group">
                            <label for="sender_name">Sender Name</label>
                            <input type="text" name="sender_name" class="form-control" id="sender_name" placeholder="Example User">
                        </div>
                        <div class="form-group">
                            <label for="reply_to">Reply To Email(s)</label>
                            <input type="text" name="reply_to" class="form-control" id="reply_to" placeholder="ex@example.com,ex@ex.com">
                        </div>

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
