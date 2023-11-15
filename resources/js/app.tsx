import React from "react";
import ReactDOM from "react-dom";
import TestComponent from "./KanbanBoard";
import { ThemeProvider } from "@mui/material";
import { theme } from "./theme";

const root = document.getElementById("react-root");
if (root) {
    ReactDOM.createRoot(root).render(
        <ThemeProvider theme={theme}>
            <TestComponent />
        </ThemeProvider>
    );
}
