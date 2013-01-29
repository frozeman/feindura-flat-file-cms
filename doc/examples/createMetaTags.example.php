<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

// start to write HTML page
?>
<!DOCTYPE html>
  <html>
  <head>';
  <?php
    // John Doe is the author of the website.
    echo $feindura->createMetaTags('John Doe');
  ?>
  </head>
  <body>
  ...


<?php                               *** RESULT *** 
--------------------------------------------------------------------------------

<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">
  <title>Welcome - An Example Website</title>

  <meta name="author" content="John Doe">
  <meta name="publisher" content="John Doe">
  <meta name="copyright" content="John Doe">
  <meta name="keywords" content="feindura,cms,flat file">
  <meta name="description" content="The website of feindura">
  <meta name="generator" content="feindura - Flat File CMS 1.2 build:999">

  <!-- Open Graph Protocol -->
  <meta property="og:site_name" content="feindura - Flat File CMS">
  <meta property="og:url" content="http://feindura.org/page/welcome/">
  <meta property="og:title" content="Welcome | feindura - Flat File CMS">
  <meta property="og:description" content="The website of feindura">
  <meta property="og:image" content="http://feindura.org/cms/upload/thumbnails/thumb_page66_50a104f97f1c1.jpg">

  <!-- Twitter Cards -->
  <meta name="twitter:site_name" content="feindura - Flat File CMS">
  <meta name="twitter:url" content="http://feindura.org/page/welcome/">
  <meta name="twitter:title" content="Welcome | feindura - Flat File CMS">
  <meta name="twitter:description" content="The website of feindura">
  <meta name="twitter:image" content="http://feindura.org/cms/upload/thumbnails/thumb_page66_50a104f97f1c1.jpg">

  <!-- Google+ Snippets -->
  <meta itemprop="url" content="http://feindura.org/page/welcome/">
  <meta itemprop="name" content="Welcome | feindura - Flat File CMS">
  <meta itemprop="description" content="The website of feindura">
  <meta itemprop="image" content="http://feindura.org/cms/upload/thumbnails/thumb_page66_50a104f97f1c1.jpg">


  <link rel="alternate" type="application/atom+xml" title="Eine Beispiel Website (Atom, DE)" href="http://localhost/cms/pages/atom.de.xml">
  <link rel="alternate" type="application/rss+xml" title="Eine Beispiel Website (RSS 2.0, DE)" href="http://localhost/cms/pages/rss2.de.xml">
  <link rel="alternate" type="application/atom+xml" title="An Example Website (Atom, EN)" href="http://localhost/cms/pages/atom.en.xml">
  <link rel="alternate" type="application/rss+xml" title="An Example Website (RSS 2.0, EN)" href="http://localhost/cms/pages/rss2.en.xml">

</head>
<body>
...

?>