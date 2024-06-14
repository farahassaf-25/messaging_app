document.addEventListener('DOMContentLoaded', function() {
    const modeToggleBtns = document.querySelectorAll('.theme-toggle');
    const modeToggleBtn = document.querySelector('.theme-toggle-sidebar-alt');
    
    function applyDarkMode() {
        document.body.classList.add('dark-mode');
    }

    function removeDarkMode() {
        document.body.classList.remove('dark-mode');
    }

    if (localStorage.getItem('theme') === 'dark') {
        applyDarkMode();
    } else {
        removeDarkMode();
    }

    modeToggleBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            if (document.body.classList.contains('dark-mode')) {
                removeDarkMode();
                localStorage.setItem('theme', 'light');
            } else {
                applyDarkMode();
                localStorage.setItem('theme', 'dark');
            }
        });
    });

    modeToggleBtn.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            if (document.body.classList.contains('dark-mode')) {
                removeDarkMode();
                localStorage.setItem('theme', 'light');
            } else {
                applyDarkMode();
                localStorage.setItem('theme', 'dark');
            }
        });
    });
});
