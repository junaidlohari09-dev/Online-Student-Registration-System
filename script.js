
$(document).ready(function () {

    $("#registrationForm").submit(function (event) {

        let fullname = $("#fullname").val().trim();
        let usn = $("#usn").val().trim();
        let email = $("#email").val().trim();
        let phone = $("#phone").val().trim();
        let course = $("#course").val();
        let semester = $("#semester").val();
        let gender = $("input[name='gender']:checked").val();
        let address = $("#address").val().trim();

        let namePattern = /^[A-Za-z ]+$/;
        let usnPattern = /^[A-Za-z0-9]+$/;
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let phonePattern = /^[0-9]{10}$/;

        if (fullname.length < 3 || !namePattern.test(fullname)) {
            alert("Please enter a valid full name.");
            event.preventDefault();
            return;
        }

        if (!usnPattern.test(usn)) {
            alert("Please enter a valid USN.");
            event.preventDefault();
            return;
        }

        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            event.preventDefault();
            return;
        }

        if (!phonePattern.test(phone)) {
            alert("Mobile number must contain exactly 10 digits.");
            event.preventDefault();
            return;
        }

        if (course === "") {
            alert("Please select your course.");
            event.preventDefault();
            return;
        }

        if (semester === "") {
            alert("Please select your semester.");
            event.preventDefault();
            return;
        }

        if (!gender) {
            alert("Please select your gender.");
            event.preventDefault();
            return;
        }

        if (address.length < 10) {
            alert("Please enter a complete address.");
            event.preventDefault();
            return;
        }

        alert("Validation successful! Submitting your registration.");

    });

});
