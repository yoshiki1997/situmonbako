<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold">{{ __('質問投稿') }}</h2>
                    
                    <form method="POST" action="{{ route('questions.store') }}">
                        @csrf
                        
                        <div class="mt-4">
                            <label for="title" class="block font-medium text-gray-700">{{ __('タイトル') }}</label>
                            <input type="text" name="title" id="title" class="form-input mt-1 block w-full" required autofocus />
                        </div>
                        
                        <div class="mt-4">
                            <label for="content" class="block font-medium text-gray-700">{{ __('内容') }}</label>
                            <textarea name="content" id="content" rows="5" class="form-textarea mt-1 block w-full" required></textarea>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 rounded-md">{{ __('投稿する') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

