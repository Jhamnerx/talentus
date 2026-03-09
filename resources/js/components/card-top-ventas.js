/* eslint-disable prefer-destructuring */
/* eslint-disable max-len */
// Import Chart.js
import {
    Chart,
    DoughnutController,
    ArcElement,
    TimeScale,
    Tooltip,
} from "chart.js";
import "chartjs-adapter-moment";

// Import utilities
import { getCssVariable } from "../utils";

Chart.register(DoughnutController, ArcElement, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const CardVentas = () => {
    const ctx = document.getElementById("dashboard-card-06");
    if (!ctx) return;

    const darkMode = localStorage.getItem("dark-mode") === "true";

    // eslint-disable-next-line no-unused-vars
    const chart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["United States", "Italy", "Other"],
            datasets: [
                {
                    label: "Top Countries",
                    data: [35, 30, 35],
                    backgroundColor: [
                        getCssVariable("--color-indigo-500"),
                        getCssVariable("--color-blue-400"),
                        getCssVariable("--color-indigo-800"),
                    ],
                    hoverBackgroundColor: [
                        getCssVariable("--color-indigo-600"),
                        getCssVariable("--color-blue-500"),
                        getCssVariable("--color-indigo-900"),
                    ],
                    hoverBorderColor: getCssVariable("--color-white"),
                },
            ],
        },
        options: {
            cutout: "80%",
            layout: {
                padding: 24,
            },
            plugins: {
                legend: {
                    display: false,
                },
                htmlLegend: {
                    // ID of the container to put the legend in
                    containerID: "dashboard-card-06-legend",
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
                        c.options.plugins.legend.labels.generateLabels(c);
                    items.forEach((item) => {
                        const li = document.createElement("li");
                        li.style.margin = "0.25rem";
                        // Button element
                        const button = document.createElement("button");
                        button.classList.add("btn-xs");
                        button.style.backgroundColor = darkMode
                            ? "#1E293B"
                            : "#ffffff";
                        button.style.borderWidth = "1px";
                        button.style.borderColor = darkMode
                            ? "#475569"
                            : "#E2E8F0";
                        button.style.color = darkMode ? "#94A3B8" : "#64748B";
                        button.style.boxShadow =
                            "0 4px 6px -1px rgb(0 0 0 / 0.1)";
                        button.style.opacity = item.hidden ? ".3" : "";
                        button.onclick = () => {
                            c.toggleDataVisibility(item.index, !item.index);
                            c.update();
                        };
                        // Color box
                        const box = document.createElement("span");
                        box.style.display = "block";
                        box.style.width = "0.5rem";
                        box.style.height = "0.5rem";
                        box.style.backgroundColor = item.fillStyle;
                        box.style.borderRadius = "0.125rem";
                        box.style.marginRight = "0.25rem";
                        box.style.pointerEvents = "none";
                        // Label
                        const label = document.createElement("span");
                        label.style.display = "flex";
                        label.style.alignItems = "center";
                        const labelText = document.createTextNode(item.text);
                        label.appendChild(labelText);
                        li.appendChild(button);
                        button.appendChild(box);
                        button.appendChild(label);
                        ul.appendChild(li);
                    });
                },
            },
        ],
    });
};

export default CardVentas;
