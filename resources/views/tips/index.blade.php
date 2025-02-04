<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips and Best Practices - Smart Planner</title>
    
    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include Bootstrap 5 CSS Before Custom Styles -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        integrity="sha384-rbsA2VBKQfE3UHGbwD4BumPEz9F7B4ZK1rxFKe3T2YdY8FNCAZ0FctnX8KZw1T3N" 
        crossorigin="anonymous"
    >

    <!-- Your Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/taskmanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="{{ asset('css/tips.css') }}"> <!-- Your updated CSS -->

    <!-- Material Icons (Google) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header plain-header">
            <div class="menu-icon" id="menu-icon" tabindex="0" aria-label="Toggle Sidebar" role="button">
                <i class="bi bi-list"></i>
            </div>
            <div class="title">Tips & Best Practices</div>
        </header>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Illustration Carousel -->
            <div class="carousel-wrapper">
                <div class="carousel carousel-slider center" id="illustration-carousel">
                    <div class="carousel-item">
                        <img src="{{ asset('images/list.png') }}" alt="Illustration 1" class="carousel-image" loading="lazy">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/save.png') }}" alt="Illustration 2" class="carousel-image" loading="lazy">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/notasks.png') }}" alt="Illustration 3" class="carousel-image" loading="lazy">
                    </div>
                </div>
                <!-- Dot Indicators Below Carousel -->
                <div class="carousel-indicators">
                    <ul class="indicators-list">
                        <li class="indicator-item active" data-target="0"></li>
                        <li class="indicator-item" data-target="1"></li>
                        <li class="indicator-item" data-target="2"></li>
                    </ul>
                </div>
            </div>

            <!-- Tips Wrapper -->
            <div class="tips-wrapper">
                <div class="tips-container">
                    <div class="card resource-card modal-trigger" data-target="modal-time-management" tabindex="0" role="button" aria-label="Open Time Management Tips">
                        <div class="card-content">
                            <h3>Time Management</h3>
                            <p>Learn effective techniques to manage your time and boost productivity.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-budgeting-strategies" tabindex="0" role="button" aria-label="Open Budgeting Strategies Tips">
                        <div class="card-content">
                            <h3>Budgeting Strategies</h3>
                            <p>Explore proven strategies to create and maintain a successful budget.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-savings-techniques" tabindex="0" role="button" aria-label="Open Savings Techniques Tips">
                        <div class="card-content">
                            <h3>Savings Techniques</h3>
                            <p>Discover ways to save effectively and grow your financial security.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-debt-management" tabindex="0" role="button" aria-label="Open Debt Management Tips">
                        <div class="card-content">
                            <h3>Debt Management</h3>
                            <p>Understand how to manage and reduce debt for financial freedom.</p>
                        </div>
                    </div>
                    <!-- New Tip: Expense Management -->
                    <div class="card resource-card modal-trigger" data-target="modal-expense-management" tabindex="0" role="button" aria-label="Open Expense Management Tips">
                        <div class="card-content">
                            <h3>Expense Management</h3>
                            <p>Learn how to track and control your expenses effectively.</p>
                        </div>
                    </div>
                    <!-- New Tip: Project Management -->
                    <div class="card resource-card modal-trigger" data-target="modal-project-management" tabindex="0" role="button" aria-label="Open Project Management Tips">
                        <div class="card-content">
                            <h3>Project Management</h3>
                            <p>Discover strategies to break projects into manageable actions.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles and Blog Posts Section -->
            <section class="resources-section">
                <h2>Articles and Blog Posts</h2>
                <div class="resources-container">
                    <div class="card resource-card modal-trigger" data-target="modal-article-time-management" tabindex="0" role="button" aria-label="Open Time Management Article">
                        <div class="card-content">
                            <h3>Mastering Time Management</h3>
                            <p>Dive deep into effective time management techniques with our comprehensive article.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-article-budgeting" tabindex="0" role="button" aria-label="Open Budgeting Strategies Article">
                        <div class="card-content">
                            <h3>Budgeting Strategies</h3>
                            <p>Learn the fundamentals of budgeting to take control of your finances.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-article-productivity" tabindex="0" role="button" aria-label="Open Productivity Article">
                        <div class="card-content">
                            <h3>Boosting Productivity</h3>
                            <p>Explore advanced strategies to enhance your productivity and efficiency.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-article-financial-planning" tabindex="0" role="button" aria-label="Open Financial Planning Article">
                        <div class="card-content">
                            <h3>Financial Planning Basics</h3>
                            <p>Understand the essentials of financial planning for long-term stability.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-article-task-management" tabindex="0" role="button" aria-label="Open Task Management Article">
                        <div class="card-content">
                            <h3>Effective Task Management</h3>
                            <p>Learn how to organize and prioritize tasks for optimal performance.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Book Summaries Section -->
            <section class="resources-section">
                <h2>Book Summaries</h2>
                <div class="resources-container">
                    <!-- Book Cards -->
                    <div class="card resource-card modal-trigger" data-target="modal-book-rich-dad-poor-dad" tabindex="0" role="button" aria-label="Open Rich Dad Poor Dad Summary">
                        <div class="card-content">
                            <h3>Rich Dad Poor Dad</h3>
                            <p>Robert T. Kiyosaki</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-money-master-the-game" tabindex="0" role="button" aria-label="Open Money: Master the Game Summary">
                        <div class="card-content">
                            <h3>Money: Master the Game</h3>
                            <p>Tony Robbins</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-i-will-teach-you-to-be-rich" tabindex="0" role="button" aria-label="Open I Will Teach You to Be Rich Summary">
                        <div class="card-content">
                            <h3>I Will Teach You to Be Rich</h3>
                            <p>Ramit Sethi</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-getting-things-done" tabindex="0" role="button" aria-label="Open Getting Things Done Summary">
                        <div class="card-content">
                            <h3>Getting Things Done</h3>
                            <p>David Allen</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-7-habits" tabindex="0" role="button" aria-label="Open The 7 Habits Summary">
                        <div class="card-content">
                            <h3>The 7 Habits</h3>
                            <p>Stephen R. Covey</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-eat-that-frog" tabindex="0" role="button" aria-label="Open Eat That Frog! Summary">
                        <div class="card-content">
                            <h3>Eat That Frog!</h3>
                            <p>Brian Tracy</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-pomodoro-technique" tabindex="0" role="button" aria-label="Open The Pomodoro Technique Summary">
                        <div class="card-content">
                            <h3>The Pomodoro Technique</h3>
                            <p>Francesco Cirillo</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-80-20-principle" tabindex="0" role="button" aria-label="Open The 80/20 Principle Summary">
                        <div class="card-content">
                            <h3>The 80/20 Principle</h3>
                            <p>Richard Koch</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-checklist-manifesto" tabindex="0" role="button" aria-label="Open The Checklist Manifesto Summary">
                        <div class="card-content">
                            <h3>The Checklist Manifesto</h3>
                            <p>Atul Gawande</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-book-total-money-makeover" tabindex="0" role="button" aria-label="Open The Total Money Makeover Summary">
                        <div class="card-content">
                            <h3>The Total Money Makeover</h3>
                            <p>Dave Ramsey</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQs and Common Questions Section -->
            <section class="resources-section">
                <h2>FAQs and Common Questions</h2>
                <div class="resources-container">
                    <div class="card resource-card modal-trigger" data-target="modal-faq-time-management" tabindex="0" role="button" aria-label="View Time Management FAQs">
                        <div class="card-content">
                            <h3>Time Management FAQs</h3>
                            <p>Find answers to the most common questions about time management.</p>
                        </div>
                    </div>
                    <div class="card resource-card modal-trigger" data-target="modal-faq-budgeting" tabindex="0" role="button" aria-label="View Budgeting FAQs">
                        <div class="card-content">
                            <h3>Budgeting FAQs</h3>
                            <p>Get answers to frequently asked questions about budgeting.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal Structures (Tips) -->
    <!-- Time Management Tips Modal -->
    <div id="modal-time-management" class="modal">
        <div class="modal-content">
            <h4>Time Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/task1.png') }}" alt="Time Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Time management is essential for achieving your goals and maintaining a work-life balance.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>Set SMART Goals</h6>
                        <p>Define Specific, Measurable, Achievable, Relevant, and Time-bound goals to stay focused.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Use a Planner</h6>
                        <p>Organize tasks by priority using a physical planner or digital tools.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Break Tasks Down</h6>
                        <p>Divide larger tasks into smaller, manageable steps to avoid overwhelm.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Allocate Time Slots</h6>
                        <p>Assign specific time periods for focused work to enhance productivity.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Regular Reviews</h6>
                        <p>Frequently assess and adjust your schedule to stay on track.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Budgeting Strategies Tips Modal -->
    <div id="modal-budgeting-strategies" class="modal">
        <div class="modal-content">
            <h4>Budgeting Strategies</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/accounts.png') }}" alt="Budgeting Strategies" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Effective budgeting helps in managing finances, reducing stress, and saving for future goals.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>Track Expenses</h6>
                        <p>Monitor your spending to understand where your money goes.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Create a Monthly Budget</h6>
                        <p>Include all income and expenses to plan your finances effectively.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Use the 50/30/20 Rule</h6>
                        <p>Allocate 50% to needs, 30% to wants, and 20% to savings and debt repayment.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Regularly Review Budget</h6>
                        <p>Adjust your budget as necessary to reflect changes in income or expenses.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Utilize Budgeting Apps</h6>
                        <p>Use technology to simplify tracking and managing your budget.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Savings Techniques Tips Modal -->
    <div id="modal-savings-techniques" class="modal">
        <div class="modal-content">
            <h4>Savings Techniques</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/save.png') }}" alt="Savings Techniques" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Building savings is crucial for financial security and future investments.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>Pay Yourself First</h6>
                        <p>Set aside a portion of your income for savings before other expenses.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Automate Savings</h6>
                        <p>Set up automatic transfers to your savings account to ensure consistency.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Reduce Unnecessary Expenses</h6>
                        <p>Cut back on non-essential spending to increase your savings potential.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Set Specific Goals</h6>
                        <p>Define clear savings goals to stay motivated and track progress.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Invest Wisely</h6>
                        <p>Consider investment options to grow your savings over time.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Debt Management Tips Modal -->
    <div id="modal-debt-management" class="modal">
        <div class="modal-content">
            <h4>Debt Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/debts.png') }}" alt="Debt Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Understanding and managing debt is vital for achieving financial freedom and reducing stress.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>List All Debts</h6>
                        <p>Document amounts, interest rates, and due dates to get a clear picture.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Choose a Repayment Strategy</h6>
                        <p>Use methods like snowball or avalanche to prioritize debt payments.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Negotiate with Creditors</h6>
                        <p>Seek lower interest rates or payment plans to ease your burden.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Avoid New Debt</h6>
                        <p>Resist accumulating more debt while paying off existing ones.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Seek Professional Advice</h6>
                        <p>Consult financial advisors if you're overwhelmed.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Expense Management Tips Modal -->
    <div id="modal-expense-management" class="modal">
        <div class="modal-content">
            <h4>Expense Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/expenses.png') }}" alt="Expense Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Effective expense management ensures that your spending aligns with your financial goals.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>Track All Expenses</h6>
                        <p>Maintain a record of every expense to identify spending patterns.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Set Spending Limits</h6>
                        <p>Establish budgets for different categories to control spending.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Use Expense Apps</h6>
                        <p>Leverage technology to monitor expenses in real-time.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Regular Reviews</h6>
                        <p>Periodically assess your expenses and adjust as needed.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Prioritize Needs Over Wants</h6>
                        <p>Focus on essential expenses to maintain financial stability.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Project Management Tips Modal -->
    <div id="modal-project-management" class="modal">
        <div class="modal-content">
            <h4>Project Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/project.png') }}" alt="Project Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <h5>Overview:</h5>
                <p>Effective project management helps in breaking down complex projects into manageable actions.</p>
                <h5>Tips:</h5>
                <div class="tips-list">
                    <div class="tip-card">
                        <h6>Define Clear Goals</h6>
                        <p>Establish specific objectives to guide your project.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Break Into Tasks</h6>
                        <p>Divide the project into smaller, actionable tasks.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Assign Responsibilities</h6>
                        <p>Delegate tasks to team members based on strengths.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Set Realistic Deadlines</h6>
                        <p>Allocate sufficient time for each task to ensure quality.</p>
                    </div>
                    <div class="tip-card">
                        <h6>Monitor Progress</h6>
                        <p>Regularly review the project's status and adjust plans accordingly.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Articles and Blog Posts Modals -->
    <!-- Time Management Article Modal -->
    <div id="modal-article-time-management" class="modal">
        <div class="modal-content">
            <h4>Mastering Time Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/completed.png') }}" alt="Mastering Time Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p>Our in-depth article covers various time management techniques to help you boost productivity and achieve your goals.</p>
                <p><strong>Source:</strong> <a href="https://www.mindtools.com/pages/article/newHTE_00.htm" target="_blank" rel="noopener noreferrer">MindTools</a></p>
                <a href="https://www.mindtools.com/pages/article/newHTE_00.htm" target="_blank" rel="noopener noreferrer" class="btn read-btn">Read Full Article</a>
            </div>
        </div>
    </div>

    <!-- Budgeting Strategies Article Modal -->
    <div id="modal-article-budgeting" class="modal">
        <div class="modal-content">
            <h4>Budgeting Strategies</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/money.png') }}" alt="Budgeting Strategies" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p>Learn effective budgeting strategies to manage your finances and achieve your financial goals.</p>
                <p><strong>Source:</strong> <a href="https://www.nerdwallet.com/article/finance/how-to-budget" target="_blank" rel="noopener noreferrer">NerdWallet</a></p>
                <a href="https://www.nerdwallet.com/article/finance/how-to-budget" target="_blank" rel="noopener noreferrer" class="btn read-btn">Read Full Article</a>
            </div>
        </div>
    </div>

    <!-- Productivity Article Modal -->
    <div id="modal-article-productivity" class="modal">
        <div class="modal-content">
            <h4>Boosting Productivity</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/task1.png') }}" alt="Boosting Productivity" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p>Explore advanced strategies to enhance your productivity and efficiency in both personal and professional settings.</p>
                <p><strong>Source:</strong> <a href="https://www.atlassian.com/blog/productivity/how-to-be-more-productive" target="_blank" rel="noopener noreferrer">Atlassian</a></p>
                <a href="https://www.atlassian.com/blog/productivity/how-to-be-more-productive" target="_blank" rel="noopener noreferrer" class="btn read-btn">Read Full Article</a>
            </div>
        </div>
    </div>

    <!-- Financial Planning Basics Article Modal -->
    <div id="modal-article-financial-planning" class="modal">
        <div class="modal-content">
            <h4>Financial Planning Basics</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/savings.png') }}" alt="Financial Planning Basics" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p>Understand the essentials of financial planning to achieve long-term financial stability and success.</p>
                <p><strong>Source:</strong> <a href="https://www.investopedia.com/articles/pf/08/financial-planning-basics.asp" target="_blank" rel="noopener noreferrer">Investopedia</a></p>
                <a href="https://www.investopedia.com/articles/pf/08/financial-planning-basics.asp" target="_blank" rel="noopener noreferrer" class="btn read-btn">Read Full Article</a>
            </div>
        </div>
    </div>

    <!-- Task Management Article Modal -->
    <div id="modal-article-task-management" class="modal">
        <div class="modal-content">
            <h4>Effective Task Management</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/notasks.png') }}" alt="Effective Task Management" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p>Learn how to organize and prioritize tasks to achieve optimal performance and efficiency.</p>
                <p><strong>Source:</strong> <a href="https://www.toggl.com/blog/task-management" target="_blank" rel="noopener noreferrer">Toggl</a></p>
                <a href="https://www.toggl.com/blog/task-management" target="_blank" rel="noopener noreferrer" class="btn read-btn">Read Full Article</a>
            </div>
        </div>
    </div>

    <!-- Book Summary Modals -->
    <!-- Book 1: Rich Dad Poor Dad Summary Modal -->
    <div id="modal-book-rich-dad-poor-dad" class="modal">
        <div class="modal-content">
            <h4>Rich Dad Poor Dad</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="Rich Dad Poor Dad" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Robert T. Kiyosaki</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Financial Education is Crucial:</strong> Invest in your financial literacy to make informed decisions about money.</li>
                    <li><strong>Understand Assets vs. Liabilities:</strong> Focus on acquiring assets that generate income.</li>
                    <li><strong>Build Passive Income Streams:</strong> Create income sources that don't require active work.</li>
                    <li><strong>Mindset Matters:</strong> Seek opportunities rather than accepting limitations.</li>
                    <li><strong>Work to Learn, Not Just to Earn:</strong> Choose jobs that offer skills development over high salaries.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 2: Money: Master the Game Summary Modal -->
    <div id="modal-book-money-master-the-game" class="modal">
        <div class="modal-content">
            <h4>Money: Master the Game</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="Money: Master the Game" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Tony Robbins</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Start Early and Be Consistent:</strong> Take advantage of compounding returns.</li>
                    <li><strong>Diversify Your Investments:</strong> Spread risk across asset classes.</li>
                    <li><strong>Understand Fees and Expenses:</strong> High fees can reduce returns significantly.</li>
                    <li><strong>Set Clear Financial Goals:</strong> Define what financial freedom means to you.</li>
                    <li><strong>Educate Yourself:</strong> Learn about financial markets to make informed decisions.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 3: I Will Teach You to Be Rich Summary Modal -->
    <div id="modal-book-i-will-teach-you-to-be-rich" class="modal">
        <div class="modal-content">
            <h4>I Will Teach You to Be Rich</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="I Will Teach You to Be Rich" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Ramit Sethi</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Automate Your Finances:</strong> Set up automatic transfers for savings and bills.</li>
                    <li><strong>Focus on the Big Wins:</strong> Prioritize high-impact financial actions.</li>
                    <li><strong>Spend Consciously:</strong> Invest in what you love, cut what you don't.</li>
                    <li><strong>Invest Early and Regularly:</strong> Benefit from compound interest over time.</li>
                    <li><strong>Understand Credit Cards:</strong> Use them wisely to build credit and earn rewards.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 4: Getting Things Done Summary Modal -->
    <div id="modal-book-getting-things-done" class="modal">
        <div class="modal-content">
            <h4>Getting Things Done</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="Getting Things Done" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> David Allen</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Capture Everything:</strong> Write down tasks to clear your mind.</li>
                    <li><strong>Clarify and Organize:</strong> Determine actionable steps and categorize tasks.</li>
                    <li><strong>Use Context Lists:</strong> Organize tasks by context.</li>
                    <li><strong>Review Regularly:</strong> Weekly reviews keep you on track.</li>
                    <li><strong>Focus on Next Actions:</strong> Identify the next step needed for progress.</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Book 5: The 7 Habits Summary Modal -->
    <div id="modal-book-7-habits" class="modal">
        <div class="modal-content">
            <h4>The 7 Habits of Highly Effective People</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="The 7 Habits" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Stephen R. Covey</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Be Proactive:</strong> Focus on what you can control.</li>
                    <li><strong>Begin with the End in Mind:</strong> Define your vision and goals first.</li>
                    <li><strong>Put First Things First:</strong> Prioritize what's important.</li>
                    <li><strong>Think Win-Win:</strong> Seek mutual benefits in interactions.</li>
                    <li><strong>Seek First to Understand:</strong> Listen before speaking.</li>
                    <li><strong>Synergize:</strong> Collaborate for greater results.</li>
                    <li><strong>Sharpen the Saw:</strong> Continuous self-improvement.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 6: Eat That Frog! Summary Modal -->
    <div id="modal-book-eat-that-frog" class="modal">
        <div class="modal-content">
            <h4>Eat That Frog!</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="Eat That Frog!" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Brian Tracy</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Prioritize Tasks:</strong> Identify your most important tasks first.</li>
                    <li><strong>Plan Each Day in Advance:</strong> Use lists to organize.</li>
                    <li><strong>Apply the 80/20 Rule:</strong> Focus on tasks with high returns.</li>
                    <li><strong>Eliminate Procrastination:</strong> Start tasks promptly.</li>
                    <li><strong>Use Time Blocks:</strong> Allocate focused work periods.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 7: The Pomodoro Technique Summary Modal -->
    <div id="modal-book-pomodoro-technique" class="modal">
        <div class="modal-content">
            <h4>The Pomodoro Technique</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="The Pomodoro Technique" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Francesco Cirillo</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Work in Short Intervals:</strong> 25-minute focus sessions plus breaks.</li>
                    <li><strong>Reduce Distractions:</strong> No interruptions during sessions.</li>
                    <li><strong>Track Progress:</strong> Measure completed sessions.</li>
                    <li><strong>Improve Estimations:</strong> Estimate task time more accurately.</li>
                    <li><strong>Take Regular Breaks:</strong> Helps maintain long-term productivity.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 8: The 80/20 Principle Summary Modal -->
    <div id="modal-book-80-20-principle" class="modal">
        <div class="modal-content">
            <h4>The 80/20 Principle</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="The 80/20 Principle" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Richard Koch</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Focus on the Vital Few:</strong> Identify the tasks with the greatest impact.</li>
                    <li><strong>Optimize Time and Resources:</strong> Allocate efforts for max efficiency.</li>
                    <li><strong>Eliminate Low-Value Activities:</strong> Reduce or delegate minimal impact tasks.</li>
                    <li><strong>Apply Across Life Areas:</strong> Use the principle in work and personal life.</li>
                    <li><strong>Continuously Reassess:</strong> Regularly evaluate priorities.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 9: The Checklist Manifesto Summary Modal -->
    <div id="modal-book-checklist-manifesto" class="modal">
        <div class="modal-content">
            <h4>The Checklist Manifesto</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="The Checklist Manifesto" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Atul Gawande</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Simplify Complexity:</strong> Use checklists for complex tasks.</li>
                    <li><strong>Enhance Communication:</strong> Align teams with clear guidelines.</li>
                    <li><strong>Standardize Processes:</strong> Improve efficiency and outcomes.</li>
                    <li><strong>Adapt and Refine:</strong> Update checklists as needed.</li>
                    <li><strong>Apply Universally:</strong> Checklists help in many fields.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Book 10: The Total Money Makeover Summary Modal -->
    <div id="modal-book-total-money-makeover" class="modal">
        <div class="modal-content">
            <h4>The Total Money Makeover</h4>
            <div class="modal-illustration">
                <img src="{{ asset('images/Learning.png') }}" alt="The Total Money Makeover" class="modal-illustration" loading="lazy" />
            </div>
            <div class="modal-content-wrapper">
                <p><strong>Author:</strong> Dave Ramsey</p>
                <h5>Key Lessons:</h5>
                <ul class="lessons-list">
                    <li><strong>Create a Budget:</strong> Control your finances.</li>
                    <li><strong>Build an Emergency Fund:</strong> Prepare for the unexpected.</li>
                    <li><strong>Eliminate Debt:</strong> Use the snowball method.</li>
                    <li><strong>Live Below Your Means:</strong> Avoid unnecessary spending.</li>
                    <li><strong>Invest for the Future:</strong> Plan for long-term goals.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- FAQs Modals -->
    <!-- Time Management FAQs Modal -->
    <div id="modal-faq-time-management" class="modal">
        <div class="modal-content">
            <h4>Time Management FAQs</h4>
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How can I prioritize my tasks?</div>
                    <div class="collapsible-body"><span>Use the Eisenhower Matrix to categorize tasks by urgency and importance.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>What are some effective time management techniques?</div>
                    <div class="collapsible-body"><span>Try the Pomodoro Technique, time blocking, and setting SMART goals.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How can I avoid procrastination?</div>
                    <div class="collapsible-body"><span>Break tasks into smaller steps, set deadlines, and eliminate distractions.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How do I manage time effectively when working from home?</div>
                    <div class="collapsible-body"><span>Create a dedicated workspace, establish a routine, and set clear boundaries.</span></div>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Budgeting FAQs Modal -->
    <div id="modal-faq-budgeting" class="modal">
        <div class="modal-content">
            <h4>Budgeting FAQs</h4>
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How do I start creating a budget?</div>
                    <div class="collapsible-body"><span>Begin by tracking all your income and expenses.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>What is the 50/30/20 rule?</div>
                    <div class="collapsible-body"><span>Allocate 50% to needs, 30% to wants, and 20% to savings/debt.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How can I reduce my monthly expenses?</div>
                    <div class="collapsible-body"><span>Identify non-essentials, negotiate bills, and find cost-effective alternatives.</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">help</i>How often should I review my budget?</div>
                    <div class="collapsible-body"><span>Review monthly to track progress and make adjustments.</span></div>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar" role="navigation" aria-label="Bottom Navigation">
        <a href="{{ route('dashboard') }}" class="navbar-item" aria-label="Dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-house-door" aria-hidden="true"></i>
        </a>
        <a href="{{ route('taskmanagement.index') }}" class="navbar-item" aria-label="Task Management" title="Task Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-list-task" aria-hidden="true"></i>
        </a>
        <a href="{{ route('financemanagement.index') }}" class="navbar-item" aria-label="Finance Management" title="Finance Management" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-currency-dollar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('calendar.index') }}" class="navbar-item" aria-label="Calendar" title="Calendar" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-calendar" aria-hidden="true"></i>
        </a>
        <a href="{{ route('notifications.index') }}" class="navbar-item" aria-label="Notifications" title="Notifications" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bell" aria-hidden="true"></i>
        </a>
        <a href="{{ route('tips') }}" class="navbar-item active" aria-label="Tips & Best Practices" title="Tips & Best Practices" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-lightbulb" aria-hidden="true"></i>
        </a>
        <a href="{{ route('reports') }}" class="navbar-item" aria-label="Reports" title="Reports" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-bar-chart" aria-hidden="true"></i>
        </a>
    </nav>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ENjdO4Dr2bkBIFxQpeo/ej3V0y4R6/HM0n6pGHrh9W/wPRp74Phb32Dd3HPFjqD" 
        crossorigin="anonymous">
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize all Materialize Modals
        const modalElems = document.querySelectorAll('.modal');
        M.Modal.init(modalElems);

        // Initialize Collapsible for FAQs
        const collapsibles = document.querySelectorAll('.collapsible');
        M.Collapsible.init(collapsibles);

        // Initialize Sidebar Toggle
        const menuIcon = document.getElementById('menu-icon');
        menuIcon.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const sidebar = document.querySelector('.sidebar');
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
            // Keyboard accessibility
            trigger.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    modalInstance.open();
                }
            });
        });

        // Initialize Carousel
        const carouselElems = document.querySelectorAll('.carousel');
        const carouselInstances = M.Carousel.init(carouselElems, {
            fullWidth: true,
            indicators: false, 
            duration: 200,
        });

        // Auto-play Carousel
        let autoplay = setInterval(() => {
            carouselInstances[0].next();
            updateIndicators(carouselInstances[0].center);
        }, 3000);

        // Pause autoplay on hover
        const carousel = document.getElementById('illustration-carousel');
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoplay);
        });
        carousel.addEventListener('mouseleave', () => {
            autoplay = setInterval(() => {
                carouselInstances[0].next();
                updateIndicators(carouselInstances[0].center);
            }, 3000);
        });

        // Handle Indicator Clicks
        const indicators = document.querySelectorAll('.indicator-item');
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                carouselInstances[0].set(index);
                updateIndicators(index);
                resetAutoplay();
            });
        });

        // Update Indicators
        function updateIndicators(activeIndex) {
            indicators.forEach((indicator, index) => {
                if(index === activeIndex){
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        // Reset Autoplay
        function resetAutoplay(){
            clearInterval(autoplay);
            autoplay = setInterval(() => {
                carouselInstances[0].next();
                updateIndicators(carouselInstances[0].center);
            }, 3000);
        }

        // Initial Indicators Update
        updateIndicators(carouselInstances[0].center);

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>
