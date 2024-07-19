// KEQ Bar Chart
const keqBarChart = document.getElementById('keqBarChart').getContext('2d');
new Chart(keqBarChart, {
    type: 'bar',
    data: {
        labels: ['Decision Making', 'Teamwork', 'Determination', 'Problem-solving', 'No Failure', 'Curiosity', 'Optimism', 'Self-confidence', 'Honesty', 'Experience', 'Kindness'],
        datasets: [
            {
                label: 'Base',
                backgroundColor: '#6CD65D',
                borderWidth: 1,
                data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
            },
            {
                label: 'Improvement',
                backgroundColor: '#47B2E0',
                borderWidth: 1,
                data: [8, 9, 9, 4, 8, 5, 7, 9, 9, 5, 7]
            },
            {
                label: 'Target',
                backgroundColor: '#F6D23E',
                borderWidth: 1,
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
            '#296BBF', //self awareness
            '#DA6C11', //Self Management
            '#81807E', // Social Awareness
            '#FACD05', // Relationship Skills
            '#56A5F5' // Responsible Decision Making
            ],
            hoverOffset: 10
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
    plugins: [{
        id: '3d-pie-plugin',
        afterDatasetsDraw(chart) {
            const ctx = chart.ctx;
            const chartArea = chart.chartArea;
            const centerX = (chartArea.left + chartArea.right) / 2;
            const centerY = (chartArea.top + chartArea.bottom) / 2;
            const radius = Math.min((chartArea.right - chartArea.left) / 2, (chartArea.bottom - chartArea.top) / 2);
            const depth = 20; // Depth of the 3D effect
            const offset = 10; // Offset for the shadow

            // Draw shadows
            chart.data.datasets.forEach((dataset, datasetIndex) => {
                const meta = chart.getDatasetMeta(datasetIndex);
                meta.data.forEach((slice, index) => {
                    const startAngle = slice.startAngle;
                    const endAngle = slice.endAngle;
                    const midAngle = (startAngle + endAngle) / 2;
                    const x = Math.cos(midAngle) * radius;
                    const y = Math.sin(midAngle) * radius;

                    ctx.save();
                    ctx.translate(centerX, centerY + offset);
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.lineTo(x, y);
                    ctx.lineTo(x, y + depth);
                    ctx.lineTo(0, depth);
                    ctx.closePath();
                    ctx.fillStyle = 'rgba(0, 0, 0, 0.2)';
                    ctx.fill();
                    ctx.restore();
                });
            });

            // Draw slices
            chart.data.datasets.forEach((dataset, datasetIndex) => {
                const meta = chart.getDatasetMeta(datasetIndex);
                meta.data.forEach((slice, index) => {
                    const startAngle = slice.startAngle;
                    const endAngle = slice.endAngle;
                    const midAngle = (startAngle + endAngle) / 2;
                    const x = Math.cos(midAngle) * radius;
                    const y = Math.sin(midAngle) * radius;

                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.arc(0, 0, radius, startAngle, endAngle);
                    ctx.lineTo(0, 0);
                    ctx.closePath();
                    ctx.fillStyle = dataset.backgroundColor[index];
                    ctx.fill();
                    ctx.restore();

                    // Draw the 3D sides
                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.lineTo(x, y);
                    ctx.lineTo(x, y + depth);
                    ctx.lineTo(0, depth);
                    ctx.closePath();
                    ctx.fillStyle = dataset.backgroundColor[index];
                    ctx.fill();
                    ctx.restore();
                });
            });

            // Draw top slice
            chart.data.datasets.forEach((dataset, datasetIndex) => {
                const meta = chart.getDatasetMeta(datasetIndex);
                meta.data.forEach((slice, index) => {
                    const startAngle = slice.startAngle;
                    const endAngle = slice.endAngle;

                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.beginPath();
                    ctx.arc(0, 0, radius, startAngle, endAngle);
                    ctx.lineTo(0, 0);
                    ctx.closePath();
                    ctx.fillStyle = dataset.backgroundColor[index];
                    ctx.fill();
                    ctx.restore();
                });
            });
        }
    }]
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
                backgroundColor: '#296BBF',
                data: [9, 9, 7]
            },
            {
                label: 'Mind (SM)',
                backgroundColor: '#DA6C11',
                data: [8, 4, 9]
            },
            {
                label: 'Will (SW)',
                backgroundColor: '#81807E',
                data: [9, 8, 5]
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'CHARACTER STRENGTHS',
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
        },
        layout: {
            padding: {
                left: 10,
                right: 10,
                top: 10,
                bottom: 10
            }
        }
    }
});