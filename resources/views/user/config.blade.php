@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-sm-12 col-md-9 col-lg-7 px-xl-5">

            <config-component user-data="{{json_encode(Auth::user())}}">

        </div>
    </div>
</div>
@endsection
