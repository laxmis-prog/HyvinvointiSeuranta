let wellnessData = {
    sleepHours: [],
    mood: [],
    waterIntake: [],
    exerciseDuration: [],
    nutrition: []
};

document.getElementById('healthForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Collect form data
    const sleepHours = document.getElementById('sleep_hours').value;
    const mood = document.getElementById('mood').value;
    const waterIntake = document.getElementById('water_intake').value;
    const exerciseDuration = document.getElementById('exercise_duration').value;
    const nutrition = document.getElementById('nutrition').value;

    // Validate form fields (add your validation code here)

    // Collect data for chart
    wellnessData.sleepHours.push(sleepHours);
    wellnessData.mood.push(mood);
    wellnessData.waterIntake.push(waterIntake);
    wellnessData.exerciseDuration.push(exerciseDuration);
    wellnessData.nutrition.push(nutrition);

    // Call function to update chart
    updateChart();

    // Clear the form (optional)
    document.getElementById('healthForm').reset();
});

function updateChart() {
    const ctx = document.getElementById('wellnessChart').getContext('2d');

    // If the chart already exists, destroy it before creating a new one
    if (window.wellnessChart) {
        window.wellnessChart.destroy();
    }

    // Create the chart
    window.wellnessChart = new Chart(ctx, {
        type: 'bar', // Change this to the type of chart you want
        data: {
            labels: ['Sleep Hours', 'Mood', 'Water Intake', 'Exercise Duration', 'Nutrition'],
            datasets: [{
                label: 'Daily Wellness Data',
                data: [
                    wellnessData.sleepHours.reduce((a, b) => a + parseFloat(b), 0) / wellnessData.sleepHours.length || 0,
                    wellnessData.mood.length ? wellnessData.mood.length : 0,
                    wellnessData.waterIntake.reduce((a, b) => a + parseFloat(b), 0) / wellnessData.waterIntake.length || 0,
                    wellnessData.exerciseDuration.reduce((a, b) => a + parseFloat(b), 0) / wellnessData.exerciseDuration.length || 0,
                    wellnessData.nutrition.length
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
