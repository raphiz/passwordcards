<?php
namespace raphiz\passwordcards;

require_once 'vendor/autoload.php';
use \Rain\Tpl;

if (!RequestUtils::isPost()) {
    // Render template
    Tpl::configure(
        array(
            "tpl_dir" => __DIR__ . "/resources/",
        )
    );
    $tpl = new Tpl;
    $tpl->draw('index');
} else {
    // Parse request
    $pattern = RequestUtils::parsePattern();
    $keyboardLayout = RequestUtils::parseKeyboardLayout();
    $seed = RequestUtils::parseSeed();
    $text = RequestUtils::parseText();
    $primary = RequestUtils::parsePrimaryColor();
    $secondary = RequestUtils::parseSecondaryColor();
    $spaceBarSize = RequestUtils::parseSpacebarSize();

    // Setup configuration
    $cfg = new Configuration($seed, $pattern, $keyboardLayout, $spaceBarSize, $text, $primary, $secondary);
    $creator = new CardCreator($cfg);

    // Load SVG templates
    $front_template = $creator->getSvgTemplate('simple_back');
    $back_template = $creator->getSvgTemplate('simple_front');

    // Render SVG into tempfiles
    $front = $creator->renderIntoTempfile($front_template);
    $back = $creator->renderIntoTempfile($back_template);

    // Render the PDF
    $doc = PDFRenderer::render($front, $back);

    // Prepare response PDF file header
    RequestUtils::preparePdfHeader(strlen($doc));

    // Ignore user abort to cleanup afterwards
    ignore_user_abort(true);

    // Strem the PDF
    echo $doc;

    // Cleanup temporary SVG images
    unlink($back);
    unlink($front);
}
