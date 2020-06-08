@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong> Errors Occured </strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <strong> {{ session('success') }} </strong>
        </div>
    @endif

    <div id="display-message" class="border mb-5 p-2 rounded d-none">
    </div>

    <form id="msg_form">
        @csrf

        <div class="form-group">
            <label for="messageTextArea">Type your message</label>
            <textarea class="form-control @error('message') is-invalid @enderror" id="messageTextArea" rows="5" name="message"></textarea>

            @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="receiverSelect">Select user to send message</label>
            <select class="form-control @error('receiver') is-invalid @enderror"" id="receiverSelect" name="receiver">
                <option>Choose Receiver...</option>

                @foreach ($users as $user)
                    @if ($user != Auth::user())
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>

            @error('receiver')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Listener for Event Broadcasts -->
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript">
    Echo.private(`instant-messaging.{{ Auth::user()->id }}`)
        .listen('.instant-messaging', (e) => {
            console.log(e, 'Showing Message ...!');
            display_message(e.message, e.user.name);
        });
</script>

<!-- Send Message Broadcasts -->
<script type="text/javascript">
    var msg_form = document.getElementById("msg_form");

    msg_form.addEventListener("submit", function(e) {
        e.preventDefault();

        // get form data
        var message_txt = document.getElementById("messageTextArea").value;
        var message_receiver = document.getElementById("receiverSelect").value;

        // post form data
        axios.post("{{ route('messages.store') }}", {
            message: message_txt,
            receiver: message_receiver,
        })
        .then(function (response) {
            console.log(response);
            display_message(message_txt, "{{ Auth::user()->name }}")
        })
        .catch(function (error) {
            console.log(error);
        });
    });
</script>

<!-- Display Message -->
<script type="text/javascript">
    function display_message(message_txt, user_name) {
        var display = document.getElementById("display-message");
        var message_p = document.createElement("p");
        var message_text = document.createTextNode(
            user_name + ": " + message_txt
        );

        // insert text and append to message display
        message_p.appendChild(message_text);
        display.appendChild(message_p);
        display.classList.remove('d-none');
    }
</script>

@endsection
