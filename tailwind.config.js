import plugin from "tailwindcss/plugin";
import aspectRatio from "@tailwindcss/aspect-ratio";
import colors from "tailwindcss/colors";
import wireuiConfig from "./vendor/wireui/wireui/tailwind.config.js";

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js"),
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
        "./resources/views/**/**/**/*.blade.php",
        "./vendor/wireui/wireui/src/*.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/WireUi/**/*.php",
        "./vendor/wireui/wireui/src/Components/**/*.php",
        "./app/Livewire/**/**/Tabla.php",
        "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
    ],
    theme: {
        extend: {
            colors: {
                "pg-primary": colors.gray,
                gray: {
                    50: "#F9FAFB",
                    100: "#F3F4F6",
                    200: "#E5E7EB",
                    300: "#BFC4CD",
                    400: "#9CA3AF",
                    500: "#6B7280",
                    600: "#4B5563",
                    700: "#374151",
                    800: "#1F2937",
                    900: "#111827",
                    950: "#030712",
                },
                violet: {
                    50: "#F1EEFF",
                    100: "#E6E1FF",
                    200: "#D2CBFF",
                    300: "#B7ACFF",
                    400: "#9C8CFF",
                    500: "#8470FF",
                    600: "#755FF8",
                    700: "#5D47DE",
                    800: "#4634B1",
                    900: "#2F227C",
                    950: "#1C1357",
                },
                sky: {
                    50: "#E3F3FF",
                    100: "#D1ECFF",
                    200: "#B6E1FF",
                    300: "#A0D7FF",
                    400: "#7BC8FF",
                    500: "#67BFFF",
                    600: "#56B1F3",
                    700: "#3193DA",
                    800: "#1C71AE",
                    900: "#124D79",
                    950: "#0B324F",
                },
                green: {
                    50: "#D2FFE2",
                    100: "#B1FDCD",
                    200: "#8BF0B0",
                    300: "#67E294",
                    400: "#4BD37D",
                    500: "#3EC972",
                    600: "#34BD68",
                    700: "#239F52",
                    800: "#15773A",
                    900: "#0F5429",
                    950: "#0A3F1E",
                },
                red: {
                    50: "#FFE8E8",
                    100: "#FFD1D1",
                    200: "#FFB2B2",
                    300: "#FF9494",
                    400: "#FF7474",
                    500: "#FF5656",
                    600: "#FA4949",
                    700: "#E63939",
                    800: "#C52727",
                    900: "#941818",
                    950: "#600F0F",
                },
                yellow: {
                    50: "#FFF2C9",
                    100: "#FFE7A0",
                    200: "#FFE081",
                    300: "#FFD968",
                    400: "#F7CD4C",
                    500: "#F0BB33",
                    600: "#DFAD2B",
                    700: "#BC9021",
                    800: "#816316",
                    900: "#4F3D0E",
                    950: "#342809",
                },
                talentus: "#141D38",
                "talentus-100": "#0F4787",
                "talentus-200": "#052c52",
            },
            boxShadow: {
                DEFAULT:
                    "0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.02)",
                md: "0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.02)",
                lg: "0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.01)",
                xl: "0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.01)",
            },
            outline: {
                blue: "2px solid rgba(0, 112, 244, 0.5)",
            },
            fontFamily: {
                // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                inter: ["Inter", "sans-serif"],
            },
            fontSize: {
                xs: ["0.75rem", { lineHeight: "1.5" }],
                sm: ["0.875rem", { lineHeight: "1.5715" }],
                base: ["1rem", { lineHeight: "1.5", letterSpacing: "-0.01em" }],
                lg: [
                    "1.125rem",
                    { lineHeight: "1.5", letterSpacing: "-0.01em" },
                ],
                xl: [
                    "1.25rem",
                    { lineHeight: "1.5", letterSpacing: "-0.01em" },
                ],
                "2xl": [
                    "1.5rem",
                    { lineHeight: "1.33", letterSpacing: "-0.01em" },
                ],
                "3xl": [
                    "1.88rem",
                    { lineHeight: "1.33", letterSpacing: "-0.01em" },
                ],
                "4xl": [
                    "2.25rem",
                    { lineHeight: "1.25", letterSpacing: "-0.02em" },
                ],
                "5xl": [
                    "3rem",
                    { lineHeight: "1.25", letterSpacing: "-0.02em" },
                ],
                "6xl": [
                    "3.75rem",
                    { lineHeight: "1.2", letterSpacing: "-0.02em" },
                ],
            },
            screens: {
                xs: "480px",
            },
            borderWidth: {
                3: "3px",
            },
            minWidth: {
                36: "9rem",
                44: "11rem",
                56: "14rem",
                60: "15rem",
                72: "18rem",
                80: "20rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
            },
            zIndex: {
                60: "60",
            },
        },
    },
    plugins: [
        require("@tailwindcss/typography"),
        require("@tailwindcss/forms"),
        aspectRatio,
        plugin(({ addVariant, e }) => {
            addVariant("sidebar-expanded", ({ modifySelectors, separator }) => {
                modifySelectors(
                    ({ className }) =>
                        `.sidebar-expanded .${e(
                            `sidebar-expanded${separator}${className}`
                        )}`
                );
            });
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                main: "./index.html",
            },
        },
    },
};
