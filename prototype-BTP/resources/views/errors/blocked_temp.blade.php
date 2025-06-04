@extends('layouts.app')

@section('content')
<div style="text-align: center; margin-top: 100px;">
    <h1>⏳ Login Temporarily Blocked</h1>
    <p>Your IP address ({{ $ip }}) has been temporarily banned due to too many failed login attempts.</p>
    <p>Please try again after: <strong>{{ \Carbon\Carbon::parse($retryAt)->format('H:i:s') }}</strong></p>
</div>
@endsection
