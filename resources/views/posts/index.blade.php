<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
    </x-slot>
    <div class="flex justify-center">
        <div class="w-8/12">


            <div class="searchbox mb-4">
                <form action="/tagssearch" method="GET">
                    @csrf
                    <input type="text" name="keyword" placeholder="キーワードを入れてください" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">検索</button>
                    <br/>
                    <input type="text" name="tags" placeholder="タグを入れてください" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
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


            <div class="container">
              <div class="card-body mx-4">
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($questions ?? [] as $question)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="https://teratail.com/questions/{{$question['id']}}"/>
                            <input type="hidden" name="title" value="{{$question['title']}}"/>
                            <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 hover:text-gray-200 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="https://teratail.com/questions/{{$question['id']}}" target="_blank" class="hover:text-gray-200 font-semibold" onclick="this.closest('form').submit();">
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
                        <svg class="heart-icon w-4 h-4" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <use xlink:href="{{ asset('image/heart-svgrepo-com.svg#Layer_1') }}"></use>
                        </svg>
                        </form>
                        
                      @endforeach
                  </ul>
              </div>
            </div>

            <div class="mt-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $questions->links('pagination::tailwind')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>





            <div class="container">
                <div class="card-body mx-4">
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($datas ?? [] as $data)
                            <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}"/>
                            <input type="hidden" name="title" value="{{$data['snippet']['title']}}"/>
                            <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 ">
                            <a href="https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}">
                              
                        <div class="relative">
                            <img src="{{ $data['snippet']['thumbnails']['default']['url'] }}" alt="Video Thumbnail" class="w-full h-auto">
                            <div class="absolute inset-0 bg-black opacity-0 hover:opacity-50 transition-opacity">
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6L4 12l5 6M20 12h-8m4 0a4 4 0 110-8 4 4 0 010 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                            <h2>{{ $data['snippet']['title'] }}</h2>
                            <p>{{ $data['snippet']['description'] }}</p>
                            <h2>https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}</h2>
                            
                            {{-- <div>
                            <img src="{{ $data['snippet']['thumbnails']['default']['url'] }}" alt="Video Thumbnail">
                            </div> --}}
                            </a>
                        </li>
                            </form>
                      @endforeach
                  </ul>
              </div>
            </div>

            <div class="mt-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $datas->links('pagination::tailwind')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>





            <div class="container">
              <div class="card-body mx-4">
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($qittaposts ?? [] as $qittapost)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$qittapost['url']}}"/>
                            <input type="hidden" name="title" value="{{ $qittapost['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-white ">
                              <a href="{{$qittapost['url']}}" target="_blank" class="hover:text-gray-200 font-semibold">
                              <div class="flex items-center mt-2">
                                  <img src="{{ $qittapost['user']['profile_image_url'] }}" alt="User Avatar" class="w-6 h-6 rounded-full">
                                  <span class="text-sm ml-2">{{ $qittapost['user']['id'] }}</span>
                              </div>
                              <h2>{{ $qittapost['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ $qittapost['created_at'] }}</span>
                              </div>
                              </a>
                          </li> 
                        </form>
                      @endforeach
                  </ul>
              </div>
            </div>

            <div class="mt-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $datas->links('pagination::tailwind')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heartIcons = document.querySelectorAll('.heart-icon');
        
        heartIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                this.classList.toggle('filled');
            

        const user_id = document.querySelector("input[name='user_id']").value;
        const url = document.querySelector("input[name='url']").value;

        fetch("{{ route('likes.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: user_id,
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
</script>
