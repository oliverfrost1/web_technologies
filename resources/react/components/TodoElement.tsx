import React from "react";
import { Todo } from "../types/todoTypes";
import { Card, Chip } from "@mui/material";

type TodoElementProps = {
    todo: Todo;
};

/*
export interface Todo {
    completed: number;
    id: number;
    created_at: string;
    description: string | null;
    title: string;
    updated_at: string;
    user_id: number;
    status: TodoStatus;
}*/

export default function TodoElement({ todo }: TodoElementProps) {
    // Show all elements of the todo object
    return (
        <Card sx={{ margin: "10px" }}>
            <Chip label={todo.title} />
            <Chip label={todo.description} />
            <Chip label={todo.status} />
            <Chip label={todo.created_at} />
            <Chip label={todo.updated_at} />
            <Chip label={todo.user_id} />
            <Chip label={todo.completed} />
        </Card>
    );
}
