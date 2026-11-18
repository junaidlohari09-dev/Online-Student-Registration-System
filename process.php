
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$fullname = trim($_POST["fullname"] ?? "");
$usn = strtoupper(trim($_POST["usn"] ?? ""));
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$course = trim($_POST["course"] ?? "");
$semester = trim($_POST["semester"] ?? "");
$gender = trim($_POST["gender"] ?? "");
$address = trim($_POST["address"] ?? "");

$errors = [];

if (strlen($fullname) < 3 || !preg_match("/^[A-Za-z ]+$/", $fullname)) {
    $errors[] = "Invalid full name.";
}

if (!preg_match("/^[A-Za-z0-9]+$/", $usn)) {
    $errors[] = "Invalid USN.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email address.";
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Mobile number must contain 10 digits.";
}

$allowedCourses = [
    "Computer Science Engineering",
    "Information Science Engineering",
    "Electronics and Communication",
    "Mechanical Engineering",
    "Civil Engineering",
    "Artificial Intelligence and Machine Learning"
];

if (!in_array($course, $allowedCourses, true)) {
    $errors[] = "Please select a valid course.";
}

if (!in_array($semester, ["1","2","3","4","5","6","7","8"], true)) {
    $errors[] = "Please select a valid semester.";
}

if (!in_array($gender, ["Male","Female","Other"], true)) {
    $errors[] = "Please select a valid gender.";
}

if (strlen($address) < 10) {
    $errors[] = "Please enter a complete address.";
}

if (!empty($errors)) {
    echo "<h2>Registration Failed</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>" . clean($error) . "</li>";
    }
    echo "</ul><a href='index.php'>Go Back</a>";
    exit();
}

$registrationID = "STU" . date("Ymd") . random_int(1000, 9999);

$sql = "INSERT INTO students
(registration_id, full_name, usn, email, phone, gender, course, semester, address)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database query preparation failed.");
}

$stmt->bind_param(
    "sssssssis",
    $registrationID,
    $fullname,
    $usn,
    $email,
    $phone,
    $gender,
    $course,
    $semester,
    $address
);

if (!$stmt->execute()) {
    if ($conn->errno === 1062 || $stmt->errno === 1062) {
        die("This USN or registration ID is already registered. <a href='index.php'>Go Back</a>");
    }
    die("Registration could not be saved. Please try again.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="container">
        <h1>Student Portal</h1>
        <p>Online Student Registration System</p>
    </div>
</header>

<main class="container">
    <section class="registration-card">

        <div class="form-heading">
            <h2>Registration Successful!</h2>
            <p>Your student registration has been saved successfully.</p>
        </div>

        <div class="success-details">
            <h3>Registration Details</h3>

            <p><strong>Registration ID:</strong> <?= clean($registrationID) ?></p>
            <p><strong>Full Name:</strong> <?= clean($fullname) ?></p>
            <p><strong>USN:</strong> <?= clean($usn) ?></p>
            <p><strong>Email:</strong> <?= clean($email) ?></p>
            <p><strong>Mobile:</strong> <?= clean($phone) ?></p>
            <p><strong>Course:</strong> <?= clean($course) ?></p>
            <p><strong>Semester:</strong> <?= clean($semester) ?></p>
            <p><strong>Gender:</strong> <?= clean($gender) ?></p>
            <p><strong>Address:</strong> <?= clean($address) ?></p>
        </div>

        <div class="success-actions">
            <button onclick="window.print()" class="submit-btn">
                Print Registration
            </button>

            <a href="index.php" class="back-btn">Back to Home</a>
        </div>

    </section>
</main>

<footer class="footer">
    <p>© 2026 Student Portal | Online Student Registration System</p>
</footer>

</body>
</html>
