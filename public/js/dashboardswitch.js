// 各項目の要素を取得します
const favoriteItem = document.getElementById('favorite-item');
const problemsItem = document.getElementById('problems-item');
const historyItem = document.getElementById('history-item');
const followingItem = document.getElementById('following-item');

// 各項目のコンテンツ要素を取得します
const favoriteContent = document.getElementById('favorite-content');
const problemsContent = document.getElementById('problems-content');
const historyContent = document.getElementById('history-content');
const followingContent = document.getElementById('following-content');

favoriteItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(favoriteItem);
    favoriteContent.classList.remove('hidden');
});

problemsItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(problemsItem);
    problemsContent.classList.remove('hidden');
});

historyItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(historyItem);
    historyContent.classList.remove('hidden');
});

followingItem.addEventListener('click', () => {
    hideAllContent();
    setActiveItem(followingItem);
    followingContent.classList.remove('hidden');
});

function hideAllContent() {
    const contents = document.querySelectorAll('.content');
    contents.forEach(content => {
        content.classList.add('hidden');
    });
}

function setActiveItem(item) {
    const items = document.querySelectorAll('.dashboard-list');
    items.forEach(item => {
        item.classList.remove('bg-gray-600');
        item.classList.remove('text-gray-200');
    });
    item.classList.add('bg-gray-600');
    item.classList.add('text-gray-200');
}