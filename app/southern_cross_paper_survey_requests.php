<?php

Route::group(array('prefix' => 'southern_cross_doctors'), function() {
    Route::get('/sc_paper_survey_requests', function() {

        $TestFeed = new \FeedWriter\RSS2;
        // Setting the channel elements
        // Use wrapper functions for common channel elements
        $TestFeed->setTitle('Testing & Checking the RSS writer class');
        $TestFeed->setLink('http://www.ajaxray.com/projects/rss');
        $TestFeed->setDescription('This is a test of creating a RSS 2.0 feed Universal Feed Writer');
        // Image title and link must match with the 'title' and 'link' channel elements for valid RSS 2.0
        $TestFeed->setImage('Testing & Checking the RSS writer class','http://www.ajaxray.com/projects/rss','http://www.rightbrainsolution.com/_resources/img/logo.png');
        // Let's add some feed items: Create two empty Item instances
        $itemOne = $TestFeed->createNewItem();
        $itemTwo = $TestFeed->createNewItem();
        // Add item details
        $itemOne->setTitle('The title of the first entry.');
        $itemOne->setLink('http://www.google.de');
        $itemOne->setDate(time());
        $itemOne->setDescription('And here\'s the description of the entry.');
        $itemTwo->setTitle('Lorem ipsum');
        $itemTwo->setLink('http://www.example.com');
        $itemTwo->setDate(1234567890);
        $itemTwo->setDescription('Lorem ipsum dolor sit amet, consectetur, adipisci velit');
        // Now add the feed item
        $TestFeed->addItem($itemOne);
        $TestFeed->addItem($itemTwo);
        // OK. Everything is done. Now generate the feed.
        $TestFeed->printFeed();
    });

    Route::get('/sourthern_cross/', function() {

    });
});
