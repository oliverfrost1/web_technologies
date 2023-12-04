import axios from "axios";
import { Todo } from "../types/todoTypes";

export async function getTodos() {
    return await axios
        .get<Todo[]>("/api/todos")
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
        });
}
