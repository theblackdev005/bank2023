@extends('layouts.guest')

@section('content')
    <x-guest-testimonials :items=$testimonials />
@endsection