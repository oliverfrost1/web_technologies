import React from "react";
import { KanbanBoardProvider } from "./components/KanbanBoardProvider";
import KanbanBoardColumns from "./components/KanbanBoardColumns";
import { Box } from "@mui/material";

export default function KanbanBoard() {
    return (
        <KanbanBoardProvider>
            <Box className="kanban-page-wrapper">
                <KanbanBoardColumns />
            </Box>
        </KanbanBoardProvider>
    );
}
