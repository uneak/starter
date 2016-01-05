<?php

	namespace AppBundle\Sluggable\Util;
	use Gedmo\Sluggable\Util\Urlizer;


	class Transliterator extends Urlizer
	{


		public static function transliterate($text, $separator = '-') {
			$text = strtr($text, self::$table);
			if (preg_match('/[\x80-\xff]/', $text) && self::validUtf8($text)) {
				$text = self::utf8ToAscii($text);
			}
			return self::urlize($text, $separator);
		}

	}

