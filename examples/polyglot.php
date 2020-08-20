<?php
require "../vendor/autoload.php";

$nlpserver_config = [
    'hosts'     => [
        'http://localhost:6400/',
        'http://localhost:6400/',
    ],
    'debug'     => false,
];

$nlp = new \Web64\Nlp\NlpClient( $nlpserver_config['hosts'], $nlpserver_config['debug'] );


$text = "Den har en tykk, sukkulent stamme som blir 1,5–8 m høy. Stammen er bare forgrenet i toppen på eldre planter. Stammen og eventuelle greiner er dekket av lange torner, som er omdannede akselblad. I toppen av planten sitter en rosett med avlange blad. Bladene er olivengrønne på oversiden og lyse under. Etterhvert som planten vokser, faller bladene av nedover stammen, men tornene står parvis igjen i de gamle bladfestene. Blomstene er femtallige og hvite. Arten vokser i torneskogene på sørlige og sørvestlige Madagaskar opptil 750 moh.
Madagaskarpalme blir plantet i hager i områder uten frost, og i kaldere strøk er den en populær stueplante. Til tross for navnet er den ingen palme, og den er heller ingen kaktus. Den utvikler sjelden blomster når den dyrkes innendørs. Planten mister bladene når den gjør seg klar til tørketiden. Da må den ikke vannes, ellers råtner stammen innenfra og planten dør.";


$text = "Barack Hussein Obama II is an American politician who served as the 44th President of the United States from 2009 to 2017. The first African American to assume the presidency, he was previously the junior United States Senator from Illinois from 2005 to 2008. Before that, he served in the Illinois State Senate from 1997 until 2004.
Obama was born in 1961 in Honolulu, Hawaii, two years after the territory was admitted to the Union as the 50th state. Raised largely in Hawaii, Obama also spent one year of his childhood in Washington State and four years in Indonesia. After graduating from Columbia University in New York City in 1983, he worked as a community organizer in Chicago. In 1988 Obama enrolled in Harvard Law School, where he was the first black president of the Harvard Law Review. After graduation, he became a civil rights attorney and professor and taught constitutional law at the University of Chicago Law School from 1992 to 2004. Obama represented the 13th District for three terms in the Illinois Senate from 1997 to 2004, when he ran for the U.S. Senate. Obama received national attention in 2004 with his unexpected March primary win, his well-received July Democratic National Convention keynote address, and his landslide November election to the Senate. In 2008, Obama was nominated for president a year after his campaign began and after a close primary campaign against Hillary Clinton. He was elected over Republican John McCain and was inaugurated on January 20, 2009. Nine months later, Obama was named the 2009 Nobel Peace Prize laureate, accepting the award with the caveat that he felt there were others 'far more deserving of this honor than I.'
During his first two years in office, Obama signed many landmark bills into law. The main reforms were the Patient Protection and Affordable Care Act (often referred to as 'Obamacare', shortened as the 'Affordable Care Act'), the Dodd–Frank Wall Street Reform and Consumer Protection Act, and the Don't Ask, Don't Tell Repeal Act of 2010. The American Recovery and Reinvestment Act of 2009 and Tax Relief, Unemployment Insurance Reauthorization, and Job Creation Act of 2010 served as economic stimulus amidst the Great Recession. After a lengthy debate over the national debt limit, Obama signed the Budget Control and the American Taxpayer Relief Acts. In foreign policy, Obama increased U.S. troop levels in Afghanistan, reduced nuclear weapons with the United States–Russia New START treaty, and ended military involvement in the Iraq War. He ordered military involvement in Libya in opposition to Muammar Gaddafi; Gaddafi was killed by NATO-assisted forces, and he also ordered the military operation that resulted in the death of Osama bin Laden.
After winning re-election by defeating Republican opponent Mitt Romney, Obama was sworn in for a second term in 2013. During his second term, Obama promoted inclusiveness for LGBT Americans. His administration filed briefs that urged the Supreme Court to strike down same-sex marriage bans as unconstitutional (United States v. Windsor and Obergefell v. Hodges). Obama advocated for gun control in response to the Sandy Hook Elementary School shooting, and issued wide-ranging executive actions concerning climate change and immigration. In foreign policy, Obama ordered military intervention in Iraq in response to gains made by ISIL after the 2011 withdrawal from Iraq, continued the process of ending U.S. combat operations in Afghanistan, promoted discussions that led to the 2015 Paris Agreement on global climate change, initiated sanctions against Russia following the invasion in Ukraine and again after Russian interference in the 2016 United States elections, brokered a nuclear deal with Iran, and normalized U.S. relations with Cuba. Obama left office in January 2017 with a 60% approval rating and currently resides in Washington, D.C. Since leaving office, his presidency has been favorably ranked by historians and the American general public.[2][3]";


$text = "– Norsk matvarebransje er preget av for dyre varer, for lite utvalg, for lite konkurranse og for lite åpenhet, slo Isaksen fast på et debattmøte for matvarebransjen mandag, der representanter for dagligvarebransjen, organisasjoner og offentlige myndigheter var samlet for å diskutere konkurranseforholdene.
Gal retning.
– Regjeringen er bekymret for konkurransen, både blant dagligvarekjedene og blant leverandørene. Vi har fått dyrere mat og dårligere utvalg. Utviklingen har gått i gal retning, slår Røe Isaksen fast.
Nå er næringsministeren på jakt etter tiltak som kan bedre situasjonen og dempe markedsmakten til matvaregigantene. Men han er samtidig klar på at det ikke finnes noen «quick fix».
– Dette er en komplisert analyse, som ikke har ett enkelt svar. Det er for tidlig å si noe om hvilke tiltak vi vil gjennomføre. Men jeg sier veldig klart og tydelig at denne regjeringen er villig til å sette i verk tiltak for å gjøre konkurransesituasjonen bedre, sier statsråden, som nå vil be fagmiljøer om å utrede saken.
Når en utredning vil være klar, eller når regjeringen kan tenkes å komme med forslag til tiltak, er altfor tidlig å si, sier Røe Isaksen til NTB.
– Jeg ønsker å gjøre noe med denne saken. Men det må jo være noe som virker, sier han.
Prisregulering.
Ett tema som har vært på dagsordenen den siste tiden, er om store leverandører som Orkla og Tine skal tvinges til å gi alle butikkjeder samme pris på varene. I dag kan for eksempel giganten Norgesgruppen, som blant annet kontrollerer kjedene Meny og Kiwi, forhandle seg fram til langt bedre priser enn Rema 1000.
Slike innkjøpsbetingelser hindrer også nye aktører til å komme inn på markedet, viser en fersk rapport fra Oslo Economics.
Situasjonen blir heller ikke bedre av at Norgesgruppen også eier det største distribusjonsselskapet, Asko.";

$detected_lang = $nlp->language( $text );
$polyglot = $nlp->polyglot_entities( $text, $detected_lang );

print_r($polyglot);

echo "\nSentiment:\n";
print_r( $polyglot->getSentiment() );



echo "\n\nEntities:\n";
print_r( $polyglot->getEntities() );


echo "\n\nEntity Types:\n";
print_r( $polyglot->getEntityTypes() );