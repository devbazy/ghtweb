<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Кол-во символов в логине
$config['login_min_length'] = 4;
$config['login_max_length'] = 16;

// Кол-во символов в пароле
$config['password_min_length'] = 4;
$config['password_max_length'] = 16;


// Список классов, ID рас и названий классов
$config['class_list'] = array(
    0 => array('name' => 'Human Fighter', 'race' => 0),
    1 => array('name' => 'Warrior', 'race' => 0),
    2 => array('name' => 'Gladiator', 'race' => 0),
    3 => array('name' => 'Warlord', 'race' => 0),
    4 => array('name' => 'Human Knight', 'race' => 0),
    5 => array('name' => 'Paladin', 'race' => 0),
    6 => array('name' => 'Dark Avenger', 'race' => 0),
    7 => array('name' => 'Rogue', 'race' => 0),
    8 => array('name' => 'Treasure Hunter', 'race' => 0),
    9 => array('name' => 'Hawkeye', 'race' => 0),
    10 => array('name' => 'Human Mage', 'race' => 0),
    11 => array('name' => 'Human Wizard', 'race' => 0),
    12 => array('name' => 'Sorcerer', 'race' => 0),
    13 => array('name' => 'Necromancer', 'race' => 0),
    14 => array('name' => 'Warlock', 'race' => 0),
    15 => array('name' => 'Cleric', 'race' => 0),
    16 => array('name' => 'Bishop', 'race' => 0),
    17 => array('name' => 'Human Prophet', 'race' => 0),
    18 => array('name' => 'Elf Fighter', 'race' => 1),
    19 => array('name' => 'Elf Knight', 'race' => 1),
    20 => array('name' => 'Temple Knight', 'race' => 1),
    21 => array('name' => 'Swordsinger', 'race' => 1),
    22 => array('name' => 'Scout', 'race' => 1),
    23 => array('name' => 'Plains Walker', 'race' => 1),
    24 => array('name' => 'Silver Ranger', 'race' => 1),
    25 => array('name' => 'Elf Mage', 'race' => 1),
    26 => array('name' => 'Elf Wizard', 'race' => 1),
    27 => array('name' => 'Spellsinger', 'race' => 1),
    28 => array('name' => 'Elemental Summoner', 'race' => 1),
    29 => array('name' => 'Oracle', 'race' => 1),
    30 => array('name' => 'Elder', 'race' => 1),
    31 => array('name' => 'DE Fighter', 'race' => 2),
    32 => array('name' => 'Palus Knight', 'race' => 2),
    33 => array('name' => 'Shillien Knight', 'race' => 2),
    34 => array('name' => 'Bladedancer', 'race' => 2),
    35 => array('name' => 'Assassin', 'race' => 2),
    36 => array('name' => 'Abyss Walker', 'race' => 2),
    37 => array('name' => 'Phantom Ranger', 'race' => 2),
    38 => array('name' => 'DE Mage', 'race' => 2),
    39 => array('name' => 'DE Wizard', 'race' => 2),
    40 => array('name' => 'Spell Howler', 'race' => 2),
    41 => array('name' => 'Phantom Summoner', 'race' => 2),
    42 => array('name' => 'Shillien Oracle', 'race' => 2),
    43 => array('name' => 'Shillien Elder', 'race' => 2),
    44 => array('name' => 'Orc Fighter', 'race' => 3),
    45 => array('name' => 'Raider', 'race' => 3),
    46 => array('name' => 'Destroyer', 'race' => 3),
    47 => array('name' => 'Monk', 'race' => 3),
    48 => array('name' => 'Tyrant', 'race' => 3),
    49 => array('name' => 'Orc Mage', 'race' => 3),
    50 => array('name' => 'Shaman', 'race' => 3),
    51 => array('name' => 'Overlord', 'race' => 3),
    52 => array('name' => 'Warcryer', 'race' => 3),
    53 => array('name' => 'Dwarf Fighter', 'race' => 4),
    54 => array('name' => 'Scavenger', 'race' => 4),
    55 => array('name' => 'Bounty Hunter', 'race' => 4),
    56 => array('name' => 'Artisan', 'race' => 4),
    57 => array('name' => 'Warsmith', 'race' => 4),
    88 => array('name' => 'Duelist', 'race' => 0),
    89 => array('name' => 'DreadNought', 'race' => 0),
    90 => array('name' => 'Phoenix Knight', 'race' => 0),
    91 => array('name' => 'Hell Knight', 'race' => 0),
    92 => array('name' => 'Sagittarius', 'race' => 0),
    93 => array('name' => 'Adventurer', 'race' => 0),
    94 => array('name' => 'Archmage', 'race' => 0),
    95 => array('name' => 'Soultaker', 'race' => 0),
    96 => array('name' => 'Arcana Lord', 'race' => 0),
    97 => array('name' => 'Cardinal', 'race' => 0),
    98 => array('name' => 'Hierophant', 'race' => 0),
    99 => array('name' => 'Eva Templar', 'race' => 1),
    100 => array('name' => 'Sword Muse', 'race' => 1),
    101 => array('name' => 'Wind Rider', 'race' => 1),
    102 => array('name' => 'Moonlight Sentinel', 'race' => 1),
    103 => array('name' => 'Mystic Muse', 'race' => 1),
    104 => array('name' => 'Elemental Master', 'race' => 1),
    105 => array('name' => 'Eva Saint', 'race' => 1),
    106 => array('name' => 'Shillien Templar', 'race' => 2),
    107 => array('name' => 'Spectral Dancer', 'race' => 2),
    108 => array('name' => 'Ghost Hunter', 'race' => 2),
    109 => array('name' => 'Ghost Sentinel', 'race' => 2),
    110 => array('name' => 'Storm Screamer', 'race' => 2),
    111 => array('name' => 'Spectral Master', 'race' => 2),
    112 => array('name' => 'Shillen Saint', 'race' => 2),
    113 => array('name' => 'Titan', 'race' => 3),
    114 => array('name' => 'Grand Khauatari', 'race' => 3),
    115 => array('name' => 'Dominator', 'race' => 3),
    116 => array('name' => 'Doomcryer', 'race' => 3),
    117 => array('name' => 'Fortune Seeker', 'race' => 4),
    118 => array('name' => 'Maestro', 'race' => 4),
    123 => array('name' => 'Male Soldier', 'race' => 5),
    124 => array('name' => 'Female Soldier', 'race' => 5),
    125 => array('name' => 'Trooper', 'race' => 5),
    126 => array('name' => 'Warder', 'race' => 5),
    127 => array('name' => 'Berserker', 'race' => 5),
    128 => array('name' => 'Male Soulbreaker', 'race' => 5),
    129 => array('name' => 'Female Soulbreaker', 'race' => 5),
    130 => array('name' => 'Arbalester', 'race' => 5),
    131 => array('name' => 'Doombringer', 'race' => 5),
    132 => array('name' => 'Male Soulhound', 'race' => 5),
    133 => array('name' => 'Female Soulhound', 'race' => 5),
    134 => array('name' => 'Trickster', 'race' => 5),
    135 => array('name' => 'Inspector', 'race' => 5),
    136 => array('name' => 'Judicator', 'race' => 5),
    139 => array('name' => 'Awaking', 'race' => 5),
    140 => array('name' => 'Awaking', 'race' => 5),
    141 => array('name' => 'Awaking', 'race' => 5),
    142 => array('name' => 'Awaking', 'race' => 5),
    143 => array('name' => 'Awaking', 'race' => 5),
    144 => array('name' => 'Awaking', 'race' => 5),
    145 => array('name' => 'Awaking', 'race' => 5),
    146 => array('name' => 'Awaking', 'race' => 5),
);














