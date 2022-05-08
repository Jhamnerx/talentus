/* eslint-disable prefer-destructuring */
/* eslint-disable max-len */
// Import Chart.js
import {
  Chart, PieController, ArcElement, TimeScale, Tooltip,
} from 'chart.js';
import 'chartjs-adapter-moment';

// Import TailwindCSS variables
import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../../../tailwind.config';

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(PieController, ArcElement, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const fintechCard09 = () => {
  const ctx = document.getElementById('fintech-card-09');
  if (!ctx) return;
  // eslint-disable-next-line no-unused-vars
  const chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Cash', 'Commodities', 'Bonds', 'Stock'],
      datasets: [
        {
          label: 'Sessions By Device',
          data: [
            12, 13, 10, 65,
          ],
          backgroundColor: [
            fullConfig.theme.colors.emerald[400],
            fullConfig.theme.colors.yellow[400],
            fullConfig.theme.colors.sky[400],
            fullConfig.theme.colors.indigo[500],
          ],
          hoverBackgroundColor: [
            fullConfig.theme.colors.emerald[500],
            fullConfig.theme.colors.yellow[500],
            fullConfig.theme.colors.sky[500],
            fullConfig.theme.colors.indigo[600],
          ],
          borderWidth: 0,
        },
      ],
    },
    options: {
      layout: {
        padding: {
          top: 4,
          bottom: 4,
          left: 24,
          right: 24,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        htmlLegend: {
          // ID of the container to put the legend in
          containerID: 'fintech-card-09-legend',
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
          li.style.margin = fullConfig.theme.margin[1.5];
          // Button element
          const button = document.createElement('button');
          button.style.display = 'inline-flex';
          button.style.alignItems = 'center';
          button.style.opacity = item.hidden ? '.3' : '';
          button.onclick = () => {
            c.toggleDataVisibility(item.index, !item.index);
            c.update();
          };
          // Color box
          const box = document.createElement('span');
          box.style.display = 'block';
          box.style.width = fullConfig.theme.width[3];
          box.style.height = fullConfig.theme.height[3];
          box.style.borderRadius = fullConfig.theme.borderRadius.full;
          box.style.marginRight = fullConfig.theme.margin[1.5];
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

export default fintechCard09;
