<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        @include('layouts.dashboardheader')
    </x-slot>

    <div id="profile" class="w-64 h-64 bg-gyra-700 border border-black rounded-md flex flex-col justify-center items-center m-auto">
        @if(!isset(auth()->user()->userImage->icon))
        <p id="iconExplanation" class="">画像ファイルをドラッグ＆ドロップで<br>設定できます。</p>
        @endif
            <form action="{{ route('profile.img') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="dropzone" class="dropzone">
                    <div id="user_image" class="rounded-full h-32 w-32 overflow-hidden">
                    @if(isset(auth()->user()->userImage->icon))
                    <img src="/storage/{{ auth()->user()->userImage->icon }}" alt="User Icon" class="w-full h-full object-cover">
                    @else              
                    <img src="{{ asset('images/noimage.jpg') }}" alt="User Icon" class="w-full h-full object-cover">
                    @endif
                    </div>
                </div>
                
                <button type="submit">保存</button>
            </form>
        
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



                <div id="update-content" class="content">
                    @if(isset($updateproblem))
                    <p class="text-center text-3xl font-bold italic mb-2">困ったことリスト変更フォーム</p>
                    <div id="updateproblemform" class="w-7/12 mb-3 mx-auto border border-black rounded bg-gray-600">
                        <form id="problem" action="{{ route('updateproblem', ['id' => $updateproblem->id]) }}" method="POST">
                            @csrf
                            <div class="p-8">
                                <label for="title" class="mb-4 text-gray-700 dark:text-white">タイトル:</label>
                                <input type="text" id="title" name="title" value="{{ $updateproblem->title }}" placeholder="タイトルを入力してください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                <label for="priority" class="mb-2 text-gray-700 dark:text-white">優先度:</label>
                                <select id="priority" name="priority" class="text-black mb-2 text-gray-700"><br>
                                    <option value="3" class="text-black">高</option>
                                    <option value="2" class="text-black">中</option>
                                    <option value="1" class="text-black">低</option>
                                    <option value="0" class="text-black">済</option>
                                </select>

                                <input type="hidden" id="tagValueUpdate" name="categories">
                                <label for="category" class="mb-4 ml-4 text-gray-700 dark:text-white">Category:</label>
                                <input type="text" name="category" id="categoriesUpdate" placeholder="カテゴリーを入れてください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button id="addUpdateCategoryButton" type="button" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">追加</button><br>

                                <div id="tagContainer_update" class="flex flex-wrap gap-2 mb-2 tagContainer_update">
                                    Category:
                                        @if(isset($updateproblem->categories))
                                        @foreach($updateproblem->categories as $category)
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded flex">
                                                <p>{{ $category->category }}</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 delete-button" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        @endforeach
                                        @endif
                                </div>

                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                    <div class="relative flex">
                                        <textarea name="description" id="description" placeholder="詳細を入力してください" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none w-full sm:w-auto flex-grow">{{ $updateproblem->description }}</textarea><br>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="problem_url" class="mb-2 text-gray-700 dark:text-white"><i class="fa-solid fa-link" style="color: #ed0c90;"></i>参考ULR:</label>
                                    <input type="text" id="problem_url" name="problem_url" placeholder="解決に役立ったURLをコピペして下さい。" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                </div>
                                
                                <div id="storediv" class="flex justify-end accordion-button">
                                <button type="submit" id="storeButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    変更
                                </button>
                                </div>
                                
                                

                            </div>
                            
                        </form>
                    </div>
                    @endif
                </div>

                <div id="favorite-content" class="content hidden">

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
                                    <div class="flex">
                                    <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " onclick="likeComment({{$id}})">コメント</button>
                                    <svg data-user-id="{{ $like->user->id }}" data-title="{{ $like->title }}" data-url="{{ $like->url }}" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    </div>
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

</div>
    
