import axios from "axios";
import React, { createContext, useEffect, useState } from "react";
import { Todo } from "../types/todoTypes";
import TodoElement from "./TodoElement";
import { KanbanBoardProvider } from "./KanbanBoardProvider";
import {
    DragDropContext,
    DropResult,
    ResponderProvided,
} from "@hello-pangea/dnd";

const KanbanBoardContext = createContext<{
    todo: Todo[];
    doing: Todo[];
    done: Todo[];
}>({ todo: [], doing: [], done: [] });

export default function KanbanBoard() {
    const [todos, setTodos] = useState<Todo[]>([]);

    useEffect(() => {
        axios.get("/api/todos").then((res) => {
            setTodos(res.data);
        });
    }, []);

    const handleDragEnd = (result: DropResult, provided: ResponderProvided) => {
        console.log(result);
    };

    return (
        <KanbanBoardProvider>
            <DragDropContext onDragEnd={handleDragEnd}>
                <div className="kanban-page-wrapper">
                    {todos.map((todo) => {
                        return <TodoElement key={todo.id} todo={todo} />;
                    })}
                </div>
            </DragDropContext>
        </KanbanBoardProvider>
    );
}
