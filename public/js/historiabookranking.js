window.addEventListener('scroll', function() {
    var element = document.getElementById('bookranking'); // スクロールに追従させたい要素のIDを指定
    var windowHeight = window.innerHeight;
    var elementHeight = element.offsetHeight;
    var scrollPosition = window.scrollY;
    var topOffset = 20; // 追従位置の上部オフセット

    if (scrollPosition > elementHeight - windowHeight + topOffset) {
        element.style.position = 'fixed';
        element.style.top = (windowHeight - elementHeight + topOffset) + 'px';
    } else {
        element.style.position = 'static';
        element.style.top = 'auto';
    }
});
