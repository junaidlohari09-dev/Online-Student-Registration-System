
<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

function clean($value) {
    return htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
}

// Get form values
$fullname = trim($_POST['fullname'] ?? $_POST['full_name'] ?? '');
$usn      = trim($_POST['usn'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$gender   = trim($_POST['gender'] ?? '');
$course   = trim($_POST['course'] ?? '');
$semester = (int)($_POST['semester'] ?? 0);
$address  = trim($_POST['address'] ?? '');

// Validate form
if (
    $fullname === '' ||
    $usn === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $phone === '' ||
    $course === '' ||
    $semester < 1 ||
    $semester > 8 ||
    $address === ''
) {
    die("Invalid or incomplete form details. Please go back and check your form.");
}

try {
    require_once "db.php";

    // Generate registration ID
    $registration_id = "STU" . date("Ymd") . random_int(1000, 9999);

    // Insert registration into database
    $sql = "INSERT INTO students
    (registration_id, full_name, usn, email, phone, gender, course, semester, address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssis",
        $registration_id,
        $fullname,
        $usn,
        $email,
        $phone,
        $gender,
        $course,
        $semester,
        $address
    );

    $stmt->execute();
    $stmt->close();
    $conn->close();

} catch (mysqli_sql_exception $e) {
    die("DATABASE ERROR: " . htmlspecialchars($e->getMessage()));

} catch (Throwable $e) {
    error_log($e->getMessage());
    die("Something went wrong. Please try again later.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-container {
            max-width: 650px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .success-title {
            color: #198754;
            text-align: center;
            margin-bottom: 20px;
        }

        .details p {
            padding: 10px;
            border-bottom: 1px solid #eee;
            overflow-wrap: anywhere;
        }

        .details strong {
            display: inline-block;
            min-width: 130px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 11px 20px;
            border: none;
            border-radius: 6px;
            background: #198754;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        @media print {
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="success-container">

    <h2 class="success-title">
        Registration Successful!
    </h2>

    <p style="text-align:center;">
        Your student registration has been submitted successfully.
    </p>

    <div class="details">

        <p><strong>Registration ID:</strong>
            <?= clean($registration_id) ?>
        </p>

        <p><strong>Full Name:</strong>
            <?= clean($fullname) ?>
        </p>

        <p><strong>USN:</strong>
            <?= clean($usn) ?>
        </p>

        <p><strong>Email:</strong>
            <?= clean($email) ?>
        </p>

        <p><strong>Phone:</strong>
            <?= clean($phone) ?>
        </p>

        <p><strong>Gender:</strong>
            <?= clean($gender) ?>
        </p>

        <p><strong>Course:</strong>
            <?= clean($course) ?>
        </p>

        <p><strong>Semester:</strong>
            <?= clean($semester) ?>
        </p>

        <p><strong>Address:</strong>
            <?= clean($address) ?>
        </p>

    </div>

    <div class="action-buttons">
        <button onclick="window.print()">Print Details</button>

        <a href="index.php">Back to Registration</a>
    </div>

</div>

</body>
</html>
