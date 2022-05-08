/* eslint-disable prefer-destructuring */
import {
  Chart, BarController, BarElement, LinearScale, CategoryScale, Tooltip, Legend,
} from 'chart.js';
// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';
// Import utilities
import { formatValue } from '../utils';
// Import images
import revolutIcon from '../../images/fintech-icon-01.svg';
import hsbcIcon from '../../images/fintech-icon-02.svg';
import qontoIcon from '../../images/fintech-icon-03.svg';
import n26Icon from '../../images/fintech-icon-04.svg';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(BarController, BarElement, LinearScale, CategoryScale, Tooltip, Legend);
const images = [revolutIcon, hsbcIcon, qontoIcon, n26Icon];

// A chart built with Chart.js 3
// https://www.chartjs.org/
const analyticsCard04 = () => {
  const ctx = document.getElementById('fintech-card-04');
  if (!ctx) return;
  // eslint-disable-next-line no-unused-vars
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        '02-01-2021', '03-01-2021', '04-01-2021', '05-01-2021',
      ],
      datasets: [
        // Indigo bars
        {
          label: 'Inflow',
          data: [
            4100, 1900, 2700, 3900,
          ],
          backgroundColor: fullConfig.theme.colors.indigo[500],
          hoverBackgroundColor: fullConfig.theme.colors.indigo[600],
          categoryPercentage: 0.66,
        },
        // Gray bars
        {
          label: 'Outflow',
          data: [
            2000, 1000, 1100, 2600,
          ],
          backgroundColor: fullConfig.theme.colors.slate[300],
          hoverBackgroundColor: fullConfig.theme.colors.slate[400],
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
          left: 72,
          right: 20,
        },
      },
      scales: {
        y: {
          grid: {
            display: false,
            drawBorder: false,
            drawTicks: false,
          },
          ticks: {
            display: false,
          },
        },
        x: {
          grid: {
            drawBorder: false,
          },
          ticks: {
            maxTicksLimit: 3,
            align: 'end',
            callback: (value) => formatValue(value),
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        htmlLegend: {
          // ID of the container to put the legend in
          containerID: 'fintech-card-04-legend',
        },
        tooltip: {
          callbacks: {
            title: () => false, // Disable tooltip title
            label: (context) => formatValue(context.parsed.x),
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
      afterDraw(c) {
        const xAxis = c.scales.x;
        const yAxis = c.scales.y;
        yAxis.ticks.forEach((value, index) => {
          const y = yAxis.getPixelForTick(index);
          const image = new Image();
          image.src = images[index];
          c.ctx.drawImage(image, xAxis.left - 52, y - 18);
        });
      },
    }],
  });
};

export default analyticsCard04;
