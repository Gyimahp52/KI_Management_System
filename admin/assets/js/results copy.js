// //result.js
// File path: /mapWords.js

// Mapping of short forms to full forms
const wordMap = {
    'Flex': 'Flexibility',
    'Deter': 'Determination',
    'Adap': 'Adaptability',
    'Grit': 'Grit',
    'Endu': 'Endurance',
    'Team': 'Teamwork',
    'Posi': 'Positivity',
    'Coll': 'Collaboration',
    'Prob Solv': 'Problem-Solving',
    'Self Cont': 'Self-Control',
    'Comm': 'Communication',
    'Self Conf': 'Self-Confidence',
    'Opti': 'Optimism',
    'Curi': 'Curiosity',
    'Empa': 'Empathy',
    'Grat': 'Gratitude',
    'Proa': 'Proactivity',
    'Deci Maki': 'Decision Making',
    'Kind': 'Kindness',
    'Hone': 'Honesty',
    'Grow Mind': 'Growth Mindset',
    'Purp': 'Purpose',
    'No Fail': 'No Failure',
    'Expe': 'Experience'
};

// Function to map short forms to full forms
// function mapWords(shortForms) {
//     return shortForms.map(shortForm => wordMap[shortForm] || shortForm);
// }

// Example usage

// const fullForms = mapWords(shortForms);
// console.log(fullForms);



