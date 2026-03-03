<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Colocation;

class ColocationSeeder extends Seeder
{
    public function run(): void
    {
        // --- Fetch the admin user ---
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'reputation' => 0,
            ]);
        }

        // --- Create 2 colocations ---
        $coloc1 = Colocation::create([
            'name' => 'Alpha Colocation',
            'owner_id' => $admin->id,
            'status' => 'active',
        ]);

        $coloc2 = Colocation::create([
            'name' => 'Beta Colocation',
            'owner_id' => 2, // placeholder, we'll assign later
            'status' => 'active',
        ]);

        // --- Create normal users ---
        $usersData = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Bob Brown', 'email' => 'bob@example.com'],
            ['name' => 'Alice White', 'email' => 'alice@example.com'],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'user',
                'reputation' => 0,
            ]);
            $users[] = $user;
        }

        // --- Attach users to colocations via pivot ---
        // Admin owns coloc1 and is automatically a member
        $coloc1->members()->attach($admin->id);

        // Add first 2 normal users to coloc1
        $coloc1->members()->attach([$users[0]->id, $users[1]->id]);

        // Add the other 2 users to coloc2
        $coloc2->owner_id = $users[2]->id; // set owner for coloc2
        $coloc2->save();
        $coloc2->members()->attach([$users[2]->id, $users[3]->id]);
    }
}