<?php

array(
  'id'                => 1,
  'category'          => 'Example Category',
  'pageDate'          => '2000-12-31', // depending on the date format settings from the backend
  'pageDateTimestamp' => 1325393999,
  'title'             => 'Title Example',
  'thumbnail'         => '<img src="/path/thumb_page1.png" alt="Thumbnail" title="Title Example">',
  'thumbnailPath'     => '/path/thumb_page1.png',
  'content'           => "\n".'<p>Content Text</p>'."\n", // the content has line breaks before and after
  'description'       => 'Short description of the page',
  'tags'              => 'tag1 tag2 tag3',
  'plugins'           => array(
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
  'error'             => false
  )

?>