
<?php
require_once "db.php";

$search = trim($_GET["search"] ?? "");

if ($search !== "") {
    $sql = "SELECT * FROM students
            WHERE full_name LIKE ? OR usn LIKE ? OR registration_id LIKE ?
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $term = "%" . $search . "%";
    $stmt->bind_param("sss", $term, $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM students ORDER BY id DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .records-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin: 30px auto;
            overflow-x: auto;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .search-form input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .search-form button {
            padding: 12px 20px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #173b70;
            color: white;
        }

        tr:nth-child(even) {
            background: #f5f7fa;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="container">
        <h1>Student Portal</h1>
        <p>Admin - Registered Students</p>
    </div>
</header>

<main class="container">
    <section class="records-card">

        <h2>Registered Students</h2>

        <form method="GET" class="search-form">
            <input type="text" name="search"
                   placeholder="Search by name, USN or registration ID"
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="submit-btn">Search</button>
        </form>

        <p><strong>Total records:</strong> <?= $result->num_rows ?></p>

        <table>
            <tr>
                <th>ID</th>
                <th>Registration ID</th>
                <th>Name</th>
                <th>USN</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Gender</th>
                <th>Address</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row["id"]) ?></td>
                <td><?= htmlspecialchars($row["registration_id"]) ?></td>
                <td><?= htmlspecialchars($row["full_name"]) ?></td>
                <td><?= htmlspecialchars($row["usn"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td><?= htmlspecialchars($row["phone"]) ?></td>
                <td><?= htmlspecialchars($row["course"]) ?></td>
                <td><?= htmlspecialchars($row["semester"]) ?></td>
                <td><?= htmlspecialchars($row["gender"]) ?></td>
                <td><?= htmlspecialchars($row["address"]) ?></td>
            </tr>
            <?php endwhile; ?>

            <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="10">No student records found.</td>
            </tr>
            <?php endif; ?>
        </table>

        <br>
        <a href="index.php" class="back-btn">Back to Registration</a>

    </section>
</main>

</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
