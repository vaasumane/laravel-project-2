@extends('layout.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center py-5">
        <form class="col-lg-6" id="loginForm">
            @csrf
            <h1 class="text-center">Login</h1>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                    <input type="text" class="form-control" id="inputEmail3" name="username">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword3" name="password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
</div>
@endsection