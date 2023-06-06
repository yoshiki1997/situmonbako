<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="profile" class="w-64 h-64 bg-gyra-700 border border-black rounded-md flex flex-col justify-center items-center m-auto">
        <div id="user_image" class="rounded-full h-32 w-32 overflow-hidden">
            <img src="{{ asset('images/noimage.jpg') }}" alt="User Icon" class="w-full h-full object-cover">
        </div>
        <div id="user_info" class="flex justify-evenly w-full h-20 items-end">
            <div class="flex flex-col">
                <div id="user_name">
                    <p class="text-center font-semibold">Name:{{ $user->name }}</p>
                </div>
                <div id="user_id" class="mr-auto">
                    <p class="text-center">ID:{{ $user->id }}</p>
                </div>
            </div>
            <div id="followButton">
                <form action="{{ route('follow', ['user' => $user]) }}" method="POST">
                @csrf
                    <button type="submit" name="follow" class="bg-blue-300 text-white rounded py-2 px-4" >
                    @if($user->isFollowed)
                        フォロー済み
                    @else
                        フォロー
                    @endif
                    </button>
                </form>
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
                                </li>
                                @endif
                                @if(isset($like->comment))
                                <li id="like_comment" class="mb-2 ml-8">
                                    <p class="text-black dark:text-white hover:underline">{{ $like->comment }}</p>
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
                                                </ul>
                                            </div>
                                    </li>
                                    <li id="description_{{ $id }}" class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between hidden">
                                        @if(isset($problem->description))
                                                <label for="problem_description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                                <textarea name="description" id="description" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $problem->description }}</textarea><br>
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
                                @endforeach
                            </ul>
                        @else
                            <p>困ったことリストはまだありません。</p>
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
                                </li>
                                @if(isset($history->comment))
                                <li id="history_de" class="mb-2 ml-8">
                                    <p class="text-black dark:text-white hover:underline">{{ $history->comment }}</p>
                                </li>
                                @endif
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
                    フォロワーリスト
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
