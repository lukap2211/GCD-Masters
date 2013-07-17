    <?php
    global $username, $password;
    // echo "<br /><br />user: $username";
    // echo "<br />passs: $password";
    ?>

    <form class="form-signin" method="POST" action="login_check.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-medium" placeholder="Username" name="username" value="<?php ($username !== NULL) ? "" : $username ; echo $username; ?>" >
        <input type="password" class="input-medium" placeholder="Password" name="password" value="<?php ($password !== NULL) ? "" : $password ; echo $password; ?>">
        <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
    </form>