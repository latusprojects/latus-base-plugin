<?php
$create = require 'role/create.php';
$edit = require 'role/edit.php';

return
    [
        'action.prompt.delete.title' => 'Delete role: #',
        'action.prompt.delete.text' => 'This action is permanent and cannot be undone.<br/><br/><strong>Do you want to continue?</strong>',
        'action.prompt.locked.title' => 'Role is Blocked:',
        'action.prompt.locked.text' => 'This role is currently being edited by another user.<br><br>Please wait until they are done editing to continue.',
        'action.prompt.confirm' => 'Continue',
        'action.prompt.refresh' => 'Refresh Page',
        'action.prompt.cancel' => 'Cancel',
        'action.prompt.close' => 'Close',
    ]
    + $create + $edit;