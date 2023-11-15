window.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch(SYSTEM_URL + "app/Jobs/process_gender_stats_fetch.php");

        if(!response.ok){
            return
        }
        
        const responseData = await response.json();

        createChart(responseData);
    } catch (error) {
        toast(error, 'error');
    }
})

function createChart(data){
    const ctx1 = document.getElementById('chart-gender').getContext('2d');
    
    const chartGender = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: data.category,
            datasets: [{
                data: data.total,
                backgroundColor: ["#221507", "#432a0e", "#543512", "#654016", "#764a19", "#86551d", "#a86a24", "#b1793a", "#b98850", "#c29766", "#cba67c", "#d4b592", "#dcc3a7"],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            maintainAspectRatio: false,
            tooltips: {
                titleFontFamily: 'Poppins',
                bodyFontFamily: 'Poppins'
            },
        }
    });
}