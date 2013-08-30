<?php

// Copyright 2013 Luka Puharic
// http://www.apache.org/licenses/LICENSE-2.0.txt


// show all errors
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// API calls - JSON only

// c = controler (content, user)
// a = action (all, id, add, edit, delete)
// f = filter

//open connection
require("../cms/include/connect.php");
global $conn;

// include
include("api_validate.php");
include("api_functions.php");

// preare query based on controler and action
switch ($c) {
    case 'user':
        switch ($a) {
            case 'all':
                users_all();
                break;
            case 'id':
                user_id();
                break;
            case 'add':
                user_add();
                break;
            case 'edit':
                user_edit();
                break;
            case 'delete':
                user_delete();
                break;
            default:
                die("no action for user!");
        }
        break;
    case 'content':
        switch ($a) {
            case 'all':
                item_all();
                break;
            case 'legend':
                item_legend();
                break;
            case 'id':
                item_id();
                break;
            case 'get_image':
                item_get_image();
                break;
            case 'add':
                item_add();
                break;
            case 'edit':
                item_edit();
                break;
            case 'edit_loc':
                item_edit_loc();
                break;
            case 'delete':
                item_delete();
                break;
            default:
                die("no action for content!");
        }
        break;
    case "site":
        switch ($a) {
            case 'id':
                site_id();
                break;
            case 'edit':
                site_edit();
                break;
        }
        break;
    default:
        die("no controler defined!");
}

?>