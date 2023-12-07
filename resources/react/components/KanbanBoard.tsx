import React, { createContext } from "react";
import { Todo } from "../types/todoTypes";
import { KanbanBoardProvider } from "./KanbanBoardProvider";
import KanbanBoardColumns from "./KanbanBoardColumns";

const KanbanBoardContext = createContext<{
    todo: Todo[];
    doing: Todo[];
    done: Todo[];
}>({ todo: [], doing: [], done: [] });

export default function KanbanBoard() {
    return (
        <KanbanBoardProvider>
            <KanbanBoardColumns />
        </KanbanBoardProvider>
    );
}
