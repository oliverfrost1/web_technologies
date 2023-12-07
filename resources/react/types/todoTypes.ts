export type TodoStatus = "todo" | "doing" | "done";

export interface Todo {
    completed: number;
    id: number;
    created_at: string;
    description: string | null;
    title: string;
    updated_at: string;
    user_id: number;
    status: TodoStatus;
}
