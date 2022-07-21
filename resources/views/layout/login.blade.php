@extends('layout.wrapper', ['title' => "Login", 'classBody' => 'bg-gradient-primary'])
@section('content-wrapper')

@php
$height = 'min-height: 100vh; height: auto;';
@endphp

<div class="container" style="{{ $height }}">
    <div class="row justify-content-center align-items-center" style="{{ $height }}">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                                </div>
                                @if(session()->get('errors'))
                                <div class="text-center">
                                    <h5 class="h5 text-danger fw-bold mb-4">{{ session()->get('errors')->first() }}</h5>
                                </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('loginProcess') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="input" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email / Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
