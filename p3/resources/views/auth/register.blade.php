@extends('layouts/main')

@section('title')
Register
@endsection

@section('content')
<h2 dusk="register-heading">Register</h2>

<form method='POST' action='/register'>
    {{ csrf_field() }}
    <div class="form-group">
        <label for='name'>Name</label>
        <input dusk="register-name-input" class="form-control" id='name' type='text' name='name' value='{{ old('name') }}' autofocus>
        @if($errors->get('name'))
        <div class='text-danger' dusk="register-error-name">{{ $errors->first('name') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for='email'>E-Mail Address</label>
        <input dusk="register-email-input" class="form-control" id='email' type='email' name='email' value='{{ old('email') }}'>
        @if($errors->get('email'))
        <div class='text-danger' dusk="register-error-email">{{ $errors->first('email') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for='password'>Password (min: 8)</label>
        <input dusk="register-password-input" class="form-control" id='password' type='password' name='password'>
        @if($errors->get('password'))
        <div class='text-danger' dusk="register-error-password">{{ $errors->first('password') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for='password-confirm'>Confirm Password</label>
        <input dusk="register-password-confirm-input" class="form-control" id='password-confirm' type='password' name='password_confirmation'>
    </div>

    <button dusk="register-button" type='submit' class='btn btn-primary'>Register</button>
</form>
@endsection
