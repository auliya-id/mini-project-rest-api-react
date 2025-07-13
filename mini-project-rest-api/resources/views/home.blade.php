@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <center>
            <h3 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
            <h5 class="text-muted">Dashboard Mini Project Rest API</h5>
        </center>
    </div>

    <div class="row">
        <center>
            <img src="{{ asset('assets/img/banner.jpg') }}" alt="Banner Home" style="width: auto; height: 500px">
        </center>
    </div>
</div>
@endsection
