<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Management</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/financemanagement.css') }}"> <!-- Custom Finance Management CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" id="menu-icon">
                <i class="bi bi-list"></i>
            </div>
            <div class="title">Finance Management</div>
        </header>

        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Search Bar -->
            <div class="global-search">
                <div class="finance-search">
                    <i class="bi bi-search search-icon" aria-hidden="true"></i>
                    <input type="text" id="finance-search-input" placeholder="Search Finance Records..." aria-label="Search Finance Records" />
                    <i class="bi bi-x-circle-fill clear-search" id="clear-search" aria-hidden="true"></i>
                </div>
            </div>

            <!-- Search Results Section -->
            <div id="search-results" class="tab-content">
                <h2>Search Results</h2>
                <div class="search-cards">
                    <!-- Matching cards will be dynamically inserted here -->
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'accounts')">Accounts</button>
                <button class="tab-link" onclick="openTab(event, 'income')">Income</button>
                <button class="tab-link" onclick="openTab(event, 'expenses')">Expenses</button>
                <button class="tab-link" onclick="openTab(event, 'debts')">Debts</button>
                <button class="tab-link" onclick="openTab(event, 'savings')">Savings</button>
                <button class="tab-link" onclick="openTab(event, 'budgets')">Budgets</button>
            </div>

            <!-- Accounts Section -->
            <div id="accounts" class="tab-content active">
                <div class="filter-container">
                    <!-- Add any filters specific to accounts if needed -->
                </div>

                <!-- Account Cards Container -->
                <div class="account-cards">
                    @if ($accounts->isEmpty())
                        <!-- No accounts -->
                        <div class="nothing-here" id="no-accounts-message" style="display: flex;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No accounts yet.</p>
                        </div>
                    @else
                        @foreach($accounts as $account)
                            <div class="card account-card" 
                                data-account-id="{{ $account->id }}">
                                <div class="card-content">
                                    <div class="account-info">
                                        <span class="card-title">{{ $account->name }}</span>
                                        <p>Balance: {{ number_format($account->balance, 2) }} {{ $account->currency }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- 'Nothing here' illustration, initially hidden -->
                        <div class="nothing-here" id="no-accounts-message" style="display: none;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No accounts yet.</p>
                        </div>
                    @endif
                </div>

                <!-- View All Accounts Link -->
                <div class="view-all-link" id="view-all-accounts-link">
                    <a href="{{ route('accounts.index') }}">View All Accounts</a>
                </div>
            </div>

            <!-- Income Section -->
            <div id="income" class="tab-content">
                <div class="filter-container">
                    <!-- Add any filters specific to income if needed -->
                </div>

                <!-- Income Cards Container -->
                <div class="income-cards">
                    @if ($incomes->isEmpty())
                        <!-- No incomes -->
                        <div class="nothing-here" id="no-income-message" style="display: flex;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No income records yet.</p>
                        </div>
                    @else
                        @foreach($incomes as $income)
                            <div class="card income-card" 
                                data-income-id="{{ $income->id }}">
                                <div class="card-content">
                                    <div class="income-info">
                                        <span class="card-title">{{ $income->source_name }}</span>
                                        <p>Amount: {{ number_format($income->amount, 2) }}</p>
                                        <p>Date: {{ \Carbon\Carbon::parse($income->date)->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- 'Nothing here' illustration, initially hidden -->
                        <div class="nothing-here" id="no-income-message" style="display: none;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No income records yet.</p>
                        </div>
                    @endif
                </div>

                <!-- View All Income Link -->
                <div class="view-all-link" id="view-all-income-link">
                    <a href="{{ route('incomes.index') }}">View All Income</a>
                </div>
            </div>

            <!-- Expenses Section -->
            <div id="expenses" class="tab-content">
                <div class="filter-container">
                    <!-- Add any filters specific to expenses if needed -->
                </div>

                <!-- Expense Cards Container -->
                <div class="expense-cards">
                    @if ($expenses->isEmpty())
                        <!-- No expenses -->
                        <div class="nothing-here" id="no-expenses-message" style="display: flex;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No expense records yet.</p>
                        </div>
                    @else
                        @foreach($expenses as $expense)
                            <div class="card expense-card" 
                                data-expense-id="{{ $expense->id }}">
                                <div class="card-content">
                                    <div class="expense-info">
                                        <span class="card-title">{{ $expense->name }}</span>
                                        <p>Amount: {{ number_format($expense->amount, 2) }}</p>
                                        <p>Date: {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- 'Nothing here' illustration, initially hidden -->
                        <div class="nothing-here" id="no-expenses-message" style="display: none;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No expense records yet.</p>
                        </div>
                    @endif
                </div>

                <!-- View All Expenses Link -->
                <div class="view-all-link" id="view-all-expenses-link">
                    <a href="{{ route('expenses.index') }}">View All Expenses</a>
                </div>
            </div>

            <!-- Debts Section -->
            <div id="debts" class="tab-content">
                <div class="filter-container">
                    <!-- Add any filters specific to debts if needed -->
                </div>

                <!-- Debt Cards Container -->
                <div class="debt-cards">
                    @if ($debts->isEmpty())
                        <!-- No debts -->
                        <div class="nothing-here" id="no-debts-message" style="display: flex;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No debt records yet.</p>
                        </div>
                    @else
                        @foreach($debts as $debt)
                            <div class="card debt-card" 
                                data-debt-id="{{ $debt->id }}">
                                <div class="card-content">
                                    <div class="debt-info">
                                        <span class="card-title">{{ $debt->name }}</span>
                                        <p>Amount: {{ number_format($debt->amount, 2) }}</p>
                                        <p>Due Date: {{ \Carbon\Carbon::parse($debt->due_date)->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- 'Nothing here' illustration, initially hidden -->
                        <div class="nothing-here" id="no-debts-message" style="display: none;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No debt records yet.</p>
                        </div>
                    @endif
                </div>

                <!-- View All Debts Link -->
                <div class="view-all-link" id="view-all-debts-link">
                    <a href="{{ route('debts.index') }}">View All Debts</a>
                </div>
            </div>

            <!-- Savings Section -->
<div id="savings" class="tab-content">
    <div class="filter-container">
        <!-- Add any filters specific to savings if needed -->
    </div>

    <!-- Savings Cards Container -->
    <div class="saving-cards">
        @if ($savings->isEmpty())
            <!-- No savings -->
            <div class="nothing-here" id="no-savings-message" style="display: flex;">
                <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                <p>No savings records yet.</p>
            </div>
        @else
            @foreach($savings as $saving)
                <div class="card saving-card" data-saving-id="{{ $saving->id }}">
                    <div class="card-content">
                        <div class="saving-info">
                            <span class="card-title">{{ $saving->name }}</span>
                            <p><strong>Desired Amount:</strong> {{ number_format($saving->desired_amount, 2) }} {{ $saving->currency }}</p>
                            <p><strong>Amount Saved:</strong> {{ number_format($saving->total_saved, 2) }} {{ $saving->currency }}</p>
                            <p><strong>Desired Date:</strong> 
                                @if($saving->desired_date)
                                    {{ \Carbon\Carbon::parse($saving->desired_date)->format('Y-m-d') }}
                                @else
                                    Not Set
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- 'Nothing here' illustration, initially hidden -->
            <div class="nothing-here" id="no-savings-message" style="display: none;">
                <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                <p>No savings records yet.</p>
            </div>
        @endif
    </div>

    <!-- View All Savings Link -->
    <div class="view-all-link" id="view-all-savings-link">
        <a href="{{ route('savings.index') }}">View All Savings</a>
    </div>
</div>



            <!-- Budgets Section -->
            <div id="budgets" class="tab-content">
                <div class="filter-container">
                    <!-- Add any filters specific to budgets if needed -->
                </div>

                <!-- Budget Cards Container -->
                <div class="budget-cards">
                    @if ($budgets->isEmpty())
                        <!-- No budgets -->
                        <div class="nothing-here" id="no-budgets-message" style="display: flex;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No budget records yet.</p>
                        </div>
                    @else
                        @foreach($budgets as $budget)
                            <div class="card budget-card" 
                                data-budget-id="{{ $budget->id }}">
                                <div class="card-content">
                                    <div class="budget-info">
                                        <span class="card-title">{{ $budget->name }}</span>
                                        <p>Amount: {{ number_format($budget->amount, 2) }}</p>
                                        <p>Spent: {{ number_format($budget->spent, 2) }}</p>
                                        <p>Remaining: {{ number_format($budget->amount - $budget->spent, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- 'Nothing here' illustration, initially hidden -->
                        <div class="nothing-here" id="no-budgets-message" style="display: none;">
                            <img src="{{ asset('images/empty.svg') }}" alt="Nothing here yet">
                            <p>No budget records yet.</p>
                        </div>
                    @endif
                </div>

                <!-- View All Budgets Link -->
                <div class="view-all-link" id="view-all-budgets-link">
                    <a href="{{ route('budgets.index') }}">View All Budgets</a>
                </div>
            </div>
        </main>

        <!-- Floating Action Button -->
        <div class="fab" id="fab">
            <i class="bi bi-plus"></i>
        </div>
        <div class="fab-options" id="fab-options">
            <div class="fab-option" data-action="{{ route('accounts.create') }}">
                <i class="bi bi-wallet"></i> <span>New Account</span>
            </div>
            <div class="fab-option" data-action="{{ route('incomes.create') }}">
                <i class="bi bi-cash-stack"></i> <span>New Income</span>
            </div>
            <div class="fab-option" data-action="{{ route('expenses.create') }}">
                <i class="bi bi-receipt"></i> <span>New Expense</span>
            </div>
            <div class="fab-option" data-action="{{ route('debts.create') }}">
                <i class="bi bi-credit-card"></i> <span>New Debt</span>
            </div>
            <div class="fab-option" data-action="{{ route('savings.create') }}">
                <i class="bi bi-piggy-bank"></i> <span>New Saving</span>
            </div>
            <div class="fab-option" data-action="{{ route('budgets.create') }}">
                <i class="bi bi-bar-chart"></i> <span>New Budget</span>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Define the base URLs here
                const routeBases = {
                    account: "{{ url('accounts') }}/",
                    income: "{{ url('incomes') }}/",
                    expense: "{{ url('expenses') }}/",
                    debt: "{{ url('debts') }}/",
                    saving: "{{ url('savings') }}/",
                    budget: "{{ url('budgets') }}/",
                };

                // Define card types and their corresponding tab IDs
                const cardTypes = ['account', 'income', 'expense', 'debt', 'saving', 'budget'];
                const tabIds = {
                    account: 'accounts',
                    income: 'income',       // Correct mapping for 'income'
                    expense: 'expenses',
                    debt: 'debts',
                    saving: 'savings',
                    budget: 'budgets'
                };

                // FAB button toggle functionality
                const fab = document.getElementById('fab');
                const fabOptions = document.getElementById('fab-options');

                fab.addEventListener('click', () => {
                    fabOptions.classList.toggle('show');
                });

                document.querySelectorAll('.fab-option').forEach(option => {
                    option.addEventListener('click', () => {
                        window.location.href = option.getAttribute('data-action');
                    });
                });

                // Event Delegation for Card Navigation
                const mainContent = document.querySelector('.main-content');

                mainContent.addEventListener('click', (event) => {
                    // Find the closest parent with class 'card'
                    const card = event.target.closest('.card');
                    if (card) {
                        // Determine the card type based on its class
                        let type = '';
                        if (card.classList.contains('account-card')) {
                            type = 'account';
                        } else if (card.classList.contains('income-card')) {
                            type = 'income';
                        } else if (card.classList.contains('expense-card')) {
                            type = 'expense';
                        } else if (card.classList.contains('debt-card')) {
                            type = 'debt';
                        } else if (card.classList.contains('saving-card')) {
                            type = 'saving';
                        } else if (card.classList.contains('budget-card')) {
                            type = 'budget';
                        }

                        if (type) {
                            const id = card.getAttribute(`data-${type}-id`);
                            if (id) {
                                const url = `${routeBases[type]}${id}`;
                                window.location.href = url;
                            } else {
                                console.error(`No ID found for ${type} card.`);
                            }
                        }
                    }
                });

                // Initial check for each tab to show/hide "Nothing Here" messages and "View All" links
                cardTypes.forEach(type => {
                    const cards = document.querySelectorAll(`.${type}-card`);
                    const noMessage = document.getElementById(`no-${type}s-message`);
                    const viewAllLink = document.getElementById(`view-all-${type}s-link`);

                    if (cards.length === 0) {
                        if (noMessage) {
                            noMessage.style.display = 'flex';
                        }
                        if (viewAllLink) {
                            viewAllLink.style.display = 'none';
                        }
                    } else {
                        if (noMessage) {
                            noMessage.style.display = 'none';
                        }
                        if (viewAllLink) {
                            viewAllLink.style.display = 'block';
                        }
                    }
                });

                // Search functionality
                const searchInput = document.getElementById('finance-search-input');
                const clearSearch = document.getElementById('clear-search');
                const searchResults = document.getElementById('search-results');
                const searchCardsContainer = searchResults.querySelector('.search-cards');
                const tabsDiv = document.querySelector('.tabs'); // Reference to the tabs div

                // Debounce Function to limit the rate of search execution
                function debounce(func, delay) {
                    let debounceTimer;
                    return function() {
                        const context = this;
                        const args = arguments;
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => func.apply(context, args), delay);
                    }
                }

                searchInput.addEventListener('input', debounce(function() {
                    const query = this.value.toLowerCase().trim();

                    if (query.length === 0) {
                        // If search is cleared, hide search results and show active tab
                        searchResults.style.display = 'none';
                        searchCardsContainer.innerHTML = ''; // Clear previous search results
                        tabsDiv.style.display = 'flex'; // Show the tabs
                        cardTypes.forEach(type => {
                            const tab = document.getElementById(tabIds[type]);
                            if (tab.classList.contains('active')) {
                                tab.style.display = 'block';
                            } else {
                                tab.style.display = 'none';
                            }
                        });
                        return;
                    }

                    // Perform global search across all categories
                    // Hide all tabs
                    tabsDiv.style.display = 'none'; // Hide the tabs
                    cardTypes.forEach(type => {
                        const tab = document.getElementById(tabIds[type]);
                        if (tab) {
                            tab.style.display = 'none';
                        }
                    });

                    // Clear previous search results
                    searchCardsContainer.innerHTML = '';

                    // Iterate over all card types and append matching cards to search-results
                    cardTypes.forEach(type => {
                        const cards = document.querySelectorAll(`.${type}-card`);
                        cards.forEach(card => {
                            const cardTitleElement = card.querySelector('.card-title');
                            const cardTitle = cardTitleElement ? cardTitleElement.textContent.toLowerCase() : '';
                            let cardContentText = '';

                            // Collect relevant text from card based on type
                            switch(type) {
                                case 'account':
                                    const accountBalance = card.querySelector('.account-info p');
                                    cardContentText = accountBalance ? accountBalance.textContent.toLowerCase() : '';
                                    break;
                                case 'income':
                                    const incomeAmount = card.querySelector('.income-info p');
                                    const incomeDate = card.querySelector('.income-info p:nth-child(3)');
                                    cardContentText = (incomeAmount ? incomeAmount.textContent.toLowerCase() : '') + ' ' +
                                                      (incomeDate ? incomeDate.textContent.toLowerCase() : '');
                                    break;
                                case 'expense':
                                    const expenseAmount = card.querySelector('.expense-info p');
                                    const expenseDate = card.querySelector('.expense-info p:nth-child(3)');
                                    cardContentText = (expenseAmount ? expenseAmount.textContent.toLowerCase() : '') + ' ' +
                                                      (expenseDate ? expenseDate.textContent.toLowerCase() : '');
                                    break;
                                case 'debt':
                                    const debtAmount = card.querySelector('.debt-info p');
                                    const debtDueDate = card.querySelector('.debt-info p:nth-child(3)');
                                    cardContentText = (debtAmount ? debtAmount.textContent.toLowerCase() : '') + ' ' +
                                                      (debtDueDate ? debtDueDate.textContent.toLowerCase() : '');
                                    break;
                                case 'saving':
                                    const savingAmount = card.querySelector('.saving-info p');
                                    const savingDesiredDate = card.querySelector('.saving-info p:nth-child(3)');
                                    cardContentText = (savingAmount ? savingAmount.textContent.toLowerCase() : '') + ' ' +
                                                      (savingDesiredDate ? savingDesiredDate.textContent.toLowerCase() : '');
                                    break;
                                case 'budget':
                                    const budgetAmount = card.querySelector('.budget-info p');
                                    const budgetSpent = card.querySelector('.budget-info p:nth-child(3)');
                                    const budgetRemaining = card.querySelector('.budget-info p:nth-child(4)');
                                    cardContentText = (budgetAmount ? budgetAmount.textContent.toLowerCase() : '') + ' ' +
                                                      (budgetSpent ? budgetSpent.textContent.toLowerCase() : '') + ' ' +
                                                      (budgetRemaining ? budgetRemaining.textContent.toLowerCase() : '');
                                    break;
                                default:
                                    break;
                            }

                            // Check if the query matches any part of the card's content
                            if (cardTitle.includes(query) || cardContentText.includes(query)) {
                                // Clone the card and append to search-results
                                const clonedCard = card.cloneNode(true);
                                // Ensure the cloned card retains the necessary data attributes
                                searchCardsContainer.appendChild(clonedCard);
                            }
                        });
                    });

                    // Show search results
                    searchResults.style.display = 'block';

                    // Handle "No Results" message
                    const totalResults = searchCardsContainer.querySelectorAll('.card').length;
                    if (totalResults === 0) {
                        searchCardsContainer.innerHTML = `
                            <div class="nothing-here" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <img src="{{ asset('images/empty.svg') }}" alt="No results found">
                                <p>No records match your search.</p>
                            </div>
                        `;
                    }
                }, 300)); // 300 milliseconds delay

                // Clear Search functionality
                clearSearch.addEventListener('click', () => {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input')); // Trigger input event to reset search
                });

                // Function to handle "No Data" messages when switching tabs
                function handleNoDataMessages() {
                    // Existing logic...
                }
            });

            // Tab functionality remains unchanged
            function openTab(evt, tabName) {
                const tabLinks = document.getElementsByClassName("tab-link");
                const tabContents = document.getElementsByClassName("tab-content");

                // Hide all tab contents
                for (let i = 0; i < tabContents.length; i++) {
                    tabContents[i].classList.remove("active");
                    tabContents[i].style.display = 'none';
                }

                // Remove 'active' class from all tab links
                for (let i = 0; i < tabLinks.length; i++) {
                    tabLinks[i].classList.remove("active");
                }

                // Show the current tab and add 'active' class to the clicked tab
                const currentTab = document.getElementById(tabName);
                currentTab.classList.add("active");
                currentTab.style.display = 'block';
                evt.currentTarget.classList.add("active");
            }
        </script>
</body>
</html>
