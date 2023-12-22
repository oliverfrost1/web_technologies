import React from "react";
import { Todo } from "../types/todoTypes";
import { Card, CardContent, Typography, useTheme } from "@mui/material";

type TodoElementProps = {
    todo: Todo;
};

export default function TodoElement({ todo }: Readonly<TodoElementProps>) {
    const theme = useTheme();
    return (
        <Card
            className="card"
            sx={{
                border: "2px solid " + theme.palette.primary.main,
                color: theme.palette.secondary.contrastText,
            }}
        >
            <CardContent>
                <Typography variant="h6" color="text.secondary">
                    {todo.title}
                </Typography>
                <Typography variant="body2" color="text.secondary">
                    {todo.due_date ? `Due by: ${todo.due_date}` : ""}
                </Typography>
            </CardContent>
        </Card>
    );
}
