<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true, // Enable creation of a user for each role during seeding

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true, // Ensures a clean database before seeding

    /**
     * Roles and their permissions structure.
     */
    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',         // Manage users
            'students' => 'c,r,u,d',      // Manage student records
            'payments' => 'c,r,u,d',      // Manage payments
            'fees' => 'c,r,u,d',          // Manage fee settings
            'reports' => 'c,r,u,d',       // Generate and manage reports
        ],
        'parent' => [
            'students' => 'r',            // View student records
            'payments' => 'c,r',          // Make and view payments
        ],
        'teacher' => [
            'students' => 'r,u',          // View and update student records
        ],
    ],

    /**
     * Map of permission abbreviations to their full names.
     */
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
