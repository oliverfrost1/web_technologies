import React from "react";
import ReactDOM from "react-dom";
import { ThemeProvider } from "@mui/material";
import { theme } from "./theme";
import "../../public/css/kanban.css";
import KanbanBoard from "./KanbanBoard";

const root = document.getElementById("react-root");
if (root) {
    ReactDOM.createRoot(root).render(
        <React.StrictMode>
            <ThemeProvider theme={theme}>
                <KanbanBoard />
            </ThemeProvider>
        </React.StrictMode>
    );
}
