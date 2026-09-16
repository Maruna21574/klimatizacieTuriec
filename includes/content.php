<?php
/**
 * CMS vrstva: editovateľné texty, nastavenia kalkulačky, galéria, značky a obce.
 *
 * Registrujeme tu VŠETKY editovateľné bloky s ich pôvodným (pôvodne natvrdo
 * napísaným) textom ako default. Admin rozhranie (/admin/content.php,
 * /admin/calculator.php) tieto registre používa na vykreslenie formulárov
 * a database/seed.php ich používa na prvotné naplnenie databázy.
 *
 * Ak DB nie je dostupná alebo hodnota v nej chýba, všetky funkcie tu
 * spoľahlivo spadnú späť na default text, takže web nikdy nezostane prázdny.
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

// ------------------------------------------------------------------
// Registre (definícia editovateľných polí)
// ------------------------------------------------------------------

/**
 * @return array<string, array{label:string, blocks:array<string, array{label:string, type:string, default:string}>}>
 */
function pageContentRegistry(): array
{
    static $registry = null;
    if ($registry !== null) {
        return $registry;
    }

    $registry = [
        'global' => [
            'label' => 'Spoločné (pätička, CTA pruh)',
            'blocks' => [
                'footer_desc' => ['label' => 'Popis firmy v pätičke', 'type' => 'textarea', 'default' => 'Profesionálna montáž, servis a čistenie klimatizácií v Martine, Vrútkach a celom regióne Turiec. Kvalitne, spoľahlivo a za férovú cenu.'],
                'cta_title' => ['label' => 'CTA pruh nad pätičkou – nadpis', 'type' => 'text', 'default' => 'Naplánujme si montáž ešte pred vlnou horúčav'],
                'cta_desc' => ['label' => 'CTA pruh nad pätičkou – text', 'type' => 'text', 'default' => 'Zavolajte alebo napíšte – do 24 hodín sa vám ozveme s nezáväznou cenovou ponukou.'],
                'cookie_title' => ['label' => 'Cookie lišta – nadpis', 'type' => 'text', 'default' => 'Používame cookies'],
                'cookie_text' => ['label' => 'Cookie lišta – text', 'type' => 'textarea', 'default' => 'Táto stránka používa cookies na zabezpečenie základnej funkčnosti a na zlepšenie vášho zážitku z prehliadania. Kliknutím na „Prijať všetky“ súhlasíte s ich používaním. Viac sa dozviete v Ochrane osobných údajov.'],
            ],
        ],
        'index' => [
            'label' => 'Domov',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Klimatizácie Turiec – Montáž a servis klimatizácií v Martine a Turci'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Montáž, servis a čistenie klimatizácií v Martine, Vrútkach a celom regióne Turiec. Bezplatná obhliadka, rýchle termíny, záruka na montáž.'],
                'hero_title' => ['label' => 'Hero – nadpis (HTML povolené, napr. <span>)', 'type' => 'html', 'default' => 'Príjemný chlad vo vašom&nbsp;dome, <span>presne podľa vašich predstáv</span>'],
                'hero_lead' => ['label' => 'Hero – text pod nadpisom', 'type' => 'textarea', 'default' => 'Montujeme, servisujeme a čistíme klimatizácie všetkých značiek. Od obhliadky po spustenie zvládneme montáž rodinného domu alebo bytu spravidla do pár dní.'],
                'hero_point_1' => ['label' => 'Hero – bod 1', 'type' => 'text', 'default' => 'Bezplatná obhliadka a návrh riešenia'],
                'hero_point_2' => ['label' => 'Hero – bod 2', 'type' => 'text', 'default' => 'Montáž do 1–2 týždňov'],
                'hero_point_3' => ['label' => 'Hero – bod 3', 'type' => 'text', 'default' => 'Záruka na montáž aj servis'],
                'services_kicker' => ['label' => 'Služby – nadpis kategórie', 'type' => 'text', 'default' => 'Čo pre vás urobíme'],
                'services_title' => ['label' => 'Služby – hlavný nadpis', 'type' => 'text', 'default' => 'Kompletné služby okolo klimatizácie'],
                'services_lead' => ['label' => 'Služby – text', 'type' => 'text', 'default' => 'Od prvého telefonátu až po pravidelný servis – všetko zastrešíme jeden dodávateľ.'],
                'service_1_title' => ['label' => 'Služba 1 – názov', 'type' => 'text', 'default' => 'Montáž klimatizácií'],
                'service_1_desc' => ['label' => 'Služba 1 – popis', 'type' => 'textarea', 'default' => 'Nástenné aj multisplit jednotky pre rodinné domy, byty a prevádzky – čisté vedenie potrubia, odborné zapojenie.'],
                'service_2_title' => ['label' => 'Služba 2 – názov', 'type' => 'text', 'default' => 'Servis a čistenie'],
                'service_2_desc' => ['label' => 'Služba 2 – popis', 'type' => 'textarea', 'default' => 'Pravidelná údržba, dezinfekcia a čistenie filtrov predĺžia životnosť jednotky a udržia zdravý vzduch.'],
                'service_3_title' => ['label' => 'Služba 3 – názov', 'type' => 'text', 'default' => 'Diagnostika a chladivo'],
                'service_3_desc' => ['label' => 'Služba 3 – popis', 'type' => 'textarea', 'default' => 'Meranie tlaku, dopĺňanie chladiva a odstránenie porúch pomocou digitálnych manometrov.'],
                'service_4_title' => ['label' => 'Služba 4 – názov', 'type' => 'text', 'default' => 'Poradenstvo a výber'],
                'service_4_desc' => ['label' => 'Služba 4 – popis', 'type' => 'textarea', 'default' => 'Poradíme s výkonom, umiestnením aj vhodnou značkou podľa veľkosti a orientácie priestoru.'],
                'why_kicker' => ['label' => 'Prečo my – nadpis kategórie', 'type' => 'text', 'default' => 'Prečo si vybrať nás'],
                'why_title' => ['label' => 'Prečo my – hlavný nadpis', 'type' => 'text', 'default' => 'Montáž, na ktorú sa môžete spoľahnúť'],
                'why_1_title' => ['label' => 'Prečo my 1 – názov', 'type' => 'text', 'default' => 'Rýchle termíny'],
                'why_1_desc' => ['label' => 'Prečo my 1 – popis', 'type' => 'textarea', 'default' => 'Väčšinu montáží zrealizujeme do 1–2 týždňov od obhliadky, v sezóne aj skôr.'],
                'why_2_title' => ['label' => 'Prečo my 2 – názov', 'type' => 'text', 'default' => 'Záruka a poistenie'],
                'why_2_desc' => ['label' => 'Prečo my 2 – popis', 'type' => 'textarea', 'default' => 'Na montáž aj prácu poskytujeme záruku, práce vykonávame s poistením zodpovednosti.'],
                'why_3_title' => ['label' => 'Prečo my 3 – názov', 'type' => 'text', 'default' => 'Odborná montáž'],
                'why_3_desc' => ['label' => 'Prečo my 3 – popis', 'type' => 'textarea', 'default' => 'Tlakové skúšky, vákuovanie a presné dávkovanie chladiva pri každej inštalácii.'],
                'why_4_title' => ['label' => 'Prečo my 4 – názov', 'type' => 'text', 'default' => 'Čistá práca'],
                'why_4_desc' => ['label' => 'Prečo my 4 – popis', 'type' => 'textarea', 'default' => 'Estetické vedenie potrubia v maskovacích lištách a upratané pracovisko po montáži.'],
                'process_kicker' => ['label' => 'Postup – nadpis kategórie', 'type' => 'text', 'default' => 'Ako to prebieha'],
                'process_title' => ['label' => 'Postup – hlavný nadpis', 'type' => 'text', 'default' => 'Od obhliadky po spustenie v 4 krokoch'],
                'process_1_title' => ['label' => 'Krok 1 – názov', 'type' => 'text', 'default' => 'Obhliadka a ponuka'],
                'process_1_desc' => ['label' => 'Krok 1 – popis', 'type' => 'textarea', 'default' => 'Prídeme k vám, prezrieme priestor a do 24 hodín pošleme nezáväznú cenovú ponuku.'],
                'process_2_title' => ['label' => 'Krok 2 – názov', 'type' => 'text', 'default' => 'Návrh riešenia'],
                'process_2_desc' => ['label' => 'Krok 2 – popis', 'type' => 'textarea', 'default' => 'Odporučíme výkon a umiestnenie jednotky presne podľa vášho priestoru a potrieb.'],
                'process_3_title' => ['label' => 'Krok 3 – názov', 'type' => 'text', 'default' => 'Montáž'],
                'process_3_desc' => ['label' => 'Krok 3 – popis', 'type' => 'textarea', 'default' => 'Odborná inštalácia, tlaková skúška a vákuovanie okruhu skúsenými technikmi.'],
                'process_4_title' => ['label' => 'Krok 4 – názov', 'type' => 'text', 'default' => 'Spustenie a servis'],
                'process_4_desc' => ['label' => 'Krok 4 – popis', 'type' => 'textarea', 'default' => 'Zaškolíme vás v ovládaní a v prípade záujmu zabezpečíme pravidelný servis.'],
                'brands_kicker' => ['label' => 'Značky – nadpis kategórie', 'type' => 'text', 'default' => 'Montujeme overené značky'],
                'brands_title' => ['label' => 'Značky – hlavný nadpis', 'type' => 'text', 'default' => 'Klimatizácie, ktorým môžete dôverovať'],
                'gallery_kicker' => ['label' => 'Galéria – nadpis kategórie', 'type' => 'text', 'default' => 'Naša práca'],
                'gallery_title' => ['label' => 'Galéria – hlavný nadpis', 'type' => 'text', 'default' => 'Vybrané realizácie'],
            ],
        ],
        'o-nas' => [
            'label' => 'O nás',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'O nás – Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Sme lokálny tím zameraný na montáž a servis klimatizácií v Turci. Poznáme miestne domy, byty aj firmy a robíme prácu, za ktorou si stojíme.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Robíme montáže, ktoré chceme mať aj vo vlastnom dome'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Klimatizácie Turiec je tím technikov zameraný výhradne na montáž, servis a čistenie klimatizácií v regióne Turiec. Pracujeme poctivo, bez zbytočného naťahovania termínov a s dôrazom na detail, ktorý sa oplatí až o pár rokov.'],
                'story_kicker' => ['label' => 'Príbeh – nadpis kategórie', 'type' => 'text', 'default' => 'Náš príbeh'],
                'story_title' => ['label' => 'Príbeh – hlavný nadpis', 'type' => 'text', 'default' => 'Od jednej montáže po stovky spokojných domácností'],
                'story_p1' => ['label' => 'Príbeh – odsek 1', 'type' => 'textarea', 'default' => 'Začínali sme ako malý tím, ktorý montoval klimatizácie susedom a známym v Martine a Vrútkach. Dnes vďaka odporúčaniam pôsobíme v celom regióne Turiec – od Sučian po Turčianske Teplice – a za sebou máme stovky zrealizovaných montáží v rodinných domoch, bytoch aj menších prevádzkach.'],
                'story_p2' => ['label' => 'Príbeh – odsek 2', 'type' => 'textarea', 'default' => 'Nešpecializujeme sa na desiatky odborov naraz. Robíme jednu vec – klimatizácie – a robíme ju poriadne, od prvej obhliadky až po pravidelný servis.'],
                'badge_1' => ['label' => 'Odznak 1', 'type' => 'text', 'default' => 'Poistenie zodpovednosti za škodu'],
                'badge_2' => ['label' => 'Odznak 2', 'type' => 'text', 'default' => 'Preškolení technici na aktuálne značky'],
                'badge_3' => ['label' => 'Odznak 3', 'type' => 'text', 'default' => 'Práca s tlakovými skúškami a vákuovaním'],
                'values_kicker' => ['label' => 'Hodnoty – nadpis kategórie', 'type' => 'text', 'default' => 'Naše hodnoty'],
                'values_title' => ['label' => 'Hodnoty – hlavný nadpis', 'type' => 'text', 'default' => 'Na čom nám záleží pri každej zákazke'],
                'value_1_title' => ['label' => 'Hodnota 1 – názov', 'type' => 'text', 'default' => 'Presnosť'],
                'value_1_desc' => ['label' => 'Hodnota 1 – popis', 'type' => 'textarea', 'default' => 'Každú montáž kontrolujeme tlakovou skúškou a meraním – žiadne odhady, len overené hodnoty.'],
                'value_2_title' => ['label' => 'Hodnota 2 – názov', 'type' => 'text', 'default' => 'Čistá práca'],
                'value_2_desc' => ['label' => 'Hodnota 2 – popis', 'type' => 'textarea', 'default' => 'Potrubie vedieme v maskovacích lištách a po sebe upraceme – dom vyzerá, ako keby sme tam ani neboli.'],
                'value_3_title' => ['label' => 'Hodnota 3 – názov', 'type' => 'text', 'default' => 'Dochvíľnosť'],
                'value_3_desc' => ['label' => 'Hodnota 3 – popis', 'type' => 'textarea', 'default' => 'Dohodnutý termín dodržíme. Ak sa čokoľvek zmení, dáme vám vedieť vopred.'],
                'value_4_title' => ['label' => 'Hodnota 4 – názov', 'type' => 'text', 'default' => 'Zodpovednosť'],
                'value_4_desc' => ['label' => 'Hodnota 4 – popis', 'type' => 'textarea', 'default' => 'Za odvedenú prácu poskytujeme záruku a v prípade potreby sme dostupní aj po montáži.'],
                'towns_kicker' => ['label' => 'Obce – nadpis kategórie', 'type' => 'text', 'default' => 'Kde pôsobíme'],
                'towns_title' => ['label' => 'Obce – hlavný nadpis', 'type' => 'text', 'default' => 'Celý región Turiec'],
                'towns_lead' => ['label' => 'Obce – text', 'type' => 'text', 'default' => 'Realizujeme montáže a servis vo všetkých okolitých obciach a mestách.'],
            ],
        ],
        'sluzby' => [
            'label' => 'Služby',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Služby – montáž, servis a čistenie klimatizácií | Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Montáž klimatizácií, servis, čistenie, diagnostika a doplnenie chladiva. Poradenstvo pri výbere vhodnej klimatizácie pre dom, byt aj prevádzku.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Všetko okolo klimatizácie na jednom mieste'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Od výberu vhodného typu jednotky, cez odbornú montáž, až po pravidelný servis a čistenie. Pracujeme so všetkými bežnými značkami klimatizácií.'],
                'montaz_title' => ['label' => 'Montáž – nadpis', 'type' => 'text', 'default' => 'Montáž klimatizácií'],
                'montaz_desc' => ['label' => 'Montáž – popis', 'type' => 'textarea', 'default' => 'Realizujeme montáž nástenných aj multisplit klimatizácií pre rodinné domy, byty, kancelárie a menšie prevádzky. Súčasťou montáže je návrh optimálneho umiestnenia vnútornej aj vonkajšej jednotky, vedenie potrubia v maskovacích lištách, elektrické zapojenie, tlaková skúška, vákuovanie okruhu a odborné spustenie.'],
                'montaz_li_1' => ['label' => 'Montáž – bod 1', 'type' => 'text', 'default' => 'Nástenné aj multisplit jednotky'],
                'montaz_li_2' => ['label' => 'Montáž – bod 2', 'type' => 'text', 'default' => 'Rodinné domy, byty aj prevádzky'],
                'montaz_li_3' => ['label' => 'Montáž – bod 3', 'type' => 'text', 'default' => 'Čisté vedenie potrubia v lištách'],
                'montaz_li_4' => ['label' => 'Montáž – bod 4', 'type' => 'text', 'default' => 'Tlaková skúška a vákuovanie okruhu'],
                'servis_title' => ['label' => 'Servis – nadpis', 'type' => 'text', 'default' => 'Servis a čistenie'],
                'servis_desc' => ['label' => 'Servis – popis', 'type' => 'textarea', 'default' => 'Pravidelný servis predlžuje životnosť klimatizácie a udržiava zdravý vzduch v priestore. Vyčistíme filtre a výmenník, skontrolujeme tesnosť okruhu, funkčnosť odvodu kondenzátu a v prípade potreby vykonáme dezinfekciu jednotky.'],
                'servis_li_1' => ['label' => 'Servis – bod 1', 'type' => 'text', 'default' => 'Čistenie filtrov a výmenníka'],
                'servis_li_2' => ['label' => 'Servis – bod 2', 'type' => 'text', 'default' => 'Dezinfekcia vnútornej jednotky'],
                'servis_li_3' => ['label' => 'Servis – bod 3', 'type' => 'text', 'default' => 'Kontrola odvodu kondenzátu'],
                'servis_li_4' => ['label' => 'Servis – bod 4', 'type' => 'text', 'default' => 'Odporúčaný servis raz ročne'],
                'diagnostika_title' => ['label' => 'Diagnostika – nadpis', 'type' => 'text', 'default' => 'Diagnostika a doplnenie chladiva'],
                'diagnostika_desc' => ['label' => 'Diagnostika – popis', 'type' => 'textarea', 'default' => 'Ak klimatizácia nechladí ako má, príčinou je často únik alebo nedostatok chladiva. Digitálnymi manometrami zmeriame tlak v okruhu, nájdeme prípadný únik a chladivo bezpečne doplníme na presnú hodnotu podľa výrobcu.'],
                'diagnostika_li_1' => ['label' => 'Diagnostika – bod 1', 'type' => 'text', 'default' => 'Meranie tlaku digitálnymi manometrami'],
                'diagnostika_li_2' => ['label' => 'Diagnostika – bod 2', 'type' => 'text', 'default' => 'Vyhľadanie a odstránenie úniku'],
                'diagnostika_li_3' => ['label' => 'Diagnostika – bod 3', 'type' => 'text', 'default' => 'Presné doplnenie chladiva'],
                'diagnostika_li_4' => ['label' => 'Diagnostika – bod 4', 'type' => 'text', 'default' => 'Odstránenie bežných porúch'],
                'poradenstvo_title' => ['label' => 'Poradenstvo – nadpis', 'type' => 'text', 'default' => 'Poradenstvo a výber jednotky'],
                'poradenstvo_desc' => ['label' => 'Poradenstvo – popis', 'type' => 'textarea', 'default' => 'Nie každý priestor potrebuje rovnaký výkon. Pri obhliadke posúdime veľkosť a orientáciu miestnosti, počet okien aj zdroje tepla a odporučíme vhodný výkon, typ aj umiestnenie jednotky – bez zbytočného predimenzovania.'],
                'poradenstvo_li_1' => ['label' => 'Poradenstvo – bod 1', 'type' => 'text', 'default' => 'Výpočet vhodného výkonu jednotky'],
                'poradenstvo_li_2' => ['label' => 'Poradenstvo – bod 2', 'type' => 'text', 'default' => 'Porovnanie dostupných značiek'],
                'poradenstvo_li_3' => ['label' => 'Poradenstvo – bod 3', 'type' => 'text', 'default' => 'Odporúčanie umiestnenia jednotiek'],
                'poradenstvo_li_4' => ['label' => 'Poradenstvo – bod 4', 'type' => 'text', 'default' => 'Nezáväzná cenová ponuka'],
                'brands_kicker' => ['label' => 'Značky – nadpis kategórie', 'type' => 'text', 'default' => 'Značky, s ktorými pracujeme'],
                'brands_title' => ['label' => 'Značky – hlavný nadpis', 'type' => 'text', 'default' => 'Kvalitné klimatizácie overených výrobcov'],
            ],
        ],
        'kalkulacka' => [
            'label' => 'Kalkulačka (texty)',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Kalkulačka výkonu klimatizácie – Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Zistite orientačný výkon klimatizácie podľa plochy a typu miestnosti. Rýchly odhad zadarmo, presný návrh pripravíme pri bezplatnej obhliadke.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Kalkulačka výkonu klimatizácie'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Zadajte parametre miestnosti a hneď uvidíte orientačný výkon jednotky aj odhadovanú cenu montáže. Presný návrh pripravíme zadarmo priamo na mieste.'],
                'check_1' => ['label' => 'Zoznam výhod – bod 1', 'type' => 'text', 'default' => 'Odhad podľa bežných pravidiel pre chladenie priestoru'],
                'check_2' => ['label' => 'Zoznam výhod – bod 2', 'type' => 'text', 'default' => 'Cena je orientačná, presnú vám potvrdíme po obhliadke'],
                'check_3' => ['label' => 'Zoznam výhod – bod 3', 'type' => 'text', 'default' => 'Poradíme aj s výberom značky a umiestnením jednotiek'],
                'disclaimer' => ['label' => 'Upozornenie pod výsledkom', 'type' => 'textarea', 'default' => 'Ceny sú orientačné podľa bežných cien montáže na Slovensku a slúžia len ako predbežný odhad. Konečná cena závisí od konkrétnej obhliadky, značky jednotky a stavebných úprav.'],
            ],
        ],
        'kontakt' => [
            'label' => 'Kontakt',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Kontakt – Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Napíšte nám alebo zavolajte – radi vám pripravíme nezáväznú cenovú ponuku na montáž klimatizácie v regióne Turiec.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Poďme naplánovať vašu klimatizáciu'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Napíšte nám pár slov o tom, čo potrebujete, alebo rovno zavolajte. Ozveme sa spravidla do 24 hodín s nezáväznou ponukou.'],
                'success_message' => ['label' => 'Hláška po úspešnom odoslaní formulára', 'type' => 'text', 'default' => 'Ďakujeme! Správa bola odoslaná, ozveme sa vám čo najskôr.'],
                'error_message' => ['label' => 'Hláška pri chybe odoslania formulára', 'type' => 'text', 'default' => 'Správu sa nepodarilo odoslať. Skúste to prosím znova alebo nám zavolajte.'],
                'form_note' => ['label' => 'Poznámka pod formulárom (GDPR)', 'type' => 'text', 'default' => 'Odoslaním súhlasíte so spracovaním údajov za účelom vybavenia vášho dopytu.'],
            ],
        ],
        'realizacie' => [
            'label' => 'Realizácie',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Realizácie – galéria montáží klimatizácií | Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Pozrite si vybrané realizácie montáží klimatizácií v rodinných domoch, bytoch aj pri exteriérových priestoroch v regióne Turiec.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Montáže, na ktoré sme hrdí'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Výber z realizovaných montáží v rodinných domoch, bytoch aj pri exteriérových priestoroch v Turci. Kliknutím na fotografiu si ju zobrazíte v plnej veľkosti.'],
            ],
        ],
        'gdpr' => [
            'label' => 'Ochrana osobných údajov',
            'blocks' => [
                'seo_title' => ['label' => 'SEO – titulok stránky', 'type' => 'text', 'default' => 'Ochrana osobných údajov a cookies – Klimatizácie Turiec'],
                'seo_description' => ['label' => 'SEO – meta popis', 'type' => 'textarea', 'default' => 'Informácie o spracúvaní osobných údajov a používaní cookies na webe Klimatizácie Turiec.'],
                'hero_title' => ['label' => 'Hero – nadpis', 'type' => 'text', 'default' => 'Ochrana osobných údajov a cookies'],
                'hero_lead' => ['label' => 'Hero – text', 'type' => 'textarea', 'default' => 'Vysvetlenie, aké osobné údaje spracúvame, prečo a ako používame cookies na tomto webe.'],
                'body_html' => ['label' => 'Hlavný text stránky (HTML povolené)', 'type' => 'html', 'default' => <<<HTML
<h2>Prevádzkovateľ</h2>
<p>Prevádzkovateľom webovej stránky a spracúvateľom osobných údajov je {{SITE_FULLNAME}}, so sídlom v regióne {{SITE_REGION}}. Kontakt: {{EMAIL}}, {{PHONE}}.</p>

<h2>Aké údaje spracúvame</h2>
<p>Pri vyplnení kontaktného formulára spracúvame údaje, ktoré nám sami poskytnete – meno a priezvisko, e-mail, telefónne číslo, mesto/obec a obsah vašej správy. Tieto údaje používame výhradne na to, aby sme vás mohli kontaktovať a pripraviť cenovú ponuku alebo vybaviť váš dopyt.</p>

<h2>Právny základ a doba uchovávania</h2>
<p>Údaje spracúvame na základe vášho súhlasu udeleného odoslaním formulára (čl. 6 ods. 1 písm. a) GDPR), prípadne na účely plnenia zmluvy (písm. b). Údaje uchovávame len po dobu nevyhnutnú na vybavenie dopytu a prípadnú realizáciu zákazky, najdlhšie po dobu 3 rokov od posledného kontaktu, pokiaľ osobitný predpis nevyžaduje inak (napr. účtovné doklady).</p>

<h2>Komu údaje sprístupňujeme</h2>
<p>Vaše údaje neposkytujeme tretím stranám na marketingové účely. Údaje môžu byť spracúvané technickými poskytovateľmi, ktorí prevádzkujú hosting a e-mailovú komunikáciu tejto stránky, výhradne za účelom jej funkčnosti.</p>

<h2>Vaše práva</h2>
<p>Máte právo na prístup k svojim osobným údajom, ich opravu, výmaz, obmedzenie spracúvania, prenosnosť a právo namietať proti spracúvaniu. Súhlas so spracovaním údajov môžete kedykoľvek odvolať napísaním na {{EMAIL}}. Máte tiež právo podať sťažnosť na Úrad na ochranu osobných údajov SR.</p>

<h2>Cookies</h2>
<p>Táto stránka používa cookies – malé textové súbory, ktoré sa ukladajú vo vašom prehliadači. Používame:</p>
<ul>
<li><strong>Nevyhnutné cookies</strong> – potrebné pre základnú funkčnosť webu (napr. bezpečné prihlásenie do administrácie). Tieto nie je možné vypnúť.</li>
<li><strong>Funkčné / analytické cookies</strong> – pomáhajú nám pochopiť, ako web používate, aby sme ho mohli zlepšovať. Používajú sa len s vaším súhlasom.</li>
</ul>
<p>Svoj súhlas s cookies môžete kedykoľvek zmeniť – stačí kliknúť na tlačidlo "Nastavenia cookies" v pätičke stránky.</p>

<h2>Zmeny tohto dokumentu</h2>
<p>Tieto zásady môžeme priebežne aktualizovať. Aktuálne znenie je vždy dostupné na tejto stránke.</p>
HTML
],
            ],
        ],
        'stranka-404' => [
            'label' => 'Stránka 404',
            'blocks' => [
                'title' => ['label' => 'Nadpis', 'type' => 'text', 'default' => 'Túto stránku sa nám nepodarilo nájsť'],
                'desc' => ['label' => 'Text', 'type' => 'text', 'default' => 'Možno bola presunutá alebo už neexistuje. Skúste sa vrátiť na domovskú stránku.'],
            ],
        ],
    ];

    return $registry;
}

