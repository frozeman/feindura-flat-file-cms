<?php

array(

  0 => array(
    'id' => 1,
    'category' => 'A Category',
    'pageDate' => '2010-12-31',
    'title' => 'Title Example 1',
    'thumbnail' => false, // page has no thumbnail
    'thumbnailPath' => false, // page has no thumbnail
    'content' => "\n".'<p>Content Text</p>'."\n", // the content has line breaks before and after
    'tags' => 'tag1 tag2 tag3',
    'plugins' => array (?)
    ),
   
   1 => array(
    'id' => 5,
    'category' => 'A Category',
    'pageDate' => '2009-12-31',
    'title' => 'Title Example 2',
    'thumbnail' => false, // page has no thumbnail
    'thumbnailPath' => false, // page has no thumbnail
    'content' => "\n".'<p>Content Text</p>'."\n", // the content has line breaks before and after
    'tags' => 'tag3 tag4',
    'plugins' => array (?)
    ),
  
   2 => array(
    'id' => 8,
    'category' => 'Another Category',
    'pageDate' => false, // page has no pagedate
    'title' => 'Title Example 3',
    'thumbnail' => '<img src="/path/thumb_cat1page3.png" alt="Thumbnail" title="Title Example 3" />',
    'thumbnailPath' => '/path/thumb_cat1page3.png',
    'content' => "\n".'<p>Content Text</p>'."\n", // the content has line breaks before and after
    'tags' => 'tag3 tag1',
    'plugins' => array (?)
    )
  )
  
?>