    <div id="modal-site" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Site Settings</h3>
        </div>
        <div class="modal-body">
            <form>
                <fieldset>
                    <label>Name</label>
                    <input class="input-xlarge" type="text" name="name" placeholder="Site name goes here" />
                </fieldset>

                <fieldset>
                    <label>Description</label>
                    <textarea rows="3" name="desc" ></textarea>
                </fieldset>

                <div class="switch">
                    <div class="head">
                        <label>Debug</label>
                        <i class="icon-bug"></i>
                    </div>
                    <div class="onoffswitch">
                        <input type="checkbox" name="debug" class="onoffswitch-checkbox" id="debugOnOff" >
                        <label class="onoffswitch-label" for="debugOnOff">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div>

                <div class="switch">
                    <div class="head">
                        <label>Location</label>
                        <i class="icon-map-marker"></i>
                    </div>
                    <div class="onoffswitch">
                        <input type="checkbox" name="location" class="onoffswitch-checkbox" id="locationOnOff" >
                        <label class="onoffswitch-label" for="locationOnOff">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div>

                <div class="switch">
                    <div class="head">
                        <label>Legend</label>
                        <i class="icon-tasks"></i>
                    </div>
                    <div class="onoffswitch">
                        <input type="checkbox" name="legend" class="onoffswitch-checkbox" id="legendOnOff" >
                        <label class="onoffswitch-label" for="legendOnOff">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div>
           </form>

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-primary save">Save</a>
        </div>
    </div>