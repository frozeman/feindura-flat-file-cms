<?php

// search for the terms "welc home foo"

$results[0]['page']['id']       = 1; // the ID of the page
$results[0]['page']['category'] = 0; // the ID of the category of the page
$results[0]['id']               = false;
$results[0]['title']            = '<mark>Welc</mark>ome';
$results[0]['category']         = false;
$results[0]['searchwords']      = '<mark>home</mark> <mark>foo</mark>bar';
$results[0]['description']      = '... an example page description of <mark>foo</mark>bar';
$results[0]['content']          = 'The Welcome page of your <mark>Home</mark>page.
                                   I hope you find some ... and also was a <mark>foo</mark>bar and a <mark>foo</mark> women here';

$results[1]['page']['id']       = 5;
$results[1]['page']['category'] = 2;
$results[1]['id']               = false;
$results[1]['title']            = false;
$results[1]['category']         = '<mark>foo</mark> category';
$results[1]['searchwords']      = false;
$results[1]['description']      = '... other example page description of <mark>home</mark>bar';
$results[1]['content']          = false;
...

?>