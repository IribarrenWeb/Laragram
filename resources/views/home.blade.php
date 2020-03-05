@extends('layouts.app')
{{-- @dump($images) --}}
@section('content')

    <cards-component data-user="{{Auth::user()}}"></cards-component>
        
@endsection
