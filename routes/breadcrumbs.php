<?php

// Import
Breadcrumbs::for('import', function ($trail) {
    $trail->push('Import', route('admin.import.index'));
});

// Profile
Breadcrumbs::for('profile', function ($trail, $user) {
    $trail->push('Profile', route('admin.profiles.edit', $user->id));
});