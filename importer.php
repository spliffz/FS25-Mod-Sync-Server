<?php
# Version 1.0
#
# This import the mods from GPortal and runs the indexer each import.
# Either visit it via a browser or run it via the CLI 'php check.php'
# Run it in a cronjob for maximum effort
# */5 * * * * php importer.php
#
require __DIR__ . '/header.php';

if($misc->importModsFromGPortal()) {
    echo "Import completed successfully.";
}

?>