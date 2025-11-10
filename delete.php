<?php
include 'database/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>❌ Error: Student ID not provided.<br><a href='read.php'>Back</a></p>");
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT fullname FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("<p style='color:red; text-align:center;'>❌ Student not found.<br><a href='read.php'>Back</a></p>");
    }
} catch (PDOException $e) {
    die("Error fetching record: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    try {
        $del = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $del->execute([$id]);

        echo "<script>alert('✅ Student record deleted successfully!'); window.location='read.php';</script>";
        exit;
    } catch (PDOException $e) {
        die("Error deleting record: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delete Student</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    * {
    margin: 0; padding: 0; box-sizing: border-box;
    font-family: "Poppins", Arial, sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4975ff, #67e2ff);
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.card {
    width: 440px;
    padding: 40px;
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.16);
    backdrop-filter: blur(22px);
    border: 2px solid rgba(255, 255, 255, 0.28);
    box-shadow: 0 12px 50px rgba(0,0,0,0.25);
    text-align: center;
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    font-weight: 600;
    margin-bottom: 14px;
    color: #ffffff;
    font-size: 22px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

h2::before {
    font-size: 22px;
}

.student-name {
    font-size: 18px;
    font-weight: 600;
    color: #fff7c6;
    text-shadow: 0 1px 5px rgba(0,0,0,0.25);
}


button, .cancel-btn {
    width: 100%;
    padding: 14px;
    margin-top: 20px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    transition: 0.3s;
}

button {
    background: linear-gradient(135deg, #ff6262, #d30202);
    color: white;
    box-shadow: 0 6px 20px rgba(255,0,0,0.3);
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(255,0,0,0.45);
}

.cancel-btn {
    background: rgba(255, 255, 255, 0.28);
    color: #ffffff;
    text-decoration: none;
    display: inline-block;
    backdrop-filter: blur(6px);
}

.cancel-btn:hover {
    background: rgba(255,255,255,0.55);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(255,255,255,0.4);
}

</style>
</head>
<body>

<div class="card">
    <h2> Confirm Delete</h2>

    <p>Are you sure you want to delete:</p>
    <p class="student-name"><?= htmlspecialchars($student['fullname']); ?></p>

    

    <form method="POST">
        <button type="submit" name="confirm">Yes, Delete</button>
    </form>

    <a href="read.php" class="cancel-btn">Cancel</a>
</div>

</body>
</html>
