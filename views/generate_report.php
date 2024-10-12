<?php
session_start();
require '../config/db.php';

$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session

// Calculate total income
$stmt = $conn->prepare("SELECT SUM(amount) AS total_income FROM income WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_income = $result->fetch_assoc()['total_income'] ?? 0;

// Calculate total expenses
$stmt = $conn->prepare("SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_expenses = $result->fetch_assoc()['total_expenses'] ?? 0;

// Calculate net balance
$net_balance = $total_income - $total_expenses;

// Fetch income and expense data for charting (by month)
$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(amount) AS total 
    FROM income 
    WHERE user_id = ? 
    GROUP BY month
    ORDER BY month");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$income_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(amount) AS total 
    FROM expenses 
    WHERE user_id = ? 
    GROUP BY month
    ORDER BY month");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$expense_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include '../partials/header.php';
?>

<div class="container mt-5">
    <h2>Financial Report and Analytics</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Income</div>
                <div class="card-body">
                    <h5 class="card-title">$<?php echo number_format($total_income, 2); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Expenses</div>
                <div class="card-body">
                    <h5 class="card-title">$<?php echo number_format($total_expenses, 2); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Net Balance</div>
                <div class="card-body">
                    <h5 class="card-title">$<?php echo number_format($net_balance, 2); ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-12">
            <h3>Income vs Expenses Over Time</h3>
            <canvas id="incomeExpenseChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for charting
    const incomeData = <?php echo json_encode($income_data); ?>;
    const expenseData = <?php echo json_encode($expense_data); ?>;

    // Extract labels and data points
    const labels = incomeData.map(item => item.month);
    const incomeAmounts = incomeData.map(item => item.total);
    const expenseAmounts = expenseData.map(item => item.total);

    // Create chart
    const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Income',
                    data: incomeAmounts,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                },
                {
                    label: 'Expenses',
                    data: expenseAmounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include '../partials/footer.php'; ?>
