@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Title') }}</div>

          

          <div class="card-body">
          @if(count($questions)>0)
          @foreach($questions as $question)
                <p><a href="/questions/{{$question['id']}}">{{ $question['title'] }}</a></p>
            @endforeach
          @else
          <p>該当する質問がありません。</p>
          @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
