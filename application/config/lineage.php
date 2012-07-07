<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Кол-во символов в логине
$config['login_min_length'] = 4;
$config['login_max_length'] = 16;

// Кол-во символов в пароле
$config['password_min_length'] = 4;
$config['password_max_length'] = 16;

// Список классов
$config['class_list'] = array(
    0 => 'Human Fighter',     21 => 'Swordsinger',          42 => 'Shillien Oracle',    93 => 'Adventurer',             114 => 'Grand Khauatari',
    1 => 'Warrior',           22 => 'Scout',                43 => 'Shillien Elder',     94 => 'Archmage',               115 => 'Dominator',
    2 => 'Gladiator',         23 => 'Plains Walker',        44 => 'Orc Fighter',        95 => 'Soultaker',              116 => 'Doomcryer',
    3 => 'Warlord',           24 => 'Silver Ranger',        45 => 'Raider',             96 => 'Arcana Lord',            117 => 'Fortune Seeker',
    4 => 'Human Knight',      25 => 'Elf Mage',             46 => 'Destroyer',          97 => 'Cardinal',               118 => 'Maestro',
    5 => 'Paladin',           26 => 'Elf Wizard',           47 => 'Monk',               98 => 'Hierophant',             123 => 'Male Soldier',
    6 => 'Dark Avenger',      27 => 'Spellsinger',          48 => 'Tyrant',             99 => 'Eva Templar',            124 => 'Female Soldier',
    7 => 'Rogue',             28 => 'Elemental Summoner',   49 => 'Orc Mage',           100 => 'Sword Muse',            125 => 'Trooper',
    8 => 'Treasure Hunter',   29 => 'Oracle',               50 => 'Shaman',             101 => 'Wind Rider',            126 => 'Warder',
    9 => 'Hawkeye',           30 => 'Elder',                51 => 'Overlord',           102 => 'Moonlight Sentinel',    127 => 'Berserker',
    10 => 'Human Mage',       31 => 'DE Fighter',           52 => 'Warcryer',           103 => 'Mystic Muse',           128 => 'Male Soulbreaker',
    11 => 'Human Wizard',     32 => 'Palus Knight',         53 => 'Dwarf Fighter',      104 => 'Elemental Master',      129 => 'Female Soulbreaker',
    12 => 'Sorcerer',         33 => 'Shillien Knight',      54 => 'Scavenger',          105 => 'Eva Saint',             130 => 'Arbalester',
    13 => 'Necromancer',      34 => 'Bladedancer',          55 => 'Bounty Hunter',      106 => 'Shillien Templar',      131 => 'Doombringer',
    14 => 'Warlock',          35 => 'Assassin',             56 => 'Artisan',            107 => 'Spectral Dancer',       132 => 'Male Soulhound',
    15 => 'Cleric',           36 => 'Abyss Walker',         57 => 'Warsmith',           108 => 'Ghost Hunter',          133 => 'Female Soulhound',
    16 => 'Bishop',           37 => 'Phantom Ranger',       88 => 'Duelist',            109 => 'Ghost Sentinel',        134 => 'Trickster',
    17 => 'Human Prophet',    38 => 'DE Mage',              89 => 'DreadNought',        110 => 'Storm Screamer',        135 => 'Inspector',
    18 => 'Elf Fighter',      39 => 'DE Wizard',            90 => 'Phoenix Knight',     111 => 'Spectral Master',       136 => 'Judicator',
    19 => 'Elf Knight',       40 => 'Spell Howler',         91 => 'Hell Knight',        112 => 'Shillen Saint',
    20 => 'Temple Knight',    41 => 'Phantom Summoner',     92 => 'Sagittarius',        113 => 'Titan',
);

// Список рас
$config['race_list'] = array(
    array(
        'name' => lang('Люди'),
    ),
    array(
        'name' => lang('Эльфы'),
    ),
    array(
        'name' => lang('Тёмные Эльфы'),
    ),
    array(
        'name' => lang('Орки'),
    ),
    array(
        'name' => lang('Гномы'),
    ),
    array(
        'name' => lang('Камаели'),
    ),
);

// Список замков
$config['castles'] = array(
    1 => 'Gludio',
    2 => 'Dion',
    3 => 'Giran',
    4 => 'Oren',
    5 => 'Aden',
    6 => 'Innadril',
    7 => 'Goddard',
    8 => 'Rune',
    9 => 'Schuttgart',
);

