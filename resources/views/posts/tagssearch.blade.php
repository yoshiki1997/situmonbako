@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Title') }}</div>

          <div class="searchbox">
          </div>

          <div class="tags">
              <form action="/tagssearch" method="GET">
                  @csrf <!-- CSRFトークンを追加 -->
                  <input type="text" name="tags" placeholder="キーワードを入れてください">
                  <input type="number" name="limit" value="{{ old('limit') !== null ? old('limit') : 20 }}" max="100" min="1" />質問数
                  <input type="number" name="perPage" value="{{ old('perPage') !== null ? old('perPage') : 10 }}" max="100" min="1" />表示する数
                  <button type="submit">検索</button> <!-- キーワード検索ボタンを追加 -->
              </form>
          </div>
          @if(isset($message))
          <div class="error">{{ $message }}</div>>
          @endif
          <div class="card-body">
          @foreach($questions ?? [] as $question)
                <p><a href="https://teratail.com/questions/{{$question['id']}}" target="_brank">{{ $question['title'] }}</a></p>
            @endforeach
          </div>
          @if(isset($questions))
          <p>{{ $questions->links() }}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
