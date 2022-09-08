// Import Chart.js
import {
    Chart,
    BarController,
    BarElement,
    LinearScale,
    TimeScale,
    Tooltip,
    Legend,
} from "chart.js";

// Import utilities
// Import TailwindCSS variables
import resolveConfig from "tailwindcss/resolveConfig";
import tailwindConfig from "../../../tailwind.config";
// Import utilities
import { formatValue, hexToRGB } from "../utils";

// Tailwind config
const fullConfig = resolveConfig(tailwindConfig);

Chart.register(
    BarController,
    BarElement,
    LinearScale,
    TimeScale,
    Tooltip,
    Legend
);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const dashboardCard04 = () => {
    const ctx = document.getElementById("dashboard-card-04");
    if (!ctx) return;

    fetch("/admin/json-data-feed")
        .then((a) => {
            return a.json();
        })
        .then((result) => {
            const dataset1 = result.data.facturas.totales;
            const dataset2 = result.data.recibos.totales;

            const chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: result.labels,
                    datasets: [
                        // Light blue bars
                        {
                            label: "Facturas",
                            data: dataset1,
                            // data: [
                            //     800, 1600, 900, 1300, 1950, 1700,
                            // ],
                            backgroundColor: fullConfig.theme.colors.blue[400],
                            hoverBackgroundColor:
                                fullConfig.theme.colors.blue[500],
                            barPercentage: 0.66,
                            categoryPercentage: 0.66,
                        },
                        // Blue bars
                        {
                            label: "Recibos",
                            data: dataset2,
                            // data: [
                            //     4900, 2600, 5350, 4800, 5200, 4800,
                            // ],
                            backgroundColor:
                                fullConfig.theme.colors.indigo[500],
                            hoverBackgroundColor:
                                fullConfig.theme.colors.indigo[600],
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
                            grid: {
                                drawBorder: false,
                            },
                            ticks: {
                                maxTicksLimit: 5,
                                callback: (value) => formatValue(value),
                            },
                        },
                        x: {
                            type: "time",
                            time: {
                                parser: "MM-DD-YYYY",
                                unit: "month",
                                displayFormats: {
                                    month: "MMM YY",
                                },
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        htmlLegend: {
                            // ID of the container to put the legend in
                            containerID: "dashboard-card-04-legend",
                        },
                        tooltip: {
                            callbacks: {
                                title: () => false, // Disable tooltip title
                                label: (context) =>
                                    formatValue(context.parsed.y),
                            },
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "nearest",
                    },
                    animation: {
                        duration: 200,
                    },
                    maintainAspectRatio: false,
                },
                plugins: [
                    {
                        id: "htmlLegend",
                        afterUpdate(c, args, options) {
                            const legendContainer = document.getElementById(
                                options.containerID
                            );
                            const ul = legendContainer.querySelector("ul");
                            if (!ul) return;
                            // Remove old legend items
                            while (ul.firstChild) {
                                ul.firstChild.remove();
                            }
                            // Reuse the built-in legendItems generator
                            const items =
                                c.options.plugins.legend.labels.generateLabels(
                                    c
                                );
                            items.forEach((item) => {
                                const li = document.createElement("li");
                                li.style.marginRight =
                                    fullConfig.theme.margin[4];
                                // Button element
                                const button = document.createElement("button");
                                button.style.display = "inline-flex";
                                button.style.alignItems = "center";
                                button.style.opacity = item.hidden ? ".3" : "";
                                button.onclick = () => {
                                    c.setDatasetVisibility(
                                        item.datasetIndex,
                                        !c.isDatasetVisible(item.datasetIndex)
                                    );
                                    c.update();
                                };
                                // Color box
                                const box = document.createElement("span");
                                box.style.display = "block";
                                box.style.width = fullConfig.theme.width[3];
                                box.style.height = fullConfig.theme.height[3];
                                box.style.borderRadius =
                                    fullConfig.theme.borderRadius.full;
                                box.style.marginRight =
                                    fullConfig.theme.margin[2];
                                box.style.borderWidth = "3px";
                                box.style.borderColor = item.fillStyle;
                                box.style.pointerEvents = "none";
                                // Label
                                const labelContainer =
                                    document.createElement("span");
                                labelContainer.style.display = "flex";
                                labelContainer.style.alignItems = "center";
                                const value = document.createElement("span");
                                value.style.color =
                                    fullConfig.theme.colors.slate[800];
                                value.style.fontSize =
                                    fullConfig.theme.fontSize["3xl"][0];
                                value.style.lineHeight =
                                    fullConfig.theme.fontSize[
                                        "3xl"
                                    ][1].lineHeight;
                                value.style.fontWeight =
                                    fullConfig.theme.fontWeight.bold;
                                value.style.marginRight =
                                    fullConfig.theme.margin[2];
                                value.style.pointerEvents = "none";
                                const label = document.createElement("span");
                                label.style.color =
                                    fullConfig.theme.colors.slate[500];
                                label.style.fontSize =
                                    fullConfig.theme.fontSize.sm[0];
                                label.style.lineHeight =
                                    fullConfig.theme.fontSize.sm[1].lineHeight;
                                const theValue = c.data.datasets[
                                    item.datasetIndex
                                ].data.reduce((a, b) => a + b, 0);
                                const valueText = document.createTextNode(
                                    formatValue(theValue)
                                );
                                const labelText = document.createTextNode(
                                    item.text
                                );
                                value.appendChild(valueText);
                                label.appendChild(labelText);
                                li.appendChild(button);
                                button.appendChild(box);
                                button.appendChild(labelContainer);
                                labelContainer.appendChild(value);
                                labelContainer.appendChild(label);
                                ul.appendChild(li);
                            });
                        },
                    },
                ],
            });
        });
};

export default dashboardCard04;
