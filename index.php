
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration System</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js" defer></script>
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
                <h2>Student Registration</h2>
                <p>Fill in your details to complete registration.</p>
            </div>

            <form id="registrationForm" action="process.php" method="POST">

                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname"
                           placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="usn">University Seat Number (USN)</label>
                    <input type="text" id="usn" name="usn"
                           placeholder="Enter your USN" required>
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                               placeholder="example@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Mobile Number</label>
                        <input type="tel" id="phone" name="phone"
                               placeholder="Enter 10-digit number"
                               pattern="[0-9]{10}" required>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="course">Select Course</label>
                        <select id="course" name="course" required>
                            <option value="">Choose your course</option>
                            <option value="Computer Science Engineering">Computer Science Engineering</option>
                            <option value="Information Science Engineering">Information Science Engineering</option>
                            <option value="Electronics and Communication">Electronics and Communication</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine Learning</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select id="semester" name="semester" required>
                            <option value="">Select semester</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                            <option value="3">3rd Semester</option>
                            <option value="4">4th Semester</option>
                            <option value="5">5th Semester</option>
                            <option value="6">6th Semester</option>
                            <option value="7">7th Semester</option>
                            <option value="8">8th Semester</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label>Gender</label>

                    <div class="gender-options">
                        <label>
                            <input type="radio" name="gender" value="Male" required>
                            Male
                        </label>

                        <label>
                            <input type="radio" name="gender" value="Female">
                            Female
                        </label>

                        <label>
                            <input type="radio" name="gender" value="Other">
                            Other
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"
                              placeholder="Enter your complete address"
                              rows="4" required></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    Submit Registration
                </button>

            </form>

        </section>

    </main>

    <footer class="footer">
        <p>© 2026 Student Portal | Online Student Registration System</p>
    </footer>

</body>
</html>
