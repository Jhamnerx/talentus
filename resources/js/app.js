import "./bootstrap";
import "./main";

import VenoBox from "venobox";

window.VenoBox = VenoBox;

import flatpickr from "flatpickr";

// Chart.js — gráficos de barras para Dashboard Reportes
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
} from "chart.js";
Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
);

import TomSelect from "tom-select";
window.TomSelect = TomSelect;

import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/tailwind.css";

new VenoBox({
    selector: ".image-task",
    maxWidth: "75%",
    spinner: "rotating-plane",
});
// import Sortable from "sortablejs";

// window.Sortable = Sortable;

//Sortable.start();

//import Sortable from "sortablejs";

import Swal from "sweetalert2";

window.Swal = Swal;
import iziToast from "izitoast";
window.iziToast = iziToast;

import.meta.glob(["../images/**"]);

//FILE POND IMAGE DROP AND DRAG
import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

FilePond.registerPlugin(FilePondPluginImagePreview);

window.FilePond = FilePond;

// import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";
// window.DecoupledEditor = DecoupledEditor;
// import Base64UploadAdapter from "@ckeditor/ckeditor5-upload/src/adapters/base64uploadadapter";

// // DecoupledEditor.builtinPlugins = [Base64UploadAdapter];
window.dashboardDatepicker = function (fechaInicio, fechaFin) {
    let fp = null; // fuera del obj reactivo para que Alpine no lo proxifique
    return {
        init() {
            fp = flatpickr(this.$refs.input, {
                mode: "range",
                static: true,
                monthSelectorType: "static",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "M j, Y",
                defaultDate: [fechaInicio, fechaFin],
                prevArrow:
                    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow:
                    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
                onChange: (selectedDates) => {
                    if (selectedDates.length === 2) {
                        const fmt = (d) => {
                            const y = d.getFullYear();
                            const m = String(d.getMonth() + 1).padStart(2, "0");
                            const day = String(d.getDate()).padStart(2, "0");
                            return `${y}-${m}-${day}`;
                        };
                        Livewire.dispatch("dashboard-filtro-actualizado", {
                            fechaInicio: fmt(selectedDates[0]),
                            fechaFin: fmt(selectedDates[1]),
                        });
                    }
                },
            });
        },
        setPreset(periodo) {
            if (!fp) return;
            const now = new Date();
            let start, end;
            const day = now.getDay();
            const monday = new Date(now);
            monday.setDate(now.getDate() - (day === 0 ? 6 : day - 1));
            monday.setHours(0, 0, 0, 0);
            switch (periodo) {
                case "hoy":
                    start = new Date(now);
                    end = new Date(now);
                    break;
                case "semana":
                    start = monday;
                    end = new Date(monday);
                    end.setDate(monday.getDate() + 6);
                    break;
                case "mes":
                    start = new Date(now.getFullYear(), now.getMonth(), 1);
                    end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                    break;
                case "ano":
                    start = new Date(now.getFullYear(), 0, 1);
                    end = new Date(now.getFullYear(), 11, 31);
                    break;
            }
            fp.setDate([start, end], true); // triggerChange=true → dispara onChange → setRangoFecha
        },
    };
};

/**
 * Alpine component para gráficas de barras agrupadas (PEN / USD) — Dashboard Reportes.
 * Patrón Mosaic: fetch a endpoint JSON en lugar de datos inline @js().
 * Uso: x-data="ventasBarChart('/dashboard/chart-ventas?tipo=gps')" x-init="init()"
 */
