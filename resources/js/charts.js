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
            labels: ['Male', 'Female'],
            datasets: [{
                data: data,
                backgroundColor: ["#5138ee", "#010101"],
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