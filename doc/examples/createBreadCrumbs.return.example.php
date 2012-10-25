<?php

array(
  array(
    'menuItem' => '<ul>',
    'startTag' => '<ul>'
    ),
  array(
    'position'           => 'first',
    'active'             => true,
    'menuItem' or 'item' => '<li class="active"><a href="?page=1" class="active">Welcome</a> &rArr; </li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=1" class="active">Welcome</a>',
    'endTag'             => '</li>',
    'title'              => 'Welcome',
    'href'               => '?page=1',
    'pageId'             => 1,
    'categoryId'         => 0
    ),
  array(
    'position'           => 'last',
    'menuItem' or 'item' => '<li><a href="?page=5$category=1">Example Category: Example Page 1</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=5$category=1">Example Category: Example Page 1</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Category: Example Page 1',
    'href'               => '?page=5$category=1',
    'pageId'             => 5,
    'categoryId'         => 1
    ),
  array(
    'menuItem' => '</ul>',
    'endTag'   => '</ul>'
    )
  )
  
?>