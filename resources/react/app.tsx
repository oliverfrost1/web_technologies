import React from "react";
import ReactDOM from "react-dom";
import KanbanBoard from "./components/KanbanBoard";
import { ThemeProvider } from "@mui/material";
import { theme } from "./theme";
import "../../public/css/kanban.css";

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
