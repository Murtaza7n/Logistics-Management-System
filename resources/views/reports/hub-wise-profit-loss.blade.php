@extends('layouts.app')
@section('title', '$(echo $report | tr "-" " " | sed "s/\b\(.\)/\u\1/g")')
@section('content')
<div class="page-header"><h1>$(echo $report | tr "-" " " | sed "s/\b\(.\)/\u\1/g")</h1></div>
<div class="card"><div class="card-body"><p>Report page. Under development.</p></div></div>
@endsection
