<?php

array(
    "id" => 2,
    "category" => 1,
    "public" => true,
    "sortOrder" => 4,
    "lastSaveDate" => 1282348800, // UNIX-Timestamp
    "lastSaveAuthor" => 'fooMan',
    "title" => 'Example Page 2',
    "description" => '',
    "pageDate" => array(
                  "before" => 'text before date',
                  "date" => 1282348800,
                  "after" => 'text after date'
                ),  
    "tags" => 'winter summer',
    "plugins" => array(
                  "plugin1" => array(
                              "active" => true,
                              "exampleConfigString" => 'example/path/',
                              "exampleConfigNumber" => 500
                            ),
                  "plugin2" => array(
                              "active" => true,
                              "exampleConfigBool1" => false,
                              "exampleConfigBool2" => true,
                            )
                ),
    "thumbnail" => 'thumb_page2.jpg',
    "styleFile" => 'a:0:{}',  // serialized array
    "styleId" => '',
    "styleClass" => '',
    "content" => '<p>Example Content</p>'
    )

?>