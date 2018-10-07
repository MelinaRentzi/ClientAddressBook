<?php
session_start();

include('includes/functions.php');

// if login form was submitted (name)
if(isset($_POST['login'])) {
    // create variables and wrap data with validate function
    $formEmail = validateFormData($_POST['email']);
    $formPass = validateFormData($_POST['password']);
    
    // connect to DB
    include('includes/connection.php');
    
    // create query
    $query = "SELECT name, password FROM users WHERE email='$formEmail'";
    
    // store the result
    $result = mysqli_query($conn, $query);
    
    // verify if a result is returned
    if(mysqli_num_rows($result)>0) {
        // store basic data in variables
        while($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $hashedPass = $row['password'];
        }
        // verify hashed password with submitted password
        if(password_verify($formPass, $hashedPass)){
            // correct login creds -> store data in SESSION variables
            $_SESSION['loggedInUser'] = $name;
            
            // redirect to clients page
            header("Location: clients.php");
        } else {
            // hashed password didn't verify/match
            // error message
            $loginError = "<div class='alert alert-danger'>Wrong username/password combination. Try again.</div>";
        }
    } else {
        // no results in DB
        $loginError = "<div class='alert alert-danger'>No such user in database. Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

// close mysql connection
mysqli_close($conn);

include('includes/header.php');

// https://stackoverflow.com/questions/37064029/cant-connect-to-mysql-server-on-localhost-10061-2003-error-phpmyadmin-usi
?>

    <h1>Client Address Book</h1>
    <p class="lead">Log in to your account.</p>

    <?php echo $loginError; ?>

    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="login-email" class="sr-only">Email</label>
            <input type="text" class="form-control" id="login-email" placeholder="email" name="email" value="<?php echo $formEmail ?>">
        </div>
        <div class="form-group">
            <label for="login-password" class="sr-only">Password</label>
            <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>

    <?php
include('includes/footer.php');
?>
