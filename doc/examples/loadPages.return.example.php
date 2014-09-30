<?php

array(
    0 => array(
      "id"             => 2,
      "category"       => 1,
      "subCategory"    => 3,
      "public"         => true,
      "sortOrder"      => 4,
      "lastSaveDate"   => 1282348800, // UNIX-Timestamp
      "lastSaveAuthor" => 1, // ID of the user
      "pageDate"       => array(
          "date"   => '2010-12-31',
        ),
      "plugins"      => '',
      "thumbnail"    => 'thumb_page2.jpg',
      "styleFile"    => '',
      "styleId"      => '',
      "styleClass"   => '',
      "localized"    => array(
          "en" => array( 
            "title"       => 'Example Page 2',
            "description" => '',
            "tags"        => 'winter summer',
            "pageDate"    => array(
                "before" => 'text before date',
                "after"  => 'text after date'
              ),
            "content"     => '<p>Example Content</p>'
          ),
          "de" => array( 
            "title"       => 'Beispiel Seite 2',
            "description" => '',
            "tags"        => 'Winter Sommer',
            "pageDate"    => array(
                "before" => 'Text davor',
                "after"  => 'Text danach'
              ),
            "content"     => '<p>Beispiel Inhalt</p>'
          )
        )
      ),
    
    1 => array(
      "id"             => 2,
      "category"       => 1,
      "subCategory"    => false,
      "public"         => true,
      "sortOrder"      => 4,
      "lastSaveDate"   => 1282348855, // UNIX-Timestamp
      "lastSaveAuthor" => 2, // ID of the user
      "pageDate"       => array(
          "date"   => '2010-12-15',
        ),
      "plugins"      => '',
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

    ...
  )

?>