<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips and Best Practices - Smart Planner</title>
    
    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}"> <!-- Matching the Task Management styles -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Material Icons (Google) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" id="menu-icon" tabindex="0" aria-label="Toggle Sidebar" role="button">
                <i class="bi bi-list"></i>
            </div>
            <div class="title">Tips & Best Practices</div>
            <!-- Optional Profile icon, matching Task Management header structure -->
        </header>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Illustration (with controlled size) -->
            <div class="illustration-wrapper" style="text-align: center;">
                <img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="illustration" style="max-width: 60%; height: auto;">
            </div>

            <!-- Tips Container -->
            <div class="tips-container">
                <div class="card modal-trigger" data-target="modal-time-management">
                    <div class="card-content">
                        <h3>Time Management</h3>
                        <p>Learn effective techniques to manage your time and boost productivity.</p>
                    </div>
                </div>
                <div class="card modal-trigger" data-target="modal-budgeting-strategies">
                    <div class="card-content">
                        <h3>Budgeting Strategies</h3>
                        <p>Explore proven strategies to create and maintain a successful budget.</p>
                    </div>
                </div>
                <div class="card modal-trigger" data-target="modal-savings-techniques">
                    <div class="card-content">
                        <h3>Savings Techniques</h3>
                        <p>Discover ways to save effectively and grow your financial security.</p>
                    </div>
                </div>
                <div class="card modal-trigger" data-target="modal-debt-management">
                    <div class="card-content">
                        <h3>Debt Management</h3>
                        <p>Understand how to manage and reduce debt for financial freedom.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Structures -->

   <!-- Time Management Modal -->
<div id="modal-time-management" class="modal">
    <div class="modal-content">
        <h4>Time Management</h4>
        <div class="modal-illustration">
            <img src="{{ asset('images/illustr.png') }}" alt="Time Management" class="modal-illustration" style="max-width: 150px; width: 100%; height: auto;" />
        </div>
        <div class="modal-content-wrapper">
            <h5>Overview:</h5>
            <p>Time management is essential for achieving your goals and maintaining a work-life balance.</p>
            <h5>Tips:</h5>
            <ul>
                <li>Set clear goals using the SMART criteria.</li>
                <li>Use a planner or digital tools to organize tasks by priority.</li>
                <li>Break tasks into smaller, manageable steps.</li>
                <li>Allocate specific time slots for focused work.</li>
                <li>Regularly review and adjust your schedule.</li>
            </ul>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>


    <!-- Budgeting Strategies Modal -->
    <div id="modal-budgeting-strategies" class="modal">
        <div class="modal-content">
            <h4>Budgeting Strategies</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/illustration_budgeting.png') }}" alt="Budgeting Strategies" class="modal-illustration" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Effective budgeting helps in managing finances, reducing stress, and saving for future goals.</p>
                <h5>Tips:</h5>
                <ul>
                    <li>Track your expenses to understand your spending habits.</li>
                    <li>Create a monthly budget that includes all income and fixed/variable expenses.</li>
                    <li>Use the 50/30/20 rule for budget allocation.</li>
                    <li>Review your budget regularly and adjust as necessary.</li>
                    <li>Consider using budgeting apps for real-time tracking.</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Savings Techniques Modal -->
    <div id="modal-savings-techniques" class="modal">
        <div class="modal-content">
            <h4>Savings Techniques</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/illustration_savings.png') }}" alt="Savings Techniques" class="modal-illustration" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Building savings is crucial for financial security and future investments.</p>
                <h5>Tips:</h5>
                <ul>
                    <li>Pay yourself first by setting aside a portion of your income.</li>
                    <li>Open a separate savings account to keep funds out of reach.</li>
                    <li>Automate your savings to make the process effortless.</li>
                    <li>Look for high-yield savings accounts for better growth.</li>
                    <li>Set specific savings goals to stay motivated.</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Debt Management Modal -->
    <div id="modal-debt-management" class="modal">
        <div class="modal-content">
            <h4>Debt Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/illustration_debt_management.png') }}" alt="Debt Management" class="modal-illustration" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Understanding and managing debt is vital for achieving financial freedom and reducing stress.</p>
                <h5>Tips:</h5>
                <ul>
                    <li>List all your debts with amounts and interest rates.</li>
                    <li>Consider the snowball or avalanche method for repayments.</li>
                    <li>Negotiate with creditors for lower rates.</li>
                    <li>Avoid accumulating more debt by creating a spending plan.</li>
                    <li>Seek professional help if overwhelmed.</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script> <!-- Sidebar JavaScript -->
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize all Materialize Modals
        const modalElems = document.querySelectorAll('.modal');
        M.Modal.init(modalElems);

        // Initialize Sidebar Toggle
        const menuIcon = document.getElementById('menu-icon');
        menuIcon.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const sidebar = document.querySelector('.sidebar'); // Adjust selector as needed
                sidebar.classList.toggle('open');
            }
        });

        // Initialize Modal Triggers
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        modalTriggers.forEach(trigger => {
            const targetModalId = trigger.getAttribute('data-target');
            const modalInstance = M.Modal.getInstance(document.getElementById(targetModalId));
            trigger.addEventListener('click', () => {
                modalInstance.open();
            });
        });
    });
    </script>
</body>
</html>
