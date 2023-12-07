import React from "react";
import { KanbanBoardProvider } from "./components/KanbanBoardProvider";
import KanbanBoardColumns from "./components/KanbanBoardColumns";
import { Box } from "@mui/material";

export default function KanbanBoard() {
    return (
        <KanbanBoardProvider>
            <Box sx={{ padding: "10px" }}>
                <KanbanBoardColumns />
            </Box>
        </KanbanBoardProvider>
    );
}
