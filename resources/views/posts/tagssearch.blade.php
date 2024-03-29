<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
    </x-slot>

    <div class="flex justify-center">
        <div class="w-8/12">


            <div class="searchbox mb-4">
                <form action="/tagssearch" method="GET">
                    @csrf
                    <input type="text" name="tags" placeholder="キーワードを入れてください" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">検索</button>
                    <br/>
                    <details class="mt-2">
                        <summary class="cursor-pointer hover:bg-gray-200 rounded-lg p-2">詳細設定</summary>
                        <div class="ml-4 flex">
                            <div class="input-group mr-2">
                                <input type="number" name="limit" value="{{ old('limit') !== null ? old('limit') : 20 }}" max="100" min="1" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" style="color: black" />
                                <div class="input-group-text">質問数</div>
                            </div>
                            <div class="input-group mr-2">
                                <input type="number" name="perPage" value="{{ old('perPage') !== null ? old('perPage') : 10 }}" max="100" min="1" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" style="color: black" />
                                <div class="input-group-text">表示する数</div>
                            </div>
                        </div>
                    </details>
                </form>
            </div>


            <div>
              <p>{{ old('tag') !== null ? old('tag') : '' }}</p>
            </div>


            <div class="container">
              <div class="card-body mx-4">
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($questions ?? [] as $question)
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 ">
                              <a href="https://teratail.com/questions/{{$question['id']}}" target="_blank" class="hover:text-gray-200 font-semibold">
                              <h2>{{ $question['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <!-- <img src="{{ $question['user']['photo'] }}" alt="User Avatar" class="w-6 h-6 rounded-full"> -->
                                  <span class="text-sm ml-2">{{ $question['user']['display_name'] }}</span>
                              </div>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ $question['created'] }}</span>
                              </div>
                              </a>
                          </li>
                      @endforeach
                  </ul>
              </div>
            </div>





            <div class="mt-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                      @if(isset($questions))
                        {{ $questions->links('pagination::tailwind')->with(['class' => 'hover:shadow-lg']) }}
                      @else
                        <p>何もありませんでした</p>
                      @endif
                      </div>
                </div>
            </div>


            


        </div>
    </div>
</x-app-layout>
