@extends('layouts/main')

@section('title')
Login
@endsection

@section('content')

<h2 dusk="login-heading">Login</h2>

<form method='POST' action='/login'>
    {{ csrf_field() }}
    <div class="form-group">
        <label for='email'>E-Mail Address</label>
        <input dusk="login-email-input" class="form-control" id='email' type='email' name='email' value='{{ old('email') }}' autofocus>
        @if($errors->get('email'))
        <div class='text-danger' dusk="login-error-email">{{ $errors->first('email') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for='password'>Password</label>
        <input dusk="login-password-input" class="form-control" id='password' type='password' name='password'>
        @if($errors->get('password'))
        <div class='text-danger' dusk="login-error-password">{{ $errors->first('password') }}</div>
        @endif
    </div>

    <button dusk="login-button" type='submit' class='btn btn-primary'>Login</button>

    </a>

</form>

@endsection
