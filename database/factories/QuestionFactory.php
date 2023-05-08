<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static $counter = 1;

    public function definition()
    {

        $description = array(
            '¿Utilitzes contrasenyes segures per a les teves comptes?',
            '¿Has activat la verificació en dos passos en els teus comptes?',
            '¿Has instal·lat un programa antivirus en el teu dispositiu?',
            '¿Actualitzes regularment el software del teu dispositiu?',
            '¿Verifiques la identitat de les persones que et contacten per correu electrònic o xarxes socials?',
            '¿Utilitzes xifrat de dades per protegir les teves comunicacions?',
            '¿Has desactivat la connexió Wi-Fi o Bluetooth quan no els utilitzes?',
            '¿Has configurat la privacitat de les teves xarxes socials per evitar que desconeguts puguin accedir a la teva informació personal?',
            '¿Has revisat la configuració de privacitat i seguretat dels teus comptes en línia recentment?',
            '¿Has rebutjat correus electrònics sospitosos o de remitents desconeguts?',
            '¿Has comprovat la veracitat de la informació abans de compartir-la o difondre-la en línia?',
            '¿Has tancat la sessió dels teus comptes quan acabes d’utilitzar-los?',
            '¿Has creat còpies de seguretat de la teva informació important?',
            '¿Has utilitzat un cable ethernet en lloc de Wi-Fi per connectar-te a Internet?',
            '¿Has configurat el teu router per evitar que altres persones es puguin connectar a la teva xarxa sense permís?',
            '¿Has activat la funció de bloqueig del teu telèfon mòbil amb una contrasenya o un patró?',
            '¿Has descarregat aplicacions només de fonts fiables i segures?',
            '¿Has rebutjat trucades o missatges de text sospitosos o de números desconeguts?',
            '¿Has desactivat la localització del teu dispositiu quan no la necessites?',
            '¿Has revisat les autoritzacions que dones a les aplicacions instal·lades en el teu dispositiu?',
            '¿Has configurat el firewall del teu ordinador per bloquejar connexions no autoritzades?',
            '¿Has utilitzat una clau USB que no coneixes l’origen?',
            '¿Has iniciat sessió als teus comptes en línia des d’un lloc públic?',
            '¿Has compartit informació personal en línia amb persones desconegudes?',
            '¿Has obert arxius adjunts en correus electrònics de remitents desconeguts?',
            '¿Has caigut en l’engany del phishing o del correu electrònic maliciós en línia?',
            '¿Has permès que altres persones utilitzin el teu compte d’usuari en línia?',
            '¿Has obert l’enllaç d’una pàgina web desconeguda?',
            '¿Has permès que la teva informació personal sigui visible per a tothom a les xarxes socials?',
            '¿Has compartit el teu nom d’usuari o la teva contrasenya amb algú més?'
        );

        return [
            'name' => str_pad(self::$counter++, 4, '0', STR_PAD_LEFT),
            'description' => fake()->randomElement($description),
        ];
    }

    public function initialize()
    {
        self::$counter = 0;
    }
}
