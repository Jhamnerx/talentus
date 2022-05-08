/* eslint-disable prefer-destructuring */
// Import Chart.js
import {
  Chart, LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip,
} from 'chart.js';
// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';
// Import utilities
import { formatValue, hexToRGB } from '../utils';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const fintechCard07 = () => {
  const ctx = document.getElementById('fintech-card-07');
  if (!ctx) return;
  // eslint-disable-next-line no-unused-vars
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        '09-01-2021', '10-01-2021', '11-01-2021',
        '12-01-2021', '01-01-2022', '02-01-2022',
        '03-01-2022', '04-01-2022', '05-01-2022',
        '06-01-2022', '07-01-2022', '08-01-2022',
        '09-01-2022', '10-01-2022', '11-01-2022',
        '12-01-2022', '01-01-2023', '02-01-2023',
        '03-01-2023', '04-01-2023',
      ],
      datasets: [
        // Indigo line
        {
          label: 'Mosaic Portfolio',
          data: [
            1500, 2000, 1800, 1900, 1900, 2400, 2900, 2600, 3900, 2700,
            3500, 3200, 2900, 3500, 3600, 3400, 3900, 3600, 4100, 4100,
          ],
          borderColor: fullConfig.theme.colors.indigo[500],
          fill: true,
          backgroundColor: `rgba(${hexToRGB(fullConfig.theme.colors.blue[500])}, 0.08)`,
          borderWidth: 2,
          tension: 0,
          pointRadius: 0,
          pointHoverRadius: 3,
          pointBackgroundColor: fullConfig.theme.colors.indigo[500],
          clip: 20,
        },
        // Gray line
        {
          label: 'Expected Return',
          data: [
            2000, 2100, 2200, 2300, 2400, 2500, 2600, 2700, 2800, 2900,
            3000, 3100, 3200, 3300, 3400, 3500, 3600, 3700, 3800, 3900,
          ],
          borderColor: fullConfig.theme.colors.slate[300],
          fill: false,
          borderWidth: 2,
          tension: 0,
          pointRadius: 0,
          pointHoverRadius: 3,
          pointBackgroundColor: fullConfig.theme.colors.slate[300],
          clip: 20,
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
          beginAtZero: true,
          grid: {
            drawBorder: false,
          },
          ticks: {
            maxTicksLimit: 7,
            callback: (value) => formatValue(value),
          },
        },
        x: {
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
        tooltip: {
          callbacks: {
            title: () => false, // Disable tooltip title
            label: (context) => formatValue(context.parsed.y),
          },
        },
        legend: {
          display: false,
        },
      },
      interaction: {
        intersect: false,
        mode: 'nearest',
      },
      maintainAspectRatio: false,
    },
  });
};

export default fintechCard07;
