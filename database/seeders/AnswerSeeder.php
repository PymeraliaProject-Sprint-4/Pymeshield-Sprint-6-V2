<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $answerCount = 300; // número total de respuestas que se crearán
        $yesCount = $answerCount / 2; // número de respuestas "Sí"
        $noCount = $answerCount / 2; // número de respuestas "No"

        // creación de respuestas "Sí"
        /*Answer::factory()->count($yesCount)->create([
            'name' => 'Sí'
        ]);*/

        // creación de respuestas "No"
        /*Answer::factory()->count($noCount)->create([
            'name' => 'No'
        ]);*/
    }

}
