@extends('layouts.backend')
@section('title','Dashboard')
@section('content')
  <h1>Welcome to the Paradise <b style="color: skyblue">{{ Auth::user()->name }}</b></h1>
  <p>Lorem ipsum dolor sit amet.</p>
  
@endsection
