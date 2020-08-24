@extends('layouts._admin')

@section('content')
<div class="FSPanel">
    <div class="FSPanel__container">
        <form class="Form Form--flex" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <input class="Form__input" id="email" type="text" name="email" value="{{ old('email') }}" placeholder="Username/Email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <input class="Form__input" id="password" type="password" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <button class="Button" type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection
