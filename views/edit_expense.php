<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE expenses SET amount = ?, category = ?, date = ?, description = ? WHERE id = ?");
    $stmt->bind_param("dsssi", $amount, $category, $date, $description, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Expense updated successfully!';
    } else {
        $_SESSION['message'] = 'Error: Could not update expense.';
    }
    $stmt->close();
    header("Location: view_expenses.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$expense = $result->fetch_assoc();

include '../partials/header.php';
?>

<div class="container mt-5">
    <h2>Edit Expense</h2>
    <form action="edit_expense.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" value="<?php echo $expense['amount']; ?>" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?php echo $expense['category']; ?>" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo $expense['date']; ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?php echo $expense['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Expense</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
