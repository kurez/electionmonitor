<?php


use App\Models\Aspirant\Aspirant;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class AspirantsTableSeeder.
 */
class AspirantsTableSeeder extends Seeder
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
        // $this->truncate('aspirants');

        factory(Aspirant::class, 200)->create();

        $this->enableForeignKeys();
    }
}
