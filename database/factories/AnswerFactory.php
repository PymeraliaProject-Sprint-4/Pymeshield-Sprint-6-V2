<?php

namespace Database\Factories;

use App\Models\Impact;
use App\Models\Intervention;
use App\Models\Probability;
use App\Models\Question;
use App\Models\Risk;
use App\Models\TypeMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $risk_id = Risk::all()->pluck('id')->toArray();
        $intervention_id = Intervention::all()->pluck('id')->toArray();
        $type_measure_id = TypeMeasure::all()->pluck('id')->toArray();
        $probability_id = Probability::all()->pluck('id')->toArray();
        $impact_id = Impact::all()->pluck('id')->toArray();
        $question_id = Question::all()->pluck('id')->toArray();

        $recomentations = array(
            'Configura la funció de bloqueig del teu telèfon mòbil amb una contrasenya o un patró difícil de endevinar.',
            'Descarrega aplicacions només de fonts fiables i segures com Google Play o l’App Store.',
            'No responguis a trucades o missatges de text sospitosos o de números desconeguts.',
            'Desactiva la localització del teu dispositiu quan no la necessitis per preservar la teva privacitat.',
            'Revisa les autoritzacions que dones a les aplicacions instal·lades en el teu dispositiu i elimina les que no són necessàries.',
            'Configura el firewall del teu ordinador per bloquejar connexions no autoritzades i impedeix l’accés a ports no segurs.',
            'No utilitzis claus USB desconegudes o d’origen no confiable.',
            'Evita iniciar sessió als teus comptes en línia des d’un lloc públic per evitar ser víctima de ciberdelinqüents.',
            'No compartis informació personal en línia amb persones desconegudes i assegura’t de mantenir la teva informació personal segura.',
            'No obre arxius adjunts en correus electrònics de remitents desconeguts i elimina’ls immediatament.',
            'Estar alerta davant de correus electrònics sospitosos i no proporciones informació personal a través de correus electrònics.',
            'No permetis que altres persones utilitzin el teu compte d’usuari en línia i protegeix la teva informació personal.',
            'No obre enllaços a pàgines web desconegudes i assegura’t de verificar la URL abans de fer clic.',
            'Mantén la teva informació personal privada a les xarxes socials i no la compartis amb tothom.',
            'No comparteixis el teu nom d’usuari ni la teva contrasenya amb altres persones, ni tan sols amb familiars o amics.',
            'Mantén actualitzat el teu sistema operatiu i les aplicacions instal·lades en el teu dispositiu per evitar vulnerabilitats de seguretat.',
            'No utilitzis xarxes Wi-Fi públiques no segures per evitar que els teus dades siguin robades.',
            'No utilitzis contrasenyes senzilles o obvies i utilitza contrasenyes úniques per a cada compte.',
            'Mantén una còpia de seguretat de la teva informació important i guarda-la en un lloc segur.',
            'Instal·la un programari antivirus en el teu dispositiu per protegir-te contra virus i malware.',
            'No comparteixis informació bancària o financera en línia a menys que estiguis segur que la connexió és segura.',
            'No utilitzis el mateix nom d’usuari i contrasenya per a múltiples comptes en línia per evitar que si un compte és piratejat, tots els altres també ho siguin.',
            'Configura la funció de bloqueig automàtic del teu dispositiu perquè es bloquegi automàticament després d’un període d’inactivitat.',
            'No emmagatzemis informació personal en línia, com ara documents d’identitat o fotografies de passaports.',
            'Sigues prudent al fer clic en enllaços acortats en xarxes socials o en correus electrònics per evitar ser redirigit a pàgines malicioses.',
            'No executis programes desconeguts en el teu dispositiu sense verificar primer la font i la seguretat del programa.',
            'Configura el teu router Wi-Fi amb una contrasenya forta per evitar que altres persones accedeixin a la teva xarxa.',
            'Desactiva el Bluetooth en el teu dispositiu quan no el necessitis per evitar connexions no autoritzades.',
            'Sigues conscient dels missatges de phishing i de les estafes en línia i no proporcionis informació personal a persones que no coneixes.',
            'No utilitzis l’opció de “recordar-me” en llocs web on has iniciat sessió per evitar que altres persones accedeixin als teus comptes.'
        );


        return [
            'name' => $this->faker->unique()->name(),
            'recommendation' => $this->faker->randomElement($recomentations),
            'risk_id' => $this->faker->randomElement($risk_id),
            'intervention_id' => $this->faker->randomElement($intervention_id),
            'type_measure_id' => $this->faker->randomElement($type_measure_id),
            'probability_id' => $this->faker->randomElement($probability_id),
            'impact_id' => $this->faker->randomElement($impact_id),
            'question_id' => $this->faker->randomElement($question_id),
            'hidden' => $this->faker->date(),
        ];
    }
}
