<?php
if (!isset($_SESSION['user_id'])) {
    // User not authenticated
    // TODO: Make this an actual system, for now just prompt message and log out

    // Right now if no user_id session is set the user will be logged out,
    // this doesn't check that the correct account is logged in, just that
    // an account is logged in
    echo "<script>alert('Authentication invalid. Logging out</script>";
    echo "<script>window.location.href='/'</script>";
}