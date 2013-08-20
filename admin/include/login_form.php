    <?php
    global $username, $password;
    // echo "<br /><br />user: $username";
    // echo "<br />passs: $password";
    ?>

    <form class="form-horizontal" method="POST" action="index.php">
        <!-- <h2 class="form-signin-heading">Please sign in</h2> -->
        <legend>Please sign in</legend>
        <div class="control-group">
            <label class="control-label" for="inputUsername">Password</label>
            <div class="controls">
                <input id="inputUsername" type="text" class="input-medium" placeholder="Username" name="username" value="<?php ($username !== NULL) ? "" : $username ; echo $username; ?>" >
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">Password</label>
            <div class="controls">
                <input id="inputPassword" type="password" class="input-medium" placeholder="Password" name="password" value="<?php ($password !== NULL) ? "" : $password ; echo $password; ?>" >
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            </div>
        </div>

    </form>