/**
 * @return array<int, array{key:string, label:string, type:string, default:string, group:string}>
 */
function calcSettingsRegistry(): array
{
    static $registry = null;
    if ($registry !== null) {
        return $registry;
    }

    $registry = [];

    $registry[] = ['key' => 'room_base_value', 'label' => 'Základný koeficient miestnosti', 'type' => 'number', 'default' => '0.11', 'group' => 'Základný výpočet'];

    $ceilings = [
        'ceiling_low' => ['do 2,6 m', '1'],
        'ceiling_mid' => ['2,6 – 3 m', '1.12'],
        'ceiling_high' => ['nad 3 m', '1.25'],
    ];
    foreach ($ceilings as $key => [$label, $value]) {
        $registry[] = ['key' => $key . '_label', 'label' => "Výška stropu – {$label} (názov)", 'type' => 'text', 'default' => $label, 'group' => 'Výška stropu'];
        $registry[] = ['key' => $key . '_value', 'label' => "Výška stropu – {$label} (koeficient)", 'type' => 'number', 'default' => $value, 'group' => 'Výška stropu'];
    }

    $orientations = [
        'orient_none' => ['Bez okien / vnútorná miestnosť', '0.95'],
        'orient_north' => ['Sever (najmenej slnka)', '1'],
        'orient_east' => ['Východ', '1.05'],
        'orient_west' => ['Západ', '1.1'],
        'orient_south' => ['Juh (najviac slnka)', '1.15'],
    ];
    foreach ($orientations as $key => [$label, $value]) {
        $registry[] = ['key' => $key . '_label', 'label' => "Orientácia – {$label} (názov)", 'type' => 'text', 'default' => $label, 'group' => 'Orientácia okien'];
        $registry[] = ['key' => $key . '_value', 'label' => "Orientácia – {$label} (koeficient)", 'type' => 'number', 'default' => $value, 'group' => 'Orientácia okien'];
    }

    $registry[] = ['key' => 'person_load_kw', 'label' => 'Príplatok na osobu nad 2 osoby (kW)', 'type' => 'number', 'default' => '0.1', 'group' => 'Ostatné'];
    $registry[] = ['key' => 'route_included_m', 'label' => 'Dĺžka trasy v základnej cene (m)', 'type' => 'number', 'default' => '3', 'group' => 'Ostatné'];
    $registry[] = ['key' => 'route_rate_eur', 'label' => 'Cena za každý ďalší meter trasy (€)', 'type' => 'number', 'default' => '25', 'group' => 'Ostatné'];

    $prices = [
        '2' => ['650', '850'],
        '2_5' => ['700', '900'],
        '3_5' => ['800', '1050'],
        '5' => ['950', '1250'],
        '7' => ['1300', '1700'],
        '9' => ['1700', '2200'],
        '12' => ['2200', '2800'],
    ];
    foreach ($prices as $size => [$min, $max]) {
        $size = (string) $size;
        $kwLabel = str_replace('_', ',', $size);
        $registry[] = ['key' => "price_{$size}_min", 'label' => "Cena pre {$kwLabel} kW – od (€)", 'type' => 'number', 'default' => $min, 'group' => 'Ceny montáže podľa výkonu'];
        $registry[] = ['key' => "price_{$size}_max", 'label' => "Cena pre {$kwLabel} kW – do (€)", 'type' => 'number', 'default' => $max, 'group' => 'Ceny montáže podľa výkonu'];
    }

    return $registry;
}

