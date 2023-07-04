<x-app-layout>
    
    <x-slot name="header">
        <a href="/"><h1 class="text-2xl font-bold">{{ __('質問一覧') }}</h1></a>
        @include('layouts.indexnavigation')
    </x-slot>

    <div class="flex justify-center">
        <div class="w-8/12">


            <div class="searchbox mb-4">
                <form action="/search" method="GET">
                    @csrf
                    <input type="text" id="keyword-input" name="keyword" placeholder="キーワードを入れてください" class="p-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-black" />
                    <br/>
                    <ul id="topkeyword-list" class="hidden bg-white border border-gray-300 rounded-lg shadow-md py-2 px-3 text-black w-1/2 max-h-40 overflow-y-auto mb-4"></ul>
                    <input type="text" id="tags-input" name="tags" placeholder="タグを入れてください" class="p-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-black" />
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">検索</button>
                    <br/>
                    <ul id="suggestion-list" class="hidden bg-white border border-gray-300 rounded-lg shadow-md py-2 px-3 text-black w-1/2 max-h-40 overflow-y-auto mb-4"></ul>
                    <div>
                        <p>タグは一つまで、Teratail専門です</p><p>キーワードはyoutubeとqittaから検索できます。</p>
                    </div>
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

          


          <div id="teratail-content" class="content hidden">
    
          <div class="container">
              <div class="card-body mx-4">
                @if(isset($questions))
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($questions ?? [] as $question)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="https://teratail.com/questions/{{$question['id']}}"/>
                            <input type="hidden" name="title" value="{{$question['title']}}"/>
                            <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 hover:text-gray-200 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="https://teratail.com/questions/{{$question['id']}}" target="_blank" class="hover:text-gray-200 font-semibold dark:hover:text-black" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                                  <!-- <img src="{{ $question['user']['photo'] }}" alt="User Avatar" class="w-6 h-6 rounded-full"> -->
                                  <span class="text-sm ml-2">{{ $question['user']['display_name'] }}</span>
                              </div>
                              <h2 class="my-6 font-semibold text-base h-[3em] overflow-hidden">{{ $question['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ $question['created'] }}</span>
                              </div>
                              </a>
                              
                              @if(in_array("https://teratail.com/questions/" . $question['id'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
            
                            
                          </li>
                        
                        </form>
                        
                      @endforeach
                  </ul>
                  @else
                  <p>該当する質問がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($question))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $questions->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

            <div id="youtube-content" class="content hidden">

            <div class="container">
                <div class="card-body mx-4">
                  @if(isset($datas))
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($datas ?? [] as $data)
                            <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}"/>
                            <input type="hidden" name="title" value="{{$data['snippet']['title']}}"/>
                            <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                            <a href="https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              
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

                            <h2 class="h-[3em] overflow-hidden my-6 font-semibold text-base">{{ $data['snippet']['title'] }}</h2>
                            <p class="h-[6em] overflow-hidden">{{ $data['snippet']['description'] }}</p>
                            <h2 class="h-[3em] overflow-hidden">https://www.youtube.com/watch?v={{ $data['id']['videoId'] }}</h2>
                            
                            {{-- <div>
                            <img src="{{ $data['snippet']['thumbnails']['default']['url'] }}" alt="Video Thumbnail">
                            </div> --}}
                            </a>
                            @if(in_array("https://www.youtube.com/watch?v=" . $data['id']['videoId'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                        </li>
                            </form>
                      @endforeach
                  </ul>
                  @else
                  <p>Youtubeに該当する質問がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($datas))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $datas->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

            <div id="qitta-content" class="content hidden">

            <div class="container">
              <div class="card-body mx-4">
                @if(isset($qittaposts))
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($qittaposts ?? [] as $qittapost)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$qittapost['url']}}"/>
                            <input type="hidden" name="title" value="{{ $qittapost['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="{{$qittapost['url']}}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                                  <img src="{{ $qittapost['user']['profile_image_url'] }}" alt="User Avatar" class="w-6 h-6 rounded-full" onerror="this.onerror=null; this.src='/images/noimage.jpg'">
                                  <span class="text-sm ml-2">{{ $qittapost['user']['id'] }}</span>
                              </div>
                              <h2 class="my-6 font-semibold text-base h-[3em] overflow-hidden">{{ $qittapost['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ $qittapost['created_at'] }}</span>
                              </div>
                              </a>
                              @if(in_array($qittapost['url'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                          </li> 
                        </form>
                      @endforeach
                  </ul>
                  @else
                  <p>qittaには該当する投稿がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($qittaposts))
            <div class="mt-4  mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $qittaposts->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>
            
            <div id="stack-overflow-content" class="content hidden">

            <!-- Stack Exchange API -->
{{--dd($stackExchangeQuestions);--}}
{{-- dd($stackExchangeQuestions[0]['owner']['profile_image']); --}}

            <div class="container">
              <div class="card-body mx-4">
                @if(isset($stackExchangeQuestions))
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($stackExchangeQuestions ?? [] as $question)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$question['link']}}"/>
                            <input type="hidden" name="title" value="{{ $question['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="{{$question['link']}}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                              @if(isset($question['owner']['profile_image']))
                                <img src="{{ $question['owner']['profile_image'] }}" alt="User Avatar" class="w-6 h-6 rounded-full" onerror="this.onerror=null; this.src='/images/noimage.jpg'">
                              @endif
                              @if(isset($question['owner']['user_id']))           
                            <span class="text-sm ml-2">{{ $question['owner']['user_id'] }}{{ $question['owner']['display_name'] }}</span>
                              @endif
                              </div>
                              <h2 class="my-6 font-semibold text-base h-[3em] overflow-hidden">{{ $question['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ date('Y-m-d H:i:s', $question['creation_date']) }}</span>
                              </div>
                              </a>
                              @if(in_array($question['link'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                          </li> 
                        </form>
                      @endforeach
                  </ul>
                  @else
                  <p>stack exchangeには該当する投稿がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($stackExchangeQuestions))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $stackExchangeQuestions->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

            <div id="stack-exchange-gamedev-content" class="content hidden">

            <!-- Stack Exchange GameDev -->
            <div class="container">
              <div class="card-body mx-4">
                @if(isset($stackGameDevQuestions))
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($stackGameDevQuestions ?? [] as $question)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$question['link']}}"/>
                            <input type="hidden" name="title" value="{{ $question['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="{{$question['link']}}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                              @if(isset($question['owner']['profile_image']))
                                <img src="{{ $question['owner']['profile_image'] }}" alt="User Avatar" class="w-6 h-6 rounded-full" onerror="this.onerror=null; this.src='/images/noimage.jpg'">
                              @endif
                              @if(isset($question['owner']['user_id']))           
                            <span class="text-sm ml-2">{{ $question['owner']['user_id'] }}{{ $question['owner']['display_name'] }}</span>
                              @endif
                              </div>
                              <h2 class="my-6 font-semibold h-[3em] overflow-hidden">{{ $question['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ date('Y-m-d H:i:s', $question['creation_date']) }}</span>
                              </div>
                              </a>
                              @if(in_array($question['link'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                          </li> 
                        </form>
                      @endforeach
                  </ul>
                  @else
                  <p>stack exchangeには該当する投稿がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($stackGameDevQuestions))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $stackGameDevQuestions->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

            <div id="stack-overflow-ja-content" class="content">

            <!-- StackOverFlowJa-->

            <div class="container">
              <div class="card-body mx-4">
                @if(isset($stackOverFlowJa))
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($stackOverFlowJa ?? [] as $question)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$question['link']}}"/>
                            <input type="hidden" name="title" value="{{ $question['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="{{$question['link']}}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                              @if(isset($question['owner']['profile_image']))
                                <img src="{{ $question['owner']['profile_image'] }}" alt="User Avatar" class="w-6 h-6 rounded-full" onerror="this.onerror=null; this.src='/images/noimage.jpg'">
                              @endif
                              @if(isset($question['owner']['user_id']))           
                            <span class="text-sm ml-2">{{ $question['owner']['user_id'] }}{{ $question['owner']['display_name'] }}</span>
                              @endif
                              </div>
                              <h2 class="my-6 font-semibold h-[3em] overflow-hidden">{{ $question['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ date('Y-m-d H:i:s', $question['creation_date']) }}</span>
                              </div>
                              </a>
                              @if(in_array($question['link'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                          </li> 
                        </form>
                      @endforeach
                  </ul>
                  @else
                  <p>stack exchangeには該当する投稿がありません。</p>
                  @endif
              </div>
            </div>

            @if(isset($stackOverFlowJa))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $stackOverFlowJa->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

            <div id="ranking-content" class="content hidden">

            <div class="container">
              <div class="card-body mx-4">
                  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach($rankings ?? [] as $ranking)
                        <form action="{{ route('storeHistory') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url" value="{{$ranking['url']}}"/>
                            <input type="hidden" name="title" value="{{ $ranking['title'] }}"/>
                          <li class="border border-gray-500 rounded-lg p-4 shadow-md bg-gray-300 duration-300 ease-in-out hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-100 dark:hover:text-black">
                              <a href="{{$ranking['url']}}" target="_blank" class="hover:text-gray-200 dark:hover:text-black font-semibold" onclick="this.closest('form').submit();">
                              <div class="flex items-center mt-2">
                              </div>
                              <h2>{{ $ranking['title'] }}</h2>
                              <div class="flex items-center mt-2">
                                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                  </svg>
                                  <span class="text-sm ml-2">{{ $ranking['created_at'] }}</span>
                              </div>
                              </a>
                              @if(in_array($ranking['url'],$likes))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon fill-pink-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
 
                              @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 heart-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                               
                              @endif
                          </li> 
                        </form>
                      @endforeach
                  </ul>
              </div>
            </div>

            @if(isset($rankings))
            <div class="mt-4 mb-4">
                <div class="flex items-center justify-center">
                    <div class="flex">
                        {{ $rankings->links('pagination::tailwindmydesign')->with(['class' => 'hover:shadow-lg']) }}
                    </div>
                </div>
            </div>
            @endif

            </div>

        </div>
        @include('layouts.jumpbutton')
        
    </div>
</x-app-layout>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heartIcons = document.querySelectorAll('.heart-icon');
        
        heartIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                this.classList.toggle('fill-pink-500');
            

        const user_id = document.querySelector("input[name='user_id']").value;
        const url = this.closest('form').querySelector("input[name='url']").value;
        const title = this.closest('form').querySelector("input[name='title']").value;
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
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // 入力フィールドを監視し、入力されるたびにサーバーにリクエストを送信
  $('#tags-input').on('input', function() {
    var tag = $(this).val();

    // サーバーにリクエストを送信
    $.ajax({
      url: '{{ route('suggest') }}', // サーバー側の処理を行うエンドポイントを指定
      method: 'GET',
      data: { tag: tag }, // キーワードをリクエストパラメータとして送信
      success: function(response) {
        // 受け取った結果を解析し、候補を表示
        var suggestions = response.suggestions;
        // suggestionsを使用してドロップダウンリストやオートコンプリートの候補を表示
        // ...
        var suggestionList = $('#suggestion-list');

        // 候補リストをクリア
        suggestionList.empty();

        // 候補リストにサジェストを追加
        suggestions.forEach(function(suggestion) {
        var listItem = $('<li></li>').text(suggestion);
        suggestionList.append(listItem);
        });

        // 候補リストを表示
        suggestionList.show();
        }
      });
    })

    // サジェストの候補をクリックしたときに入力フィールドに反映
  $(document).on('click', '#suggestion-list li', function() {
    var selectedSuggestion = $(this).text();
    $('#tags-input').val(selectedSuggestion);
    $('#suggestion-list').hide();

  });
});
</script>
<script>
$(document).on('click', function(event) {
  // クリックされた要素がサジェスト候補リスト内の要素でない場合、サジェスト候補リストを非表示にする
  if (!$(event.target).closest('#suggestion-list').length && !$(event.target) == $('#tags-input')) {
    $('#suggestion-list').hide();
  }
  if (!$(event.target).closest('#topkeyword-list').length && !$(event.target) == $('#keyword-input')) {
    $('#topkeyword-list').hide();
  }
});
</script>
<script>
    $(document).on('click', '#keyword-input', function() {
        var topKeywords = <?php echo json_encode($topKeywords); ?>;
        var topKeywordList = $('#topkeyword-list');

        topKeywordList.empty();

        topKeywords.forEach(function(topKeyword) {
        var listItem = $('<li></li>').text(topKeyword);
        topKeywordList.append(listItem);
        });

        topKeywordList.show();
  });




    $(document).on('click', '#topkeyword-list li', function() {
        selectedKeyword = $(this).text();
        $('#keyword-input').val(selectedKeyword);

        $('#topkeyword-list').hide();
    })
       
</script>
