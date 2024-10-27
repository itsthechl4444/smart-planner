document.addEventListener('DOMContentLoaded', () => {
    // Initialize Materialize components
    M.Tabs.init(document.querySelectorAll('.tabs'));

    // FAB button toggle functionality
    document.getElementById('fab').addEventListener('click', () => {
        document.getElementById('fab-options').classList.toggle('show');
    });

    document.querySelectorAll('.fab-option').forEach(option => {
        option.addEventListener('click', () => {
            window.location.href = option.getAttribute('data-action');
        });
    });

    // Filter functionality for task cards
    const filterButtons = document.querySelectorAll('.filter-btn');
    const taskCards = document.querySelectorAll('.task-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');

            // Update filter button active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter task cards based on selected filter
            taskCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const cardDue = new Date(card.getAttribute('data-due'));
                const today = new Date();

                let showCard = false;
                switch (filter) {
                    case 'all':
                        showCard = true;
                        break;
                    case 'today':
                        showCard = cardDue.toDateString() === today.toDateString();
                        break;
                    case 'pending':
                        showCard = cardStatus === 'pending';
                        break;
                    case 'completed':
                        showCard = cardStatus === 'completed';
                        break;
                }

                card.style.display = showCard ? 'block' : 'none';
            });
        });
    });

    // Mark as Completed functionality
    document.querySelectorAll('.mark-completed-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const taskId = event.target.closest('.task-card').id.split('-')[1];

            fetch(`/tasks/${taskId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ completed: true })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Move the task card to the "Completed" section
                    const taskCard = document.getElementById(`task-${taskId}`);
                    taskCard.setAttribute('data-status', 'completed');
                    taskCard.querySelector('.mark-completed-btn').remove();

                    // Apply the filter logic after marking as completed
                    const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
                    if (activeFilter !== 'completed') {
                        taskCard.style.display = 'none';
                    }

                    // Show feedback message
                    showSnackbar('Task marked as completed!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Sidebar toggle functionality
    document.getElementById('menu-icon').addEventListener('click', () => {
        document.querySelector('aside').classList.toggle('show');
    });

    // Snackbar display function
    function showSnackbar(message) {
        const snackbar = document.getElementById('snackbar');
        snackbar.querySelector('span').textContent = message;
        snackbar.classList.add('show');

        setTimeout(() => {
            snackbar.classList.remove('show');
        }, 3000);
    }
});
