<?php
$page_name = 'User Overview';
include __DIR__ . '/inc/header.php';
if(!isset($_SESSION['logged_in'])){
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/userClass.php';

?>

    <div class="content">
        <br><br>
        <article>
            <h2>User Management Admin</h2>
        </article>
    </div>

    <div class="regwrapper">

        <form action="#" method="POST">
            <input type="text" name="email" placeholder="String Email">
            <button type="submit" name="search">Search</button>
        </form>

        <?php
        if (isset($_POST['search'])) {
            $user = new User();
            try {
                $user->userSearch($_POST['email']);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        ?>
    </div>


    <div class="container">
        <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
            <tr>
                <th>UserID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Profile</th>
                <th>Edit</th>
            </tr>

            <?php
            $user = new User();
            $user->loadAllUsers();
            ?>
        </table>
        <br><br>
    </div>


<?php include __DIR__ . '/inc/footer.php';

