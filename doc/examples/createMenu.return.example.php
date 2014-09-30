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
    'pageDateTimestamp'  => array(
                    'date'  => 1325393999, // 'date' and 'start' is the same
                    'start' => 1325393999,
                    'end'   => 1325303455 // will be 0 when its not a date range
                    ),
    'pageId' or 'id'     => 5,
    'categoryId'         => 1
    ),
  array(
    'position'           => 2,
    'menuItem' or 'item' => '<li><a href="?page=8&category=1">Example Page 2</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=8&category=1">Example Page 2</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Page 2',
    'href'               => '?page=8&category=1',
    'pageDate'           => '2000-10-10',
    'pageDateTimestamp'  => array(
                    'date'  => 1325393465, // 'date' and 'start' is the same
                    'start' => 1325393465,
                    'end'   => 0
                    ),
    'pageId' or 'id'     => 8,
    'categoryId'         => 1
    ),
  array(
    'position'           => 'last',
    'menuItem' or 'item' => '<li><a href="?page=9&category=1">Example Page 3</a></li>',
    'startTag'           => '<li>',
    'link'               => '<a href="?page=9&category=1">Example Page 3</a>',
    'endTag'             => '</li>',
    'title'              => 'Example Page 3',
    'href'               => '?page=9&category=1',
    'pageDate'           => '2000-10-15',
    'pageDateTimestamp'  => array(
                    'date'  => 1325393322, // 'date' and 'start' is the same
                    'start' => 1325393322,
                    'end'   => 0
                    ),
    'pageId' or 'id'     => 9,
    'categoryId'         => 1
    ),
  array(
    'menuItem' or 'item' => '</ul>',
    'endTag'             => '</ul>'
    )
  )
  
?>