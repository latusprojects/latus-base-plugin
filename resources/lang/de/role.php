<?php
$create = require 'role/create.php';
$edit = require 'role/edit.php';

return
    [
        'action.prompt.delete.title' => 'Rolle löschen: #',
        'action.prompt.delete.text' => 'Diese Aktion ist permanent und kann nicht rückgängig gemacht werden.<br/><br/><strong>Trotzdem fortfahren?</strong>',
        'action.prompt.locked.title' => 'Rolle ist blockiert:',
        'action.prompt.locked.text' => 'Diese Rolle wird aktuell von einem anderen Nutzer bearbeitet.<br><br>Bitte warte, bis Dieser fertig ist, um fortzufahren.',
        'action.prompt.confirm' => 'Fortfahren',
        'action.prompt.refresh' => 'Seite aktualisieren',
        'action.prompt.cancel' => 'Abbrechen',
        'action.prompt.close' => 'Schließen',
    ]
    + $create + $edit;