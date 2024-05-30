@extends('layout.frontend')
@section('content')
<div class="container">
   <h1 class="text-center">
    Welcome {{$_COOKIE["username"]}}
   </h1>
</div>
@endsection