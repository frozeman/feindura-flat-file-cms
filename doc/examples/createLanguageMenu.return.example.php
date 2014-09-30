<?php

array(
  array(
    'menuItem' or 'item' => '<ul>',
    'startTag'           => '<ul>'
    ),
  array(
    'position'           => 'first',
    'active'             => true,
    'menuItem' or 'item' => '<li class="active"><a href="/en/page/english-page" class="active">English</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="/en/page/english-page" class="active">English</a>',
    'endTag'             => '</li>',
    'href'               => '/en/page/english-page',
    'flag'               => '/cms/library/images/icons/flags/en.png',
    'language'           => 'en'
    ),
  array(
    'position'           => 2,
    'menuItem' or 'item' => '<li><a href="/de/page/deutsche-seite">German</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="/de/page/deutsche-seite">German</a>',
    'endTag'             => '</li>',
    'href'               => '/de/page/deutsche-seite',
    'flag'               => '/cms/library/images/icons/flags/de.png',
    'language'           => 'de'
    ),
  array(
    'position'           => 'last',
    'menuItem' or 'item' => '<li><a href="/fr/page/french-site">French</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="/fr/page/french-site">French</a>',
    'endTag'             => '</li>',
    'href'               => '/fr/page/french-site',
    'flag'               => '/cms/library/images/icons/flags/fr.png',
    'language'           => 'fr'
    ),
  array(
    'menuItem' or 'item' => '</ul>',
    'endTag'             => '</ul>'
    )
  )
  
?>