@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10  main-content">

            <detail-component data-image="{{ $image }}" data-user="{{ Auth::user() }}">

        </div>
    </div>
</div>

@include('includes.modal',['image_id'=>$image->id])

@endsection