<?php
include 'database/config.php';

$message = "";
$errors = [];

$values = [
    'student_no' => '',
    'fullname'   => '',
    'branch'     => '',
    'email'      => '',
    'contact'    => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $values['student_no'] = trim($_POST['student_no'] ?? '');
    $values['fullname']   = trim($_POST['fullname'] ?? '');
    $values['branch']     = trim($_POST['branch'] ?? '');
    $values['email']      = trim($_POST['email'] ?? '');
    $values['contact']    = trim($_POST['contact'] ?? '');

    if ($values['student_no'] === '') $errors[] = "Student Number is required.";
    if ($values['fullname'] === '') $errors[] = "Full Name is required.";
    if ($values['branch'] === '') $errors[] = "Branch is required.";
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) 
        $errors[] = "A valid Email is required.";
    if ($values['contact'] === '') $errors[] = "Contact is required.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_no, fullname, branch, email, contact, date_added)
                    VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([
                $values['student_no'],
                $values['fullname'],
                $values['branch'],
                $values['email'],
                $values['contact']
            ]);

            $message = "<p class='success'>Student record added successfully.</p>";
            $values = ['student_no'=>'','fullname'=>'','branch'=>'','email'=>'','contact'=>''];

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "A student with that Student Number or Email already exists.";
            } else {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Add Student</title>

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

    .errors, .success {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 14px;
        animation: fadeIn 0.35s;
    }

    .errors {
        background: rgba(255, 78, 78, 0.25);
        border: 1px solid rgba(255, 78, 78, 0.65);
        color: #ffe2e2;
    }

    .success {
        background: rgba(72, 255, 132, 0.25);
        border: 1px solid rgba(72, 255, 132, 0.65);
        color: #dbffe6;
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
        <h2>Add Student Record</h2>

        <?php
            if (!empty($errors)) {
                echo '<div class="errors"><ul>';
                foreach ($errors as $err) echo "<li>$err</li>";
                echo '</ul></div>';
            }
            echo $message;
        ?>

        <form method="post">
            <label>Student Number</label>
            <input name="student_no" type="text" value="<?php echo $values['student_no']; ?>">

            <label>Full Name</label>
            <input name="fullname" type="text" value="<?php echo $values['fullname']; ?>">

            <label>Branch</label>
            <select name="branch">
                <option value="">Select Branch</option>
                <?php
                    foreach (['BSIT','BSCS','BSCE','BSECE'] as $b) {
                        $selected = ($values['branch'] === $b) ? "selected" : "";
                        echo "<option $selected>$b</option>";
                    }
                ?>
            </select>

            <label>Email</label>
            <input name="email" type="email" value="<?php echo $values['email']; ?>">

            <label>Contact</label>
            <input name="contact" type="text" value="<?php echo $values['contact']; ?>">

            <input type="submit" value="Save Student">
        </form>

        <a href="index.php">← Back to Homepage</a>
    </div>
</body>
</html>


