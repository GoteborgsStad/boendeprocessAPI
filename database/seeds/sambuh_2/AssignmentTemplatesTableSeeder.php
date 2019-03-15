<?php

namespace sambuh_2;
use Illuminate\Database\Seeder;

class AssignmentTemplatesTableSeeder extends Seeder
{
    public function run()
    {
        $assignmentTemplates = collect([
            (object) [
                'name'                      => 'Lista vårdcentral',
                'description'               => 'För att ta dig framåt mot ditt hälsomål ska du ringa eller besöka en vårdcentral för att lista dig där. Du klarar uppdraget genom att skriva namnet på den vårdcentral som du listat dig hos och adressen dit.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Tandvård',
                'description'               => 'Som nästa steg i att ta dig mot hälsomålet ska du ringa och boka en tandläkartid, alternativt boka det via webb. För att klara uppdraget skriv vilket datum och tid samt vilken tandläkarmottagning det är.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Hälsoundersökning',
                'description'               => 'Kontakta din vårdcentral för en hälsoundersökning. På en hälsoundersökning kan du få koll på din grundhälsa. Dessutom kan du få tips på vad du kan påverka själv för att må bättre.Klara av uppdraget genom att beskriva vilken information du fick vid hälsoundersökningen.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Träning',
                'description'               => 'Planera och utför en fysisk aktivitet under veckan. Har du svårt att komma på vad du ska göra är det bara att chatta med mig om det! Ta ett foto under aktiviteten och skriv vad du gjort.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Regelbunden fritid',
                'description'               => 'Ta fram tre förslag på en fritidsaktivitet du kan tänka dig att börja med.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Betala räkningar i Internetbanken.',
                'description'               => 'Logga in på Internetbanken med ditt BankID och betala dina räkningar.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Kosthållning/planering',
                'description'               => 'Gör en veckomatlista och planera dina inköp. Planera minst 5 middagar och vad du behöver handla för att kunna laga dessa.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Tvättid',
                'description'               => 'Använd din tvättbricka/tvättnyckel för att boka en tid.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Lägenhetsunderhåll',
                'description'               => 'Frosta av din frys. Ta ut de varor som finns i frysen, stäng av den, samla upp smältvattnet så att det inte rinner ut på golvet och torka ur frysen när all is har smält. Sätt på frysen och lägg in dina varor igen.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Registrera dig på Boplats',
                'description'               => 'Gå till Boplats Göteborg och registrera dig. Betala avgiften så att du kan börja söka bostad.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Sök x antal lägenheter på Boplats. ',
                'description'               => 'Logga in på Boplats och sök lägenheter som du realistiskt sett skulle kunna få och kunna betala hyran på.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Hemförsäkring',
                'description'               => 'Ta kontakt med ett försäkringsbolag eller gör det via nätet. Teckna en hemförsäkring och ange att du ska betala den via autogiro.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Transport',
                'description'               => 'Gå till Startsida - Västtrafik - Västtrafik och sök färdväg till och från skolan.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Träffa en SYV',
                'description'               => 'Boka tid med din StudieSy- och yrkesvägledare och diskutera vad du kan göra efter gymnasiet.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Skriv ett personligt brev',
                'description'               => 'Sök på Internet om hur ett personligt brev kan se ut och skriv sedan ett eget utifrån det som du tycker passar dig.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Gör ett eget CV',
                'description'               => 'Fyll i det som är relevant i denna mall.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Ansök om ekonomiskt bistånd',
                'description'               => 'Gå till socialkontoret och lämna in en ansökan om ekonomiskt bistånd. Ta med kopior på handlingar som du måste bifoga med din ansökan.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Ha minst x% närvaro i skolan eller på din praktik',
                'description'               => 'Prata med din kontaktperson om hur du ska klara detta.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Skaffa en slutskattesedel',
                'description'               => 'Gå till skatteverket och be om ett slutskattebesked. Glöm inte att ta med legitimation!',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Gå med i A-kassan',
                'description'               => 'Fråga på din arbetsplats vilken a-kassa dina kollegor är med i eller anslut dig till alfa-kassan.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Brandsäkerhet',
                'description'               => 'Byt batteri på din brandvarnare. Ta ner brandvarnaren. Kolla vilket batteri som gäller. Köp batteri och montera.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Umgås med familj',
                'description'               => 'Bjud hem dina föräldrar/din förälder på en fika. Prata med din kontaktperson om hur du ska göra om du är osäker.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Familj och sociala relationer')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Kosthållning',
                'description'               => 'Ät frukost. Inhandla det du tror att du kommer att äta på morgonen. Gå upp i tid så att du hinner fixa en frukost.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Pausa från Internet och sociala medier.',
                'description'               => 'Stäng av mobil och dator vid uppgjord tid och så länge du tror det är realistiskt att du klarar det.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Hälsofrämjande självbild',
                'description'               => 'Skriv upp minst fem saker som får dig att må bra. Vad är du bra  på, vad tycker du om att göra, vad får dig att skratta, vad gör dig glad etc.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Hälsa')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Registrera dig som arbetssökande på Arbetsförmedlingen',
                'description'               => 'Detta kan du göra antingen hemifrån på Internet eller så kan du gå till närmaste Arbetsförmedling och få hjälp där.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Gör en skoluppgift',
                'description'               => 'Ta med dig läxan/uppgiften hem. Avsätt tid för när du ska jobba med det. Ta hjälp om du behöver det.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Sök 20 jobb',
                'description'               => 'Sök 20 jobb utspritt över tidsperioden. Du kan t.ex. ej söka alla samma dag. Ladda ner Platsbanken-appen eller gå i via AF:s hemsida https://www.arbetsformedlingen.se/.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Sök jobb',
                'description'               => 'Lämna ut CV till arbetsplatser. Skriv ut ditt CV och ta dig till de ställen du kan tänka dig att jobba på. Be att få prata med personalansvarig och lämna ditt CV och säg att du är intresserad av att få jobb där.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Sysselsättning')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Utvecklingssamtal',
                'description'               => 'Prata med din mentor och be att få ha ett utvecklingssamtal för att få en uppfattning om hur du ligger till i skolan. Bjud in din kontaktperson om du vill.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Självbild',
                'description'               => 'Skriv ett manus om ditt liv. Tänk film, bok eller pjäs. Fundera på vad som står i ditt manus, vilka har skrivit det, är du nöjd med delar av det eller vill du göra ett nytt. Be din kontaktperson om hjälp för tips.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Identitet',
                'description'               => 'Gör en lista med förebilder. Skriv ner minst tre förebilder. Det kan vara verkliga eller fiktiva personer och det kan vara personer som står dig nära eller som du aldrig har träffat.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Självbild/identitet',
                'description'               => 'Skriv en kontaktannons om dig själv. Beskriv dig själv i positiva ordalag för att få den vän eller partner du önskar.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Umgänge',
                'description'               => 'Bjud med en ny kompis på träningen. Ibland är det lättare att göra något samtidigt som man ska lära känna någon. Att bjuda med en bekant på ett träningspass där man gör saker i grupp kan vara ett mer avslappnat sätt att lära känna någon. Bolla med din kontaktperson om du inte vet hur du ska göra.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Familj och sociala relationer')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Sök bostad',
                'description'               => 'Registrera dig hos en privat hyresvärd. Förutom Boplats finns det flera privata hyresvärdar. Kolla upp om det går att registrera sig i kö hos dessa.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Gör en månadsbudget',
                'description'               => 'Skriv upp de inkomster och utgifter du har för varje månad och planera för kommande månad. Hur mycket lägger du på mat i månaden? Hur mycket lägger du på fika på stan. Finns det utrymme för att spara pengar?',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Deklarera',
                'description'               => 'När man jobbar och betalar skatt måste man deklarera. Detta gör du enklast på nätet idag. Gå in på Skatteverkets hemsida och kolla hur du gör.',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
            (object) [
                'name'                      => 'Gå med i en förening eller klubb',
                'description'               => 'Kolla upp vilka föreningar eller klubbar det finns som du har ett intresse för. Du kanske är politiskt intresserad eller vill bli volontär?',
                'start_at'                  => null,
                'end_at'                    => null,
                'image_url'                 => null,
                'color'                     => null,
                'assignment_category_id'    => \App\AssignmentCategory::where('name', 'Klara sig själv')->firstOrFail()->id,
                'assignment_status_id'      => \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail()->id,
            ],
        ]);

        \App\AssignmentTemplate::get()->each(function ($f) {
            $f->delete();
        });

        $assignmentTemplates->each(function ($f) {
            \App\AssignmentTemplate::create([
                'name'                      => $f->name,
                'description'               => $f->description,
                'start_at'                  => $f->start_at,
                'end_at'                    => $f->end_at,
                'image_url'                 => $f->image_url,
                'color'                     => $f->color,
                'assignment_category_id'    => $f->assignment_category_id,
                'assignment_status_id'      => $f->assignment_status_id,
            ]);
        });
    }
}
