<?php

include 'database/config.php';


try {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Records</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", Arial, sans-serif;
}

body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #4b79ff, #6ad6ff);
    padding: 20px;
    color: #fff;
}

h2 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: 600;
}

.table-container {
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(14px);
    border-radius: 12px;
    padding: 15px;
    max-width: 900px;
    margin: 0 auto;
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

th, td {
    padding: 8px 10px;
}

th {
    background: rgba(255,255,255,0.22);
    font-weight: 600;
    border-bottom: 1px solid rgba(255,255,255,0.3);
}

tr:hover {
    background: rgba(255,255,255,0.13);
    transition: 0.25s;
}

.btn {
    padding: 4px 8px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    color: #fff;
    font-size: 13px;
}

.edit { background: #38d65c; }
.edit:hover { background: #29b34a; }

.delete { background: #ff4b4b; }
.delete:hover { background: #d93a3a; }

.back-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    text-decoration: none;
    font-size: 14px;
    color: #fff;
    opacity: 0.85;
}
.back-link:hover { opacity: 1; }

</style>

</head>

<body>

<h2>Student Records</h2>

<div class="table-container">
<table>
    <tr>
        <th>ID</th>
        <th>Student No</th>
        <th>Full Name</th>
        <th>Branch</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Date Added</th>
        <th>Actions</th>
    </tr>

    <?php if (count($students) > 0): ?>
        <?php foreach ($students as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['student_no']); ?></td>
                <td><?= htmlspecialchars($row['fullname']); ?></td>
                <td><?= htmlspecialchars($row['branch']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['contact']); ?></td>
                <td><?= htmlspecialchars($row['date_added']); ?></td>
                <td>
                    <a href="update.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn delete" onclick="return confirm('Delete this record?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align:center;">No student records found.</td>
        </tr>
    <?php endif; ?>
</table>
</div>

<a href="index.php" class="back-link">← Back to Homepage</a>

</body>
</html>