// ------------------------------------------------------------------
// Čítanie hodnôt (s fallbackom, ak DB nie je dostupná)
// ------------------------------------------------------------------

/** Načíta a vyrovnávacie pamätá celú tabuľku page_content pre danú stránku. */
function pageContentRow(string $page): array
{
    static $cache = [];
    if (isset($cache[$page])) {
        return $cache[$page];
    }

    $values = [];
    $pdo = db();
    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare('SELECT block_key, content_value FROM page_content WHERE page_slug = ?');
            $stmt->execute([$page]);
            foreach ($stmt->fetchAll() as $row) {
                $values[$row['block_key']] = $row['content_value'];
            }
        } catch (PDOException $e) {
            error_log('[klimaturiec] Chyba pri čítaní page_content: ' . $e->getMessage());
        }
    }

    return $cache[$page] = $values;
}

/**
 * Vráti editovateľný text bloku danej stránky, pripravený na priamy výstup do HTML.
 * Pri type 'html' sa vracia hodnota bez escapovania (dôveryhodný obsah z adminu).
 */
function cms(string $page, string $key): string
{
    $registry = pageContentRegistry();
    $def = $registry[$page]['blocks'][$key] ?? null;
    $default = $def['default'] ?? '';
    $type = $def['type'] ?? 'text';

    $stored = pageContentRow($page);
    $value = $stored[$key] ?? $default;

    return $type === 'html' ? $value : e($value);
}

