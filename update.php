<?php
include 'database/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>❌ Error: Student ID not provided.<br><a href='read.php'>Back</a></p>");
}

$id = $_GET['id'];
$message = "";

try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("<p style='color:red; text-align:center;'>❌ Error: Student not found.<br><a href='read.php'>Back</a></p>");
    }
} catch (PDOException $e) {
    die("Error fetching record: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_no = $_POST['student_no'];
    $fullname = $_POST['fullname'];
    $branch = $_POST['branch'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    try {
        $sql = "UPDATE students SET student_no=?, fullname=?, branch=?, email=?, contact=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$student_no, $fullname, $branch, $email, $contact, $id]);

        echo "<script>alert('✅ Student record updated successfully!'); window.location='read.php';</script>";
        exit;
    } catch (PDOException $e) {
        $message = "<p class='error'>❌ Update failed: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", Arial, sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #4b79ff, #6ad6ff);
    }

    .card {
        width: 420px;
        padding: 32px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 10px 36px rgba(0,0,0,0.25);
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(12px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        text-align: center;
        margin-bottom: 18px;
        font-weight: 600;
        color: #ffffff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    label {
        font-size: 14px;
        margin-top: 14px;
        display: block;
        color: #eef6ff;
        font-weight: 500;
    }

    input, select {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        border-radius: 10px;
        border: none;
        background: rgba(255, 255, 255, 0.25);
        color: #000;
        font-size: 15px;
        transition: 0.3s;
        outline: none;
    }

    input:focus, select:focus {
        background: rgba(255,255,255,0.4);
        box-shadow: 0 0 6px rgba(255,255,255,0.8);
    }

    /* Make dropdown text visible */
    select option {
        background: #ffffff;
        color: #000;
    }

    input[type="submit"] {
        margin-top: 22px;
        background: linear-gradient(135deg, #ffd86b, #f7a400);
        color: #2d1b00;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: 0.25s;
    }

    input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.25);
    }

    .error {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 14px;
        background: rgba(255, 78, 78, 0.25);
        border: 1px solid rgba(255, 78, 78, 0.65);
        color: #ffe2e2;
        animation: fadeIn 0.35s;
        text-align: center;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 18px;
        text-decoration: none;
        color: #ffffff;
        opacity: 0.85;
        transition: 0.25s;
    }

    a:hover { opacity: 1; }
</style>
</head>

<body>

<div class="card">
    <h2>Edit Student</h2>
    <?= $message ?>

    <form method="POST">
        <label>Student No</label>
        <input type="text" name="student_no" value="<?= htmlspecialchars($student['student_no']); ?>" required>

        <label>Full Name</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']); ?>" required>

        <label>Branch</label>
        <select name="branch" required>
            <?php
            $branches = ['BSIT', 'BSCS', 'BSCE', 'BSECE'];
            foreach ($branches as $b) {
                $sel = ($student['branch'] === $b) ? 'selected' : '';
                echo "<option value='$b' $sel>$b</option>";
            }
            ?>
        </select>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>

        <label>Contact</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($student['contact']); ?>" required>

        <input type="submit" value="Update Record">
    </form>

    <a href="read.php">← Back to Student List</a>
</div>

</body>
</html>
