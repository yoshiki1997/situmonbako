@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Title') }}</div>

          <div class="card-body">
        
            <p>{{ $questioninfo['id'] }}</p>
            <p>{{ $questioninfo['body'] }}</p>
            <p><a href="https://teratail.com/questions/{{ $questioninfo['id'] }}">{{ $questioninfo['title']}}</a></p>
            




          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

