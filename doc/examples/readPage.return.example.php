<?php

array(
    "id"             => 2,
    "category"       => 1,
    "subCategory"    => false,
    "public"         => true,
    "sortOrder"      => 4,
    "showInMenus"    => true,
    "editLink"       => '',

    "lastSaveDate"   => 1282348800, // UNIX-Timestamp
    "lastSaveAuthor" => 1, // ID of the user

    "pageDate"       => array(
        "start"   => 1282342343,
        "end"     => 1282353627
      ),

    "plugins"      => array(
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
          ),

    "thumbnail"    => 'thumb_page1.jpg',

    "styleFile"    => '',
    "styleId"      => '',
    "styleClass"   => '',

    "localized"    => array(
        "en" => array( 
          "title"       => 'Example Page 1',
          "description" => '',
          "tags"        => 'fall',
          "pageDate"    => array(
              "before" => 'text before date',
              "after"  => 'text after date'
            ),
          "content"     => '<p>Example Content of page 1</p>'
        ),
        "de" => array( 
          "title"       => 'Beispiel Seite 1',
          "description" => '',
          "tags"        => 'herbst',
          "pageDate"    => array(
              "before" => 'Text davor',
              "after"  => 'Text danach'
            ),
          "content"     => '<p>Beispiel Inhalt von Seite 1</p>'
        )
      )
    )

?>