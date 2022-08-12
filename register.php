<?php
$page_name = 'Registration';
include __DIR__ . '/inc/header.php';
?>

    <div class="content">

        <form action="register.php" method="post">

            <input type="text" name="first_name" id="firstname" placeholder="First name" required>
            <input type="text" name="last_name" id="lastname" placeholder="Last name" required>
            <input type="text" name="address" id="address" placeholder="Address" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="password2" id="password" placeholder="Confirm password" required>

            <button type="submit" name="regbtn" id="regbtn">Register!</button>
        </form>

        //SHA1 gleich bei übernahme hier

        <?php
        if (isset($_POST['regbtn'])) {
            include __DIR__ . '/classes/userClass.php';
            $user = new User();
            try {
                $user->userRegistration($_POST);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        ?>
    </div>
<?php include __DIR__ . '/inc/footer.php';
