// Import Chart.js
import {
  Chart, LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip,
} from 'chart.js';
import 'chartjs-adapter-moment';

// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';
// Import utilities
import { formatValue } from '../utils';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const fintechCard14 = () => {
  const miniCharts = [
    // Twitter
    {
      selector: 'fintech-card-14-a',
      data: [
        540, 466, 540, 466, 385, 432, 334,
        334, 289, 289, 200, 289, 222, 289,
        289, 403, 554, 304, 289, 270, 134,
        270, 829, 644, 688, 664,
      ],
      growth: true,
    },
    // Facebook
    {
      selector: 'fintech-card-14-b',
      data: [
        245, 288, 332, 404, 404, 314, 314,
        314, 314, 314, 234, 314, 234, 234,
        314, 314, 314, 388, 314, 202, 202,
        202, 202, 514, 720, 642,
      ],
      growth: true,
    },
    // Google
    {
      selector: 'fintech-card-14-c',
      data: [
        732, 610, 610, 504, 504, 504, 349,
        349, 504, 342, 504, 610, 391, 192,
        154, 273, 191, 191, 126, 263, 349,
        252, 323, 322, 270, 232,
      ],
      growth: false,
    },
    // Apple
    {
      selector: 'fintech-card-14-d',
      data: [
        222, 222, 226, 271, 365, 365, 238,
        324, 288, 206, 324, 324, 500, 409,
        409, 273, 232, 273, 500, 570, 767,
        808, 685, 767, 685, 685,
      ],
      growth: true,
    },
    // Coinbase
    {
      selector: 'fintech-card-14-e',
      data: [
        632, 510, 610, 404, 504, 404, 449,
        349, 404, 542, 404, 410, 491, 392,
        254, 273, 291, 191, 226, 363, 449,
        252, 223, 222, 170, 132,
      ],
      growth: false,
    },
  ];

  miniCharts.forEach((miniChart) => {
    const ctx = document.getElementById(miniChart.selector);
    if (!ctx) return;
    // eslint-disable-next-line no-unused-vars
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [
          '12-01-2020', '01-01-2021', '02-01-2021',
          '03-01-2021', '04-01-2021', '05-01-2021',
          '06-01-2021', '07-01-2021', '08-01-2021',
          '09-01-2021', '10-01-2021', '11-01-2021',
          '12-01-2021', '01-01-2022', '02-01-2022',
          '03-01-2022', '04-01-2022', '05-01-2022',
          '06-01-2022', '07-01-2022', '08-01-2022',
          '09-01-2022', '10-01-2022', '11-01-2022',
          '12-01-2022', '01-01-2023',
        ],
        datasets: [
          // Line
          {
            data: miniChart.data,
            // eslint-disable-next-line max-len
            borderColor: miniChart.growth ? fullConfig.theme.colors.emerald[500] : fullConfig.theme.colors.rose[500],
            borderWidth: 2,
            tension: 0,
            pointRadius: 0,
            pointHoverRadius: 3,
            // eslint-disable-next-line max-len
            pointBackgroundColor: miniChart.growth ? fullConfig.theme.colors.emerald[500] : fullConfig.theme.colors.rose[500],
            clip: 20,
          },
        ],
      },
      options: {
        scales: {
          y: {
            display: false,
            beginAtZero: true,
          },
          x: {
            type: 'time',
            time: {
              parser: 'MM-DD-YYYY',
              unit: 'month',
            },
            display: false,
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
  });
};

export default fintechCard14;
