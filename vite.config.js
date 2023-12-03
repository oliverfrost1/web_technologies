import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/react/app.tsx"],
            refresh: true,
        }),
        react(),
    ],
    build: {
        rollupOptions: {
            input: "resources/react/app.tsx",
        },
        outDir: "public/build",
    },
});
