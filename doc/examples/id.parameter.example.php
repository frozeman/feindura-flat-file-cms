<?php
  // The "next","previous","first" and "last" is always relative to the current $this->page and $this->category property.
  // If there is an ID, "prev" or "next" for the page value, it will always discard the category value and load the right page.
  // Note: When using "previous","next","first" or "last" it will jump over pages/categories which are not public and return the next one.

  empty                  // load the current page
  false/true             // same as above
  array(false,false)     // same as above

  2                      // load page with ID 2
  'rand'                 // load a random page of the current category
  array('rand',false)    // same as above

  'next'                 // load the next page in the current category
  array('next',false)    // the same as above
  array('next','rand')   // the same as above (it would discard the category ID)
  array(2,45)            // load the page with ID 2 (it would discard the category ID)

  array(false,3)         // load the first page of category with ID 3

  array(false,'next')    // load the first page of the next category
  array(false,'prev')    // load the first page of the previous category

  array('last',false)    // load the last page of the current category
  array('last','next')   // load the last page of the next category
  array('first','last')  // load the first page of the last category

  array('rand','next')   // load a random page of the next category
  array('rand','rand')   // load a random page of a random category
  array('first','rand')  // load the first page of a random category

  ...

?>