window.ventasBarChart = function (url) {
    return {
        chart: null,
        loading: true,
        init() {
            fetch(url)
                .then((r) => r.json())
                .then((data) => {
                    this.loading = false;
                    this._buildChart(data);
                })
                .catch(() => {
                    this.loading = false;
                });
        },
        _buildChart(data) {
            const canvas = this.$refs.canvas;
            if (!canvas) return;

            const dark = localStorage.getItem("dark-mode") === "true";
            const gridColor = dark
                ? "rgba(148,163,184,0.15)"
                : "rgba(15,23,42,0.08)";
            const tickColor = dark ? "#94a3b8" : "#64748b";
            const colorPEN = "#6366f1"; // indigo-500
            const colorUSD = "#0ea5e9"; // sky-500

            // Conteo de unidades por mes (puede no existir en gráficas que no lo envíen)
            const countPEN = data.countPEN ?? [];
            const countUSD = data.countUSD ?? [];

            this.chart = new Chart(canvas, {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: "PEN (S/)",
                            data: data.dataPEN,
                            backgroundColor: colorPEN + "cc",
                            borderColor: colorPEN,
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.7,
                        },
                        {
                            label: "USD ($)",
                            data: data.dataUSD,
                            backgroundColor: colorUSD + "cc",
                            borderColor: colorUSD,
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.7,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 300 },
                    layout: { padding: { top: 4, bottom: 4 } },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: tickColor, font: { size: 11 } },
                        },
                        y: {
                            grid: { color: gridColor },
                            border: { display: false },
                            ticks: {
                                color: tickColor,
                                font: { size: 11 },
                                callback: (v) =>
                                    v >= 1000 ? (v / 1000).toFixed(1) + "k" : v,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                color: tickColor,
                                font: { size: 11 },
                                boxWidth: 12,
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const isPEN = ctx.datasetIndex === 0;
                                    const sym = isPEN ? "S/" : "$";
                                    const counts = isPEN ? countPEN : countUSD;
                                    const qty = counts[ctx.dataIndex] ?? 0;
                                    const amount = Number(
                                        ctx.parsed.y,
                                    ).toLocaleString("es-PE", {
                                        minimumFractionDigits: 2,
                                    });
                                    const uLabel =
                                        qty === 1 ? "equipo" : "equipos";
                                    return qty > 0
                                        ? ` ${qty} ${uLabel} — ${sym} ${amount}`
                                        : ` ${sym} ${amount}`;
                                },
                            },
                        },
                    },
                },
            });

            document.addEventListener("darkMode", (e) => {
                if (!this.chart) return;
                const isDark = e.detail.mode === "on";
                const gc = isDark
                    ? "rgba(148,163,184,0.15)"
                    : "rgba(15,23,42,0.08)";
                const tc = isDark ? "#94a3b8" : "#64748b";
                this.chart.options.scales.x.ticks.color = tc;
                this.chart.options.scales.y.ticks.color = tc;
                this.chart.options.scales.y.grid.color = gc;
                this.chart.options.plugins.legend.labels.color = tc;
                this.chart.update();
            });
        },
    };
};

/**
 * Alpine component para el gráfico de Ventas Facturadas (Ventas + Recibos pagados).
 * 4 datasets: Ventas PEN, Ventas USD, Recibos PEN, Recibos USD.
 */
window.facturadasBarChart = function (url) {
    return {
        chart: null,
        loading: true,
        init() {
            fetch(url)
                .then((r) => r.json())
                .then((data) => {
                    this.loading = false;
                    this._buildChart(data);
                })
                .catch(() => {
                    this.loading = false;
                });
        },
        _buildChart(data) {
            const canvas = this.$refs.canvas;
            if (!canvas) return;

            const dark = localStorage.getItem("dark-mode") === "true";
            const gridColor = dark
                ? "rgba(148,163,184,0.15)"
                : "rgba(15,23,42,0.08)";
            const tickColor = dark ? "#94a3b8" : "#64748b";

            this.chart = new Chart(canvas, {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: "Ventas PEN (S/)",
                            data: data.ventasPEN,
                            backgroundColor: "#6366f1cc",
                            borderColor: "#6366f1",
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.8,
                        },
                        {
                            label: "Ventas USD ($)",
                            data: data.ventasUSD,
                            backgroundColor: "#0ea5e9cc",
                            borderColor: "#0ea5e9",
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.8,
                        },
                        {
                            label: "Recibos PEN (S/)",
                            data: data.recibosPEN,
                            backgroundColor: "#10b981cc",
                            borderColor: "#10b981",
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.8,
                        },
                        {
                            label: "Recibos USD ($)",
                            data: data.recibosUSD,
                            backgroundColor: "#f59e0bcc",
                            borderColor: "#f59e0b",
                            borderWidth: 1,
                            borderRadius: 3,
                            categoryPercentage: 0.8,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 300 },
                    layout: { padding: { top: 4, bottom: 4 } },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: tickColor, font: { size: 11 } },
                        },
                        y: {
                            grid: { color: gridColor },
                            border: { display: false },
                            ticks: {
                                color: tickColor,
                                font: { size: 11 },
                                callback: (v) =>
                                    v >= 1000 ? (v / 1000).toFixed(1) + "k" : v,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                color: tickColor,
                                font: { size: 11 },
                                boxWidth: 12,
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const sym =
                                        ctx.datasetIndex % 2 === 0 ? "S/" : "$";
                                    return ` ${ctx.dataset.label}: ${sym} ${Number(ctx.parsed.y).toLocaleString("es-PE", { minimumFractionDigits: 2 })}`;
                                },
                            },
                        },
                    },
                },
            });

            document.addEventListener("darkMode", (e) => {
                if (!this.chart) return;
                const isDark = e.detail.mode === "on";
                const gc = isDark
                    ? "rgba(148,163,184,0.15)"
                    : "rgba(15,23,42,0.08)";
                const tc = isDark ? "#94a3b8" : "#64748b";
                this.chart.options.scales.x.ticks.color = tc;
                this.chart.options.scales.y.ticks.color = tc;
                this.chart.options.scales.y.grid.color = gc;
                this.chart.options.plugins.legend.labels.color = tc;
                this.chart.update();
            });
        },
    };
};

