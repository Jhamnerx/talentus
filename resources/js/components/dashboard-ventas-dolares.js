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
import { getCssVariable, adjustColorOpacity } from "../utils";

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
const cardVentaDolares = () => {
    const ctx = document.getElementById("card-ventas-dolares");
    if (!ctx) return;

    const darkMode = localStorage.getItem("dark-mode") === "true";

    const textColor = {
        light: "#9CA3AF",
        dark: "#6B7280",
    };

    const gridColor = {
        light: "#F3F4F6",
        dark: adjustColorOpacity("#374151", 0.6),
    };

    const tooltipBodyColor = {
        light: "#6B7280",
        dark: "#9CA3AF",
    };

    const tooltipBgColor = {
        light: "#ffffff",
        dark: "#374151",
    };

    const tooltipBorderColor = {
        light: "#E5E7EB",
        dark: "#4B5563",
    };

    fetch("/admin/json-data-ventas?divisa=usd")
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
                            backgroundColor: getCssVariable("--color-blue-400"),
                            hoverBackgroundColor:
                                getCssVariable("--color-blue-500"),
                            barPercentage: 0.66,
                            categoryPercentage: 0.66,
                        },
                        // Blue bars
                        {
                            label: "Recibos",
                            data: dataset2,
                            backgroundColor:
                                getCssVariable("--color-indigo-500"),
                            hoverBackgroundColor:
                                getCssVariable("--color-indigo-600"),
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
                            border: {
                                display: false,
                            },
                            grid: {
                                color: darkMode
                                    ? gridColor.dark
                                    : gridColor.light,
                            },
                            ticks: {
                                maxTicksLimit: 5,
                                callback: (value) =>
                                    value.toLocaleString("es-US", {
                                        style: "decimal",
                                    }),
                                color: darkMode
                                    ? textColor.dark
                                    : textColor.light,
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
                            border: {
                                display: false,
                            },
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: darkMode
                                    ? textColor.dark
                                    : textColor.light,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        htmlLegend: {
                            // ID of the container to put the legend in
                            containerID: "card-ventas-dolares-legend",
                        },
                        tooltip: {
                            callbacks: {
                                title: () => false, // Disable tooltip title
                                label: (context) =>
                                    context.parsed.y.toLocaleString("es-US", {
                                        style: "currency",
                                        currency: "USD",
                                        currencyDisplay: "symbol",
                                    }),
                            },
                            bodyColor: darkMode
                                ? tooltipBodyColor.dark
                                : tooltipBodyColor.light,
                            backgroundColor: darkMode
                                ? tooltipBgColor.dark
                                : tooltipBgColor.light,
                            borderColor: darkMode
                                ? tooltipBorderColor.dark
                                : tooltipBorderColor.light,
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
                                li.style.marginRight = "1rem";
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
                                box.style.width = "0.75rem";
                                box.style.height = "0.75rem";
                                box.style.borderRadius = "9999px";
                                box.style.marginRight = "0.5rem";
                                box.style.borderWidth = "3px";
                                box.style.borderColor = item.fillStyle;
                                box.style.pointerEvents = "none";
                                // Label
                                const labelContainer =
                                    document.createElement("span");
                                labelContainer.style.display = "flex";
                                labelContainer.style.alignItems = "center";
                                const value = document.createElement("span");
                                value.style.color = darkMode
                                    ? "#F1F5F9"
                                    : "#1E293B";
                                value.style.fontSize = "1.5rem";
                                value.style.lineHeight = "2rem";
                                value.style.fontWeight = "700";
                                value.style.marginRight = "0.5rem";
                                value.style.pointerEvents = "none";
                                const label = document.createElement("span");
                                label.style.color = darkMode
                                    ? "#94A3B8"
                                    : "#64748B";
                                label.style.fontSize = "0.875rem";
                                label.style.lineHeight = "1.25rem";
                                const theValue = c.data.datasets[
                                    item.datasetIndex
                                ].data.reduce((a, b) => a + b, 0);
                                const valueText = document.createTextNode(
                                    theValue.toLocaleString("es-US", {
                                        style: "currency",
                                        currency: "USD",
                                        currencyDisplay: "code",
                                    })
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

            document.addEventListener("darkMode", (e) => {
                const { mode } = e.detail;
                if (mode === "on") {
                    chart.options.scales.x.ticks.color = textColor.dark;
                    chart.options.scales.y.ticks.color = textColor.dark;
                    chart.options.scales.y.grid.color = gridColor.dark;
                    chart.options.plugins.tooltip.bodyColor =
                        tooltipBodyColor.dark;
                    chart.options.plugins.tooltip.backgroundColor =
                        tooltipBgColor.dark;
                    chart.options.plugins.tooltip.borderColor =
                        tooltipBorderColor.dark;
                } else {
                    chart.options.scales.x.ticks.color = textColor.light;
                    chart.options.scales.y.ticks.color = textColor.light;
                    chart.options.scales.y.grid.color = gridColor.light;
                    chart.options.plugins.tooltip.bodyColor =
                        tooltipBodyColor.light;
                    chart.options.plugins.tooltip.backgroundColor =
                        tooltipBgColor.light;
                    chart.options.plugins.tooltip.borderColor =
                        tooltipBorderColor.light;
                }
                chart.update("none");
            });
        });
};

export default cardVentaDolares;
