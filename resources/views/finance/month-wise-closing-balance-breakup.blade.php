@extends('layouts.app')

@section('title', '$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")')
@section('page-title', '$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")')

@section('content')
<div class="page-header">
    <h1 class="page-title">$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")</h1>
</div>
<div class="card">
    <div class="card-body">
        <p class="text-muted">This page is under development.</p>
    </div>
</div>
@endsection
