@extends('layouts.master')





@section('title','Posts')

@section('content')
  <div class="w-11/12 min-w-min mx-auto">
    <x-table :list=$list :columns=$columns :filters=$filters :querylink=$querylink :settings=$settings />
  </div>
@endsection
