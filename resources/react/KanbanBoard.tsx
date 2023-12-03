import axios from "axios";
import React, { useEffect, useState } from "react";
import { Todo } from "./types/todoTypes";
import TodoElement from "./components/TodoElement";

export default function KanbanBoard() {
    const [todos, setTodos] = useState<Todo[]>([]);

    useEffect(() => {
        axios.get("/api/todos").then((res) => {
            setTodos(res.data);
        });
    }, []);

    return (
        <div>
            {todos.map((todo) => {
                return <TodoElement key={todo.id} todo={todo} />;
            })}
        </div>
    );
}
