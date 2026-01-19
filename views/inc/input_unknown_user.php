<div class="center">
    <div> 
        <h3>Login or register a new user</h3>
        <form method="POST" action="src/user_processing.php">
        <input type="text" name="alias" placeholder="alias" id="stdInput"><br>
        <input type="password" name="password" placeholder="password" id="stdInput"><br>
        <button type="reset">Clear</button>
        <button type="submit" name="submit_login_user">Login</button>
        <button type="submit" name="submit_new_user">Register</button>
        </form>
    <?php if(isset($_SESSION['invalid_user_msg'])) echo "<small><i>*{$_SESSION['invalid_user_msg']}</i></small>"; ?>
    </div>
    <div> 
    </div>
</div>
