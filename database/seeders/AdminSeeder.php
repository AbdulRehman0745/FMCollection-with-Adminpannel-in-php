<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Admin;  // Import the Admin model if needed.

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        Admin::create([
            'name' => 'Admin User',  // You can change the name
            'email' => 'admin@example.com',  // Change the email if needed
            'password' => Hash::make('admin12345'),  // Set a password, it will be hashed
            'cnic' =>'1234567891234',
            'address' => 'Arif Wala',

        ]);
    }
}
