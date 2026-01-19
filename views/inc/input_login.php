<div class="center">
    <div> 
    <h3>Welcome back <?php echo $_COOKIE['known_user'];?></h3>
        <form method="POST" action="src/user_processing.php">
        <input type="password" name="password" placeholder="password" id="stdInput"><br>
        <button type="reset">Clear</button>
        <button type="submit" name="submit_known_user">Login</button>
        <br>
        <button type="submit" name="submit_clear_cookie">Not me?</button>
        </form>
    <?php if(isset($_SESSION['invalid_user_msg'])) echo "<small><i>*{$_SESSION['invalid_user_msg']}</i></small>"; ?>
    </div>
    <div> 
    </div>
</div>
