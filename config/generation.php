<?php

$svgNormalization = static function (string $tempFilepath, array $iconSet) {
    $doc = new DOMDocument();
    $doc->formatOutput = false;
    $doc->load($tempFilepath);
    /**
     * @var DOMElement $svgElement
     */
    $svgElement = $doc->getElementsByTagName('svg')[0];

    // Get initial viewBox value, when empty add safe default.
    $vBoxValue = $svgElement->getAttribute('viewBox') ?: '0 0 16 16';

    // Remove all the attributes to control order of them on output
    $svgElement->removeAttribute('width');
    $svgElement->removeAttribute('height');
    $svgElement->removeAttribute('viewBox');
    $svgElement->removeAttribute('fill');
    // For some reason PHP's DOMElement likes to put xmlns first even if you don't touch it.
    $svgElement->removeAttributeNS('http://www.w3.org/2000/svg', null);
    // Add them back in the correct order to match current results...
    $svgElement->setAttribute('viewBox', $vBoxValue);
    $svgElement->setAttributeNS(null, 'xmlns', 'http://www.w3.org/2000/svg');
    $svgElement->setAttribute('fill', 'currentColor');
    $doc->save($tempFilepath);

    $svgLine = trim(file($tempFilepath)[1]);
    file_put_contents($tempFilepath, $svgLine);
};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/src/icons',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => true,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,
    ],
];