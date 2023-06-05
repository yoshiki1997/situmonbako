<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
    </x-slot>

    <div class="flex justify-center">
        <form class="w-full flex justify-center">
        <input type="text" name="keyword" class="w-7/12" placeholder="キーワードを入力してください">
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md ml-8">検索</button>
        </form>
    </div>
    <div class="flex justify-center items-start bg-gray-100 dark:bg-gray-700">
        <div class="max-w-xl w-full mx-auto px-4 py-8">
            <div id="problemtweets" class="space-y-4">

                @if(isset($problems))
                @foreach($problems as $problem)
                <div id="tweet" class="bg-white dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black shadow-md rounded-lg p-4 duration-300 ease-in-out">
                    <div class="flex flex-col justify-between">
                        <div class="flex flex-row justify-start ">
                            <a href="{{ route('user.page', ['id' => $problem->user->id]) }}">
                            <img src="{{ $problem->user_id }}" class="w-10 h-10 rounded-full mr-4" alt="Profile Image">
                            <h2 class="font-bold text-lg px-8">{{ $problem->user->name }}</h2>
                            </a>
                            <p class="text-gray-600 dark:text-black hover:text-white px-8 ml-auto">{{ $problem->created_at->diffForHumans() }}</p>
                            <form action="#" method="POST">@csrf編集</form>
                        </div>
                        <p class="text-xl mt-2">{{ $problem->title }}</p>
                        <p>{{ $problem->description }}</p>
                        @if($problem->problemUrl)
                        @foreach($problem->problemUrl as $problemUrl)
                        <a class="text-blue-500 hover:underline">{{ $problemUrl->url }}</a>
                        @endforeach
                        @endif
                        <div class="flex justify-end mt-4">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">いいね</button>
                            <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md ml-2">リツイート</button>
                        </div>
                        {{ $problem->title }}
                    </div>
                </div>
                @endforeach
                @endif
                <div class="flex justify-center">
                    <nav class="pagination flex">
                        {{ $problems->links('pagination::tailwind') }}
                    </nav>
                </div>
            </div>
        </div>
        <div class="w-64">
        
        </div>
    </div>

</x-app-layout>