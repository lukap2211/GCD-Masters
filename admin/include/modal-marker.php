
    <div id="modal-marker" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Marker Details</h3>
        </div>
        <div class="modal-body">

            <form>


                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">Location</a></li>
                        <li><a href="#tab2" data-toggle="tab">Content</a></li>
                        <li><a href="#tab3" data-toggle="tab">Category</a></li>
                    </ul>

                    <div class="tab-content">

                        <!-- TAB 1 -->
                        <div class="tab-pane active" id="tab1">

                            <fieldset class="float-left">
                                <label>Longitude</label>
                                <input class="input-large" type="text" name="geo_lng" disabled />
                            </fieldset>

                            <fieldset class="float-left">
                                <label>Latitude</label>
                                <input class="input-large" type="text" name="geo_lat" disabled />
                            </fieldset>

                            <img class="sat_map" width="530" height="250" />

                        </div>

                        <!-- TAB 2 -->
                        <div class="tab-pane" id="tab2">

                            <fieldset class="float-left">
                                <label>Title</label>
                                <input class="input-xlarge" type="text" name="title" placeholder="Title" />
                            </fieldset>

                            <fieldset class="float-left">
                                <label>Content</label>
                                <textarea rows="10" name="content" placeholder="Content here..."></textarea>
                            </fieldset>

                        </div>

                        <!-- TAB 3 -->
                        <div class="tab-pane" id="tab3">
                            <fieldset class="float-left">
                                <ul class="inline">
                                    <li>
                                        <label>
                                            <div class="switch">
                                                <p>Activity</p>
                                                <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_green.png" />
                                                <input type="radio" name="category" value="activity">
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <div class="switch">
                                                <p>History</p>
                                                <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_orange.png" />
                                                <input type="radio" name="category" value="history">
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <div class="switch">
                                                <p>Study</p>
                                                <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_blue.png" />
                                                <input type="radio" name="category" value="study">
                                            </div>
                                        </label>
                                    </li>
                                    <li class="last">
                                        <label>
                                            <div class="switch">
                                                <p>Todo!</p>
                                                <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_todo.png" />
                                                <input type="radio" name="category" value="todo">
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </fieldset>

                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" />
                <input type="hidden" name="user_id" />

            </form>


        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-primary save" data-dismiss="modal">Save</a>
            <a href="#" class="btn btn-danger delete float-left" data-dismiss="modal">Delete</a>
        </div>
    </div>
