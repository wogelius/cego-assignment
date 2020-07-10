<?php

namespace Tests\Feature;

use App\User;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This test generates 500 random users, and ensures that 500 lines are written to the csv-file
     *
     * @test
     */
    public function it_generates_csv_file_and_deletes_from_database()
    {
        factory(User::class, 500)->create();

        $this->assertDatabaseCount('users', 500);

        $this->artisan('run');
        $filePath = storage_path('app/user_export.csv');

        $this->assertDatabaseCount('users', 0);
        $this->assertCount(500, file($filePath));
        unlink($filePath);
    }

    /**
     * This test ensures that the correct records are applied to the file
     *
     * @test
     */

     public function it_generates_the_correct_records()
     {
        factory(User::class, 500)->create();
        $users = User::all();

        $filePath = storage_path('app/user_export.csv');

        $this->artisan('run');
        $file = fopen($filePath, 'r');

        foreach ($users as $user) {
            $this->assertEquals(array_values($user->toArray()), fgetcsv($file));
        }

        unlink($filePath);
     }
}
