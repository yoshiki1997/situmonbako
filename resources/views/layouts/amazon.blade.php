<div class="mt-8 -mb-3">
<div class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
<div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
<div class="relative rounded-xl overflow-auto max-h-[50rem] overflow-y-auto">
    <div class="shadow-sm overflow-hidden my-8">
        <table class="border-collapse table-auto w-full text-sm">
            <thead>
                <tr>
                    <th class="w-full border-b dark:border-slate-600 font-medium  text-3xl underlinep-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center">amazon ランキング</th>
                    <!--<th class="w-2/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">タイトル</th>
                    <th class="w-1/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">著者</th>
                    <th class="w-1/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">価格</th>
                    <th class="w-1/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">出版日</th>
                    <th class="w-1/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">レビュー</th>
                    <th class="w-1/7 border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">送料</th>-->
                    <!-- 必要な他のカラムを追加 -->
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
                @foreach ($records as $record)
                    
                        <tr class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-900" onclick="window.location.href='{{ $record['product_url'] }}';">
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 flex flex-col">
                                <div class="w-64 h-64 flex justify-center items-center">
                                    <img src="{{ $record['画像URL'] }}" alt="{{ $record['title'] }}"  class="object-contain h-full w-full"/>
                                </div>
                                <div class="mt-4 mx-4">
                                    <p>{{ $record['title'] }}</p>
                                    <p>{{ $record['auther1'] }}{{ $record['auther2'] }}{{ $record['otherauther'] }}</p>
                                    <p>{{ $record['price'] }}{{ $record['points'] }}</p>
                                    <p>{{ $record['publishdate'] }}</p>
                                    <p>{{ $record['arow2'] }}{{ $record['stare'] }}{{ $record['review'] }}</p>
                                    <p>{{ $record['arow4'] }}{{ $record['Arrival_date'] }}{{ $record['word'] }}{{ $record['Arrival_price'] }}</p>
                                </dvi>
                            </td>
                            <!--
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['title'] }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['auther1'] }}{{ $record['auther2'] }}{{ $record['otherauther'] }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['price'] }}{{ $record['points'] }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['publishdate'] }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['arow2'] }}{{ $record['stare'] }}{{ $record['review'] }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $record['arow4'] }}{{ $record['Arrival_date'] }}{{ $record['word'] }}{{ $record['Arrival_price'] }}</td>
                            -->
                            <!-- 必要な他のカラムを追加 -->
                        </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
</div>
</div>