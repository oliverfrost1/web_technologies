import React, { useContext } from "react";
import {
    DragDropContext,
    Draggable,
    DropResult,
    Droppable,
    ResponderProvided,
} from "@hello-pangea/dnd";
import { KanbanBoardContext } from "./KanbanBoardProvider";
import { Box, Grid } from "@mui/material";
import TodoElement from "./TodoElement";

export default function KanbanBoardColumns() {
    const { todo, doing, done, setTodo, setDoing, setDone } =
        useContext(KanbanBoardContext);
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
                } else if (destination.droppableId === "done") {
                    const newDone = Array.from(done);
                    newDone.splice(destination.index, 0, movedTodo);
                    setDone(newDone);
                    setTodo(newTodo);
                }
            } else if (source.droppableId === "doing") {
                const newDoing = Array.from(doing);
                const [movedDoing] = newDoing.splice(source.index, 1);
                if (destination.droppableId === "todo") {
                    const newTodo = Array.from(todo);
                    newTodo.splice(destination.index, 0, movedDoing);
                    setTodo(newTodo);
                    setDoing(newDoing);
                } else if (destination.droppableId === "done") {
                    const newDone = Array.from(done);
                    newDone.splice(destination.index, 0, movedDoing);
                    setDone(newDone);
                    setDoing(newDoing);
                }
            } else if (source.droppableId === "done") {
                const newDone = Array.from(done);
                const [movedDone] = newDone.splice(source.index, 1);
                if (destination.droppableId === "todo") {
                    const newTodo = Array.from(todo);
                    newTodo.splice(destination.index, 0, movedDone);
                    setTodo(newTodo);
                    setDone(newDone);
                } else if (destination.droppableId === "doing") {
                    const newDoing = Array.from(doing);
                    newDoing.splice(destination.index, 0, movedDone);
                    setDoing(newDoing);
                    setDone(newDone);
                }
            }
        }
    };
    console.log(todo, doing, done);

    return (
        <DragDropContext onDragEnd={handleDragEnd}>
            <Grid container spacing={2}>
                <Grid item xs={4}>
                    <Droppable droppableId="todo">
                        {(provided) => (
                            <Box
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                                sx={{
                                    backgroundColor: "red",
                                    minHeight: "100px",
                                }}
                            >
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
                                sx={{
                                    backgroundColor: "yellow",
                                    minHeight: "100px",
                                }}
                            >
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
                                sx={{
                                    backgroundColor: "green",
                                    minHeight: "100px",
                                }}
                            >
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
