<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class GenerateSlugsForExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing users who do not have slugs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get users without a slug
        $users = User::whereNull('slug')->get();

        foreach ($users as $user) {
            // Generate the slug based on first and last name
            $name = trim("{$user->first_name} {$user->last_name}") ?: explode('@', $user->email)[0];
            $slug = $this->generateUniqueSlug($name);

            // Update the user's slug
            $user->slug = $slug;
            $user->save();

            $this->info("Generated slug '{$slug}' for user ID: {$user->id}");
        }

        $this->info('Slugs have been generated for all users without slugs.');
        return Command::SUCCESS;
    }

    /**
     * Generate a unique slug for the user.
     *
     * @param string $name
     * @return string
     */
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name, '-');
        $count = User::where('slug', 'LIKE', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}
