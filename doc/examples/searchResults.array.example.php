<?php

// search for the terms "welc home foo"

$results[0]['page']['id']       = 1; // the ID of the page
$results[0]['page']['category'] = 0; // the ID of the category of the page
$results[0]['id']               = false;
$results[0]['title']            = '<b>Welc</b>ome';
$results[0]['category']         = false;
$results[0]['searchwords']      = '<b>home</b> <b>foo</b>bar';
$results[0]['description']      = '... an example page description of <b>foo</b>bar';
$results[0]['content']          = 'The Welcome page of your <b>Home</b>page.
                               I hope you find some ... and also was a <b>foo</b>bar and a <b>foo</b> women here';

$results[1]['page']['id']       = 5;
$results[1]['page']['category'] = 2;
$results[1]['id']               = false;
$results[1]['title']            = false;
$results[1]['category']         = '<b>foo</b> category';
$results[1]['searchwords']      = false;
$results[1]['description']      = '... other example page description of <b>home</b>bar';
$results[1]['content']          = false;
...

?>