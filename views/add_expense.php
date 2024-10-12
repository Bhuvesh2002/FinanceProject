<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];  // Assuming user_id is stored in the session after login

    $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, category, date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $user_id, $amount, $category, $date, $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Expense added successfully!';
    } else {
        $_SESSION['message'] = 'Error: Could not add expense.';
    }
    $stmt->close();
    $conn->close();
    header("Location: view_expenses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Expense</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../partials/header.php'; ?>

<div class="container mt-5">
    <h2>Add New Expense</h2>
    <form action="add_expense.php" method="POST">
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Expense</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
