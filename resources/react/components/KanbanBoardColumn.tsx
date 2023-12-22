import { Draggable, Droppable } from "@hello-pangea/dnd";
import { Box, BoxProps, Typography, useTheme } from "@mui/material";
import React, { useMemo } from "react";
import { Todo } from "../types/todoTypes";
import TodoElement from "./TodoElement";

type Props = {
    todoElements: Todo[];
    title: string;
};

export default function KanbanBoardColumn({
    todoElements,
    title,
}: Readonly<Props>) {
    const theme = useTheme();

    const kanbanColumnStyling: BoxProps["sx"] = useMemo(() => {
        return {
            borderColor: theme.palette.primary.main,
            backgroundColor: theme.palette.primary.main,
            color: theme.palette.primary.contrastText,
        };
    }, [theme]);

    return (
        <Droppable droppableId="done">
            {(provided) => (
                <Box
                    ref={provided.innerRef}
                    {...provided.droppableProps}
                    sx={kanbanColumnStyling}
                    className="kanban-column"
                >
                    <Typography variant="h5">{title}</Typography>
                    {todoElements.map((todo, index) => (
                        <Draggable
                            draggableId={todo.id.toString()}
                            index={index}
                            key={todo.id}
                        >
                            {(provided) => (
                                <Box
                                    ref={provided.innerRef}
                                    {...provided.draggableProps}
                                    {...provided.dragHandleProps}
                                >
                                    <TodoElement todo={todo} />
                                </Box>
                            )}
                        </Draggable>
                    ))}
                    {provided.placeholder}
                </Box>
            )}
        </Droppable>
    );
}
