document.addEventListener("DOMContentLoaded", () => {
    const expenseDataDiv = document.getElementById("expenseData");

    const financeLabelsWeek = JSON.parse(
        expenseDataDiv.getAttribute("data-labels-week"),
    );
    const financeDataWeek = JSON.parse(
        expenseDataDiv.getAttribute("data-data-week"),
    );
    const financeLabelsMonth = JSON.parse(
        expenseDataDiv.getAttribute("data-labels-month"),
    );
    const financeDataMonth = JSON.parse(
        expenseDataDiv.getAttribute("data-data-month"),
    );

    let expenseChart = null;

    function updateChart(period) {
        let labels = [];
        let data = [];

        if (period === "week") {
            labels = financeLabelsWeek;
            data = financeDataWeek;
        } else if (period === "month") {
            labels = financeLabelsMonth;
            data = financeDataMonth;
        }

        const ctx = document.getElementById("expenseChart").getContext("2d");

        if (expenseChart) {
            expenseChart.destroy();
        }

        const backgroundColors = [
            "#FF6384",
            "#36A2EB",
            "#FFCE56",
            "#4BC0C0",
            "#9966FF",
            "#FF9F40",
            "#FFCD56",
            "#C9CBCF",
        ];

        const assignedColors = backgroundColors.slice(0, labels.length);

        expenseChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data,
                        backgroundColor: assignedColors,
                        hoverOffset: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `${tooltipItem.label}: $${tooltipItem.raw.toLocaleString()}`;
                            },
                        },
                    },
                    title: {
                        display: true,
                        text: `Expense Distribution - ${period === "week" ? "This Week" : "This Month"}`,
                    },
                },
            },
        });
    }

    // Initial chart load
    const initialPeriod = document.getElementById("expense-filter").value;
    updateChart(initialPeriod);

    // Event listener for filter change
    document
        .getElementById("expense-filter")
        .addEventListener("change", (e) => {
            updateChart(e.target.value);
        });
});
