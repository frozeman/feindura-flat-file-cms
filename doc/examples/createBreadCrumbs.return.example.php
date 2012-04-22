<?php

array(
  array(
    'menuItem' => '<ul>',
    'startTag' => '<ul>'
    ),
  array(
    'menuItem' => '<li><a href="?page=1">Welcome</a> &rArr; </li>',
    'startTag' => '<li>',
    'link'     => '<a href="?page=1">Welcome</a>',
    'endTag'   => '</li>',
    'title'    => 'Welcome',
    'href'     => '?page=1',
    'pageId'   => 1
    ),
  array(
    'menuItem'   => '<li><a href="?page=5$category=1">Example Category: Example Page 1</a></li>',
    'startTag'   => '<li>',
    'link'       => '<a href="?page=5$category=1">Example Category: Example Page 1</a>',
    'endTag'     => '</li>',
    'title'      => 'Example Category: Example Page 1',
    'href'       => '?page=5$category=1',
    'pageId'     => 5,
    'categoryId' => 1
    ),
  array(
    'menuItem' => '</ul>',
    'endTag'   => '</ul>'
    )
  )
  
?>