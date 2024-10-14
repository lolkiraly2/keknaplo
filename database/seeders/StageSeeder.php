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
        Hike::create(['nev' => 'OKT']);
        Hike::create(['nev' => 'DDK']);
        Hike::create(['nev' => 'AK']);

        //DDK szakaszok
        stage::create([
            'nev' => 'DDK-01',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-02',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-03',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-04',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-05',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-06',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-07',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-08',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-09',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-10',
            'hike_id' => 2
        ]);

        stage::create([
            'nev' => 'DDK-11',
            'hike_id' => 2
        ]);

        //OKT szakaszok
        stage::create([
            'nev' => 'OKT-01',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-02',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-03',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-04',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-05',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-06',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-07',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-08',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-09',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-10',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-11',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-12',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-13',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-14',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-15',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-16',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-17',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-18',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-19',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-20',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-21',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-22',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-23',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-24',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-25',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-26',
            'hike_id' => 1
        ]);

        stage::create([
            'nev' => 'OKT-27',
            'hike_id' => 1
        ]);

        //AK szakaszok
        stage::create([
            'nev' => 'AK-01',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-02',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-03',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-04',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-05',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-06',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-07',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-08',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-09',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-10',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-11',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-12',
            'hike_id' => 3
        ]);

        stage::create([
            'nev' => 'AK-13',
            'hike_id' => 3
        ]);
    }
}
