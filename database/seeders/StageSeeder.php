<?php

namespace Database\Seeders;

use App\Models\Hike;
use App\Models\Stage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //túramozgalmak
        Hike::create(['name' => 'OKT']);
        Hike::create(['name' => 'DDK']);
        Hike::create(['name' => 'AK']);

        //DDK szakaszok
        stage::create([
            'name' => 'DDK-01',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-02',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-03',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-04',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-05',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-06',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-07',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-08',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-09',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-10',
            'hike_id' => 2
        ]);

        stage::create([
            'name' => 'DDK-11',
            'hike_id' => 2
        ]);

        //OKT szakaszok
        stage::create([
            'name' => 'OKT-01',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-02',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-03',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-04',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-05',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-06',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-07',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-08',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-09',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-10',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-11',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-12',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-13',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-14',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-15',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-16',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-17',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-18',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-19',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-20',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-21',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-22',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-23',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-24',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-25',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-26',
            'hike_id' => 1
        ]);

        stage::create([
            'name' => 'OKT-27',
            'hike_id' => 1
        ]);

        //AK szakaszok
        stage::create([
            'name' => 'AK-01',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-02',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-03',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-04',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-05',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-06',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-07',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-08',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-09',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-10',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-11',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-12',
            'hike_id' => 3
        ]);

        stage::create([
            'name' => 'AK-13',
            'hike_id' => 3
        ]);
    }
}