// Список фортов
$config['forts'] = array(
    101 => 'Shanty',
    102 => 'Southern',
    103 => 'Hive',
    104 => 'Valley',
    105 => 'Ivory',
    106 => 'Narsell',
    107 => 'Bayou',
    108 => 'WhiteSands',
    109 => 'Borderland',
    110 => 'Swamp',
    111 => 'Archaic',
    112 => 'Floran',
    113 => 'CloudMountain',
    114 => 'Tanor',
    115 => 'Dragonspine',
    116 => 'Antharas',
    117 => 'Western',
    118 => 'Hunters',
    119 => 'Aaru',
    120 => 'Demon',
    121 => 'Monastic',
);

// Cписок координат городов
$config['list_city'] = array(
    array(
        'name' => 'Dark Elven Village',
        'coordinates' => array(
            array('x' => '9745', 'y' => '15606', 'z' => '-4574'),
        ),
    ),
    array(
        'name' => 'Town of Aden',
        'coordinates' => array(
            array('x' => '147450', 'y' => '26741', 'z' => '-2204'),
        ),
    ),
    array(
        'name' => 'Dwarven Village',
        'coordinates' => array(
            array('x' => '115113', 'y' => '-178212', 'z' => '-901'),
        ),
    ),
    array(
        'name' => 'Town of Dion',
        'coordinates' => array(
            array('x' => '15670', 'y' => '142983', 'z' => '-2705'),
        ),
    ),
    array(
        'name' => 'Elven Village',
        'coordinates' => array(
            array('x' => '46934', 'y' => '51467', 'z' => '-2977'),
        ),
    ),
    array(
        'name' => 'Floran Village',
        'coordinates' => array(
            array('x' => '17838', 'y' => '170274', 'z' => '-3508'),
        ),
    ),
    array(
        'name' => 'Orc Village',
        'coordinates' => array(
            array('x' => '-44836', 'y' => '-112352', 'z' => '-239'),
        ),
    ),
    array(
        'name' => 'Town of Giran',
        'coordinates' => array(
            array('x' => '83400', 'y' => '147943', 'z' => '-3404'),
        ),
    ),
    array(
        'name' => 'Talking Island Village',
        'coordinates' => array(
            array('x' => '-84318', 'y' => '244579', 'z' => '-3730'),
        ),
    ),
    array(
        'name' => 'Gludin Village',
        'coordinates' => array(
            array('x' => '-80826', 'y' => '149775', 'z' => '-3043'),
        ),
    ),
    array(
        'name' => 'Town of Gludio',
        'coordinates' => array(
            array('x' => '-12672', 'y' => '122776', 'z' => '-3116'),
        ),
    ),
    array(
        'name' => 'Heine',
        'coordinates' => array(
            array('x' => '111322', 'y' => '219320', 'z' => '-3538'),
        ),
    ),
    array(
        'name' => 'Hunters Village',
        'coordinates' => array(
            array('x' => '117110', 'y' => '76883', 'z' => '-2695'),
        ),
    ),
    array(
        'name' => 'Ivory Tower',
        'coordinates' => array(
            array('x' => '85337', 'y' => '12728', 'z' => '-3787'),
        ),
    ),
    array(
        'name' => 'Town of Oren',
        'coordinates' => array(
            array('x' => '82956', 'y' => '53162', 'z' => '-1495'),
        ),
    ),
    array(
        'name' => 'Rune Township',
        'coordinates' => array(
            array('x' => '43799', 'y' => '-47727', 'z' => '-798'),
        ),
    ),
    array(
        'name' => 'Town of Goddard',
        'coordinates' => array(
            array('x' => '147928', 'y' => '-55273', 'z' => '-2734'),
        ),
    ),
    array(
        'name' => 'Town of Schuttgart',
        'coordinates' => array(
            array('x' => '87386', 'y' => '-143246', 'z' => '-1293'),
        ),
    ),
);

$config['password_type'] = array('sha1', 'wirlpool');

// Типы серверов
$config['types_of_servers'] = array('emurt', 'acis', 'rt', 'lucer', 'altdev', 'l2jserver', 'rebellion_it');