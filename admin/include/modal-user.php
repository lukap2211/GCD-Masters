
    <div id="modal-user" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>My Settings</h3>
        </div>
        <div class="modal-body">

            <form>
                <fieldset class="float-left">
                    <label>First Name</label>
                    <input class="input-large" type="text" name="first_name" placeholder="First Name" />
                </fieldset>

                <div class="clearfix"></div>

                <fieldset class="float-left">
                    <label>Last Name</label>
                    <input class="input-large" type="text" name="last_name" placeholder="Last Name" />
                </fieldset>

                <fieldset class="float-left">
                    <label>Short Bio</label>
                    <textarea rows="3" name="bio" ></textarea>
                </fieldset>

                <input type="hidden" name="id" />

            </form>


            <legend>Reset Password</legend>

            <fieldset class="float-left">
                <label>New Password</label>
                <input type="password" name="new-pass" placeholder="Type new password">
                <span class="help-block">Please enter new password.</span>
            </fieldset>

            <fieldset class="float-right">
                <label>Repeat Password</label>
                <input type="password" name="repeat-pass" placeholder="Repeat new password">
                <span class="help-block">Repeated password must match.</span>
            </fieldset>

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-primary save">Save</a>
        </div>
    </div>