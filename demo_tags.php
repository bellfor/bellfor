<?php
# @Author: Oleg
# @Date:   Friday, September 29th 2017, 11:27:55 am
# @Email:  oleg@webiprog.com
# @Project: Set opencart order_status
# @Filename: status.php
# @Last modified by:   Oleg
# @Last modified time: Friday, September 29th 2017, 12:32:49 pm
# @License: free
# @Copyright: webiprog.com




error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1) ;
//error_reporting(E_ALL);
define('_PARSER_DIR', dirname(__FILE__));

define('DS', DIRECTORY_SEPARATOR);

include(_PARSER_DIR.DS.'admin'.DS.'config.php');
// Startup
include(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();
// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);
// Config
$config = new Config();
$registry->set('config', $config);

//$config->set('config_language_id', 1);
// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);


$languages = array();

$query = $db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE status = '1' AND language_id != 1");

foreach ($query->rows as $result) {
    $languages[$result['language_id']] = $result['language_id'];
}

$tooltips = array(
	array(
		"keyword" => "Test2",
		"description" => "Test212345fghsrhstzh",
	),
	array(
		"keyword" => "Vitamin A",
		"description" => "Vitamin A stärkt natürlich das Sehvermögen. Ein erhöhter Wert kann helfen, in der Dunkelheit besser zu sehen. Außerdem können sich Fell- und Hautzellen schneller regenerieren und der Stoffwechsel kann angeregt werden. Natürliche Quellen sind Fleisch, Fisch und Gemüse.",
	),
	array(
		"keyword" => "Weidelammfleisch",
		"description" => "Weidelammfleisch ist besonders zart und mild und wird von vielen Hunden sehr gern angenommen. Wir verwenden nur Fleisch in Lebensmittelqualität und verzichten komplett auf Fleischabfälle. Unsere Fleischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fleischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Wildkaninchenfleisch",
		"description" => "Wildkaninchenfleisch ist mager, zart und sehr bekömmlich. Wir verwenden nur Fleisch in Lebensmittelqualität und verzichten komplett auf Fleischabfälle. Unsere Fleischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fleischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Hühnerfleisch",
		"description" => "Hühnerfleisch ist im Allgemeinen als sehr gut bekömmlich bekannt. Wir verwenden nur Fleisch in Lebensmittelqualität und verzichten komplett auf Fleischabfälle. Unsere Fleischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fleischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Truthahnfleisch",
		"description" => "Truthahnfleisch ist fettarm und sehr eiweißreich. Wir verwenden nur Fleisch in Lebensmittelqualität und verzichten komplett auf Fleischabfälle. Unsere Fleischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fleischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Entenfleisch",
		"description" => "Ente gilt als eine fettreiche Fleischsorte. Wir verwenden nur Fleisch in Lebensmittelqualität und verzichten komplett auf Fleischabfälle. Unsere Fleischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fleischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Frischer Wildlachs",
		"description" => "Wildlachs ist reich an Omega-3-Fettsäuren und bekannt für sein hochwertiges, leichtverdauliches Eiweiß. Wir verzichten konsequent auf den Einsatz von Antibiotika. Wir verwenden nur Fisch in Lebensmittelqualität und verzichten komplett auf Fischabfälle. Unsere Fischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "frische Bachforelle",
		"description" => "Bachforelle besitzt ein besonders hochwertiges Eiweiß und enthält mehrfach und einfach gesättigte Fettsäuren. Wir verzichten konsequent auf den Einsatz von Antibiotika. Wir verwenden nur Fisch in Lebensmittelqualität und verzichten komplett auf Fischabfälle. Unsere Fischsorten ähneln der natürlichen Fleisch- und Proteinquelle des Wolfes. Diese Proteinquelle beinhaltet ein niedriges Allergiepotenzial, weil das Aminosäurenprofil optimal verträglich ist. Die hohe Fischqualität zahlt sich aus, denn Sie brauchen von unserem hochwertigen Bellfor Hundefutter weniger füttern.",
	),
	array(
		"keyword" => "Süßkartoffeln",
		"description" => "Die Süßkartoffel gilt als nährstoffreichstes Gemüse (laut CSPI) und ist prall gefüllt mit natürlichem Vitamin A (Betacarotin), Vitamin C, Vitamin E, Vitamin B2, Magnesium, Kupfer, Vitamin B6, Biotin, Kalium und Eisen. Besondere Proteine wirken außerdem als Antioxidantien. Sie ist in der Lage blutzuckerregulierend zu wirken und besitzt einen niedrigen glykämischen Index. Für Ihren Hund bedeutet das: gesunde Kohlenhydrate, viele Ballaststoffe und kein Fett.",
	),
	array(
		"keyword" => "erntefrische Erbsen",
		"description" => "Die Erbse besitzt den höchsten Eiweißgehalt aller bei uns kultivierten Gemüse sowie einen hohen Gehalt an B-Vitaminen und Spurenelementen. Ihre Ballaststoffe sind gut für die Verdauung und sie kann das Immunsystem mit Magnesium und Kalium stärken. Antioxidativ wirkendes Betacarotin bringt sie ebenfalls im Gepäck mit.",
	),
	array(
		"keyword" => "erntefrische Tomaten",
		"description" => "Tomaten liefern wichtige Antioxidantien, z. B. Lycopin, die das Immunsystem Stärken können. Sie enthalten Vitamin A, B1, B2, C, E und Niacin.",
	),
	array(
		"keyword" => "Kartoffeln",
		"description" => "Die Kartoffel zählt zu den Nachtschattengewächsen und enthält viel Vitamin C. Sie liefert Kohlenhydrate und zusätzlich Vitamine und wichtige Ballaststoffe. Der geringe Proteinanteil der Kartoffel ist von allen pflanzlichen Eiweißträgern das am besten verwertbare.",
	),
	array(
		"keyword" => "Rübenschnitzel",
		"description" => "Rübenschnitzel liefern milde Betafasern (Rohfasern), die der Hund zur sanften Darmregulation benötigt. Warum entzuckert? Weil Zucker den Blutzuckerspiegel steigen lassen würde.",
	),
	array(
		"keyword" => "Leinsamen",
		"description" => "Leinsamen sind reich an ungesättigten Fettsäuren, essentiellen Aminosäuren und Vitamin E. Wichtig ist der hohe Anteil an Omega-3-Fettsäure (Alpha-Linolensäure, ALA). Diese kann von Hunden nicht selbst gebildet werden. Leinsamen können für ein glänzendes Fell und gesunde Haut sorgen, Haarausfall und Juckreiz vorbeugen und sich positiv auf die Verdauung und Nährstoffaufnahme auswirken.",
	),
	array(
		"keyword" => "Vollei",
		"description" => "Vollei bedeutet, dass Eigelb und Eiweiß verwendet werden. Eier sind sehr protein- und fettreich. Sie sind hochverdaulich und weisen einen hohen Anteil an essentiellen Aminosäuren und Fettsäuren auf, die sich positiv auf den Glanz des Fells auswirken können.\r\nGeflügelfett Geflügelfett enthält wertvolle Omega-Fettsäuren und dient der Komplettierung eines ausgewogenen Fettsäuremusters. Es ist ein leichtverdaulicher Energielieferant mit einem hohen Anteil an Vitamin E.",
	),
	array(
		"keyword" => "Lachsöl",
		"description" => "Lachsöl enthält die Omega-3-Fettsäuren Eicosapentaensäure (EPA) und Docosahexaensäure (DHA). Es rundet mit Leinsamen das komplette Omega-3-Spektrum wunderbar ab. Kann für ein glänzendes Fell und gesunde Haut sorgen sowie Haarausfall und Juckreiz vorbeugen.",
	),
	array(
		"keyword" => "Cranberry",
		"description" => "Cranberries sind reich an Vitamin C und Flavonoiden, welche antibakteriell und positiv auf die Harnorgane wirken können. Flavonoide verstärken die Wirkung der natürlichen Vitamine wie Tomate, Karotte, Cranberry, Süßkartoffel, Erbsen.",
	),
	array(
		"keyword" => "Inulin",
		"description" => "Fructooligosaccharide (FOS) dienen als Prebiotika für die guten und nützlichen Darmbakterien als Nahrungsquelle. Gemeinsam fördern sie die Verdauung und die Aufnahme von Nährstoffen. Befinden sich zu viele &#8222;schlechte&#8220; Bakterien im Magen-Darm-Trakt, können FOS dabei helfen, die Balance zwischen den &#8222;guten&#8220; und den &#8222;schlechten&#8220; Bakterien wiederherzustellen.",
	),
	array(
		"keyword" => "Yucca-Schidigera-Extrakt",
		"description" => "Yucca Schidigera ist ein wertvoller Lieferant von Mineralien, Enzymen, Vitaminen und Spurenelementen, weshalb es als Nahrungsergänzung bzw. als zusätzlicher Inhaltstoff in gesunder Menschen- und Tiernahrung sehr zu empfehlen ist. Yucca Schidigera kann hiermit punkten:\r\nnatürlich gewonnen aus der Yucca-Palme, enthält wertvolle Mineralstoffe, Enzyme, Vitamine und Spurenelemente, kann eine entzündungshemmende und heilende Wirkung haben, kann Giftstoffe auf milde Weise aus dem Körper befördern, stärkt die Abwehrkräfte und das Immunsystem, aktiviert den Stoffwechsel",
	),
	array(
		"keyword" => "Glucosamine",
		"description" => "Glucosamin ist der Grundbaustein von Knorpeln, Sehnen und Bändern. Prophylaktisch gegeben, kann es dem Verschleiß der Gelenke und Knorpelflächen vorbeugen. Wir verwenden natürliches Glucosamin, das aus Schrimps- und Krabbenschalen gewonnen wird.\r\nChondroitinChondroitin wirkt regulierend auf eine Vielzahl zellulärer Vorgänge und ist die ideale Ergänzung zu Glucosamin. Gemeinsam verstärkt sich die positive Wirkung auf die Knorpelmasse.",
	),
	array(
		"keyword" => "Chondroitin",
		"description" => "Chondroitin wirkt regulierend auf eine Vielzahl zellulärer Vorgänge und ist die ideale Ergänzung zu Glucosamin. Gemeinsam verstärkt sich die positive Wirkung auf die Knorpelmasse.",
	),
	array(
		"keyword" => "Taurin",
		"description" => "Taurin unterstützt die Herzmuskulatur und die Sehkraft. Es kann ernährungsbedingter DCM (dilatative Kardiomyopathie) vorbeugen bei Hunden, die selbst zu wenig Taurin bilden.",
	),
	array(
		"keyword" => "MOS",
		"description" => "MOS (Mannan-Oligosaccharide), gewonnen aus der Zellwand der Hefe, können die vorhandenen Bakterien im Darm unterstützen und beeinflussen direkt die Gesundheit des Verdauungstrakts. Sie können helfen, Durchfälle und verdauungsbedingte infektiöse Krankheiten vorzubeugen.",
	),
	array(
		"keyword" => "Methionin",
		"description" => "Methionin ist eine essentielle Aminosäure, die vom Hund nicht selbst produziert werden kann. Es wird aus frischen Erbsen gewonnen und steigert den Nährwert des Futters.",
	),
	array(
		"keyword" => "Geflügelfett",
		"description" => "Geflügelfett dient als Geschmacksträger und verleiht unserem Bellfor Hundefutter einen sehr leckeren Geruch und Geschmack für Ihren Hund.\r\nWir verwenden das Fett vom Hühnchen.\r\nHunde können nicht auf Hühnerfett allergisch reagieren, sondern wenn nur auf das jeweilige Protein.",
	),
	array(
		"keyword" => "Lysin",
		"description" => "Lysin ist eine essentielle Aminosäure und spielt in vielen Bereichen (Immunsystem, Blutgefäße, Haut, Zähne, Knochen) eine wichtige Rolle. Da diese Aminosäure nicht selbst hergestellt werden kann, ist eine Zufuhr durch die Nahrung essentiell. Unser Lysin wird aus frischen Erbsen gewonnen.",
	),
	array(
		"keyword" => "L-Carnitin",
		"description" => "L-Carnitin wirkt unterstützend bei der Fettverbrennung, der Herzfunktion und dem Transport der Fettsäuren. Es wird aus den Aminosäuren Lysin und Methionin hergestellt.",
	),
	array(
		"keyword" => "Süßkartoffelmehl",
		"description" => "Die Süßkartoffel gilt als nährstoffreichstes Gemüse (laut CSPI) und ist prall gefüllt mit natürlichem Vitamin A (Betacarotin), Vitamin C, Vitamin E, Vitamin B2, Magnesium, Kupfer, Vitamin, B6, Biotin, Kalium und Eisen. Besondere Proteine wirken außerdem als Antioxidantien. Sie ist in der Lage blutzuckerregulierend zu wirken und besitzt einen niedrigen glykämischen Index. Für Ihren Hund bedeutet das: gesunde Kohlenhydrate, viele Ballaststoffe und kein Fett.",
	),
	array(
		"keyword" => "Kupfer",
		"description" => "Kupfer ist ein lebenswichtiges Spurenelement. Es hat eine blutbildende Wirkung und eine positive Auswirkung auf eine schöne Fellfarbe.",
	),
	array(
		"keyword" => "Chelat",
		"description" => "Chelat dient als Träger, um Spurenelemente zu fixieren und ihre Verfügbarkeit für den Organismus wesentlich zu verbessern.",
	),
	array(
		"keyword" => "Zink",
		"description" => "Zink ist ein lebensnotwendiges Spurenelement. Es ist wichtig für das Immunsystem sowie für Haut und Fell.",
	),
	array(
		"keyword" => "Eisen",
		"description" => "Eisen ist ein lebenswichtiges Spurenelement. Es ist für den Transport von Sauerstoff in die roten Blutkörperchen ausschlaggebend.",
	),
	array(
		"keyword" => "Mangan",
		"description" => "Mangan ist ein lebensnotwendiges Spurenelement. Es ist sehr wichtig für die Bildung der Knochen- und Gelenksknorpel.",
	),
	array(
		"keyword" => "Jod",
		"description" => "Jod ist ein lebensnotwendiges Spurenelement. Es ist wichtig für die Produktion einiger Schilddrüsenhormone die den Stoffwechsel fast aller Zellen regulieren. Bei Jodmangel kann es zur Schilddrüsenunterfunktion kommen. Natürliches Jod kommt hauptsächlich in Meeresprodukten vor.",
	),
	array(
		"keyword" => "Selen",
		"description" => "Selen ist ein lebensnotwendiges Spurenelement. Das Immunsystem benötigt Selen um zu funktionieren. Es trägt zum Schutz der Zellen vor oxidativen Schäden bei und unterstütz die normale Schilddrüsenfunktion.",
	),
	array(
		"keyword" => "Vitamin D3",
		"description" => "Vitamin D ist wichtig für den Kalziumspiegel im Blut, einen gesunden Knochenaufbau und starke Muskeln. Eine Unterversorgung kann die Entstehung von Krebs begünstigen. Natürliche Quellen sind Lachsöl und Vollei.",
	),
	array(
		"keyword" => "Vitamin C",
		"description" => "Vitamin C ist ein natürliches Konservierungsmittel und die Ascorbinsäure stärkt das Immunsystem. Natürliche Quellen sind Süßkartoffel, Cranberry, Tomaten und Karotten.",
	),
	array(
		"keyword" => "Vitamin E",
		"description" => "Vitamin E schützt besonders Fettstoffe vor dem Zugriff freier Radikale. Es stärkt das Immunsystems und kann vor Herz- und Gefäßkrankheiten sowie Augenerkrankungen schützen. Vitamin E wird auch als natürlicher Konservierungsstoff eingesetzt. Natürliche Quellen sind Süßkartoffel und Vollei.",
	),
	array(
		"keyword" => "Vitamin B1",
		"description" => "Vitamin B1 ist besonders wichtig für das Nervensystem. Eine Unterversorgung zeigt sich durch Trägheit, Schwierigkeiten beim Gehen oder Sehen. Eine natürliche Quelle ist Fleisch und Fisch.",
	),
	array(
		"keyword" => "Vitamin B2",
		"description" => "Vitamin B2 unterstützt den Zellstoffwechsel bei Ihrem Hund. Eine natürliche Quelle ist Fleisch und Fisch.",
	),
	array(
		"keyword" => "Vitamin B5",
		"description" => "Vitamin B5 unterstützt den Stoffwechsel bei Ihrem Hund. Natürliche Quellen sind Fleisch, Fisch und Vollei.",
	),
	array(
		"keyword" => "Vitamin B6",
		"description" => "Vitamin B6 unterstützt den Stoffwechsel bei Ihrem Hund. Eine natürliche Quelle ist Fleisch und Fisch.",
	),
	array(
		"keyword" => "Vitamin B12",
		"description" => "Vitamin B12 unterstützt Bildung von roten Blutzellen bei Ihrem Hund. Eine natürliche Quelle ist Fleisch und Fisch.",
	),
	array(
		"keyword" => "Folsäure",
		"description" => "Folsäure ist wichtig für die DNA-Synthese, die Zellteilung und den Proteinstoffwechsel. Eine natürliche Quelle sind Erbsen.",
	),
	array(
		"keyword" => "Biotin",
		"description" => "Biotin sorgt für den Haut- und Haarstoffwechsel, trägt zur Funktion des Nervensystems und des Fettstoffwechsels bei. Natürliche Quellen sind Fleisch und Vollei.",
	),
	array(
		"keyword" => "Cholin",
		"description" => "Cholin ist ein B-Vitamin und hat mehrere wichtige Funktionen im Körper. Nervensystem, Zellstrukturen und Stoffwechselprozesse können besser funktionieren. Natürliche Quellen sind Leber, Eigelb, Bierhefe und Weizenkeime.",
	),
	array(
		"keyword" => "Niacin",
		"description" => "Niacin ist ein B-Vitamin. Seine zentrale Rolle hat es beim Energiestoffwechsel von Proteinen, Fetten und Kohlenhydraten. Es unterstützt Muskeln, Nerven und Haut. Natürliche Quellen sind Geflügel, Wild, Fisch, Erbsen, Tomaten und Bierhefe.",
	),
	array(
		"keyword" => "Glucosamin",
		"description" => "Glucosamin ist der Grundbaustein von Knorpeln, Sehnen und Bändern. Prophylaktisch gegeben, kann es dem Verschleiß der Gelenke und Knorpelflächen vorbeugen. Wir verwenden natürliches Glucosamin, das aus Schrimps- und Krabbenschalen gewonnen wird.",
	),
	array(
		"keyword" => "Rohfett",
		"description" => "Wir verwenden nur natürliche und hochwertige Zutaten. Bei den Fleischsorten wird nur das hochwertige Muskelfleisch verwendet und keine Fleischabfälle. Vor allem durch das verwendete Muskelfleisch, das Hühnerfett und den Leinsamen erreichen wir unseren positiven Rohfettanteil bei unseren verschiedenen Sorten. Der Rohfettgehalt wird nicht nach unten korrigiert, weil wir absolut auf Getreide verzichten. Durch das L-Carnitin, welches als Emulgator dient, kann der Fettgehalt vom Hund optimal umgesetzt werden.\r\nJeder Hund benötigt Rohfett. Dieses dient dem Hund zur Energiegewinnung.",
	),
	array(
		"keyword" => "Rohprotein",
		"description" => "Ist eine quantitative Angabe über den Anteil am enthaltenen Protein. Diese Angabe gibt keine Information darüber, wie verwertbar das enthaltene Eiweiß ist. Die Verwertbarkeit von Eiweiß gibt an, wie viel körpereigenes Eiweiß aus dem angebotenen Mix an Aminosäuren (das sind die Baustoffe, aus denen Proteine/Eiweiß aufgebaut ist) gewonnen werden kann, da diese Zusammensetzung je nach Proteinquelle variiert, und der Körper eines Hundes eine bestimmte Zusammensetzung benötigt. Dabei bestimmt der Anteil der Aminosäure, die in geringster Menge in der Futterquelle vorhanden ist, die gesamte Verwertbarkeit. Durch Kombination bestimmter Proteinquellen (wie bei unserem Bellfor) kann die Verwertbarkeit deutlich erhöht werden. Proteine können tierischer oder pflanzlicher Herkunft sein. Unser tierisches Protein wird gewonnen aus Fleisch, Fisch oder aus Eiern und unser pflanzliches Protein aus Erbsen oder Leinsamen.",
	),
	array(
		"keyword" => "Rohfaser",
		"description" => "Rohfaserbestandteile sind die unverdaulichen Bestandteile des Futters und setzen sich hauptsächlich aus Cellulose zusammen. Im Grunde werden damit die nicht verdaulichen Pflanzenbestandteile erfasst. Diese können nicht vom Körper abgebaut werden, übernehmen aber in der Verdauung eine darmregulierende Wirkung. Zum einen binden diese Pflanzenfasern Feuchtigkeit und zum anderen beeinflussen sie die Darmflora, also die im Darm lebenden und für die Verdauung wichtigen und guten Bakterien. Ein gutes Futter hat daher einen ausgewogenen Anteil an Rohfasern.",
	),
	array(
		"keyword" => "Rohasche",
		"description" => "Die Rohasche gibt den Mineralstoffanteil am Futter an. Ein gutes Futter enthält ein ausgewogenes Verhältnis an benötigten Mineralstoffen wie Calcium und Phosphor. Verantwortlich für ein gesundes Organsystem.",
	),
	array(
		"keyword" => "Calcium",
		"description" => "Calcium ist ein wertvoller Mineralstoff und ist für viele physiologische Prozesse (wie zum Beispiel für den Wachstumsprozess) sehr wichtig. Calcium ist für die Knochenfestigkeit und die Übertragung von Informationen im Nervenleitersystem verantwortlich.",
	),
	array(
		"keyword" => "Phosphor",
		"description" => "Phosphor ist für ein gesundes Wachstum und eine gesunde Funktion des Organismus, gemeinsam mit einer ausgewogenen Calciumzufuhr, zuständig.",
	),
	array(
		"keyword" => "Bierhefe",
		"description" => "Bierhefe ist ein Naturprodukt, welches bedonders bei Haut- und Fellproblemen helfen kann. Auch kann es die Immunabwehr Ihres Hundes positiv beeinflussen, denn Bierhefekulturen sind in der Lage Bakterien im Darm zu stärken. Bierhefe enthält eine massive Ansammlung von Vitaminen, Aminosäuren, Mineralstoffen und Spurenelementen. Dazu gehört unter anderm das Antioxidans Selen, welches eine positive Auswirkung auf Fell und Haut haben kann.",
	),
	array(
		"keyword" => "Johannisbrot",
		"description" => "Johannisbrot ist eine Schotenfrucht und kann die Darmflora Ihres Hundes wieder ins Gleichgewicht bringen. Es enthält Balaststoffe, Mineralien und natürliche Vitamine.",
	),
	array(
		"keyword" => "Spirulina",
		"description" => "Spirulina ist eine Mikroalge und enthält verschiedene Mineralstoffe wie Phosphor, Eisen, Selen, Mangan und Zink. Vitamin A und B12 sind in Spirulina reichlich vorhanden.\r\nAuch der Gehalt an essentiellen Fettsäuren und essentiellen Aminosäuren ist sehr hoch, so dass das Immunsystem gestärkt werden kann.",
	),
	array(
		"keyword" => "Apfel",
		"description" => "Der Apfel zeichnet sich durch seinen hohen Vitamin-Gehalt aus. Er enthält Vitamin A, B1, B2, B6, E und C. Desweiteren beinhaltet ein Apfel viele andere wertvolle Mineralstoffe wie Phosphor, Kalzium, Magnesium oder Eisen.",
	),
	array(
		"keyword" => "Echinacea",
		"description" => "Echinacea oder besser bekannt als „Sonnenhüte“ sind eine Pflanzengattung aus der Familie der Korbblütler ist ein reines Naturprodukt und wird als Heilpflanze angesehen. Es dient zur Unterstützung des Immunsystems.",
	),
	array(
		"keyword" => "Lecithin",
		"description" => "Lecithin dient als Baustoff für Zellwände und Membrane und unterstützt als natürliches Nahrungselement den Fettstoffwechsel und die Verarbeitung. Ebenfalls dient Lecithin als Transportdienstleister der essentiellen Vitamine A, D und E.",
	),
	array(
		"keyword" => "Banane",
		"description" => "Die Banane enthält wichtige Nährstoffe, die Herz und Nerven stärken. Sie ist ein hervorragender Lieferant von natürlichem Kalium und Magnesium.",
	),
	array(
		"keyword" => "Pflaume",
		"description" => "Pflaumen enthalten mit Eisen, Magnesium, Kalium, Kupfer und Zink  wichtige Mineralstoffe.\r\nSie haben außerdem jede Menge Vitamine zu bieten, wie Vitamin A, Vitamin C und Vitamin E. Diese sind besonders wichtig für das Nervensystem. Bezüglich der einzelnen Vitamine können Pflaumen zwar keine Spitzenwerte aufweisen, sie bieten aber ein gesundes Gesamtpaket. Außerdem enthalten Pflaumen Zellulose und Pektin, die sich hervorragend auf das Verdauungssystem auswirken.",
	),
	array(
		"keyword" => "Brennnessel",
		"description" => "Die Brennnessel ist eine Heilpflanze, die viele Einsatzgebiete kennt. So gilt sie als harntreibend, kann entzündungshemmend wirken und fördert die Durchblutung.\r\nDie Brennnessel eignet sich hervorragend als Lebensmittel – nicht nur auf Grund ihrer Fülle an Vitalstoffen, sondern auch wegen ihres fantastischen Geschmackes.\r\nSie hat einen hohen Eisen- und Chlorophyllgehalt",
	),
	array(
		"keyword" => "Spirulina",
		"description" => "Spirulina ist ein wertvoller Proteinträger und enthält alle essentiellen Aminosäuren. Sie ist prall gefüllt mit Calcium, Eisen, Selen, Vitamin A und Vitamin B12. Darüber hinaus enthält sie weitere Vitalstoffe wie Enzyme und Gamma-Lynolsäure.",
	),
	array(
		"keyword" => "Thymian",
		"description" => "Als Arznei kommt das ganze Kraut zum Einsatz, also alle Pflanzenbestandteile außer der Wurzel. Das Kraut enthält 1 bis 2,5 Prozent ätherisches Öl. Hauptsächlich kommen darin die Substanzen Thymol und Carvacrol vor. Daneben finden sich Lamiaceengerbstoffe und Flavonoide. Thymian ist überdies für seine gesunde und heilende Wirkung bekannt. Es wirkt antibakteriell, antibiotisch und schleimlösenden.",
	),
	array(
		"keyword" => "Basilikum",
		"description" => "Basilikum wirkt antibakteriell und kann auch vor anderen Krankheitserregern schützen, sogar vor solchen, die bereits gegen Antibiotika resistent sind. Basilikum kann auch Schäden, die durch freie Radikale entstehen, vorbeugen.\r\nBasilikum enthält entzündungshemmende Enzyme wie es auch in der Medizin verwendet wird.",
	),
	array(
		"keyword" => "Echinacea",
		"description" => "Echinacea wird in der Homöopathie zur Stärkung des Immunsystems eingesetzt.",
	),
	array(
		"keyword" => "Sellerie",
		"description" => "Sellerie findet vielfache Verwendung als Heil- und Nutzpflanze. Die enthaltenen ätherischen Öle können den Stoffwechsel anregen und die Knollen sind reich an Ballaststoffen.",
	),
	array(
		"keyword" => "Mango",
		"description" => "Die Mango ist ein natürlicher Lieferant von Niacin, Biotin, Folsäure, Phantotensäure, Vitamin C und Vitamin D.",
	),
	array(
		"keyword" => "Mais",
		"description" => "Der Hauptbestandteil von Mais sind Kohlenhydrate und somit \r\nist Mais ein hervorragender Energielieferant.\r\nDa die Stärke im Mais, durch die spezielle Verarbeitung im\r\nProduktionsprozess aufgeschlossen wird, kann der Hund\r\ndie ihm zugeführte Energie verarbeiten und sehr gut verdauen.\r\nDas Allergiepotenzial bei Mais tendiert deutlich gegen Null.\r\nAllergien entstehen sehr oft durch sogenannte „langkörnige\r\nGetreide“ wie Weizen, Hafer, Gerste oder Roggen.",
	),
	array(
		"keyword" => "Reis",
		"description" => "In unserem Bellfor Pur Hundefutter verwenden wir nur braunen Vollkornreis.\r\nDieser Vollkornreis wird von den Magenenzymen langsamer gespalten als weißer Reis. \r\nDadurch wird die Stärke nicht so schnell in Zucker umgewandelt. \r\nDer Blutzuckerspiegel wird also deutlich weniger in die Höhe getrieben als bei weißem Reis. Vollkornreis enthält B-Vitamine, Mineralstoffe und Ballaststoffe.  \r\nReis ist glutenfrei und begünstigt somit keine Futtermittelallergien. Vollkornreis ist ein hervorragender, leichtverdaulicher Kohlenhydratträger.",
	),
	array(
		"keyword" => "Kartoffelmehl",
		"description" => "Die Kartoffel zählt zu den Nachtschattengewächsen und enthält viel Vitamin C. Sie liefert Kohlenhydrate und zusätzlich Vitamine und wichtige Ballaststoffe. Der geringe Proteinanteil der Kartoffel ist von allen pflanzlichen Eiweißträgern das am besten verwertbare.",
	),
	array(
		"keyword" => "Karotten",
		"description" => "Karotten sind reich an Vitaminen (Vitamin B1, B2, B6, C, E) und Eisen und werden von Hunden i.d.R. gerne angenommen.",
	),
	array(
		"keyword" => "Insekten",
		"description" => "Das gewonnene Insektenprotein aus den Larven der schwarzen Soldatenfliegen bietet eine hohe Verdaulichkeit für unsere Hunde.\r\nDiese Proteinquelle hat ein sehr niedriges Allergiepotenzial und eignet sich daher bestens für ein nachhaltiges Hundetrockenfutter.",
	),
	array(
		"keyword" => "tierisches Fett",
		"description" => "Wir nutzen eine Mischung aus dem Fett unserer Insekten und Hühnerfett. Hunde können nicht auf Hühnerfett allergisch reagieren, sondern wenn nur auf das jeweilige Protein. Daher ist unser Insekten Hundefutter bestens für Allergiker geeignet.",
	),
);

$rab = array();
foreach ($tooltips as $key => $value) {


   $name = $value['keyword'];

   $query = $db->query("SELECT tooltiplabel_id FROM " . DB_PREFIX . "tooltiplabel_description
		WHERE `name` = '" . (string)$name . "' ");

	$tooltiplabel_id = isset($query->row['tooltiplabel_id'])?(int)$query->row['tooltiplabel_id']:false;
	//echo "<pre>"; var_export($tooltiplabel_id); echo "</pre>";
	// exit;
	if($tooltiplabel_id) {
		continue ;
	}


	$db->query("INSERT INTO " . DB_PREFIX . "tooltiplabel SET status = '1'");
        $tooltiplabel_id = $db->getLastId();

    //ON DUPLICATE KEY UPDATE name = ' " . $db->escape($name) . "-".$l."'
    foreach ($languages as $l) {


        $tut =  (bool)$query->row;
        if ($tut===false) {

        $db->query("
		INSERT INTO " . DB_PREFIX . "tooltiplabel_description SET
				tooltiplabel_id = '" . (int)$tooltiplabel_id . "',
				language_id = '" . (int)$l . "',
				name = '" . $db->escape($name) . "',
				description_top = '" . $db->escape($value['description']) . "',
				name_short = '',
				description_bottom = '',
				h1 = '',
				meta_title = '',
				meta_description = '',
				meta_keyword = ''
                ON DUPLICATE KEY UPDATE name = ' " . $db->escape($name) . "'
				");

		$rab[] = "NEW TooltipLabel ADDED : name = " . $db->escape($name) . "<br />";
        }else {

        }
    }
}
echo 'Update : '.count($rab).PHP_EOL;
echo "<br />-------------------------------------<br />";
echo(implode(PHP_EOL, $rab));
//exit;


