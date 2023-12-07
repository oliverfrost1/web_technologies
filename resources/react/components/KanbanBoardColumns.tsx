import React, { useContext, useState } from "react";
import {
    DragDropContext,
    Draggable,
    DropResult,
    Droppable,
    ResponderProvided,
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
    const theme = useTheme();
    const [error, setError] = useState<string | null>(null);

    const kanbanColumnStyling: BoxProps["sx"] = {
        minHeight: "100px",
        padding: "5px",
        border: "3px solid " + theme.palette.primary.main,
        borderRadius: "5px",
        backgroundColor: theme.palette.primary.main,
        color: theme.palette.primary.contrastText,
    };

    const updateTodoInDatabase = async (
        todoId: number,
        newStatus: TodoStatus
    ) => {
        updateTodo(todoId, newStatus).catch(() => {
            setError("Error in updating Kanban board. Fetching latest data.");
            refetch();
        });
    };

    const handleDragEnd = (result: DropResult, provided: ResponderProvided) => {
        console.log(result, provided);
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
        // If the database update fails, I refetch the data from the database (done elsewhere)
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
            // IF it's moving to another column
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
                    <Droppable droppableId="todo">
                        {(provided) => (
                            <Box
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                                sx={kanbanColumnStyling}
                            >
                                <Typography variant="h5">Todo</Typography>
                                {todo.map((todo, index) => (
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
                </Grid>
                <Grid item xs={4}>
                    <Droppable droppableId="doing">
                        {(provided) => (
                            <Box
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                                sx={kanbanColumnStyling}
                            >
                                <Typography variant="h5">Doing</Typography>
                                {doing.map((todo, index) => (
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
                </Grid>
                <Grid item xs={4}>
                    <Droppable droppableId="done">
                        {(provided) => (
                            <Box
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                                sx={kanbanColumnStyling}
                            >
                                <Typography variant="h5">Done</Typography>
                                {done.map((todo, index) => (
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
                </Grid>
            </Grid>
        </DragDropContext>
    );
}