/*

// Список классов
$config['class_list'] = array(
    0 => 'Human Fighter',     21 => 'Swordsinger',          42 => 'Shillien Oracle',    93 => 'Adventurer',             114 => 'Grand Khauatari',         139 => 'Awaking',
    1 => 'Warrior',           22 => 'Scout',                43 => 'Shillien Elder',     94 => 'Archmage',               115 => 'Dominator',               140 => 'Awaking',
    2 => 'Gladiator',         23 => 'Plains Walker',        44 => 'Orc Fighter',        95 => 'Soultaker',              116 => 'Doomcryer',               141 => 'Awaking',
    3 => 'Warlord',           24 => 'Silver Ranger',        45 => 'Raider',             96 => 'Arcana Lord',            117 => 'Fortune Seeker',          142 => 'Awaking',
    4 => 'Human Knight',      25 => 'Elf Mage',             46 => 'Destroyer',          97 => 'Cardinal',               118 => 'Maestro',                 143 => 'Awaking',
    5 => 'Paladin',           26 => 'Elf Wizard',           47 => 'Monk',               98 => 'Hierophant',             123 => 'Male Soldier',            144 => 'Awaking',
    6 => 'Dark Avenger',      27 => 'Spellsinger',          48 => 'Tyrant',             99 => 'Eva Templar',            124 => 'Female Soldier',          145 => 'Awaking',
    7 => 'Rogue',             28 => 'Elemental Summoner',   49 => 'Orc Mage',           100 => 'Sword Muse',            125 => 'Trooper',                 146 => 'Awaking',
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
);*/

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