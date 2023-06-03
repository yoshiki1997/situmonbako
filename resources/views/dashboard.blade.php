<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                    閲覧履歴
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
                    <div class="accordion-content">
                    @if(isset($likes))
                        <ul>
                            @foreach($likes as $like)
                                <li class="mb-2 ml-4">
                                    <a href="{{ $like->url }}" target="_blank">
                                        <p class="text-blue-500 hover:underline">{{ $like->title }}</p>
                                    </a>
                                </li>
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
                                    <form id="storeform{{ $problem->id }}" class="w-full flex flex-row items-center justify-between" action="{{ route('updateproblem', ['id', $problem->id]) }}" method="POST">
                                        @csrf
                                            <input type="text" name="title" id="title" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1" value="{{ $problem->title }}" />
                                            <p class="text-black dark:text-white hover:underline mr-4 font-bold">{{ $problem->title }}</p>
                                            {{-- @if($problem->priority == 0)
                                            <p class="text-green-500 bg-green-100 px-2 py-1 rounded-md mr-4">済</p>
                                            @elseif($problem->priority == 1)
                                            <p class="text-green-500 bg-green-100 px-2 py-1 rounded-md mr-4">低</p>
                                            @elseif($problem->priority == 2)
                                            <p class="text-yellow-500 bg-yellow-100 px-2 py-1 rounded-md mr-4">中</p>
                                            @elseif($problem->priority == 3)
                                            <p class="text-red-500 bg-red-100 px-2 py-1 rounded-md mr-4">高</p>
                                            @endif --}}
                                            <select name="priority" class="text-black rounded-md">
                                                <option value="3" {{ $problem->priority == 0 ? 'selected' : '' }}>高</option>
                                                <option value="2" {{ $problem->priority == 1 ? 'selected' : '' }}>中</option>
                                                <option value="1" {{ $problem->priority == 2 ? 'selected' : '' }}>低</option>
                                                <option value="0" {{ $problem->priority == 3 ? 'selected' : '' }}>済</option>
                                            </select>

                                            <p class="text-black dark:text-white hover:underline mr-4">{{ $problem->category }}</p>
                                            <p class="text-black dark:text-white hover:underline mr-4">{{ $problem->status }}</p>
                                            <p class="text-black dark:text-white hover:underline mr-4">{{ $problem->updated_at }}</p>
                                            <div class="flex justify-end">
                                    </form>
                                                <ul class="flex flex-row">
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
                                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="store({{ $problem->id }})">
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
                                                <label for="problem_description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                                <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"><a href="#">保存</a></button>
                                                <textarea name="description" id="description" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $problem->description }}</textarea><br>
                                        @endif
                                        
                                    </li>
                                    <li id="url_{{ $id }}" class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between hidden">
                                        <p class="text-black dark:text-white hover:underline mr-4 font-bold">
                                        @if(isset($problem_urls) && isset($problem->id) && isset($problem_urls[$problem->id]))
                                            @foreach($problem_urls[$problem->id] as $problem_url)
                                                <a href="{{ $problem_url->url }}" target="_blank" class="text-blue-500 hover:underline">{{ $problem_url->url }}</a><br>
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
                    <div class="accordion-content">
                    @if(isset($historys))
                        <ul>
                            @foreach($historys as $history)
                                <li class="mb-2 ml-4">
                                    <a href="{{ $history->url }}" target="_blank">
                                        <p class="text-blue-500 hover:underline">{{ $history->title }}</p>
                                    </a>
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
