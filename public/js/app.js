// 各項目の要素を取得します
const stackOverflowItem = document.getElementById('stack-overflow-item');
const qittaItem = document.getElementById('qitta-item');
const teratailItem = document.getElementById('teratail-item');
const youtubeItem = document.getElementById('youtube-item');
const stackexchangegamedevItem = document.getElementById('stack-exchange-gamedev-item');
const stackoverflowjaItem = document.getElementById('stack-overflow-ja-item');
const rankingItem = document.getElementById('ranking-item');

// 各項目のコンテンツ要素を取得します
const stackOverflowContent = document.getElementById('stack-overflow-content');
const qittaContent = document.getElementById('qitta-content');
const teratailContent = document.getElementById('teratail-content');
const youtubeContent = document.getElementById('youtube-content');
const stackexchangegamedevContent = document.getElementById('stack-exchange-gamedev-content');
const stackoverflowjaContent = document.getElementById('stack-overflow-ja-content');
const rankingContent = document.getElementById('ranking-content');

// 各項目のクリックイベントを設定します
stackOverflowItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(stackOverflowItem);
    stackOverflowContent.classList.remove('hidden');
});

qittaItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(qittaItem);
    qittaContent.classList.remove('hidden');
});

teratailItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(teratailItem);
    teratailContent.classList.remove('hidden');
});

youtubeItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(youtubeItem);
    youtubeContent.classList.remove('hidden');
});

stackexchangegamedevItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(stackexchangegamedevItem);
    stackexchangegamedevContent.classList.remove('hidden');
});

stackoverflowjaItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(stackoverflowjaItem);
    stackoverflowjaContent.classList.remove('hidden');
});

rankingItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(rankingItem);
    rankingContent.classList.remove('hidden');
});

// すべてのコンテンツを非表示にする関数
function hideAllContent() {
    const contents = document.querySelectorAll('.content');
    contents.forEach(content => {
      content.classList.add('hidden');
    });
  }

  // アクティブな項目を設定する関数
function setActiveItem(item) {
    const items = document.querySelectorAll('.index-list');
    items.forEach(item => {
      item.classList.remove('bg-gray-200');
      item.classList.remove('text-gray-600');
    });
    item.classList.add('bg-gray-200');
    item.classList.add('text-gray-600');
  }