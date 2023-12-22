import React, { useCallback, useContext, useMemo, useState } from "react";
import {
    DragDropContext,
    Draggable,
    DropResult,
    Droppable,
} from "@hello-pangea/dnd";
import { KanbanBoardContext } from "./KanbanBoardProvider";
import {
    Alert,
    Box,
    BoxProps,
    Fade,
    Grid,
    Typography,
    useTheme,
} from "@mui/material";
import TodoElement from "./TodoElement";
import { TodoStatus } from "../types/todoTypes";
import { updateTodo } from "../api/KanbanApiEndpoints";
import ErrorSnackbar from "./ErrorSnackbar";
import KanbanBoardColumn from "./KanbanBoardColumn";

export default function KanbanBoardColumns() {
    const {
        todo,
        doing,
        done,
        setTodo,
        setDoing,
        setDone,
        refetch,
        fetchingTodoError,
    } = useContext(KanbanBoardContext);

    const [error, setError] = useState<string | null>(null);

    const updateTodoInDatabase = useCallback(
        async (todoId: number, newStatus: TodoStatus) => {
            updateTodo(todoId, newStatus).catch(() => {
                setError(
                    "Error in updating Kanban board. Fetching latest data."
                );
                refetch();
            });
        },
        [refetch, setError]
    );

    const handleDragEnd = (result: DropResult) => {
        if (!setTodo || !setDoing || !setDone) return;
        if (!result.destination) return;

        const { source, destination } = result;

        // Clone the array based on droppableId
        const cloneArray = (droppableId) => {
            switch (droppableId) {
                case "todo":
                    return Array.from(todo);
                case "doing":
                    return Array.from(doing);
                case "done":
                    return Array.from(done);
                default:
                    return [];
            }
        };

        // I optimistically update the state first, then update the database
        // If the database update fails, I refetch the data from the database (done in updateTodoInDatabase)
        const updateState = (droppableId, newState) => {
            switch (droppableId) {
                case "todo":
                    setTodo(newState);
                    break;
                case "doing":
                    setDoing(newState);
                    break;
                case "done":
                    setDone(newState);
                    break;
                default:
                    break;
            }
        };

        const sourceClone = cloneArray(source.droppableId);
        const [movedItem] = sourceClone.splice(source.index, 1);

        if (source.droppableId === destination.droppableId) {
            // If it's the same column
            sourceClone.splice(destination.index, 0, movedItem);
            updateState(source.droppableId, sourceClone);
        } else {
            // If it's moving to another column
            const destinationClone = cloneArray(destination.droppableId);
            destinationClone.splice(destination.index, 0, movedItem);
            updateState(source.droppableId, sourceClone);
            updateState(destination.droppableId, destinationClone);
            updateTodoInDatabase(
                movedItem.id,
                destination.droppableId as TodoStatus
            );
        }
    };

    return (
        <DragDropContext onDragEnd={handleDragEnd}>
            <ErrorSnackbar error={error} setError={setError} />
            <Fade in={!!fetchingTodoError} mountOnEnter>
                <Alert severity="error">{fetchingTodoError}</Alert>
            </Fade>
            <Grid container spacing={2} sx={{ height: "100%" }}>
                <Grid item xs={4}>
                    <KanbanBoardColumn todoElements={todo} title="Todo" />
                </Grid>
                <Grid item xs={4}>
                    <KanbanBoardColumn todoElements={doing} title="Doing" />
                </Grid>
                <Grid item xs={4}>
                    <KanbanBoardColumn todoElements={done} title="Done" />
                </Grid>
            </Grid>
        </DragDropContext>
    );
}
