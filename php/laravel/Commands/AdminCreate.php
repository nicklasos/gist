<?php

namespace App\Console\Commands;

use App\User;
use App\Http\Requests\AdminAdminCreateRequest;
use Illuminate\Console\Command;
use Validator;

class AdminCreate extends Command
{
    protected $signature = 'admin:create {email} {role=admin}';
    protected $description = 'Create admin user';

    public function handle()
    {
        $password = $this->secret('Type password');
        $repeat = $this->secret('Repeat');

        if ($password !== $repeat) {
            $this->error('Password mismatch');
            exit();
        }

        $validator = Validator::make($this->arguments(), [
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors());
            exit();
        }

        $email = $this->argument('email');
        $role = $this->argument('role');

        User::create([
            'name' => str_before($email, '@'),
            'email' => $email,
            'role' => $role,
            'password' => bcrypt($password),
        ]);

        $this->info('ok');
    }
}