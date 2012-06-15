<?php

array(

  0 => array(
    'position'          => 'first', // is the first page in the returned pages list
    'pageId' or 'id'    => 1,
    'category'          => 'A Category',
    'categoryId'        => 1,
    'subCategory'       => 'Another Category',
    'subCategoryId'     => 2,
    'pageDate'          => '2010-12-31', // format depending on the administrator-settings
    'pageDateTimestamp' => 1325393999,
    'title'             => 'Title Example 1',
    'thumbnail'         => false, // page has no thumbnail
    'thumbnailPath'     => false,
    'content'           => "\n".'<p>Content Text</p>'."\n",
    'description'       => 'Short description of the page',
    'tags'              => 'tag1,tag2,tag3',
    'plugins'           => array (
    	'imageGallery' => array(
                'galleryPath'     => '',
                'imageWidth'      => 800,
                'imageHeight'     => null,
                'thumbnailWidth'  => 160,
                'thumbnailHeight' => null,
                'tag'             => 'table',
                'breakAfter'      => 3
    			)
    	)
    ),
   
   1 => array(
    'position'          => 2,
    'pageId' or 'id'    => 5,
    'category'          => 'A Category',
    'categoryId'        => 1,
    'subCategory'       => false,
    'subCategoryId'     => false,
    'pageDate'          => '2009-12-31',
    'pageDateTimestamp' => 1325393999,
    'title'             => 'Title Example 2',
    'thumbnail'         => false,
    'thumbnailPath'     => false,
    'content'           => "\n".'<p>Content Text</p>'."\n",
    'description'       => 'Short description of the page',
    'tags'              => 'tag3,tag4',
    'plugins'           => array ()
    ),
  
   2 => array(
    'position'          => 'last', // is the last page in the returned pages list
    'pageId' or 'id'    => 8,
    'category'          => 'Another Category',
    'categoryId'        => 2,
    'subCategory'       => false,
    'subCategoryId'     => false,
    'pageDate'          => false, // page has no page date
    'pageDateTimestamp' => false,
    'title'             => 'Title Example 3',
    'thumbnail'         => '<img src="/path/thumb_page3.png" class="feinduraThumbnail" alt="Thumbnail" title="Title Example 3">',
    'thumbnailPath'     => '/path/thumb_page3.png',
    'content'           => "\n".'<p>Content Text</p>'."\n",
    'description'       => 'Short description of the page',
    'tags'              => 'tag3,tag1',
    'plugins'           => array ()
    )
  )
  
?>