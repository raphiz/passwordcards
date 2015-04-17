<?php

namespace raphiz\passwordcards;

class CardCreator
{
    private $configration = null;

    public function __construct($configration)
    {
        if ($configration === null) {
            throw new \Exception('The given $configuration is null!');
        }

        if ($configration instanceof Configuration === false) {
            throw new \Exception(
                'The given $configuration is not a valid ' .
                'Configuration object.'
            );
        }

        $this->configration = $configration;
    }

    public function getSvgFilePath($template_name)
    {
        return __DIR__ . "/../templates/$template_name.svg";
    }

    public function getSvgTemplate($template_name)
    {
        return file_get_contents($this->getSvgFilePath($template_name));
    }

    public function render($svg)
    {
        // Get and count available characters
        $chars = $this->configration->getPatternCharacters();
        $char_count = count($chars);

        // set seed
        $seed = $this->configration->seed;
        mt_srand($seed);

        $number_of_keys = strlen($this->configration->keys);
        for ($i = 0; $i < $number_of_keys; $i++) {
            $equivalent = $chars[mt_rand(0, $char_count-1)];

            $equivalent = $this->escape($equivalent);

            // Replace the equivalent on the "keyboard"
            $svg = str_replace('$' . ($i+1) . '$', $equivalent, $svg);

            $svg = str_replace('$k' . ($i+1) . '$', $this->configration->keys[$i], $svg);

        }

        $space_lenght = $this->configration->spaceBarSize;
        $space = '';
        for ($i = 0; $i < $space_lenght; $i++) {
            $space .= $this->escape($chars[mt_rand(0, $char_count-1)]);
        }

        $svg = str_replace('$SPACE$', $space, $svg);

        $svg = str_replace('$SEED$', $seed, $svg);

        $svg = str_replace('$PRIMARY$', $this->configration->primaryColor, $svg);

        $svg = str_replace('$SECONDARY$', $this->configration->secondaryColor, $svg);

        $svg = str_replace('$TEXT$', $this->escape($this->configration->text), $svg);

        $svg = str_replace('$PATTERN$', $this->escape($this->configration->pattern), $svg);

        return $svg;
    }
    private function escape($str)
    {
        return htmlentities(utf8_encode($str), ENT_XML1);
    }


    public function renderIntoTempfile($svg)
    {
        $uri = tempnam("/tmp", "php");
        file_put_contents($uri, $this->render($svg));
        return $uri;
    }
}
