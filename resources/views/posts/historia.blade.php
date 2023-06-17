<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
    </x-slot>

    <div class="flex justify-center">
        <form action="{{ route('history.search') }}" method="GET" class="w-full flex justify-center">
        <input type="text" name="keyword" class="w-7/12 text-black" placeholder="キーワードを入力してください">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md ml-8">検索</button>
        </form>
    </div>
    <div class="flex justify-center items-start bg-gray-100 dark:bg-gray-700">
        <div class="max-w-xl w-full mx-auto px-4 py-8">
            <div id="problemtweets" class="space-y-4">

            @error('keyword')
            <div class="text-center">{{ $message }}</div>
            @enderror
            @error('body')
            <div class="text-center">{{ $message }}</div>
            @enderror

                @if(isset($problems))
                @foreach($problems as $key => $problem)
                @php
                    $id = $key + 1;
                @endphp
                <div id="tweet" class="bg-white dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black shadow-md rounded-lg p-4 duration-300 ease-in-out">
                    <div class="flex flex-col justify-between">
                        <div class="flex flex-row justify-start ">
                            @if(isset($problem->user->id))
                            <a href="{{ route('user.page', ['id' => $problem->user->id]) }}">
                            @if(isset($problem->user->userImage->icon))
                            <img src="/storage/{{ auth()->user()->userImage->icon }}" class="w-10 h-10 rounded-full mr-4" alt="Profile Image">
                            @else
                            <img src="{{ asset('images/noimage.jpg') }}" class="w-10 h-10 rounded-full mr-4" alt="Profile Image">
                            @endif
                            <h2 class="font-bold text-lg px-8">{{ $problem->user->name }}</h2>
                            </a>
                            @endif
                            <p class="text-gray-600 dark:text-black px-8 ml-auto">{{ $problem->created_at->diffForHumans() }}</p>
                            <a href="{{ route('history.pickup',['id' => $problem->id]) }}">
                                <button type="button">編集</button>
                            </a>
                        </div>
                        <div class="mx-8">
                            <p class="text-xl mt-2 mb-2">{{ $problem->title }}</p>
                            <p>{{ $problem->description }}</p>
                            @if($problem->problemUrl)
                            @foreach($problem->problemUrl as $problemUrl)
                            <a class="text-blue-500 hover:underline">{{ $problemUrl->url }}</a>
                            @endforeach
                            @endif
                        </div>
                        <div id="reply_{{$id}}" class="hidden mt-2">
                            @if($problem->reply)
                            @foreach($problem->reply as $key2 => $reply )
                            @php
                                $id2 = $key2 + 1;
                            @endphp
                            <div class="m-8 border rounded">
                                <div class="m-2">
                                <div class="flex justify-between">
                                    <p>{{ $reply->user->name }}</p><p>{{ $reply->created_at }}</p>
                                </div>
                                <p>{{ $reply->body }}</p>
                               
                                <div class="flex justify-between">
                                <form action="{{ route('destory.reply', ['id' => $reply->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">削除</button>
                                </form>
                                <button type="button" onclick="openPatchReply({{$id2}})">編集</button>
                                </div>

                                <div id="replypatch_{{$id2}}" class="hidden">
                                    <form action="{{ route('update.reply', ['id' => $reply->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="body" id="body" cols="20" rows="1" class="text-black border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full h-16">{{ old('body') }}</textarea>
                                        <button type="submit">変更</button>
                                    </form>
                                </div>

                                </div>
                            </div>
                            <div class="flex justify-center">
                                <p>↓</p>
                            </div>
                            @endforeach
                            @endif
                            @if(auth()->check())
                            <form action="{{ route('reply',['id' => $problem->id]) }}" method="POST">
                            @csrf
                            <textarea name="body" id="body" cols="20" rows="1" class="text-black border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full h-16"></textarea>
                            <button type="submit">投稿</button><br>
                            </form>
                            @endif
                        </div>
                        <div class="flex justify-end mt-4">
                            <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md ml-2" onclick="openReply({{$id}})">リプライ</button>
                        
                            <div>
                                @if(auth()->check())
                                    @if(in_array($problem->id,$userProblemLikes))
                                        <div class="problem"  data-problem-id="{{ $problem->id }}" data-user-id="{{ auth()->user()->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor" data-problem-id="{{ $problem->id }}" data-user-id="{{ auth()->user()->id }}">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="problem" data-problem-id="{{ $problem->id }}" data-user-id="{{ auth()->user()->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor" data-problem-id="{{ $problem->id }}" data-user-id="{{ auth()->user()->id }}">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                @if(isset($problems))
                <div class="flex justify-center">
                    <nav class="pagination flex dark:text-white">
                        {{ $problems->links('pagination::tailwind') }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
        <div class="w-64">
        
        </div>
    </div>

</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heartIcons = document.querySelectorAll('.heart-icon');
        
        heartIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                this.classList.toggle('fill-pink-500');
            

        const user_id = this.closest('.problem').getAttribute("data-user-id");
        const problem_id = this.closest('.problem').getAttribute("data-problem-id");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('problem.likes') }}", {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        problem_id: problem_id,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // レスポンスに応じて必要な処理を追加します
                })
                .catch(error => {
                    // エラーハンドリングを行います
                });
            });
        });
    });

    function openReply(id){
        const Reply = document.getElementById('reply_' + id);
        Reply.classList.toggle('hidden');
    }

    function openPatchReply(id2){
        const ReplyPatch = document.getElementById('replypatch_'+ id2);
        ReplyPatch.classList.toggle('hidden');
    }

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
//jQuery
$(function(){
  // 送信ボタンが1度クリックされたら、送信ボタンを非活性化する（二重submit対策）
  $('form').submit(function() {
    $("button[type='submit']").prop("disabled", true);
  });
});
</script>