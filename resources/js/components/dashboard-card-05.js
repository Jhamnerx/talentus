/* eslint-disable prefer-destructuring */
// Import Chart.js
import {
  Chart, LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip,
} from 'chart.js';
import 'chartjs-adapter-moment';

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
const dashboardCard05 = () => {
  const ctx = document.getElementById('dashboard-card-05');
  if (!ctx) return;
  // Fake real-time data
  const data = [
    57.81, 57.75, 55.48, 54.28, 53.14, 52.25, 51.04, 52.49, 55.49, 56.87,
    53.73, 56.42, 58.06, 55.62, 58.16, 55.22, 58.67, 60.18, 61.31, 63.25,
    65.91, 64.44, 65.97, 62.27, 60.96, 59.34, 55.07, 59.85, 53.79, 51.92,
    50.95, 49.65, 48.09, 49.81, 47.85, 49.52, 50.21, 52.22, 54.42, 53.42,
    50.91, 58.52, 53.37, 57.58, 59.09, 59.36, 58.71, 59.42, 55.93, 57.71,
    50.62, 56.28, 57.37, 53.08, 55.94, 55.82, 53.94, 52.65, 50.25,
  ];
  // Fake real-time labels
  const generateDates = () => {
    const now = new Date();
    const dates = [];
    data.forEach((v, i) => {
      dates.push(new Date(now - 2000 - i * 2000));
    });
    return dates;
  };
  const labels = generateDates();
  let range = 35;
  let increment = 0;
  const slicedData = data.slice(0, range);
  const slicedLabels = labels.slice(0, range).reverse();

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: slicedLabels,
      datasets: [
        // Indigo line
        {
          data: slicedData,
          fill: true,
          backgroundColor: `rgba(${hexToRGB(fullConfig.theme.colors.blue[500])}, 0.08)`,
          borderColor: fullConfig.theme.colors.indigo[500],
          borderWidth: 2,
          tension: 0,
          pointRadius: 0,
          pointHoverRadius: 3,
          pointBackgroundColor: fullConfig.theme.colors.indigo[500],
          clip: 20,
        },
      ],
    },
    options: {
      layout: {
        padding: 20,
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
          },
          suggestedMin: 30,
          suggestedMax: 80,
          ticks: {
            maxTicksLimit: 5,
            callback: (value) => formatValue(value),
          },
        },
        x: {
          type: 'time',
          time: {
            parser: 'hh:mm:ss',
            unit: 'second',
            tooltipFormat: 'MMM DD, H:mm:ss a',
            displayFormats: {
              second: 'H:mm:ss',
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
          titleFont: {
            weight: '600',
          },
          callbacks: {
            label: (context) => formatValue(context.parsed.y),
          },
        },
      },
      interaction: {
        intersect: false,
        mode: 'nearest',
      },
      animation: false,
      maintainAspectRatio: false,
    },
  });

  // Fake real-time
  // For demo purposes only!
  const chartValue = document.getElementById('dashboard-card-05-value');
  const chartDeviation = document.getElementById('dashboard-card-05-deviation');

  const adddata = (value = NaN, prev) => {
    const { datasets } = chart.data;
    chart.data.labels.shift();
    chart.data.labels.push(new Date());
    datasets[0].data.shift();
    datasets[0].data.push(value);
    chart.update(0);
    if (!chartValue) return;
    const diff = ((value - prev) / prev) * 100;
    chartValue.innerHTML = value;
    if (!chartDeviation) return;
    if (diff < 0) {
      chartDeviation.style.backgroundColor = fullConfig.theme.colors.yellow[500];
    } else {
      chartDeviation.style.backgroundColor = fullConfig.theme.colors.emerald[500];
    }
    chartDeviation.innerHTML = `${diff > 0 ? '+' : ''}${diff.toFixed(2)}%`;
  };

  const reload = () => {
    increment += 1;
    if (increment + range - 1 < data.length) {
      adddata(data[increment + range - 1], data[increment + range - 2]);
    } else {
      increment = 0;
      range = 1;
      adddata(data[increment + range - 1], data[data.length - 1]);
    }
    setTimeout(reload, 2000);
  };
  reload();
};

export default dashboardCard05;
