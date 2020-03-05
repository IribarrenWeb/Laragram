@extends('layouts.app')

@section('content')
<upload-component data-user="{{ Auth::user() }}"></upload-component>

@endsection