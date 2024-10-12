<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $source = $_POST['source'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE income SET amount = ?, source = ?, date = ?, description = ? WHERE id = ?");
    $stmt->bind_param("dsssi", $amount, $source, $date, $description, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Income updated successfully!';
    } else {
        $_SESSION['message'] = 'Error: Could not update income.';
    }
    $stmt->close();
    header("Location: view_income.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM income WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$income = $result->fetch_assoc();

include '../partials/header.php';
?>

<div class="container mt-5">
    <h2>Edit Income</h2>
    <form action="../views/edit_income.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $income['id']; ?>">
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" value="<?php echo $income['amount']; ?>" required>
        </div>
        <div class="form-group">
            <label>Source</label>
            <input type="text" name="source" class="form-control" value="<?php echo $income['source']; ?>" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo $income['date']; ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?php echo $income['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Income</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
