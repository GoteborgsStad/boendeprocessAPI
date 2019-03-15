<?php

namespace test;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts       = \App\User::contacts()->get();
        $operands       = \App\Operand::get();
        $faqCategory    = \App\FaqCategory::where('name', 'Feedback')->firstOrFail();

        $questions = ['Varför en app?','Vad menas med växten på första sidan?','Vad bestämmer när ett uppdrag är utfört?','Hur vet jag när jag får ett uppdrag i appen?','Vad händer med det som jag skriver i appen?','Hur fungerar månadskollen?','Vem kan se vad jag skriver i chatten?','Vad är ett kontaktsamtal?','Skriver ni ner allt som jag gör på Sambuh?','Vad menas med sekretess inom Socialtjänsten?','Har ni nycklar och kan gå in i min lägenhet?','Får jag ha en kompis som sover över i min lägenhet?','Kan jag ha hund i min lägenhet?','Går det bra att ta med egna möbler till min lägenhet?','Hur lång tid bor man på HVB?','Hur lång tid bor man i stödboende?','Ingår TV i boendet?','Vad ingår i hyran?','Vad gäller kring hemförsäkring?'];
        $answers = ['Den här appen hjälper dig att följa ditt boende här på Sambuh. I appen kan du se hur det går för dig med det du ska jobba med på Sambuh.. Du kommer få uppdrag i appen som är kopplade till den plan vi tillsammans med din handläggare kommit överens om. Dessa uppdrag är till för att du ska träna på att bo själv och bli självständig. Allt eftersom du utför uppdrag kommer en växt att växa på förstasidan i appen. På förstasidan ser du också hur du ligger till i de olika delmomenten i Sambuh: boende, delaktighet och uppdrag. Du kan se vilka områden du behöver jobba lite mer med för att komma närmare målet med boendet.','Växten visar din utveckling på Sambuh. För varje uppdrag du får kommer ett blad, när det är dags att göra uppdraget lyser det blått och när du utfört uppdraget blir bladet grönt. Är du sen med ett uppdrag vissnar bladet. Klickar du på ett blad kommer du till det uppdrag som det gäller. När du uppnått ett av de större målen du har så kommer en blomma att slå ut.','När du får ett uppdrag står det där hur du visar att uppdraget är utfört. När din kontaktperson sett och godkänt att du utfört uppdraget kommer växten visa detta.','Om du går till inställningar i din telefon kan du ställa in att du får en notis från Sambuhs app när ett uppdrag kommit. Du kan också logga in i appen för att se nya uppdrag.','Under tiden du bor på Sambuh finns det kvar. När du flyttar ut från Sambuh raderas ditt konto och allt du skrivit.','Varje månad gör din kontaktperson en bedömning av hur det fungerar för dig på Sambuh. Bedömningen görs inom tre områden: 1. Om du betalat hyra och skött ditt boende, 2. Om du deltagit i kontaktträffar och andra planerade möten, 3. Om du utfört de uppdrag du fått i appen. På första sidan i appen ser du tre smileys som visar hur månaden fungerat. Genom att klicka på fliken “Månadskollen” kan du läsa varför du fått vilken smiley och se dina mål.','Det är bara den i personalen du chattar med som kan se dina inlägg.','Varje vecka har du en planerad träff med din kontaktperson på Sambuh.','Nej. Vi har däremot skyldighet att dokumentera det vi gör tillsamman med dig för att nå de mål vi har satt upp. Händer det viktiga saker måste vi även dokumentera det.','Det betyder att vi får inte lämna ut information om dig till andra om du inte själv godkänt det. Det finns några undantag. Fråga personalen om du har funderingar kring detta.','Vi har nycklar till din lägenhet. Om vi inte får tag på dig och blir oroliga så kan vi gå in i lägenheten.','De först två veckorna får du inte det. Efter den perioden går det bra, men vi vill att det sker på helgen och att du planerar det med din kontaktperson.','Nej, du kan inte ha några husdjur när du bor på Sambuh.','Nej det går tyvärr inte. Vi har begränsade möjligheter att förvara de möbler som redan finns i lägenheten. Alla vår lägenheter är fullt möblerade.','Det är individuellt. Du bor där tills vi känner att du klarar av de delar som är viktiga att kunna för att bli självständigt. Det viktigaste är att du klarar av att komma upp och gå iväg till din sysselsättning.','Det vanliga är att du först bor i stödboende en period med daglig kontakt. När vi känner att du inte längre behöver det stödet går du in i det som kallas stödboende referens. Då har du bara kontakt med din kontaktperson. Stödboende referens pågår vanligtvis under sex månader. Unde de månaderna ska du betala in din hyra i tid, sköta ditt boende och delta i och utföra de uppdrag du får i appen.','Det finns TV om du vill låna den under tiden på Sambuh. Du har själv ansvar för att betala TV-avgift till Radiotjänst.','El, vatten och värme ingår i hyran.','Bor du i Stödboende så kommer du att folkbokföras på den adressen. Du är då skyldig att teckna en hemförsäkring. Din kontaktperson hjälper dig med detta i samband med att du flyttar in.'];

        factory(\App\Faq::class, count($questions))->create()->each(function ($f) use(&$contacts, &$faqCategory, &$operands, &$questions, &$answers) {
            $f->faqCategory()->associate($faqCategory);
            $f->operand()->associate($operands->random());
            $f->user()->associate($contacts->random());
            $f->name = array_shift($questions);
            $f->description = array_shift($answers);
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
