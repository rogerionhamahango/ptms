@extends('adminlte::page')

{{-- =========================================================
     PTMS - LAYOUT PRINCIPAL
     Laravel 13 + AdminLTE 3
     ========================================================= --}}

@section('title', $title ?? 'PTMS')

@section('content_header')
    <h1>{{ $header ?? 'PTMS' }}</h1>
@stop








@section('footer')
    @include('layouts.footer')
@stop