// Ensure the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function () {

    // Register the plugin
    Chart.register(ChartDataLabels);

    const keqBarChart = document.getElementById('keqBarChart').getContext('2d');

    const labels = studentData.map(theme => theme.theme_name);
    const baseData = new Array(labels.length).fill(50);
    const improvementData = studentData.map(theme => Math.max(theme.score));
    const targetData = studentData.map(theme => Math.max(50 - theme.score, 0));

    new Chart(keqBarChart, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Base',
                    backgroundColor: '#6CD65D',
                    borderWidth: 1,
                    data: baseData
                },
                {
                    label: 'Improvement',
                    backgroundColor: '#47B2E0',
                    borderWidth: 1,
                    data: improvementData
                },
                {
                    label: 'Target',
                    backgroundColor: '#F6D23E',
                    borderWidth: 1,
                    data: targetData
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    color: 'black',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value, context) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                title: {
                    display: true,
                    text: `Kinesthetic Emotional Intelligence Quotient (KEQ) for ${studentName}`,
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
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + '%';
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
                        callback: function (value) {
                            return value + '%';
                        }
                    },
                    max: 100
                }
            }

        }
    });

    // Mapping of short forms to full forms
    const shortCompetencyMap = {
        'RDM': 'Responsible Decision Making',
        'SOA': 'Social Awareness',
        'SEA': 'Self Awareness',
        'RS': 'Relationship Skills',
        'SM': 'Self Management',
    };

    // Function to map competencies forms to full forms
    function competencyMap(shortForms) {
        return shortForms.map(shortForm => shortCompetencyMap[shortForm] || shortForm);
    }




    // -----SEL Pie Chart
    const selPieChart = document.getElementById('selPieChart').getContext('2d');

    // Process the data for the SEL chart
    const selLabels = [...new Set(studentData.map(theme => theme.competency))];
    const fullSelLabels = competencyMap(selLabels);

    // Calculate the data for each competency, summing the highest two scores if there are more than two
    const selData = selLabels.map(competency => {
        // Filter scores for the current competency
        const scores = studentData
            .filter(theme => theme.competency === competency)
            .map(theme => theme.score);

        // Sort scores in descending order and sum the top two scores
        scores.sort((a, b) => b - a);
        const topTwoScores = scores.slice(0, 2);
        return topTwoScores.reduce((sum, score) => sum + score, 0);
    });

    new Chart(selPieChart, {
        type: 'pie',
        data: {
            labels: fullSelLabels,
            datasets: [{
                data: selData,
                backgroundColor: [
                    '#296BBF', '#DA6C11', '#81807E', '#FACD05', '#56A5F5'
                ],
                hoverOffset: 10,

            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    display: true,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    anchor: 'center',
                    align: 'center',
                    offset: 10,
                    padding: {
                        top: 10,
                        bottom: 10,
                        left: 10,
                        right: 10
                    },
                    formatter: (value, context) => {

                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(2);
                        return `${value} : (${percentage}%)`;
                    },

                },
                title: {
                    display: true,
                    text: `Social Emotional Learning Competencies for ${studentName}`,
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
                        label: function (context) {
                            const shortForm = selLabels[context.dataIndex];
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${shortForm}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            }
        },
        // plugins: [{

        //     id: '3d-pie-plugin',
        //     afterDatasetsDraw(chart) {
        //         const ctx = chart.ctx;
        //         const chartArea = chart.chartArea;
        //         const centerX = (chartArea.left + chartArea.right) / 2;
        //         const centerY = (chartArea.top + chartArea.bottom) / 2;
        //         const radius = Math.min((chartArea.right - chartArea.left) / 2, (chartArea.bottom - chartArea.top) / 2);
        //         const depth = 20; // Depth of the 3D effect
        //         const offset = 10; // Offset for the shadow

        //         // Draw shadows
        //         chart.data.datasets.forEach((dataset, datasetIndex) => {
        //             const meta = chart.getDatasetMeta(datasetIndex);
        //             meta.data.forEach((slice, index) => {
        //                 const startAngle = slice.startAngle;
        //                 const endAngle = slice.endAngle;
        //                 const midAngle = (startAngle + endAngle) / 2;
        //                 const x = Math.cos(midAngle) * radius;
        //                 const y = Math.sin(midAngle) * radius;

        //                 ctx.save();
        //                 ctx.translate(centerX, centerY + offset);
        //                 ctx.beginPath();
        //                 ctx.moveTo(0, 0);
        //                 ctx.lineTo(x, y);
        //                 ctx.lineTo(x, y + depth);
        //                 ctx.lineTo(0, depth);
        //                 ctx.closePath();
        //                 ctx.fillStyle = 'rgba(0, 0, 0, 0.2)';
        //                 ctx.fill();
        //                 ctx.restore();
        //             });
        //         });

        //         // Draw slices
        //         chart.data.datasets.forEach((dataset, datasetIndex) => {
        //             const meta = chart.getDatasetMeta(datasetIndex);
        //             meta.data.forEach((slice, index) => {
        //                 const startAngle = slice.startAngle;
        //                 const endAngle = slice.endAngle;
        //                 const midAngle = (startAngle + endAngle) / 2;
        //                 const x = Math.cos(midAngle) * radius;
        //                 const y = Math.sin(midAngle) * radius;

        //                 ctx.save();
        //                 ctx.translate(centerX, centerY);
        //                 ctx.beginPath();
        //                 ctx.moveTo(0, 0);
        //                 ctx.arc(0, 0, radius, startAngle, endAngle);
        //                 ctx.lineTo(0, 0);
        //                 ctx.closePath();
        //                 ctx.fillStyle = dataset.backgroundColor[index];
        //                 ctx.fill();
        //                 ctx.restore();

        //                 // Draw the 3D sides
        //                 ctx.save();
        //                 ctx.translate(centerX, centerY);
        //                 ctx.beginPath();
        //                 ctx.moveTo(0, 0);
        //                 ctx.lineTo(x, y);
        //                 ctx.lineTo(x, y + depth);
        //                 ctx.lineTo(0, depth);
        //                 ctx.closePath();
        //                 ctx.fillStyle = dataset.backgroundColor[index];
        //                 ctx.fill();
        //                 ctx.restore();
        //             });
        //         });

        //         // Draw top slice
        //         chart.data.datasets.forEach((dataset, datasetIndex) => {
        //             const meta = chart.getDatasetMeta(datasetIndex);
        //             meta.data.forEach((slice, index) => {
        //                 const startAngle = slice.startAngle;
        //                 const endAngle = slice.endAngle;

        //                 ctx.save();
        //                 ctx.translate(centerX, centerY);
        //                 ctx.beginPath();
        //                 ctx.arc(0, 0, radius, startAngle, endAngle);
        //                 ctx.lineTo(0, 0);
        //                 ctx.closePath();
        //                 ctx.fillStyle = dataset.backgroundColor[index];
        //                 ctx.fill();
        //                 ctx.restore();
        //             });
        //         });
        //     }
        // }]
    });




    // CHARACTER STREGTHS BARCHART
    const csBarChart = document.getElementById('csBarChart').getContext('2d');

    // Assuming studentData is an array of objects, each containing a 'character_strength' and 'score' property
    const months = ['First Month', 'Second Month', 'Third Month'];

    // Divide the studentData into 3 groups, each containing 4 scores (representing data for three months)
    const monthlyData = [];
    for (let i = 0; i < studentData.length; i += 4) {
        monthlyData.push(studentData.slice(i, i + 4));
    }

    // Extract unique character strengths
    const csLabels = [...new Set(studentData.map(theme => theme.character_strength))];

    // Map data to months and character strengths
    const csData = csLabels.map(label => {
        return monthlyData.map(monthData => {
            // Find the score corresponding to the character strength for the current month
            const item = monthData.find(theme => theme.character_strength === label);
            return item ? item.score : 0; // If not found, default to 0
        });
    });

    // Data for the chart
    const chartData = {
        labels: months,
        datasets: csLabels.map((label, index) => ({
            label: label,
            backgroundColor: ['#296BBF', '#DA6C11', '#81807E'][index],
            data: csData[index]
        }))
    };

    new Chart(csBarChart, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    anchor: 'end',
                    align: 'top',
                    offset: 5
                },
                title: {
                    display: true,
                    text: 'Character Strengths by Month',
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
                    callbacks: {
                        label: function (context) {
                            const label = context.dataset.label || '';
                            const value = context.raw;
                            return `${label}: ${value}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    ticks: {
                        color: 'white',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    stacked: false,
                    ticks: {
                        color: 'white',
                        font: {
                            weight: 'bold'
                        },
                        stepSize: 1
                    },
                    max: 9
                }
            }
        }
    });
});