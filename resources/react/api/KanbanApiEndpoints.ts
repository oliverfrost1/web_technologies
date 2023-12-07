import axios from "axios";
import { Todo, TodoStatus } from "../types/todoTypes";

export async function getTodos() {
    return await axios
        .get<Todo[]>("/api/todos")
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            throw err;
        });
}

export async function updateTodo(todoId: number, newStatus: TodoStatus) {
    return axios.put<Todo>(`/api/todos/${todoId}`, { status: newStatus });
}
