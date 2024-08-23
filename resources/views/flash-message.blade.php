@if ($message = Session::get('success'))
    <div id="myalert" class="msg-card-main success-msg-card">
        <strong>
            <p> {{ $message }} </p>
        </strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div id="myalert" class="msg-card-main danger-msg-card">
        <strong>
            <p> {{ $message }} </p>
        </strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div id="myalert" class="alert alert-warning alert-dismissible">
        <strong>
            <p> {{ $message }} </p>
        </strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div id="myalert" class="alert alert-info alert-dismissible">
        <strong>
            <p> {{ $message }} </p>
        </strong>
    </div>
@endif
