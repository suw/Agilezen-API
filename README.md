# Agilezen.com API Class in PHP
This small class lets you connect to Agilezen.com and gather information about your projects and stories. Using it is very simple.

## Usage
    $agilezen = new \Agilezen('YOUR_API_KEY_HERE');
  
    $storyList = $agilezen->with('tags')
      ->with('metrics')
      ->getStoryList('PROJECT_ID');

    $story = $agilezen->with('everything')
      ->getStory('PROJECT_ID', 'STORY_ID');

Each of those calls returns an array of `stdClass` PHP objects that you can loop through and do whatever you want with.

## Author
Vic Cherubini <vmc@leftnode.com>