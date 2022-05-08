// Import Chart.js
import {
  Chart, BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend,
} from 'chart.js';
// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';
// Import utilities
import { formatValue } from '../utils';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const dashboardCard09 = () => {
  const ctx = document.getElementById('dashboard-card-09');
  if (!ctx) return;
  // eslint-disable-next-line no-unused-vars
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        '12-01-2020', '01-01-2021', '02-01-2021',
        '03-01-2021', '04-01-2021', '05-01-2021',
      ],
      datasets: [
        // Light blue bars
        {
          label: 'Stack 1',
          data: [
            6200, 9200, 6600, 8800, 5200, 9200,
          ],
          backgroundColor: fullConfig.theme.colors.indigo[500],
          hoverBackgroundColor: fullConfig.theme.colors.indigo[600],
          barPercentage: 0.66,
          categoryPercentage: 0.66,
        },
        // Blue bars
        {
          label: 'Stack 2',
          data: [
            -4000, -2600, -5350, -4000, -7500, -2000,
          ],
          backgroundColor: fullConfig.theme.colors.indigo[200],
          hoverBackgroundColor: fullConfig.theme.colors.indigo[300],
          barPercentage: 0.66,
          categoryPercentage: 0.66,
        },
      ],
    },
    options: {
      layout: {
        padding: {
          top: 12,
          bottom: 16,
          left: 20,
          right: 20,
        },
      },
      scales: {
        y: {
          stacked: true,
          grid: {
            drawBorder: false,
          },
          beginAtZero: true,
          ticks: {
            maxTicksLimit: 5,
            callback: (value) => formatValue(value),
          },
        },
        x: {
          stacked: true,
          type: 'time',
          time: {
            parser: 'MM-DD-YYYY',
            unit: 'month',
            displayFormats: {
              month: 'MMM YY',
            },
          },
          grid: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            autoSkipPadding: 48,
            maxRotation: 0,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          callbacks: {
            title: () => false, // Disable tooltip title
            label: (context) => formatValue(context.parsed.y),
          },
        },
      },
      interaction: {
        intersect: false,
        mode: 'nearest',
      },
      animation: {
        duration: 200,
      },
      maintainAspectRatio: false,
    },
  });
};

export default dashboardCard09;
