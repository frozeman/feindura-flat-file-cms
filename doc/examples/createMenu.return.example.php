<?php

array(
  array(
    'menuItem' or 'item' => '<ul>',
    'startTag'           => '<ul>'
    ),
  array(
    'position'           => 'first',
    'active'             => true,
    'menuItem' or 'item' => '<li class="active"><a href="?page=5&category=1" class="active">Example Page 1</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=5&category=1" class="active">Example Page 1</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Page 1',
    'href'               => '?page=5&category=1',
    'pageDate'           => '2000-12-31',
    'pageDateTimestamp'  => 1325393999,
    'pageId' or 'id'     => 5,
    'categoryId'         => 1
    ),
  array(
    'position'           => 2,
    'active'             => false,
    'menuItem' or 'item' => '<li><a href="?page=8&category=1">Example Page 2</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=8&category=1">Example Page 2</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Page 2',
    'href'               => '?page=8&category=1',
    'pageDate'           => '2000-10-10',
    'pageDateTimestamp'  => 13253034552,
    'pageId' or 'id'     => 8,
    'categoryId'         => 1
    ),
  array(
    'position'           => 'last',
    'active'             => false,
    'menuItem' or 'item' => '<li><a href="?page=9&category=1">Example Page 3</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=9&category=1">Example Page 3</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Page 3',
    'href'               => '?page=9&category=1',
    'pageDate'           => '2000-10-15',
    'pageDateTimestamp'  => 13253034222,
    'pageId' or 'id'     => 9,
    'categoryId'         => 1
    ),
  array(
    'menuItem' or 'item' => '</ul>',
    'endTag'             => '</ul>'
    )
  )
  
?>