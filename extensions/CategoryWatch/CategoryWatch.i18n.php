<?php
/**
 * Internationalisation file for extension CategoryWatch.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Nad
 */
$messages['en'] = array(
	'categorywatch-desc' => 'Extends watchlist functionality to include notification about membership changes of watched categories',
	'categorywatch-emailsubject' => 'Activity involving watched category \"$1\"',
	'categorywatch-catmovein' => "$1 has moved into $2 from $3",
	'categorywatch-catmoveout' => "$1 has moved out of $2 into $3",
	'categorywatch-catadd' => "$1 has been added to $2",
	'categorywatch-catsub' => "$1 has been removed from $2",
	'categorywatch-autocat' => "Automatically watched by $1",
	'categorywatch-emailprefs' => "E-mail me when a category on my watchlist is changed",
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'categorywatch-desc' => '{{desc}}',
	'categorywatch-catmovein' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is the target category name
* $3 is the source category name',
	'categorywatch-catmoveout' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is the source category name
* $3 is the target category name',
	'categorywatch-catadd' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is a category name',
	'categorywatch-catsub' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is a category name',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'categorywatch-desc' => 'Étend la fonctionnalité de la liste de suivi afin d’y inclure la notification des modifications de la liste des membres des catégories suivies.',
	'categorywatch-emailsubject' => 'Activité concernant la catégorie suivie « $1 »',
	'categorywatch-catmovein' => 'a inclu la page $1 dans la catégorie $2 en la retirant de $3',
	'categorywatch-catmoveout' => 'a retiré la page $1 de la catégorie $2 en l’incluant dans $3',
	'categorywatch-catadd' => 'a inclu la page $1 dans la catégorie $2',
	'categorywatch-catsub' => 'a retiré la page $1 de la catégorie $2',
	'categorywatch-autocat' => 'Suivie automatiquement par $1',
	'categorywatch-emailprefs' => "Veuillez m’envoyer un courriel lorsqu’une catégorie de ma liste à surveiller est modifiée.",
);



