import React from "react";
import { Todo } from "../types/todoTypes";
import {
    Button,
    Card,
    CardActions,
    CardContent,
    CardHeader,
    Typography,
    useTheme,
} from "@mui/material";

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
    const theme = useTheme();
    // Show all elements of the todo object
    return (
        <Card
            sx={{
                margin: "10px",
                border: "2px solid " + theme.palette.primary.main,
                color: theme.palette.secondary.contrastText,
            }}
        >
            <CardHeader
                title={todo.title}
                subheader={todo.due_date ? `Due by: ${todo.due_date}` : ""}
            />
            <CardContent>
                <Typography variant="body2" color="text.secondary">
                    {todo.description}
                </Typography>
            </CardContent>
            <CardActions>
                {/* TODO: Add edit button */}
                <Button size="small" color="primary">
                    Edit
                </Button>
            </CardActions>
        </Card>
    );
}