/** Surová (needitovaná) hodnota bloku – pre potreby admin formulárov. */
function cmsRaw(string $page, string $key): string
{
    $registry = pageContentRegistry();
    $default = $registry[$page]['blocks'][$key]['default'] ?? '';
    $stored = pageContentRow($page);
    return $stored[$key] ?? $default;
}

/** Všeobecné nastavenie webu (telefón, e-mail, sociálne siete...) s fallbackom na $default. */
function setting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        $pdo = db();
        if ($pdo !== null) {
            try {
                $stmt = $pdo->query('SELECT setting_key, setting_value FROM site_settings');
                foreach ($stmt->fetchAll() as $row) {
                    $cache[$row['setting_key']] = $row['setting_value'];
                }
            } catch (PDOException $e) {
                error_log('[klimaturiec] Chyba pri čítaní site_settings: ' . $e->getMessage());
            }
        }
    }

    $value = $cache[$key] ?? $default;
    return $value === '' ? $default : $value;
}

/** Hodnoty pre kalkulačku (pole key => value ako string), s fallbackom na defaulty registra. */
function calcSettings(): array
{
    static $result = null;
    if ($result !== null) {
        return $result;
    }

    $registry = calcSettingsRegistry();
    $result = [];
    foreach ($registry as $field) {
        $result[$field['key']] = $field['default'];
    }

    $pdo = db();
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query('SELECT setting_key, setting_value FROM calculator_settings');
            foreach ($stmt->fetchAll() as $row) {
                if (array_key_exists($row['setting_key'], $result)) {
                    $result[$row['setting_key']] = $row['setting_value'];
                }
            }
        } catch (PDOException $e) {
            error_log('[klimaturiec] Chyba pri čítaní calculator_settings: ' . $e->getMessage());
        }
    }

    return $result;
}