document.addEventListener("DOMContentLoaded", () => {
    // Light switcher
    // Light switcher
    const lightSwitches = document.querySelectorAll(".light-switch");
    if (lightSwitches.length > 0) {
        lightSwitches.forEach((lightSwitch, i) => {
            if (localStorage.getItem("dark-mode") === "true") {
                lightSwitch.checked = true;
            }
            lightSwitch.addEventListener("change", () => {
                const { checked } = lightSwitch;
                lightSwitches.forEach((el, n) => {
                    if (n !== i) {
                        el.checked = checked;
                    }
                });
                document.documentElement.classList.add("**:transition-none!");
                if (lightSwitch.checked) {
                    document.documentElement.classList.add("dark");
                    document.querySelector("html").style.colorScheme = "dark";
                    localStorage.setItem("dark-mode", true);
                    document.dispatchEvent(
                        new CustomEvent("darkMode", { detail: { mode: "on" } }),
                    );
                } else {
                    document.documentElement.classList.remove("dark");
                    document.querySelector("html").style.colorScheme = "light";
                    localStorage.setItem("dark-mode", false);
                    document.dispatchEvent(
                        new CustomEvent("darkMode", {
                            detail: { mode: "off" },
                        }),
                    );
                }
                setTimeout(() => {
                    document.documentElement.classList.remove(
                        "**:transition-none!",
                    );
                }, 1);
            });
        });
    }
    // Flatpickr
    flatpickr(".datepicker", {
        mode: "range",
        static: true,
        monthSelectorType: "static",
        dateFormat: "M j, Y",
        defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
        prevArrow:
            '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
        nextArrow:
            '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
        onReady: (selectedDates, dateStr, instance) => {
            instance.element.value = dateStr.replace("to", "-");
            const customClass = instance.element.getAttribute("data-class");
            instance.calendarContainer.classList.add(customClass);
        },
        onChange: (selectedDates, dateStr, instance) => {
            instance.element.value = dateStr.replace("to", "-");
        },
    });
    // Charts
    // dashboardCard01();
    // dashboardCard02();
    // dashboardCard03();
    // dashboardCard04();
    // dashboardCard05();
    // dashboardCard06();
    // dashboardCard08();
    // dashboardCard09();
    // analyticsCard01();
    // analyticsCard02();
    // analyticsCard03();
    // analyticsCard04();
    // analyticsCard08();
    // analyticsCard09();
    // analyticsCard10();
    // fintechCard01();
    // fintechCard03();
    // fintechCard04();
    // fintechCard07();
    // fintechCard08();
    // fintechCard09();
    // fintechCard10();
    // fintechCard11();
    // fintechCard12();
    // fintechCard13();
    // fintechCard14();
});
