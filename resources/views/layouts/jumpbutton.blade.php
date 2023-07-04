<div class=" bg-white dark:bg-gray-700 shadow">
    <div class="h-16 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="h-full flex justify-end">
            <div class="fixed bottom-4 right-4">
                <button id="jumpbutton" type="button" class="hidden">
                    <i class="fa-solid fa-square-caret-up fa-2xl"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const jumpbutton = document.getElementById('jumpbutton');

    window.addEventListener('scroll', function () {
       if(window.pageYOffset < 5){
        jumpbutton.classList.add('hidden');
       } else {
        jumpbutton.classList.remove('hidden');
       }
    });

    jumpbutton.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>