import moment from "moment";
import "moment/locale/es";

import { Chart } from "chart.js";

import "chartjs-adapter-moment";

moment.locale("es");

// Import TailwindCSS variables
import { tailwindConfig } from "./utils";

import cardVentaSoles from "./components/dashboard-ventas-soles";
import cardVentaDolares from "./components/dashboard-ventas-dolares";
import CardVentas from "./components/card-top-ventas";

Chart.defaults.font.family = '"Inter", sans-serif';
Chart.defaults.font.weight = "500";
Chart.defaults.color = tailwindConfig().theme.colors.slate[400];
Chart.defaults.scale.grid.color = tailwindConfig().theme.colors.slate[100];
Chart.defaults.plugins.tooltip.titleColor =
    tailwindConfig().theme.colors.slate[800];
Chart.defaults.plugins.tooltip.bodyColor =
    tailwindConfig().theme.colors.slate[800];
Chart.defaults.plugins.tooltip.backgroundColor =
    tailwindConfig().theme.colors.white;
Chart.defaults.plugins.tooltip.borderWidth = 1;
Chart.defaults.plugins.tooltip.borderColor =
    tailwindConfig().theme.colors.slate[200];
Chart.defaults.plugins.tooltip.displayColors = false;
Chart.defaults.plugins.tooltip.mode = "nearest";
Chart.defaults.plugins.tooltip.intersect = false;
Chart.defaults.plugins.tooltip.position = "nearest";
Chart.defaults.plugins.tooltip.caretSize = 0;
Chart.defaults.plugins.tooltip.caretPadding = 20;
Chart.defaults.plugins.tooltip.cornerRadius = 4;
Chart.defaults.plugins.tooltip.padding = 8;

Chart.register({
    id: "chartAreaPlugin",

    beforeDraw: (chart) => {
        if (
            chart.config.options.chartArea &&
            chart.config.options.chartArea.backgroundColor
        ) {
            const ctx = chart.canvas.getContext("2d");
            const { chartArea } = chart;
            ctx.save();
            ctx.fillStyle = chart.config.options.chartArea.backgroundColor;

            ctx.fillRect(
                chartArea.left,
                chartArea.top,
                chartArea.right - chartArea.left,
                chartArea.bottom - chartArea.top
            );
            ctx.restore();
        }
    },
});

document.addEventListener("DOMContentLoaded", () => {
    var hoy = new Date();

    var hora = hoy.getHours() + ":" + hoy.getMinutes();

    cardVentaSoles();
    cardVentaDolares();
    CardVentas();
});
