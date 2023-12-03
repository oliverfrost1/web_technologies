export interface Todo {
    completed: number;
    id: number;
    created_at: string;
    description: string | null;
    title: string;
    updated_at: string;
    user_id: number;
    kanban_category: "todo" | "doing" | "done";
}
