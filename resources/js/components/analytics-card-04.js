/* eslint-disable prefer-destructuring */
import {
  Chart, BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend,
} from 'chart.js';
// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';
// Import utilities
import { formatThousands } from '../utils';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const analyticsCard04 = () => {
  const ctx = document.getElementById('analytics-card-04');
  if (!ctx) return;
  // eslint-disable-next-line no-unused-vars
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        '02-01-2021', '03-01-2021', '04-01-2021', '05-01-2021',
      ],
      datasets: [
        // Blue bars
        {
          label: 'New Visitors',
          data: [
            8000, 3800, 5350, 7800,
          ],
          backgroundColor: fullConfig.theme.colors.indigo[500],
          hoverBackgroundColor: fullConfig.theme.colors.indigo[600],
          categoryPercentage: 0.66,
        },
        // Light blue bars
        {
          label: 'Returning Visitors',
          data: [
            4000, 6500, 2200, 5800,
          ],
          backgroundColor: fullConfig.theme.colors.sky[400],
          hoverBackgroundColor: fullConfig.theme.colors.sky[500],
          categoryPercentage: 0.66,
        },
      ],
    },
    options: {
      indexAxis: 'y',
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
          type: 'time',
          time: {
            parser: 'MM-DD-YYYY',
            unit: 'month',
            displayFormats: {
              month: 'MMM',
            },
          },
          grid: {
            display: false,
            drawBorder: false,
          },
        },
        x: {
          grid: {
            drawBorder: false,
          },
          ticks: {
            maxTicksLimit: 3,
            align: 'end',
            callback: (value) => formatThousands(value),
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        htmlLegend: {
          // ID of the container to put the legend in
          containerID: 'analytics-card-04-legend',
        },
        tooltip: {
          callbacks: {
            title: () => false, // Disable tooltip title
            label: (context) => formatThousands(context.parsed.x),
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
    plugins: [{
      id: 'htmlLegend',
      afterUpdate(c, args, options) {
        const legendContainer = document.getElementById(options.containerID);
        const ul = legendContainer.querySelector('ul');
        if (!ul) return;
        // Remove old legend items
        while (ul.firstChild) {
          ul.firstChild.remove();
        }
        // Reuse the built-in legendItems generator
        const items = c.options.plugins.legend.labels.generateLabels(c);
        items.forEach((item) => {
          const li = document.createElement('li');
          li.style.marginRight = fullConfig.theme.margin[4];
          // Button element
          const button = document.createElement('button');
          button.style.display = 'inline-flex';
          button.style.alignItems = 'center';
          button.style.opacity = item.hidden ? '.3' : '';
          button.onclick = () => {
            c.setDatasetVisibility(item.datasetIndex, !c.isDatasetVisible(item.datasetIndex));
            c.update();
          };
          // Color box
          const box = document.createElement('span');
          box.style.display = 'block';
          box.style.width = fullConfig.theme.width[3];
          box.style.height = fullConfig.theme.height[3];
          box.style.borderRadius = fullConfig.theme.borderRadius.full;
          box.style.marginRight = fullConfig.theme.margin[2];
          box.style.borderWidth = '3px';
          box.style.borderColor = item.fillStyle;
          box.style.pointerEvents = 'none';
          // Label
          const label = document.createElement('span');
          label.style.color = fullConfig.theme.colors.slate[500];
          label.style.fontSize = fullConfig.theme.fontSize.sm[0];
          label.style.lineHeight = fullConfig.theme.fontSize.sm[1].lineHeight;
          const labelText = document.createTextNode(item.text);
          label.appendChild(labelText);
          li.appendChild(button);
          button.appendChild(box);
          button.appendChild(label);
          ul.appendChild(li);
        });
      },
    }],
  });
};

export default analyticsCard04;
