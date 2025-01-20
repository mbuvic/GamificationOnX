// Leaderboard.js
document.addEventListener("DOMContentLoaded", function () {
  const leaderboardContainer = document.querySelector("#leaderboard");

  // Show a loading spinner while data is being fetched
  function showLoading() {
    leaderboardContainer.innerHTML = `
      <div class="loading">
        <p>Loading leaderboard...</p>
      </div>
    `;
  }

  // Fetch leaderboard data from the backend
  async function fetchLeaderboard() {
    try {
      const response = await fetch("/api/leaderboard"); // Replace with your backend endpoint
      if (!response.ok) {
        throw new Error("Failed to fetch leaderboard data.");
      }
      const data = await response.json();
      renderLeaderboard(data);
    } catch (error) {
      console.error("Error fetching leaderboard:", error);
      leaderboardContainer.innerHTML = `
        <div class="error">
          <p>Unable to load leaderboard. Please try again later.</p>
        </div>
      `;
    }
  }

  // Render the leaderboard
  function renderLeaderboard(data) {
    if (data.length === 0) {
      leaderboardContainer.innerHTML = `
        <div class="empty">
          <p>No leaderboard data available.</p>
        </div>
      `;
      return;
    }

    let leaderboardHTML = `
      <table class="leaderboard-table">
        <thead>
          <tr>
            <th>Rank</th>
            <th>User</th>
            <th>Points</th>
            <th>Badges</th>
          </tr>
        </thead>
        <tbody>
    `;

    data.forEach((user, index) => {
      leaderboardHTML += `
        <tr>
          <td>#${index + 1}</td>
          <td>
            <div class="user-info">
              <img src="${user.avatar || 'https://via.placeholder.com/40'}" alt="${user.name}'s avatar" />
              <span>${user.name}</span>
            </div>
          </td>
          <td>${user.points}</td>
          <td>${user.badges.map(badge => `🏆 ${badge}`).join(" ")}</td>
        </tr>
      `;
    });

    leaderboardHTML += `
        </tbody>
      </table>
    `;

    leaderboardContainer.innerHTML = leaderboardHTML;
  }

  // Initialize the leaderboard
  showLoading();
  fetchLeaderboard();
});
