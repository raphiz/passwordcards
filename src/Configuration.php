<?php

namespace raphiz\passwordcards;

class Configuration
{

    const DEFAULT_PATTERN = 'a-zA-Z0-9~*-*';

    const LOWER = "abcdefghijklmnopqrstuvwxyz";

    const UPPER = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    const NUMBERS = "0123456789";

    const SYMBOLS = '!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';

    public $seed = null;

    public $pattern = null;

    public $primaryColor = null;

    public $secondaryColor = null;

    public $text = null;

    public $keys = null;

    public function __construct($seed, $pattern, $keys, $spaceBarSize, $text, $primaryColor, $secondaryColor)
    {
        $this->seed = self::evalSeed($seed);
        $this->pattern = self::evalPattern($pattern);
        $this->keys = self::evalKeys($keys);
        $this->primaryColor = $primaryColor;
        $this->text = $text;
        $this->spaceBarSize = $spaceBarSize;
        $this->secondaryColor = $secondaryColor;
    }

    public function getPatternCharacters()
    {
        return str_split(self::completePattern($this->pattern));
    }

    public static function completePattern($pattern)
    {
        $pattern = str_replace('a-z', self::LOWER, $pattern);
        $pattern = str_replace('A-Z', self::UPPER, $pattern);
        $pattern = str_replace('0-9', self::NUMBERS, $pattern);
        $pattern = str_replace('*-*', self::SYMBOLS, $pattern);
        return $pattern;
    }

    /**
     * If no (numeric) seed is provided, generate one.
     */
    public static function evalSeed($seed)
    {
        if ($seed == null || !is_numeric($seed)) {
            list($usec, $sec) = explode(' ', microtime());
            $seed = (float) $sec + ((float) $usec * 100000);
        }
        return $seed;
    }

    /**
    * If no pattern is provided, return the default.
    */
    public static function evalPattern($pattern)
    {
        if ($pattern == null) {
            $pattern = self::DEFAULT_PATTERN;
        }
        return $pattern;
    }

    /**
    * If no keys are provided, use qwerty.
    */
    public static function evalKeys($keys)
    {
        // Return qwertz
        if (strtolower($keys) === 'qwertz') {
            return 'QWERTZUIOPASDFGHJKLYXCVBNM';
        }
        // Return qwerty
        return 'QWERTYUIOPASDFGHJKLZXCVBNM';
    }
}
