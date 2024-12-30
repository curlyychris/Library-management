
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="../Scripts/login_register_validator.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include('common_scripts_and_styles.php'); ?>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" action="../Actions/login_handler.php" method="POST">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input id="email" class="form-control" id="email" name="email" >
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" id="password" name="password"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" name="roleName">
                                    <option value="member">Member</option>
                                    <option value="librarian">Librarian</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            <p id="error" class="text-danger"><?= $_GET['errorMessage'] ?? '' ?></p>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Don't have an account? <a href="register_view.php">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    
    var form = null;

    $(document).ready(() => {

        const form = document.getElementById("loginForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault();
            const validationError = validateLoginForm();

            if (validationError == null) {

                form.removeEventListener("submit", arguments.callee);
                form.submit();
            }

            document.getElementById("error").innerText = validationError;
        });
    })


</script>