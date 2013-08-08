 <?php

// user functions

function view_dashboard () {

    $code = <<<CODE

    <div id="map-controls">
        <div class="map-zoom">
            <button id="zoomIn"  class="btn btn-primary"><i class="icon-plus-sign-alt"></i></button><br/>
            <button id="zoomOut" class="btn btn-primary"><i class="icon-minus-sign-alt"></i></button>
        </div>
    </div>

CODE;
    echo $code;
}

function show_legend () {

    $code = <<<CODE

    <div id="footer_wrapper">
        <div id="map-legend" class="container">
            <div class="progress ">
                <div class="bar activity bar-warning" style="width: 0%;">
                    <a href="#" title="" data-original-title="Activity">0</a>
                </div>
                <div class="bar history bar-success" style="width: 0%;">
                    <a href="#" title="" data-original-title="History">0</a>
                </div>
                <div class="bar study bar-danger" style="width: 0%;">
                    <a href="#" title="" data-original-title="Study">0</a>
                </div>
                <div class="bar pending bar-danger" style="width: 0%;">
                    <a href="#" title="" data-original-title="Pending">0</a>
                </div>
            </div>
        </div>
    </div>
CODE;
    echo $code;
}

function show_modal () {

    $code = <<<CODE

    <div id="modal" class="modal hide fade" data-keyboard="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Modal header</h3>
        </div>
        <div class="modal-body">
        <?php include("modal.php") ?>
        </div>
        <div class="modal-footer">
        <a href="#" id="edit-item" class="btn btn-primary">Edit</a>
        <a href="#" id="delete-item" class="btn btn-danger">Delete</a>
        </div>
    </div>
CODE;
    echo $code;
}

function view_debug () {

    $code = <<<CODE
        <div class="debug">
            <input id="longitude" type="text" value="">
            <input id="latitude" type="text" value="">
        </div>
CODE;
    echo $code;
}


?>

