<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Branch Directory System</title>

<style>
* {
    margin: 0; padding: 0; box-sizing: border-box;
    font-family: "Poppins", Arial, sans-serif;
}

body {
    height: 100vh;
    background: linear-gradient(135deg, #4b79ff, #6ad6ff);
    background-size: 200% 200%;
    animation: gradientFlow 8s ease infinite;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

@keyframes gradientFlow {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}


nav {
    position: fixed;
    top: 20px;
    width: 92%;
    display: flex;
    justify-content: center;
    gap: 18px;
    padding: 12px 28px;
    background: rgba(255,255,255,0.20);
    backdrop-filter: blur(14px);
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 8px 28px rgba(0,0,0,0.25);
    animation: fadeDown 0.6s ease;
}

@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-16px); }
    to { opacity: 1; transform: translateY(0); }
}

nav a {
    text-decoration: none;
    color: #ffffff;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px;
    transition: 0.3s;
}

nav a:hover {
    background: rgba(255,255,255,0.35);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}


h1 {
    color: #ffffff;
    font-size: 2.7em;
    font-weight: 600;
    margin-top: 80px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.35);
    animation: fadeIn 0.7s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(8px);}
    to {opacity: 1; transform: translateY(0);}
}


p {
    color: #eef6ff;
    font-size: 1.1em;
    margin-top: 16px;
    text-align: center;
    max-width: 500px;
    opacity: 0.9;
}


footer {
    position: fixed;
    bottom: 12px;
    font-size: 0.9em;
    color: #ffffff;
    opacity: 0.85;
}
</style>
</head>

<body>

<nav>
    <a href="create.php">Add Student</a>
    <a href="read.php">View Students</a>
    <a href="read.php">Update Student</a>
    <a href="read.php">Delete Student</a>
</nav>

<h1>Student Branch Directory System</h1>
<p>Manage, view, and update student records efficiently using a clean and elegant dashboard.</p>


</body>
</html>
