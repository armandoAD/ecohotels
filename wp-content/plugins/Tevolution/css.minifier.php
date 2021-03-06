<?php
include_once('../../../wp-load.php' );
error_reporting(E_ALL);
header("Content-type: text/css");
$tev_css= array();
global $tev_css;
// Array of css files
$css = array(
    plugin_dir_path( __FILE__ ).'style.css',
);

/* this hook is to pass the global vars */
do_action('tevolution_css');

$css = array_merge($css,$tev_css);
// Prevent a notice
$css_content = '';

echo '<pre>';
print_r($css);
echo '</pre>';

// Loop the css Array
foreach ($css as $css_file) {
    // Load the content of the css file 
    $response = file_get_contents($css_file);
    $css_content .= $response;
}

$css_content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css_content );

/* remove tabs, spaces, newlines, etc. */
$css_content = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_content );

echo $css_content;
?>