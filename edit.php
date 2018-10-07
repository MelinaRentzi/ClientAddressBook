<?php

session_start();

if(!$_SESSION['loggedInUser']) {
    // if user is not logged in, send them to login page
    header("Location: index.php");
}

$clientID = $_GET['id'];

include('includes/connection.php');
include('includes/functions.php');

// query the DB with client ID
$query = "SELECT * FROM clients WHERE id='$clientID'";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result)>0) {
    // if data is returned, set variables
    while($row = mysqli_fetch_assoc($result)) {
        $clientName = $row['name'];
        $clientEmail = $row['email'];
        $clientPhone = $row['phone'];
        $clientAddress = $row['address'];
        $clientCompany = $row['company'];
        $clientNotes = $row['notes'];
    }
} else {
    // no results
    $alertMessage = '<div class="alert alert-warning">Nothing to see here. <a href="clients.php">Head back</a>.</div>';
}

include('includes/header.php');
?>

    <h1>Edit Client</h1>

    <form action="clients.php" method="post" class="row">
        <div class="form-group col-sm-6">
            <label for="client-name">Name</label>
            <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="client-email">Email</label>
            <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="client-phone">Phone</label>
            <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="client-address">Address</label>
            <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientAddress; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="client-company">Company</label>
            <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="client-notes">Notes</label>
            <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientNotes; ?></textarea>
        </div>
        <div class="col-sm-12">
            <hr>
            <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
            <div class="pull-right">
                <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
                <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
            </div>
        </div>
    </form>

    <?php
include('includes/footer.php');
?>
