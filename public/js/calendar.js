document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'customPrev,customNext,customToday,customThisMonth,customThisWeek',
            center: 'title',
            right: ''
        },
        customButtons: {
            customPrev: {
                text: '<',
                click: function() {
                    calendar.prev();
                }
            },
            customNext: {
                text: '>',
                click: function() {
                    calendar.next();
                }
            },
            customToday: {
                text: 'Today',
                click: function() {
                    calendar.today();
                }
            },
            customThisMonth: {
                text: 'This Month',
                click: function() {
                    calendar.changeView('dayGridMonth');
                }
            },
            customThisWeek: {
                text: 'This Week',
                click: function() {
                    calendar.changeView('timeGridWeek');
                }
            }
        },
        eventSources: [
            {
                url: '/calendar/tasks',
                method: 'GET',
                failure: function() {
                    alert('There was an error while fetching tasks!');
                },
                color: 'blue',
                textColor: 'white'
            },
            {
                url: '/calendar/expenses',
                method: 'GET',
                failure: function() {
                    alert('There was an error while fetching expenses!');
                },
                color: 'red',
                textColor: 'white'
            },
            {
                url: '/calendar/savings',
                method: 'GET',
                failure: function() {
                    alert('There was an error while fetching savings!');
                },
                color: 'green',
                textColor: 'white'
            },
            {
                url: '/calendar/debts',
                method: 'GET',
                failure: function() {
                    alert('There was an error while fetching debts!');
                },
                color: 'purple',
                textColor: 'white'
            }
        ]
    });
    calendar.render();

    // Sidebar toggle
    var sidebar = document.getElementById('sidebar');
    var menuIcon = document.getElementById('menu-icon');
    menuIcon.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });

    // FAB toggle
    var fab = document.getElementById('fab');
    var fabOptions = document.getElementById('fab-options');
    fab.addEventListener('click', function() {
        fabOptions.classList.toggle('show');
    });
});
