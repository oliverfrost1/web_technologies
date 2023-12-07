import React, { useContext, useState } from "react";
import {
    DragDropContext,
    Draggable,
    DropResult,
    Droppable,
    ResponderProvided,
} from "@hello-pangea/dnd";
import { KanbanBoardContext } from "./KanbanBoardProvider";
import { Alert, Box, BoxProps, Fade, Grid, Typography } from "@mui/material";
import TodoElement from "./TodoElement";
import { TodoStatus } from "../types/todoTypes";
import { updateTodo } from "../api/KanbanApiEndpoints";
import ErrorSnackbar from "./ErrorSnackbar";

const kanbanColumnStyling: BoxProps["sx"] = {
    minHeight: "100px",
    padding: "5px",
    border: "3px solid black",
    borderRadius: "5px",
    backgroundColor: "lightgrey",
};

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
        if (source.droppableId === destination.droppableId) {
            if (source.droppableId === "todo") {
                const newTodo = Array.from(todo);
                const [movedTodo] = newTodo.splice(source.index, 1);
                newTodo.splice(destination.index, 0, movedTodo);
                setTodo(newTodo);
            } else if (source.droppableId === "doing") {
                const newDoing = Array.from(doing);
                const [movedDoing] = newDoing.splice(source.index, 1);
                newDoing.splice(destination.index, 0, movedDoing);
                setDoing(newDoing);
            } else if (source.droppableId === "done") {
                const newDone = Array.from(done);
                const [movedDone] = newDone.splice(source.index, 1);
                newDone.splice(destination.index, 0, movedDone);
                setDone(newDone);
            }
        } else {
            if (source.droppableId === "todo") {
                const newTodo = Array.from(todo);
                const [movedTodo] = newTodo.splice(source.index, 1);
                if (destination.droppableId === "doing") {
                    const newDoing = Array.from(doing);
                    newDoing.splice(destination.index, 0, movedTodo);
                    setDoing(newDoing);
                    setTodo(newTodo);
                    updateTodoInDatabase(movedTodo.id, "doing");
                } else if (destination.droppableId === "done") {
                    const newDone = Array.from(done);
                    newDone.splice(destination.index, 0, movedTodo);
                    setDone(newDone);
                    setTodo(newTodo);
                    updateTodoInDatabase(movedTodo.id, "done");
                }
            } else if (source.droppableId === "doing") {
                const newDoing = Array.from(doing);
                const [movedDoing] = newDoing.splice(source.index, 1);
                if (destination.droppableId === "todo") {
                    const newTodo = Array.from(todo);
                    newTodo.splice(destination.index, 0, movedDoing);
                    setTodo(newTodo);
                    setDoing(newDoing);
                    updateTodoInDatabase(movedDoing.id, "todo");
                } else if (destination.droppableId === "done") {
                    const newDone = Array.from(done);
                    newDone.splice(destination.index, 0, movedDoing);
                    setDone(newDone);
                    setDoing(newDoing);
                    updateTodoInDatabase(movedDoing.id, "done");
                }
            } else if (source.droppableId === "done") {
                const newDone = Array.from(done);
                const [movedDone] = newDone.splice(source.index, 1);
                if (destination.droppableId === "todo") {
                    const newTodo = Array.from(todo);
                    newTodo.splice(destination.index, 0, movedDone);
                    setTodo(newTodo);
                    setDone(newDone);
                    updateTodoInDatabase(movedDone.id, "todo");
                } else if (destination.droppableId === "doing") {
                    const newDoing = Array.from(doing);
                    newDoing.splice(destination.index, 0, movedDone);
                    setDoing(newDoing);
                    setDone(newDone);
                    updateTodoInDatabase(movedDone.id, "doing");
                }
            }
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
