import React from "react";
import { Todo } from "../types/todoTypes";
import { Chip, useTheme } from "@mui/material";

// export interface Todo {
//     completed: number;
//     id: number;
//     created_at: string;
//     description: string | null;
//     title: string;
//     updated_at: string;
//     user_id: number;
// }

type TodoElementProps = {
    todo: Todo;
};

export default function TodoElement({ todo }: TodoElementProps) {
    // Show all elements of the todo object
    return <Chip label={todo.title} color={"primary"} />;
}
