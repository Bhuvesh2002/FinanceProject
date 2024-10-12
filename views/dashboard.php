<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include '../partials/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p class="text-center">Here’s a snapshot of your financial data.</p>

    <!-- Dashboard Summary -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Income</div>
                <div class="card-body">
                    <h5 class="card-title">$12,000</h5> <!-- Placeholder -->
                    <p class="card-text">This is the total income recorded.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Expenses</div>
                <div class="card-body">
                    <h5 class="card-title">$8,000</h5> <!-- Placeholder -->
                    <p class="card-text">This is the total expenses recorded.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Net Balance</div>
                <div class="card-body">
                    <h5 class="card-title">$4,000</h5> <!-- Placeholder -->
                    <p class="card-text">This is the net balance after expenses.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Manage Income</div>
                <div class="card-body">
                    <p>Record and manage your income sources.</p>
                    <a href="add_income.php" class="btn btn-primary">Add Income</a>
                    <a href="view_income.php" class="btn btn-outline-primary">View Income</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Manage Expenses</div>
                <div class="card-body">
                    <p>Track and organize your expenses.</p>
                    <a href="add_expense.php" class="btn btn-danger">Add Expense</a>
                    <a href="view_expenses.php" class="btn btn-outline-danger">View Expenses</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Reports and Analytics</div>
                <div class="card-body">
                    <p>Generate detailed reports on your finances to help with decision-making.</p>
                    <a href="generate_report.php" class="btn btn-success">Generate Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
