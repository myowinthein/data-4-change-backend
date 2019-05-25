<?php

// Import
Breadcrumbs::for('import', function ($trail) {
    $trail->push('Import', route('admin.import.index'));
});