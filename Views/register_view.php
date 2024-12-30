<!DOCTYPE html>
<html lang="en">

<head>
<script src="../Scripts/login_register_validator.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php include('common_scripts_and_styles.php'); ?>
    <script>
        function toggleFields() {
            var role = document.getElementById('role').value;
            var memberFields = document.getElementById('memberFields');
            if (role === 'member') {
                memberFields.style.display = 'block';
            } else {
                memberFields.style.display = 'none';
            }
        }
        var form = null;

        $(document).ready(() => {

            const form = document.getElementById("registerForm");

            form.addEventListener("submit", function (event) {
                event.preventDefault();
                const validationError = validateRegisterForm();

                if (validationError == null) {

                    form.removeEventListener("submit", arguments.callee);
                    form.submit();
                }

                document.getElementById("error").innerText = validationError;
                console.log(validationError);
            });
        })
    </script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <form id="registerForm" action="../Actions/register_handler.php" method="POST">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" onchange="toggleFields()">
                                    <option value="member">Member</option>
                                    <option selected value="librarian">Librarian</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" id="name" name="name">
                            </div>
                            <div id="memberFields" style="display: none;">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input id="contact" type="text" class="form-control" id="contact" name="contact">
                                </div>
                                <div class="form-group">
                                    <label for="membership_id">Membership ID</label>
                                    <input id="membership_id" type="text" class="form-control" id="membership_id"
                                        name="membership_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input id="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input id="confirm_password" type="password" class="form-control" id="confirm_password"
                                    name="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                            <p id="error" class="text-danger"><?= $_GET['errorMessage'] ?? '' ?></p>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="login_view.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>