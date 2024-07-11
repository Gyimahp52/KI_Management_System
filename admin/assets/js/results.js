// script.js

// KEQ Bar Chart
const keqBarChart = document.getElementById('keqBarChart').getContext('2d');
new Chart(keqBarChart, {
    type: 'bar',
    data: {
        labels: ['Decision Making', 'Teamwork', 'Determination', 'Problem-solving', 'No Failure', 'Curiosity', 'Optimism', 'Self-confidence', 'Honesty', 'Experience', 'Kindness'],
        datasets: [
            {
                label: 'Base',
                backgroundColor: '#50C878',
                data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
            },
            {
                label: 'Improvement',
                backgroundColor: '#0EB7F7',
                data: [8, 9, 9, 4, 8, 5, 7, 9, 9, 5, 7]
            },
            {
                label: 'Target',
                backgroundColor: '#F7A60E',
                data: [42, 41, 41, 46, 42, 45, 43, 41, 41, 45, 43]
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Kinesthetic Emotional Intelligence Quotient (KEQ)',
                color: 'white',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                padding: {
                    top: 10,
                    bottom: 30
                }
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: 'white',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += context.parsed.y;
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: 'white',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    callback: function(value, index, ticks) {
                        return value + '%';
                    }
                },
                max: 100
            }
        }
    }
});

// SEL Pie Chart
const selPieChart = document.getElementById('selPieChart').getContext('2d');
new Chart(selPieChart, {
    type: 'pie',
    data: {
        labels: ['Self Awareness', 'Self Management', 'Social Awareness', 'Relationship Skills', 'Responsible Decision Making'],
        datasets: [{
            data: [18, 18, 10, 18, 18],
            backgroundColor:[
            '#FF6384',
            '#36A2EB',
            '#FFCE56', 
            '#4BC0C0', 
            '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Competencies Chart',
                color: 'white',
                font: {
                    size: 30,
                    weight: 'bold'
                },
                padding: {
                    top: 10,
                    bottom: 30
                }
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: 'white',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw;
                        const total = context.chart._metasets[context.datasetIndex].total;
                        const percentage = ((value / total) * 100).toFixed(2);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    }
});

// Character Strengths Bar Chart
const csBarChart = document.getElementById('csBarChart').getContext('2d');
new Chart(csBarChart, {
    type: 'bar',
    data: {
        labels: ['First Month', 'Second Month', 'Third Month'],
        datasets: [
            {
                label: 'Heart (SH)',
                backgroundColor: '#FF6384',
                data: [9, 9, 7]
            },
            {
                label: 'Mind (SM)',
                backgroundColor: '#36A2EB',
                data: [8, 4, 9]
            },
            {
                label: 'Will (SW)',
                backgroundColor: '#FFCE56',
                data: [9, 8, 5]
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
