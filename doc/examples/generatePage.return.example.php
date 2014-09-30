<?php

array(
  'pageId' or 'id'    => 1,
  'category'          => 'Example Category',
  'categoryId'        => 3,
  'subCategory'       => 'Another Category',
  'subCategoryId'     => 4,
  'pageDate'          => '2000-12-31 - 2010-01-15', // depending on the date format settings in the backend
  'pageDateTimestamp'  => array(
                    'date'  => 1325393999, // 'date' and 'start' is the same
                    'start' => 1325393999,
                    'end'   => 1325303455 // will be 0 when its not a date range
                    ),
  'title'             => 'Title Example',
  'thumbnail'         => '<img src="/path/thumb_page1.png" class="feinduraThumbnail" alt="Thumbnail" title="Title Example">',
  'thumbnailPath'     => '/path/thumb_page1.png',
  'content'           => "\n".'<p>Content Text</p>'."\n",
  'description'       => 'Short description of the page',
  'tags'              => 'tag1,tag2,tag3',
  'href'              => '?category=3&page=1', // or a speaking url, if activated
  'plugins'           => array( // each activated plugin with its page specific settings
          'imageGallery' => array(
              'active'          => true,
              'galleryPath'     => '/upload/gallery/',
              'imageWidth'      => 800,
              'imageHeight'     => null,
              'thumbnailWidth'  => 160,
              'thumbnailHeight' => null,
              'tag'             => 'table',
              'breakAfter'      => 3
          ),
          'pageRating' => array(
              'active' => false,
              'value'  => 0,
              'votes'  => 0
          )
      ),
  'error'             => false // will be set to TRUE when the page doesn't exist or is deactivated
  )

?>