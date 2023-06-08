<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="profile" class="w-64 h-64 bg-gyra-700 border border-black rounded-md flex flex-col justify-center items-center m-auto">
        <div id="user_image" class="rounded-full h-32 w-32 overflow-hidden">
            @if(isset($user->icon))
            <img src="{{ asset('$user->icon') }}" alt="User Icon" class="w-full h-full object-cover">
            @else
            <img src="{{ asset('images/noimage.jpg') }}" alt="User Icon" class="w-full h-full object-cover">
            @endif
        </div>
        <div id="user_info" class="flex justify-evenly w-full h-20 items-end">
            <div class="flex flex-col">
                <div id="user_name">
                    <p class="text-center font-semibold">Name:{{ Auth::user()->name }}</p>
                </div>
                <div id="user_id" class="mr-auto">
                    <p class="text-center">ID:{{ Auth::user()->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>


    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 accordion-toggle" onclick="toggleAccordion(this)">
                    役立ったYOした投稿
                    </div>
                    <div id="like-accordion" class="accordion-content">
                    @if(isset($likes))
                        <ul>
                            @foreach($likes as $key => $like)
                            @php
                            $id = $key + 1;
                            @endphp
                                @if(isset($like->title))
                                <li class="mb-2 ml-4 flex justify-between">
                                    <a href="{{ $like->url }}" target="_blank">
                                        <p class="text-blue-500 hover:underline">{{ $like->title }}</p>
                                    </a>
                                    <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " onclick="likeComment({{$id}})">コメント</button>
                                </li>
                                @if(isset($like->comment))
                                <li id="like_comment" class="mb-2 ml-8">
                                    <p class="text-black dark:text-white hover:underline">{{ $like->comment }}</p>
                                </li>
                                @endif
                                <li id="like_de_fo_{{$id}}" class="mb-2 ml-8 flex justify-between hidden">
                                    <form class="flex" action="{{ route('like.comment.input', ['id' => $like->id]) }}" method="POST">
                                        @csrf
                                        <textarea name="like_comment" id="like_comment" cols="70" rows="1" class="text-black border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $like->comment }}</textarea><br>
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-8">保存</button>
                                    </form>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p>まだ役立ったYOしてません。</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4 accordion-toggle" onclick="toggleAccordion(this); toggleBottun();">
                        <h2 class="text-xl">あなたの失敗履歴</h2>
                    </div>
                    <div id="problem-accordion" class="accordion-content">
                        @if(isset($problems))
                            <ul class="mb-16 flex flex-col">
                                @foreach($problems as $key => $problem)
                                @php
                                $id = $key + 1;
                                @endphp
                                    <li class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between">
                                    <form id="storeform{{ $problem->id }}" class="w-full flex flex-row items-center justify-between" action="{{ route('updateproblem', ['id' => $problem->id]) }}" method="POST">
                                        @csrf
                                            <input type="text" name="title" id="title" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1" value="{{ $problem->title }}" />
                                        
                                            <select name="priority" class="text-black rounded-md">
                                                <option value="3" {{ $problem->priority == 0 ? 'selected' : '' }}>高</option>
                                                <option value="2" {{ $problem->priority == 1 ? 'selected' : '' }}>中</option>
                                                <option value="1" {{ $problem->priority == 2 ? 'selected' : '' }}>低</option>
                                                <option value="0" {{ $problem->priority == 3 ? 'selected' : '' }}>済</option>
                                            </select>

                                            <input type="text" name="category" id="category" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1" value="{{ $problem->category }}" />

                                            <p class="text-black dark:text-white hover:underline mr-4">{{ $problem->updated_at }}</p>
                                            <div class="flex justify-end">
                                    </form>
                                    
                                                <ul class="flex flex-row py-4">
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-purple-500 hover:bg-purple-700 dark:text-white font-bold py-2 px-4 rounded" onclick="openDescription({{ $id }})">
                                                            詳細
                                                        </button>
                                                    </li>
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="URLget({{ $id }})">
                                                            参考URL
                                                        </button>
                                                    </li>
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="store({{ $problem->id }})">
                                                            保存
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('destroy.problem',['id' => $problem->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                                削除
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                    </li>
                                    <li id="description_{{ $id }}" class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between hidden">
                                        @if(isset($problem->description))
                                            <form action="{{ route('description_update', ['id' => $problem->id]) }}" method="POST">
                                                @csrf
                                                <label for="problem_description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">保存</button>
                                                <textarea name="description" id="description" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $problem->description }}</textarea><br>
                                            </form>
                                        @endif
                                    </li>
                                    <li id="url_{{ $id }}" class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between hidden">
                                        <p class="text-black dark:text-white hover:underline mr-4 font-bold">
                                        @if(isset($problem->problemUrl))
                                            @foreach($problem->problemUrl as $problemUrl)
                                                <a href="{{ $problemUrl->url }}" target="_blank" class="text-blue-500 hover:underline">{{ $problemUrl->url }}</a><br>
                                            @endforeach
                                        @endif
                                        </p>
                                    </li>
                                    <li id="urlform_{{ $id }}" class="hidden">
                                        <div class="relative">
                                            <div class="flex flex-col mb-4 mr-9 ">
                                                <form action="{{ Route('problem.url.store') }}" method="POST">
                                                @csrf
                                                    <label for="problem_url" class="mb-2 text-gray-700 dark:text-white">参考ULR:</label>
                                                    <div class="flex flex-row">
                                                    <input class="hidden" name="problem_id" value="{{ $problem->id }}">
                                                    <input type="text" id="problem_url" name="problem_url" placeholder="解決に役立ったURLをコピペして下さい。" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"><br>
                                                    <button type="submit" id="storeButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded ml-8">
                                                        追加
                                                    </button>
                                                    </div>
                                                </form>
                                                <div class="absolute inset-y-0 right-0 flex items-center px-4 ">

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>困ったことリストはまだありません。</p>
                        @endif
                    </div>
                    <div id="form" class="accordion-button hidden">
                        <form id="problem" action="{{ Route('problem.store') }}" method="POST">
                            @csrf
                            <div>
                                <label for="title" class="mb-4 text-gray-700 dark:text-white">タイトル:</label>
                                <input type="text" id="title" name="title" placeholder="タイトルを入力してください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                <label for="priority" class="mb-2 text-gray-700 dark:text-white">優先度:</label>
                                <select id="priority" name="priority" class="text-black mb-2 text-gray-700"><br>
                                    <option value="3" class="text-black">高</option>
                                    <option value="2" class="text-black">中</option>
                                    <option value="1" class="text-black">低</option>
                                    <option value="0" class="text-black">済</option>
                                </select>
                                <label for="category" class="mb-2 text-gray-700 dark:text-white">Category:</label>
                                <input type="text" id="category" name="category" placeholder="カテゴリーを入れてください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                    <div class="relative">
                                        <textarea name="description" id="description" placeholder="詳細を入力してください" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea><br>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="problem_url" class="mb-2 text-gray-700 dark:text-white">参考ULR:</label>
                                    <input type="text" id="problem_url" name="problem_url" placeholder="解決に役立ったURLをコピペして下さい。" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                </div>

                                <div class="pl-12">
                                <label for="status-unresolved">未</label>
                                <label for="status-resolved" class="pl-4">済</label><br>
                                </div>
                                <label class="mb-2 text-gray-700 dark:text-white">状況:</label>
                                <input type="radio" name="status" value="未" checked id="status-unresovled" class="border boder-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="radio" name="status" value="済" id="status-resovled" class="border boder-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                

                            </div>
                            <div id="storediv" class="flex justify-end accordion-button hidden">
                                <button type="submit" id="storeButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    追加
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 accordion-toggle" onclick="toggleAccordion(this)">
                        <h2 class="text-lg font-bold">閲覧履歴</h2>
                    </div>
                    <div id="historyaccordion" class="accordion-content">
                    @if(isset($historys))
                        <ul>
                            @foreach($historys as $key => $history)
                            @php
                            $id = $key + 1;
                            @endphp
                                <li class="mb-2 ml-4 flex flex-row justify-between">
                                        <p class="text-blue-500 hover:underline">
                                            <a href="{{ $history->url }}" target="_blank">{{ $history->title }}</a>
                                        </p>
                                    <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " onclick="Comment({{$id}})">コメント</button>
                                </li>
                                @if(isset($history->comment))
                                <li id="history_de" class="mb-2 ml-8">
                                    <p class="text-black dark:text-white hover:underline">{{ $history->comment }}</p>
                                </li>
                                @endif
                                <li id="history_de_fo_{{$id}}" class="mb-2 ml-8 flex justify-between hidden">
                                    <form action="{{ route('history.comment.input', ['id' => $history->id]) }}" method="POST">
                                        @csrf
                                        <textarea name="comment" id="comment" cols="70" rows="1" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $history->comment }}</textarea><br>
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">保存</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>閲覧履歴はありません。</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 accordion-toggle" onclick="toggleAccordion(this)">
                    フォローリスト
                    </div>
                    <div id="follow-accordion" class="accordion-content">
                        <ul>
                            @if(isset(auth()->user()->following))
                            @foreach(auth()->user()->following as $followingUser)
                                <li class="mb-2 ml-4 flex justify-between">
                                    <a href="{{ route('user.page', ['id' => $followingUser->id]) }}" target="_blank">
                                        <p class="text-blue-500 hover:underline  text-2xl">{{ $followingUser->name }}</p>
                                    </a>
                                    <form action="{{ route('delete', ['user' => $followingUser]) }}" method="POST">
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " >フォロー解除</button>
                                    </form>
                                </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>