// ------------------------------------------------------------------
// Galéria, značky, obce (DB-backed zoznamy s fallbackom na pôvodný obsah)
// ------------------------------------------------------------------

/** Pôvodné (predvolené) položky galérie – použité ako fallback aj ako zdroj pre prvotný seed. */
function galleryItemsDefault(): array
{
    return [
        ['file' => 'realizacia-01.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Montáž klimatizácie Baxi na fasáde', 'desc' => 'Vonkajšia jednotka Baxi na fasáde rodinného domu, čisté vertikálne vedenie potrubia.'],
        ['file' => 'realizacia-02.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Klimatizácia Viessmann pod strechou terasy', 'desc' => 'Montáž vonkajšej jednotky Viessmann pod prístreškom, vrátane zapojenia rozvodov.'],
        ['file' => 'realizacia-03.jpg', 'category' => 'exterier', 'categoryLabel' => 'Exteriér', 'title' => 'Klimatizácia Midea pri bazéne', 'desc' => 'Kompaktné umiestnenie vonkajšej jednotky Midea nad terasou so záhradným bazénom.'],
        ['file' => 'realizacia-04.jpg', 'category' => 'servis', 'categoryLabel' => 'Servis', 'title' => 'Zapojenie a tlaková skúška', 'desc' => 'Odborné elektrické zapojenie a meranie tlaku chladiva digitálnymi manometrami.'],
        ['file' => 'realizacia-05.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Montáž klimatizácie na rebríku', 'desc' => 'Bezpečné uchytenie a zapojenie vonkajšej jednotky Viessmann vo výške.'],
        ['file' => 'realizacia-06.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Klimatizácia Midea na rodinnom dome', 'desc' => 'Nová montáž vonkajšej jednotky Midea pri záhrade a hospodárskej budove.'],
        ['file' => 'realizacia-07.jpg', 'category' => 'servis', 'categoryLabel' => 'Servis', 'title' => 'Servis a kontrola klimatizácie technikom', 'desc' => 'Kontrola zapojenia a nastavenie vonkajšej jednotky po montáži.'],
        ['file' => 'realizacia-08.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Čisté vedenie potrubia na poschodovom dome', 'desc' => 'Estetické vertikálne vedenie chladiva popri fasáde k jednotke Midea.'],
        ['file' => 'realizacia-09.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Montáž vo výške v tíme dvoch technikov', 'desc' => 'Spoločná montáž krytu potrubia popri odkvapovej rúre vo väčšej výške.'],
        ['file' => 'realizacia-10.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Montáž klimatizácie pod strechou', 'desc' => 'Zapojenie vonkajšej jednotky vo výške pri streche rodinného domu.'],
        ['file' => 'realizacia-11.jpg', 'category' => 'rodinne-domy', 'categoryLabel' => 'Rodinný dom', 'title' => 'Klimatizácia Midea na staršom rodinnom dome', 'desc' => 'Nová montáž vonkajšej jednotky Midea na fasáde rodinného domu.'],
    ];
}