<div id="problems-content" class="content">

        <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4 accordion-toggle" onclick="toggleAccordion(this); toggleBottun();">
                        <h2 class="text-xl">あなたの失敗履歴</h2>
                    </div>
                    <div id="problem-accordion" class="accordion-content">
                    <div class="flex justify-end">
                    <label for="toggle" class="flex items-center cursor-pointer">
                        <div class="relative">
                        <input type="checkbox" id="toggle" class="sr-only">
                        <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-black dark:text-white font-medium">未達成のみ</div>
                    </label>
                    </div>
                        @if(isset($problems))
                            <ul class="mb-16 flex flex-col">
                                @foreach($problems as $key => $problem)
                                @php
                                $id = $key + 1;
                                @endphp
                                    <div class="my-2 p-2 border rounded listContainer">
                                    <li class="mb-2 ml-4 mt-4 flex flex-col justify-between">
                                    <form id="storeform{{ $problem->id }}" class="w-full flex flex-col justify-between" action="{{ route('updateproblem', ['id' => $problem->id]) }}" method="POST">
                                        @csrf
                                            <div class="flex my-8 gap-32">
                                    
                                            <select id="prioritySelect" name="priority" class="text-black rounded-md prioritySelect" onchange="updateBackground(this)">
                                                <option value="3" class="bg-selecter-high" {{ $problem->priority == 3 ? 'selected' : '' }}>高</option>
                                                <option value="2" class="bg-selecter-middel" {{ $problem->priority == 2 ? 'selected' : '' }}>中</option>
                                                <option value="1" class="bg-selecter-low" {{ $problem->priority == 1 ? 'selected' : '' }}>低</option>
                                                <option value="0" class="bg-gray-500" {{ $problem->priority == 0 ? 'selected' : '' }}>済</option>
                                            </select>

                                            <input type="text" name="title" id="title" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1 flex-grow" value="{{ $problem->title }}" />

                                            </div>

                                            {{--<div class="flex justify-between my-2">
                                            <input type="hidden" id="tagValue_{{$id}}" class="tagValueInput2" name="categories" value="{{  $problem->categories->pluck('category')->implode(',') }}">
                                            <div id="tagContainer_{{$id}}" class="flex flex-wrap gap-2 mb-2 tagContainer2">
                                                Category:
                                                    @if(isset($problem->categories))
                                                    @foreach($problem->categories as $category)
                                                        <span class="bg-blue-500 text-white px-2 py-1 rounded flex">
                                                            <p>{{ $category->category }}</p>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 delete-button" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </span>
                                                    @endforeach
                                                    @endif
                                            </div>
                                            <input type="text" name="category" id="categories_{{$id}}" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1 categories" value="{{ $problem->category }}" />
                                            <button type="button" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded addProblemCategoryButton" data-id="{{$id}}">追加</button><br>

                                            </div>--}}
                                            
                                    </form>
                                    <div class="flex justify-between">

                                        
                                        
                                            <div class="flex flex-col my-2">
                                                <div class="flex mb-2">
                                                <input type="hidden" id="tagValue_{{$id}}" class="tagValueInput2" name="categories" value="{{  $problem->categories->pluck('category')->implode(',') }}">
                                                <input type="text" name="category" id="categories_{{$id}}" class="text-black hover:underline mr-4 font-bold border border-gray-300 rounded-md px-2 py-1 categories" value="{{ $problem->category }}" />
                                                <button type="button" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded addProblemCategoryButton" data-id="{{$id}}">追加</button><br>
                                                </div>
                                                <div id="tagContainer_{{$id}}" class="flex flex-wrap gap-2 mb-2 tagContainer2">
                                                    Category:
                                                        @if(isset($problem->categories))
                                                        @foreach($problem->categories as $category)
                                                            <span class="bg-blue-500 text-white px-2 py-1 rounded flex">
                                                                <p>{{ $category->category }}</p>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 delete-button" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </span>
                                                        @endforeach
                                                        @endif
                                                </div>
                                            </div>

                                            <div class="flex flex-col">
                                                <p class="text-black dark:text-white hover:underline mr-4 self-end flex-auto">{{ $problem->updated_at }}</p>
                                                <div class="flex flex-auto justify-center">
                                                <button id="menu-button" class="bg-transparent border-none cursor-pointer self-center mr-4 menu-button">
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                    </svg>
                                                </button>
                                                <ul class="flex flex-row py-4 hidden menu">
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-purple-500 hover:bg-purple-700 dark:text-white font-bold py-2 px-4 rounded" onclick="openDescription({{ $id }})">
                                                            <i class="fa-solid fa-plus fa-lg" style="color: #8902f7;"></i>詳細
                                                        </button>
                                                    </li>
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="URLget({{ $id }})">
                                                        <i class="fa-solid fa-link fa-lg" style="color: #ed0c90;"></i>参考URL
                                                        </button>
                                                    </li>
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-white dark:bg-black hover:bg-opacity-50 text-black dark:text-white font-bold py-2 px-4 rounded" onclick="openReply({{ $id }})">
                                                        <i class="fa-solid fa-reply-all fa-lg" style="color: #15f978;"></i>リプライ
                                                        </button>
                                                    </li>
                                                    <li class="mr-4">
                                                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="store({{ $problem->id }})">
                                                        <i class="fa-regular fa-file fa-lg" style="color: #08f7cf;"></i>保存
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('destroy.problem',['id' => $problem->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            <i class="fa-regular fa-square-minus fa-lg" style="color: #ffea00;"></i>削除
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                                </div>
                                            </div>
                                        
                                    </dvi>
                                    </li>
                                    <li id="reply_{{$id}}" class="flex justify-center hidden">
                                        <div class="mx-12">
                                            @if($problem->reply)
                                            @foreach($problem->reply as $key2 => $reply )
                                            @php
                                                $id2 = $key2 + 1;
                                            @endphp
                                            <div class="my-4 border rounded">
                                                <div class="m-2">
                                                    <div class="flex justify-between mb-4">
                                                    <p>{{ $reply->user->name }}</p><p>{{ $reply->created_at }}</p>
                                                    </div>
                                                    <div>
                                                    <p>{{ $reply->body }}</p>
                                                    </div>

                                                    @if($reply->user_id == Auth::user()->id)
                                                    <div class="flex justify-between">
                                                        <form action="{{ route('destory.reply', ['id' => $reply->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">削除</button>
                                                        </form>
                                                        <button type="button" onclick="openPatchReply({{$id2}})">編集</button>
                                                    </div>
                                                    @endif

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
                                        </div>
                                    </li>
                                    <li id="description_{{ $id }}" class="mb-2 ml-4 mt-4 flex flex-row items-center justify-between hidden">
                                        @if(isset($problem->description))
                                            <form class="flex justify-center w-full" action="{{ route('description_update', ['id' => $problem->id]) }}" method="POST">
                                                @csrf
                                                <div class="flex flex-col w-full mr-4">
                                                <label for="problem_description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                                <textarea name="description" id="description" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $problem->description }}</textarea><br>
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded self-end">保存</button>
                                                </div>
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
                                                    <label for="problem_url" class="mb-2 text-gray-700 dark:text-white"><i class="fa-solid fa-link" style="color: #ed0c90;"></i>参考ULR:</label>
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
                                    </div>
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
                                <div class="mr-9 mb-4">

                                <label for="title" class="mb-4 text-gray-700 dark:text-white">タイトル:</label>
                                <input type="text" id="title" name="title" placeholder="タイトルを入力してください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"><br>

                                </div>

                                <label for="priority" class="mb-2 text-gray-700 dark:text-white">優先度:</label>
                                <select id="prioritySelect" name="priority" class="text-black rounded-md prioritySelect" onchange="updateBackground(this)">
                                    <option value="3" class="bg-selecter-high" >高</option>
                                    <option value="2" class="bg-selecter-middel">中</option>
                                    <option value="1" class="bg-selecter-low">低</option>
                                    <option value="0" class="bg-gray-500">済</option>
                                </select>

                                
                                <input type="hidden" id="tagValue" name="categories">
                                <label for="category" class="mb-4 ml-4 text-gray-700 dark:text-white">Category:</label>
                                <input type="text" name="category" id="categories" placeholder="カテゴリーを入れてください" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button id="addCategoryButton" type="button" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">追加</button><br>

                                <div id="tagContainer" class="flex flex-wrap gap-2 mb-8 mt-8">Category:</div>
                                
                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="description" class="mb-2 text-gray-700 dark:text-white">詳細:</label>
                                    <div class="relative">
                                        <textarea name="description" id="description" placeholder="詳細を入力してください" cols="70" rows="6" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">{{ old('description') }}</textarea><br>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col mb-4 mr-9">
                                    <label for="problem_url" class="mb-2 text-gray-700 dark:text-white">参考ULR:</label>
                                    <div id="problem_url_form" class="relative flex mb-4">
                                        <input type="text" id="problem_url" name="problem_url" placeholder="解決に役立ったURLをコピペして下さい。" class="text-black border border-gray-300 rounded px-4 py-2 mb-2 flex-grow focus:outline-none focus:ring-2 focus:ring-blue-500"><br>
                                        <button type="button" id="add_url" class="absolute top-0 right-0 mt-2 mr-2 text-gray-500 rounded-rfocus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>



                                
                                

                            </div>
                            <div id="storediv" class="flex justify-end accordion-button hidden mr-9">
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

    </div>

    <div id="history-content" class="content hidden">

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
                                    <div class="history flex" data-user-id="{{ $history->user->id }}" data-history-id="{{ $history->id }}">
                                    <form action="{{ route('destroy.history', ['id' => $history->id]) }}" method="POST">
                                        @csrf
                                        <button id="destroy-history" type="submit" class=" destroy-history bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mx-4">
                                            <i class="fa-solid fa-delete-left fa-2xl mr-2" style="color: #5237b3;"></i>取り消し
                                        </button>
                                    </form>
                                    <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " onclick="Comment({{$id}})">コメント</button>
                                    </div>
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

    </div>

    <div id="following-content" class="content hidden">

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
                                    <a href="{{ route('user.page', ['id' => $followingUser->id]) }}" target="_blank" class="flex">
                                        <div id="user_image" class="rounded-full mr-4 h-8 w-8 overflow-hidden">
                                        @if(isset($followingUser->userImage->icon))
                                        <img src="/storage/{{ $followingUser->userImage->icon }}" alt="User Icon" class="w-full h-full object-cover">
                                        @else              
                                        <img src="{{ asset('images/noimage.jpg') }}" alt="User Icon" class="w-full h-full object-cover">
                                        @endif
                                        </div>
                                        <p class="text-blue-500 hover:underline  text-2xl">{{ $followingUser->name }}</p>
                                    </a>
                                    <form action="{{ route('delete', ['user' => $followingUser]) }}" method="POST">
                                        @csrf
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

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 accordion-toggle" onclick="toggleAccordion(this)">
                    フォロワーリスト
                    </div>
                    <div id="follow-accordion" class="accordion-content">
                        <ul>
                            @if(isset(auth()->user()->followers))
                            @foreach(auth()->user()->followers as $followerUser)
                                <li class="mb-2 ml-4 flex justify-between">
                                    <a href="{{ route('user.page', ['id' => $followerUser->id]) }}" target="_blank" class="flex">
                                        <div id="user_image" class="rounded-full mr-4 h-8 w-8 overflow-hidden">
                                        @if(isset($followingUser->userImage->icon))
                                        <img src="/storage/{{ $followingUser->userImage->icon }}" alt="User Icon" class="w-full h-full object-cover">
                                        @else              
                                        <img src="{{ asset('images/noimage.jpg') }}" alt="User Icon" class="w-full h-full object-cover">
                                        @endif
                                        </div>
                                        <p class="text-blue-500 hover:underline  text-2xl">{{ $followerUser->name }}</p>
                                    </a>
                                    <form action="{{ route('delete', ['user' => $followerUser]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded " >ブロック</button>
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

    </div>
    
</x-app-layout>

<script src="{{ asset('js/dashboardswitch.js') }}"></script>

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
        function openReply(id) {
            const accordionUrlForm = document.getElementById("reply_" + id);
            const problemaccordion = document.getElementById("problem-accordion");

            accordionUrlForm.classList.toggle("hidden");
            // アコーディオンを開きな
            problemaccordion.style.maxHeight = problemaccordion.scrollHeight + "px";
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heartIcons = document.querySelectorAll('.heart-icon');
        
        heartIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                this.classList.toggle('fill-pink-500');
            

        const user_id = this.getAttribute("data-user-id");
        const url = this.getAttribute("data-url");
        const title = this.getAttribute("data-title");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("/likes", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        title: title,
                        url: url
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

    var selectElements = document.querySelectorAll('.prioritySelect');
    selectElements.forEach(function(selectElement) {
        // 初期選択状態での色を適用する
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var selectedColor = selectedOption.classList[0];
        selectElement.className = 'text-black rounded-md prioritySelect ' + selectedColor; // クラスを変更して背景色を適用する

        selectElement.addEventListener('change', function() {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var selectedColor = selectedOption.classList[0]; // オプションのクラスから色を取得する

            selectElement.className = 'text-black rounded-md prioritySelect ' + selectedColor; // クラスを変更して背景色を適用する
    });
});

const categoryInput = document.getElementById('categories');
const categoryInput2 = document.querySelectorAll('.categories');
const categoryUpdate = document.getElementById('categoriesUpdate');
const tagContainer = document.getElementById('tagContainer');
const addCategoryButton = document.getElementById('addCategoryButton');
const tagValueInput = document.getElementById('tagValue');
const addUpdateCategoryButton = document.getElementById('addUpdateCategoryButton');
const tagValueInputUpdate = document.getElementById('tagValueUpdate');
const tagContainerUpdate = document.getElementById('tagContainer_update')

function createTag3() {

if (categoryUpdate.value.trim() !== '') {
  const tag = document.createElement('span');
  const text = document.createElement('p');

  text.textContent = categoryUpdate.value.trim();
  tag.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'flex');
  tag.appendChild(text);
  tagContainerUpdate.appendChild(tag);

  categoryUpdate.value = '';

  tagValueInputUpdate.value += (tagValueInputUpdate.value !== '' ? ',' : '') + text.textContent;

  const deleteButton = document.createElement('button');
  tag.appendChild(deleteButton);
  deleteButton.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  `;
  deleteButton.classList.add("ml-2", "text-gray-500", "focus:outline-none");

  deleteButton.addEventListener("click", () => {
    tag.remove();
  });

}

}

function createTag2(id) {console.log(this);
    const closestCategoryInput = document.getElementById('categories_' + id);
    const closestTagContainer = document.getElementById('tagContainer_' + id);
    const closestTagValueInput = document.getElementById('tagValue_' + id);
    console.log(closestCategoryInput);
    console.log(closestTagContainer);
    console.log(closestTagValueInput);

    if (closestCategoryInput.value.trim() !== '' && closestTagContainer && closestTagValueInput) {
      const tag = document.createElement('span');
      const text = document.createElement('p');
      text.textContent = closestCategoryInput.value.trim();
      tag.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'flex');
      tag.appendChild(text);
      closestTagContainer.appendChild(tag);

      closestCategoryInput.value = '';

      closestTagValueInput.value += (closestTagValueInput.value !== '' ? ',' : '') + text.textContent;

      const deleteButton = document.createElement('button');
      tag.appendChild(deleteButton);
      deleteButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      `;
      deleteButton.classList.add("ml-2", "text-gray-500", "focus:outline-none");

      deleteButton.addEventListener("click", () => {
        tag.remove();
      });

    }
}

function createTag() {

    if (categoryInput.value.trim() !== '') {
      const tag = document.createElement('span');
      const text = document.createElement('p');

      text.textContent = categoryInput.value.trim();
      tag.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'flex');
      tag.appendChild(text);
      tagContainer.appendChild(tag);

      categoryInput.value = '';

      tagValueInput.value += (tagValueInput.value !== '' ? ',' : '') + text.textContent;

      const deleteButton = document.createElement('button');
      tag.appendChild(deleteButton);
      deleteButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      `;
      deleteButton.classList.add("ml-2", "text-gray-500", "focus:outline-none");

      deleteButton.addEventListener("click", () => {
        tag.remove();
      });

    }

}

const buttons = document.querySelectorAll('.addProblemCategoryButton');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const id = event.target.dataset.id;
        createTag2(id);
    });
});

categoryInput.addEventListener('keyup', function(event) {
  if (event.key === 'Enter') {
    createTag();
  }
});

addCategoryButton.addEventListener('click', function() {
  createTag();
});

if(addUpdateCategoryButton){
    addUpdateCategoryButton.addEventListener('click', function() {
        createTag3();
    });
}

// 削除ボタンがクリックされたときの処理
function handleDeleteButtonClick(event) {
  const targetElement = event.target.closest('span'); // 削除ボタンの親要素を取得
  targetElement.remove(); // 親要素を削除
}

// 削除ボタンにクリックイベントのリスナーを追加
const deleteButtons = document.querySelectorAll('.delete-button');
deleteButtons.forEach(button => {
  button.addEventListener('click', handleDeleteButtonClick);
});


</script>

<script>
  const addUrlButton = document.getElementById("add_url");
  const maxInputs = 10;
  let inputCount = 1;

  addUrlButton.addEventListener("click", () => {
    if (inputCount < maxInputs) {
      const inputContainer = document.createElement("div");
      inputContainer.classList.add("relative", 'flex', "mb-4",);

      const newInput = document.createElement("input");
      newInput.type = "text";
      newInput.name = "problem_url" + inputCount;
      newInput.placeholder = "解決に役立ったURLをコピペして下さい。";
      newInput.classList.add("flex-grow", "text-black", "border", "border-gray-300", "rounded", "px-4", "py-2", "mb-2", "focus:outline-none", "focus:ring-2", "focus:ring-blue-500");

      const deleteButton = document.createElement("button");
      deleteButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      `;
      deleteButton.classList.add("absolute", "top-0", "right-0", "mt-2", "mr-2", "text-gray-500", "focus:outline-none");

      deleteButton.addEventListener("click", () => {
        inputContainer.remove();
        inputCount--;
      });

      inputContainer.appendChild(newInput);
      inputContainer.appendChild(deleteButton);

      const parentContainer = document.getElementById("problem_url_form").parentElement;
      const addButton = document.getElementById("problem_url_form");
      parentContainer.insertBefore(inputContainer, addButton.nextSibling);

      inputCount++;
    }
  });

  const dropzone = document.getElementById('dropzone');
  
  // ドラッグ＆ドロップエリアのイベントリスナーを設定
  dropzone.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
  });

  dropzone.addEventListener('drop', (event) => {
    event.preventDefault();
    dropzone.classList.remove('dragover');

    const file = event.dataTransfer.files[0];

    // DataTransfer オブジェクトを作成
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);

    // 既存の img 要素を取得
    const existingImage = dropzone.querySelector('img');

    // 既存の img 要素が存在する場合、新しい画像で置き換える
    existingImage.src = URL.createObjectURL(file);

    // 選択されたファイルをフォームに追加
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'icon';
    input.files = dataTransfer.files;
    input.classList.add('hidden');

    dropzone.appendChild(input);

    const iconExplanation = document.getElementById('iconExplanation');
    iconExplanation.classList.add('hidden');
  }
);

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('toggle').addEventListener('change', function() {
        const dot = document.querySelector('.dot');
        const selecters = document.querySelectorAll('.prioritySelect');
        const Done = [];
        const NotYet = [];
        selecters.forEach(function(selecter) {
            const selectedIndex = selecter.selectedIndex;
            const selectedValue = selecter.options[selectedIndex].value;
            if(selectedValue == 0){
                Done.push(selecter);
            }else{
                NotYet.push(selecter);
            }
        });
        if (this.checked) {
        dot.style.transform = 'translateX(100%)';console.log(Done);
            if (Done) {
                Done.forEach(function(element) {
                    const ListContainer = element.closest('.listContainer');
                    console.log(ListContainer);
                    if(ListContainer !== null){
                        ListContainer.classList.add('hidden');
                    }
                });
            }
        } else {
        dot.style.transform = 'translateX(0)';
            if (Done) {
                Done.forEach(function(element) {
                    const ListContainer = element.closest('.listContainer');
                    if(ListContainer !== null){
                        ListContainer.classList.remove('hidden');
                    }
                });
            }
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var menuButtons = document.querySelectorAll('.menu-button');

  menuButtons.forEach(function(menuButton) {
    var menu = menuButton.nextElementSibling;

    menuButton.addEventListener('click', function() {
      menu.classList.toggle('hidden');
    });
  });
});

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
