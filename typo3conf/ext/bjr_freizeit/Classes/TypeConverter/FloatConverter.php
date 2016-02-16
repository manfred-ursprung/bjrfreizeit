<?php
namespace MUM\BjrFreizeit\TypeConverter;
/**
 * Class FloatConverter
 * @package MUM\BjrFreizeit\TypeConverter
 *
 * Description : Converter shall parses a string with "," to convert it to a float
 */
class FloatConverter extends \TYPO3\CMS\Extbase\Property\TypeConverter\FloatConverter {
    /**
     * Actually convert from $source to $targetType, by doing a typecast.
     *
     * @param mixed $source
     * @param string $targetType
     * @param array $convertedChildProperties
     * @param \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration
     * @return float|\TYPO3\CMS\Extbase\Error\Error
     * @api
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration = NULL) {
        if ($source === NULL || strlen($source) === 0) {
            return NULL;
        }

        $posComma = strpos( $source, "," );
        $posPoint = strpos( $source, "." );

        if ($posComma === FALSE && $posPoint === FALSE) { // should be an integer
            //$source = $source;
        } else if ($posComma !== FALSE && $posPoint === FALSE) { // there is a comma. Let us define this is a german value with decimals
            $source = str_replace( ",", ".", $source ); // transform to english notation
        } else if ($posComma === FALSE && $posPoint !== FALSE) { // there is a point. Let us define this is an english value with decimals
            //$source = $source;
        } else {
            // at this point we have a comma and a point.
            // Let us try to find out if it is 0.000,00 or 0,000.00
            if ($posComma < $posPoint) { // 0,000.00
                // we need no comma
                $source = str_replace( ",", "", $source );
            } else { // 0.000,00
                // remove the . and replace , with .
                $source = str_replace( ".", "", $source );
                $source = str_replace( ",", ".", $source );
            }
        }
        $source = (float)$source;

        if (!is_numeric($source)) {
            return new \TYPO3\CMS\Extbase\Error\Error('"%s" cannot be converted to a float value.', 1332934124, array($source));
        }
        return (float) $source;
    }
}