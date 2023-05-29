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

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    閲覧履歴
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    役立ったYOした投稿
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    あなたの失敗履歴
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
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

    <div class="pt-12">
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
        max-height: 500px; /* 適切な高さに変更してください */
    }
</style>
