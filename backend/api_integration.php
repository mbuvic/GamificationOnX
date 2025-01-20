<?php
/**
 * API Integration for GamificationOnX
 * Author: Charles Mbuvi
 * Date: <?php echo date("Y-m-d"); ?>
 * Description: Connects to the X API, fetches real-time user activity, and provides data for gamification.
 */

// Constants for API connection
define('API_BASE_URL', 'https://api.x.com/2/');
define('ACCESS_TOKEN', 'your_access_token_here'); // Replace with your API access token

/**
 * Makes a GET request to the X API
 * 
 * @param string $endpoint The API endpoint to call
 * @param array $params Query parameters for the API call
 * @return array The decoded JSON response
 */
function apiGetRequest($endpoint, $params = []) {
    $url = API_BASE_URL . $endpoint . '?' . http_build_query($params);

    $headers = [
        "Authorization: Bearer " . ACCESS_TOKEN
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        return json_decode($response, true);
    } else {
        echo "Error: Unable to fetch data from API. HTTP Status Code: $httpCode\n";
        return [];
    }
}

/**
 * Fetches user activity from the X API
 * 
 * @param string $userId The ID of the user
 * @return array The processed activity data
 */
function fetchUserActivity($userId) {
    // Fetch user tweets
    $tweetsData = apiGetRequest("users/$userId/tweets", [
        'max_results' => 100
    ]);

    // Fetch user followers count
    $userData = apiGetRequest("users/$userId", []);

    // Process data
    $userActivity = [
        'likes' => 0,
        'tweets' => count($tweetsData['data'] ?? []),
        'followers' => $userData['data']['public_metrics']['followers_count'] ?? 0,
        'replies' => 0, // Placeholder, as replies might need additional endpoint parsing
        'trending_hashtags' => 0 // Placeholder, additional logic required
    ];

    // Calculate likes from tweets
    if (!empty($tweetsData['data'])) {
        foreach ($tweetsData['data'] as $tweet) {
            $userActivity['likes'] += $tweet['public_metrics']['like_count'] ?? 0;

            // Extract trending hashtags logic (mock example)
            if (strpos($tweet['text'], '#Trending') !== false) {
                $userActivity['trending_hashtags']++;
            }
        }
    }

    return $userActivity;
}

// User-specific information (Actual user ID from X API)
$userId = 'user_id_here'; // The target user ID

// Fetch user activity and display it
$userActivity = fetchUserActivity($userId);
echo "Fetched User Activity:\n";
print_r($userActivity);

// Award badges based on activity
require_once 'badges_system.php';
$awardedBadges = awardBadges($badgeCriteria, $userActivity);

if (!empty($awardedBadges)) {
    echo "🎖️ Badges Earned:\n";
    foreach ($awardedBadges as $badge) {
        echo "- {$badge['emoji']} {$badge['name']} ({$badge['description']})\n";
    }
} else {
    echo "No badges earned yet. Keep engaging and achieving!\n";
}
?>

