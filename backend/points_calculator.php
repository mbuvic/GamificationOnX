<?php
/**
 * Points Calculator for GamificationOnX
 * Author: Charles Mbuvi Peter
 * Date: <?php echo date("Y-m-d"); ?>
 * Description: Dynamically calculates points based on user activity and events on X. Built for scalability and extensibility.
 */

// Configuration: Define point rules and thresholds for various activities.
$pointRules = [
    'like' => 1,             // 1 point per like
    'retweet' => 2,          // 2 points per retweet
    'new_follower' => 5,     // 5 points per new follower
    'trending_hashtag' => 10, // 10 points for using a trending hashtag
    'reply' => 3,            // 3 points per reply to a tweet
    'tweet' => 5             // 5 points per original tweet
];

// Bonus multipliers for gamification streaks or special events
$bonusMultipliers = [
    'streak' => 1.5,         // 50% extra for daily streaks
    'event' => 2             // Double points for special events
];

// User activity logs (to be replaced with real-time API data from X)
$userActivityLog = [
    ['type' => 'like', 'count' => 50],     // Example: 50 likes
    ['type' => 'retweet', 'count' => 20], // Example: 20 retweets
    ['type' => 'new_follower', 'count' => 10],
    ['type' => 'trending_hashtag', 'count' => 5],
    ['type' => 'reply', 'count' => 15],
    ['type' => 'tweet', 'count' => 10]
];

// Function to calculate points for a single activity
function calculateActivityPoints($activityType, $count, $rules, $bonusMultiplier = 1) {
    if (!isset($rules[$activityType])) {
        return 0; // Return 0 for unknown activities
    }
    return $rules[$activityType] * $count * $bonusMultiplier;
}

// Function to calculate total points for a user
function calculateTotalPoints($activityLog, $rules, $multipliers) {
    $totalPoints = 0;
    $streakActive = true; // Simulating a streak bonus (replace with real data)
    $eventActive = false; // Simulating an event bonus (replace with real data)
    
    foreach ($activityLog as $activity) {
        $bonusMultiplier = 1;
        if ($streakActive) {
            $bonusMultiplier *= $multipliers['streak'];
        }
        if ($eventActive) {
            $bonusMultiplier *= $multipliers['event'];
        }
        $totalPoints += calculateActivityPoints($activity['type'], $activity['count'], $rules, $bonusMultiplier);
    }
    return $totalPoints;
}

// Calculate points
$totalPoints = calculateTotalPoints($userActivityLog, $pointRules, $bonusMultipliers);

// Display the results
echo "🎉 Total Points Earned: " . $totalPoints . "\n";

// Suggestive Feedback for Gamification
function suggestAchievements($points) {
    if ($points > 500) {
        return "🏆 You're an X Rockstar! Keep dominating!";
    } elseif ($points > 200) {
        return "✨ Amazing progress! Aim for the next level.";
    } else {
        return "🚀 Great start! Keep engaging and leveling up.";
    }
}

// Provide Feedback
echo suggestAchievements($totalPoints) . "\n";

// Propose badges
function proposeBadges($activityLog) {
    $badges = [];
    foreach ($activityLog as $activity) {
        if ($activity['type'] == 'tweet' && $activity['count'] >= 100) {
            $badges[] = "Content Creator Badge 🖊️";
        }
        if ($activity['type'] == 'new_follower' && $activity['count'] >= 50) {
            $badges[] = "Influencer Badge 👑";
        }
        if ($activity['type'] == 'like' && $activity['count'] >= 100) {
            $badges[] = "Engagement Guru Badge 💬";
        }
    }
    return $badges;
}

// Display suggested badges
$badges = proposeBadges($userActivityLog);
if (!empty($badges)) {
    echo "🏅 Suggested Badges for You:\n";
    foreach ($badges as $badge) {
        echo " - $badge\n";
    }
}
?>
