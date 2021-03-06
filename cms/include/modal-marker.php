
    <div id="modal-marker" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Marker Details</h3>
        </div>
        <div class="modal-body">

            <p class="muted text-right edit-info">Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</p>

            <!-- <form> -->
            <form id="upload_form" action="../API/upload_image.php" method="post" enctype="multipart/form-data" target="upload_target" >

                <input type="hidden" name="c" value="content" />
                <input type="hidden" name="a" value="edit" />

                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs" id="marker-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">Location</a></li>
                        <li><a href="#tab2" data-toggle="tab">Content</a></li>
                        <li><a href="#tab3" data-toggle="tab">Image</a></li>
                        <li><a href="#tab4" data-toggle="tab">Category</a></li>
                        <li><a href="#tab5" data-toggle="tab">Social</a></li>
                    </ul>

                    <div class="tab-content">

                        <!-- TAB 1 -->
                        <div class="tab-pane active" id="tab1">

                            <div class="loc-container">
                                <div class="longlat"><spam class="geo_lng"></spam>, <spam class="geo_lat"></spam></div>
                                <img class="sat_map" width="530" height="250" />
                            </div>

                        </div>

                        <!-- TAB 2 -->
                        <div class="tab-pane" id="tab2">

                            <fieldset class="float-left">
                                <label>Title</label>
                                <input class="input-xlarge" type="text" name="title" placeholder="Title" />
                            </fieldset>

                            <fieldset class="float-left">
                                <label>Content</label>
                                <textarea rows="8" name="content" placeholder="Content here..."></textarea>
                                <span class="help-block">Please enter your content here (max char: 1000)</span>


                            </fieldset>

                        </div>

                        <!-- TAB 3 -->
                        <div class="tab-pane" id="tab3">
                            <div class="image-container">
                                <div class="dimensions">530x250px</div>
                                <div class="image-wrapper">
                                    <img class="image" />
                                </div>
                            </div>

                            <fieldset class="float-left ">
                                <label class="load-image">
                                    <a class="btn">Upload lmage Here! </a>
                                    <input type="file" name="file" id="file">
                                </label>
                            </fieldset>

                        </div>

                        <!-- TAB 4 -->
                        <div class="tab-pane" id="tab4">
                            <fieldset class="float-left">
                                <ul class="inline">
                                    <li>
                                        <label>
                                            <div class="switch cat">
                                                <p>Activity</p>
                                                <div class="pin">
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_green.png" />
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_shadow.png" class="shadow" />
                                                </div>
                                                <input type="radio" name="category" value="activity">
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <div class="switch cat">
                                                <p>History</p>
                                                <div class="pin">
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_orange.png" />
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_shadow.png" class="shadow" />
                                                </div>
                                            <input type="radio" name="category" value="history">
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <div class="switch cat">
                                                <p>Study</p>
                                                <div class="pin">
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_blue.png" />
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_shadow.png" class="shadow" />
                                                </div>
                                                <input type="radio" name="category" value="study">
                                            </div>
                                        </label>
                                    </li>
                                    <li class="last">
                                        <label>
                                            <div class="switch cat">
                                                <p>Todo!</p>
                                                <div class="pin">
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_todo.png" />
                                                    <img width="47" height="47" src="http://o.aolcdn.com/os/industry/misc/pin_shadow.png" class="shadow" />
                                                </div>
                                                <input type="radio" name="category" value="todo">
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </fieldset>

                        </div>

                        <!-- TAB 5 -->
                        <div class="tab-pane" id="tab5">
                            <div class="switch">
                                <div class="head">
                                    <label>Comments</label>
                                    <i class="icon-comments"></i>
                                </div>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="comments" class="onoffswitch-checkbox" id="commentsOnOff" >
                                    <label class="onoffswitch-label" for="commentsOnOff">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div>

                            <div class="switch">
                                <div class="head">
                                    <label>Twitter</label>
                                    <i class="icon-twitter"></i>
                                </div>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="twitter" class="onoffswitch-checkbox" id="twitterOnOff" >
                                    <label class="onoffswitch-label" for="twitterOnOff">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div>

                            <div class="switch">
                                <div class="head">
                                    <label>Facebook</label>
                                    <i class="icon-facebook"></i>
                                </div>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="facebook" class="onoffswitch-checkbox" id="facebookOnOff" >
                                    <label class="onoffswitch-label" for="facebookOnOff">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <input type="hidden" name="id" />
                <input type="hidden" name="user_id" />

            </form>


        </div>
        <div class="modal-footer">
            <iframe id="upload_target" name="upload_target" src="javascript:void(0);" ></iframe>

                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-primary save" data-loading-text="Saving..."><i class="icon-ok"></i> Save</a>
                <a href="#" class="btn btn-danger delete float-left"><i class="icon-remove"></i> Delete</a>
        </div>

            <div class="loader">
                <div class="progress progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
            </div>
        </div>

    </div>
