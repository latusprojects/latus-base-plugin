<?php
$create = require 'user/create.php';
$edit = require 'user/edit.php';

return
    []
    + $create + $edit;