function galleryItems(): array
{
    $pdo = db();
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query('SELECT id, filename AS file, category, category_label AS categoryLabel, title, description AS `desc` FROM gallery_images ORDER BY sort_order ASC, id ASC');
            $rows = $stmt->fetchAll();
            if ($rows) {
                return $rows;
            }
        } catch (PDOException $e) {
            error_log('[klimaturiec] Chyba pri čítaní gallery_images: ' . $e->getMessage());
        }
    }
    return galleryItemsDefault();
}

function brandListDefault(): array
{
    return [
        ['slug' => 'midea', 'name' => 'Midea'],
        ['slug' => 'viessmann', 'name' => 'Viessmann'],
        ['slug' => 'baxi', 'name' => 'Baxi'],
        ['slug' => 'daikin', 'name' => 'Daikin'],
        ['slug' => 'lg', 'name' => 'LG'],
        ['slug' => 'samsung', 'name' => 'Samsung'],
        ['slug' => 'gree', 'name' => 'Gree'],
        ['slug' => 'toshiba', 'name' => 'Toshiba'],
        ['slug' => 'sinclair', 'name' => 'Sinclair'],
    ];
}

function brandList(): array
{
    $pdo = db();
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query('SELECT id, name FROM brands ORDER BY sort_order ASC, id ASC');
            $rows = $stmt->fetchAll();
            if ($rows) {
                return $rows;
            }
        } catch (PDOException $e) {
            error_log('[klimaturiec] Chyba pri čítaní brands: ' . $e->getMessage());
        }
    }
    return brandListDefault();
}

function serviceTownsDefault(): array
{
    return ['Martin', 'Vrútky', 'Sučany', 'Turčianske Teplice', 'Kláštor pod Znievom', 'Mošovce', 'Blatnica', 'Necpaly', 'Diaková', 'Belá-Dulice'];
}

function serviceTowns(): array
{
    $pdo = db();
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query('SELECT name FROM service_towns ORDER BY sort_order ASC, id ASC');
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if ($rows) {
                return $rows;
            }
        } catch (PDOException $e) {
            error_log('[klimaturiec] Chyba pri čítaní service_towns: ' . $e->getMessage());
        }
    }
    return serviceTownsDefault();
}