<script>
        function toggleAccordion(element) {

            element.classList.toggle('active');
            var content = element.nextElementSibling;

            if (content.style.maxHeight) {
            // アコーディオンを閉じる
            content.style.maxHeight = null;
            } else {
            // アコーディオンを開く
            content.style.maxHeight = content.scrollHeight + "px";
            }
        }
        function toggleBottun() {
            const accordionButton = document.getElementById("form");
            const accordionForm = document.getElementById("storediv");

            accordionButton.classList.toggle("hidden");
            accordionForm.classList.toggle("hidden");
        }
        function URLget(id) {
            const accordionUrlForm = document.getElementById("urlform_" + id);
            const problemaccordion = document.getElementById("problem-accordion");
            const problemurlaccordion = document.getElementById("url_" + id);

            accordionUrlForm.classList.toggle("hidden");
            // アコーディオンを開きな
            problemaccordion.style.maxHeight = problemaccordion.scrollHeight + "px";
            problemurlaccordion.classList.toggle("hidden");
        }
        function store(problem_id) {
            const storeform = document.getElementById("storeform" + problem_id);

            storeform.submit();
        }
        function openDescription(id) {
            const accordionDiscription = document.getElementById("description_" + id);
            const problemaccordion = document.getElementById("problem-accordion");

            accordionDiscription.classList.toggle("hidden");
            // アコーディオンを開きな
            problemaccordion.style.maxHeight = problemaccordion.scrollHeight + "px";
        }
        function Comment(id) {
            const HistoryComment = document.getElementById("history_de_fo_" + id);
            const HistoryAccordion = document.getElementById("historyaccordion");

            HistoryComment.classList.toggle("hidden");
            HistoryAccordion.style.maxHeight = HistoryAccordion.scrollHeight + 'px';
        }
        function likeComment(id) {
            const LikeComment = document.getElementById("like_de_fo_" + id);
            const LikeAccordion = document.getElementById("like-accordion");

            LikeComment.classList.toggle("hidden");
            LikeAccordion.style.maxHeight = LikeAccordion.scrollHeight + 'px';
        }
</script>

<style>
    .accordion-toggle {
        cursor: pointer;
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }

    .active .accordion-content {
        max-height: max-content; /* 適切な高さに変更してください */
    }
</style>
