// Mapping of short forms to full forms
const wordMap = {
  Flexi: "Flexibility",
  Deter: "Determination",
  Adapt: "Adaptability",
  Grit: "Grit",
  Endu: "Endurance",
  Team: "Teamwork",
  Posit: "Positivity",
  Collab: "Collaboration",
  "Prob Solv": "Problem-Solving",
  "Self Cont": "Self-Control",
  Comm: "Communication",
  "Self Conf": "Self-Confidence",
  Opti: "Optimism",
  Curi: "Curiosity",
  Empat: "Empathy",
  Grat: "Gratitude",
  Proacti: "Proactivity",
  "Deci Maki": "Decision Making",
  Kind: "Kindness",
  Hone: "Honesty",
  "Grow Mind": "Growth Mindset",
  "Purp.": "Purpose",
  "No Fail": "No Failure",
  Expe: "Experience",
};

// Mapping of character strength codes to full descriptions
const characterStrengthMap = {
  SW: "Strength of Will",
  SH: "Strength of Heart",
  SM: "Strength of Mind",
};

// Function to map a single short form to full form
function mapWord(shortForm) {
  return wordMap[shortForm] || shortForm;
}

// Function to map character strength code to full description
function mapCharacterStrength(code) {
  return characterStrengthMap[code] || code;
}

// Register plugin globally
Chart.register(ChartDataLabels);

// global background plugin
Chart.defaults.plugins.background = {
  color: "#000000",
};

// Custom plugin to ensure background rendering
const backgroundPlugin = {
  id: "custom_canvas_background_color",
  beforeDraw: (chart) => {
    const ctx = chart.canvas.getContext("2d");
    ctx.save();
    ctx.globalCompositeOperation = "destination-over";
    ctx.fillStyle = chart.config.options.plugins.background.color || "#000000";
    ctx.fillRect(0, 0, chart.width, chart.height);
    ctx.restore();
  },
};

document.addEventListener("DOMContentLoaded", function () {
  // KEQ Bar Chart
  const keqBarChart = document.getElementById("keqBarChart").getContext("2d");

  // Map the short form labels to full form before using them
  const shortLabels = studentData.map((theme) => theme.theme_name);
  const labels = shortLabels.map((label) => mapWord(label));

  const baseData = new Array(labels.length).fill(50);
  const improvementData = studentData.map((theme) => Math.max(theme.score));
  const targetData = studentData.map((theme) => Math.max(50 - theme.score, 0));

  new Chart(keqBarChart, {
    type: "bar",
    plugins: [backgroundPlugin],
    data: {
      labels: labels,
      datasets: [
        {
          label: "Base",
          backgroundColor: "#6CD65D",
          borderWidth: 1,
          data: baseData,
        },
        {
          label: "Improvement",
          backgroundColor: "#47B2E0",
          borderWidth: 1,
          data: improvementData,
        },
        {
          label: "Target",
          backgroundColor: "#F6D23E",
          borderWidth: 1,
          data: targetData,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        background: {
          color: "#000000",
        },
        datalabels: {
          color: "#000000",
          font: {
            weight: "bold",
            size: 14,
          },
          formatter: (value) => value,
          anchor: "center",
          align: "center",
          offset: 0,
          padding: 0,
        },
        title: {
          display: true,
          text: `Kinesthetic Emotional Intelligence Quotient (KEQ) for ${studentName}`,
          color: "#FFFFFF",
          font: {
            size: 18,
            weight: "bold",
          },
          padding: {
            top: 10,
            bottom: 30,
          },
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
          },
        },
        tooltip: {
          mode: "index",
          intersect: false,
          callbacks: {
            label: function (context) {
              return `${context.dataset.label}: ${context.parsed.y}%`;
            },
          },
        },
      },
      scales: {
        x: {
          stacked: true,
          ticks: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
          },
        },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
            callback: (value) => `${value}%`,
          },
          max: 100,
        },
      },
    },
  });

  // SEL Pie Chart
  const shortCompetencyMap = {
    RDM: "Responsible Decision Making",
    SOA: "Social Awareness",
    SEA: "Self Awareness",
    RS: "Relationship Skills",
    SM: "Self Management",
  };

  const competencyMap = (shortForms) =>
    shortForms.map((form) => shortCompetencyMap[form] || form);

  const selPieChart = document.getElementById("selPieChart").getContext("2d");
  const selLabels = [...new Set(studentData.map((theme) => theme.competency))];
  const fullSelLabels = competencyMap(selLabels);
  const selData = selLabels.map((competency) => {
    const scores = studentData
      .filter((theme) => theme.competency === competency)
      .map((theme) => theme.score)
      .sort((a, b) => b - a)
      .slice(0, 2)
      .reduce((sum, score) => sum + score, 0);
    return scores;
  });

  new Chart(selPieChart, {
    type: "pie",
    plugins: [backgroundPlugin],
    data: {
      labels: fullSelLabels,
      datasets: [
        {
          data: selData,
          backgroundColor: [
            "#296BBF",
            "#DA6C11",
            "#81807E",
            "#FACD05",
            "#56A5F5",
          ],
          hoverOffset: 10,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        background: {
          color: "#000000",
        },
        datalabels: {
          display: true,
          color: "#FFFFFF",
          font: {
            weight: "bold",
          },
          formatter: (value, context) => {
            const total = context.chart.data.datasets[0].data.reduce(
              (a, b) => a + b,
              0
            );
            const percentage = ((value / total) * 100).toFixed(2);
            return `${value} (${percentage}%)`;
          },
        },
        title: {
          display: true,
          text: `Social Emotional Learning Competencies for ${studentName}`,
          color: "#FFFFFF",
          font: {
            size: 30,
            weight: "bold",
          },
          padding: {
            top: 10,
            bottom: 30,
          },
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
          },
        },
      },
    },
  });

  // Character Strengths Bar Chart
  const csBarChart = document.getElementById("csBarChart").getContext("2d");
  const months = ["First Month", "Second Month", "Third Month"];
  const monthlyData = [];

  for (let i = 0; i < studentData.length; i += 4) {
    monthlyData.push(studentData.slice(i, i + 4));
  }

  const csLabels = [
    ...new Set(studentData.map((theme) => theme.character_strength)),
  ];
  const csData = csLabels.map((label) => {
    return monthlyData.map((monthData) => {
      const item = monthData.find(
        (theme) => theme.character_strength === label
      );
      return item ? item.score : 0;
    });
  });

  new Chart(csBarChart, {
    type: "bar",
    plugins: [backgroundPlugin],
    data: {
      labels: months,
      datasets: csLabels.map((label, index) => ({
        label: mapCharacterStrength(label), // Use the mapped label here
        backgroundColor: ["#296BBF", "#DA6C11", "#81807E"][index],
        data: csData[index],
      })),
    },
    options: {
      responsive: true,
      plugins: {
        background: {
          color: "#000000",
        },
        datalabels: {
          color: "#FFFFFF",
          font: {
            weight: "bold",
          },
          anchor: "end",
          align: "top",
          offset: 5,
        },
        title: {
          display: true,
          text: "Character Strengths by Month",
          color: "#FFFFFF",
          font: {
            size: 18,
            weight: "bold",
          },
          padding: {
            top: 10,
            bottom: 30,
          },
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
          },
        },
      },
      scales: {
        x: {
          stacked: false,
          ticks: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
          },
        },
        y: {
          beginAtZero: true,
          stacked: false,
          ticks: {
            color: "#FFFFFF",
            font: {
              weight: "bold",
            },
            stepSize: 1,
          },
          max: 9,
        },
      },
    },
  });
});
