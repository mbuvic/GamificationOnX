<?php
/**
 * Badges System for GamificationOnX
 * Author: Charles Mbuvi
 * Date: <?php echo date("Y-m-d"); ?>
 * Description: Dynamically awards badges to users based on achievements, milestones, and activity trends on X.
 */

// Predefined badge categories and their requirements
$badgeCriteria = [
    'Engagement Guru' => [
        'description' => 'Awarded for receiving 100+ likes across your posts.',
        'requirement' => ['likes' => 100],
        'emoji' => '💬',
        'color' => 'blue'
    ],
    'Content Creator' => [
        'description' => 'Awarded for posting 50+ original tweets.',
        'requirement' => ['tweets' => 50],
        'emoji' => '🖊️',
        'color' => 'green'
    ],
    'Influencer' => [
        'description' => 'Awarded for gaining 50+ followers in a day.',
        'requirement' => ['followers' => 50],
        'emoji' => '👑',
        'color' => 'gold'
    ],
    'Hashtag Hero' => [
        'description' => 'Awarded for using 10+ trending hashtags.',
        'requirement' => ['trending_hashtags' => 10],
        'emoji' => '🔥',
        'color' => 'orange'
    ],
    'Community Builder' => [
        'description' => 'Awarded for replying to 20+ tweets in a day.',
        'requirement' => ['replies' => 20],
        'emoji' => '🤝',
        'color' => 'purple'
    ]
];

// User activity logs (to be replaced with real-time API data from X)
$userActivityLog = [
    'likes' => 120,
    'tweets' => 60,
    'followers' => 55,
    'trending_hashtags' => 12,
    'replies' => 22
];

// Function to check if a badge can be awarded
function checkBadgeEligibility($criteria, $userActivity) {
    foreach ($criteria as $key => $value) {
        if (!isset($userActivity[$key]) || $userActivity[$key] < $value) {
            return false;
        }
    }
    return true;
}

// Function to award badges based on user activity
function awardBadges($badgeCriteria, $userActivity) {
    $awardedBadges = [];
    foreach ($badgeCriteria as $badgeName => $details) {
        if (checkBadgeEligibility($details['requirement'], $userActivity)) {
            $awardedBadges[] = [
                'name' => $badgeName,
                'description' => $details['description'],
                'emoji' => $details['emoji'],
                'color' => $details['color']
            ];
        }
    }
    return $awardedBadges;
}

// Award badges to the user
$awardedBadges = awardBadges($badgeCriteria, $userActivityLog);

// Display awarded badges
if (!empty($awardedBadges)) {
    echo "🎖️ Congratulations! You've earned the following badges:\n\n";
    foreach ($awardedBadges as $badge) {
        echo "{$badge['emoji']} \033[1;38;5;{$badge['color']}m{$badge['name']}\033[0m - {$badge['description']}\n";
    }
} else {
    echo "No badges earned yet. Keep engaging and achieving milestones!\n";
}

// Bonus: Special achievement system
function checkSpecialAchievements($userActivity) {
    $specialAchievements = [];
    if ($userActivity['likes'] >= 500) {
        $specialAchievements[] = "🔥 Viral Sensation - Earned 500+ likes!";
    }
    if ($userActivity['tweets'] >= 100 && $userActivity['replies'] >= 50) {
        $specialAchievements[] = "🌟 Community Star - Posted 100+ tweets and replied to 50+ threads!";
    }
    return $specialAchievements;
}

// Check for special achievements
$specialAchievements = checkSpecialAchievements($userActivityLog);

// Display special achievements
if (!empty($specialAchievements)) {
    echo "\n🏆 Special Achievements Unlocked:\n";
    foreach ($specialAchievements as $achievement) {
        echo " - $achievement\n";
    }
}

?>
