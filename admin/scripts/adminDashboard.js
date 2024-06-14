document.addEventListener('DOMContentLoaded', function () {
    const bottomSidebarLinks = document.querySelectorAll('.navbar.sidebar-bottom a.nav-link');
    const tabContentPanes = document.querySelectorAll('.tab-content .tab-pane');

    // const modeToggleBtn = document.querySelector(".modeToggleBtn");

    // const editUserBtns = document.querySelectorAll('#editUserBtn');
    // editUserBtns.forEach(btn => {
    //     btn.addEventListener('click', function () {
    //         const row = btn.closest('tr');

    //         const username = row.querySelector('td:nth-child(3)').innerText;
    //         const email = row.querySelector('td:nth-child(4)').innerText;
    //         const status = row.querySelector('td:nth-child(5) select').value;

    //         document.getElementById('editUsername').value = username;
    //         document.getElementById('editEmail').value = email;
    //         document.getElementById('editStatus').value = status;
    //     });
    // });

    bottomSidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            if (this.getAttribute('href') === 'logout.php') {
                return;
            }

            event.preventDefault();
            const tabId = this.getAttribute('href').substring(1);
            tabContentPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
                if (pane.id === tabId) {
                    pane.classList.add('show', 'active');
                }
            });
            bottomSidebarLinks.forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    const searchInput = document.getElementById('searchInput');
    const table = document.querySelector('table');
    const tr = table.getElementsByTagName('tr');

    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toUpperCase();
        
        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[2];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1 || filter === "") {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    });
});
