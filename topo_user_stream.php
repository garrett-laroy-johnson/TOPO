<?php
require_once('Phirehose.php');
require_once('OauthPhirehose.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words
 */
class FilterTrackConsumer extends OauthPhirehose
{
  /**
   * Enqueue each status
   *
   * @param string $status
   */
  public function enqueueStatus($status)
  {
    /*
     * In this simple example, we will just display to STDOUT rather than enqueue.
     * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
     *       enqueued and processed asyncronously from the collection process.
     */
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
    }
  }
}

// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", "cDSrF8g6TtqWHNTeL06JBtFGO");
define("TWITTER_CONSUMER_SECRET", "vsVUmqpUolLDxwxqjCFwCm1M22GpK7gkvDr7DqLOSa5iu3P2aA");


// The OAuth data for the twitter account
define("OAUTH_TOKEN", "711836958876536832-OqGj3Fv968vDXMAMHXlFA3l8LVvGD9Z");
define("OAUTH_SECRET", "RYlWWGbY1JNKXpPdXdHnEhUKSwugZThWR0PztSRyOFtTi");

// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setFollow(array(
711836958876536832 //The user IDs of the twitter accounts to follow. All of
    //these users must have given your app permission.
));
$sc->consume();
