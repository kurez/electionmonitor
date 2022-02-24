<?php


use App\Models\User\User;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder.
 */
class UsersTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        // $this->truncate('users');

        factory(User::class, 392)->create();

        $this->enableForeignKeys();
    }
}
