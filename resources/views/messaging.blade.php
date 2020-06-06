@extends('layouts.app')

@section('content')
<div class="container">
    <form method="post" action="{{ route('messages.store') }}">
        @csrf

        <div class="form-group">
            <label for="messageTextArea">Type your message</label>
            <textarea class="form-control" id="messageTextArea" rows="10" name="message"></textarea>

            @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Listener for Event Broadcasts -->
<!--script src="{{ asset('js/bootstrap.js') }}"></script-->
<script type="text/javascript">
    Echo.private(`instant-messaging.${message_id}`)
        .listen('.instant-messaging', (e) => {
            console.log(e.update);
        });
</script>

@endsection
